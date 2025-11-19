<?php

namespace App\Http\Controllers\Admin;

use App\Models\KategoriGambar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriGambarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriGambars = KategoriGambar::paginate(10);
        return view('page_admin.kategoriGambar.index', compact('kategoriGambars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.kategoriGambar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_gambar' => 'required|unique:kategori_gambar',
            'deskripsi' => 'nullable',
        ]);

        KategoriGambar::create($request->all());
        return redirect()->route('admin.kategori-gambar.index')->with('success', 'Kategori gambar berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriGambar $kategoriGambar)
    {
        return view('page_admin.kategoriGambar.show', compact('kategoriGambar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriGambar $kategoriGambar)
    {
        return view('page_admin.kategoriGambar.edit', compact('kategoriGambar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriGambar $kategoriGambar)
    {
        $request->validate([
            'kategori_gambar' => 'required|unique:kategori_gambar,kategori_gambar,' . $kategoriGambar->id,
            'deskripsi' => 'nullable',
        ]);

        $kategoriGambar->update($request->all());
        return redirect()->route('admin.kategori-gambar.index')->with('success', 'Kategori gambar berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriGambar $kategoriGambar)
    {
        $kategoriGambar->delete();
        return redirect()->route('admin.kategori-gambar.index')->with('success', 'Kategori gambar berhasil dihapus');
    }
}
