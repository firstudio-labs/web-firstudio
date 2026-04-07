<?php

namespace App\Http\Controllers\Admin;

use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori_artikels = KategoriArtikel::latest()->get();
        return view('page_admin.kategori-artikel.index', compact('kategori_artikels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.kategori-artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_artikel' => 'required|string|max:255',
        ]);

        KategoriArtikel::create($request->all());

        return redirect()->route('admin.kategori-artikel.index')->with('success', 'Kategori Artikel berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriArtikel $kategori_artikel)
    {
        return view('page_admin.kategori-artikel.show', compact('kategori_artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriArtikel $kategori_artikel)
    {
        return view('page_admin.kategori-artikel.edit', compact('kategori_artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriArtikel $kategori_artikel)
    {
        $request->validate([
            'kategori_artikel' => 'required|string|max:255',
        ]);

        $kategori_artikel->update($request->all());

        return redirect()->route('admin.kategori-artikel.index')->with('success', 'Kategori Artikel berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriArtikel $kategori_artikel)
    {
        $kategori_artikel->delete();

        return redirect()->route('admin.kategori-artikel.index')->with('success', 'Kategori Artikel berhasil dihapus');
    }
}
