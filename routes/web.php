<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Teacher\TeacherLoginController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminOnTeacher;
use App\Http\Controllers\ContentController;
use App\Models\Course;
use App\Models\Content;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Middleware\TeacherCanEditCourse;
use App\Http\Controllers\Teacher\TeacherCourseController;
use App\Http\Controllers\Teacher\TeacherContentController;
use App\Http\Controllers\Teacher\TeacherController;
// Public Routes
Route::get('/', function () {
    return view('welcome');
});
Route::get('/test-middleware', function () {
    return 'Middleware test route works';
})->middleware('teacher.can.edit.course');


// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
     Route::get('/notifications', function () {
        $notifications = auth()->User()->notifications()->paginate(10);
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');

    Route::post('/notifications/mark-all-read', function () {
        auth()->User()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.markAllRead');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //content routes
    Route::get('/courses/{course}/content/{content}', [\App\Http\Controllers\ContentController::class, 'show'])->name('content.show');
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('enroll.course');
    Route::get('/courses/{course}/checkout', [EnrollmentController::class, 'checkout'])->name('courses.checkout');
    Route::post('/courses/{course}/pay', [EnrollmentController::class, 'pay'])->name('courses.pay');
});

// Teacher Routes
Route::prefix('teacher')->group(function () {
    // Login Routes
    Route::get('/login', [TeacherLoginController::class, 'showLoginForm'])->name('teacher.login');
    Route::post('/login', [TeacherLoginController::class, 'login'])->name('teacher.login.post');
    Route::post('/logout', [TeacherLoginController::class, 'logout'])->name('teacher.logout');

    // Authenticated Teacher Routes
    Route::middleware('auth:teacher')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('teacher.dashboard');   
         // Now group the “can edit this course” routes by class reference
        Route::middleware([TeacherCanEditCourse::class])->group(function () {
            // Show “add content” form
              // Course Management
    Route::get('/courses', [App\Http\Controllers\Teacher\TeacherCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [TeacherCourseController::class, 'show'])->name('teacher.courses.show');    
    // Content Management
    Route::get('/courses/{course}/contents/create', [TeacherCourseController::class, 'createContent'])->name('teacher.courses.contents.create');
    Route::post('/courses/{course}/contents', [TeacherCourseController::class, 'storeContent'])->name('teacher.courses.contents.store');

    // Edit/update content
    Route::get('/courses/{course}/contents/{content}/edit', [TeacherCourseController::class, 'editContent'])->name('teacher.contents.edit');
    Route::put('/courses/{course}/contents/{content}', [TeacherCourseController::class, 'updateContent'])->name('teacher.contents.update');

    // Delete content
    Route::delete('/courses/{course}/contents/{content}', [TeacherCourseController::class, 'destroyContent'])->name('teacher.contents.destroy');

    // Preview content (Teacher view)
    Route::get('/courses/{course}/contents/{content}/preview', [TeacherCourseController::class, 'previewContent'])->name('teacher.contents.preview');

    // Toggle publish/unpublish
    Route::patch('/courses/{course}/contents/{content}/toggle-publish', [TeacherCourseController::class, 'togglePublish'])->name('teacher.contents.toggle-publish');

    // Update the order of contents (e.g., drag-drop reordering)
    Route::post('/courses/{course}/contents/update-order', [TeacherCourseController::class, 'updateOrder'])->name('teacher.contents.update-order');

});


    // Content management routes
        });
});
// Admin Routes
Route::prefix('admin')->group(function () {
    // Login Routes
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    // Authenticated Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); 
        })->name('admin.dashboard');
        //see removeable teachers list 
        Route::get('teachers', [AdminOnTeacher::class, 'listTeachers'])->name('admin.list-teachers');
        Route::delete('teachers/{id}', [AdminOnTeacher::class, 'removeTeacher'])->name('admin.remove-teacher');
         //see removeable admins list
        Route::get('/admins', [AdminController::class, 'listAdmins'])->name('admin.list-admins');
        Route::delete('/admins/{id}', [AdminController::class, 'removeAdmin'])->name('admin.remove-admin');

        // Create Admin Routes
        Route::get('/create-admin', [AdminController::class, 'showCreateAdminForm'])->name('admin.create-admin');
        Route::post('/create-admin', [AdminController::class, 'storeAdmin'])->name('admin.store-admin');

        // Create Teacher Routes
        Route::get('/create-teacher', [AdminOnTeacher::class, 'showCreateTeacherForm'])->name('admin.create-teacher');
        Route::post('/create-teacher', [AdminOnTeacher::class, 'storeTeacher'])->name('admin.store-teacher');

        // Create Course Routes
        Route::get('/create-course', [AdminController::class, 'showCreateCourseForm'])->name('admin.create-course');
        Route::post('/create-course', [AdminController::class, 'storeCourse'])->name('admin.store-course');
    });
});

// Course and Enrollment Routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/search', [CourseController::class, 'search'])->name('courses.search');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('my-courses');
Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('enroll.course');
Route::get('/course/{course}', [CourseController::class, 'show'])->name('course.show');
Route::get('/courses/{course}/content/contents', [ContentController::class, 'allContents'])->name('content.all');
Route::get('/courses/{course}/content/{content}', [ContentController::class, 'show'])->name('content.show');
Route::get('/courses/{course}/contents', [ContentController::class, 'index'])->name('contents.index');


// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

require __DIR__.'/auth.php';
