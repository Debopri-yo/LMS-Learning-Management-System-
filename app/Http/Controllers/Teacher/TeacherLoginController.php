<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TeacherLoginController extends Controller
{
    /**
     * Show the login form for teachers.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.teacher-login'); // Ensure this view exists
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt authentication
        if (Auth::guard('teacher')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->route('teacher.dashboard');
        }

        // Authentication failed
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Log the teacher out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('teacher.login');
    }
}

