<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>500 Server Error</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f8f9fa; }
        .container-box { height: 100vh; }
        .error-code {
            font-size: 110px;
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center container-box">
    <div class="text-center">
        <div class="error-code">500</div>

        <h2 class="mb-3">Server Error</h2>
        <p class="text-muted mb-4">
            Something went wrong on our side. Please try again later.
        </p>

        <a href="{{ url('/') }}" class="btn btn-primary px-4 me-2">
            Go Home
        </a>

        <button onclick="location.reload()" class="btn btn-outline-secondary px-4">
            Retry
        </button>
    </div>
</div>

</body>
<script>
    setTimeout(function () {
        window.location.href = "{{ url('/login') }}";
    }, 4000);
</script>
</html>