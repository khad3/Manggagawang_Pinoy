<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/employer/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">    
    <style>

    </style>
</head>

<body class="section1">

   <div class="login-wrapper">
    <a href="{{ route('display.index') }}" class="close-btnn" title="Go to Landing Page">&times;</a>
    <div class="login-left">
        <h2 style="margin-top: 18px;">Manggagawang Pinoy</h2>
        <p class="subtitle">Log in as a employer</p>
        

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
 
        <form class="login-form" action="{{ route('employer.login.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" required placeholder="glicompany@example.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required
                    placeholder="password">
            </div>

      
                <button type="submit" class="sign-in-b login-btn w-100">Login</button>
           

            <div class="form-text">
                <p>Don’t have an account? <a href="{{ route('employer.register.display') }}">Register</a></p>
            </div>
        </form>
    <div class="divider"></div>
      <div class="login-alt-label"><strong>Sign in as employer</strong></div>
      <button class="sign-in-b employer-btn">Sign in as Employer</button>
    </div>
        <div class="login-right">
      <div class="centered-portrait">
        <img src="https://png.pngtree.com/png-clipart/20250105/original/pngtree-professional-man-standing-confidently-png-image_18805914.png" alt="User Illustration">
      </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showPassword() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>

</html>
