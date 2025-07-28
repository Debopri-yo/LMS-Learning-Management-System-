<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherCanEditCourse
{
    public function handle($request, Closure $next)
    {
        $course = $request->route('course');

    if (auth('teacher')->check() && $course->teacher_id === auth('teacher')->id()) {
        return $next($request);
    }

    abort(403, 'Unauthorized');
}
}
