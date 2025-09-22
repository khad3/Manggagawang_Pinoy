<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mangagawang Pinoy - Create Account</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/applicant/register.css') }}">
</head>

<body>
    <!-- Loader -->
    <div id="loader-wrapper">
        <div id="loader-content">
            <div
                style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; font-weight: 700; color: white;">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-width: 100px;">
            </div>
            <div id="loader"></div>
            <div id="loader-text">Please wait...</div>
        </div>
    </div>

    <!-- Registration Container -->
    <div class="registration-container">
        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-steps">
                <div class="progress-line">
                    <div class="progress-line-fill" id="progressFill"></div>
                </div>
                <div class="step active" data-step="1">1</div>
                <div class="step pending" data-step="2">2</div>
                <div class="step pending" data-step="3">3</div>
                <div class="step pending" data-step="4">4</div>
                <div class="step pending" data-step="5">5</div>
            </div>
            <div class="step-labels">
                <span class="step-label active">Account</span>
                <span class="step-label">Verify</span>
                <span class="step-label">Personal</span>
                <span class="step-label">Work</span>
                <span class="step-label">Profile</span>
            </div>
        </div>

        <!-- Form Content -->
        <div class="form-content">
            <div class="form-header">
                <h2 class="form-title">Create Account</h2>
                <p class="form-subtitle">Join Mangagawang Pinoy and find your dream employer</p>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Registration Form -->
            <form action="{{ route('applicant.register.store') }}" method="post" id="registrationForm">
                @csrf

                <!-- Username -->
                <div class="form-group">
                    <input type="text" name="username" class="form-input with-icon" placeholder="Username" required
                        value="{{ old('username') }}">
                    <i class="bi bi-person input-icon"></i>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <input type="email" name="email" class="form-input with-icon" placeholder="Email Address"
                        required value="{{ old('email') }}">
                    <i class="bi bi-envelope input-icon"></i>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-input with-icon"
                        placeholder="Password" required oninput="checkPasswordStrength()">
                    <i class="bi bi-lock input-icon"></i>
                    <div id="passwordHelp" class="password-feedback"></div>
                    <div class="strength-indicator" id="strengthIndicator" style="display: none;">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-input with-icon" placeholder="Confirm Password" required
                        oninput="checkPasswordMatch()">
                    <i class="bi bi-shield-lock input-icon"></i>
                    <div id="passwordMatchHelp" class="password-feedback"></div>
                </div>

                <!-- Terms Checkbox -->
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox" id="termsCheckbox" onclick="toggleCheckbox()"></div>
                    <input type="checkbox" name="terms" id="termsInput" style="display: none;" required>
                    <label class="checkbox-label" for="termsInput">
                        I agree to the <a href="{{ route('display.termsandconditions') }}" target="_blank">Terms &
                            Conditions</a> and <a href="{{ route('display.privacypolicy') }}" target="_blank">Privacy
                            Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn" id="submitBtn" disabled>
                    <i class="bi bi-arrow-right me-2"></i>Create Account
                </button>
            </form>

            <!-- Links -->
            <div class="form-links">
                Already have an account? <a href="{{ route('applicant.login.display') }}">Sign in here</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Hide loader after page load
        window.addEventListener("load", function() {
            setTimeout(function() {
                document.getElementById("loader-wrapper").style.display = "none";
            }, 1500);
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
                indicator.style.display = 'none';
                helpText.innerHTML = '';
                validateForm();
                return;
            }

            indicator.style.display = 'block';

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
            fill.className = 'strength-fill';
            if (strength === 1) fill.classList.add('strength-weak');
            else if (strength === 2) fill.classList.add('strength-fair');
            else if (strength === 3) fill.classList.add('strength-good');
            else if (strength === 4) fill.classList.add('strength-strong');

            window.passwordValid = isValid;
            validateForm();
        }

        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const matchHelp = document.getElementById('passwordMatchHelp');

            if (!confirm) {
                matchHelp.innerHTML = '';
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

        // Checkbox toggle
        function toggleCheckbox() {
            const checkbox = document.getElementById('termsCheckbox');
            const input = document.getElementById('termsInput');

            if (input.checked) {
                input.checked = false;
                checkbox.classList.remove('checked');
            } else {
                input.checked = true;
                checkbox.classList.add('checked');
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

            submitBtn.disabled = !isValid;
        }

        // Initialize validation state
        window.passwordValid = false;
        window.passwordMatch = false;

        // Add input listeners for real-time validation
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('input', validateForm);
            });
        });
    </script>
</body>

</html>
