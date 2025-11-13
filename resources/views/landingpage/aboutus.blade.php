<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Capstone Team</title>
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/about_us.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>
    <!-- Navigation (from your original) -->
    <nav>
        <div class="navbar-container">
            <div class="nav-logo">
                <a href="{{ route('display.index') }}" class="d-flex align-items-center gap-2"
                    style="text-decoration:none;">
                    <img src="img/logotext.png" alt="MP Logo" id="home" /></a>
                <img src="img/logo.png" alt="MP Logo" id="home2" />

            </div>
            <ul class="nav-links" id="navLinks">
                {{-- <li><a href="#">Services</a></li> --}}
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Meet Our Team</h1>
            <p>Passionate developers and designers working together to create innovative solutions through our capstone
                project</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Project Overview -->
        <section class="project-overview">
            <h2>About Our Capstone Project</h2>
            <p>Our capstone project, "Manggagawang Pinoy," represents the culmination of our academic journey. We've
                developed a comprehensive web-based job-matching platform designed to bridge the gap between blue-collar
                Filipino workers and employers. Through innovative features like AR portfolios, real-time messaging, and
                TESDA certification verification, we're creating meaningful solutions that address real-world challenges
                in the employment sector.</p>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="stat-card">
                <span class="stat-number">5</span>
                <div class="stat-label">Team Members</div>
            </div>
            <div class="stat-card">
                <span class="stat-number">6</span>
                <div class="stat-label">Months Development</div>
            </div>
            <div class="stat-card">
                <span class="stat-number">10+</span>
                <div class="stat-label">Technologies Used</div>
            </div>
            <div class="stat-card">
                <span class="stat-number">100%</span>
                <div class="stat-label">Dedication</div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team-section">
            <h2>Our Development Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">
                        <span><img src="{{ asset('img/xander formal.png') }}" alt="Alexander Bataller"
                                style="margin-top: 90px;">
                        </span>
                    </div>
                    <h3 class="member-name">Alexander Bataller</h3>
                    <p class="member-role">Quality Assurance & Testing Lead</p>
                    <p class="member-description">Quality Assurance Lead specializing in web app testing and automation.
                        I ensure seamless user experiences by delivering reliable, bug-free applications through
                        expert test strategies.

                    </p>
                    <div class="member-skills">
                        <span class="skill-tag">Test Automation</span>
                        <span class="skill-tag">Selenium</span>
                        <span class="skill-tag">Performance Testing</span>
                        <span class="skill-tag">Quality Assurance</span>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <span> <span><img src="{{ asset('img/paw_formal.png') }}" alt="Rogelio Cerenado Jr."
                                    style="width:180%; position:absolute; left: -40%; top: -65%;">
                            </span>
                    </div>
                    <h3 class="member-name">Rogelio Cerenado Jr.</h3>
                    <p class="member-role">Full-Stack Developer & Database Architect</p>
                    <p class="member-description">Skilled full-stack developer and database architect
                        delivering scalable web apps and optimized data solutions. Passionate about clean code,
                        performance, and innovation.</p>
                    <div class="member-skills">
                        <span class="skill-tag">Hostinger</span>
                        <span class="skill-tag">MySQL</span>
                        <span class="skill-tag">API Development</span>
                        <span class="skill-tag">Laravel</span>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <span><img src="{{ asset('img/prins formal.png') }}" alt="Prince Robie Dimas"
                                style="width:180%; position:absolute; left: -40%; top: -65%;"></span>
                    </div>
                    <h3 class="member-name">Prince Robie Dimas</h3>
                    <p class="member-role">Researcher & Tester</p>
                    <p class="member-description">Dedicated researcher and tester committed to ensuring quality and
                        accuracy. Expert in analyzing data, identifying issues,
                        and validating solutions to support informed decisions and high-quality outcomes.</p>
                    <div class="member-skills">
                        <span class="skill-tag">ChatGPT</span>
                        <span class="skill-tag">Microsoft Workspace</span>
                        <span class="skill-tag">Test automation</span>
                        <span class="skill-tag">Perfomance Testing</span>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <span><img src="{{ asset('img/carlo formal.png') }}" alt="John Carlo Saulog"
                                style="width:150%; position:absolute; left: -25%; top: -40%;"></span>
                    </div>
                    <h3 class="member-name">John Carlo Saulog</h3>
                    <p class="member-role">Researcher & Writer</p>
                    <p class="member-description">Detail-oriented research and writer specializing in clear, accurate
                        project documentation. Skilled at gathering information, creating comprehensive reports, and
                        ensuring
                        effective communication throughout the project lifecycle.</p>
                    <div class="member-skills">
                        <span class="skill-tag">ChatGPT</span>
                        <span class="skill-tag">Microsoft Workspace</span>
                        <span class="skill-tag">Google</span>
                        <span class="skill-tag">Google Scholar</span>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <span><img src="{{ asset('img/khad formal.png') }}" alt="Khadley Cyle Wong"
                                style="width:130%; position:absolute; left: -15%; top: -60%;"></span>
                    </div>
                    <h3 class="member-name">Khadley Cyle Wong</h3>
                    <p class="member-role">UI/UX Designer & Frontend Developer</p>
                    <p class="member-description">Creative UI/UX designer and frontend developer crafting intuitive,
                        visually engaging web experiences. Skilled in blending design and code
                        to build responsive, user-centered interfaces that delight and perform</p>
                    <div class="member-skills">
                        <span class="skill-tag">Figma</span>
                        <span class="skill-tag">CSS/SCSS</span>
                        <span class="skill-tag">Javascript</span>
                        <span class="skill-tag">User Research</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- Mission Section -->
        <section class="mission-section">
            <h2>Our Mission & Vision</h2>
            <p>We are committed to creating innovative technological solutions that address real-world challenges in the
                Philippine employment sector. Our capstone project aims to empower blue-collar workers by providing them
                with modern tools to showcase their skills and connect with potential employers. Through collaboration,
                creativity, and dedication to excellence, we strive to make a meaningful impact in bridging the
                employment gap and supporting the Filipino workforce in the digital age.</p>
        </section>
    </main>

    <!-- Footer (from your original) -->
    <footer class="footer">
        <div class="footer-col about">
            <img src="img/logo.png" class="logo-placeholder">
            <p>
                Manggagawang Pinoy is a web-based job-matching platform designed to help blue-collar Filipino workers
                connect with employers.
            </p>
            <a href="#">Our Capstone Journey</a>
        </div>
        <div class="footer-col contact">
            <h4>Contact Our Team</h4>
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
                </span>mangaggawangpinoycompany@gmail.com</p>
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

    <script>
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('navLinks');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');

            // Toggle scroll lock on body
            document.body.classList.toggle('noscroll');
        });

        // Close menu when clicking a link (mobile)
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    hamburger.classList.remove('active');

                    // Remove scroll lock on body
                    document.body.classList.remove('noscroll');
                }
            });
        });

        // Scroll to top when logo is clicked
        document.getElementById('home2').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.querySelectorAll('.dropdown button').forEach(btn => {
            btn.addEventListener('click', e => {
                const dropdown = btn.closest('.dropdown');
                const isActive = dropdown.classList.contains('active');

                // close any open popups first
                document.querySelectorAll('.dropdown.active').forEach(d => d.classList.remove('active'));

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
                    const b = d.querySelector('button, .dropdown-toggle, [role="button"]');
                    if (b) b.setAttribute('aria-expanded', 'false');
                });

                if (hamburger) hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            }
        });
    </script>
</body>

</html>
