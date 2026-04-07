<?php

namespace App\Http\Controllers\Admin;

use App\Models\Beranda;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BerandaController extends Controller
{
    
    public function index()
    {
        $berandas = Beranda::all();
        return view('page_admin.beranda.index', compact('berandas'));
    }

   
    public function create()
    {
        return view('page_admin.beranda.create');
    }

    
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan beranda');
            Log::info('Request data:', $request->all());

            $request->validate([
                'judul_utama' => 'required',
                'gambar_utama' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'slogan' => 'required',
                'gambar_sekunder' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'judul_sekunder' => 'required',
                'keterangan' => 'required',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $beranda = new Beranda();
            $beranda->judul_utama = $request->judul_utama;
            $beranda->slogan = $request->slogan;
            $beranda->judul_sekunder = $request->judul_sekunder;
            $beranda->keterangan = $request->keterangan;

            // Proses gambar utama
            if ($request->hasFile('gambar_utama')) {
                $isWebpSupported = function_exists('imagewebp');
                $extension = $isWebpSupported ? 'webp' : 'jpg';
                $gambar_utama = $request->file('gambar_utama');
                $gambar_utama_name = time() . '_utama.' . $extension;

                // Pastikan direktori ada
                $path = public_path('storage/beranda');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori storage/beranda');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar utama');
                // Konversi gambar
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar_utama);
                
                if ($isWebpSupported) {
                    $image->toWebp(80);
                } else {
                    $image->toJpeg(80);
                }
                
                $image->save($path . '/' . $gambar_utama_name);

                $beranda->gambar_utama = $gambar_utama_name;
            }

            // Proses gambar sekunder
            if ($request->hasFile('gambar_sekunder')) {
                $isWebpSupported = function_exists('imagewebp');
                $extension = $isWebpSupported ? 'webp' : 'jpg';
                $gambar_sekunder = $request->file('gambar_sekunder');
                $gambar_sekunder_name = time() . '_sekunder.' . $extension;

                // Pastikan direktori ada
                $path = public_path('storage/beranda');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori storage/beranda');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar sekunder');
                // Konversi gambar
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar_sekunder);
                
                if ($isWebpSupported) {
                    $image->toWebp(80);
                } else {
                    $image->toJpeg(80);
                }
                
                $image->save($path . '/' . $gambar_sekunder_name);

                $beranda->gambar_sekunder = $gambar_sekunder_name;
            }

            Log::info('Mencoba menyimpan data beranda ke database');
            if (!$beranda->save()) {
                Log::error('Gagal menyimpan data beranda ke database');
                throw new \Exception('Gagal menyimpan data beranda');
            }

            Log::info('Beranda berhasil disimpan');
            return redirect()->route('admin.beranda.index')->with('success', 'Beranda berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error in BerandaController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    
    public function show(Beranda $beranda)
    {
        return view('page_admin.beranda.show', compact('beranda'));
    }

    
    public function edit(Beranda $beranda)
    {
        return view('page_admin.beranda.edit', compact('beranda'));
    }

   
    public function update(Request $request, Beranda $beranda)
    {
        $request->validate([
            'judul_utama' => 'required',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'slogan' => 'required',
            'gambar_sekunder' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul_sekunder' => 'required',
            'keterangan' => 'required',
        ]);

        try {
            $beranda->judul_utama = $request->judul_utama;
            $beranda->slogan = $request->slogan;
            $beranda->judul_sekunder = $request->judul_sekunder;
            $beranda->keterangan = $request->keterangan;

            // Proses gambar utama
            if ($request->hasFile('gambar_utama')) {
                // Hapus gambar lama jika ada
                if ($beranda->gambar_utama && file_exists(public_path('storage/beranda/' . $beranda->gambar_utama))) {
                    unlink(public_path('storage/beranda/' . $beranda->gambar_utama));
                }

                $isWebpSupported = function_exists('imagewebp');
                $extension = $isWebpSupported ? 'webp' : 'jpg';
                $gambar_utama = $request->file('gambar_utama');
                $gambar_utama_name = time() . '_utama.' . $extension;

                // Pastikan direktori ada
                $path = public_path('storage/beranda');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi gambar
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar_utama);
                
                if ($isWebpSupported) {
                    $image->toWebp(80);
                } else {
                    $image->toJpeg(80);
                }
                
                $image->save($path . '/' . $gambar_utama_name);

                $beranda->gambar_utama = $gambar_utama_name;
            }

            // Proses gambar sekunder
            if ($request->hasFile('gambar_sekunder')) {
                // Hapus gambar lama jika ada
                if ($beranda->gambar_sekunder && file_exists(public_path('storage/beranda/' . $beranda->gambar_sekunder))) {
                    unlink(public_path('storage/beranda/' . $beranda->gambar_sekunder));
                }

                $isWebpSupported = function_exists('imagewebp');
                $extension = $isWebpSupported ? 'webp' : 'jpg';
                $gambar_sekunder = $request->file('gambar_sekunder');
                $gambar_sekunder_name = time() . '_sekunder.' . $extension;

                // Pastikan direktori ada
                $path = public_path('storage/beranda');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi gambar
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar_sekunder);
                
                if ($isWebpSupported) {
                    $image->toWebp(80);
                } else {
                    $image->toJpeg(80);
                }
                
                $image->save($path . '/' . $gambar_sekunder_name);

                $beranda->gambar_sekunder = $gambar_sekunder_name;
            }

            $beranda->save();
            return redirect()->route('admin.beranda.index')->with('success', 'Beranda berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error in BerandaController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy(Beranda $beranda)
    {
        try {
            // Hapus file gambar
            if ($beranda->gambar_utama && file_exists(public_path('storage/beranda/' . $beranda->gambar_utama))) {
                unlink(public_path('storage/beranda/' . $beranda->gambar_utama));
            }
            if ($beranda->gambar_sekunder && file_exists(public_path('storage/beranda/' . $beranda->gambar_sekunder))) {
                unlink(public_path('storage/beranda/' . $beranda->gambar_sekunder));
            }

            $beranda->delete();
            return redirect()->route('admin.beranda.index')->with('success', 'Beranda berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in BerandaController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
