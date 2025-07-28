<?php
// app/Http/Middleware/RedirectIfAuthenticated.php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Customize redirect based on guard
                switch($guard) {
                    case 'teacher':
                        return redirect()->route('teacher.dashboard');
                    default:
                        return redirect(RouteServiceProvider::HOME);
                }
            }
        }

    return $next($request);      
    }
}
