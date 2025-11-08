<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>manggagawangpinoy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>
    <!-- Responsive Navbar (HTML) -->
    <nav>
        <div class="navbar-container">
            <div class="nav-logo">
                <img src="img/logotext.png" alt="MP Logo" id="home" />
                <img src="img/logo.png" alt="MP Logo" id="home2" />
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
                    <button class="sign-up-b">Sign up </button>
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


    <section class="section1" id="slideshow">
        <div class="content">
            <div>
                <h1>Building the Future <br />One Skill at a Time</h1>
                <p>Partnership With <span>TESDA</span></p>
                <button class="sign-up-b" id="wideb">Get Started</button>

                <!-- role modal removed from here to avoid stacking/transform issues -->

                <button class="sign-up-b" id="wideb2">Tutorial</button>
            </div>
            <div>
                <img class="biglogo" src="img/logo.png" alt="Logo" />
            </div>
        </div>
    </section>

    <section id="features">
        <div class="features-section">
            <h1>FEATURES</h1><br><br><br>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="flip-card-inner">
                        <div class="front">
                            <div class="feature-icon">

                                <!-- Example Resume SVG -->
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="black"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                </svg>
                            </div>
                            <div>
                                <strong>Resume Builder</strong>
                                <p>Workers will have the ability to generate a job resume directly from the information
                                    in their profile.</p>
                            </div>
                        </div>
                        <div class="back">
                            <img src="img/resumebuilder.png" alt="Feature image" />
                        </div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="flip-card-inner">
                        <div class="front">
                            <div class="feature-icon">
                                <!-- Example Messaging SVG -->
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="black"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="22 2 11 13 9 11 2 18 22 2" />
                                </svg>
                            </div>
                            <div>
                                <strong>Real-Time Messaging</strong>
                                <p>Allows instant messaging between workers and employers. This will help both parties
                                    clarify job details and negotiate terms.</p>
                            </div>
                        </div>
                        <div class="back">
                            <img src="img/realmessage.png" alt="Feature image" />
                        </div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="flip-card-inner">
                        <div class="front">
                            <div class="feature-icon">
                                <!-- Example AR Portfolio SVG -->
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="black"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polygon points="12,6 16,18 8,18" />
                                </svg>
                            </div>
                            <div>
                                <strong>Augmented Reality Portfolio</strong>
                                <p>An AR portfolio lets employers scan a QR code to instantly view videos or images of a
                                    worker's projects in augmented reality.</p>
                            </div>
                        </div>
                        <div class="back">
                            <img src="img/arcard.png" alt="Feature image" />
                        </div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="flip-card-inner">
                        <div class="front">
                            <div class="feature-icon">
                                <!-- Example Verification SVG -->
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </div>
                            <div>
                                <strong>Verification Process</strong>
                                <p>During registration, workers are prompted to upload certifications, which are then
                                    marked as pending for Manggagawang Pinoy to approve or reject.</p>
                            </div>
                        </div>
                        <div class="back">
                            <img src="img/verification.png" alt="Feature image" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="tutorial">
        <h1>Tutorial</h1><br>
        <iframe width="100%" height="550" src="https://www.youtube.com/embed/d9fL7_BP3q8" title="Tutorial Video"
            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
        </iframe>

    </section>

    <!-- HTML ---------------------------------------------------------------------------------------------------------------------->
    <footer class="footer">
        <div class="footer-col about">
            <img src="img/logo.png" class="logo-placeholder">
            <p>
                Manggagawang Pinoy is a web-based job-matching platform designed to help blue-collar Filipino workers
                connect with employers.
            </p>
            <a href="{{ route('display.aboutus') }}">Our Team</a>
        </div>
        <div class="footer-col contact">
            <h4>Contact</h4>
            <p><span class="icon"><svg width="23" height="19" viewBox="0 0 43 39" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.5 35.75C21.0819 35.75 20.7236 35.6417 20.425 35.425C20.1264 35.2083 19.9024 34.924 19.7531 34.5719C19.1858 33.0552 18.4691 31.6333 17.6031 30.3062C16.767 28.9792 15.5875 27.4219 14.0646 25.6344C12.5417 23.8469 11.3024 22.1406 10.3469 20.5156C9.42118 18.8906 8.95833 16.9271 8.95833 14.625C8.95833 11.4562 10.1677 8.775 12.5865 6.58125C15.0351 4.36042 18.0062 3.25 21.5 3.25C24.9937 3.25 27.95 4.36042 30.3687 6.58125C32.8174 8.775 34.0417 11.4562 34.0417 14.625C34.0417 17.0896 33.5191 19.1479 32.474 20.8C31.4587 22.425 30.2792 24.0365 28.9354 25.6344C27.3229 27.5844 26.0986 29.2094 25.2625 30.5094C24.4562 31.7823 23.7844 33.1365 23.2469 34.5719C23.0976 34.951 22.8587 35.249 22.5302 35.4656C22.2316 35.6552 21.8882 35.75 21.5 35.75ZM21.5 18.6875C22.7542 18.6875 23.8142 18.2948 24.6802 17.5094C25.5462 16.724 25.9792 15.7625 25.9792 14.625C25.9792 13.4875 25.5462 12.526 24.6802 11.7406C23.8142 10.9552 22.7542 10.5625 21.5 10.5625C20.2458 10.5625 19.1858 10.9552 18.3198 11.7406C17.4538 12.526 17.0208 13.4875 17.0208 14.625C17.0208 15.7625 17.4538 16.724 18.3198 17.5094C19.1858 18.2948 20.2458 18.6875 21.5 18.6875Z"
                            fill="#1D1B20" />
                    </svg></span>MetroGate Silang Estates, Silang, Cavite</p>
            <p><span class="icon"><svg width="16" height="16" viewBox="0 0 36 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M33 25.3801V29.8801C33.0017 30.2979 32.9161 30.7114 32.7488 31.0942C32.5814 31.4769 32.336 31.8205 32.0281 32.1029C31.7203 32.3854 31.3569 32.6004 30.9611 32.7342C30.5654 32.868 30.1461 32.9177 29.73 32.8801C25.1143 32.3786 20.6805 30.8014 16.785 28.2751C13.1607 25.9721 10.088 22.8994 7.78501 19.2751C5.24997 15.362 3.67237 10.9066 3.18001 6.27015C3.14252 5.85535 3.19182 5.43729 3.32476 5.04258C3.4577 4.64788 3.67136 4.28518 3.95216 3.97758C4.23295 3.66997 4.57471 3.42421 4.95569 3.25593C5.33667 3.08765 5.74852 3.00054 6.16501 3.00015H10.665C11.393 2.99298 12.0987 3.25076 12.6506 3.72544C13.2026 4.20013 13.5631 4.85932 13.665 5.58015C13.8549 7.02025 14.2072 8.43424 14.715 9.79515C14.9168 10.332 14.9605 10.9155 14.8409 11.4765C14.7212 12.0374 14.4433 12.5523 14.04 12.9601L12.135 14.8651C14.2703 18.6205 17.3797 21.7298 21.135 23.8651L23.04 21.9601C23.4478 21.5569 23.9627 21.2789 24.5237 21.1593C25.0846 21.0397 25.6681 21.0833 26.205 21.2851C27.5659 21.793 28.9799 22.1452 30.42 22.3351C31.1487 22.4379 31.8141 22.805 32.2898 23.3664C32.7655 23.9278 33.0183 24.6445 33 25.3801Z"
                            stroke="#1E1E1E" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>09275044091</p>
            <p><span class="icon"><svg width="23" height="21" viewBox="0 0 33 31" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.5 25.8332C4.74375 25.8332 4.09063 25.5856 3.54063 25.0905C3.01354 24.5738 2.75 23.9603 2.75 23.2498V7.74984C2.75 7.03942 3.01354 6.43664 3.54063 5.9415C4.09063 5.42484 4.74375 5.1665 5.5 5.1665H27.5C28.2563 5.1665 28.8979 5.42484 29.425 5.9415C29.975 6.43664 30.25 7.03942 30.25 7.74984V23.2498C30.25 23.9603 29.975 24.5738 29.425 25.0905C28.8979 25.5856 28.2563 25.8332 27.5 25.8332H5.5ZM16.5 16.7915L27.5 10.3332V7.74984L16.5 14.2082L5.5 7.74984V10.3332L16.5 16.7915Z"
                            fill="#1D1B20" />
                    </svg>
                </span>manggagawangpinoycompany@gmail.com</p>
        </div>
        <div class="footer-col links">
            <h4>Links</h4>
            <ul>
                <li><a href="index">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#tutorial">Tutorial</a></li>
                <li><a href="https://www.tesda.gov.ph/">TESDA</a>
                </li>
            </ul>
        </div>
    </footer>

    <!-- Role modal moved outside .section1 so fixed positioning and z-index work correctly -->
    <div class="modal" id="roleModal" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="modal-content">
            <h2>SELECT YOUR ROLE</h2>
            <div class="role-container">
                <div class="role-card" onclick="window.location.href='{{ route('employer.register.display') }}'">
                    <img id="workeroremployer" src="https://img.icons8.com/ios-filled/100/000000/manager.png"
                        alt="Employer">
                    <h3>Employer</h3>
                    <button class="select-btn">Select</button>
                </div>

                <div class="role-card" onclick="window.location.href='{{ route('applicant.register.display') }}'">
                    <img id="workeroremployer" src="https://img.icons8.com/ios-filled/100/000000/worker-male.png"
                        alt="Worker">
                    <h3>Worker</h3>
                    <button class="select-btn">Select</button>
                </div>
            </div>
            <button class="close-btn" id="closeModal">Cancel</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const hamburger = document.getElementById('hamburger');
                const navLinks = document.getElementById('navLinks');
                const isMobile = () => window.innerWidth <= 900;

                const closeMobileMenu = () => {
                    if (!navLinks || !hamburger) return;
                    navLinks.classList.remove('active');
                    hamburger.classList.remove('active');

                    // collapse open dropdowns
                    navLinks.querySelectorAll('.dropdown.open').forEach(d => {
                        d.classList.remove('open');
                        const m = d.querySelector('.dropdown-menu');
                        if (m) m.style.maxHeight = null;
                        const b = d.querySelector('button, .dropdown-toggle, [role="button"]');
                        if (b) b.setAttribute('aria-expanded', 'false');
                    });
                };

                if (hamburger && navLinks) {
                    // toggle panel
                    hamburger.addEventListener('click', e => {
                        e.stopPropagation();
                        hamburger.classList.toggle('active');
                        navLinks.classList.toggle('active');

                    });

                    // close panel on real link click (mobile)
                    navLinks.querySelectorAll('a').forEach(a => {
                        a.addEventListener('click', () => {
                            if (isMobile() && navLinks.classList.contains('active'))
                                closeMobileMenu();
                        });
                    });

                    // dropdown toggles
                    navLinks.querySelectorAll('.dropdown').forEach(drop => {
                        let trigger = drop.querySelector('button, .dropdown-toggle');
                        if (!trigger) {
                            const firstLink = drop.querySelector('a');
                            if (firstLink) {
                                firstLink.setAttribute('role', 'button');
                                trigger = firstLink;
                            }
                        }
                        const menu = drop.querySelector('.dropdown-menu');
                        if (!trigger || !menu) return;

                        // init aria
                        trigger.setAttribute('aria-expanded', 'false');
                        trigger.setAttribute('aria-haspopup', 'true');

                        trigger.addEventListener('click', function(ev) {
                            if (!isMobile()) return;
                            ev.preventDefault();
                            ev.stopPropagation();
                            const open = drop.classList.contains('open');

                            // close other dropdowns (accordion behavior)
                            navLinks.querySelectorAll('.dropdown.open').forEach(other => {
                                if (other === drop) return;
                                other.classList.remove('open');
                                const om = other.querySelector('.dropdown-menu');
                                if (om) om.style.maxHeight = null;
                                const ob = other.querySelector(
                                    'button, .dropdown-toggle, [role="button"]');
                                if (ob) ob.setAttribute('aria-expanded', 'false');
                            });

                            if (open) {
                                drop.classList.remove('open');
                                menu.style.maxHeight = null;
                                trigger.setAttribute('aria-expanded', 'false');
                            } else {
                                drop.classList.add('open');
                                // set explicit maxHeight for smooth transition
                                menu.style.maxHeight = menu.scrollHeight + 'px';
                                trigger.setAttribute('aria-expanded', 'true');
                                // ensure panel visible
                                if (!navLinks.classList.contains('active')) {
                                    navLinks.classList.add('active');
                                    hamburger.classList.add('active');

                                }
                            }
                        });

                        // submenu links close panel on navigation (mobile)
                        menu.querySelectorAll('a').forEach(sa => sa.addEventListener('click', () => {
                            if (isMobile()) closeMobileMenu();
                        }));
                    });

                    // click outside: collapse submenus
                    document.addEventListener('click', function(e) {
                        if (!navLinks.contains(e.target) && !hamburger.contains(e.target)) {
                            navLinks.querySelectorAll('.dropdown.open').forEach(d => {
                                d.classList.remove('open');
                                const m = d.querySelector('.dropdown-menu');
                                if (m) m.style.maxHeight = null;
                                const b = d.querySelector(
                                    'button, .dropdown-toggle, [role="button"]');
                                if (b) b.setAttribute('aria-expanded', 'false');
                            });
                        }
                    });
                    document.querySelectorAll('.dropdown button').forEach(btn => {
                        btn.addEventListener('click', e => {
                            const dropdown = btn.closest('.dropdown');
                            const isActive = dropdown.classList.contains('active');

                            // close any open popups first
                            document.querySelectorAll('.dropdown.active').forEach(d => d.classList
                                .remove('active'));

                            // toggle the current one
                            if (!isActive) dropdown.classList.add('active');
                        });
                    });

                    // close popup when clicking outside or close button
                    document.addEventListener('click', e => {
                        if (e.target.classList.contains('dropdown-menu')) {
                            e.target.closest('.dropdown').classList.remove('active');
                        }
                    });


                    // ESC closes panel and submenus
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') closeMobileMenu();
                    });

                    // on resize, cleanup mobile-only inline styles
                    window.addEventListener('resize', function() {
                        if (!isMobile() && navLinks) {
                            navLinks.querySelectorAll('.dropdown .dropdown-menu').forEach(m => {
                                m.style.maxHeight = null;
                            });
                            navLinks.querySelectorAll('.dropdown').forEach(d => {
                                d.classList.remove('open');
                                const b = d.querySelector(
                                    'button, .dropdown-toggle, [role="button"]');
                                if (b) b.setAttribute('aria-expanded', 'false');
                            });

                            if (hamburger) hamburger.classList.remove('active');
                            navLinks.classList.remove('active');
                        }
                    });
                }

                // --- existing modal, tutorial, scroll handlers kept as before ---
                const modal = document.getElementById('roleModal');
                const getStartedBtn = document.getElementById('wideb');
                const closeBtn = document.getElementById('closeModal');
                if (getStartedBtn && modal) {
                    getStartedBtn.addEventListener('click', () => {
                        modal.style.display = 'flex';
                    });
                }
                if (closeBtn && modal) {
                    closeBtn.addEventListener('click', () => {
                        modal.style.display = 'none';
                    });
                    window.addEventListener('click', (event) => {
                        if (event.target === modal) modal.style.display = 'none';
                    });
                }

                const tutorialBtn = document.getElementById('wideb2');
                if (tutorialBtn) tutorialBtn.addEventListener('click', function() {
                    const tutorial = document.getElementById('tutorial');
                    if (tutorial) tutorial.scrollIntoView({
                        behavior: 'smooth'
                    });
                });

                document.addEventListener('scroll', function() {
                    const section = document.querySelector('.section1');
                    if (!section) return;
                    const rect = section.getBoundingClientRect();
                    const scrolled = Math.min(Math.max(-rect.top, 0), rect.height);
                    const scale = 1 + (scrolled / rect.height) * 0.20;
                    section.style.setProperty('--bg-scale', scale);
                }, {
                    passive: true
                });

                ['home', 'home2'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.addEventListener('click', function() {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                });

            } catch (err) {
                console.error('Landing page init error:', err);
            }
        });
    </script>
</body>

</html>
