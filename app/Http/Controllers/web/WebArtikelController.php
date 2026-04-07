<?php

namespace App\Http\Controllers\web;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'all');
        $kategori_artikels = KategoriArtikel::all();
        
        $query = Artikel::with('kategoriArtikel')
            ->where('status', 'Publik');
        
        if ($kategori !== 'all') {
            $query->whereHas('kategoriArtikel', function($q) use ($kategori) {
                $q->where('slug', $kategori);
            });
        }
        
        $artikels = $query->latest()->paginate(12);
        
        return view('page_web.artikel.index', compact('artikels', 'kategori_artikels', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $artikel = Artikel::with('kategoriArtikel')
            ->where('slug', $slug)
            ->where('status', 'Publik')
            ->firstOrFail();
        
        // Get related articles (same category, exclude current article)
        $relatedArtikels = Artikel::with('kategoriArtikel')
            ->where('status', 'Publik')
            ->where('id', '!=', $artikel->id)
            ->when($artikel->kategori_artikel_id, function($query) use ($artikel) {
                return $query->where('kategori_artikel_id', $artikel->kategori_artikel_id);
            })
            ->latest()
            ->limit(3)
            ->get();
        
        // If not enough related articles, get latest articles
        if ($relatedArtikels->count() < 3) {
            $additionalArtikels = Artikel::with('kategoriArtikel')
                ->where('status', 'Publik')
                ->where('id', '!=', $artikel->id)
                ->whereNotIn('id', $relatedArtikels->pluck('id'))
                ->latest()
                ->limit(3 - $relatedArtikels->count())
                ->get();
            
            $relatedArtikels = $relatedArtikels->merge($additionalArtikels);
        }
        
        return view('page_web.artikel.show', compact('artikel', 'relatedArtikels'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artikel $artikel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        //
    }
}
