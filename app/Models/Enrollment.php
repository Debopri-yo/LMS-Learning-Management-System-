<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ['user_id', 'course_id','enrollment_type',];

    // Define the inverse relationship with the Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Define the inverse relationship with the User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function enroll(Request $request, $courseId)
{
    $user = Auth::user();
    $course = Course::findOrFail($courseId);

    // Check if the user is already enrolled
    if ($user->courses->contains($course)) {
        return redirect()->route('courses.index')->with('message', 'You are already enrolled in this course.');
    }

    // Enroll the user in the course
    $user->courses()->attach($course);

    return redirect()->route('courses.index')->with('message', 'You have successfully enrolled in the course.');
}


}
