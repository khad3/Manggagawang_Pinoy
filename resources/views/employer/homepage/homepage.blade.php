<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - MangagawangPinoy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/applicant/employer/homepage.css') }}">
</head>

<body>
    <!-- Mobile Menu Toggle -->
    <button class="btn btn-primary mobile-menu-toggle" id="toggleSidebar">
        <i class="fas fa-bars" id="menuIcon"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Brand Section -->
        <div class="brand-section">
            <div class="d-flex align-items-center gap-3">
                <div class="brand-logo">MP</div>
                <div>
                    <h5 class="mb-0 fw-bold">Employer Portal</h5>
                    <p class="text-muted small mb-0">MangagawangPinoy</p>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="nav-section">
            <div class="nav-item">
                <a href="#" class="nav-link active" data-target="dashboard-section">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="applicants-section">
                    <i class="fas fa-users"></i>
                    Applicants
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="jobposts-section">
                    <i class="fas fa-briefcase"></i>
                    Job Posts
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="messages-section">
                    <i class="fas fa-comments"></i>
                    Messages
                </a>
            </div>

            <div class="nav-item">
                <a href="#" class="nav-link" data-target="analytics-section">
                    <i class="fas fa-chart-line"></i>
                    Analytics
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="settings-section">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="reports-section">
                    <i class="fas fa-flag"></i>
                    Reports
                </a>
            </div>
            <div class="nav-item mt-4">
                <a href="#" class="nav-link text-danger"
                    onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) { document.getElementById('logout-form').submit(); }">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('employer.logout.store') }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>

        <script>
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.dataset.target;
                    if (target) openSection(target);
                });
            });
        </script>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <br>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" id="success-alert">
                <center>{{ session('success') }}</center>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <script>
                // Hide the alert after 5 seconds (5000 ms)
                setTimeout(() => {
                    let alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.classList.remove('show'); // fade out
                        alert.classList.add('fade'); // keep bootstrap fade animation
                        setTimeout(() => alert.remove(), 500); // remove from DOM after fade
                    }
                }, 2000); // change to 2000 for 2 seconds
            </script>
        @endif
        <!-- Welcome Section -->
        <br>
        <div class="welcome-header">
            <div class="welcome-title">Welcome back, {{ $retrievePersonal->first_name ?? 'Employer' }}
                {{ $retrievePersonal->last_name ?? '' }}! 👋</div>
            <div class="welcome-subtitle">Here's what's happening with your job postings today</div>
        </div>

        <!-- Dashboard Section -->
        @include('employer.homepage.section.dashboard_section')
        <!-- Applicants Section -->
        @include('employer.homepage.section.applicant_section')

        <!-- Job Posts Section -->
        @include('employer.homepage.section.job_section')

        <!-- messages section ---->
        @include('employer.homepage.section.message_section')

        <!-- Analytics Section -->
        <div class="page-section" id="analytics-section" style="display: flex; justify-content: center; width: 90%;">
            <div class="content-section"
                style="max-width: 1200px; width: 100%; padding: 30px; background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

                <!-- 🪄 Chart Title -->
                <div class="text-center" style="margin-bottom: 20px;">
                    <i class="fas fa-chart-bar fa-3x mb-2" style="color: #4CAF50;"></i>
                    <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 8px;">Applicant Status Analytics</h2>
                    <p style="color: #666; font-size: 1rem;">Approved vs Rejected Applicants per Job Post & Employer</p>
                </div>

                <!-- 🪄 Chart Container -->
                <div class="chart-container"
                    style="width: 100%; height: 300px; display: flex; justify-content: center;">
                    <!-- ⬅️ height reduced -->
                    <div id="approvedApplicantsChart" style="width: 90%; height: 100%;"></div>
                </div>
            </div>
        </div>

        <!-- 📊 Google Charts Script -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(drawApprovedApplicantsChart);

            function drawApprovedApplicantsChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Job Post (Employer)', 'Approved', 'Rejected'],
                    @foreach ($jobPosts as $job)
                        ['{{ $job->title }} ({{ $job->companyName->company_name ?? 'No Employer' }})',
                            {{ $job->approved_count }}, {{ $job->rejected_count }}
                        ],
                    @endforeach
                ]);

                var options = {
                    title: 'Approved vs Rejected Applicants',
                    titleTextStyle: {
                        fontSize: 20,
                        bold: true
                    },
                    chartArea: {
                        left: '10%',
                        right: '10%',
                        top: 60,
                        bottom: 80,
                        width: '80%',
                        height: '60%'
                    },
                    hAxis: {
                        title: 'Job Post & Employer',
                        titleTextStyle: {
                            fontSize: 14,
                            bold: true
                        },
                        textStyle: {
                            fontSize: 12
                        },
                        slantedText: true,
                        slantedTextAngle: 25
                    },
                    vAxis: {
                        title: 'Number of Applicants',
                        titleTextStyle: {
                            fontSize: 14,
                            bold: true
                        },
                        minValue: 0,
                        viewWindow: {
                            min: 0,
                            max: 10 // ✅ set a fixed max to make bar shorter
                        },
                        format: '0',
                        gridlines: {
                            count: -1
                        }
                    },
                    legend: {
                        position: 'top',
                        alignment: 'center',
                        textStyle: {
                            fontSize: 12
                        }
                    },
                    colors: ['#4CAF50', '#F44336'],
                    bar: {
                        groupWidth: '40%'
                    },
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('approvedApplicantsChart'));
                chart.draw(data, options);

                window.addEventListener('resize', () => chart.draw(data, options));
            }
        </script>



        <!-- Settings Section -->
        <div class="page-section" id="settings-section">
            <div class="content-section">
                <div class="text-center py-5">
                    <i class="fas fa-cog fa-4x text-muted mb-3"></i>
                    <h3 class="mb-2">Settings</h3>
                    <p class="text-muted">Settings panel will appear here...</p>
                </div>
            </div>
        </div>

        <!-- Reports Section -->
        <div class="page-section" id="reports-section">
            <div class="content-section">
                <div class="text-center py-5">
                    <i class="fas fa-flag fa-4x text-muted mb-3"></i>
                    <h3 class="mb-2">Reports</h3>
                    <p class="text-muted">Reports section will appear here...</p>
                </div>
            </div>
        </div>
    </div>






    <!-- New Job Modal -->
    <div class="modal fade" id="newJobModal" tabindex="-1" aria-labelledby="newJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newJobModalLabel">Post New Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Show global error (invalid login) --}}
                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                {{-- Show success message --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="modal-body">
                    <form action="{{ route('employer.jobsposts.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="jobTitle" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="jobTitle" name="job_title"
                                    placeholder="e.g. Senior Electrician">
                            </div>
                            <div class="col-md-6">
                                <label for="jobCategory" class="form-label">Category</label>
                                <select class="form-select" id="jobCategory" name="job_department">
                                    <option selected disabled>Choose category...</option>
                                    <option value="Construction">Construction</option>
                                    <option value="Electrical">Electrical</option>
                                    <option value="Plumbing">Plumbing</option>
                                    <option value="Culinary">Culinary</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Housekeeping">Housekeeping</option>
                                    <option value="Caregiving">Caregiving</option>
                                    <option value="IT / Tech Support">IT / Tech Support</option>
                                    <option value="Customer Service">Customer Service</option>
                                    <option value="Teaching / Tutoring">Teaching / Tutoring</option>
                                    <option value="Driving / Delivery">Driving / Delivery</option>
                                    <option value="Laundry Services">Laundry Services</option>
                                    <option value="Beauty / Wellness">Beauty / Wellness</option>
                                    <option value="Administrative / Office Work">Administrative / Office Work</option>
                                    <option value="Carpentry">Carpentry</option>
                                    <option value="Welding">Welding</option>
                                    <option value="Gardening / Landscaping">Gardening / Landscaping</option>
                                    <option value="Repair Services">Repair Services</option>
                                    <option value="Security Services">Security Services</option>
                                    <option value="Other">Others</option>
                                </select>

                                <div id="otherCategory" style="display: none; ">
                                    <label for="otherCategoryInput" class="form-label">Other Category</label>
                                    <input type="text" class="form-control" id="otherCategoryInput"
                                        name="other_department" placeholder="Enter other category">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <label for="jobType" class="form-label">Job Type</label>
                                <select class="form-select" id="jobType" name="job_type">
                                    <option selected>Choose type...</option>
                                    <option>Full-time</option>
                                    <option>Part-time</option>
                                    <option>Contract</option>
                                    <option>Temporary</option>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="workType" class="form-label">Work Type </label>
                                <select class="form-select" name="job_work_type" id="workType" required>
                                    <option value="">Select work type</option>
                                    <option value="Onsite">On-site</option>
                                    <option value="Project-based">Project-based</option>
                                    <option value="Contract">Contract Work</option>
                                    <option value="Seasonal">Seasonal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="jobLocation" class="form-label">Location</label>
                                <input type="text" class="form-control" name="job_location" id="jobLocation"
                                    placeholder="e.g. Silang, Cavite">
                            </div>
                            <div class="col-md-6">
                                <label for="jobSalary" class="form-label">Salary Range</label>
                                <input type="text" class="form-control" id="jobSalary" name="job_salary_range"
                                    placeholder="e.g. 35,000 to 45,000 month">
                            </div>
                            <div class="col-md-6">
                                <label for="experience" class="form-label">Experience Level *</label>
                                <select class="form-select" id="experience" name="job_experience" required>
                                    <option value="">Select experience</option>
                                    <option value="Apprentice Level (0-1 years)">Apprentice Level (0-1 years)</option>
                                    <option value="Skilled Worker (2-5 years)">Skilled Worker (2-5 years)</option>
                                    <option value="Experienced Craftsman (6-10 years)">Experienced Craftsman (6-10
                                        years)</option>
                                    <option value="Master Craftsman (10+ years)">Master Craftsman (10+ years)</option>
                                    <option value="Supervisor/Foreman">Supervisor/Foreman</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="jobDescription" class="form-label">Job Description</label>
                                <textarea class="form-control" name="job_description" id="jobDescription" rows="4"
                                    placeholder="Describe the job requirements, responsibilities, and qualifications..."></textarea>
                            </div>
                            <div class="col-12">
                                <label for="jobRequirements" class="form-label">Additional Requirements
                                    (comma-separated)</label>
                                <input type="text" class="form-control" name="job_additional_requirements"
                                    id="jobRequirements"
                                    placeholder="e.g. 5+ years experience, Licensed, Safety Certified">
                            </div>
                            <!--- Tesda certification ---->
                            <!-- TESDA Certification Requirements -->
                            <div class="tesda-section">
                                <h5 class="text-warning mb-3">
                                    <i class="fas fa-certificate me-2"></i>TESDA Certification Requirements
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
                                <div id="tesdacertifications"
                                    class="tesda-certification-section p-4 rounded shadow-sm mb-4">
                                    <h5 class="text-warning mb-3">
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
                                                <label class="form-check-label" for="plumbing">Plumbing Installation &
                                                    Maintenance</label>
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
                                                <label class="form-check-label fw-bold" for="experience">At least 1
                                                    year work experience</label>
                                                <small class="text-muted d-block">In any related job or trade</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="job_non_tesda_certification[]"
                                                    value="Strong teamwork and collaboration" type="checkbox"
                                                    id="teamwork">
                                                <label class="form-check-label fw-bold" for="teamwork">Strong teamwork
                                                    and collaboration</label>
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
                                                <label class="form-check-label fw-bold" for="flexibility">Flexible and
                                                    adaptable</label>
                                                <small class="text-muted d-block">Can adjust to various working
                                                    conditions</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Benefits & Compensation -->
                            <div class="mb-4">
                                <label class="form-label">Benefits & Compensation Offered</label>
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

                            <hr>
                            <!-- Communication Preferences -->
                            <div class="section-divider">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-comments text-success me-2"></i>Communication Preferences
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Preferred Contact Method *</label>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="contact_method"
                                                id="contactEmail" value="email" required />
                                            <label class="form-check-label" for="contactEmail">
                                                <i class="fas fa-envelope me-2"></i>Email
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="contact_method"
                                                id="contactPhone" value="phone" />
                                            <label class="form-check-label" for="contactPhone">
                                                <i class="fas fa-phone me-2"></i>Phone Call
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="contact_method"
                                                id="contactSMS" value="sms" />
                                            <label class="form-check-label" for="contactSMS">
                                                <i class="fas fa-sms me-2"></i>SMS/Text Message
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Best Time to Contact</label>
                                        <select class="form-select" id="contactTime" name="contact_time">
                                            <option value="">Select best time</option>
                                            <option value="morning">Morning (8AM - 12PM)</option>
                                            <option value="afternoon">Afternoon (12PM - 5PM)</option>
                                            <option value="evening">Evening (5PM - 8PM)</option>
                                            <option value="anytime">Anytime during business hours</option>
                                        </select>

                                        <label class="form-label mt-3">Language Preference</label>
                                        <select class="form-select" id="language" name="language_preference">
                                            <option value="english">English</option>
                                            <option value="filipino">Filipino/Tagalog</option>
                                            <option value="cebuano">Cebuano</option>
                                            <option value="ilocano">Ilocano</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!-- Interview & Screening Preferences -->
                            <div class="preference-card">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-clipboard-check text-warning me-2"></i>Interview & Screening
                                    Preferences
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label">Preferred Screening Methods</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="preferred_screening_method[]" value="Phone/Video interview"
                                                    id="phoneInterview" />
                                                <label class="form-check-label" for="phoneInterview">Phone/Video
                                                    interview</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="preferred_screening_method[]" value="In-person interview"
                                                    id="inPersonInterview" />
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
                                                <label class="form-check-label" for="drugTest">Drug testing</label>
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
                                        <option value="Job site/project location">Job site/project location</option>
                                        <option value="Neutral location (cafe, etc.)">Neutral location (cafe, etc.)
                                        </option>
                                        <option value="Online/Video call only">Online/Video call only</option>
                                        <option value="Flexible - worker's choice">Flexible - worker's choice</option>
                                    </select>
                                </div>
                            </div>
                            <hr>

                            <!-- Special Requirements -->
                            <div class="preference-card">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Special Requirements
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
                                        or
                                        Notes</label>
                                    <textarea class="form-control" name="additional_requirements" id="additionalRequirements" rows="3"
                                        placeholder="Any specific requirements, work conditions, or special instructions..."></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" name="action" value="draft" class="btn btn-secondary"
                                data-bs-dismiss="modal">Save as Draft</button>
                            <button type="submit" name="action" value="publish" class="btn btn-primary">Publish
                                Job</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>




    <script>
        function openSection(sectionId) {
            document.querySelectorAll('.page-section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';

            // update active nav link
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            const navLink = document.querySelector(`.nav-link[data-target="${sectionId}"]`);
            if (navLink) navLink.classList.add('active');

            // smooth scroll
            document.getElementById(sectionId).scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>



    <!-- for the applicant aplied job javascript--->
    <script>
        function exportApplications() {
            // Professional export functionality
            console.log('Exporting applications with balanced theme...');

            const btn = event.target;
            const originalHTML = btn.innerHTML;

            // Show loading state
            btn.innerHTML =
                '<i class="fas fa-spinner fa-spin me-1"></i><span class="d-none d-sm-inline">Exporting...</span><span class="d-sm-none">Loading...</span>';
            btn.disabled = true;
            btn.classList.add('btn-secondary');

            // Simulate export process
            setTimeout(() => {
                btn.innerHTML =
                    '<i class="fas fa-check me-1"></i><span class="d-none d-sm-inline">Exported!</span><span class="d-sm-none">Done!</span>';
                btn.classList.remove('btn-secondary');
                btn.classList.add('btn-success');

                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-accent-balanced');
                }, 1500);
            }, 2000);
        }

        // Optional: Add filtering functionality
        function filterApplications(status) {
            const applications = document.querySelectorAll('.application-item');

            applications.forEach(app => {
                if (status === 'All Status' || app.dataset.status === status.toLowerCase()) {
                    app.style.display = 'block';
                } else {
                    app.style.display = 'none';
                }
            });
        }

        // Initialize tooltips (if using Bootstrap tooltips)
        document.addEventListener('DOMContentLoaded', function() {
            // Add any initialization code here
            console.log('Balanced theme job applications modal loaded');
        });
    </script>



    {{-- JavaScript Functions --}}
    <script>
        function openApplicationsModal() {
            document.getElementById('applicationsModalOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeApplicationsModal() {
            document.getElementById('applicationsModalOverlay').style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        function viewDocument(type, applicationId) {
            if (type === 'resume') {
                alert(`Opening resume for application ${applicationId}`);
                // In real implementation: window.open('/storage/resumes/applicant_${applicationId}_resume.pdf', '_blank');
            } else if (type === 'tesda') {
                alert(`Opening TESDA certificate for application ${applicationId}`);
                // In real implementation: window.open('/storage/certificates/applicant_${applicationId}_tesda.pdf', '_blank');
            }
        }

        function approveApplication(applicationId) {
            if (confirm('Are you sure you want to approve this application?')) {
                alert(`Application ${applicationId} approved!`);
                // Update status visually
                updateApplicationStatus(applicationId, 'approved', '#28a745');

                // In real implementation:
                // fetch('/applications/' + applicationId + '/approve', { method: 'POST' })
            }
        }

        function rejectApplication(applicationId) {
            if (confirm('Are you sure you want to reject this application?')) {
                alert(`Application ${applicationId} rejected!`);
                // Update status visually
                updateApplicationStatus(applicationId, 'rejected', '#dc3545');

                // In real implementation:
                // fetch('/applications/' + applicationId + '/reject', { method: 'POST' })
            }
        }

        function scheduleInterview(applicationId) {
            alert(`Schedule interview for application ${applicationId}`);
            // In real implementation: open interview scheduling modal
        }

        function contactApplicant(email) {
            window.location.href = `mailto:${email}`;
        }

        function updateApplicationStatus(applicationId, status, color) {
            // Find the application card and update status badge
            const cards = document.querySelectorAll('.application-card');
            cards.forEach((card, index) => {
                if (index + 1 === applicationId) {
                    const statusBadge = card.querySelector('.status-badge');
                    statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    statusBadge.style.background = color;
                    statusBadge.style.color = 'white';
                }
            });
        }

        function exportApplications() {
            alert('Exporting all applications to CSV...');
            // In real implementation: generate and download CSV file
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('applicationsModalOverlay');
            if (event.target === modal) {
                closeApplicationsModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeApplicationsModal();
            }
        });
    </script>

    <!-- Scripts -->

    <script>
        const jobCategorySelect = document.getElementById('jobCategory');
        const jobSubcategorySelect = document.getElementById('otherCategory');

        jobCategorySelect.addEventListener('change', function() {
            if (this.value === 'Other') {
                jobSubcategorySelect.style.display = 'block';
            } else {
                jobSubcategorySelect.style.display = 'none';
            }

        });



        document.addEventListener('DOMContentLoaded', function() {
            const benefitBadges = document.querySelectorAll('.benefit-option');
            const hiddenInput = document.getElementById('benefits');

            benefitBadges.forEach(badge => {
                badge.addEventListener('click', () => {
                    badge.classList.toggle('selected');

                    // Collect all selected benefits
                    const selectedBenefits = Array.from(document.querySelectorAll(
                            '.benefit-option.selected'))
                        .map(el => el.dataset.benefit);

                    // Update the hidden input value (you can split this later on the server)
                    hiddenInput.value = selectedBenefits.join(',');
                });
            });
        });


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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuIcon = document.getElementById('menuIcon');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');

            if (sidebar.classList.contains('show')) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            } else {
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
        }

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Navigation functionality
        const navLinks = document.querySelectorAll('.nav-link[data-target]');
        const sections = document.querySelectorAll('.page-section');

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();

                // Remove active class from all links
                navLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');

                // Hide all sections
                sections.forEach(section => section.classList.remove('active'));

                // Show target section
                const targetId = link.getAttribute('data-target');
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }

                // Auto-close sidebar on mobile
                if (window.innerWidth <= 991) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });
        });

        // Search and filter functionality for applicants
        const searchInput = document.getElementById('searchApplicants');
        const positionFilter = document.getElementById('positionFilter');
        const certificationFilter = document.getElementById('certificationFilter');
        const applicantRows = document.querySelectorAll('#applicantsTable tbody tr');

        function filterApplicants() {
            const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const selectedPosition = positionFilter ? positionFilter.value.toLowerCase().trim() : '';
            const certificationValue = certificationFilter ? certificationFilter.value.toLowerCase().trim() : '';

            applicantRows.forEach(row => {
                const nameCell = row.querySelector('.applicant-details h6');
                const positionCell = row.querySelector('td:nth-child(3) strong');
                const locationCell = row.querySelector('td:nth-child(3) small');

                const name = nameCell ? nameCell.textContent.toLowerCase().trim() : '';
                const position = positionCell ? positionCell.textContent.toLowerCase().trim() : '';
                const location = locationCell ? locationCell.textContent.toLowerCase().trim() : '';
                const certificationsText = (row.dataset.certifications || '').toLowerCase().trim();

                const matchesSearch = !searchValue || name.includes(searchValue) || location.includes(searchValue);
                const matchesPosition = !selectedPosition || position.includes(selectedPosition);
                const matchesCertification = !certificationValue || certificationsText.includes(certificationValue);

                row.style.display = (matchesSearch && matchesPosition && matchesCertification) ? '' : 'none';
            });
        }

        if (searchInput) searchInput.addEventListener('input', filterApplicants);
        if (positionFilter) positionFilter.addEventListener('change', filterApplicants);
        if (certificationFilter) certificationFilter.addEventListener('change', filterApplicants);


        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 991) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && sidebar.classList.contains(
                        'show')) {
                    toggleSidebar();
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 991) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
        });

        function updateBenefits() {
            const selected = document.querySelectorAll('.skill-badge-selected');
            const benefits = Array.from(selected).map(el => el.textContent.trim());
            document.getElementById('benefits').value = selected.join(',');
        }
    </script>

    <script>
        const selectedBenefits = [];

        function toggleSkill(el) {
            const benefit = el.innerText.trim();
            const index = selectedBenefits.indexOf(benefit);

            if (index > -1) {
                selectedBenefits.splice(index, 1);
                el.classList.remove("selected");
            } else {
                selectedBenefits.push(benefit);
                el.classList.add("selected");
            }

            // Update the hidden input
            document.getElementById('benefits').value = selectedBenefits.join(',');
        }
    </script>

    <script>
        const timeout = 10 * 60 * 1000; // 10 minutes
        const warningTime = 9 * 60 * 1000; // 1 minute before logout

        let warningTimer = setTimeout(showWarning, warningTime);
        let logoutTimer = setTimeout(autoLogout, timeout);

        function resetTimers() {
            clearTimeout(warningTimer);
            clearTimeout(logoutTimer);
            warningTimer = setTimeout(showWarning, warningTime);
            logoutTimer = setTimeout(autoLogout, timeout);
        }

        function showWarning() {
            alert(
                "You will be logged out in 1 minute due to inactivity. Move your mouse or press a key to stay logged in."
            );
        }

        function autoLogout() {
            window.location.href = "{{ route('employer.login.display') }}";
        }

        document.addEventListener('mousemove', resetTimers);
        document.addEventListener('keydown', resetTimers);
        document.addEventListener('click', resetTimers);
    </script>


</body>

</html>
