<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll($course_id)
    {
        $user = Auth::user();
        $course = Course::findOrFail($course_id);

        // Check if the user is already enrolled
        if ($user->enrollments()->where('course_id', $course_id)->exists()) {
            return redirect()->route('my-courses')->with('message', 'You are already enrolled in this course!');
        }

        // Enroll the user
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrolled_at' => now(),
        ]);
        
$user = Auth::user();

    // Check if already enrolled
    $alreadyEnrolled = $user->enrollments()->where('course_id', $course->id)->exists();

    if ($alreadyEnrolled) {
        return redirect()->back()->with('info', 'You are already enrolled in this course.');
    }

    // Enroll the user
    $user->enrollments()->create([
        'course_id' => $course->id,
        'enrollment_type' => 'free',
        'enrolled_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Enrolled successfully!');    }
    public function checkout(Course $course)
{
    if ($course->type !== 'paid') {
        return redirect()->route('courses.show', $course->id)->with('info', 'This course is free.');
    }

    return view('courses.checkout', compact('course'));
}

public function pay(Request $request, Course $course)
{
    $user = $request->user();

    // Check if already enrolled
    if ($user->enrollments()->where('course_id', $course->id)->exists()) {
        return redirect()->route('courses.show', $course->id)->with('info', 'You are already enrolled in this course.');
    }

    // ✅ Simulated payment success → create enrollment
    Enrollment::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'enrollment_type' => 'paid',
    ]);

    return redirect()->route('courses.show', $course->id)->with('success', 'Payment successful! You are now enrolled.');
}

}
