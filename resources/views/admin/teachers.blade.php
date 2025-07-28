<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #292G36 !important; /* Gunmetal */
            color: white;
        }

        .header {
            background-color: #4ECDC4;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #292G36;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
        }

        .logout-btn {
            background-color: #292G36;
            color: #4ECDC4;
            border: 1px solid #4ECDC4;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .logout-btn:hover {
            background-color: #4ECDC4;
            color: #292G36;
        }

        .teacher-card {
            background-color: #1d2529;
            border: 1px solid #4ECDC4;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .remove-btn {
            background-color: #4ECDC4;
            color: #292G36;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .remove-btn:hover {
            background-color: #292G36;
            color: #4ECDC4;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">Teacher List</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @foreach($teachers as $teacher)
        <div class="teacher-card">
            <div>
                <strong>{{ $teacher->name }}</strong>
                <div>{{ $teacher->email }}</div>
            </div>
            <form action="{{ route('admin.remove-teacher', $teacher->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="remove-btn">Remove</button>
            </form>
        </div>
        @endforeach
    </div>
</body>
</html>

