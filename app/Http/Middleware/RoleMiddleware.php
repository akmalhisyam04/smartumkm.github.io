<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login via session
        if (!session('login')) {
            return redirect()->route('login');
        }

        $userRole = session('role');

        // Jika roles kosong, izinkan akses
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah role user ada di dalam array roles yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, redirect ke dashboard dengan pesan error
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
    }
}