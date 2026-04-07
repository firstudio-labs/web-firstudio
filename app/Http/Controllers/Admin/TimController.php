<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tim;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tim = Tim::paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $tim = Tim::where('nama', 'like', '%' . $filter . '%')->paginate(10);
        }
        return view('page_admin.tim.index', compact('tim', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.tim.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan tim');
            Log::info('Request data:', $request->all());

            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'nama' => 'required',
                'posisi' => 'required',
                'instagram' => 'required',
                'linkedin' => 'required',
                'facebook' => 'required',
                'whatsapp' => 'required',
                'quote' => 'required',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $tim = new Tim();
            $tim->nama = $request->nama;
            $tim->posisi = $request->posisi;
            $tim->instagram = $request->instagram;
            $tim->linkedin = $request->linkedin;
            $tim->facebook = $request->facebook;
            $tim->whatsapp = $request->whatsapp;
            $tim->quote = $request->quote;

            if ($request->hasFile('gambar')) {
                $isWebpSupported = function_exists('imagewebp');
                $extension = $isWebpSupported ? 'webp' : 'jpg';
                $gambar = $request->file('gambar');
                $gambarName = time() . '.' . $extension;

                // Pastikan direktori ada
                $path = public_path('storage/tim');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori storage/tim');
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

                $tim->gambar = $gambarName;
            }

            Log::info('Mencoba menyimpan data tim ke database');
            if (!$tim->save()) {
                Log::error('Gagal menyimpan data tim ke database');
                throw new \Exception('Gagal menyimpan data tim');
            }

            Log::info('Tim berhasil disimpan');
            return redirect()->route('admin.tim.index')->with('success', 'Tim berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error in TimController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tim $tim)
    {
        return view('page_admin.tim.show', compact('tim'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tim $tim)
    {
        return view('page_admin.tim.edit', compact('tim'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tim $tim)
    {
        try {
            $request->validate([
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'nama' => 'required',
                'posisi' => 'required',
                'instagram' => 'required',
                'linkedin' => 'required',
                'facebook' => 'required',
                'whatsapp' => 'required',
                'quote' => 'required',
            ]);

            $tim->nama = $request->nama;
            $tim->posisi = $request->posisi;
            $tim->instagram = $request->instagram;
            $tim->linkedin = $request->linkedin;
            $tim->facebook = $request->facebook;
            $tim->whatsapp = $request->whatsapp;
            $tim->quote = $request->quote;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($tim->gambar && file_exists(public_path('storage/tim/' . $tim->gambar))) {
                    unlink(public_path('storage/tim/' . $tim->gambar));
                }

                $isWebpSupported = function_exists('imagewebp');
                $extension = $isWebpSupported ? 'webp' : 'jpg';
                $gambar = $request->file('gambar');
                $gambarName = time() . '.' . $extension;

                // Pastikan direktori ada
                $path = public_path('storage/tim');
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

                $tim->gambar = $gambarName;
            }

            $tim->save();
            return redirect()->route('admin.tim.index')->with('success', 'Tim berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error in TimController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tim $tim)
    {
        try {
            // Hapus gambar jika ada
            if ($tim->gambar && file_exists(public_path('storage/tim/' . $tim->gambar))) {
                unlink(public_path('storage/tim/' . $tim->gambar));
            }

            $tim->delete();
            return redirect()->route('admin.tim.index')->with('success', 'Tim berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in TimController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
