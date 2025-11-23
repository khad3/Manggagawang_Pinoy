<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details - Employer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/applicant/landingpage/landingpage.css') }}" rel="stylesheet">
    <link href="{{ asset('css/applicant/employer/registration.css') }}" rel="stylesheet">
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

                    <button id="closeMenu" class="close-btn" aria-label="Close menu">✕</button>
                </div>

                <ul class="mobile-menu" role="menu" aria-label="Mobile main menu">
                    <li role="none"><a role="menuitem" href="{{ route('display.topworker') }}">Top Workers</a></li>
                    <li role="none"><a role="menuitem" href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                    <li role="none"><a role="menuitem" href="{{ route('display.aboutus') }}">About Us</a></li>

                    <li class="dropdown" role="none">
                        <button class="dropdown-btn" aria-expanded="false">Sign in</button>
                        <ul class="dropdown-content" role="menu" aria-hidden="true">
                            <li role="none"><a role="menuitem" href="{{ route('applicant.login.display') }}">As
                                    Applicant</a></li>
                            <li role="none"><a role="menuitem" href="{{ route('employer.login.display') }}">As
                                    Employer</a></li>
                        </ul>
                    </li>

                    <li class="dropdown" role="none">
                        <button class="dropdown-btn" aria-expanded="false">Sign up</button>
                        <ul class="dropdown-content" role="menu" aria-hidden="true">
                            <li role="none"><a role="menuitem" href="{{ route('applicant.register.display') }}">As
                                    Applicant</a></li>
                            <li role="none"><a role="menuitem" href="{{ route('employer.register.display') }}">As
                                    Employer</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <!-- Step Content -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card" style="margin-top:100px;">
                <div class="card-header bg-white border-0 py-4">
                    <div class="container">
                        <!-- Header -->
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-dark mb-3">Employer Registration</h1>
                            <p class="lead text-muted">Find TESDA-certified skilled workers and blue collar
                                professionals for your
                                projects</p>
                        </div>

                        <!-- Progress Stepper -->
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-10">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-center">
                                        <div class="step-indicator step-active" id="step1">1</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Job Details</small><br>
                                            <small class="text-muted d-none d-sm-block">Position Requirements</small>
                                        </div>
                                    </div>
                                    <div class="step-line"></div>

                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step2">2</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Contact</small><br>
                                            <small class="text-muted d-none d-sm-block">Your Contact Info</small>
                                        </div>
                                    </div>
                                    <div class="step-line"></div>

                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step3">3</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Preferences</small><br>
                                            <small class="text-muted d-none d-sm-block">Hiring Preferences</small>
                                        </div>
                                    </div>
                                    <div class="step-line"></div>

                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step4">4</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Review</small><br>
                                            <small class="text-muted d-none d-sm-block">Review & Submit</small>
                                        </div>
                                    </div>
                                    <div class="step-line"></div>

                                </div>
                            </div>
                        </div> <!-- End Stepper -->


                        <h3 class="card-title mb-2">Job Details</h3>
                        <p class="text-muted mb-0">Describe the skilled position you're looking to fill and the
                            specific requirements.</p>
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

                        {{-- Optional: Show form validation errors --}}
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

                        <form id="jobDetailsForm" action="{{ route('employer.jobdetails.store') }}" method="POST">
                            @csrf
                            <!-- Job Title & Department -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jobTitle" class="form-label">Job Title <span
                                            style="color: red;">*</span></label>
                                    <input type="text" name="job_title" class="form-control" id="jobTitle"
                                        placeholder="e.g. Skilled Welder, Electrician, Carpenter" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="department" class="form-label">Department <span
                                            style="color: red;">*</span></label>
                                    <select class="form-select" name="job_department" id="department"
                                        onchange="toggleOtherDepartment()">
                                        <option selected disabled>Choose category...</option>
                                        <option value="Administrative / Office Work">Administrative / Office Work
                                        </option>
                                        <option value="Beauty / Wellness">Beauty / Wellness</option>
                                        <option value="Caregiving">Caregiving</option>
                                        <option value="Carpentry">Carpentry</option>
                                        <option value="Construction">Construction</option>
                                        <option value="Customer Service">Customer Service</option>
                                        <option value="Culinary">Culinary</option>
                                        <option value="Driving / Delivery">Driving / Delivery</option>
                                        <option value="Electrical">Electrical</option>
                                        <option value="Gardening / Landscaping">Gardening / Landscaping</option>
                                        <option value="Housekeeping">Housekeeping</option>
                                        <option value="IT / Tech Support">IT / Tech Support</option>
                                        <option value="Laundry Services">Laundry Services</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Plumbing">Plumbing</option>
                                        <option value="Repair Services">Repair Services</option>
                                        <option value="Security Services">Security Services</option>
                                        <option value="Teaching / Tutoring">Teaching / Tutoring</option>
                                        <option value="Welding">Welding</option>
                                        <option value="Other">Others</option>
                                    </select>

                                    <!-- Hidden input for 'Other' -->
                                    <input type="text" class="form-input mt-2" name="other_department"
                                        id="departmentOther" placeholder="Please specify..." style="display: none;">
                                </div>

                                <script>
                                    function toggleOtherDepartment() {
                                        const departmentSelect = document.getElementById('department');
                                        const otherInput = document.getElementById('departmentOther');

                                        if (departmentSelect.value === 'Other') {
                                            otherInput.style.display = 'block';
                                            otherInput.required = true;
                                        } else {
                                            otherInput.style.display = 'none';
                                            otherInput.required = false;
                                            otherInput.value = ''; // Clear input
                                        }
                                    }
                                </script>

                            </div>
                            <div class="col-md-6">
                                <label for="jobType" class="form-label">Job Type</label>
                                <select class="form-select" id="jobType" name="job_type">
                                    <option selected>Choose type...</option>
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Temporary">Temporary</option>

                                </select>
                            </div>

                            <!-- Location & Work Type -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="location" class="form-label">Location <span
                                            style="color: red;">*</span></label>
                                    <input type="text" name="job_location" class="form-control" id="location"
                                        placeholder="e.g. Silang, Cavite" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="workType" class="form-label">Work Type <span
                                            style="color: red;">*</span></label>
                                    <select class="form-select" name="job_work_type" id="workType" required>
                                        <option value="">Select work type</option>
                                        <option value="Onsite">On-site</option>
                                        <option value="Project-based">Project-based</option>
                                        <option value="Contract">Contract Work</option>
                                        <option value="Seasonal">Seasonal</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Experience Level & Salary Range -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="experience" class="form-label">Experience Level <span
                                            style="color: red;">*</span></label>
                                    <select class="form-select" id="experience" name="job_experience" required>
                                        <option value="">Select experience</option>
                                        <option value="Apprentice Level (0-1 years)">Apprentice Level (0-1 years)
                                        </option>
                                        <option value="Skilled Worker (2-5 years)">Skilled Worker (2-5 years)
                                        </option>
                                        <option value="Experienced Craftsman (6-10 years)">Experienced Craftsman
                                            (6-10 years)</option>
                                        <option value="Master Craftsman (10+ years)">Master Craftsman (10+ years)
                                        </option>
                                        <option value="Supervisor/Foreman">Supervisor/Foreman</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="salaryRange" class="form-label">
                                        Salary Range <span style="color: red;">*</span>
                                    </label>

                                    <!-- Option 1: Predefined salary ranges -->
                                    <select class="form-select" id="jobSalarySelect" name="job_salary_range"required>
                                        <option value="" disabled selected>Select Salary Range</option>
                                        <option value="Below 10,000">Below 10,000 monthly</option>
                                        <option value="10,000 - 20,000">10,000 - 20,000 monthly</option>
                                        <option value="20,001 - 30,000">20,001 - 30,000 monthly</option>
                                        <option value="30,001 - 40,000">30,001 - 40,000 monthly</option>
                                        <option value="40,001 - 50,000">40,001 - 50,000 monthly</option>
                                        <option value="50,001 - 60,000">50,001 - 60,000 monthly</option>
                                        <option value="Above 60,000">Above 60,000 monthly</option>
                                    </select>
                                </div>

                            </div>

                            <!-- Job Description -->
                            <div class="mb-4">
                                <label for="jobDescription" class="form-label">Job Description <span
                                        style="color: red;">*</span></label>
                                <textarea class="form-control" name="job_description" id="jobDescription" rows="4"
                                    placeholder="Describe the role, responsibilities, and what the worker will be doing..." required></textarea>
                            </div>

                            <!-- Requirements -->
                            <div class="mb-4">
                                <label for="requirements" class="form-label">Additional Requirements
                                    (comma-separated)</label>
                                <textarea class="form-control" name="job_additional_requirements" id="requirements" rows="3"
                                    placeholder="List any additional qualifications, education, or experience requirements..."></textarea>
                            </div>

                            <!-- TESDA Certification Requirements -->
                            <div class="tesda-section">
                                <h5>
                                    <i class="fas fa-certificate me-2"></i>TESDA Certification Requirements<span
                                        style="color: red;">*</span>
                                </h5>
                                <p class="mb-3">Select the required TESDA certifications for this position:</p>

                                <!-- None Certification Toggle -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="none_certifications" value="on"
                                            type="checkbox" id="nonecertification" onchange="toggleTesdaCerts(this)">
                                        <label class="form-check-label fw-bold" for="nonecertification"> None
                                            Certification </label>
                                        <small class="text-muted d-block">Check this if no TESDA certificate is
                                            required</small>
                                    </div>
                                </div>


                                <!-- TESDA Certifications Section -->
                                <div id="tesdacertifications">
                                    <h5>
                                        <i class="fas fa-certificate me-2"></i>TESDA Certification Requirements
                                    </h5>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <label class="form-check-label" for="welding">Welding
                                                    (SMAW/GMAW/GTAW)</label>
                                                <input class="form-check-input" name="job_tesda_certification[]"
                                                    value="Welding (SMAW/GMAW/GTAW)" type="checkbox" id="welding">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_tesda_certification[]"
                                                    value="Electrical Installation & Maintenance" type="checkbox"
                                                    id="electrical">
                                                <label class="form-check-label" for="electrical">Electrical
                                                    Installation & Maintenance</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_tesda_certification[]"
                                                    value="Plumbing Installation & Maintenance" type="checkbox"
                                                    id="plumbing">
                                                <label class="form-check-label" for="plumbing">Plumbing
                                                    Installation & Maintenance</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_tesda_certification[]"
                                                    value="Carpentry & Joinery" type="checkbox" id="carpentry">
                                                <label class="form-check-label" for="carpentry">Carpentry &
                                                    Joinery</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_tesda_certification[]"
                                                    value="Automotive Servicing" type="checkbox" id="automotive">
                                                <label class="form-check-label" for="automotive">Automotive
                                                    Servicing</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_tesda_certification[]"
                                                    value="HVAC Installation & Servicing" type="checkbox"
                                                    id="hvac">
                                                <label class="form-check-label" for="hvac">HVAC Installation &
                                                    Servicing</label>
                                            </div>
                                        </div>

                                        <!-- OTHER Certification Option -->
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_tesda_certification[]"
                                                    value="Other" type="checkbox" id="otherCertCheckbox"
                                                    onchange="toggleOtherCertInput()">
                                                <label class="form-check-label fw-bold" for="otherCertCheckbox">Other
                                                    Certification</label>
                                                <small class="text-muted d-block">Check this if the desired
                                                    certification is not listed</small>
                                            </div>
                                        </div>

                                        <!-- Input for custom cert (hidden by default) -->
                                        <div class="col-md-6" id="otherCertInput" style="display: none;">
                                            <input type="text" class="form-control" name="other_certification"
                                                id="otherCertification"
                                                placeholder="Enter specific certification name">
                                        </div>
                                    </div>
                                </div>

                                <!-- Non-TESDA Certification Section (Initially Hidden) -->
                                <div id="nonTesdaCertifications" style="display: none;">
                                    <h5 class="text-success mt-4 mb-3">
                                        <i class="fas fa-clipboard-check me-2"></i> Non-Certification Requirements
                                    </h5>
                                    <p class="mb-3">Select non-certification qualifications required for this
                                        position:</p>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_non_tesda_certification[]"
                                                    value="At least 1 year work experience" type="checkbox"
                                                    id="experience">
                                                <label class="form-check-label fw-bold" for="experience">At least
                                                    1 year work experience</label>
                                                <small class="text-muted d-block">In any related job or
                                                    trade</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_non_tesda_certification[]"
                                                    value="Strong teamwork and collaboration" type="checkbox"
                                                    id="teamwork">
                                                <label class="form-check-label fw-bold" for="teamwork">Strong
                                                    teamwork and collaboration</label>
                                                <small class="text-muted d-block">Ability to work well with
                                                    others</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_non_tesda_certification[]"
                                                    value="Good communication skills" type="checkbox"
                                                    id="communication">
                                                <label class="form-check-label fw-bold" for="communication">Good
                                                    communication skills</label>
                                                <small class="text-muted d-block">Verbal and written</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_non_tesda_certification[]"
                                                    value="Flexible and adaptable" type="checkbox" id="flexibility">
                                                <label class="form-check-label fw-bold" for="flexibility">Flexible
                                                    and adaptable</label>
                                                <small class="text-muted d-block">Can adjust to various working
                                                    conditions</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Benefits & Compensation -->
                            <div class="mb-4">
                                <label class="form-label">Benefits & Compensation Offered<span
                                        style="color: red;">*</span></label>
                                <p class="text-muted small mb-3">Select benefits you offer:</p>
                                <div id="benefits-container">
                                    <span class="skill-badge" onclick="toggleSkill(this)">SSS Contribution</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">PhilHealth</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">Pag-IBIG</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">13th Month Pay</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">Overtime Pay</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">Holiday Pay</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">Free Meals</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">Transportation
                                        Allowance</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">Safety Equipment
                                        Provided</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">Skills Training</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">Performance Bonus</span>
                                    <span class="skill-badge" onclick="toggleSkill(this)">Health Insurance</span>
                                </div>

                                <input type="hidden" name="job_benefits[]" id="benefits" value="">
                            </div>
                            <!-- Navigation Buttons -->
                            <div class="row justify-content-center mt-4">
                                <div class="col-lg-8">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="previousStep()">
                                            <i class="fas fa-arrow-left me-2"></i>Previous
                                        </button>
                                        <small class="text-muted">Step 1 of 4</small>
                                        <button type="submit" class="btn btn-primary-custom">Next <i
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
        function toggleSkill(el) {
            el.classList.toggle('active');
            const selected = Array.from(document.querySelectorAll('.skill-badge.active')).map(span => span.textContent);
            document.getElementById('benefits').value = selected;
        }


        function updateBenefits() {
            const selected = document.querySelectorAll('.skill-badge-selected');
            const benefits = Array.from(selected).map(el => el.textContent.trim());
            document.getElementById('benefits').value = selected.join(',');
        }

        function toggleTesdaCerts(checkbox) {
            const tesda = document.getElementById('tesdacertifications');
            const nonTesda = document.getElementById('nonTesdaCertifications');

            if (checkbox.checked) {
                tesda.style.display = 'none';
                nonTesda.style.display = 'block';
            } else {
                tesda.style.display = 'block';
                nonTesda.style.display = 'none';
            }


        }

        function toggleOtherCertInput() {
            const input = document.getElementById('otherCertInput');
            const checkbox = document.getElementById('otherCertCheckbox');
            input.style.display = checkbox.checked ? 'block' : 'none';

        }


        function toggleCertification(element) {
            element.classList.toggle('selected');
            const checkbox = element.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
        }

        function addCustomSkill() {
            const input = document.getElementById('customSkill');
            const skill = input.value.trim();
            if (skill) {
                const container = document.getElementById('skillsContainer');
                const span = document.createElement('span');
                span.className = 'skill-badge skill-badge-selected';
                span.textContent = skill;
                span.onclick = function() {
                    toggleSkill(this);
                };
                container.appendChild(span);
                input.value = '';
            }
        }

        function nextStep() {
            const form = document.getElementById('jobDetailsForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            window.location.href = "{{ route('employer.contact.display') }}";
        }

        function previousStep() {
            window.location.href = '{{ route('employer.login.display') }}';
        }

        // guard adding key listener for optional custom skill input
        const customSkillInput = document.getElementById('customSkill');
        if (customSkillInput) {
            customSkillInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addCustomSkill();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const navLinks = document.getElementById('navLinks');

            if (!hamburger || !navLinks) return;

            hamburger.addEventListener('click', function() {
                navLinks.classList.toggle('active');
                hamburger.classList.toggle('active');
                document.body.classList.toggle('noscroll');
            });

            // Close menu when any nav link/button is clicked (mobile)
            navLinks.querySelectorAll('a, button').forEach(link => {
                link.addEventListener('click', function() {
                    if (navLinks.classList.contains('active')) {
                        navLinks.classList.remove('active');
                        hamburger.classList.remove('active');
                        document.body.classList.remove('noscroll');
                    }
                });
            });
        });

        (function() {
            function log(...args) {
                if (window.console) console.log('[nav]', ...args);
            }

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
