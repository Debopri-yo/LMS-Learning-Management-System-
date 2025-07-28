<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePaidEnrollment
{
    public function handle(Request $request, Closure $next)
    {
        $course = $request->route('course');

        // If the course is FREE, allow public access
        if ($course->type === 'free') {
            return $next($request);
        }

        // If not logged in, redirect to login
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please login to access this course.');
        }

        // If logged in but NOT enrolled, block access
        $enrolled = $request->user()->enrollments()
            ->where('course_id', $course->id)
            ->exists();

        if (!$enrolled) {
            return redirect()->route('courses.show', $course)->with('info', 'You need to enroll to view this content.');
        }

        return $next($request);
    }
}
