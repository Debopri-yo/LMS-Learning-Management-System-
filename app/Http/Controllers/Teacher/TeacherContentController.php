<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Content;
use App\Services\ContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherContentController extends Controller
{
    protected $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    public function store(Request $request, Course $course)
    {
        // Check if teacher is assigned to this course
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:lesson,video,document,assignment,quiz,link',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'external_link' => 'nullable|url',
            'files.*' => 'nullable|file|max:51200', // 50MB max per file
            'is_published' => 'boolean'
        ]);

        try {
            $content = $this->contentService->createContent(
                $course,
                $validated,
                $request->file('files')
            );

            // Handle external link for link type
            if ($validated['type'] === 'link' && $validated['external_link']) {
                $content->update(['content' => $validated['external_link']]);
            }

            return redirect()->route('teacher.courses.edit', $course)
                            ->with('success', 'Content added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Error adding content: ' . $e->getMessage())
                            ->withInput();
        }
    }
    public function checkOrder(Course $course, $order)
    {
        $exists = Content::where('course_id', $course->id)
                         ->where('order', $order)
                         ->exists();

        return response()->json(['exists' => $exists]);
    }
    
    
    public function previewContent(Course $course, Content $content)
{
    if ($content->course_id !== $course->id) {
        abort(404);
    }

    return view('teacher.content.show', compact('course', 'content'));
}

    public function edit(Course $course, Content $content)
    {
        $this->authorize('update', $course);
        
        return view('teacher.content.edit', compact('course', 'content'));
    }

    public function update(Request $request, Course $course, Content $content)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:lesson,video,document,assignment,quiz,link',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'external_link' => 'nullable|url',
            'files.*' => 'nullable|file|max:51200',
            'is_published' => 'boolean',
            'remove_existing_file' => 'boolean'
        ]);

        try {
            // Handle file removal
            if ($request->boolean('remove_existing_file') && $content->file_path) {
                Storage::disk('public')->delete($content->file_path);
                $content->update([
                    'file_path' => null,
                    'file_type' => null,
                    'file_size' => null
                ]);
            }

            // Update basic content info
            $content->update([
                'title' => $validated['title'],
                'type' => $validated['type'],
                'description' => $validated['description'],
                'content' => $validated['type'] === 'link' ? $validated['external_link'] : $validated['content'],
                'is_published' => $validated['is_published'] ?? false
            ]);

            // Handle new file uploads
            if ($request->hasFile('files')) {
                $this->contentService->handleFileUploads($content, $request->file('files'));
            }

            return redirect()->route('teacher.courses.edit', $course)
                            ->with('success', 'Content updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Error updating content: ' . $e->getMessage())
                            ->withInput();
        }
    }

    public function destroy(Course $course, Content $content)
    {
        $this->authorize('update', $course);

        try {
            // Delete associated files
            if ($content->file_path) {
                Storage::disk('public')->delete($content->file_path);
            }

            // Delete content files
            foreach ($content->files as $file) {
                Storage::disk('public')->delete($file->file_path);
            }

            $content->delete();

            return redirect()->route('teacher.courses.edit', $course)
                            ->with('success', 'Content deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Error deleting content: ' . $e->getMessage());
        }
    }
}

