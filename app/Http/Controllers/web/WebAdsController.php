<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\MetaAdsBlock;
use App\Models\Setting;
use App\Support\MetaAdsTheme;

class WebAdsController extends Controller
{
    public function index()
    {
        $blocks = MetaAdsBlock::where('is_active', true)->ordered()->get();

        $pageTitle = Setting::where('key', 'meta_ads_page_title')->value('value') ?: 'Firstudio';
        $pageDescription = Setting::where('key', 'meta_ads_page_description')->value('value') ?: '';

        $theme = MetaAdsTheme::fromDatabase();

        return view('page_web.ads.index', compact('blocks', 'pageTitle', 'pageDescription', 'theme'));
    }
}
