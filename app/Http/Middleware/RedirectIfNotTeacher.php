<?php
// app/Http/Middleware/RedirectIfNotTeacher.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotTeacher
{
    public function handle($request, Closure $next, $guard = 'teacher')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('teacher.login');
        }

        return $next($request);
    }
}