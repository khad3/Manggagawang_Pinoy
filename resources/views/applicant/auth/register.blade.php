<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>
    <nav>
        <div class="navbar-container">
            <div class="nav-logo d-flex align-items-center">
                <a href="{{ route('display.index') }}" class="d-flex align-items-center gap-2"
                    style="text-decoration:none;">
                    <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home" />
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" />
                </a>
            </div>

            <ul class="nav-links" id="navLinks">
                <li><a href="#">Services</a></li>
                <li><a href="{{ route('display.topworker') }}">Top Workers</a></li>
                <li><a href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                <li><a href="{{ route('display.aboutus') }}">About Us</a></li>
                <li class="dropdown">
                    <button class="sign-in-b">Sign in</button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.login.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.login.display') }}">As Employer</a></li>
                    </ul>
                </li>

                <!-- Sign Up Dropdown -->
                <li class="dropdown">
                    <button class="sign-up-b">Sign up</button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.register.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.register.display') }}">As Employer</a></li>
                    </ul>
                </li>
            </ul>


            <div class="hamburger" id="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </nav>


    <!-- Loader -->
    <div id="loader-wrapper">
        <div id="loader-content">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; font-weight: 700; color: white;">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-width: 100px;">
            </div>
            <div id="loader"></div>
            <div id="loader-text">Please wait...</div>
        </div>
    </div>

    <!-- Step Content -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card" style="margin-top:100px;">
                <div class="card-header bg-white border-0 py-4">
                    <div class="container">
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-dark mb-3">Worker Registration</h1>
                            <p class="lead text-muted">Showcase your TESDA-certified skills and connect with employers who value your expertise.</p>
                        </div>

                        <!-- Progress Stepper (same structure as employer for responsive behavior) -->
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-10">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-center">
                                        <div class="step-indicator step-active" id="step1">1</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Account</small><br>
                                            <small class="text-muted d-none d-sm-block">Account setup</small>
                                        </div>
                                    </div>
                                    <div class="step-line"></div>

                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step2">2</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Verify</small><br>
                                            <small class="text-muted d-none d-sm-block">Verification</small>
                                        </div>
                                    </div>
                                    <div class="step-line"></div>

                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step3">3</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Personal</small><br>
                                            <small class="text-muted d-none d-sm-block">Personal info</small>
                                        </div>
                                    </div>
                                    <div class="step-line"></div>

                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step4">4</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Work</small><br>
                                            <small class="text-muted d-none d-sm-block">Work details</small>
                                        </div>
                                    </div>
                                    <div class="step-line"></div>

                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step5">5</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Profile</small><br>
                                            <small class="text-muted d-none d-sm-block">Build profile</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Stepper -->

                    </div>
                </div>

                <div class="card-body p-4">
                    <h1 class="card-title mb-2">Create Account</h1>
                    <p class="text-muted mb-0">Join Mangagawang Pinoy and find your dream employer</p>
                    <br>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('applicant.register.store') }}" method="post" id="registrationForm">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label">Username *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" value="{{ old('username') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required oninput="checkPasswordStrength()">
                            </div>
                            <div id="passwordHelp" class="form-text"></div>
                            <div class="strength-indicator mt-1" id="strengthIndicator" style="display: none;">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Re-enter password" required oninput="checkPasswordMatch()">
                            </div>
                            <div id="passwordMatchHelp" class="form-text"></div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="terms" id="termsInput" required>
                            <label class="form-check-label" for="termsInput">
                                I agree to the
                                <a href="{{ route('display.termsandconditions') }}" target="_blank">Terms & Conditions</a> and
                                <a href="{{ route('display.privacypolicy') }}" target="_blank">Privacy Policy</a>
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="submitBtn" class="btn btn-primary-custom" disabled>
                                Create Account <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>

                    <div class="form-links mt-3">
                        Already have an account? <a href="{{ route('applicant.login.display') }}">Sign in here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        
        // Hide loader after page load
        window.addEventListener("load", function() {
            setTimeout(function() {
                const loader = document.getElementById("loader-wrapper");
                if (loader) loader.style.display = "none";
            }, 800);
        });

        // Password strength checker
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const helpText = document.getElementById('passwordHelp');
            const indicator = document.getElementById('strengthIndicator');
            const fill = document.getElementById('strengthFill');

            const hasLetter = /[a-zA-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSymbol = /[\W_]/.test(password);
            const minLength = password.length >= 8;

            let strength = 0;
            let message = '';
            let isValid = false;

            if (password.length === 0) {
                if (indicator) indicator.style.display = 'none';
                if (helpText) helpText.innerHTML = '';
                window.passwordValid = false;
                validateForm();
                return;
            }

            if (indicator) indicator.style.display = 'block';

            if (!minLength) {
                message = '<i class="bi bi-x-circle me-1"></i>Password must be at least 8 characters';
                helpText.className = 'password-feedback invalid';
            } else if (!hasLetter) {
                message = '<i class="bi bi-x-circle me-1"></i>Password must include at least one letter';
                helpText.className = 'password-feedback invalid';
                strength = 1;
            } else if (!hasNumber) {
                message = '<i class="bi bi-x-circle me-1"></i>Password must include at least one number';
                helpText.className = 'password-feedback invalid';
                strength = 2;
            } else if (!hasSymbol) {
                message = '<i class="bi bi-x-circle me-1"></i>Password must include at least one special character';
                helpText.className = 'password-feedback invalid';
                strength = 3;
            } else {
                message = '<i class="bi bi-check-circle me-1"></i>Strong password!';
                helpText.className = 'password-feedback valid';
                strength = 4;
                isValid = true;
            }

            helpText.innerHTML = message;

            // Update strength indicator
            if (fill) {
                fill.className = 'strength-fill';
                fill.classList.remove('strength-weak','strength-fair','strength-good','strength-strong');
                if (strength === 1) fill.classList.add('strength-weak');
                else if (strength === 2) fill.classList.add('strength-fair');
                else if (strength === 3) fill.classList.add('strength-good');
                else if (strength === 4) fill.classList.add('strength-strong');
            }

            window.passwordValid = isValid;
            validateForm();
        }

        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const matchHelp = document.getElementById('passwordMatchHelp');

            if (!confirm) {
                if (matchHelp) matchHelp.innerHTML = '';
                window.passwordMatch = false;
                validateForm();
                return;
            }

            if (password === confirm) {
                matchHelp.innerHTML = '<i class="bi bi-check-circle me-1"></i>Passwords match';
                matchHelp.className = 'password-feedback valid';
                window.passwordMatch = true;
            } else {
                matchHelp.innerHTML = '<i class="bi bi-x-circle me-1"></i>Passwords do not match';
                matchHelp.className = 'password-feedback invalid';
                window.passwordMatch = false;
            }

            validateForm();
        }

        // Form validation
        function validateForm() {
            const submitBtn = document.getElementById('submitBtn');
            const username = document.querySelector('input[name="username"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const terms = document.getElementById('termsInput').checked;

            const isValid = username && email && window.passwordValid && window.passwordMatch && terms;

            if (submitBtn) submitBtn.disabled = !isValid;
        }

        // Init states
        window.passwordValid = false;
        window.passwordMatch = false;

        // Add input listeners for real-time validation
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[required]');
            inputs.forEach(input => input.addEventListener('input', validateForm));

            // Hamburger toggle (same code as employer registration)
            const hamburger = document.getElementById('hamburger');
            const navLinks = document.getElementById('navLinks');
            if (hamburger && navLinks) {
                hamburger.addEventListener('click', function () {
                    navLinks.classList.toggle('active');
                    hamburger.classList.toggle('active');
                    document.body.classList.toggle('noscroll');
                });

                // Close menu only when actual links are clicked
                navLinks.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function () {
                        if (navLinks.classList.contains('active')) {
                            navLinks.classList.remove('active');
                            hamburger.classList.remove('active');
                            document.body.classList.remove('noscroll');
                        }
                    });
                });

                // Dropdown toggle handling (prevent closing burger on dropdown toggle)
                navLinks.querySelectorAll('.dropdown > button').forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const parent = this.parentElement;
                        parent.classList.toggle('open');
                    });
                });
            }
        });
document.querySelectorAll('.dropdown > button').forEach(button => {
  button.addEventListener('click', e => {
    e.stopPropagation(); // Prevent hamburger close
    const dropdown = button.parentElement;

    // Close other dropdowns
    document.querySelectorAll('.dropdown.active').forEach(d => {
      if (d !== dropdown) d.classList.remove('active');
    });

    // Toggle this one
    dropdown.classList.toggle('active');
  });
});

// Close dropdown if clicking outside
document.addEventListener('click', e => {
  if (!e.target.closest('.dropdown')) {
    document.querySelectorAll('.dropdown.active').forEach(d => d.classList.remove('active'));
  }
});


    </script>
</body>

</html>
