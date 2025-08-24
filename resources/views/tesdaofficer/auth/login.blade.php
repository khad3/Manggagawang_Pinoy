<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESDA Officers Portal - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            position: relative;
            overflow: hidden;
        }

        /* Background Elements */
        .bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            margin: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 40px 30px 30px;
            text-align: center;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            clip-path: ellipse(100% 100% at 50% 0%);
        }

        .logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            margin: 0 auto 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.025em;
        }

        .login-subtitle {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
        }

        /* Alert Messages - Positioned between header and form */
        .alert-container {
            padding: 0 30px;
            margin-top: 20px;
        }

        .alert {
            padding: 15px 18px;
            border-radius: 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease-out;
            position: relative;
            overflow: hidden;
        }

        @keyframes slideDown {
            from { 
                opacity: 0; 
                transform: translateY(-10px);
                max-height: 0;
                padding-top: 0;
                padding-bottom: 0;
            }
            to   { 
                opacity: 1; 
                transform: translateY(0);
                max-height: 100px;
                padding-top: 15px;
                padding-bottom: 15px;
            }
        }

        /* Success message styling */
        .alert-success {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #15803d;
            border: 1px solid #86efac;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
        }

        .alert-success::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #22c55e 0%, #15803d 100%);
        }

        .alert-success i {
            color: #22c55e;
            font-size: 16px;
        }

        /* Error message styling */
        .alert-danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            color: #dc2626;
            border: 1px solid #f87171;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }

        .alert-danger::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%);
        }

        .alert-danger i {
            color: #ef4444;
            font-size: 16px;
        }

        .login-form {
            padding: 30px 30px 30px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 16px 50px 16px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
            position: relative;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }

        .form-input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            font-size: 16px;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
        }

        .form-options {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 32px;
            font-size: 14px;
        }

        .forgot-password {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .login-footer {
            padding: 20px 30px;
            background: #f8fafc;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #e5e7eb;
        }

        .footer-links {
            margin-top: 12px;
        }

        .footer-links a {
            color: #3b82f6;
            text-decoration: none;
            margin: 0 8px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            text-decoration: underline;
            color: #1e40af;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .loading-content {
            text-align: center;
            color: #3b82f6;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 16px;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
            }

            .login-form, .alert-container {
                padding-left: 20px;
                padding-right: 20px;
            }

            .login-header {
                padding: 30px 20px 20px;
            }

            .form-input {
                padding: 14px 45px 14px 16px;
                font-size: 15px;
            }

            .login-btn {
                padding: 14px 20px;
                font-size: 15px;
            }

            .login-title {
                font-size: 24px;
            }

            .form-input-icon, .password-toggle {
                right: 12px;
            }
        }
    </style>
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
                @if($errors->has('email'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $errors->first('email') }}
                </div>
                @endif

                <!-- Show success message -->
                @if(session('success'))
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
                        <input type="email" class="form-input" name="email" placeholder="Enter your email address" required>
                        <i class="fas fa-envelope form-input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" class="form-input" name="password" id="password" placeholder="Enter your password" required>
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
            alert('Privacy Policy: Your data is protected according to TESDA privacy guidelines and Data Privacy Act of 2012.');
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