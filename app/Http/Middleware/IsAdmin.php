<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login atau bukan admin, tendang ke dashboard user/home
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses admin.');
        }

        return $next($request);
    }
}