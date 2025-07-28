@extends('layouts.app') {{-- Assumes layouts.app includes your basic HTML structure and Tailwind CSS --}}

@section('content')
<div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-xl p-8 lg:p-10">

        {{-- Content Title --}}
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2 border-b-2 border-teal-400 pb-3">
            {{ $content->title }}
        </h1>

        {{-- NEW: Description Section --}}
        @if($content->description)
            <p class="text-gray-600 text-lg italic mb-6">
                {{ $content->description }}
            </p>
        @endif

        {{-- Main Content Display Area --}}
        <div class="prose max-w-none text-gray-800 leading-relaxed text-lg mb-8">
            @if ($content->type === 'lesson' || $content->type === 'assignment' || $content->type === 'quiz')
                {!! Str::markdown(nl2br(e($content->body))) !!}
            @elseif ($content->type === 'document')
                <div class="flex items-center justify-center p-6 bg-blue-50 border border-blue-200 rounded-lg text-blue-700">
                    <svg class="w-8 h-8 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                    <a href="{{ asset('storage/' . $content->file_path) }}"
                       class="font-semibold hover:underline text-blue-700"
                       target="_blank" rel="noopener noreferrer">
                        Download: {{ pathinfo($content->file_path, PATHINFO_BASENAME) }}
                    </a>
                </div>
            @elseif ($content->type === 'video')
                <div class="aspect-w-16 aspect-h-9 bg-gray-900 rounded-lg overflow-hidden">
                    <video controls class="w-full h-full object-cover">
                        <source src="{{ asset('storage/' . $content->file_path) }}" type="{{ $content->file_type }}">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <p class="text-sm text-gray-600 mt-2 text-center">Video content for this lesson.</p>
            @elseif ($content->type === 'link')
                <div class="flex items-center justify-center p-6 bg-green-50 border border-green-200 rounded-lg text-green-700">
                    <svg class="w-8 h-8 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 005.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 01-2.828 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ $content->content }}"
                       class="font-semibold hover:underline text-green-700"
                       target="_blank" rel="noopener noreferrer">
                       Go to External Link: {{ Str::limit($content->content, 60) }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-200">
            @if ($previousContent)
                <a href="{{ route('content.show', ['course' => $course->id, 'content' => $previousContent->id]) }}"
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 text-base font-medium rounded-lg
                          hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400
                          transition duration-150 ease-in-out">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Previous
                </a>
            @else
                <div class="invisible"></div>
            @endif

            @if ($nextContent)
                <a href="{{ route('content.show', ['course' => $course->id, 'content' => $nextContent->id]) }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent text-white text-base font-medium rounded-lg
                          bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500
                          transition duration-150 ease-in-out">
                    Next
                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
