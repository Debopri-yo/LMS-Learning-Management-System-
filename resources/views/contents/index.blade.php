@extends('layouts.app') {{-- Assumes layouts.app includes your basic HTML structure and Bootstrap CSS --}}

@section('content')
<div class="bg-light min-h-screen py-5"> {{-- Changed to bg-light for a brighter background --}}
    <div class="container py-4">
        {{-- Custom CSS for this page --}}
        <style>
            /* Define your custom color variables for consistency */
            :root {
                --primary-accent: #4ECDC4; /* Robin Egg Blue */
                --dark-text: #343A40; /* Dark charcoal for main text */
                --light-text: #6C757D; /* Medium gray for descriptions/muted text */
                --gunmetal-dark: #292C36; /* Gunmetal for strong elements */
                --hover-accent: #38bfb2; /* Darker Robin Egg Blue for hover */
            }

            body {
                font-family: 'Inter', sans-serif; /* Recommended font for clarity */
                color: var(--dark-text);
            }

            .course-header {
                background-color: white; /* White background for the main info block */
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08); /* Subtle shadow */
                margin-bottom: 40px;
                border-top: 5px solid var(--primary-accent); /* Accent border on top */
            }

            .course-header h1 {
                color: var(--gunmetal-dark); /* Darker heading */
                font-weight: 700;
                font-size: 2.5rem; /* Larger title */
                margin-bottom: 10px;
            }

            .course-header .text-muted {
                color: var(--light-text) !important; /* Ensure muted text is the defined lighter gray */
                font-size: 1.1rem;
                line-height: 1.6;
            }

            .content-list-section h3 {
                color: var(--primary-accent); /* Accent color for section title */
                font-weight: 600;
                margin-bottom: 25px;
                padding-bottom: 10px;
                border-bottom: 2px solid rgba(78, 205, 196, 0.3); /* Lighter accent border */
                font-size: 1.8rem;
            }

            .list-group-item {
                background-color: white; /* White background for each content item */
                border: 1px solid rgba(0, 0, 0, 0.08); /* Lighter border */
                border-radius: 10px; /* Rounded corners for list items */
                margin-bottom: 15px; /* Space between items */
                padding: 20px;
                transition: all 0.3s ease; /* Smooth transition for hover */
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .list-group-item:hover {
                transform: translateY(-3px); /* Lift on hover */
                box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1); /* Enhanced shadow on hover */
            }

            .list-group-item h5 {
                font-weight: 600;
                color: var(--dark-text); /* Darker text for title */
                font-size: 1.25rem;
                margin-bottom: 8px;
            }

            .list-group-item .content-type {
                font-size: 0.9rem;
                color: var(--primary-accent); /* Accent color for type */
                font-weight: 500;
                margin-left: 10px;
                background-color: rgba(78, 205, 196, 0.1); /* Light background for type tag */
                padding: 4px 8px;
                border-radius: 5px;
            }

            .list-group-item .btn {
                margin-top: 15px; /* Space above buttons */
                margin-right: 10px; /* Space between buttons */
                padding: 8px 18px;
                border-radius: 8px; /* Rounded buttons */
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-outline-primary {
                color: var(--primary-accent);
                border-color: var(--primary-accent);
                background-color: transparent;
            }

            .btn-outline-primary:hover {
                background-color: var(--primary-accent);
                color: white;
                border-color: var(--primary-accent);
            }

            .btn-secondary {
                background-color: var(--light-text);
                border-color: var(--light-text);
                color: white;
                padding: 10px 25px;
                border-radius: 8px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-secondary:hover {
                background-color: #5a6268; /* Darker gray on hover */
                border-color: #5a6268;
            }

            /* Pagination styling */
            .pagination .page-item .page-link {
                color: var(--primary-accent);
                border: 1px solid var(--primary-accent);
                border-radius: 5px;
                margin: 0 3px;
                transition: all 0.3s ease;
            }

            .pagination .page-item.active .page-link {
                background-color: var(--primary-accent);
                border-color: var(--primary-accent);
                color: white;
            }

            .pagination .page-item .page-link:hover {
                background-color: var(--hover-accent);
                border-color: var(--hover-accent);
                color: white;
            }

            .pagination .page-item.disabled .page-link {
                color: var(--light-text);
                border-color: #dee2e6;
            }
        </style>

        {{-- Course Details Header --}}
        <div class="course-header text-center">
            <h1>{{ $course->name }}</h1>
            <p class="text-muted">{{ $course->description }}</p>
        </div>

        {{-- Course Contents Section --}}
        <div class="content-list-section mt-5">
            <h3 class="mb-4">Course Contents</h3>

            @if ($contents->count())
                <ul class="list-group">
                    @foreach ($contents as $content)
                        <li class="list-group-item d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                            <div class="mb-3 mb-md-0">
                                <h5>
                                    {{ $content->title }}
                                    <span class="content-type">{{ ucfirst($content->type) }}</span>
                                </h5>
                            </div>
                            <div class="content-actions d-flex flex-wrap justify-content-center justify-content-md-end">
                                <a href="{{ route('content.show', [$course, $content]) }}" class="btn btn-outline-primary">View Content</a>
                                @if ($content->file_path)
                                    <a href="{{ asset('storage/' . $content->file_path) }}" target="_blank" class="btn btn-outline-primary">Download/View File</a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="d-flex justify-content-center mt-4">
                    {{ $contents->links() }} {{-- Pagination --}}
                </div>
            @else
                <div class="alert alert-info text-center py-4 rounded-lg shadow-sm" role="alert">
                    <p class="mb-0">No contents available yet for this course. Please check back later!</p>
                </div>
            @endif
        </div>

        {{-- Back Button --}}
        <div class="text-center mt-5">
            <a href="{{ route('courses.index') }}" class="btn btn-secondary">← Back to All Courses</a>
        </div>
    </div>
</div>
@endsection