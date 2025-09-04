<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mangagawang Pinoy | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    
</head>

<body class="section1">

   <div class="login-wrapper">
    <a href="{{ route('display.index') }}" class="close-btnn" title="Go to Landing Page">&times;</a>
    <div class="login-left">
        <h2 style="margin-top: 18px;">Manggagawang Pinoy</h2>
        <p class="subtitle">Log in as a worker</p>
        <form class="login-form" method="POST" action="{{ route('applicant.login.store') }}">
            @csrf

            {{-- Show global error (invalid login) --}}
            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif

            {{-- Show success message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    id="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    id="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="sign-in-b login-btn w-100">Login</button>
            <div class="form-text">Don't have an account? <a href="{{ route('applicant.register.display') }}">
                Register</a></div>
        </form>
<div class="divider"></div>
      <div class="login-alt-label"><strong>Sign in as employer</strong></div>
      <button class="sign-in-b employer-btn">Sign in as Employer</button>
    </div>
        <div class="login-right">
      <div class="centered-portrait">
        <img src="https://png.pngtree.com/png-clipart/20250518/original/pngtree-construction-worker-standing-on-transparent-background-png-image_21018565.png" alt="User Illustration">
      </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
