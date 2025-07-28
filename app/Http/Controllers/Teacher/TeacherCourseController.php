<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewContentAdded;
class TeacherCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display teacher's assigned courses
     */
    public function index()
    {
        $courses = Course::where('teacher_id', Auth::id())
            ->with(['contents' => function($query) {
                $query->orderBy('order');
            }])
            ->paginate(10);

        return view('teacher.courses.index', compact('courses'));
    }

    /**
     * Show specific course with contents
     */
    public function show(Course $course)
    {
        // Ensure teacher can only access their own courses
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to course');
        }

        $contents = $course->contents()
            ->orderBy('order')
            ->paginate(15);

        return view('teacher.courses.show', compact('course', 'contents'));
    }

    /**
     * Show form to create new content
     */
    public function createContent(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to course');
        }

        $contentTypes = [
            'lesson' => 'Text Lesson',
            'video' => 'Video',
            'document' => 'Document',
            'assignment' => 'Assignment',
            'quiz' => 'Quiz',
            'link' => 'External Link'
        ];

        return view('courses.contents.create', compact('course', 'contentTypes'));
    }

    /**
     * Show form to edit content
     */
    public function editContent(Course $course, Content $content)
    {
        if ($course->teacher_id !== Auth::id() || $content->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $contentTypes = [
            'lesson' => 'Text Lesson',
            'video' => 'Video',
            'document' => 'Document',
            'assignment' => 'Assignment',
            'quiz' => 'Quiz',
            'link' => 'External Link'
        ];

        return view('teacher.contents.edit', compact('course', 'content', 'contentTypes'));
    }

    /**
     * Store new content
     */
   public function storeContent(Request $request, Course $course)
{
    if ($course->teacher_id !== Auth::id()) {
        abort(403, 'Unauthorized access to course');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|in:lesson,video,document,assignment,quiz,link',
        'description' => 'nullable|string',
        'content' => 'nullable|string',
        'body' => 'nullable|string',
        'file' => 'nullable|file|max:51200',
        'order' => 'nullable|integer|min:0',
        'is_published' => 'boolean',
        'settings' => 'nullable|array'
    ]);

    $lastOrder = $course->contents()->max('order') ?? 0;
    $content = new Content();
    $content->course_id = $course->id;
    $content->teacher_id = Auth::id();
    $content->title = $validated['title'];
    $content->type = $validated['type'];
    $content->description = $validated['description'] ?? null;
    $content->content = $validated['content'] ?? null;
    $content->body = $validated['body'] ?? null;
    $content->order = $validated['order'] ?? ($lastOrder + 1);
    $content->is_published = $request->has('is_published') ? 1 : 0;
    $content->settings = $validated['settings'] ?? [];

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs("courses/{$course->id}/contents", $filename, 'public');
        $content->file_path = $path;
        $content->file_type = $file->getClientMimeType();
        $content->file_size = $file->getSize();
    }

    $content->save();

    // ✅ Notify all enrolled users
    $students = $course->users; // via belongsToMany 'users'
    foreach ($students as $student) {
        $student->notify(new \App\Notifications\NewContentAdded($content));
    }

    return redirect()->route('teacher.courses.show', $course)->with('success', 'Content created and notifications sent!');
}




    /**
     * Update existing content
     */
    public function updateContent(Request $request, Course $course, Content $content)
{
    if ($course->teacher_id !== Auth::id() || $content->teacher_id !== Auth::id()) {
        abort(403, 'Unauthorized access');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|in:lesson,video,document,assignment,quiz,link',
        'description' => 'nullable|string',
        'content' => 'nullable|string',
        'body' => 'nullable|string',
        'file' => 'nullable|file|max:51200',
        'order' => 'nullable|integer|min:0',
        'is_published' => 'boolean',
        'settings' => 'nullable|array'
    ]);

    $content->title = $validated['title'];
    $content->type = $validated['type'];
    $content->description = $validated['description'] ?? null;
    $content->content = $validated['content'] ?? null;
    $content->body = $validated['body'] ?? null;
    $content->order = $validated['order'] ?? $content->order;
    $content->is_published = $request->has('is_published') ? 1 : 0;
    $content->settings = $validated['settings'] ?? [];

    // Handle new file upload
    if ($request->hasFile('file')) {
        if ($content->file_path && Storage::disk('public')->exists($content->file_path)) {
            Storage::disk('public')->delete($content->file_path);
        }

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs("courses/{$course->id}/contents", $filename, 'public');

        $content->file_path = $path;
        $content->file_type = $file->getClientMimeType();
        $content->file_size = $file->getSize();
    }

    $content->save();

    return redirect()
        ->route('teacher.courses.show', $course)
        ->with('success', 'Content updated successfully!');
}


    /**
     * Delete content
     */
    public function destroyContent(Course $course, Content $content)
    {
        if ($course->teacher_id !== Auth::id() || $content->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Delete associated file if exists
        if ($content->file_path && Storage::disk('public')->exists($content->file_path)) {
            Storage::disk('public')->delete($content->file_path);
        }

        $content->delete();

        return redirect()
            ->route('teacher.courses.show', $course)
            ->with('success', 'Content deleted successfully!');
    }

    /**
     * Toggle content publication status
     */
    public function togglePublish(Course $course, Content $content)
    {
        if ($course->teacher_id !== Auth::id() || $content->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $content->is_published = !$content->is_published;
        $content->save();

        $status = $content->is_published ? 'published' : 'unpublished';
        
        return response()->json([
            'success' => true,
            'message' => "Content {$status} successfully!",
            'is_published' => $content->is_published
        ]);
    }

    /**
     * Update content order (for drag and drop)
     */
    public function updateOrder(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'contents' => 'required|array',
            'contents.*.id' => 'required|exists:contents,id',
            'contents.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->contents as $contentData) {
            Content::where('id', $contentData['id'])
                ->where('course_id', $course->id)
                ->where('teacher_id', Auth::id())
                ->update(['order' => $contentData['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Content order updated successfully!'
        ]);
    }

    /**
     * Preview content
     */
    public function previewContent(Course $course, Content $content)
    {
        if ($course->teacher_id !== Auth::id() || $content->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('teacher.content.show', compact('course', 'content'));

    }
}