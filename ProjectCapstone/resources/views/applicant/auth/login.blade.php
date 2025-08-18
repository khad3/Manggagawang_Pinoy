<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mangagawang Pinoy | Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
    }
    .login-container {
      max-width: 400px;
      margin: 80px auto;
      background-color: #ffffff11;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    .form-control {
      background-color: #fff;
    }
    .login-logo {
      font-size: 30px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
      color: #f8d90f;
    }
    .btn-login {
      background-color: #f8d90f;
      color: #000;
      font-weight: bold;
    }
    .btn-login:hover {
      background-color: #e2c300;
    }
    .form-text {
      text-align: center;
      margin-top: 15px;
      color: #ccc;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-logo">Mangagawang Pinoy</div>
    <form method="POST" action="{{ route('applicant.login.store') }}">
  @csrf

  {{-- Show global error (invalid login) --}}
  @if($errors->has('email'))
    <div class="alert alert-danger">
      {{ $errors->first('email') }}
    </div>
  @endif

  {{-- Show success message --}}
  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" 
           name="email" id="email" value="{{ old('email') }}" required>
    @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" 
           name="password" id="password" required>
    @error('password')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <button type="submit" class="btn btn-login w-100">Login</button>
  <div class="form-text">Don't have an account? <a href="{{ route('applicant.register.display') }}" class="text-warning">Register</a></div>
</form>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
