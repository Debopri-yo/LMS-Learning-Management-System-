<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LMS Sale Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #292B36; /* Gunmetal */
      color: #4ECDC4;
      font-family: Arial, sans-serif;
    }
    .header {
      background-color: #4ECDC4; /* Robin Egg Blue */
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header h1 {
      margin: 0;
      color: #292B36; /* Gunmetal for contrast */
    }
    .auth-buttons {
      display: flex;
      gap: 10px;
    }
    .auth-buttons a {
      text-decoration: none;
      color: #4ECDC4; /* Robin Egg Blue text on buttons */
      background-color: #292B36; /* Gunmetal for button background */
      padding: 8px 15px;
      border-radius: 5px;
      font-weight: bold;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .auth-buttons a:hover {
      background-color: #4ECDC4;
      color: #292B36;
      border: 2px solid #292B36;
    }
    .hero-section {
      text-align: center;
      padding: 60px 20px;
      color: #4ECDC4;
    }
    .carousel img {
      height: 400px;
      object-fit: cover;
    }
  </style>
</head>
<body>
  <!-- Header Section -->
  <header class="header">
  <img 
        src="{{ asset('icons/icons8-education-100.png') }}" 
        alt="LMS Portal Icon" 
        style="height: 50px; width: 50px;"
    >
    <div class="auth-buttons">
      @if (Route::has('login'))
        @auth
        <a href="{{ url('/courses') }}">View Courses</a>
        <a href="{{ url('/dashboard') }}">Dashboard</a>
        @else
          <a href="{{ url('/courses') }}">View Courses</a>
          <a href="{{ route('login') }}">Log in</a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
          @endif
        @endauth
      @endif
    </div>
  </header>

  <!-- Hero Section -->
  <div class="hero-section">
    <h1>All the Courses You Need in One Place</h1>
    <p>Bootstrap Your Career with Quality Courses.</p>
  </div>

  <!-- Carousel Section -->
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
      <img src="{{ asset('images/slides/classroom-2093744.jpg') }}" alt="Slide 1" class="d-block w-100">
      </div>
      <div class="carousel-item">
      <img src="{{ asset('images/slides/pexels-element5-1370295(1).jpg') }}" alt="Slide 1" class="d-block w-100">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
