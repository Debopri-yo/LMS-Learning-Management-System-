@extends('layouts.app')

@section('content')

{{-- Custom CSS for this page --}}
<style>
    /* Define your custom color variables for consistency */
    :root {
        --primary-accent: #4ECDC4; /* Robin Egg Blue */
        --primary-accent-hover: #38bfb2; /* Darker Robin Egg Blue for hover */
        --dark-text: #343A40; /* Dark charcoal for main text */
        --light-text: #6C757D; /* Medium gray for descriptions/muted text */
        --gunmetal-dark: #292C36; /* Gunmetal for strong headings */
        --card-bg: white;
        --page-bg: #F8F9FA; /* Very light gray for body background */

        /* Alert Colors */
        --alert-info-bg: #d1ecf1;
        --alert-info-text: #0c5460;
        --alert-info-border: #bee5eb;
    }

    body {
        background-color: var(--page-bg);
        font-family: 'Inter', sans-serif; /* Recommended font for clarity */
        color: var(--dark-text);
    }

    /* Page Heading */
    h2 {
        color: var(--gunmetal-dark); /* Darker heading */
        font-weight: 800; /* Extra bold */
        font-size: 2.2rem; /* Larger title */
        margin-bottom: 2rem; /* More space below heading */
        text-align: center;
    }

    /* Alert Styling */
    .alert-info {
        color: var(--alert-info-text);
        background-color: var(--alert-info-bg);
        border-color: var(--alert-info-border);
        padding: 1.5rem; /* More padding */
        border-radius: 0.75rem; /* Rounded corners */
        font-size: 1.1rem;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); /* Subtle shadow */
    }

    /* Course Card Styling (consistent with other improved cards) */
    .course-card-item { /* Custom class for these course cards */
        background-color: var(--card-bg); /* White background */
        border: 1px solid rgba(78, 205, 196, 0.3); /* Subtle accent border */
        color: var(--dark-text);
        border-radius: 0.75rem; /* More rounded corners */
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.08); /* Stronger, softer shadow */
        padding: 25px; /* Increased padding */
        transition: all 0.3s ease;
        display: flex; /* Use flex for internal alignment */
        flex-direction: column;
        justify-content: space-between; /* Push button to bottom */
        height: 100%; /* Ensure cards in a row have same height */
    }

    .course-card-item:hover {
        background-color: var(--page-bg); /* Light background on hover */
        border-color: var(--primary-accent); /* Accent border on hover */
        transform: translateY(-5px); /* Lift effect */
        box-shadow: 0px 12px 25px rgba(0, 0, 0, 0.12); /* Enhanced shadow on hover */
    }

    .card-title {
        font-weight: 700; /* Bolder title */
        font-size: 1.4rem; /* Larger title font */
        color: var(--gunmetal-dark); /* Dark title text */
        margin-bottom: 1rem; /* More space below title */
        line-height: 1.3;
    }

    .course-card-item .text-muted {
        color: var(--light-text) !important; /* Muted text for instructor */
        font-size: 0.95rem;
        margin-bottom: 1.5rem; /* Space before button */
    }

    /* Button Styling */
    .btn-primary {
        background-color: var(--primary-accent) !important;
        border-color: var(--primary-accent) !important;
        color: white !important;
        padding: 0.75rem 1.75rem; /* Larger padding for buttons */
        border-radius: 0.75rem; /* More rounded buttons */
        font-weight: 600;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(78, 205, 196, 0.3); /* Accent shadow */
    }

    .btn-primary:hover {
        background-color: var(--primary-accent-hover) !important;
        border-color: var(--primary-accent-hover) !important;
        transform: translateY(-2px); /* Slight lift on hover */
        box-shadow: 0 6px 12px rgba(78, 205, 196, 0.4); /* Enhanced shadow on hover */
    }
</style>

<div class="container py-5">
    <h2>My Courses</h2>

    @if($courses->isEmpty())
        <div class="alert alert-info" role="alert">
            <p class="mb-0">You are not currently enrolled in any courses. Explore our <a href="{{ url('/courses') }}" class="alert-link">course catalog</a> to get started!</p>
        </div>
    @else
        <div class="row">
            @foreach($courses as $course)
                <div class="col-lg-4 col-md-6 mb-4"> {{-- Responsive columns for layout --}}
                    <div class="card course-card-item"> {{-- Applying custom card style --}}
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->name }}</h5>
                            <p class="text-muted">
                                Instructor: {{ $course->teacher->name ?? 'To be announced' }}
                            </p>
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary mt-auto">View Course</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
