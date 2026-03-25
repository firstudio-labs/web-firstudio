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
        $openRouterModel = Setting::where('key', 'openrouter_model')->value('value');
        return view('page_admin.settings.index', compact('openRouterApiKey', 'openRouterModel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'openrouter_api_key' => 'nullable|string',
            'openrouter_model' => 'nullable|string',
        ]);

        Setting::updateOrCreate(
            ['key' => 'openrouter_api_key'],
            ['value' => $request->openrouter_api_key]
        );

        Setting::updateOrCreate(
            ['key' => 'openrouter_model'],
            ['value' => $request->openrouter_model]
        );

        return redirect()->back()->with('success', 'Pengaturan OpenRouter berhasil disimpan.');
    }

    public function testAi()
    {
        try {
            $service = new \App\Services\OpenRouterAIService();
            $result = $service->testConnection();

            if (isset($result['success']) && $result['success']) {
                $msg = $result['message'] ?? 'OK';
                return redirect()->back()->with('success', 'Uji koneksi ke API OpenRouter berhasil! (' . $msg . ')');
            } else {
                $msg = $result['message'] ?? 'Unknown error';
                return redirect()->back()->with('error', 'Koneksi ke API OpenRouter gagal: ' . $msg);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menguji API: ' . $e->getMessage());
        }
    }
}
