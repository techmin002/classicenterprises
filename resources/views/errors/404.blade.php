<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page Not Found</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }
        .error-container {
            height: 100vh;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center error-container">
    <div class="text-center">
        <div class="error-code">404</div>
        <h2 class="mb-3">Oops! Page Not Found</h2>
        <p class="text-muted mb-4">
            The page you are looking for doesn’t exist or has been moved.
        </p>

        <a href="{{ url('/login') }}" class="btn btn-primary px-4">
            Go to Login Page
        </a>
    </div>
</div>

</body>
<script>
    setTimeout(function () {
        window.location.href = "{{ url('/login') }}";
    }, 3000); // 3 seconds
</script>
</html>