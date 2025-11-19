<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profils = Profil::latest()->get();
        $hasData = $profils->count() > 0;
        return view('page_admin.profil.index', compact('profils', 'hasData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cek apakah sudah ada data profil
        $existingProfil = Profil::count();
        if ($existingProfil > 0) {
            return redirect()->route('admin.profil.index')
                ->with('error', 'Data profil sudah ada. Hanya diizinkan memiliki 1 data profil saja. Silakan edit data yang sudah ada.');
        }
        
        return view('page_admin.profil.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Cek apakah sudah ada data profil sebelum validasi
            $existingProfil = Profil::count();
            if ($existingProfil > 0) {
                return redirect()->route('admin.profil.index')
                    ->with('error', 'Data profil sudah ada. Hanya diizinkan memiliki 1 data profil saja. Silakan edit data yang sudah ada.');
            }
            
            // Validasi tambahan: cek lagi jika ada data profil setelah user submit
            if (Profil::count() > 0) {
                throw new \Exception('Data profil sudah ada. Hanya diizinkan memiliki 1 data profil saja.');
            }
            
            $request->validate([
                'nama_perusahaan' => 'required',
                'no_telp_perusahaan' => 'required',
                'logo_perusahaan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'alamat_perusahaan' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'email_perusahaan' => 'required|email',
                'instagram_perusahaan' => 'nullable|string',
                'facebook_perusahaan' => 'nullable|string',
                'twitter_perusahaan' => 'nullable|string',
                'linkedin_perusahaan' => 'nullable|string',
            ]);

            $profil = new Profil();
            $profil->nama_perusahaan = $request->nama_perusahaan;
            $profil->no_telp_perusahaan = $request->no_telp_perusahaan;
            $profil->alamat_perusahaan = $request->alamat_perusahaan;
            $profil->latitude = $request->latitude;
            $profil->longitude = $request->longitude;
            $profil->email_perusahaan = $request->email_perusahaan;
            $profil->instagram_perusahaan = $request->instagram_perusahaan;
            $profil->facebook_perusahaan = $request->facebook_perusahaan;
            $profil->twitter_perusahaan = $request->twitter_perusahaan;
            $profil->linkedin_perusahaan = $request->linkedin_perusahaan;

            if ($request->hasFile('logo_perusahaan')) {
                $logo = $request->file('logo_perusahaan');
                $logoName = time() . '.webp';
                $path = public_path('storage/profil');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $manager = new ImageManager(new Driver());
                $image = $manager->read($logo);
                $image->toWebp(80);
                $image->save($path . '/' . $logoName);
                $profil->logo_perusahaan = $logoName;
            }

            $profil->save();
            return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Profil $profil)
    {
        return view('page_admin.profil.show', compact('profil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profil $profil)
    {
        return view('page_admin.profil.edit', compact('profil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profil $profil)
    {
        try {
            $request->validate([
                'nama_perusahaan' => 'required',
                'no_telp_perusahaan' => 'required',
                'logo_perusahaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'alamat_perusahaan' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'email_perusahaan' => 'required|email',
                'instagram_perusahaan' => 'nullable|string',
                'facebook_perusahaan' => 'nullable|string',
                'twitter_perusahaan' => 'nullable|string',
                'linkedin_perusahaan' => 'nullable|string',
            ]);

            $profil->nama_perusahaan = $request->nama_perusahaan;
            $profil->no_telp_perusahaan = $request->no_telp_perusahaan;
            $profil->alamat_perusahaan = $request->alamat_perusahaan;
            $profil->latitude = $request->latitude;
            $profil->longitude = $request->longitude;
            $profil->email_perusahaan = $request->email_perusahaan;
            $profil->instagram_perusahaan = $request->instagram_perusahaan;
            $profil->facebook_perusahaan = $request->facebook_perusahaan;
            $profil->twitter_perusahaan = $request->twitter_perusahaan;
            $profil->linkedin_perusahaan = $request->linkedin_perusahaan;

            if ($request->hasFile('logo_perusahaan')) {
                // Hapus logo lama jika ada
                if ($profil->logo_perusahaan && file_exists(public_path('storage/profil/' . $profil->logo_perusahaan))) {
                    unlink(public_path('storage/profil/' . $profil->logo_perusahaan));
                }
                $logo = $request->file('logo_perusahaan');
                $logoName = time() . '.webp';
                $path = public_path('storage/profil');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $manager = new ImageManager(new Driver());
                $image = $manager->read($logo);
                $image->toWebp(80);
                $image->save($path . '/' . $logoName);
                $profil->logo_perusahaan = $logoName;
            }

            $profil->save();
            return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil diubah');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profil $profil)
    {
        try {
            // Hapus gambar jika ada
            if ($profil->logo_perusahaan && file_exists(public_path('storage/profil/' . $profil->logo_perusahaan))) {
                unlink(public_path('storage/profil/' . $profil->logo_perusahaan));
            }

            $profil->delete();
            return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in ProfilController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
