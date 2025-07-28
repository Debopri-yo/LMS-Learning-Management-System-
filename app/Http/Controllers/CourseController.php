<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;

class CourseController extends Controller
{
    // Show all courses
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }
    public function show(Course $course)
{
    return view('course.show', compact('course'));
}
    
    // Search courses by name or description
    public function search(Request $request)
    {
        $query = $request->input('query');
        $courses = Course::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->get();

        return view('courses.index', compact('courses'));
    }

    // Show courses the authenticated user is enrolled in
    public function myCourses()
    {
        $user = Auth::user();
        $courses = $user->courses; // Assuming User has a 'courses' relationship (belongsToMany)

        return view('my-courses', compact('courses'));
    }

    // Show all courses + the user's enrollments
    public function showCourses()
    {
        $allCourses = Course::all();
        $courses = Auth::user()->enrollments()->with('course')->get();

        return view('yourviewname', compact('allCourses', 'courses'));
    }

    // Enroll the user in a course
    public function enroll($courseId)
    {
        $enrollment = new Enrollment();
        return $enrollment->enroll($courseId);
    }

    // Store a new course (with proper validation)
public function store(Request $request)
{
        dd('STORE METHOD HIT');
    // Base validation
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'stream_id' => 'required|exists:streams,id',
        'teacher_id' => 'required|exists:users,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'type' => 'required|in:free,paid',
        'price' => ['nullable', 'integer', 'min:0'],
        'is_active' => 'nullable|boolean',
    ]);
        dd($validated); // 👈 This will show you the data being passed to the controller
    // Custom logic: Require price for paid courses
    if ($validated['type'] === 'paid' && empty($validated['price'])) {
        return redirect()->back()
            ->withErrors(['price' => 'Price is required for paid courses.'])
            ->withInput();
    }

    // Auto-set price to 0 for free courses
    if ($validated['type'] === 'free') {
        $validated['price'] = 0;
    }

    // Ensure is_active defaults to true if not explicitly provided
    if (!isset($validated['is_active'])) {
        $validated['is_active'] = true;
    }

    Course::create($validated);

    return redirect()->route('admin.dashboard')->with('success', 'Course created successfully.');
}

}
