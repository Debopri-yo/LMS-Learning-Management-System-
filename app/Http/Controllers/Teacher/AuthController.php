<?php
// app/Http/Controllers/Teacher/AuthController.php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Constructor to apply middleware
    public function __construct()
    {
        // Use parent controller's middleware method
        $this->middleware('guest:teacher')->except('logout');
    }

    public function showLoginForm()
    {
        return view('teacher.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('teacher')->attempt($credentials, $request->filled('remember'))) {
            // Redirect to teacher dashboard
            return redirect()->intended(route('teacher.dashboard'));
        }

        // Redirect back with error
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
    }

    public function logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher.login');
    }
}