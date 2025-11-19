<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek role (saat ini hanya admin)
            if ($user->role === 'admin') {
                Alert::success('Login Berhasil', 'Selamat datang kembali, Admin!');
                return redirect()->route('admin.dashboard');
            }

            // Jika rolenya tidak dikenali
            Auth::logout();
            Alert::error('Login Gagal', 'Anda tidak memiliki akses.');
            return redirect('/');
        }

        // Jika login gagal
        Alert::error('Login Gagal', 'Email atau password salah.');
        return back();
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        Alert::info('Logged Out', 'You have been logged out.');
        return redirect()->route('web.beranda.index');
    }
}
