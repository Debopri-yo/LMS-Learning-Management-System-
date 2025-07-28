@extends('layouts.app') 

@section('content')
<div class="container">
    <h1>{{ $content->title }} @if(!$content->is_published)<span class="badge bg-warning text-dark">Draft</span>@endif</h1>

    <p><strong>Type:</strong> {{ ucfirst($content->type) }}</p>

    @if($content->description)
        <p>{{ $content->description }}</p>
    @endif

    <div class="my-3">
        {!! nl2br(e($content->content)) !!}
    </div>

    @if($content->getFileUrl())
        <div class="mt-4">
            <a href="{{ $content->getFileUrl() }}" target="_blank" class="btn btn-primary">Download File</a>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('teacher.contents.edit', [$course, $content]) }}" class="btn btn-warning">Edit Content</a>
        <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">← Back to Course</a>
    </div>
</div>
@endsection
