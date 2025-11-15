<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hiring Preferences - Employer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/applicant/employer/hiringpreference.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/applicant/landingpage/landingpage.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>
    <!-- REPLACED NAV (updated unified nav + mobile sidebar) -->
    <nav>
        <div class="navbar-container">
            <div class="nav-logo d-flex align-items-center">
                <a href="{{ route('display.index') }}" class="d-flex align-items-center gap-2" style="text-decoration:none;">
                    <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home" />
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" />
                </a>
            </div>

            <ul class="nav-links" id="navLinks">
                <li><a href="#">Services</a></li>
                <li><a href="{{ route('display.topworker') }}">Top Workers</a></li>
                <li><a href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                <li><a href="{{ route('display.aboutus') }}">About Us</a></li>
                <li><button class="sign-in-b">Sign in</button></li>

                <!-- Sign Up Dropdown -->
                <li class="dropdown">
                    <button class="sign-up-b">Sign up ▾</button>
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

            <!-- Mobile overlay and sidebar -->
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


    <!-- Step Content (single card only now) -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="registration-container">
                    <div class="container">
                        <!-- Header -->
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-dark mb-3">
                                Employer Registration
                            </h1>
                            <p class="lead text-muted">
                                Find TESDA-certified skilled workers and blue collar professionals
                                for your projects
                            </p>
                        </div>

                        <!-- Progress Stepper -->
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-10">
                                <div class="d-flex align-items-center justify-content-between">
                                    <!-- Step 1 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-completed" id="step1">
                                            1
                                        </div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Job Details</small>
                                            <br /><small class="text-muted d-none d-sm-block">Position
                                                requirements</small>
                                        </div>
                                    </div>
                                    <div class="step-line step-line-completed" id="line1"></div>

                                    <!-- Step 2 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-completed" id="step2">
                                            2
                                        </div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Contact</small>
                                            <br /><small class="text-muted d-none d-sm-block">Your contact info</small>
                                        </div>
                                    </div>
                                    <div class="step-line step-line-completed" id="line2"></div>

                                    <!-- Step 3 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-active" id="step3">3</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Preferences</small>
                                            <br /><small class="text-muted d-none d-sm-block">Hiring preferences</small>
                                        </div>
                                    </div>
                                    <div class="step-line" id="line3"></div>

                                    <!-- Step 4 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step4">4</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Review</small>
                                            <br /><small class="text-muted d-none d-sm-block">Review & submit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header bg-white border-0 py-4">
                            <h3 class="card-title mb-2">Hiring Preferences</h3>
                            <p class="text-muted mb-0">
                                Configure your hiring preferences and communication settings to
                                streamline your recruitment process.
                            </p>
                        </div>
                        <div class="card-body p-4">

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- Validation errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-times-circle me-2"></i>
                                    <strong>There were some problems with your input.</strong>
                                    <ul class="mb-0 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif



                            <form id="preferencesForm" action="{{ route('employer.hiringpreference.store') }}"
                                method="POST">
                                @csrf


                                <!-- Interview & Screening Preferences -->
                                <div class="preference-card">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-clipboard-check text-warning me-2"></i>Interview & Screening
                                        Preferences<span style="color: red;">*</span>
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label">Preferred Screening Methods</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]"
                                                        value="Phone/Video interview" id="phoneInterview" />
                                                    <label class="form-check-label" for="phoneInterview">Phone/Video
                                                        interview</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]"
                                                        value="In-person interview" id="inPersonInterview" />
                                                    <label class="form-check-label" for="inPersonInterview">In-person
                                                        interview</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]"
                                                        value="Skills demonstration/test" id="skillsDemo" />
                                                    <label class="form-check-label" for="skillsDemo">Skills
                                                        demonstration/test</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]" value="Reference check"
                                                        id="referenceCheck" />
                                                    <label class="form-check-label" for="referenceCheck">Reference
                                                        check</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]"
                                                        value="Background verification" id="backgroundCheck" />
                                                    <label class="form-check-label" for="backgroundCheck">Background
                                                        verification</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]" value="Drug testing"
                                                        id="drugTest" />
                                                    <label class="form-check-label" for="drugTest">Drug
                                                        testing</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="interviewLocation" class="form-label">Preferred Interview
                                            Location</label>
                                        <select class="form-select" id="interviewLocation"
                                            name="preferred_interview_location">
                                            <option value="">Select location</option>
                                            <option value="Our office/headquarters">Our office/headquarters</option>
                                            <option value="Job site/project location">Job site/project location
                                            </option>
                                            <option value="Neutral location (cafe, etc.)">Neutral location (cafe, etc.)
                                            </option>
                                            <option value="Online/Video call only">Online/Video call only</option>
                                            <option value="Flexible - worker's choice">Flexible - worker's choice
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Special Requirements -->
                                <div class="preference-card">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>Special
                                        Requirements<span style="color: red;">*</span>
                                    </h5>

                                    <div class="switch-container">
                                        <div>
                                            <strong>Safety Training Required</strong>
                                            <div class="text-muted small">
                                                Workers must have safety training certificates
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="special_requirements[]"
                                                value="Workers must have safety training certificates" type="checkbox"
                                                id="safetyTraining" />
                                        </div>
                                    </div>

                                    <div class="switch-container">
                                        <div>
                                            <strong>Own Tools Required</strong>
                                            <div class="text-muted small">
                                                Workers must bring their own basic tools
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="special_requirements[]"
                                                value="Workers must bring their own basic tools" type="checkbox"
                                                id="ownTools" />
                                        </div>
                                    </div>

                                    <div class="switch-container">
                                        <div>
                                            <strong>Transportation Assistance</strong>
                                            <div class="text-muted small">
                                                Provide transportation or allowance
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="special_requirements[]"
                                                value="Provide Transportation or allowance" type="checkbox"
                                                id="transportation" />
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label for="additionalRequirements" class="form-label">Additional Requirements
                                            or Notes</label>
                                        <textarea class="form-control" name="additional_requirements" id="additionalRequirements" rows="3"
                                            placeholder="Any specific requirements, work conditions, or special instructions..."></textarea>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-8">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="previousStep()">
                                                <i class="fas fa-arrow-left me-2"></i>Previous
                                            </button>
                                            <small class="text-muted">Step 3 of 4</small>
                                            <button type="submit" class="btn btn-primary-custom"> Next <i
                                                    class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>


            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function selectTimeline(element, value) {
                // Remove selected class from all timeline options
                document
                    .querySelectorAll(".timeline-option")
                    .forEach((option) => option.classList.remove("selected"));

                // Add selected class to clicked option
                element.classList.add("selected");

                // Check the radio button
                document.getElementById(value).checked = true;
            }

            function nextStep() {
                const form = document.getElementById("preferencesForm");
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                window.location.href = "{{ route('employer.reviewregistration.display') }}";
            }

            function previousStep() {
                window.location.href = "{{ route('employer.contact.display') }}";
            }
        </script>

        <!-- NAVIGATION SCRIPT (inserted) -->
        <script>
            (function() {
                function log(...args) { if (window.console) console.log('[nav]', ...args); }

                document.addEventListener('DOMContentLoaded', () => {
                    try {
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
                            // close any open dropdowns
                            mobileNavbar.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
                            mobileNavbar.querySelectorAll('.dropdown-btn').forEach(b => b.setAttribute('aria-expanded', 'false'));
                            mobileNavbar.querySelectorAll('.dropdown-content').forEach(m => m.setAttribute('aria-hidden', 'true'));
                        }

                        if (hamburger && mobileNavbar) {
                            hamburger.addEventListener('click', (e) => {
                                e.stopPropagation();
                                if (window.innerWidth <= 768) {
                                    if (mobileNavbar.classList.contains('open')) closeMenuFn();
                                    else openMenu();
                                }
                            });

                            if (closeMenu) closeMenu.addEventListener('click', (e) => { e.stopPropagation(); closeMenuFn(); });
                            if (overlay) overlay.addEventListener('click', closeMenuFn);

                            mobileNavbar.querySelectorAll('.dropdown').forEach(drop => {
                                const btn = drop.querySelector('.dropdown-btn');
                                const menu = drop.querySelector('.dropdown-content');
                                if (!btn) return;
                                btn.addEventListener('click', (ev) => {
                                    ev.stopPropagation();
                                    const isOpen = drop.classList.toggle('open');
                                    btn.setAttribute('aria-expanded', String(isOpen));
                                    if (menu) menu.setAttribute('aria-hidden', String(!isOpen));
                                });
                            });

                            // close when selecting a link inside mobile menu
                            mobileNavbar.querySelectorAll('a').forEach(a => a.addEventListener('click', () => closeMenuFn()));

                            // close on ESC
                            document.addEventListener('keydown', (e) => {
                                if (e.key === 'Escape') closeMenuFn();
                            });

                            // optionally avoid closing when clicking arbitrary page elements:
                            // only close on overlay click or explicit outside click when overlay is not present
                            document.addEventListener('click', (e) => {
                                const overlayVisible = overlay && overlay.classList.contains('show');
                                if (overlayVisible) {
                                    // overlay click already handled; ignore other clicks to avoid accidental closes
                                    return;
                                }
                                if (!mobileNavbar.contains(e.target) && !hamburger.contains(e.target)) {
                                    closeMenuFn();
                                }
                            });

                            // close menu on window resize to desktop
                            window.addEventListener('resize', () => {
                                if (window.innerWidth > 768) closeMenuFn();
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
