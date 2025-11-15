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
                <li class="dropdown">
                    <button class="sign-up-b">Sign up</button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.register.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.register.display') }}">As Employer</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Mobile Hamburger -->
            <button id="m-hamburger" class="m-hamburger" aria-label="Open menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Mobile navbar -->
            <div class="mobile-overlay" id="mobileOverlay" aria-hidden="true"></div>

            <div class="mobile-navbar" id="mobileNavbar" role="dialog" aria-modal="true" aria-hidden="true">
                <div class="nav-top nav-logo">
                     <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home" />
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2"/>
                    <button id="closeMenu" class="close-btn" aria-label="Close menu"></button>
                </div>

                <ul class="mobile-menu" role="menu" aria-label="Mobile main menu">
                    <li role="none"><a role="menuitem" href="{{ route('display.topworker') }}">Top Workers</a></li>
                    <li role="none"><a role="menuitem" href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                    <li role="none"><a role="menuitem" href="{{ route('display.aboutus') }}">About Us</a></li>

                    <li class="dropdown" role="none">
                        <button class="dropdown-btn" aria-expanded="false">Sign in</button>
                        <ul class="dropdown-content" role="menu" aria-hidden="true">
                            <li role="none"><a role="menuitem" href="{{ route('applicant.login.display') }}">As Applicant</a>
                            </li>
                            <li role="none"><a role="menuitem" href="{{ route('employer.login.display') }}">As Employer</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown" role="none">
                        <button class="dropdown-btn" aria-expanded="false">Sign up</button>
                        <ul class="dropdown-content" role="menu" aria-hidden="true">
                            <li role="none"><a role="menuitem" href="{{ route('applicant.register.display') }}">As Applicant</a>
                            </li>
                            <li role="none"><a role="menuitem" href="{{ route('employer.register.display') }}">As Employer</a>
                            </li>
                        </ul>
                    </li>
                </ul>
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


                        <!-- Submit Button -->
                        <button type="submit" class="submit-btn" id="submitBtn" disabled>
                            <i class="bi bi-shield-check me-2"></i>Verify Email
                        </button>
                    </form>
                    <!-- Resend -->
                    <!-- Resend -->
                    <div class="resend-container" style="margin-top: 10px;">
                        <span style="color: #64748b; font-size: 14px;">Didn't receive the code?</span>

                        <form action="{{ route('verification.resend') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="button" class="resend-btn" id="resendBtn" disabled>
                                Resend Code (<span id="countdown">30</span>s)
                            </button>
                        </form>
                    </div>

                    <script>
                        const resendBtn = document.getElementById('resendBtn');
                        const countdownSpan = document.getElementById('countdown');
                        let resendCountdown = 30;
                        let resendTimer = null;

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
                                    resendBtn.innerHTML = 'Resend Code';
                                }
                            }, 1000);
                        }

                        // Handle resend click
                        resendBtn.addEventListener('click', () => {
                            resendBtn.disabled = true;
                            resendBtn.innerHTML = 'Sending...';

                            fetch("{{ route('verification.resend') }}", {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Content-Type": "application/json",
                                        "Accept": "application/json",
                                    },
                                    body: JSON.stringify({})
                                })
                                .then(async response => {
                                    let data = {};
                                    try {
                                        data = await response.json();
                                    } catch (e) {}
                                    alert(data.message || "A new code has been sent to your email.");

                                    // Reset button with countdown again
                                    resendBtn.innerHTML = 'Resend Code (<span id="countdown">30</span>s)';
                                    startResendCountdown();
                                })
                                .catch(error => {
                                    console.error(error);
                                    alert("Something went wrong: " + error.message);
                                    resendBtn.disabled = false;
                                    resendBtn.innerHTML = 'Resend Code';
                                });
                        });

                        // Start countdown when page loads
                        document.addEventListener('DOMContentLoaded', startResendCountdown);
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

            <script>
                (function() {
                    function log(...args) { if (window.console) console.log('[nav]', ...args); }

                    document.addEventListener('DOMContentLoaded', () => {
                        try {
                            // ====== wire new mobile-navbar ======
                            const hamburger = document.getElementById('m-hamburger');
                            const mobileNavbar = document.getElementById('mobileNavbar');
                            const closeMenu = document.getElementById('closeMenu');
                            const overlay = document.getElementById('mobileOverlay');

                            function openMenu() {
                                mobileNavbar.classList.add('open');
                                overlay.classList.add('show');
                                hamburger.classList.add('active');
                                hamburger.setAttribute('aria-expanded', 'true');
                                mobileNavbar.setAttribute('aria-hidden', 'false');
                                document.body.style.overflow = 'hidden';
                            }

                            function closeMenuFn() {
                                mobileNavbar.classList.remove('open');
                                overlay.classList.remove('show');
                                hamburger.classList.remove('active');
                                hamburger.setAttribute('aria-expanded', 'false');
                                mobileNavbar.setAttribute('aria-hidden', 'true');
                                document.body.style.overflow = 'auto';
                            }

                            if (hamburger && mobileNavbar) {
                                hamburger.addEventListener('click', (e) => {
                                    e.stopPropagation();
                                    if (window.innerWidth <= 768) {
                                        if (mobileNavbar.classList.contains('open')) closeMenuFn();
                                        else openMenu();
                                    }
                                });

                                closeMenu.addEventListener('click', (e) => {
                                    e.stopPropagation();
                                    closeMenuFn();
                                });

                                overlay.addEventListener('click', closeMenuFn);

                                // dropdown toggles
                                mobileNavbar.querySelectorAll('.dropdown').forEach(drop => {
                                    const btn = drop.querySelector('.dropdown-btn');
                                    const menu = drop.querySelector('.dropdown-content');
                                    btn.addEventListener('click', (ev) => {
                                        ev.stopPropagation();
                                        const isOpen = drop.classList.toggle('open');
                                        btn.setAttribute('aria-expanded', String(isOpen));
                                        if (menu) menu.setAttribute('aria-hidden', String(!isOpen));
                                    });
                                });

                                // close when selecting a link
                                mobileNavbar.querySelectorAll('a').forEach(a => {
                                    a.addEventListener('click', () => closeMenuFn());
                                });

                                // close on ESC
                                document.addEventListener('keydown', (e) => {
                                    if (e.key === 'Escape') closeMenuFn();
                                });

                                // click outside closes menu
                                document.addEventListener('click', (e) => {
                                    if (!mobileNavbar.contains(e.target) && !hamburger.contains(e.target)) {
                                        closeMenuFn();
                                    }
                                });

                                log('Mobile navbar initialized');
                            }

                            // Hide loader after page load
                            window.addEventListener("load", function() {
                                setTimeout(function() {
                                    const loader = document.getElementById("loader-wrapper");
                                    if (loader) loader.style.display = "none";
                                }, 1500);
                            });

                        } catch (err) {
                            log('Error:', err.message);
                        }
                    });
                })();
            </script>
</body>

</html>
