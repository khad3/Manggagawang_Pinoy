<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mangagawang Pinoy - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>

    <div class="login-wrapper">
        <a href="{{ route('display.index') }}" class="close-btnn" title="Go to Landing Page">&times;</a>
        <div class="login-left">
            <div class="form-container">
                <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2"
                    style=" height: 100px; /*  Adjust height as needed */
    width: auto;
    
    cursor: pointer;
    user-select: none;
    transition: opacity 0.3s ease;
    filter: invert(45%) sepia(84%) saturate(10058%) hue-rotate(247deg)
        brightness(47%) contrast(121%);">
                <h2 style="margin-top: 18px;">Manggagawang Pinoy</h2>
                <p class="subtitle">Log in as a worker</p>
                <form class="login-form" method="POST" action="{{ route('applicant.login.store') }}">
                    @csrf

                    {{-- Show global error (invalid login) --}}
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            {!! $errors->first('email') !!}
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

                    </div>

                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="password" required style="padding-right: 4rem;">
                            <button type="button" id="togglePassword"
                                style="position: absolute; top: 50%; right: 0.5rem; transform: translateY(-50%); border: none; background: none; color: #007bff; cursor: pointer; font-weight: 500;">
                                Show
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="forgot-password text-end mt-1">
                            <a href="{{ route('applicant.forgotpassword.display') }}">Forgot Password?</a>
                        </div>
                    </div>



                    <button type="submit" class="sign-in-b login-btn w-100">Login</button>
                    <div class="form-text">Don't have an account? <a
                            href="{{ route('applicant.register.display') }}">Register</a></div>
                </form>

                <div class="text-start mt-3 back-btn-container">
                    <a href="{{ route('display.index') }}" class="back-btn">← Back to Home</a>
                </div>

            </div>
        </div>
        <div class="login-right">
            <div class="centered-portrait">
                <img src="https://png.pngtree.com/png-clipart/20250518/original/pngtree-construction-worker-standing-on-transparent-background-png-image_21018565.png"
                    alt="User Illustration">
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                togglePassword.textContent = 'Show';
            }
        });
    </script>

</body>

</html>
