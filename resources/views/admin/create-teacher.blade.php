<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Teacher - Your Learning Portal</title> {{-- More descriptive title --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

            /* Alert Colors - Adjusted for a softer look */
            --alert-success-bg: #d4edda;
            --alert-success-text: #155724;
            --alert-danger-bg: #f8d7da;
            --alert-danger-text: #721c24;
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
        }

        .alert-success {
            color: var(--alert-success-text);
            background-color: var(--alert-success-bg);
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: var(--alert-danger-text);
            background-color: var(--alert-danger-bg);
            border-color: #f5c6cb;
        }

        /* Card Styling for the form */
        .create-teacher-card {
            background-color: var(--card-bg);
            border-radius: 1rem; /* More rounded corners */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* Stronger, softer shadow */
            padding: 2.5rem; /* Increased padding */
            border: none; /* Remove default card border */
            position: relative;
            overflow: hidden; /* Ensure content stays within rounded corners */
        }

        .create-teacher-card::before { /* Subtle accent line on top of card */
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

        .create-teacher-card h1 {
            color: var(--gunmetal-dark); /* Darker heading */
            font-weight: 800; /* Extra bold for prominence */
            font-size: 2.2rem; /* Larger title */
            margin-bottom: 2rem; /* More space below title */
            text-align: center;
        }

        /* Form Group & Input Styling */
        .form-group label {
            color: var(--dark-text);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block; /* Ensures label takes full width */
        }

        .form-control {
            border-radius: 0.5rem; /* Rounded input fields */
            padding: 0.75rem 1rem; /* More padding */
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
            box-shadow: inset 0 1px 2px rgba(0,0,0,.075); /* Subtle inner shadow */
        }

        .form-control:focus {
            border-color: var(--primary-accent);
            box-shadow: 0 0 0 0.2rem rgba(78, 205, 196, 0.25); /* Accent glow on focus */
            outline: none;
        }

        .text-danger {
            color: var(--alert-danger-text) !important; /* Ensure red for error messages */
            font-size: 0.875rem; /* Smaller font for errors */
            margin-top: 0.25rem;
            display: block; /* Ensure it takes its own line */
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

        .btn-secondary {
            color: var(--light-text) !important;
            border-color: var(--light-text) !important;
            background-color: transparent !important;
        }

        .btn-secondary:hover {
            background-color: var(--light-text) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        /* Specific error message for password mismatch and length*/
        .password-error-message {
            color: var(--alert-danger-text);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9"> {{-- Adjusted column width for form content --}}
                <div class="create-teacher-card">

                    <h1>Add New Teacher</h1>

                    <!-- Success message -->
                    @if (session('success'))
                        <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
                    @endif

                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <h4 class="alert-heading">Validation Errors!</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.store-teacher') }}" method="POST" id="teacherForm">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Name: <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Enter full name" required>
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email: <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="Enter email address" required>
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password: <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter password" required minlength="8"> {{-- Added minlength --}}
                            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                             <div id="passwordLengthError" class="password-error-message" style="display: none;">
                                Password must be at least 8 characters long.
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password: <span class="text-danger">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control"
                                placeholder="Confirm password" required minlength="8"> {{-- Added minlength --}}
                            <div id="passwordMatchError" class="password-error-message" style="display: none;">
                                Passwords do not match.
                            </div>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Add Teacher</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordMatchError = document.getElementById('passwordMatchError');
            const passwordLengthError = document.getElementById('passwordLengthError');
            const teacherForm = document.getElementById('teacherForm');

            function validatePasswords() {
                const password = passwordInput.value;
                const confirmPassword = passwordConfirmationInput.value;
                const minLength = 8; // Consistent with minlength attribute

                // Reset error messages and custom validity
                passwordLengthError.style.display = 'none';
                passwordMatchError.style.display = 'none';
                passwordInput.setCustomValidity('');
                passwordConfirmationInput.setCustomValidity('');

                // Check password length
                if (password.length < minLength && password.length > 0) { // Only show if not empty
                    passwordLengthError.textContent = `Password must be at least ${minLength} characters long.`;
                    passwordLengthError.style.display = 'block';
                    passwordInput.setCustomValidity(`Password must be at least ${minLength} characters long.`);
                    return false;
                }

                // Check password match (only if both are not empty and password meets length)
                if (password.length >= minLength && confirmPassword.length > 0 && confirmPassword !== password) {
                    passwordMatchError.textContent = 'Passwords do not match.';
                    passwordMatchError.style.display = 'block';
                    passwordConfirmationInput.setCustomValidity('Passwords do not match.');
                    return false;
                }
                 if (password.length >= minLength && confirmPassword.length === 0 && passwordInput.hasAttribute('required') ) {
                    // If confirm password is required but empty, let browser default validation handle it on submit
                    // This prevents showing 'passwords do not match' prematurely when user hasn't typed confirm yet
                    passwordConfirmationInput.setCustomValidity('');
                 } else if (password.length >= minLength && confirmPassword.length > 0 && confirmPassword === password) {
                    passwordConfirmationInput.setCustomValidity(''); // Clear if matches
                 }


                // If no errors, clear custom validity (important for form submission)
                return true;
            }

            // Attach event listeners for real-time validation
            passwordInput.addEventListener('input', validatePasswords);
            passwordConfirmationInput.addEventListener('input', validatePasswords);

            // Also validate on form submission to catch any missed cases
            teacherForm.addEventListener('submit', function(event) {
                if (!validatePasswords()) { // Run validation one last time
                    event.preventDefault(); // Prevent form submission if validation fails
                    // Optional: Add more visual feedback for invalid fields if needed
                }
            });
        });
    </script>

    {{-- Bootstrap JS (JQuery and Popper.js are dependencies for some Bootstrap features) --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
