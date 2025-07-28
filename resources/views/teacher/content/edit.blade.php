{{-- resources/views/teacher/content/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Content: ' . $content->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="bg-blue-600 text-white p-6 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">Edit Content</h1>
                        <p class="text-blue-100 mt-1">Course: {{ $course->title }}</p>
                    </div>
                    <a href="{{ route('teacher.courses.edit', $course) }}" 
                       class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-md flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Course
                    </a>
                </div>
            </div>
        </div>

        {{-- Edit Form --}}
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('teacher.content.update', [$course, $content]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Left Column --}}
                        <div class="space-y-4">
                            {{-- Content Type --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Content Type</label>
                                <select name="type" id="contentType" onchange="toggleContentFields()" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="lesson" {{ $content->type == 'lesson' ? 'selected' : '' }}>Lesson</option>
                                    <option value="video" {{ $content->type == 'video' ? 'selected' : '' }}>Video</option>
                                    <option value="document" {{ $content->type == 'document' ? 'selected' : '' }}>Document</option>
                                    <option value="assignment" {{ $content->type == 'assignment' ? 'selected' : '' }}>Assignment</option>
                                    <option value="quiz" {{ $content->type == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                    <option value="link" {{ $content->type == 'link' ? 'selected' : '' }}>External Link</option>
                                </select>
                            </div>

                            {{-- Title --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                                <input type="text" name="title" value="{{ old('title', $content->title) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $content->description) }}</textarea>
                            </div>

                            {{-- Publishing Options --}}
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_published" value="1" 
                                           {{ old('is_published', $content->is_published) ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm text-gray-700">Published (students can see this content)</span>
                                </label>
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="space-y-4">
                            {{-- Current File Display --}}
                            @if($content->file_path)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-800 mb-2">Current File</h4>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700">
                                                {{ $content->file_type ? strtoupper($content->file_type) : 'File' }}
                                                @if($content->file_size)
                                                    ({{ number_format($content->file_size / 1024, 1) }} KB)
                                                @endif
                                            </span>
                                        </div>
                                        <a href="{{ Storage::url($content->file_path) }}" target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                                    </div>
                                    <div class="mt-2">
                                        <label class="flex items-center text-sm">
                                            <input type="checkbox" name="remove_existing_file" value="1" class="mr-2">
                                            <span class="text-red-600">Remove current file</span>
                                        </label>
                                    </div>
                                </div>
                            @endif

                            {{-- File Upload --}}
                            <div id="fileUploadField">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $content->file_path ? 'Replace with new file' : 'Upload Files' }}
                                </label>
                                <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.mp3,.jpg,.png,.zip"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">
                                    Accepted formats: PDF, DOC, DOCX, PPT, PPTX, MP4, MP3, JPG, PNG, ZIP (Max 50MB per file)
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Content Fields --}}
                    <div class="mt-6 space-y-4">
                        {{-- Text Content (for lessons) --}}
                        <div id="textContentField">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                            <textarea name="content" rows="8"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $content->type === 'link' ? '' : $content->content) }}</textarea>
                        </div>

                        {{-- External Link (for link type) --}}
                        <div class="hidden" id="linkField">
                            <label class="block text-sm font-medium text-gray-700 mb-2">External Link URL</label>
                            <input type="url" name="external_link" 
                                   value="{{ old('external_link', $content->type === 'link' ? $content->content : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('teacher.courses.edit', $course) }}" 
                           class="px-6 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Update Content
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleContentFields() {
    const contentType = document.getElementById('contentType').value;
    const textContentField = document.getElementById('textContentField');
    const fileUploadField = document.getElementById('fileUploadField');
    const linkField = document.getElementById('linkField');
    
    // Show/hide fields based on content type
    if (contentType === 'lesson') {
        textContentField.classList.remove('hidden');
        fileUploadField.classList.remove('hidden');
        linkField.classList.add('hidden');
    } else if (contentType === 'link') {
        textContentField.classList.add('hidden');
        fileUploadField.classList.add('hidden');
        linkField.classList.remove('hidden');
    } else {
        textContentField.classList.add('hidden');
        fileUploadField.classList.remove('hidden');
        linkField.classList.add('hidden');
    }
}

// Initialize field visibility on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleContentFields();
});
</script>
@endsection