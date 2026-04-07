<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriTemplate;
use Illuminate\Http\Request;

class KategoriTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = KategoriTemplate::paginate(10);
        return view('page_admin.kategori_template.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.kategori_template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_templates,nama_kategori|max:255',
        ]);

        KategoriTemplate::create($request->all());

        return redirect()->route('admin.kategoriTemplate.index')->with('success', 'Kategori template berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriTemplate $kategoriTemplate)
    {
        return view('page_admin.kategori_template.edit', compact('kategoriTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriTemplate $kategoriTemplate)
    {
        $request->validate([
            'nama_kategori' => 'required|max:255|unique:kategori_templates,nama_kategori,' . $kategoriTemplate->id,
        ]);

        $kategoriTemplate->update($request->all());

        return redirect()->route('admin.kategoriTemplate.index')->with('success', 'Kategori template berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriTemplate $kategoriTemplate)
    {
        $kategoriTemplate->delete();
        return redirect()->route('admin.kategoriTemplate.index')->with('success', 'Kategori template berhasil dihapus.');
    }
}
