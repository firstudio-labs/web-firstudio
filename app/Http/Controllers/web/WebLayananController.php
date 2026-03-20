<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

class WebLayananController extends Controller
{
    /**
     * Display website development service page
     */
    public function website()
    {
        return view('page_web.layanan.website');
    }

    /**
     * Display mobile app development service page
     */
    public function mobile()
    {
        return view('page_web.layanan.mobile');
    }

    /**
     * Display IT consultation service page
     */
    public function itconsul()
    {
        return view('page_web.layanan.itconsul');
    }

    /**
     * Display company profile service page
     */
    /**
     * Display company profile service page
     */
    public function company()
    {
        return view('page_web.layanan.company');
    }

    /**
     * Display IT outsourcing service page
     */
    public function itoutsourcing()
    {
        return view('page_web.layanan.itoutsourcing');
    }
}
