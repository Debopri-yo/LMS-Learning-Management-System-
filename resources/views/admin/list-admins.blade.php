<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Admins</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #292G36; /* Gunmetal */
            color: white;
        }

        .table th, .table td {
            color: white;
        }

        .btn-danger {
            background-color: #ff4d4d;
            border: none;
        }

        .btn-danger:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">List of Admins</h2>
        <table class="table table-dark table-striped mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <form action="{{ route('admin.remove-admin', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this admin?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

