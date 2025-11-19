<?php

namespace App\Http\Controllers\web;

use App\Models\Kontak;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class WebKontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = Profil::first();
        return view('page_web.kontak.index', compact('profil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $useHCaptcha = config('services.hcaptcha.site_key') && config('services.hcaptcha.secret_key');

        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20',
            'pesan' => 'required|string',
        ];

        if ($useHCaptcha) {
            $rules['h-captcha-response'] = 'required';
        }

        $request->validate($rules);

        if ($useHCaptcha && !$this->verifyHCaptcha($request->input('h-captcha-response'))) {
            return back()
                ->withErrors(['h-captcha-response' => 'Verifikasi hCaptcha gagal. Silakan coba lagi.'])
                ->withInput();
        }

        Kontak::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'pesan' => $request->pesan
        ]);

        return redirect()->route('web.contact.index')
            ->with('success', 'Pesan Anda berhasil dikirim. Kami akan menghubungi Anda segera.');
    }

    protected function verifyHCaptcha(?string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $secret = config('services.hcaptcha.secret_key');

        if (!$secret) {
            return false;
        }

        $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret' => $secret,
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);

        if (!$response->successful()) {
            return false;
        }

        $body = $response->json();

        return $body['success'] ?? false;
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontak $kontak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontak $kontak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontak $kontak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontak $kontak)
    {
        //
    }
}
