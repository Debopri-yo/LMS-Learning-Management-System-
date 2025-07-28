<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Dashboard - Your Learning Portal</title>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<style>

:root {

--primary-accent: #4ECDC4;

--primary-accent-hover: #38bfb2;

--dark-text: #343A40;

--light-text: #6C757D;

--gunmetal-dark: #292C36;

--card-bg: white;

--page-bg: #F8F9FA;

}


body {

background-color: var(--page-bg);

color: var(--dark-text);

font-family: 'Inter', sans-serif;

}


.header {

background-color: var(--gunmetal-dark);

padding: 18px 30px;

display: flex;

justify-content: space-between;

align-items: center;

box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

}


.header-title {

font-size: 1.8rem;

font-weight: 700;

color: var(--primary-accent);

}


.header-actions {

display: flex;

align-items: center;

gap: 15px;

}


.notification-btn {

position: relative;

color: var(--primary-accent);

font-size: 1.4rem;

text-decoration: none;

}


.notification-badge {

position: absolute;

top: -8px;

right: -10px;

background-color: red;

color: #fff;

border-radius: 50%;

padding: 2px 7px;

font-size: 0.75rem;

font-weight: 600;

}


.logout-btn {

background-color: transparent;

color: var(--primary-accent);

border: 1px solid var(--primary-accent);

padding: 8px 20px;

border-radius: 0.5rem;

font-size: 0.95rem;

font-weight: 600;

transition: all 0.3s ease;

}


.logout-btn:hover {

background-color: var(--primary-accent);

color: var(--gunmetal-dark);

border-color: var(--primary-accent);

transform: translateY(-2px);

box-shadow: 0 4px 8px rgba(78, 205, 196, 0.2);

}


.browse-courses-btn {

background-color: var(--primary-accent) !important;

border-color: var(--primary-accent) !important;

color: white !important;

padding: 1rem 2.5rem;

font-size: 1.25rem;

border-radius: 0.75rem;

font-weight: 700;

box-shadow: 0 6px 15px rgba(78, 205, 196, 0.35);

transition: all 0.3s ease;

}


.browse-courses-btn:hover {

background-color: var(--primary-accent-hover) !important;

border-color: var(--primary-accent-hover) !important;

transform: translateY(-3px);

box-shadow: 0 8px 20px rgba(78, 205, 196, 0.45);

}


.dashboard-card {

background-color: var(--card-bg);

border: 1px solid rgba(78, 205, 196, 0.3);

color: var(--dark-text);

border-radius: 0.75rem;

text-align: center;

box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.08);

padding: 30px;

transition: all 0.3s ease;

text-decoration: none;

display: flex;

flex-direction: column;

justify-content: center;

align-items: center;

height: 100%;

}


.dashboard-card:hover {

background-color: var(--page-bg);

border-color: var(--primary-accent);

transform: translateY(-5px);

box-shadow: 0px 12px 25px rgba(0, 0, 0, 0.12);

}


.card-icon {

font-size: 3.5rem;

color: var(--primary-accent);

margin-bottom: 15px;

transition: color 0.3s ease;

}


.dashboard-card:hover .card-icon {

color: var(--primary-accent-hover);

}


.card-title {

font-weight: 700;

font-size: 1.25rem;

color: var(--gunmetal-dark);

line-height: 1.3;

}


.footer {

margin-top: 40px;

padding: 20px;

text-align: center;

color: var(--light-text);

font-size: 0.9rem;

background-color: white;

border-top: 1px solid #eee;

}

</style>

</head>

<body>


<!-- Header -->

<div class="header">

<div class="header-title">Welcome, {{ Auth::user()->name }}!</div>

<div class="header-actions">


 


{{-- Logout Form --}}

<form action="{{ route('logout') }}" method="POST">

@csrf

<button type="submit" class="logout-btn">Log Out</button>

</form>

</div>

</div>


<!-- Browse Courses Button -->

<div class="container mt-5 text-center">

<a href="{{ url('/courses') }}" class="btn browse-courses-btn">

<i class="fas fa-search mr-2"></i> Browse All Courses

</a>

</div>


<!-- Dashboard Grid -->

<div class="container py-5">

<div class="row justify-content-center">


<div class="col-lg-4 col-md-6 mb-4">

<a href="{{ route('my-courses') }}" class="dashboard-card">

<div class="card-icon">

<i class="fas fa-book-open"></i>

</div>

<div class="card-title">My Courses</div>

</a>

</div>



<div class="col-lg-4 col-md-6 mb-4">

<a href="{{ route('notifications.index') }}" class="btn btn-primary position-relative">

Notifications

@if (auth()->user()->unreadNotifications->count())

<span class="badge badge-danger position-absolute top-0 start-100 translate-middle">

{{ auth()->user()->unreadNotifications->count() }}

</span>

@endif

</a>


</div>


</div>

</div>


<div class="footer">

&copy; {{ date('Y') }} Your Learning Portal. All rights reserved.

</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

