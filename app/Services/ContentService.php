<?php
namespace App\Services;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Support\Facades\Storage;

class ContentService
{
    public function createContent(Course $course, array $data, $files = null)
    {
        $content = $course->contents()->create([
            'title' => $data['title'],
            'type' => $data['type'],
            'description' => $data['description'] ?? null,
            'content' => $data['content'] ?? null,
            'order' => $this->getNextOrder($course),
            'is_published' => $data['is_published'] ?? false,
            'settings' => $data['settings'] ?? null
        ]);

        // Handle file uploads
        if ($files && count($files) > 0) {
            $this->handleFileUploads($content, $files);
        }

        return $content;
    }

    public function handleFileUploads(Content $content, $files)
    {
        foreach ($files as $file) {
            if ($file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs(
                    'courses/' . $content->course_id . '/content',
                    $fileName,
                    'public'
                );

                // Update main content record (for single file support)
                $content->update([
                    'file_path' => $filePath,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize()
                ]);

                // Also save in content_files table (for multiple files support)
                $content->files()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize()
                ]);
            }
        }
    }

    private function getNextOrder(Course $course)
    {
        return $course->contents()->max('order') + 1;
    }
}