<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        \Log::info('RoleMiddleware called for role: ' . $role . ' on path: ' . $request->path());
        
        // Pastikan user sudah ter-authenticate
        if (!Auth::check()) {
            \Log::warning('RoleMiddleware: User not authenticated');
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('login.form');
        }

        $user = Auth::user();
        \Log::info('RoleMiddleware: User authenticated - ' . $user->email . ' with role: ' . $user->role);

        // Cek role user
        if ($user->role !== $role) {
            \Log::warning('RoleMiddleware: User role mismatch. Expected: ' . $role . ', Got: ' . $user->role);
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        \Log::info('RoleMiddleware: Access granted');
        return $next($request);
    }
}
