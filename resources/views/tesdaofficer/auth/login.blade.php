<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESDA Officers Portal - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/tesdaofficer/login.css') }}">
</head>

<body>
    <div class="bg-pattern"></div>

    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="logo">T</div>
                <div class="login-title">TESDA Officers Portal</div>
                <div class="login-subtitle">Certification Management System</div>
            </div>

            <!-- Alert Messages -->
            <div class="alert-container">
                <!-- Show global error (invalid login) -->
                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <!-- Show success message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <!-- Login Form -->
            <form class="login-form" id="loginForm" action="{{ route('tesda-officer.login.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div style="position: relative;">
                        <input type="email" class="form-input" name="email" placeholder="Enter your email address"
                            required>
                        <i class="fas fa-envelope form-input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" class="form-input" name="password" id="password"
                            placeholder="Enter your password" required>
                        <i class="fas fa-eye password-toggle" id="passwordToggle"></i>
                    </div>
                </div>

                <div class="form-options">
                    <a href="#" class="forgot-password" onclick="showForgotPassword()">Forgot Password?</a>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </button>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                <p>&copy; 2024 Technical Education and Skills Development Authority</p>
                <div class="footer-links">
                    <a href="#" onclick="showHelp()">Help</a>
                    <a href="#" onclick="showSupport()">Support</a>
                    <a href="#" onclick="showPrivacy()">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <p>Authenticating...</p>
        </div>
    </div>

    <script>
        // Password toggle functionality
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('passwordToggle');

        passwordToggle.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.className = 'fas fa-eye-slash password-toggle';
            } else {
                passwordInput.type = 'password';
                passwordToggle.className = 'fas fa-eye password-toggle';
            }
        });

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Forgot password functionality
        function showForgotPassword() {
            const email = prompt('Please enter your email address:');
            if (email && isValidEmail(email)) {
                alert('Password reset instructions have been sent to ' + email);
            } else if (email) {
                alert('Please enter a valid email address.');
            }
        }

        // Footer link functions
        function showHelp() {
            alert('Help: For assistance, please contact your system administrator or call TESDA hotline.');
        }

        function showSupport() {
            alert('Support: Email support@tesda.gov.ph or call (02) 8-631-TESDA (8-631-8373)');
        }

        function showPrivacy() {
            alert(
                'Privacy Policy: Your data is protected according to TESDA privacy guidelines and Data Privacy Act of 2012.'
            );
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'Enter') {
                document.getElementById('loginForm').dispatchEvent(new Event('submit'));
            }
        });

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.animation = 'slideDown 0.4s ease-out reverse';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 400);
                }, 5000);
            });
        });
    </script>
</body>

</html>
