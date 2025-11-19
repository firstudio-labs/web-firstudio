<?php

namespace App\Http\Controllers\web;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'all');
        $kategoriProduks = KategoriProduk::all();
        
        $query = Produk::with('kategoriProduk');
        
        if ($kategori !== 'all') {
            $query->whereHas('kategoriProduk', function($q) use ($kategori) {
                $q->where('slug', $kategori);
            });
        }
        
        $produks = $query->latest()->get();
        
        return view('page_web.produk.index', compact('produks', 'kategoriProduks', 'kategori'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $produk = Produk::where('slug', $slug)->firstOrFail();
        return view('page_web.produk.show', compact('produk'));
    }
}