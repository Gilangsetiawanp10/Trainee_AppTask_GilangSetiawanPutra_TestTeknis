<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect('/admin/dashboard');
                }
                break;
            
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/trainee-tasks');
                }
                break;
        }

        return $next($request);
    }
}
