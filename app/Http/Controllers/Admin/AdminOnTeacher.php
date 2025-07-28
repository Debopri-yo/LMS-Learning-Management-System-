<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Teacher;


class AdminOnTeacher extends Controller
{
    public function listTeachers()
    {
        // Fetch teachers (sample query)
        $teachers = Teacher::all();
        
        // Return view with teachers
        return view('admin.teachers', ['teachers' => $teachers]);
    }

    public function removeTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('admin.list-teachers')->with('success', 'Teacher removed successfully.');
    }  
    public function showCreateTeacherForm()
    {
        return view('admin.create-teacher'); // Ensure this view exists
    }

    public function storeTeacher(Request $request)
    {
             // Validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:teachers,email',
                'password' => 'required|string|min:8|confirmed', // Ensure a confirmed password
            ]);
        
            // Create the teacher
            Teacher::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // Hash the password
            ]);
        
            // Redirect with success message
            return redirect()->back()->with('success', 'Teacher added successfully!');
    }
}
