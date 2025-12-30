<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanManageData
{
    /**
     * Handle an incoming request.
     * Only Superuser and Administrasi can manage data (create, update, delete)
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        if (!$user->canManageData()) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola data. Hubungi administrator.');
        }

        return $next($request);
    }
}
