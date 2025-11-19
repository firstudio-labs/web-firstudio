<?php

namespace App\Http\Controllers\web;

use App\Models\Beranda;
use App\Models\Tentang;
use App\Models\Layanan;
use App\Models\Produk;
use App\Models\Tim;
use App\Models\Artikel;
use App\Models\Testimoni;
use App\Models\Profil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebBerandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beranda = Beranda::first();
        $tentang = Tentang::first();
        $layanan = Layanan::limit(5)->get();
        $produk = Produk::latest()->limit(6)->get(); // Ambil 6 untuk projects section
        $tim = Tim::limit(3)->get();
        $artikel = Artikel::where('status', 'Publik')->latest()->limit(6)->get(); // Ambil 6 untuk carousel
        $testimoni = Testimoni::latest()->limit(6)->get(); // Ambil 6 untuk testimonial slider
        $profil = Profil::first();
        
        return view('page_web.home', compact(
            'beranda', 
            'tentang', 
            'layanan', 
            'produk', 
            'tim', 
            'artikel', 
            'testimoni', 
            'profil'
        ));
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
    public function show(Beranda $beranda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beranda $beranda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beranda $beranda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beranda $beranda)
    {
        //
    }
}
