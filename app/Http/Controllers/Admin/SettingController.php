<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $openRouterApiKey = Setting::where('key', 'openrouter_api_key')->value('value');
        return view('page_admin.settings.index', compact('openRouterApiKey'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'openrouter_api_key' => 'nullable|string',
        ]);

        Setting::updateOrCreate(
            ['key' => 'openrouter_api_key'],
            ['value' => $request->openrouter_api_key]
        );

        return redirect()->back()->with('success', 'Pengaturan API Key OpenRouter berhasil disimpan.');
    }
}
