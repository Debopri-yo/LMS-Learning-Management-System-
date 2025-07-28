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
        --gunmetal-dark: #292C36; /* Gunmetal for strong elements (e.g., main heading) */
        --card-bg: white;
        --page-bg: #F8F9FA; /* Very light gray for body background */

        /* Alert Colors - Adjusted for a softer look */
        --alert-success-bg: #d4edda;
        --alert-success-text: #155724;
        --alert-info-bg: #d1ecf1;
        --alert-info-text: #0c5460;
    }

    body {
        background-color: var(--page-bg);
        font-family: 'Inter', sans-serif; /* Recommended font for clarity */
        color: var(--dark-text);
    }

    /* Alert Styling */
    .alert {
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid transparent;
        border-radius: .5rem; /* Slightly more rounded */
        font-size: 1rem;
        opacity: 0; /* Start hidden */
        transform: translateY(-20px); /* Start slightly above */
        animation: fadeInDown 0.5s forwards; /* Animation */
    }

    .alert-success {
        color: var(--alert-success-text);
        background-color: var(--alert-success-bg);
        border-color: #c3e6cb;
    }

    .alert-info {
        color: var(--alert-info-text);
        background-color: var(--alert-info-bg);
        border-color: #bee5eb;
    }

    @keyframes fadeInDown {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Styling */
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
    }

    .badge.bg-success { /* Adjusting Bootstrap success for a brighter look */
        background-color: #28a745 !important;
        color: white !important;
    }

    .badge.bg-danger { /* Adjusting Bootstrap danger for a brighter look */
        background-color: #dc3545 !important;
        color: white !important;
    }

    .badge.bg-info { /* Stream badge with an accent tone */
        background-color: var(--primary-accent) !important;
        color: var(--gunmetal-dark) !important; /* Text on accent badge */
    }


    .course-description {
        color: var(--light-text) !important; /* Muted text for description */
        font-size: 1.05rem;
        line-height: 1.6;
        margin-top: 1.5rem;
    }

    /* List Group Styling */
    .list-group-flush .list-group-item {
        background-color: transparent; /* Transparent background for flush items */
        border-color: #e9ecef; /* Lighter border for list items */
        padding: 1rem 0;
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
        min-width: 120px; /* Align text better */
        display: inline-block;
    }

    /* Button Styling */
    .btn {
        padding: 0.75rem 1.5rem; /* More padding for bigger buttons */
        border-radius: 0.75rem; /* More rounded buttons */
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: var(--primary-accent) !important;
        border-color: var(--primary-accent) !important;
        color: white !important;
    }

    .btn-primary:hover {
        background-color: var(--primary-accent-hover) !important;
        border-color: var(--primary-accent-hover) !important;
        transform: translateY(-2px); /* Slight lift on hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-success[disabled] {
        background-color: #28a745 !important; /* Keep original Bootstrap success color */
        border-color: #28a745 !important;
        opacity: 0.7;
        cursor: not-allowed;
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

    /* Flex utilities for gap */
    .d-flex.gap-2 > *:not(:last-child) {
        margin-right: 0.5rem; /* Bootstrap's built-in gap for flexbox */
    }
</style>

<div class="container py-5">
    {{-- Session Alerts --}}
    @if (session('success'))
    <div class="alert alert-success text-center" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if (session('info'))
    <div class="alert alert-info text-center" role="alert">
        {{ session('info') }}
    </div>
    @endif
    {{-- Add this button where you want it --}}
<div class="text-center my-4">
    @if ($course->type == 'free' || (auth()->check() && auth()->user()->enrollments()->where('course_id', $course->id)->exists()))
        <a href="{{ url('courses/' . $course->id . '/contents') }}" class="btn btn-outline-primary">
            📚 View All Contents for This Course
        </a>
    @else
        <button class="btn btn-outline-secondary" style="opacity: 0.5; cursor: not-allowed;" disabled>
            🔒 Enroll to Access Contents
        </button>
    @endif
</div>



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

                    <p class="course-description mt-3">
                        {{ $course->description }}
                    </p>

                    <hr class="my-4"> {{-- Horizontal rule for visual separation --}}

                    <ul class="list-group list-group-flush mt-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Start Date:</strong>
                            <span>{{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('F j, Y') : 'To be announced' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>End Date:</strong>
                            <span>{{ $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('F j, Y') : 'To be announced' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Status:</strong>
                            <span class="{{ $course->is_active ? 'text-success' : 'text-danger' }} font-weight-bold"> {{-- Added font-weight-bold --}}
                                {{ $course->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Instructor:</strong>
                            <span>{{ $course->teacher->name ?? 'Not assigned' }}</span>
                        </li>

                        @if ($course->type == 'paid' && $course->price)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Price:</strong>
                            <span class="h5 mb-0 text-success">₹{{ number_format($course->price) }}</span> {{-- Highlight price --}}
                        </li>
                        @endif
                    </ul>

                    <div class="mt-5 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start"> {{-- Increased top margin, added flex-wrap for small screens, and centered for mobiles --}}
                        @if ($course->type == 'paid')
                            @auth
                                @if (!auth()->user()->enrollments()->where('course_id', $course->id)->exists())
                                    <a href="{{ route('courses.checkout', $course->id) }}" class="btn btn-primary">Enroll Now (₹{{ number_format($course->price) }})</a>
                                @else
                                    <button class="btn btn-success" disabled>Enrolled</button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Login to Enroll</a>
                            @endauth
                        @endif

                        @if ($course->type == 'free')
                            @auth
                                @if (!auth()->user()->enrollments()->where('course_id', $course->id)->exists())
                                    <form action="{{ route('enroll.course', $course->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Enroll Now</button>
                                    </form>
                                @else
                                    <button class="btn btn-success" disabled>Enrolled</button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Login to Enroll</a>
                            @endauth
                        @endif

                        <a href="/" class="btn btn-outline-secondary">Back to Home</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
```