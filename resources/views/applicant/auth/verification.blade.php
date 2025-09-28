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

    <link rel="stylesheet" href="{{ asset('css/applicant/verification.css') }}">
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

            @if (session('email'))
                @php
                    $email = session('email');
                    $parts = explode('@', $email);
                    $masked = substr($parts[0], 0, 2) . str_repeat('*', strlen($parts[0]) - 2) . '@' . $parts[1];
                @endphp
                We've sent a 6-digit verification code to your email address.
                Please enter the code below to verify your account <strong>{{ $masked }}</strong>.
            @endif


            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Verification failed:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
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
                    <input type="text" maxlength="1" class="code-digit" data-index="0"
                        oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)"
                        onpaste="handlePaste(event)">
                    <input type="text" maxlength="1" class="code-digit" data-index="1"
                        oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                    <input type="text" maxlength="1" class="code-digit" data-index="2"
                        oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                    <input type="text" maxlength="1" class="code-digit" data-index="3"
                        oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                    <input type="text" maxlength="1" class="code-digit" data-index="4"
                        oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                    <input type="text" maxlength="1" class="code-digit" data-index="5"
                        oninput="handleDigitInput(this)" onkeydown="handleKeyDown(event, this)">
                </div>

                <!-- Timer -->
                <div class="timer-container">
                    <div class="timer-text">Code expires in:</div>
                    <div class="timer-countdown" id="countdown">05:00</div>
                </div>

                <!-- Resend -->
                <div class="resend-container">
                    <span style="color: #64748b; font-size: 14px;">Didn't receive the code?</span>
                    <button type="button" class="resend-btn" id="resendBtn" onclick="resendCode()" disabled>
                        Resend Code (<span id="countdown">30</span>s)
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
        let countdown = 30; // seconds
        let resendBtn = document.getElementById('resendBtn');
        let countdownSpan = document.getElementById('countdown');

        let timer = setInterval(function() {
            countdown--;
            countdownSpan.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(timer);
                resendBtn.disabled = false;
                countdownSpan.textContent = '';
                resendBtn.textContent = 'Resend Code';
            }
        }, 1000);

        // Function to handle resend
        function resendCode() {
            resendBtn.disabled = true;
            resendBtn.textContent = "Resending...";

            // Example: send AJAX request to backend
            fetch("{{ route('verification.resend') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || "A new code has been sent to your email.");
                    // restart countdown
                    countdown = 30;
                    resendBtn.textContent = "Resend Code (30s)";
                    resendBtn.disabled = true;
                    timer = setInterval(function() {
                        countdown--;
                        resendBtn.textContent = "Resend Code (" + countdown + "s)";
                        if (countdown <= 0) {
                            clearInterval(timer);
                            resendBtn.disabled = false;
                            resendBtn.textContent = "Resend Code";
                        }
                    }, 1000);
                })
                .catch(error => {
                    console.error("Error:", error);
                    resendBtn.disabled = false;
                    resendBtn.textContent = "Resend Code";
                });
        }
    </script>

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
