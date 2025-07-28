@extends('layouts.app')

@section('title', 'Manage Course: ' . $course->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md">
        {{-- Course Header --}}
        <div class="bg-blue-600 text-white p-6 rounded-t-lg">
            <h1 class="text-2xl font-bold">{{ $course->title }}</h1>
            <p class="text-blue-100 mt-2">{{ $course->description }}</p>
        </div>

        {{-- Content Management Section --}}
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Course Content</h2>
                <button onclick="openAddContentModal()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Content
                </button>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Content List --}}
            <div class="space-y-4">
                @forelse($course->contents as $content)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($content->type == 'video') bg-red-100 text-red-800
                                        @elseif($content->type == 'document') bg-blue-100 text-blue-800
                                        @elseif($content->type == 'assignment') bg-yellow-100 text-yellow-800
                                        @elseif($content->type == 'quiz') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($content->type) }}
                                    </span>
                                    @if(!$content->is_published)
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Draft
                                        </span>
                                    @endif
                                </div>
                                
                                <h3 class="text-lg font-medium text-gray-900 mb-1">{{ $content->title }}</h3>
                                
                                @if($content->description)
                                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($content->description, 100) }}</p>
                                @endif

                                @if($content->file_path)
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                        {{ $content->file_type ? strtoupper($content->file_type) : 'File' }}
                                        @if($content->file_size)
                                            ({{ number_format($content->file_size / 1024, 1) }} KB)
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center space-x-2 ml-4">
                                <button onclick="editContent({{ $content->id }})" 
                                        class="text-blue-600 hover:text-blue-800 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                
                                <form action="{{ route('teacher.content.destroy', [$course, $content]) }}" 
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this content?')"
                                            class="text-red-600 hover:text-red-800 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p>No content added yet. Click "Add Content" to get started.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Add Content Modal --}}
<div id="addContentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Add New Content</h3>
                    <button onclick="closeAddContentModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('teacher.content.store', $course) }}" method="POST" enctype="multipart/form-data" id="contentForm">
                    @csrf
                    
                    {{-- Content Type --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Content Type</label>
                        <select name="type" id="contentType" onchange="toggleContentFields()" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="lesson">Lesson</option>
                            <option value="video">Video</option>
                            <option value="document">Document</option>
                            <option value="assignment">Assignment</option>
                            <option value="quiz">Quiz</option>
                            <option value="link">External Link</option>
                        </select>
                    </div>

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" name="title" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    {{-- Text Content (for lessons) --}}
                    <div class="mb-4" id="textContentField">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                        <textarea name="content" rows="6"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    {{-- File Upload --}}
                    <div class="mb-4" id="fileUploadField">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Files</label>
                        <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.mp3,.jpg,.png,.zip"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">
                            Accepted formats: PDF, DOC, DOCX, PPT, PPTX, MP4, MP3, JPG, PNG, ZIP (Max 50MB per file)
                        </p>
                    </div>

                    {{-- External Link (for link type) --}}
                    <div class="mb-4 hidden" id="linkField">
                        <label class="block text-sm font-medium text-gray-700 mb-2">External Link URL</label>
                        <input type="url" name="external_link"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Publishing Options --}}
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1" class="mr-2">
                            <span class="text-sm text-gray-700">Publish immediately (students can see this content)</span>
                        </label>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAddContentModal()" 
                                class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Add Content
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openAddContentModal() {
    document.getElementById('addContentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAddContentModal() {
    document.getElementById('addContentModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('contentForm').reset();
    toggleContentFields(); // Reset field visibility
}

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

function editContent(contentId) {
    // You can implement edit functionality here
    alert('Edit functionality - Content ID: ' + contentId);
}

// Close modal when clicking outside
document.getElementById('addContentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddContentModal();
    }
});

// Initialize field visibility on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleContentFields();
});
</script>
@endsection