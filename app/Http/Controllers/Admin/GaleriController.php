<?php

namespace App\Http\Controllers\Admin;

use App\Models\Galeri;
use App\Models\KategoriGambar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $galeris = Galeri::with('kategoriGambar')->paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $galeris = Galeri::whereHas('kategoriGambar', function ($query) use ($filter) {
                $query->where('kategori_gambar', 'like', '%' . $filter . '%');
            })->paginate(10);
        }
        return view('page_admin.galeri.index', compact('galeris', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriGambars = KategoriGambar::all();
        return view('page_admin.galeri.create', compact('kategoriGambars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan galeri');
            Log::info('Request data:', $request->all());

            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'keterangan' => 'required',
                'kategori_gambar_id' => 'required|exists:kategori_gambar,id',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('storage/galeri');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori storage/galeri');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $galeri = new Galeri();
                $galeri->gambar = $gambarName;
                $galeri->keterangan = $request->keterangan;
                $galeri->kategori_gambar_id = $request->kategori_gambar_id;

                Log::info('Mencoba menyimpan data galeri ke database');
                if (!$galeri->save()) {
                    Log::error('Gagal menyimpan data galeri ke database');
                    throw new \Exception('Gagal menyimpan data galeri');
                }

                Log::info('Galeri berhasil disimpan');
                return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan');
            } else {
                throw new \Exception('File gambar tidak ditemukan');
            }

        } catch (\Exception $e) {
            Log::error('Error in GaleriController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        return view('page_admin.galeri.show', compact('galeri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        $kategoriGambars = KategoriGambar::all();
        return view('page_admin.galeri.edit', compact('galeri', 'kategoriGambars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        try {
            $request->validate([
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'keterangan' => 'required',
                'kategori_gambar_id' => 'required|exists:kategori_gambar,id',
            ]);

            $galeri->keterangan = $request->keterangan;
            $galeri->kategori_gambar_id = $request->kategori_gambar_id;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($galeri->gambar && file_exists(public_path('storage/galeri/' . $galeri->gambar))) {
                    unlink(public_path('storage/galeri/' . $galeri->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('storage/galeri');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $galeri->gambar = $gambarName;
            }

            $galeri->save();
            return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error in GaleriController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        try {
            if ($galeri->gambar && file_exists(public_path('storage/galeri/' . $galeri->gambar))) {
                unlink(public_path('storage/galeri/' . $galeri->gambar));
            }
            $galeri->delete();
            return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in GaleriController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
