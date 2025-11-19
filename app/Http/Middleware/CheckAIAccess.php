<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAIAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Silakan login terlebih dahulu.'
            ], 401);
        }

        // Pastikan user adalah admin
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden. Hanya admin yang dapat menggunakan fitur AI.'
            ], 403);
        }

        // Cek apakah Gemini API key tersedia
        if (empty(config('services.gemini.api_key'))) {
            return response()->json([
                'success' => false,
                'message' => 'Layanan AI tidak tersedia. Hubungi administrator.'
            ], 503);
        }

        return $next($request);
    }
}
