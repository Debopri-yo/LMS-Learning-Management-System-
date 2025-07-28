<?php
namespace App\Http\Controllers\Admin;
use App\Models\Stream;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth; 
use App\Models\Teacher;

class AdminController extends Controller
{  
    public function listAdmins()
{
    // Debugging check
    logger('listAdmins method called');
    
    // Fetch all admins except the current logged-in admin
    $admins = Admin::where('id', '!=', auth()->id())->get();

    return view('admin.list-admins', compact('admins'));
}

public function removeAdmin($id)
{
    // Debugging check
    logger('removeAdmin method called with id: ' . $id);

    // Find the admin by ID and delete
    $admin = Admin::findOrFail($id);
    $admin->delete();

    return redirect()->route('admin.list-admins')->with('success', 'Admin removed successfully.');
}

    
    
    
    
    public function showCreateAdminForm()
    {
        return view('admin.create-admin'); // Ensure this view exists
    }
    
        public function storeAdmin(Request $request)
        {
                 // Validate request
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:teachers,email',
                    'password' => 'required|string|min:8|confirmed', // Ensure a confirmed password
                ]);
            
                // Create the teacher
                Admin::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                     // Hash the password
                ]);
            
                // Redirect with success message
                return redirect()->back()->with('success', 'Admin added successfully!');
        }
    public function showCreateCourseForm()
    {
        $streams = Stream::all(); // Fetch all streams
        $teachers = Teacher::all(); // Fetch all teachers
        return view('admin.create-course', compact('streams', 'teachers'));  
    }

   public function storeCourse(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'stream_id' => 'required|exists:streams,id',
        'teacher_id' => 'required|exists:teachers,id',
        'start_date' => 'nullable|date|before_or_equal:end_date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'type' => 'required|in:free,paid',
        'price' => 'nullable|integer|min:0',  // ✅ Validation for price
    ]);

    // Set price to 0 if course is free
    $price = ($request->type === 'free') ? 0 : $request->price;

    Course::create([
        'name' => $request->name,
        'description' => $request->description,
        'stream_id' => $request->stream_id,
        'teacher_id' => $request->teacher_id,
        'created_by' => Auth::id(),
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'type' => $request->type,
        'price' => $price,  // ✅ Save the price here
    ]);

    return redirect()->back()->with('success', 'Course created successfully!');
}


}
