<?php

namespace App\Http\Controllers\Admin;

use App\Models\KomentarArtikel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KomentarArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $komentar_artikels = KomentarArtikel::all();
        return view('page_admin.komentar-artikel.index', compact('komentar_artikels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.komentar-artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'komentar' => 'required',
            'nama_komentar' => 'required',
            'email_komentar' => 'required',
            'no_hp_komentar' => 'nullable',
        ]);
        
        $komentar_artikel = KomentarArtikel::create($request->all());
        return redirect()->route('admin.komentar-artikel.index')->with('success', 'Komentar Artikel berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KomentarArtikel $komentar_artikel)
    {
        return view('page_admin.komentar-artikel.show', compact('komentar_artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomentarArtikel $komentar_artikel)
    {
        return view('page_admin.komentar-artikel.edit', compact('komentar_artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KomentarArtikel $komentar_artikel)
    {
        $request->validate([
            'komentar' => 'required',
            'nama_komentar' => 'required',
            'email_komentar' => 'required',
            'no_hp_komentar' => 'nullable',
        ]);
        
        $komentar_artikel->update($request->all());
        return redirect()->route('admin.komentar-artikel.index')->with('success', 'Komentar Artikel berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KomentarArtikel $komentar_artikel)
    {
        $komentar_artikel->delete();
        return redirect()->route('admin.komentar-artikel.index')->with('success', 'Komentar Artikel berhasil dihapus');
    }
}
