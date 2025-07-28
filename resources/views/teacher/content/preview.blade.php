@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $content->title }}</h1>
    <p><strong>Type:</strong> {{ ucfirst($content->type) }}</p>

    @if($content->description)
        <p>{{ $content->description }}</p>
    @endif

    <hr>

    {{-- Display content based on type --}}
    @if($content->type === 'lesson' || $content->type === 'assignment' || $content->type === 'quiz')
        {!! nl2br(e($content->body ?? $content->content)) !!}
    
    @elseif($content->type === 'video' && $content->file_path)
        <video width="640" controls>
            <source src="{{ asset('storage/' . $content->file_path) }}" type="{{ $content->file_type }}">
            Your browser does not support the video tag.
        </video>

    @elseif($content->type === 'document' && $content->file_path)
        <a href="{{ asset('storage/' . $content->file_path) }}" target="_blank" class="btn btn-primary">
            View Document
        </a>

    @elseif($content->type === 'link' && $content->content)
        <a href="{{ $content->content }}" target="_blank" class="btn btn-primary">
            Visit External Link
        </a>

    @else
        <p>No preview available for this content.</p>
    @endif

    <hr>

    <a href="{{ route('teacher.courses.show', $course) }}" class="btn btn-secondary">Back to Course</a>
</div>
@endsection

