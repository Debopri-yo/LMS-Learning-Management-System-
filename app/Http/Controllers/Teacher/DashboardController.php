<?php
// app/Http/Controllers/Teacher/DashboardController.php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();

        // Assuming the Teacher model has a `courses()` relationship
        $courses = $teacher->courses;
    
        return view('teacher.dashboard', compact('teacher', 'courses'));
    
    }
}
