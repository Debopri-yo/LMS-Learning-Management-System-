@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $course->title }}</h1>
    <p>{{ $course->description }}</p>

    <hr>

    <h3>Course Contents</h3>

    @if($contents->count())
        <ul class="list-group mb-4">
            @foreach($contents as $content)
                <li class="list-group-item">
                    <h5>{{ $content->title }} ({{ ucfirst($content->type) }})</h5>
                    <p>{{ $content->description }}</p>

                    @if($content->file_path)
                        <p><a href="{{ asset('storage/' . $content->file_path) }}" target="_blank">Download/View File</a></p>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ route('teacher.contents.preview', [$course, $content]) }}" class="btn btn-primary btn-sm">Preview</a>
                        <a href="{{ route('teacher.contents.edit', [$course, $content]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('teacher.contents.destroy', [$course, $content]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this content?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>

        {{ $contents->links() }} {{-- Pagination --}}
    @else
        <p>No contents added yet for this course.</p>
    @endif

    <a href="{{ route('teacher.courses.contents.create', $course) }}" class="btn btn-success">Add New Content</a>
</div>
@endsection

