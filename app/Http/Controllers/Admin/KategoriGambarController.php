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
        $kategori_gambars = KategoriGambar::paginate(10);
        return view('page_admin.kategori-gambar.index', compact('kategori_gambars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.kategori-gambar.create');
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
    public function show(KategoriGambar $kategori_gambar)
    {
        return view('page_admin.kategori-gambar.show', compact('kategori_gambar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriGambar $kategori_gambar)
    {
        return view('page_admin.kategori-gambar.edit', compact('kategori_gambar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriGambar $kategori_gambar)
    {
        $request->validate([
            'kategori_gambar' => 'required|unique:kategori_gambar,kategori_gambar,' . $kategori_gambar->id,
            'deskripsi' => 'nullable',
        ]);

        $kategori_gambar->update($request->all());
        return redirect()->route('admin.kategori-gambar.index')->with('success', 'Kategori gambar berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriGambar $kategori_gambar)
    {
        $kategori_gambar->delete();
        return redirect()->route('admin.kategori-gambar.index')->with('success', 'Kategori gambar berhasil dihapus');
    }
}
