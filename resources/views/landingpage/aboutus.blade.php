<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Capstone Team</title>

    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <style>
        /* Reset */
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #f9fafb;
        }

        /* Navigation styles (from your original) */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: #ffffff;
            color: white;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            z-index: 1000;
            height: 78px;
            align-items: center;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            padding: 5px 16px;
        }

        .nav-logo {
            display: flex;
            align-items: inherit;
            gap: 8px;
        }

        .nav-logo img {
            height: 50px;
            width: auto;
            display: block;
            cursor: pointer;
            user-select: none;
            transition: opacity 0.3s ease;
            filter: invert(45%) sepia(84%) saturate(10058%) hue-rotate(247deg) brightness(47%) contrast(121%);
        }

        .nav-logo img:hover {
            opacity: 0.8;
        }

        .nav-links {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #000000;
            font-weight: 400;
            font-size: 1rem;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-links a::after {
            content: "";
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #020180;
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: #020180;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .sign-in-b {
            display: inline-block;
            padding: 0 14px;
            line-height: 28px;
            background: #b1bad1;
            color: #000000;
            font-size: 15px;
            border: none;
            margin-top: 10px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: background 0.2s, box-shadow 0.2s;
            text-align: center;
        }

        .sign-in-b:hover {
            background: #678fff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .sign-up-b {
            display: inline-block;
            padding: 0 14px;
            line-height: 28px;
            background: #020180;
            color: #ffffff;
            font-size: 15px;
            border: none;
            margin-top: 10px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: background 0.2s, box-shadow 0.2s;
            text-align: center;
        }

        .sign-up-b:hover {
            background: #678fff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        /* Dropdown styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background: white;
            min-width: 150px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 8px 0;
            z-index: 1000;
        }

        .dropdown-menu li {
            list-style: none;
        }

        .dropdown-menu li a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            transition: background 0.3s;
        }

        .dropdown-menu li a:hover {
            background: #f1f1f1;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Hamburger menu */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .hamburger div {
            width: 25px;
            height: 3px;
            background: #d1d5db;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 500px;
            background: linear-gradient(135deg, #020180 0%, #678fff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 78px;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="0,0 1000,100 1000,0"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 2rem;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-content p {
            font-size: 1.3rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        /* Project Overview */
        .project-overview {
            text-align: center;
            margin-bottom: 5rem;
        }

        .project-overview h2 {
            font-size: 2.5rem;
            color: #020180;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .project-overview p {
            font-size: 1.2rem;
            color: #555;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* Team Section */
        .team-section h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #020180;
            margin-bottom: 3rem;
            font-weight: 600;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2.5rem;
            margin-bottom: 4rem;
        }

        /* Team Member Cards */
        .team-member {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .team-member::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #020180, #678fff);
        }

        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(2, 1, 128, 0.15);
        }

        .member-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #020180, #678fff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .member-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .member-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .member-role {
            font-size: 1.1rem;
            color: #020180;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .member-description {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .member-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
        }

        .skill-tag {
            background: #f0f0ff;
            color: #020180;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Mission Section */
        .mission-section {
            background: linear-gradient(135deg, #f8f9ff, #ffffff);
            border-radius: 20px;
            padding: 3rem;
            margin: 4rem 0;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .mission-section h2 {
            font-size: 2.2rem;
            color: #020180;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .mission-section p {
            font-size: 1.1rem;
            color: #555;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* Stats Section */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #020180;
            display: block;
        }

        .stat-label {
            color: #666;
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        /* Footer styles (from your original) */
        .footer {
            background: #d3d3d3;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 2rem 3vw;
            font-family: "Helvetica Neue", Arial, sans-serif;
            gap: 2rem;
        }

        .footer-col {
            flex: 1 1 0;
            min-width: 220px;
        }

        .logo-placeholder {
            width: 100px;
            height: 100px;
        }

        .footer-col.about p {
            margin: 0 0 1rem 0;
            color: #222;
            font-size: 1rem;
            line-height: 1.4;
        }

        .footer-col.about a {
            color: #222;
            text-decoration: underline;
            font-size: 1rem;
        }

        .footer-col.contact h3,
        .footer-col.links h3 {
            font-weight: bold;
            margin-bottom: 1rem;
            color: #111;
            font-size: 1.1rem;
        }

        .footer-col.contact ul,
        .footer-col.links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-col.contact li {
            display: flex;
            align-items: center;
            margin-bottom: 0.7rem;
            color: #222;
            font-size: 1rem;
            gap: 0.7em;
        }

        .footer-col.contact .icon {
            font-size: 1.2em;
        }

        .footer-col.links li {
            margin-bottom: 0.7rem;
        }

        .footer-col.links a {
            color: #222;
            text-decoration: underline;
            font-size: 1rem;
        }

        .footer-col h4 {
            font-weight: bold;
            margin-bottom: 1rem;
            color: #111;
            font-size: 1.1rem;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .nav-menu-wrapper {
                position: absolute;
                bottom: 0;
                right: 0;
                height: 100vh;
                width: 40vw;
                overflow: hidden;
            }

            .nav-menu {
                position: relative;
                z-index: 1;
                width: 100%;
                height: 100%;
                background: transparent;
            }

            .hamburger {
                width: 30px;
                height: 22px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                cursor: pointer;
                z-index: 1201;
            }

            .hamburger span {
                display: block;
                height: 3px;
                background: #e50914;
                border-radius: 2px;
                transition: all 0.3s ease;
            }

            .hamburger.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }

            .hamburger.active span:nth-child(2) {
                opacity: 0;
            }

            .hamburger.active span:nth-child(3) {
                transform: rotate(-45deg) translate(5px, -5px);
            }

            .nav-links {
                position: fixed;
                left: -180%;
                width: 300vw;
                max-width: 700px;
                height: 200vh;
                background: linear-gradient(to right,
                        rgba(1, 1, 126),
                        rgba(1, 1, 126, 0.72),
                        rgba(1, 1, 126, 0));
                display: flex;
                flex-direction: column;
                gap: 2rem;
                transition: left 0.35s ease;
                z-index: 1200;
                overflow: hidden;
                padding-bottom: 100px;
            }

            .noscroll {
                overflow: hidden;
            }

            .nav-links.active {
                left: 0;
            }

            .nav-links li {
                list-style: none;
                opacity: 0;
                transform: translateX(20px);
                transition: opacity 0.3s ease, transform 0.3s ease;
            }

            .nav-links.active li {
                opacity: 1;
                transform: translateX(0);
            }

            .nav-links a,
            .nav-links button {
                font-size: 1.5rem;
                color: white;
                text-decoration: none;
                font-weight: 600;
                background: none;
                border: none;
                cursor: pointer;
                padding: 0.5rem 1rem;
                text-align: left;
                width: 100%;
                transition: color 0.3s ease;
            }

            .nav-links a:hover,
            .nav-links button:hover {
                color: #ffffff;
            }

            .footer {
                flex-direction: column;
                align-items: stretch;
                gap: 1.5rem;
            }

            .footer-col {
                min-width: 0;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .team-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .team-member {
                padding: 2rem;
            }

            .main-content {
                padding: 2rem 1rem;
            }

            .mission-section {
                padding: 2rem;
                margin: 2rem 0;
            }

            .stats-section {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .hamburger {
                display: flex;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .stats-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation (from your original) -->
    <nav>
        <div class="navbar-container">
            <div class="nav-logo">
                <a href="{{ route('display.index') }}"><img src="img/logo.png" alt="MP Logo" id="home2" /></a>
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a href="#">Services</a></li>
                <li><a href="{{ route('display.topworker') }}">Top Workers</a></li>
                <li><a href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                <li><a href="{{ route('display.aboutus') }}">About Us</a></li>
                <li><button class="sign-in-b">Sign in</button></li>

                <!-- Sign Up Dropdown -->
                <!-- Sign Up Dropdown -->
                <li class="dropdown">
                    <button class="sign-up-b">Sign up ▾</button>
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
                <span class="stat-number">6</span>
                <div class="stat-label">Team Members</div>
            </div>
            <div class="stat-card">
                <span class="stat-number">8</span>
                <div class="stat-label">Months Development</div>
            </div>
            <div class="stat-card">
                <span class="stat-number">15+</span>
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
                        <span>AL</span>
                    </div>
                    <h3 class="member-name">Alexander Lopez</h3>
                    <p class="member-role">Project Lead & Full-Stack Developer</p>
                    <p class="member-description">Leading the development team with expertise in system architecture and
                        project management. Responsible for coordinating team efforts and ensuring project milestones
                        are met while maintaining code quality standards.</p>
                    <div class="member-skills">
                        <span class="skill-tag">Laravel</span>
                        <span class="skill-tag">JavaScript</span>
                        <span class="skill-tag">Project Management</span>
                        <span class="skill-tag">MySQL</span>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <span>MR</span>
                    </div>
                    <h3 class="member-name">Maria Rodriguez</h3>
                    <p class="member-role">UI/UX Designer & Frontend Developer</p>
                    <p class="member-description">Crafting intuitive and engaging user experiences for our platform.
                        Specializes in responsive design and user interface development, ensuring our application is
                        both beautiful and functional across all devices.</p>
                    <div class="member-skills">
                        <span class="skill-tag">Figma</span>
                        <span class="skill-tag">CSS/SCSS</span>
                        <span class="skill-tag">Vue.js</span>
                        <span class="skill-tag">User Research</span>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <span>JS</span>
                    </div>
                    <h3 class="member-name">James Santos</h3>
                    <p class="member-role">Backend Developer & Database Architect</p>
                    <p class="member-description">Building robust server-side architecture and designing efficient
                        database structures. Focuses on creating scalable APIs and ensuring data security for our
                        job-matching platform.</p>
                    <div class="member-skills">
                        <span class="skill-tag">PHP</span>
                        <span class="skill-tag">MySQL</span>
                        <span class="skill-tag">API Development</span>
                        <span class="skill-tag">Server Management</span>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <span>AC</span>
                    </div>
                    <h3 class="member-name">Anna Chen</h3>
                    <p class="member-role">AR Developer & Mobile Specialist</p>
                    <p class="member-description">Implementing cutting-edge augmented reality features for worker
                        portfolios. Specializes in mobile development and AR integration, bringing innovative
                        visualization to our platform.</p>
                    <div class="member-skills">
                        <span class="skill-tag">Unity</span>
                        <span class="skill-tag">AR Foundation</span>
                        <span class="skill-tag">C#</span>
                        <span class="skill-tag">Mobile Dev</span>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <span>RG</span>
                    </div>
                    <h3 class="member-name">Roberto Garcia</h3>
                    <p class="member-role">Quality Assurance & Testing Lead</p>
                    <p class="member-description">Ensuring our platform meets the highest quality standards through
                        comprehensive testing strategies. Responsible for bug tracking, performance testing, and user
                        acceptance testing protocols.</p>
                    <div class="member-skills">
                        <span class="skill-tag">Test Automation</span>
                        <span class="skill-tag">Selenium</span>
                        <span class="skill-tag">Performance Testing</span>
                        <span class="skill-tag">Quality Assurance</span>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <span>ST</span>
                    </div>
                    <h3 class="member-name">Sofia Torres</h3>
                    <p class="member-role">Research Analyst & Documentation Specialist</p>
                    <p class="member-description">Conducting comprehensive market research and maintaining detailed
                        project documentation. Ensures our solution is research-backed and well-documented for future
                        development and maintenance.</p>
                    <div class="member-skills">
                        <span class="skill-tag">Market Research</span>
                        <span class="skill-tag">Technical Writing</span>
                        <span class="skill-tag">Data Analysis</span>
                        <span class="skill-tag">Documentation</span>
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
                This capstone project was developed by a dedicated team of computer science students, creating
                innovative solutions for the Filipino workforce through technology and research.
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
                    </svg></span>University Campus, Computer Science Department</p>
            <p><span class="icon"><svg width="16" height="16" viewBox="0 0 36 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M33 25.3801V29.8801C33.0017 30.2979 32.9161 30.7114 32.7488 31.0942C32.5814 31.4769 32.336 31.8205 32.0281 32.1029C31.7203 32.3854 31.3569 32.6004 30.9611 32.7342C30.5654 32.868 30.1461 32.9177 29.73 32.8801C25.1143 32.3786 20.6805 30.8014 16.785 28.2751C13.1607 25.9721 10.088 22.8994 7.78501 19.2751C5.24997 15.362 3.67237 10.9066 3.18001 6.27015C3.14252 5.85535 3.19182 5.43729 3.32476 5.04258C3.4577 4.64788 3.67136 4.28518 3.95216 3.97758C4.23295 3.66997 4.57471 3.42421 4.95569 3.25593C5.33667 3.08765 5.74852 3.00054 6.16501 3.00015H10.665C11.393 2.99298 12.0987 3.25076 12.6506 3.72544C13.2026 4.20013 13.5631 4.85932 13.665 5.58015C13.8549 7.02025 14.2072 8.43424 14.715 9.79515C14.9168 10.332 14.9605 10.9155 14.8409 11.4765C14.7212 12.0374 14.4433 12.5523 14.04 12.9601L12.135 14.8651C14.2703 18.6205 17.3797 21.7298 21.135 23.8651L23.04 21.9601C23.4478 21.5569 23.9627 21.2789 24.5237 21.1593C25.0846 21.0397 25.6681 21.0833 26.205 21.2851C27.5659 21.793 28.9799 22.1452 30.42 22.3351C31.1487 22.4379 31.8141 22.805 32.2898 23.3664C32.7655 23.9278 33.0183 24.6445 33 25.3801Z"
                            stroke="#1E1E1E" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>+63 912 345 6789</p>
            <p><span class="icon"><svg width="23" height="21" viewBox="0 0 33 31" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.5 25.8332C4.74375 25.8332 4.09063 25.5856 3.54063 25.0905C3.01354 24.5738 2.75 23.9603 2.75 23.2498V7.74984C2.75 7.03942 3.01354 6.43664 3.54063 5.9415C4.09063 5.42484 4.74375 5.1665 5.5 5.1665H27.5C28.2563 5.1665 28.8979 5.42484 29.425 5.9415C29.975 6.43664 30.25 7.03942 30.25 7.74984V23.2498C30.25 23.9603 29.975 24.5738 29.425 25.0905C28.8979 25.5856 28.2563 25.8332 27.5 25.8332H5.5ZM16.5 16.7915L27.5 10.3332V7.74984L16.5 14.2082L5.5 7.74984V10.3332L16.5 16.7915Z"
                            fill="#1D1B20" />
                    </svg>
                </span>capstoneteam2024@university.edu</p>
        </div>
        <div class="footer-col links">
            <h4>Project Links</h4>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Features</a></li>
                <li><a href="#">Documentation</a></li>
                <li><a href="#">GitHub Repository</a></li>
                <li><a href="#">TESDA Partnership</a></li>
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
    </script>
</body>

</html>
