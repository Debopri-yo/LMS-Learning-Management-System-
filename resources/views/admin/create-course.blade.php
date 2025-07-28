<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Course - Your Learning Portal</title> {{-- More descriptive title --}}
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
        .create-course-card {
            background-color: var(--card-bg);
            border-radius: 1rem; /* More rounded corners */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* Stronger, softer shadow */
            padding: 2.5rem; /* Increased padding */
            border: none; /* Remove default card border */
            position: relative;
            overflow: hidden; /* Ensure content stays within rounded corners */
        }

        .create-course-card::before { /* Subtle accent line on top of card */
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

        .create-course-card h1 {
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

        textarea.form-control {
            min-height: 100px; /* Minimum height for textareas */
            resize: vertical; /* Allow vertical resizing */
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

        /* Specific date error styling */
        .date-error-message {
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
            <div class="col-lg-8 col-md-10">
                <div class="create-course-card">

                    <h1>Create a New Course</h1>

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

                    <form action="{{ route('admin.store-course') }}" method="POST">
                        @csrf

                        <!-- Course Name -->
                        <div class="form-group">
                            <label for="name">Course Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                            @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Course Type -->
                        <div class="form-group">
                            <label for="type">Course Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Select Course Type</option>
                                <option value="free" {{ old('type') == 'free' ? 'selected' : '' }}>Free</option>
                                <option value="paid" {{ old('type') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                            @error('type') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Price Field (Shown only when Paid is selected) -->
                        <div class="form-group" id="priceGroup" style="display: none;"> {{-- Hidden by default --}}
                            <label for="price">Course Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" min="0" step="any">
                            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Stream Selection -->
                        <div class="form-group">
                            <label for="stream_id">Stream <span class="text-danger">*</span></label>
                            <select id="stream_id" name="stream_id" class="form-control @error('stream_id') is-invalid @enderror" required>
                                <option value="">Select a Stream</option>
                                @foreach ($streams as $stream)
                                <option value="{{ $stream->id }}" {{ old('stream_id') == $stream->id ? 'selected' : '' }}>{{ $stream->name }}</option>
                                @endforeach
                            </select>
                            @error('stream_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Teacher Selection -->
                        <div class="form-group">
                            <label for="teacher_id">Teacher <span class="text-danger">*</span></label>
                            <select id="teacher_id" name="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror" required>
                                <option value="">Select a Teacher</option>
                                @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('teacher_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Start date -->
                        <div class="form-group">
                            <label for="start_date">Start Date <span class="text-danger">*</span></label>
                            <input type="date" id="start_date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                            <div id="startDateError" class="date-error-message"></div>
                            @error('start_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- End date -->
                        <div class="form-group">
                            <label for="end_date">End Date <span class="text-danger">*</span></label>
                            <input type="date" id="end_date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            <div id="endDateError" class="date-error-message"></div>
                            @error('end_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Create Course</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const priceGroup = document.getElementById('priceGroup');
            const priceInput = document.getElementById('price');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const startDateError = document.getElementById('startDateError');
            const endDateError = document.getElementById('endDateError');

            // --- Price Field Toggle ---
            function togglePriceField() {
                if (typeSelect.value === 'paid') {
                    priceGroup.style.display = 'block';
                    priceInput.setAttribute('required', 'required'); // Make required
                } else {
                    priceGroup.style.display = 'none';
                    priceInput.removeAttribute('required'); // Not required
                    priceInput.value = ''; // Clear value when hidden
                }
            }

            // Initial call to set state based on old input
            togglePriceField();
            typeSelect.addEventListener('change', togglePriceField);

            // --- Date Validation ---
            function clearDateError(errorElement) {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
            }

            function showDateError(errorElement, message) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }

            function validateDates() {
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Normalize to start of day

                const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
                const endDate = endDateInput.value ? new Date(endDateInput.value) : null;

                // Validate Start Date
                clearDateError(startDateError);
                if (startDate && startDate < today) {
                    showDateError(startDateError, 'Start Date cannot be in the past.');
                    startDateInput.setCustomValidity('Start Date cannot be in the past.');
                } else {
                    startDateInput.setCustomValidity('');
                }

                // Validate End Date
                clearDateError(endDateError);
                if (endDate && startDate && endDate < startDate) {
                    showDateError(endDateError, 'End Date cannot be before Start Date.');
                    endDateInput.setCustomValidity('End Date cannot be before Start Date.');
                } else {
                    endDateInput.setCustomValidity('');
                }
            }

            // Attach event listeners for date validation
            startDateInput.addEventListener('change', validateDates);
            endDateInput.addEventListener('change', validateDates);

            // Run validation once on page load to catch old input issues
            validateDates();
        });
    </script>

    {{-- Bootstrap JS (JQuery and Popper.js are dependencies for some Bootstrap features) --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
