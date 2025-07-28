@extends('layouts.app') {{-- Assumes layouts.app provides Tailwind CSS setup --}}

@section('content')

{{-- Custom CSS for this page --}}
<style>
    /* Add any custom styles specific to this form if needed, though Tailwind handles most */
    input[type="file"] {
        padding: 0.5rem; /* Add padding for consistency with other inputs */
        border: 1px solid #d1d5db; /* Light gray border */
        border-radius: 0.375rem; /* rounded-md */
        background-color: #fff; /* White background */
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* Subtle shadow */
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    input[type="file"]:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
        border-color: #20c997; /* Teal-500-like color on focus */
        box-shadow: 0 0 0 3px rgba(32, 201, 151, 0.25); /* Teal-500-like shadow */
    }
</style>

<div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        {{-- Global Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-xl p-8 lg:p-10 border-t-4 border-teal-500"> {{-- Main form card with accent border --}}

            <h1 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">
                Add New Content to: <span class="text-teal-600">{{ $course->name }}</span>
            </h1>

            <form action="{{ route('teacher.courses.contents.store', $course) }}" method="POST" enctype="multipart/form-data" id="contentForm">
                @csrf

                {{-- Title --}}
                <div class="mb-6">
                    <label for="title" class="block text-gray-700 text-sm font-semibold mb-2">Title<span class="text-red-500 ml-1">*</span></label>
                    <input type="text" name="title" id="title"
                           class="form-input w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:ring-teal-500 focus:border-teal-500 sm:text-sm
                                  @error('title') border-red-500 @enderror"
                           value="{{ old('title') }}" placeholder="e.g., Introduction to Algebra" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Content Type --}}
                <div class="mb-6">
                    <label for="type" class="block text-gray-700 text-sm font-semibold mb-2">Content Type<span class="text-red-500 ml-1">*</span></label>
                    <select name="type" id="type"
                            class="form-select w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm
                                   focus:ring-teal-500 focus:border-teal-500 sm:text-sm
                                   @error('type') border-red-500 @enderror" required>
                        <option value="">Select a content type</option>
                        @foreach($contentTypes as $key => $label)
                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Short Description --}}
                <div class="mb-6">
                    <label for="description" class="block text-gray-700 text-sm font-semibold mb-2">Short Description <span class="text-gray-500 text-xs">(optional)</span></label>
                    <textarea name="description" id="description" rows="2"
                              class="form-textarea w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm
                                     focus:ring-teal-500 focus:border-teal-500 sm:text-sm
                                     @error('description') border-red-500 @enderror"
                              placeholder="A brief overview of this content item">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Main Body (conditionally visible) --}}
                <div id="bodyField" class="mb-6 hidden">
                    <label for="body" class="block text-gray-700 text-sm font-semibold mb-2">Main Body (e.g., Lesson Text, Quiz Questions)<span class="text-gray-500 text-xs ml-1">(optional)</span></label>
                    <textarea name="body" id="body" rows="8"
                              class="form-textarea w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm
                                     focus:ring-teal-500 focus:border-teal-500 sm:text-sm
                                     @error('body') border-red-500 @enderror"
                              placeholder="Enter the main content here. For lessons, use plain text or basic Markdown. For quizzes, define questions and options.">{{ old('body') }}</textarea>
                    @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- File Upload (conditionally visible) --}}
                <div id="fileField" class="mb-6 hidden">
                    <label for="file" class="block text-gray-700 text-sm font-semibold mb-2">Attach File (Document/Video)<span class="text-gray-500 text-xs ml-1">(optional, overrides Main Body)</span></label>
                    <input type="file" name="file" id="file"
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-teal-50 file:text-teal-700
                                  hover:file:bg-teal-100
                                  @error('file') border-red-500 @enderror">
                    @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Order --}}
                <div class="mb-6">
                    <label for="order" class="block text-gray-700 text-sm font-semibold mb-2">Display Order<span class="text-red-500 ml-1">*</span></label>
                    <input type="number" name="order" id="order"
                           class="form-input w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:ring-teal-500 focus:border-teal-500 sm:text-sm
                                  @error('order') border-red-500 @enderror"
                           value="{{ old('order') }}" min="1" placeholder="e.g., 1, 2, 3..." **required**>
                    @error('order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Is Published --}}
                <div class="mb-8">
                    <div class="flex items-center">
                        <input type="hidden" name="is_published" value="0"> {{-- Hidden field for unchecked checkbox --}}
                        <input type="checkbox" name="is_published" id="is_published" value="1"
                               class="form-checkbox h-4 w-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500"
                               {{ old('is_published', $content->is_published ?? false) ? 'checked' : '' }}>
                        <label for="is_published" class="ml-2 block text-gray-700 text-sm font-semibold">Published</label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">If unchecked, content will be saved as draft.</p>
                </div>

                {{-- Submit and Cancel Buttons --}}
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('teacher.courses.show', $course) }}"
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 text-base font-medium rounded-lg
                              hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400
                              transition duration-150 ease-in-out">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-white text-base font-medium rounded-lg
                                   bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500
                                   transition duration-150 ease-in-out">
                        Create Content
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contentTypeSelect = document.getElementById('type');
        const bodyField = document.getElementById('bodyField');
        const fileField = document.getElementById('fileField');

        // Function to update field visibility based on content type
        function updateFieldVisibility() {
            const selectedType = contentTypeSelect.value;
            // Hide all by default
            bodyField.classList.add('hidden');
            fileField.classList.add('hidden');

            if (selectedType === 'lesson' || selectedType === 'assignment' || selectedType === 'quiz' || selectedType === 'link') {
                bodyField.classList.remove('hidden');
                // For 'link' type, content typically goes into the 'body' field (which acts as 'content' here)
            }
            if (selectedType === 'document' || selectedType === 'video') {
                fileField.classList.remove('hidden');
            }
        }

        // Initial call on page load
        updateFieldVisibility();

        // Listen for changes on the content type select
        contentTypeSelect.addEventListener('change', updateFieldVisibility);
    });
</script>

@endsection