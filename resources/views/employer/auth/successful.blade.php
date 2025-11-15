<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Employer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('css/applicant/employer/successful.css') }}" rel="stylesheet">
    <link href="{{ asset('css/applicant/landingpage/landingpage.css') }}" rel="stylesheet">
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
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" />
            
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

    <div class="success-container p-4">
        <!-- Success Icon -->
        <div class="success-icon">
            <i class="fas fa-check fa-3x text-white"></i>
        </div>
        <!-- Success Message -->
        <h1 class="display-4 fw-bold text-dark mb-3">Registration Successful!</h1>
        <p class="lead text-muted mb-4">
            Your employer account has been created successfully.
        </p>

        <!-- Contact Information -->
        <div class="info-card mt-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-envelope text-primary me-2"></i>Confirmation Sent
            </h5>
            <p class="mb-3">A confirmation email has been sent to:</p>
            <div class="alert alert-info">
                <i class="fas fa-mail-bulk me-2"></i>
                <strong>{{ $email }}</strong>
            </div>
            <p class="small text-muted">
                Please check your email for detailed next steps and account activation instructions.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="mt-5">
            <a href="{{ route('employer.login.display') }}" class="btn btn-primary-custom btn-lg me-3">
                <i class="fas fa-home me-2"></i>Return to login
            </a>
            <a href="{{ route('display.aboutus') }}" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-phone me-2"></i>Contact Support
            </a>
        </div>

        <!-- Additional Information -->
        <div class="mt-4">
            <p class="small text-muted">
                <i class="fas fa-clock me-1"></i>
                Registration completed on <strong>{{ date('F j, Y \a\t g:i A') }}</strong>
            </p>
            <p class="small text-muted">
                Need help? Contact us at
                <strong>
                    <a href="mailto:manggagawangpinoycompany@gmail.com" class="text-decoration-none">
                        manggagawangpinoycompany@gmail.com
                    </a>
                </strong>
                or call <strong>+63 99 999 9999</strong>
            </p>
        </div>
    </div>

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
                } catch (err) {
                    log('Error:', err.message);
                }
            });
        })();
    </script>
</body>

</html>
