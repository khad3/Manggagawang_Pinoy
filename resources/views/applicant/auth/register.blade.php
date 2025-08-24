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
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        /* Loader Styles */
        #loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        
        #loader-content {
            text-align: center;
            color: white;
        }
        
        #loader-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            border-radius: 20px;
        }
        
        #loader {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        #loader-text {
            font-size: 16px;
            font-weight: 500;
        }
        
        /* Main Container */
        .registration-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            position: relative;
        }
        
        /* Progress Bar */
        .progress-container {
            background: #f8fafc;
            padding: 30px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .step {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-weight: 600;
            font-size: 14px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .step.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: scale(1.1);
        }
        
        .step.completed {
            background: #10b981;
            color: white;
        }
        
        .step.pending {
            background: #e2e8f0;
            color: #64748b;
        }
        
        .progress-line {
            position: absolute;
            top: 50%;
            left: 50px;
            right: 50px;
            height: 2px;
            background: #e2e8f0;
            z-index: 1;
        }
        
        .progress-line-fill {
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: width 0.3s ease;
            width: 0%;
        }
        
        .step-labels {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
            margin-top: 10px;
        }
        
        .step-label.active {
            color: #667eea;
        }
        
        /* Form Content */
        .form-content {
            padding: 40px;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }
        
        .form-subtitle {
            color: #64748b;
            font-size: 16px;
        }
        
        /* Form Inputs */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            transition: color 0.3s ease;
        }
        
        .form-input:focus + .input-icon {
            color: #667eea;
        }
        
        .form-input.with-icon {
            padding-left: 50px;
        }
        
        /* Password Strength */
        .password-feedback {
            margin-top: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .password-feedback.valid {
            color: #10b981;
        }
        
        .password-feedback.invalid {
            color: #ef4444;
        }
        
        .strength-indicator {
            flex: 1;
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak { background: #ef4444; width: 25%; }
        .strength-fair { background: #f59e0b; width: 50%; }
        .strength-good { background: #3b82f6; width: 75%; }
        .strength-strong { background: #10b981; width: 100%; }
        
        /* Checkbox */
        .checkbox-wrapper {
            display: flex;
            align-items: start;
            gap: 12px;
            margin: 25px 0;
        }
        
        .custom-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .custom-checkbox.checked {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-color: #667eea;
        }
        
        .custom-checkbox.checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: 600;
        }
        
        .checkbox-label {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
        }
        
        .checkbox-label a {
            color: #667eea;
            text-decoration: none;
        }
        
        .checkbox-label a:hover {
            text-decoration: underline;
        }
        
        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        /* Links */
        .form-links {
            text-align: center;
            font-size: 14px;
        }
        
        .form-links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .form-links a:hover {
            text-decoration: underline;
        }
        
        /* Alerts */
        .alert {
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        
        .alert ul {
            margin: 0;
            padding-left: 20px;
        }
        
        /* Responsive */
        @media (max-width: 576px) {

            .registration-container {
                margin: 10px;
            }
            
            .form-content {
                padding: 30px 25px;
            }
            
            .progress-container {
                padding: 20px;
            }
            
            .step-labels {
                font-size: 10px;
            }
            
            .step {
                width: 35px;
                height: 35px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div id="loader-wrapper">
        <div id="loader-content">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; font-weight: 700; color: white;">  <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-width: 100px;"></div>
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
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach($errors->all() as $error)
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
                    <input type="text" name="username" class="form-input with-icon" placeholder="Username" required value="{{ old('username') }}">
                    <i class="bi bi-person input-icon"></i>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <input type="email" name="email" class="form-input with-icon" placeholder="Email Address" required value="{{ old('email') }}">
                    <i class="bi bi-envelope input-icon"></i>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-input with-icon" placeholder="Password" required oninput="checkPasswordStrength()">
                    <i class="bi bi-lock input-icon"></i>
                    <div id="passwordHelp" class="password-feedback"></div>
                    <div class="strength-indicator" id="strengthIndicator" style="display: none;">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input with-icon" placeholder="Confirm Password" required oninput="checkPasswordMatch()">
                    <i class="bi bi-shield-lock input-icon"></i>
                    <div id="passwordMatchHelp" class="password-feedback"></div>
                </div>

                <!-- Terms Checkbox -->
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox" id="termsCheckbox" onclick="toggleCheckbox()"></div>
                    <input type="checkbox" name="terms" id="termsInput" style="display: none;" required>
                    <label class="checkbox-label" for="termsInput">
                        I agree to the <a href="#" target="_blank">Terms & Conditions</a> and <a href="#" target="_blank">Privacy Policy</a>
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
        window.addEventListener("load", function () {
            setTimeout(function () {
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