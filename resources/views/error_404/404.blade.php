<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>404 - Page Not Found | Mangagawang Pinoy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .error-container {
      text-align: center;
      max-width: 600px;
    }
    .error-code {
      font-size: 120px;
      font-weight: bold;
      color: #0d6efd;
    }
    .error-message {
      font-size: 24px;
      color: #333;
      margin-bottom: 15px;
    }
    .error-description {
      color: #6c757d;
      margin-bottom: 30px;
    }
  </style>
</head>
<body>
  <div class="error-container">
    <div class="error-code">404</div>
    <div class="error-message">Page Not Found</div>
    <p class="error-description">
      The page you’re looking for might have been moved, deleted, or doesn't exist.
    </p>
    <a href="{{ url('/') }}" class="btn btn-primary">
      Back to Homepage
    </a>
  </div>
</body>
</html>
