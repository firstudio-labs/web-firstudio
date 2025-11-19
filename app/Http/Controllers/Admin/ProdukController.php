<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Services\AIServiceFactory;
use App\Services\TokenUsageService;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produks = Produk::paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $produks = Produk::where('judul', 'like', '%' . $filter . '%')->paginate(10);
        }
        
        // Get AI token information
        $tokenService = new TokenUsageService();
        $aiDailyLimit = $tokenService->getDailyLimit(auth()->id());
        $aiRemainingTokens = $tokenService->getRemainingTokens(auth()->id());
        
        return view('page_admin.produk.index', compact('produks', 'filter', 'aiDailyLimit', 'aiRemainingTokens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriProduks = KategoriProduk::all();
        
        // Get AI token information
        $tokenService = new TokenUsageService();
        $aiDailyLimit = $tokenService->getDailyLimit(auth()->id());
        $aiRemainingTokens = $tokenService->getRemainingTokens(auth()->id());
        
        return view('page_admin.produk.create', compact('kategoriProduks', 'aiDailyLimit', 'aiRemainingTokens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan produk');
            Log::info('Request data:', $request->all());

            $request->validate([
                'judul' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'master_kategori_produk_id' => 'required|exists:kategori_produk,id',
                'deskripsi' => 'required',
                'link' => 'nullable|url',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $produk = new Produk();
            $produk->judul = $request->judul;
            $produk->master_kategori_produk_id = $request->master_kategori_produk_id;
            $produk->deskripsi = $request->deskripsi;
            $produk->link = $request->filled('link') ? $request->link : null;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('storage/produk');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori storage/produk');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $produk->gambar = $gambarName;
            }

            Log::info('Mencoba menyimpan data produk ke database');
            if (!$produk->save()) {
                Log::error('Gagal menyimpan data produk ke database');
                throw new \Exception('Gagal menyimpan data produk');
            }

            Log::info('Produk berhasil disimpan');
            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error in ProdukController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        return view('page_admin.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $kategoriProduks = KategoriProduk::all();
        
        // Get AI token information
        $tokenService = new TokenUsageService();
        $aiDailyLimit = $tokenService->getDailyLimit(auth()->id());
        $aiRemainingTokens = $tokenService->getRemainingTokens(auth()->id());
        
        return view('page_admin.produk.edit', compact('produk', 'kategoriProduks', 'aiDailyLimit', 'aiRemainingTokens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
            'master_kategori_produk_id' => 'required|exists:kategori_produk,id',
            'deskripsi' => 'required',
            'link' => 'nullable|url',
        ]);

        try {
            $produk->judul = $request->judul;
            $produk->master_kategori_produk_id = $request->master_kategori_produk_id;
            $produk->deskripsi = $request->deskripsi;
            $produk->link = $request->filled('link') ? $request->link : null;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($produk->gambar && file_exists(public_path('storage/produk/' . $produk->gambar))) {
                    unlink(public_path('storage/produk/' . $produk->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('storage/produk');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $produk->gambar = $gambarName;
            }

            $produk->save();
            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error in ProdukController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        try {
            // Hapus gambar jika ada
            if ($produk->gambar && file_exists(public_path('storage/produk/' . $produk->gambar))) {
                unlink(public_path('storage/produk/' . $produk->gambar));
            }

            $produk->delete();
            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in ProdukController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Generate deskripsi produk menggunakan AI
     */
    public function generateDeskripsi(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'judul' => 'required|string|max:255',
                'kategori_produk_id' => 'nullable|exists:kategori_produk,id',
                'custom_prompt' => 'nullable|string|max:1000'
            ]);

            // Daily token check
            $tokenService = new TokenUsageService();
            if (!$tokenService->canUse(auth()->id())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Batas AI token harian Anda sudah habis. Coba lagi besok.'
                ], 429);
            }

            // Rate limiting check
            $cacheKey = 'ai_produk_deskripsi_' . auth()->id();
            $lastRequest = cache($cacheKey);
            
            if ($lastRequest && now()->diffInSeconds($lastRequest) < 10) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan tunggu 10 detik sebelum generate deskripsi lagi.'
                ], 429);
            }

            cache([$cacheKey => now()], 60); // Cache for 1 minute

            $aiFactory = new AIServiceFactory();

            // Get kategori produk
            $kategori = null;
            if ($request->kategori_produk_id) {
                $kategoriModel = KategoriProduk::find($request->kategori_produk_id);
                $kategori = $kategoriModel ? $kategoriModel->kategori_produk : null;
            }

            // Set timeout untuk request AI
            set_time_limit(120); // 2 menit timeout
            
            $result = $aiFactory->generateDeskripsiProduk(
                $request->judul,
                $kategori,
                $request->custom_prompt
            );

            if ($result['success']) {
                // Deduct token (1 per call)
                $tokenService->increment(auth()->id(), 'generate_produk_deskripsi', 1, [
                    'judul' => $request->judul,
                    'kategori' => $kategori,
                ]);

                // Compress descriptions to reduce response size
                $descriptions = $result['descriptions'] ?? [$result['deskripsi'] ?? ''];
                $compressedDescriptions = array_map(function($desc) {
                    // Remove extra whitespace and compress HTML
                    $desc = preg_replace('/\s+/', ' ', $desc);
                    $desc = preg_replace('/>\s+</', '><', $desc);
                    
                    // Remove unnecessary HTML tags and attributes
                    $desc = preg_replace('/<p>\s*<\/p>/', '', $desc);
                    $desc = preg_replace('/<br\s*\/?>/', ' ', $desc);
                    $desc = preg_replace('/\s+/', ' ', $desc);
                    
                    // Limit description length to prevent large responses
                    if (strlen($desc) > 2000) {
                        $desc = substr($desc, 0, 2000) . '...';
                    }
                    
                    return trim($desc);
                }, $descriptions);

                   return response()->json([
                       'success' => true,
                       'descriptions' => $compressedDescriptions,
                       'message' => 'Deskripsi produk berhasil di-generate!',
                       'remaining_tokens' => $tokenService->getRemainingTokens(auth()->id())
                   ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal generate deskripsi produk'
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error generating product description with AI: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat generate deskripsi: ' . $e->getMessage()
            ], 500);
        }
    }
}
