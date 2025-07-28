<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Services\ContentService;

class ContentController extends Controller
{
    protected $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    // Show content create form
    public function create(Course $course)
    {
        $this->authorizeCourseOwnership($course);

        return view('teacher.content.create', ['course' => $course]);
    }

    // Store new content
    public function store(Request $request, Course $course)
    {
        $this->authorizeCourseOwnership($course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:lesson,video,document,assignment,quiz,link',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'files.*' => 'nullable|file|max:50000',
            'is_published' => 'boolean'
        ]);

        $this->contentService->createContent($course, $validated, $request->file('files'));

        return redirect()->route('teacher.dashboard')->with('success', 'Content added successfully!');
    }

    // Show edit form
    public function edit(Content $content)
    {
        $this->authorizeContentOwnership($content);

        return view('teacher.content.edit', compact('content'));
    }

    // Update content
    public function update(Request $request, Content $content)
    {
        $this->authorizeContentOwnership($content);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:lesson,video,document,assignment,quiz,link',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'files.*' => 'nullable|file|max:50000',
            'is_published' => 'boolean'
        ]);

        $this->contentService->updateContent($content, $validated, $request->file('files'));

        return redirect()->route('teacher.dashboard')->with('success', 'Content updated successfully!');
    }

   public function show(Course $course, Content $content)
{
    // Ensure the content belongs to the course for security
    if ($content->course_id !== $course->id) {
        abort(404);
    }

    // Optional: Check if content is published before showing
    if (!$content->is_published) {
        abort(403, 'This content is not available.');
    }

    // Handle Free or Paid Logic
    if ($course->type !== 'free') {
        // If user is not logged in, redirect to login
        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'Please login to access this course.');
        }

        // Check enrollment
        $enrolled = auth()->user()->enrollments()->where('course_id', $course->id)->exists();

        if (!$enrolled) {
            return redirect()->route('courses.show', $course)->with('info', 'You need to enroll to view this content.');
        }
    }

    // Previous & Next Content
    $previousContent = $course->contents()
        ->where('order', '<', $content->order)
        ->orderByDesc('order')
        ->first();

    $nextContent = $course->contents()
        ->where('order', '>', $content->order)
        ->orderBy('order')
        ->first();

    return view('content.show', compact('course', 'content', 'previousContent', 'nextContent'));
}

public function index(Course $course)
{
    $contents = $course->contents()->where('is_published', true)->paginate(10);

    return view('contents.index', compact('course', 'contents'));
}
public function checkOrder(Course $course, $order)
    {
        $exists = Content::where('course_id', $course->id)
                         ->where('order', $order)
                         ->exists();

        return response()->json(['exists' => $exists]);
    }


public function allContents(Course $course)
{
    // Free courses are public, paid need enrollment
    if ($course->type !== 'free') {
        // If user is not logged in, redirect to login
        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'Please login to access this course.');
        }

        // Check enrollment
        $enrolled = auth()->user()->enrollments()->where('course_id', $course->id)->exists();

        if (!$enrolled) {
            return redirect()->route('courses.show', $course)->with('info', 'You need to enroll to view this content.');
        }
    }

    $contents = $course->contents()->published()->paginate(10);

    return view('contents.index', compact('course', 'contents'));
}



    


// === Helpers ===

    private function authorizeCourseOwnership(Course $course)
    {
        if ($course->teacher_id !== auth('teacher')->id()) {
            abort(403, 'Unauthorized: This course does not belong to you.');
        }
    }

    private function authorizeContentOwnership(Content $content)
    {
        if ($content->course->teacher_id !== auth('teacher')->id()) {
            abort(403, 'Unauthorized: This content does not belong to your course.');
        }
    }
}
