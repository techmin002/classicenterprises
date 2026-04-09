<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 Forbidden</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f8f9fa; }
        .container-box { height: 100vh; }
        .error-code {
            font-size: 110px;
            font-weight: bold;
            color: #ffc107;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center container-box">
    <div class="text-center">
        <div class="error-code">403</div>

        <h2 class="mb-3">Access Forbidden</h2>
        <p class="text-muted mb-4">
            You don’t have permission to access this page.
        </p>

        <a href="{{ url('/login') }}" class="btn btn-primary px-4 me-2">
            Go to Login
        </a>

        <a href="{{ url('/') }}" class="btn btn-secondary px-4">
            Go Home
        </a>
    </div>
</div>

</body>
<script>
    setTimeout(function () {
        window.location.href = "{{ url('/login') }}";
    }, 4000);
</script>
</html>