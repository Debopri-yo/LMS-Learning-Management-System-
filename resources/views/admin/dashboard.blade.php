<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Your Learning Portal</title> {{-- More descriptive title --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> {{-- Updated Font Awesome CDN --}}
    <style>
        /* Define your custom color variables for consistency */
        :root {
            --primary-accent: #4ECDC4; /* Robin Egg Blue */
            --primary-accent-hover: #38bfb2; /* Darker Robin Egg Blue for hover */
            --dark-text: #343A40; /* Dark charcoal for main text */
            --light-text: #6C757D; /* Medium gray for descriptions/muted text */
            --gunmetal-dark: #292C36; /* Gunmetal for strong headings/header background */
            --card-bg: white;
            --page-bg: #F8F9FA; /* Very light gray for body background */
        }

        body {
            background-color: var(--page-bg); /* Brighter page background */
            color: var(--dark-text); /* Dark text for readability */
            font-family: 'Inter', sans-serif; /* Recommended font for clarity */
        }

        .header {
            background-color: var(--gunmetal-dark); /* Darker header background */
            padding: 18px 30px; /* Adjusted padding */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .header-title {
            font-size: 1.8rem; /* Adjusted font size */
            font-weight: 700;
            color: var(--primary-accent); /* Accent color for title */
        }

        .logout-btn {
            background-color: transparent; /* Transparent background */
            color: var(--primary-accent); /* Accent color for text */
            border: 1px solid var(--primary-accent); /* Accent border */
            padding: 8px 20px; /* Adjusted padding */
            border-radius: 0.5rem; /* Rounded corners */
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: var(--primary-accent); /* Fill on hover */
            color: var(--gunmetal-dark); /* Dark text on hover */
            border-color: var(--primary-accent);
            transform: translateY(-2px); /* Slight lift */
            box-shadow: 0 4px 8px rgba(78, 205, 196, 0.2);
        }

        .dashboard-card { /* Custom class for dashboard cards */
            background-color: var(--card-bg); /* White background */
            border: 1px solid rgba(78, 205, 196, 0.3); /* Subtle accent border */
            color: var(--dark-text);
            border-radius: 0.75rem; /* More rounded corners */
            text-align: center;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.08); /* Stronger, softer shadow */
            padding: 30px; /* Increased padding */
            transition: all 0.3s ease;
            text-decoration: none; /* Remove underline from link */
            display: block; /* Make the whole card clickable */
            height: 100%; /* Ensure cards in a row have same height */
        }

        .dashboard-card:hover {
            background-color: var(--page-bg); /* Light background on hover */
            border-color: var(--primary-accent); /* Accent border on hover */
            transform: translateY(-5px); /* Lift effect */
            box-shadow: 0px 12px 25px rgba(0, 0, 0, 0.12); /* Enhanced shadow on hover */
        }

        .card-icon {
            font-size: 3.5rem; /* Larger icons */
            color: var(--primary-accent); /* Accent color for icons */
            margin-bottom: 15px; /* Space below icon */
            transition: color 0.3s ease;
        }

        .dashboard-card:hover .card-icon {
            color: var(--primary-accent-hover); /* Darker accent on hover */
        }

        .card-title {
            font-weight: 700; /* Bolder title */
            font-size: 1.25rem; /* Larger title font */
            color: var(--gunmetal-dark); /* Dark title text */
        }

        .footer {
            margin-top: 40px; /* Adjusted margin */
            padding: 20px;
            text-align: center;
            color: var(--light-text); /* Lighter text for footer */
            font-size: 0.9rem;
            background-color: white; /* White footer background */
            border-top: 1px solid #eee; /* Subtle border */
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-title">{{ Auth::user()->name }}'s Dashboard</div> {{-- More explicit title --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>

   <!-- Dashboard Grid -->
<div class="container py-5"> {{-- Added padding top/bottom --}}
    <div class="row justify-content-center"> {{-- Centered grid items --}}

        <!-- Create Course -->
        <div class="col-lg-4 col-md-6 mb-4"> {{-- Responsive column sizing --}}
            <a href="{{ route('admin.create-course') }}" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="card-title">Create New Course</div>
            </a>
        </div>

        <!-- Create Teacher -->
        <div class="col-lg-4 col-md-6 mb-4">
            <a href="{{ route('admin.create-teacher') }}" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="card-title">Add New Teacher</div>
            </a>
        </div>

        <!-- View List of Teachers -->
        <div class="col-lg-4 col-md-6 mb-4">
            <a href="{{ url('admin/teachers') }}" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-title">Manage Teachers</div>
            </a>
        </div>

        {{-- Removed: Create Admin --}}
        {{-- Removed: View Removable Admins --}}

    </div>
</div>

    <!-- Footer -->
    <div class="footer">
        &copy; {{ date('Y') }} Your Learning Portal. All rights reserved.
    </div>

    {{-- Bootstrap JS (JQuery and Popper.js are dependencies for some Bootstrap features) --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
