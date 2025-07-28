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
        --success-badge: #28a745; /* Standard green for success badge */
        --danger-badge: #dc3545;  /* Standard red for danger badge */
    }

    body {
        background-color: var(--page-bg);
        font-family: 'Inter', sans-serif; /* Recommended font for clarity */
        color: var(--dark-text);
    }

    /* Course Detail Card Styling */
    .course-detail-card {
        background-color: var(--card-bg);
        border-radius: 1rem; /* More rounded corners */
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* Stronger, softer shadow */
        padding: 2.5rem; /* Increased padding */
        border: none; /* Remove default card border */
        position: relative;
        overflow: hidden; /* Ensure content stays within rounded corners */
    }

    .course-detail-card::before { /* Subtle accent line on top of card */
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 8px; /* Thickness of the line */
        background-color: var(--primary-accent);
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .course-detail-card h1 {
        color: var(--gunmetal-dark); /* Darker heading */
        font-weight: 800; /* Extra bold for prominence */
        font-size: 2.5rem; /* Larger title */
        margin-bottom: 0.75rem;
        line-height: 1.2;
    }

    /* Badges Styling */
    .badge {
        font-size: 0.85rem;
        padding: 0.5em 0.8em;
        border-radius: 0.5rem; /* More rounded badges */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em; /* Slightly more spaced out letters */
    }

    .badge.bg-success {
        background-color: var(--success-badge) !important;
        color: white !important;
    }

    .badge.bg-danger {
        background-color: var(--danger-badge) !important;
        color: white !important;
    }

    .badge.bg-info { /* Stream badge with our primary accent tone */
        background-color: var(--primary-accent) !important;
        color: var(--gunmetal-dark) !important; /* Text on accent badge */
    }

    .course-description {
        color: var(--light-text) !important; /* Muted text for description */
        font-size: 1.05rem;
        line-height: 1.6;
        margin-top: 1.5rem;
    }

    /* List Group Styling for Course Details */
    .list-group-flush .list-group-item {
        background-color: transparent; /* Transparent background for flush items */
        border-color: #e9ecef; /* Lighter border for list items */
        padding: 1rem 0;
        display: flex; /* Use flexbox for alignment */
        justify-content: space-between; /* Space out content */
        align-items: center; /* Vertically align items */
    }
    .list-group-flush .list-group-item:first-child {
        border-top: none; /* No top border for the first item */
    }
    .list-group-flush .list-group-item:last-child {
        border-bottom: none; /* No bottom border for the last item */
    }

    .list-group-item strong {
        color: var(--dark-text); /* Ensure strong text is dark */
        font-weight: 700;
        min-width: 130px; /* Give labels consistent width for alignment */
    }

    /* Button Styling */
    .btn {
        padding: 0.75rem 1.75rem; /* More padding for bigger buttons */
        border-radius: 0.75rem; /* More rounded buttons */
        font-weight: 600;
        font-size: 1.05rem; /* Slightly larger font for buttons */
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: var(--primary-accent) !important;
        border-color: var(--primary-accent) !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(78, 205, 196, 0.3); /* Accent shadow */
    }

    .btn-primary:hover {
        background-color: var(--primary-accent-hover) !important;
        border-color: var(--primary-accent-hover) !important;
        transform: translateY(-2px); /* Slight lift on hover */
        box-shadow: 0 6px 12px rgba(78, 205, 196, 0.4); /* Enhanced shadow on hover */
    }

    .btn-outline-secondary {
        color: var(--light-text) !important;
        border-color: var(--light-text) !important;
        background-color: transparent !important;
    }

    .btn-outline-secondary:hover {
        background-color: var(--light-text) !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10"> {{-- Adjusted column width for better visual balance --}}

            <div class="card course-detail-card"> {{-- Applied custom class for styling --}}
                <div class="card-body">

                    <h1 class="mb-3">{{ $course->name }}</h1>

                    <div class="mb-4"> {{-- Increased bottom margin for badges --}}
                        <span class="badge {{ $course->type == 'paid' ? 'bg-danger' : 'bg-success' }}">
                            {{ ucfirst($course->type) }}
                        </span>
                        <span class="badge bg-info ms-2">
                            {{ $course->stream->name ?? 'General' }}
                        </span>
                    </div>

                    <p class="course-description">
                        {{ $course->description }}
                    </p>

                    <hr class="my-4"> {{-- Horizontal rule for visual separation --}}

                    <ul class="list-group list-group-flush mt-4">
                        <li class="list-group-item">
                            <strong>Start Date:</strong>
                            <span>{{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('F j, Y') : 'To be announced' }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>End Date:</strong>
                            <span>{{ $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('F j, Y') : 'To be announced' }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Status:</strong>
                            <span class="{{ $course->is_active ? 'text-success' : 'text-danger' }} font-weight-bold">
                                {{ $course->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <strong>Instructor:</strong>
                            <span>{{ $course->teacher->name ?? 'Not assigned' }}</span>
                        </li>
                    </ul>

                    <div class="mt-5 d-flex flex-wrap gap-3 justify-content-center justify-content-md-start"> {{-- Increased top margin, added flex-wrap, and more gap --}}
                        <a href="#" class="btn btn-primary">Enroll Now</a> {{-- Simplified for this view --}}
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back to Home</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
