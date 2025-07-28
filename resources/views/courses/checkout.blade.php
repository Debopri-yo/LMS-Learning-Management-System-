@extends('layouts.app') {{-- Assumes layouts.app includes your basic HTML structure and Bootstrap CSS --}}

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
        --success-btn: #28a745; /* Standard green for success */
        --success-btn-hover: #218838; /* Darker green for success hover */
    }

    body {
        background-color: var(--page-bg);
        font-family: 'Inter', sans-serif; /* Recommended font for clarity */
        color: var(--dark-text);
    }

    .checkout-card {
        background-color: var(--card-bg);
        border-radius: 1rem; /* More rounded corners */
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* Stronger, softer shadow */
        padding: 3.5rem 2.5rem; /* Increased padding for spacious feel */
        border: none; /* Remove default card border */
        position: relative;
        overflow: hidden; /* Ensure content stays within rounded corners */
        max-width: 600px; /* Max width for readability and focus */
        margin: auto; /* Center the card */
        border-top: 8px solid var(--primary-accent); /* Prominent accent border on top */
    }

    .checkout-card h2 {
        color: var(--gunmetal-dark); /* Dark heading color */
        font-weight: 800; /* Extra bold */
        font-size: 2.5rem; /* Larger title */
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .checkout-card .lead {
        color: var(--light-text) !important; /* Muted text for lead paragraph */
        font-size: 1.25rem; /* Slightly larger lead text */
        font-weight: 500;
        margin-bottom: 2.5rem; /* More space before the form */
    }

    .btn {
        padding: 0.85rem 2.25rem; /* Larger padding for all buttons */
        border-radius: 0.75rem; /* More rounded buttons */
        font-weight: 600;
        font-size: 1.1rem; /* Slightly larger font for buttons */
        transition: all 0.3s ease;
    }

    .btn-success {
        background-color: var(--primary-accent) !important; /* Use Robin Egg Blue for Confirm */
        border-color: var(--primary-accent) !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(78, 205, 196, 0.3); /* Accent shadow */
    }

    .btn-success:hover {
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
        <div class="col-12">
            <div class="checkout-card text-center"> {{-- Apply custom card style and center text --}}
                <h2 class="mb-3">Checkout: {{ $course->name }}</h2>
                <p class="lead">Your total for this course is: <span class="text-success font-weight-bold">₹{{ number_format($course->price) }}</span></p>

                <form action="{{ route('courses.pay', $course->id) }}" method="POST" class="mt-5"> {{-- More margin-top for form --}}
                    @csrf
                    <button type="submit" class="btn btn-success mr-3">Confirm Payment</button> {{-- Add margin-right --}}
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection