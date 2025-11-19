<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artikel;
use App\Models\Kontak;
use App\Models\Layanan;
use App\Models\Produk;
use App\Models\Testimoni;
use App\Models\Tim;
use App\Models\Profil;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        \Log::info('DashboardController@index called');
        try {
            $artikel = $this->countArtikel();
            $layanan = $this->countLayanan();
            $produk = $this->countProduk();
            $testimoni = $this->countTestimoni();
            $tim = $this->countTim();
            $kontak = $this->countKontak();
            $profil = Profil::first();
            \Log::info('Dashboard data loaded successfully');
            return view('page_admin.dashboard.index', compact('artikel', 'layanan', 'produk', 'testimoni', 'tim', 'kontak', 'profil'));
        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            \Log::error('Dashboard Error Trace: ' . $e->getTraceAsString());
            abort(500, 'Terjadi kesalahan saat memuat dashboard: ' . $e->getMessage());
        }
    }

    public function countArtikel()
    {
        $artikel = count(Artikel::all());
        return $artikel;
    }

    public function countLayanan()
    {
        $layanan = count(Layanan::all());
        return $layanan;
    }

    public function countProduk()
    {
        $produk = count(Produk::all());
        return $produk;
    }

    public function countTestimoni()
    {
        $testimoni = count(Testimoni::all());
        return $testimoni;
    }

    public function countTim()
    {
        $tim = count(Tim::all());
        return $tim;
    }

    public function countKontak()
    {
        $kontak = count(Kontak::all());
        return $kontak;
    }
}