<?php

namespace App\Http\Controllers\Admin;

use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $layanans = Layanan::paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $layanans = Layanan::where('judul', 'like', '%' . $filter . '%')->paginate(10);
        }
        return view('page_admin.layanan.index', compact('layanans', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan layanan');
            Log::info('Request data:', $request->all());

            $request->validate([
                'judul' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'deskripsi' => 'required',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $layanan = new Layanan();
            $layanan->judul = $request->judul;
            $layanan->deskripsi = $request->deskripsi;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('storage/layanan');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori storage/layanan');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $layanan->gambar = $gambarName;
            }

            Log::info('Mencoba menyimpan data layanan ke database');
            if (!$layanan->save()) {
                Log::error('Gagal menyimpan data layanan ke database');
                throw new \Exception('Gagal menyimpan data layanan');
            }

            Log::info('Layanan berhasil disimpan');
            return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error in LayananController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        return view('page_admin.layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        return view('page_admin.layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        try {
            $request->validate([
                'judul' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'deskripsi' => 'required',
            ]);

            $layanan->judul = $request->judul;
            $layanan->deskripsi = $request->deskripsi;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($layanan->gambar && file_exists(public_path('storage/layanan/' . $layanan->gambar))) {
                    unlink(public_path('storage/layanan/' . $layanan->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('storage/layanan');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $layanan->gambar = $gambarName;
            }

            $layanan->save();
            return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error in LayananController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        try {
            // Hapus gambar jika ada
            if ($layanan->gambar && file_exists(public_path('storage/layanan/' . $layanan->gambar))) {
                unlink(public_path('storage/layanan/' . $layanan->gambar));
            }

            $layanan->delete();
            return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in LayananController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
