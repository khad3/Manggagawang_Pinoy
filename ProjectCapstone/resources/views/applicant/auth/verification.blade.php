<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobHub - Email Verification</title>
    
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
        
        /* Main Container */
        .verification-container {
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
            width: 25%; /* Step 2 of 5 */
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
        
        .step-label.completed {
            color: #10b981;
        }
        
        /* Form Content */
        .form-content {
            padding: 40px;
            text-align: center;
        }
        
        .verification-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(102, 126, 234, 0); }
        }
        
        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }
        
        .form-subtitle {
            color: #64748b;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        /* Code Input */
        .code-input-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 30px 0;
        }
        
        .code-digit {
            width: 50px;
            height: 60px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            background: #f8fafc;
            transition: all 0.3s ease;
        }
        
        .code-digit:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: scale(1.05);
        }
        
        .code-digit.filled {
            background: white;
            border-color: #10b981;
            color: #1e293b;
        }
        
        /* Hidden input for form submission */
        #verification_code {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        
        /* Timer */
        .timer-container {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 16px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }
        
        .timer-text {
            color: #1e293b;
            font-weight: 500;
            margin-bottom: 4px;
        }
        
        .timer-countdown {
            color: #3b82f6;
            font-weight: 600;
            font-size: 18px;
        }
        
        /* Resend Button */
        .resend-container {
            margin: 20px 0;
        }
        
        .resend-btn {
            background: none;
            border: none;
            color: #667eea;
            font-weight: 500;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
        }
        
        .resend-btn:hover {
            color: #5145cd;
        }
        
        .resend-btn:disabled {
            color: #94a3b8;
            cursor: not-allowed;
            text-decoration: none;
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
            opacity: 0.5;
        }
        
        .submit-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .submit-btn.ready {
            opacity: 1;
        }
        
        .submit-btn:disabled {
            cursor: not-allowed;
            transform: none;
        }
        
        /* Alerts */
        .alert {
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: left;
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
        
        /* Help Text */
        .help-text {
            font-size: 14px;
            color: #64748b;
            margin-top: 20px;
            line-height: 1.6;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .verification-container {
                margin: 10px;
            }
            
            .form-content {
                padding: 30px 25px;
            }
            
            .progress-container {
                padding: 20px;
            }
            
            .code-digit {
                width: 45px;
                height: 55px;
                font-size: 20px;
            }
            
            .code-input-container {
                gap: 8px;
            }
            
            .form-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Verification Container -->
    <div class="verification-container">
        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-steps">
                <div class="progress-line">
                    <div class="progress-line-fill"></div>
                </div>
                <div class="step completed" data-step="1">
                    <i class="bi bi-check"></i>
                </div>
                <div class="step active" data-step="2">2</div>
                <div class="step pending" data-step="3">3</div>
                <div class="step pending" data-step="4">4</div>
                <div class="step pending" data-step="5">5</div>
            </div>
            <div class="step-labels">
                <span class="step-label completed">Account</span>
                <span class="step-label active">Verify</span>
                <span class="step-label">Personal</span>
                <span class="step-label">Work</span>
                <span class="step-label">Profile</span>
            </div>
        </div>

        <!-- Form Content -->
        <div class="form-content">
            <!-- Verification Icon -->
            <div class="verification-icon">
                <i class="bi bi-envelope-check" style="font-size: 32px; color: white;"></i>
            </div>
            
            <h2 class="form-title">Check Your Email</h2>
            <p class="form-subtitle">
                We've sent a 6-digit verification code to your email address. 
                Please enter the code below to verify your account.
            </p>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Verification failed:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Verification Form -->
            <form method="POST" action="{{ route('applicant.verification.store') }}" id="verificationForm">
                @csrf
                
                <!-- Hidden input for form submission -->
                <input type="hidden" name="verification_code" id="verification_code" required>
                
                <!-- Code Input Digits -->
                <div class="code-input-container">
                    <input type="text" maxlength="1" class="code-digit" data-index="0" oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)" onpaste="handlePaste(event)">
                    <input type="text" maxlength="1" class="code-digit" data-index="1" oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                    <input type="text" maxlength="1" class="code-digit" data-index="2" oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                    <input type="text" maxlength="1" class="code-digit" data-index="3" oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                    <input type="text" maxlength="1" class="code-digit" data-index="4" oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                    <input type="text" maxlength="1" class="code-digit" data-index="5" oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                </div>

                <!-- Timer -->
                <div class="timer-container">
                    <div class="timer-text">Code expires in:</div>
                    <div class="timer-countdown" id="countdown">05:00</div>
                </div>

                <!-- Resend -->
                <div class="resend-container">
                    <span style="color: #64748b; font-size: 14px;">Didn't receive the code? </span>
                    <button type="button" class="resend-btn" id="resendBtn" onclick="resendCode()" disabled>
                        Resend Code
                    </button>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn" id="submitBtn" disabled>
                    <i class="bi bi-shield-check me-2"></i>Verify Email
                </button>
            </form>

            <!-- Help Text -->
            <div class="help-text">
                <i class="bi bi-info-circle me-1"></i>
                Make sure to check your spam folder if you don't see the email in your inbox.
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let timeLeft = 300; // 5 minutes in seconds
        let timerInterval;

        // Start countdown timer
        function startTimer() {
            timerInterval = setInterval(function() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                const display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                document.getElementById('countdown').textContent = display;
                
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById('countdown').textContent = '00:00';
                    document.getElementById('countdown').style.color = '#ef4444';
                    document.getElementById('resendBtn').disabled = false;
                    
                    // Disable form
                    const digits = document.querySelectorAll('.code-digit');
                    digits.forEach(digit => digit.disabled = true);
                    document.getElementById('submitBtn').disabled = true;
                }
                
                timeLeft--;
            }, 1000);
        }

        // Handle digit input
        function handleDigitInput(input) {
            const index = parseInt(input.dataset.index);
            const value = input.value;
            
            // Only allow numbers
            input.value = value.replace(/[^0-9]/g, '');
            
            if (input.value) {
                input.classList.add('filled');
                
                // Move to next input
                if (index < 5) {
                    const nextInput = document.querySelector(`[data-index="${index + 1}"]`);
                    nextInput.focus();
                }
            } else {
                input.classList.remove('filled');
            }
            
            updateVerificationCode();
            checkFormValidity();
        }

        // Handle keyboard navigation
        function handleKeyDown(event, input) {
            const index = parseInt(input.dataset.index);
            
            if (event.key === 'Backspace' && !input.value && index > 0) {
                const prevInput = document.querySelector(`[data-index="${index - 1}"]`);
                prevInput.focus();
                prevInput.value = '';
                prevInput.classList.remove('filled');
                updateVerificationCode();
                checkFormValidity();
            } else if (event.key === 'ArrowLeft' && index > 0) {
                const prevInput = document.querySelector(`[data-index="${index - 1}"]`);
                prevInput.focus();
            } else if (event.key === 'ArrowRight' && index < 5) {
                const nextInput = document.querySelector(`[data-index="${index + 1}"]`);
                nextInput.focus();
            }
        }

        // Handle paste
        function handlePaste(event) {
            event.preventDefault();
            const pastedData = event.clipboardData.getData('text').replace(/[^0-9]/g, '');
            
            if (pastedData.length === 6) {
                const digits = document.querySelectorAll('.code-digit');
                for (let i = 0; i < 6; i++) {
                    digits[i].value = pastedData[i] || '';
                    if (digits[i].value) {
                        digits[i].classList.add('filled');
                    } else {
                        digits[i].classList.remove('filled');
                    }
                }
                updateVerificationCode();
                checkFormValidity();
            }
        }

        // Update hidden verification code input
        function updateVerificationCode() {
            const digits = document.querySelectorAll('.code-digit');
            let code = '';
            digits.forEach(digit => {
                code += digit.value;
            });
            document.getElementById('verification_code').value = code;
        }

        // Check if form is valid
        function checkFormValidity() {
            const code = document.getElementById('verification_code').value;
            const submitBtn = document.getElementById('submitBtn');
            
            if (code.length === 6) {
                submitBtn.disabled = false;
                submitBtn.classList.add('ready');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove('ready');
            }
        }

        // Resend code
        function resendCode() {
            // Reset timer
            timeLeft = 300;
            document.getElementById('countdown').style.color = '#3b82f6';
            document.getElementById('resendBtn').disabled = true;
            
            // Re-enable form
            const digits = document.querySelectorAll('.code-digit');
            digits.forEach(digit => {
                digit.disabled = false;
                digit.value = '';
                digit.classList.remove('filled');
            });
            
            // Clear and focus first input
            digits[0].focus();
            updateVerificationCode();
            checkFormValidity();
            
            // Restart timer
            startTimer();
            
            // Here you would make an AJAX call to resend the verification code
            // For now, we'll just show a success message
            alert('Verification code has been resent to your email!');
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            startTimer();
            
            // Focus first input
            document.querySelector('[data-index="0"]').focus();
            
            // Form submission handler
            document.getElementById('verificationForm').addEventListener('submit', function(e) {
                const code = document.getElementById('verification_code').value;
                if (code.length !== 6) {
                    e.preventDefault();
                    alert('Please enter the complete 6-digit verification code.');
                }
            });
        });
    </script>
</body>
</html>