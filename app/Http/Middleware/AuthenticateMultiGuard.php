<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateMultiGuard
{
    public function handle($request, Closure $next)
    {
        // Cek apakah user login sebagai admin
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }
        
        // Cek apakah user login sebagai user biasa
        if (Auth::guard('web')->check()) {
            return $next($request);
        }
        
        // Jika tidak ada yang login, redirect ke halaman login
        return redirect()->route('login');
    }
}