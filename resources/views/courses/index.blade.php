<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Your Learning Platform</title> {{-- Added a more descriptive title --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Define your custom color variables for easier management */
        :root {
            --primary-accent: #4ECDC4; /* Robin Egg Blue */
            --dark-background: #292C36; /* Gunmetal - corrected from G to C */
            --light-background: #F8F9FA; /* Very light gray for body */
            --text-dark: #343A40; /* Dark charcoal for main text */
            --text-light: #6C757D; /* Medium gray for descriptions */
            --hover-accent: #38bfb2; /* Darker Robin Egg Blue for hover */
        }

        body {
            background-color: var(--light-background); /* Brighter body background */
            color: var(--text-dark); /* Darker text for readability */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Slightly more modern font stack */
        }

        .header {
            background-color: var(--dark-background); /* Darker header for contrast */
            padding: 15px 30px; /* More padding for a spacious feel */
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        .header .brand-logo {
            height: 45px; /* Adjust logo size */
            width: 45px;
            margin-right: 10px;
        }

        .header .brand-name {
            color: var(--primary-accent); /* Robin Egg Blue for brand name */
            font-size: 1.8rem; /* Larger font size */
            font-weight: 700; /* Bold */
            margin-right: 30px;
            text-decoration: none; /* Remove underline from link */
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px; /* Space between input and button */
        }

        .search-input {
            border: 1px solid var(--primary-accent); /* Border matches accent */
            border-radius: 25px; /* Pill shape for modern look */
            padding: 8px 20px;
            width: 300px; /* Slightly wider input */
            font-size: 0.95rem;
            color: var(--text-dark);
            background-color: white; /* White background for input */
            transition: all 0.3s ease;
        }
        .search-input::placeholder {
            color: var(--text-light); /* Lighter placeholder text */
        }
        .search-input:focus {
            border-color: var(--hover-accent); /* Darker accent on focus */
            box-shadow: 0 0 0 0.2rem rgba(78, 205, 196, 0.25); /* Subtle glow */
        }

        .search-button {
            background-color: var(--primary-accent); /* Robin Egg Blue button */
            color: var(--dark-background); /* Gunmetal text on button */
            border: none;
            padding: 8px 20px;
            border-radius: 25px; /* Pill shape */
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-button:hover {
            background-color: var(--hover-accent); /* Darker accent on hover */
        }

        .container {
            margin-top: 40px; /* Adjusted top margin */
            margin-bottom: 50px; /* Add bottom margin for spacing */
        }

        h2 {
            color: var(--dark-background); /* Darker heading for contrast */
            font-weight: 700;
            margin-bottom: 30px; /* More space below heading */
        }

        .card {
            border-radius: 12px; /* Slightly more rounded corners */
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.08); /* More pronounced shadow for depth */
            border: 1px solid var(--primary-accent); /* Border with accent color */
            background-color: white; /* White card background for clarity */
            overflow: hidden; /* Ensures content stays within rounded corners */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth hover effect */
        }

        .card:hover {
            transform: translateY(-5px); /* Lift card on hover */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.12); /* Enhanced shadow on hover */
        }

        .card-body {
            padding: 25px; /* More padding inside card */
        }

        .card-title {
            font-weight: 700; /* Bolder title */
            color: var(--primary-accent); /* Robin Egg Blue title */
            font-size: 1.35rem; /* Slightly larger title */
            margin-bottom: 15px; /* Space below title */
        }

        .card-text {
            color: var(--text-light); /* Lighter gray for descriptions */
            line-height: 1.6; /* Better line spacing for readability */
            margin-bottom: 12px;
            font-size: 0.95rem;
        }
        .card-text strong {
            color: var(--text-dark); /* Ensure strong text is dark */
        }

        .btn-primary {
            background-color: var(--primary-accent); /* Robin Egg Blue button */
            border-color: var(--primary-accent);
            padding: 10px 20px;
            border-radius: 8px; /* Slightly rounded button */
            font-weight: 600;
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--hover-accent); /* Darker shade on hover */
            border-color: var(--hover-accent);
            transform: translateY(-2px); /* Slight lift on hover */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="d-flex align-items-center">
            <img
                src="{{ asset('icons/icons8-education-100.png') }}"
                alt="LMS Portal Icon"
                class="brand-logo"
            >
            <a href="#" class="brand-name">Your Learning Portal</a> {{-- Added a brand name/site title --}}
        </div>
        <div class="search-bar">
            <form action="{{ route('courses.search') }}" method="GET" class="d-flex">
                <input
                    type="text"
                    name="query"
                    class="search-input"
                    placeholder="Search for courses..."
                    value="{{ request()->input('query') }}"
                >
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h2 class="text-center">Available Courses</h2> {{-- More descriptive heading --}}
        <div class="row">
            @forelse ($courses as $course) {{-- Changed to forelse for no courses message --}}
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column"> {{-- Added flex-column for consistent card height --}}
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <p class="card-text flex-grow-1">{{ $course->description }}</p> {{-- flex-grow-1 pushes button to bottom --}}
                        <p class="card-text small text-muted mb-3"> {{-- Smaller and muted for dates --}}
                            <strong>Start:</strong> {{ \Carbon\Carbon::parse($course->start_date)->format('F j, Y') }}<br>
                            <strong>End:</strong> {{ \Carbon\Carbon::parse($course->end_date)->format('F j, Y') }}
                        </p>
                        <a href="{{ route('course.show', $course->id) }}" class="btn btn-primary mt-auto" target="_blank" rel="noopener noreferrer"> {{-- mt-auto pushes button to bottom --}}
                            View Course
                        </a>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="lead text-muted">No courses found at the moment. Please check back later!</p>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>