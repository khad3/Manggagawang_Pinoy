<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/verification.css') }}">
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
                <li class="dropdown"><button class="sign-in-b">Sign in</button>
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
            <div
                style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; font-weight: 700; color: white;">
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

                        <!-- Header -->
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-dark mb-3">Worker Registration</h1>
                            <p class="lead text-muted">Showcase your TESDA-certified skills and connect with employers
                                who value your expertise.</p>
                        </div>

                        <!-- Progress Stepper -->
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-10">
                                <div class="d-flex align-items-center justify-content-between">

                                    <!-- Step 1 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-completed" id="step1">1</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Account</small>
                                            <br><small class="text-muted d-none d-sm-block">Account setup</small>
                                        </div>
                                    </div>
                                    <div class="step-line step-line-completed" id="line2"></div>

                                    <!-- Step 2 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-active" id="step2">2</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Verify</small>
                                            <br><small class="text-muted d-none d-sm-block">Verification</small>
                                        </div>
                                    </div>
                                    <div class="step-line" id="line3"></div>

                                    <!-- Step 3 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step3">3</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Personal</small>
                                            <br><small class="text-muted d-none d-sm-block">Personal info</small>
                                        </div>
                                    </div>
                                    <div class="step-line" id="line4"></div>

                                    <!-- Step 4 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step4">4</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Work</small>
                                            <br><small class="text-muted d-none d-sm-block">Work details</small>
                                        </div>
                                    </div>
                                    <div class="step-line" id="line5"></div>

                                    <!-- Step 5 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step5">5</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Profile</small>
                                            <br><small class="text-muted d-none d-sm-block">Build profile</small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- End Stepper -->

                    </div>
                </div>

                <!-- Form Content -->
                <div class="form-content">
                    <!-- Verification Icon -->
                    <div class="verification-icon">
                        <i class="bi bi-envelope-check" style="font-size: 32px; color: white;"></i>
                    </div>



                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="alert alert-success">

                            @if (session('email'))
                                @php
                                    $email = session('email');
                                    $parts = explode('@', $email);
                                    $masked =
                                        substr($parts[0], 0, 2) .
                                        str_repeat('*', strlen($parts[0]) - 2) .
                                        '@' .
                                        $parts[1];
                                @endphp
                                We've sent a 6-digit verification code to your email address.
                                Please enter the code below to verify your account
                                <strong>{{ $masked }}</strong>.
                            @endif
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
                            <div class="timer-countdown" id="expiryCountdown">10:00</div>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="submit-btn" id="submitBtn" disabled>
                            <i class="bi bi-shield-check me-2"></i>Verify Email
                        </button>
                    </form>
                    <!-- Resend -->
                    <div class="resend-container" style="margin-top: 10px;">
                        <span style="color: #64748b; font-size: 14px;">Didn't receive the code?</span>

                        <form action="{{ route('verification.resend') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="resend-btn" id="resendBtn" disabled>
                                Resend Code (<span id="countdown">30</span>s)
                            </button>
                        </form>
                    </div>

                    <script>
                        const resendBtn = document.getElementById('resendBtn');
                        const countdownSpan = document.getElementById('countdown');
                        const expiryCountdownDisplay = document.getElementById('expiryCountdown');

                        let resendCountdown = 30;
                        let resendTimer = null;

                        let expiryCountdown = 600; // 10 minutes = 600 seconds
                        let expiryTimer = null;

                        // Format time as mm:ss
                        function formatTime(seconds) {
                            const minutes = Math.floor(seconds / 60);
                            const secs = seconds % 60;
                            return `${minutes.toString().padStart(2, "0")}:${secs.toString().padStart(2, "0")}`;
                        }

                        // Start 10-minute expiry countdown
                        function startExpiryCountdown() {
                            clearInterval(expiryTimer);
                            expiryCountdown = 600;
                            expiryCountdownDisplay.textContent = formatTime(expiryCountdown);

                            expiryTimer = setInterval(() => {
                                expiryCountdown--;
                                expiryCountdownDisplay.textContent = formatTime(expiryCountdown);

                                if (expiryCountdown <= 0) {
                                    clearInterval(expiryTimer);
                                    expiryCountdownDisplay.textContent = "Expired";
                                    expiryCountdownDisplay.style.color = "red";
                                    alert("Your verification code has expired. Please resend a new one.");
                                }
                            }, 1000);
                        }

                        // Start 30-second resend countdown
                        function startResendCountdown() {
                            clearInterval(resendTimer);
                            resendCountdown = 30;
                            resendBtn.disabled = true;
                            countdownSpan.textContent = resendCountdown;

                            resendTimer = setInterval(() => {
                                resendCountdown--;
                                countdownSpan.textContent = resendCountdown;

                                if (resendCountdown <= 0) {
                                    clearInterval(resendTimer);
                                    resendBtn.disabled = false;
                                    resendBtn.textContent = "Resend Code";
                                }
                            }, 1000);
                        }

                        // Handle resend click
                        resendBtn.addEventListener('click', () => {
                            resendBtn.disabled = true;
                            resendBtn.textContent = "Sending...";

                            fetch("{{ route('verification.resend') }}", {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Content-Type": "application/json",
                                        "Accept": "application/json",
                                    },
                                    body: JSON.stringify({})
                                })
                                .then(response => response.json())
                                .then(data => {
                                    alert(data.message || "A new code has been sent to your email.");
                                    resendBtn.textContent = "Resend Code (30s)";
                                    startResendCountdown(); // restart 30s
                                    startExpiryCountdown(); // restart 10-minute expiry
                                })
                                .catch(error => {
                                    console.error(error);
                                    alert("Something went wrong: " + error.message);
                                    resendBtn.disabled = false;
                                    resendBtn.textContent = "Resend Code";
                                });
                        });

                        // Start both timers on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            startResendCountdown(); // 30s resend cooldown
                            startExpiryCountdown(); // 10-minute expiry countdown
                        });
                    </script>

                    @if (session('message'))
                        <script>
                            alert("{{ session('message') }}");
                        </script>
                    @endif
                    @if (session('error'))
                        <script>
                            alert("{{ session('error') }}");
                        </script>
                    @endif

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
                // ======= HAMBURGER TOGGLE FUNCTIONALITY ======= //
                const hamburger = document.getElementById("hamburger");
                const navLinks = document.getElementById("navLinks");

                // Toggle burger open/close
                hamburger.addEventListener("click", () => {
                    hamburger.classList.toggle("active");
                    navLinks.classList.toggle("active");
                    document.body.classList.toggle("noscroll");
                });

                // ======= DROPDOWN FUNCTIONALITY ======= //
                document.querySelectorAll(".dropdown > button").forEach(button => {
                    button.addEventListener("click", e => {
                        e.stopPropagation(); // prevent closing burger
                        const dropdown = button.parentElement;

                        // Close other dropdowns
                        document.querySelectorAll(".dropdown.active").forEach(d => {
                            if (d !== dropdown) d.classList.remove("active");
                        });

                        // Toggle this dropdown
                        dropdown.classList.toggle("active");
                    });
                });

                // Close dropdowns when clicking outside
                document.addEventListener("click", e => {
                    if (!e.target.closest(".dropdown")) {
                        document.querySelectorAll(".dropdown.active").forEach(d => d.classList.remove("active"));
                    }
                });

                // ======= CLOSE BURGER ONLY ON REGULAR LINK CLICK ======= //
                document.querySelectorAll(".nav-links a").forEach(link => {
                    link.addEventListener("click", () => {
                        if (window.innerWidth <= 992) {
                            navLinks.classList.remove("active");
                            hamburger.classList.remove("active");
                            document.body.classList.remove("noscroll");
                        }
                    });
                });


                // Hide loader after page load
                window.addEventListener("load", function() {
                    setTimeout(function() {
                        document.getElementById("loader-wrapper").style.display = "none";
                    }, 1500);
                });
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
                // Optional: Close menu when a regular link is clicked (but NOT dropdown toggles)
            </script>
</body>

</html>
