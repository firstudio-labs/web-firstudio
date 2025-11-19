<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tentang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TentangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tentang = Tentang::all();
        $hasData = $tentang->count() > 0;
        return view('page_admin.tentang.index', compact('tentang', 'hasData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cek apakah sudah ada data tentang
        $existingTentang = Tentang::count();
        if ($existingTentang > 0) {
            return redirect()->route('admin.tentang.index')
                ->with('error', 'Data tentang sudah ada. Hanya diizinkan memiliki 1 data tentang saja. Silakan edit data yang sudah ada.');
        }
        
        return view('page_admin.tentang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Cek apakah sudah ada data tentang sebelum validasi
            $existingTentang = Tentang::count();
            if ($existingTentang > 0) {
                return redirect()->route('admin.tentang.index')
                    ->with('error', 'Data tentang sudah ada. Hanya diizinkan memiliki 1 data tentang saja. Silakan edit data yang sudah ada.');
            }
            
            Log::info('Memulai proses penyimpanan tentang');
            Log::info('Request data:', $request->all());

            // Validasi tambahan: cek lagi jika ada data tentang setelah user submit
            if (Tentang::count() > 0) {
                throw new \Exception('Data tentang sudah ada. Hanya diizinkan memiliki 1 data tentang saja.');
            }
            
            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'judul' => 'required',
                'deskripsi' => 'required',
                'hitungan' => 'nullable|array|min:1',
                'hitungan.*' => 'nullable|numeric',
                'keterangan_hitungan' => 'nullable|array|min:1',
                'keterangan_hitungan.*' => 'nullable|string',
                'keterangan_memilih' => 'nullable',
                'gambar_nilai' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'keterangan_nilai' => 'nullable',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $tentang = new Tentang();
            $tentang->judul = $request->judul;
            $tentang->deskripsi = $request->deskripsi;
            $tentang->hitungan = $request->hitungan;
            $tentang->keterangan_hitungan = $request->keterangan_hitungan;
            $tentang->keterangan_memilih = $request->keterangan_memilih;
            $tentang->keterangan_nilai = $request->keterangan_nilai;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '_gambar.webp';

                // Pastikan direktori ada
                $path = public_path('storage/tentang');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori storage/tentang');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $tentang->gambar = $gambarName;
            }

            if ($request->hasFile('gambar_nilai')) {
                $gambarNilai = $request->file('gambar_nilai');
                $gambarNilaiName = time() . '_nilai.webp';

                // Pastikan direktori ada
                $path = public_path('storage/tentang');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori storage/tentang');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar nilai ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambarNilai);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarNilaiName);

                $tentang->gambar_nilai = $gambarNilaiName;
            }

            Log::info('Mencoba menyimpan data tentang ke database');
            if (!$tentang->save()) {
                Log::error('Gagal menyimpan data tentang ke database');
                throw new \Exception('Gagal menyimpan data tentang');
            }

            Log::info('Tentang berhasil disimpan');
            return redirect()->route('admin.tentang.index')->with('success', 'Tentang berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error in TentangController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tentang $tentang)
    {
        return view('page_admin.tentang.show', compact('tentang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tentang $tentang)
    {
        return view('page_admin.tentang.edit', compact('tentang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tentang $tentang)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required',
            'deskripsi' => 'required',
            'hitungan' => 'nullable|array|min:1',
            'hitungan.*' => 'nullable|numeric',
            'keterangan_hitungan' => 'nullable|array|min:1',
            'keterangan_hitungan.*' => 'nullable|string',
            'keterangan_memilih' => 'nullable',
            'gambar_nilai' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan_nilai' => 'nullable',
        ]);

        try {
            $tentang->judul = $request->judul;
            $tentang->deskripsi = $request->deskripsi;
            $tentang->hitungan = $request->hitungan;
            $tentang->keterangan_hitungan = $request->keterangan_hitungan;
            $tentang->keterangan_memilih = $request->keterangan_memilih;
            $tentang->keterangan_nilai = $request->keterangan_nilai;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($tentang->gambar && file_exists(public_path('storage/tentang/' . $tentang->gambar))) {
                    unlink(public_path('storage/tentang/' . $tentang->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '_gambar.webp';

                // Pastikan direktori ada
                $path = public_path('storage/tentang');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $tentang->gambar = $gambarName;
            }

            if ($request->hasFile('gambar_nilai')) {
                // Hapus gambar nilai lama jika ada
                if ($tentang->gambar_nilai && file_exists(public_path('storage/tentang/' . $tentang->gambar_nilai))) {
                    unlink(public_path('storage/tentang/' . $tentang->gambar_nilai));
                }

                $gambarNilai = $request->file('gambar_nilai');
                $gambarNilaiName = time() . '_nilai.webp';

                // Pastikan direktori ada
                $path = public_path('storage/tentang');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambarNilai);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarNilaiName);

                $tentang->gambar_nilai = $gambarNilaiName;
            }

            $tentang->save();
            return redirect()->route('admin.tentang.index')->with('success', 'Tentang berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error in TentangController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tentang $tentang)
    {
        try {
            // Hapus gambar jika ada
            if ($tentang->gambar && file_exists(public_path('storage/tentang/' . $tentang->gambar))) {
                unlink(public_path('storage/tentang/' . $tentang->gambar));
            }

            // Hapus gambar nilai jika ada
            if ($tentang->gambar_nilai && file_exists(public_path('storage/tentang/' . $tentang->gambar_nilai))) {
                unlink(public_path('storage/tentang/' . $tentang->gambar_nilai));
            }

            $tentang->delete();
            return redirect()->route('admin.tentang.index')->with('success', 'Tentang berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in TentangController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
