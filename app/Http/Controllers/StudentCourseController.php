<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class StudentCourseController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // Assuming you have a many-to-many relationship like: $student->courses()
        $courses = $student->courses()->with('teacher')->get();

        return view('student.my-courses', compact('courses'));
    }
}
