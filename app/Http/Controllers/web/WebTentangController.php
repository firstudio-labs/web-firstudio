<?php

namespace App\Http\Controllers\web;

use App\Models\Tentang;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebTentangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tentang = Tentang::first();
        $testimoni = Testimoni::latest()->get();
        return view('page_web.tentang.index', compact('tentang', 'testimoni'));
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
    public function show(Tentang $tentang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tentang $tentang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tentang $tentang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tentang $tentang)
    {
        //
    }
}
