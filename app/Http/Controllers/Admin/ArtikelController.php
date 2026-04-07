<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artikel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriArtikel;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Services\GeminiAIService;
use App\Services\AIServiceFactory;
use App\Services\TokenUsageService;
use App\Http\Requests\GenerateArtikelRequest;
use App\Http\Requests\GenerateTitlesRequest;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $artikels = Artikel::paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $artikels = Artikel::where('judul', 'like', '%' . $filter . '%')->paginate(10);
        }
        $aiRemainingTokens = 0;
        $aiDailyLimit = TokenUsageService::DEFAULT_DAILY_LIMIT;
        if (auth()->check()) {
            $tokenService = new TokenUsageService();
            $aiRemainingTokens = $tokenService->getRemainingTokens(auth()->id());
            $aiDailyLimit = $tokenService->getTodayUsage(auth()->id())->daily_limit;
        }
        return view('page_admin.artikel.index', compact('artikels', 'filter', 'aiRemainingTokens', 'aiDailyLimit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori_artikels = KategoriArtikel::all();
        $aiRemainingTokens = 0;
        $aiDailyLimit = TokenUsageService::DEFAULT_DAILY_LIMIT;
        if (auth()->check()) {
            $tokenService = new TokenUsageService();
            $aiRemainingTokens = $tokenService->getRemainingTokens(auth()->id());
            $aiDailyLimit = $tokenService->getTodayUsage(auth()->id())->daily_limit;
        }
        return view('page_admin.artikel.create', compact('kategori_artikels', 'aiRemainingTokens', 'aiDailyLimit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan artikel');
            Log::info('Request data:', $request->all());

            $request->validate([
                'judul' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'penulis' => 'required',
                'kategori_artikel_id' => 'required|exists:kategori_artikels,id',
                'isi' => 'required',
                'catatan' => 'nullable',
                'status' => 'required',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $artikel = new Artikel();
            $artikel->judul = $request->judul;
            $artikel->penulis = $request->penulis;
            $artikel->kategori_artikel_id = $request->kategori_artikel_id;
            $artikel->isi = $request->isi;
            $artikel->catatan = $request->catatan;
            $artikel->status = $request->status;

            if ($request->hasFile('gambar')) {
                $isWebpSupported = function_exists('imagewebp');
                $extension = $isWebpSupported ? 'webp' : 'jpg';
                $gambar = $request->file('gambar');
                $gambarName = time() . '.' . $extension;

                // Pastikan direktori ada
                $path = public_path('storage/artikel');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori storage/artikel');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar');
                // Konversi gambar
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                
                if ($isWebpSupported) {
                    $image->toWebp(80);
                } else {
                    $image->toJpeg(80);
                }
                
                $image->save($path . '/' . $gambarName);

                $artikel->gambar = $gambarName;
            }

            Log::info('Mencoba menyimpan data artikel ke database');
            if (!$artikel->save()) {
                Log::error('Gagal menyimpan data artikel ke database');
                throw new \Exception('Gagal menyimpan data artikel');
            }

            Log::info('Artikel berhasil disimpan');
            return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error in ArtikelController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        return view('page_admin.artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        $kategori_artikels = KategoriArtikel::all();
        $aiRemainingTokens = 0;
        $aiDailyLimit = TokenUsageService::DEFAULT_DAILY_LIMIT;
        if (auth()->check()) {
            $tokenService = new TokenUsageService();
            $aiRemainingTokens = $tokenService->getRemainingTokens(auth()->id());
            $aiDailyLimit = $tokenService->getTodayUsage(auth()->id())->daily_limit;
        }
        return view('page_admin.artikel.edit', compact('artikel', 'kategori_artikels', 'aiRemainingTokens', 'aiDailyLimit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'penulis' => 'required',
            'kategori_artikel_id' => 'required',
            'isi' => 'required',
            'catatan' => 'nullable',
            'status' => 'required',
        ]);

        try {
            $artikel->judul = $request->judul;
            $artikel->penulis = $request->penulis;
            $artikel->kategori_artikel_id = $request->kategori_artikel_id;
            $artikel->isi = $request->isi;
            $artikel->catatan = $request->catatan;
            $artikel->status = $request->status;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($artikel->gambar && file_exists(public_path('storage/artikel/' . $artikel->gambar))) {
                    unlink(public_path('storage/artikel/' . $artikel->gambar));
                }

                $isWebpSupported = function_exists('imagewebp');
                $extension = $isWebpSupported ? 'webp' : 'jpg';
                $gambar = $request->file('gambar');
                $gambarName = time() . '.' . $extension;

                // Pastikan direktori ada
                $path = public_path('storage/artikel');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi gambar
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                
                if ($isWebpSupported) {
                    $image->toWebp(80);
                } else {
                    $image->toJpeg(80);
                }
                
                $image->save($path . '/' . $gambarName);

                $artikel->gambar = $gambarName;
            }

            $artikel->save();
            return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error in ArtikelController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        $artikel->delete();
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }

    /**
     * Generate artikel menggunakan AI
     */
    public function generateAI(GenerateArtikelRequest $request)
    {
        try {
            // Daily token check
            $tokenService = new TokenUsageService();
            if (!$tokenService->canUse(auth()->id())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Batas AI token harian Anda sudah habis. Coba lagi besok.'
                ], 429);
            }

            // Rate limiting check (simple implementation)
            $cacheKey = 'ai_generate_' . auth()->id();
            $lastRequest = cache($cacheKey);
            
            if ($lastRequest && now()->diffInSeconds($lastRequest) < 30) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan tunggu 30 detik sebelum generate konten lagi.'
                ], 429);
            }

            cache([$cacheKey => now()], 60); // Cache for 1 minute

            $aiFactory = new AIServiceFactory();

            $kategori = null;
            if ($request->kategori_artikel_id) {
                $kategoriModel = KategoriArtikel::find($request->kategori_artikel_id);
                $kategori = $kategoriModel ? $kategoriModel->kategori_artikel : null;
            }

            $minWords = $request->min_words ?? 500;

            $result = $aiFactory->generateArtikel(
                $request->judul,
                $kategori,
                $minWords,
                $request->custom_prompt
            );

            if ($result['success']) {
                // Deduct token (1 per call)
                $tokenService->increment(auth()->id(), 'generate_content', 1, [
                    'judul' => $request->judul,
                    'kategori' => $kategori,
                    'min_words' => $minWords,
                ]);

                return response()->json([
                    'success' => true,
                    'content' => $result['content'],
                    'word_count' => $result['word_count'],
                    'message' => 'Artikel berhasil di-generate!',
                    'remaining_tokens' => $tokenService->getRemainingTokens(auth()->id())
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal generate artikel'
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error generating article with AI: ' . $e->getMessage());
            
            // Get user-friendly error message
            $userMessage = $this->getUserFriendlyErrorMessage($e->getMessage());
            $httpCode = $this->getHttpCodeFromError($e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $userMessage
            ], $httpCode);
        }
    }

    /**
     * Generate judul artikel menggunakan AI
     */
    public function generateTitles(GenerateTitlesRequest $request)
    {
        try {
            // Daily token check
            $tokenService = new TokenUsageService();
            if (!$tokenService->canUse(auth()->id())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Batas AI token harian Anda sudah habis. Coba lagi besok.'
                ], 429);
            }

            // Rate limiting check untuk titles
            $cacheKey = 'ai_titles_' . auth()->id();
            $lastRequest = cache($cacheKey);
            
            if ($lastRequest && now()->diffInSeconds($lastRequest) < 20) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan tunggu 20 detik sebelum generate judul lagi.'
                ], 429);
            }

            cache([$cacheKey => now()], 60); // Cache for 1 minute

            $aiFactory = new AIServiceFactory();

            $kategori = null;
            if ($request->kategori_artikel_id) {
                $kategoriModel = KategoriArtikel::find($request->kategori_artikel_id);
                $kategori = $kategoriModel ? $kategoriModel->kategori_artikel : null;
            }

            $result = $aiFactory->generateJudul($request->topik, $kategori);

            if ($result['success']) {
                // Deduct token
                $tokenService->increment(auth()->id(), 'generate_titles', 1, [
                    'topik' => $request->topik,
                    'kategori' => $kategori,
                ]);
                return response()->json([
                    'success' => true,
                    'titles' => $result['titles'],
                    'message' => 'Judul berhasil di-generate!',
                    'remaining_tokens' => $tokenService->getRemainingTokens(auth()->id())
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal generate judul: ' . $result['error']
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error generating titles with AI: ' . $e->getMessage());
            
            $userMessage = $this->getUserFriendlyErrorMessage($e->getMessage());
            $httpCode = $this->getHttpCodeFromError($e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $userMessage
            ], $httpCode);
        }
    }

    /**
     * Enhance existing content menggunakan AI
     */
    public function enhanceContent(Request $request)
    {
        try {
            $request->validate([
                'content' => 'required|string',
                'enhance_type' => 'required|string|in:improve,expand,seo,restructure',
                'judul' => 'nullable|string|max:255'
            ]);

            // Daily token check
            $tokenService = new TokenUsageService();
            if (!$tokenService->canUse(auth()->id())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Batas AI token harian Anda sudah habis. Coba lagi besok.'
                ], 429);
            }

            // Rate limiting check untuk enhance
            $cacheKey = 'ai_enhance_' . auth()->id();
            $lastRequest = cache($cacheKey);
            
            if ($lastRequest && now()->diffInSeconds($lastRequest) < 25) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan tunggu 25 detik sebelum enhance konten lagi.'
                ], 429);
            }

            cache([$cacheKey => now()], 60); // Cache for 1 minute

            $aiFactory = new AIServiceFactory();

            // Strip tags dari content yang akan dienh ance (kecuali HTML tags yang diperlukan)
            $content = strip_tags($request->input('content'), '<p><h1><h2><h3><h4><strong><em><ul><ol><li><br><a>');

            $result = $aiFactory->enhanceContent(
                $content,
                $request->enhance_type,
                $request->judul
            );

            if ($result['success']) {
                // Deduct token
                $tokenService->increment(auth()->id(), 'enhance_content', 1, [
                    'enhance_type' => $request->enhance_type,
                    'judul' => $request->judul,
                ]);
                return response()->json([
                    'success' => true,
                    'content' => $result['content'],
                    'word_count' => $result['word_count'],
                    'enhancement_type' => $result['enhancement_type'],
                    'message' => 'Konten berhasil di-enhance!',
                    'remaining_tokens' => $tokenService->getRemainingTokens(auth()->id())
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal enhance konten'
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error enhancing content with AI: ' . $e->getMessage());
            
            $userMessage = $this->getUserFriendlyErrorMessage($e->getMessage());
            $httpCode = $this->getHttpCodeFromError($e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $userMessage
            ], $httpCode);
        }
    }

    /**
     * Get user-friendly error message untuk ditampilkan ke user
     * 
     * @param string $errorMessage
     * @return string
     */
    private function getUserFriendlyErrorMessage($errorMessage)
    {
        $lowerMessage = strtolower($errorMessage);
        
        if (strpos($lowerMessage, 'overload') !== false || strpos($lowerMessage, 'busy') !== false) {
            return '🤖 Gemini AI sedang sibuk melayani banyak permintaan. Sistem akan otomatis mencoba ulang, mohon tunggu sebentar...';
        }
        
        if (strpos($lowerMessage, 'quota') !== false) {
            return '📊 Quota API Gemini sudah tercapai. Silakan coba lagi dalam beberapa jam atau hubungi administrator.';
        }
        
        if (strpos($lowerMessage, 'rate limit') !== false || strpos($lowerMessage, 'too many requests') !== false) {
            return '⏱️ Terlalu banyak permintaan dalam waktu singkat. Silakan tunggu beberapa detik dan coba lagi.';
        }
        
        if (strpos($lowerMessage, 'api key') !== false || strpos($lowerMessage, 'unauthorized') !== false) {
            return '🔑 API key tidak valid. Hubungi administrator untuk memperbaiki konfigurasi.';
        }
        
        if (strpos($lowerMessage, 'timeout') !== false) {
            return '⏰ Request timeout. Coba lagi atau pilih artikel yang lebih pendek.';
        }
        
        if (strpos($lowerMessage, 'network') !== false || strpos($lowerMessage, 'connection') !== false) {
            return '🌐 Masalah koneksi internet. Periksa koneksi Anda dan coba lagi.';
        }
        
        // Default fallback message
        return '❌ Terjadi kesalahan pada layanan AI. Silakan coba lagi dalam beberapa menit.';
    }

    /**
     * Get appropriate HTTP status code berdasarkan error message
     * 
     * @param string $errorMessage
     * @return int
     */
    private function getHttpCodeFromError($errorMessage)
    {
        $lowerMessage = strtolower($errorMessage);
        
        if (strpos($lowerMessage, 'overload') !== false || 
            strpos($lowerMessage, 'busy') !== false ||
            strpos($lowerMessage, 'rate limit') !== false) {
            return 503; // Service Unavailable
        }
        
        if (strpos($lowerMessage, 'quota') !== false) {
            return 429; // Too Many Requests
        }
        
        if (strpos($lowerMessage, 'api key') !== false || 
            strpos($lowerMessage, 'unauthorized') !== false) {
            return 401; // Unauthorized
        }
        
        if (strpos($lowerMessage, 'timeout') !== false) {
            return 408; // Request Timeout
        }
        
        return 500; // Internal Server Error (default)
    }
}
