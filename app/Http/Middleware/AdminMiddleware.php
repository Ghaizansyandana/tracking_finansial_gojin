<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah sudah login dan apakah rolenya admin
        if (auth()->check() && auth()->user()->role == 'admin') {
            return $next($request);
        }

        // Jika bukan admin, arahkan ke home dengan pesan error
        return redirect('/home')->with('error', 'Akses ditolak! Anda bukan administrator.');
    }
}