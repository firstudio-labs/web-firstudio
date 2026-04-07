<?php

namespace App\Http\Controllers\Admin;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori_produks = KategoriProduk::paginate(10);
        return view('page_admin.kategori-produk.index', compact('kategori_produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.kategori-produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_produk' => 'required|unique:kategori_produk',
            'deskripsi' => 'nullable',
        ]);

        KategoriProduk::create($request->all());
        return redirect()->route('admin.kategori-produk.index')->with('success', 'Kategori produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriProduk $kategori_produk)
    {
        return view('page_admin.kategori-produk.show', compact('kategori_produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriProduk $kategori_produk)
    {
        return view('page_admin.kategori-produk.edit', compact('kategori_produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriProduk $kategori_produk)
    {
        $request->validate([
            'kategori_produk' => 'required|unique:kategori_produk,kategori_produk,' . $kategori_produk->id,
            'deskripsi' => 'nullable',
        ]);

        $kategori_produk->update($request->all());
        return redirect()->route('admin.kategori-produk.index')->with('success', 'Kategori produk berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriProduk $kategori_produk)
    {
        $kategori_produk->delete();
        return redirect()->route('admin.kategori-produk.index')->with('success', 'Kategori produk berhasil dihapus');
    }
}
