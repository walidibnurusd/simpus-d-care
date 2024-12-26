<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2,
        h3 {
            font-weight: bold;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-check-label {
            font-weight: normal;
        }

        .form-section {
            margin-bottom: 30px;
        }

        /* Apply flexbox for better alignment of radio buttons and labels */
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5em;
            /* Space between radio button and label */
        }

        .form-check-input[type="checkbox"],
        .form-check-input[type="radio"] {
            transform: scale(1.5);
            /* Adjust size as needed */
            margin-right: 8px;
            /* Space between input and label */
        }

        .form-check-label {
            font-size: 1em;
            /* Match with other text for consistency */
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4">@yield('title')</h2>
                @yield('content')
            </div>

        </div>

    </div>
</body>

<!-- Include Bootstrap JS (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

