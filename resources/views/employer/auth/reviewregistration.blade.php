<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Review Registration - Employer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/applicant/landingpage/landingpage.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/applicant/employer/reviewregistration.css') }}" rel="stylesheet" />
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
                <li class="dropdown">
                    <button class="sign-in-b">Sign in</button>
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


    <!-- Review Content -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="registration-container">
                    <div class="container">
                        @if (session('success'))
                            <div class="container mt-3">
                                <div class="alert alert-success alert-dismissible fade show text-center" role="alert"
                                    id="success-alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>

                            <script>
                                // Hide the alert after 2 seconds (2000 ms)
                                setTimeout(() => {
                                    const alert = document.getElementById('success-alert');
                                    if (alert) {
                                        alert.classList.remove('show'); // fade out
                                        alert.classList.add('fade'); // keep bootstrap fade animation
                                        setTimeout(() => alert.remove(), 500); // remove from DOM after fade
                                    }
                                }, 2000);
                            </script>
                        @endif
                        <!-- Header -->
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-dark mb-3">
                                Review Your Registration
                            </h1>
                            <p class="lead text-muted">
                                Please review all information before submitting your employer
                                registration
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
                                        <div class="step-indicator step-completed" id="step3">
                                            3
                                        </div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Preferences</small>
                                            <br /><small class="text-muted d-none d-sm-block">Hiring preferences</small>
                                        </div>
                                    </div>
                                    <div class="step-line step-line-completed" id="line3"></div>

                                    <!-- Step 4 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-active" id="step4">4</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Review</small>
                                            <br /><small class="text-muted d-none d-sm-block">Review & submit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-building text-primary me-2"></i>Company
                                    Information
                                </h5>
                                <a href="#" class="edit-link" data-bs-toggle="modal"
                                    data-bs-target="#editCompanyModal">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="summary-item">
                                <strong>{{ $retrievedCompanyAddress->company_name ?? '' }}</strong>
                                <div class="text-muted">{{ $retrievedJobDetail->department ?? '' }}</div>
                                <div class="small text-muted">
                                    {{ $retrievedCompanyAddress->company_complete_address ?? '' }}
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="small">
                                    {{ $retrievedJobDetail->job_description ?? 'No company description provided.' }}
                                </p>
                            </div>
                        </div>


                        <div class="modal fade" id="editCompanyModal" tabindex="-1"
                            aria-labelledby="editCompanyModalLabel" aria-hidden="true" data-bs-backdrop="false">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCompanyModalLabel">Edit Company Information
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form
                                            action="{{ route('employer.updatecontactinformation.store', session('employer_id')) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')


                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label for="companyName" class="form-label">Company Name</label>
                                                    <input type="text" name="company_name" id="companyName"
                                                        class="form-control"
                                                        value="{{ $retrievedCompanyAddress->company_name ?? '' }}"
                                                        required>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="department" class="form-label">Department</label>
                                                    <select name="department" id="department" class="form-select">
                                                        <option value="">Select department</option>
                                                        <option value="Management"
                                                            {{ ($retrievedJobDetail->department ?? '') == 'Management' ? 'selected' : '' }}>
                                                            Management</option>
                                                        <option value="Human-resource"
                                                            {{ ($retrievedJobDetail->department ?? '') == 'Human-resource' ? 'selected' : '' }}>
                                                            Human Resources</option>
                                                        <option value="Operations"
                                                            {{ ($retrievedJobDetail->department ?? '') == 'Operations' ? 'selected' : '' }}>
                                                            Operations</option>
                                                        <option value="Project-management"
                                                            {{ ($retrievedJobDetail->department ?? '') == 'Project-management' ? 'selected' : '' }}>
                                                            Project Management</option>
                                                        <option value="Safety-compliance"
                                                            {{ ($retrievedJobDetail->department ?? '') == 'Safety-compliance' ? 'selected' : '' }}>
                                                            Safety & Compliance</option>
                                                        <option value="Administration"
                                                            {{ ($retrievedJobDetail->department ?? '') == 'Administration' ? 'selected' : '' }}>
                                                            Administration</option>
                                                        <option value="Other"
                                                            {{ ($retrievedJobDetail->department ?? '') == 'Other' ? 'selected' : '' }}>
                                                            Other</option>
                                                    </select>
                                                </div>


                                                <div class="col-md-12">
                                                    <label for="companyAddress" class="form-label">Company
                                                        Address</label>
                                                    <textarea name="company_complete_address" id="companyAddress" rows="3" class="form-control" required>{{ $retrievedCompanyAddress->company_complete_address ?? '' }}</textarea>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="companyDescription" class="form-label">Company
                                                        Description</label>
                                                    <textarea name="job_description" id="companyDescription" rows="4" class="form-control">{{ $retrievedJobDetail->job_description ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary w-100">Save
                                                    Changes</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-4">
                    <div class="review-card">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-user text-success me-2"></i>Contact Information
                                </h5>

                                <a href="#" class="edit-link" data-bs-toggle="modal"
                                    data-bs-target="#editContactModal"
                                    data-firstname="{{ $retrievedPersonalInfo->first_name }}"
                                    data-lastname="{{ $retrievedPersonalInfo->last_name }}"
                                    data-email="{{ $retrievedPersonalInfo->email }}"
                                    data-phone="{{ $retrievedPersonalInfo->phone_number }}"
                                    data-address="{{ $retrievedCompanyAddress->company_complete_address }} {{ $retrievedCompanyAddress->company_municipality }}, {{ $retrievedCompanyAddress->company_province }}"
                                    data-contact="{{ $retrievedCommunication->contact_method }}"
                                    data-time="{{ $retrievedCommunication->contact_time }}"
                                    data-language="{{ $retrievedCommunication->language_preference }}">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="summary-item">
                                <strong>{{ $retrievedPersonalInfo->first_name }}
                                    {{ $retrievedPersonalInfo->last_name }}</strong>
                                <div class="text-muted">{{ $retrievedPersonalInfo->employer_job_title }}</div>
                            </div>
                            <div class="mt-3">
                                <p class="mb-1">
                                    <i class="fas fa-envelope text-muted me-2"></i>{{ $retrievedPersonalInfo->email }}
                                </p>
                                <p class="mb-1">
                                    <i
                                        class="fas fa-phone text-muted me-2"></i>{{ $retrievedPersonalInfo->phone_number }}
                                </p>
                                <p class="mb-3">
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    {{ $retrievedCompanyAddress->company_complete_address }}
                                    {{ $retrievedCompanyAddress->company_municipality }},
                                    {{ $retrievedCompanyAddress->company_province }}
                                </p>
                                <div class="small">
                                    <strong>Preferred Contact:</strong>
                                    {{ $retrievedCommunication->contact_method }}<br />
                                    <strong>Best Time:</strong> {{ $retrievedCommunication->contact_time }}<br />
                                    <strong>Language:</strong> {{ $retrievedCommunication->language_preference }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel"
                    aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header bg-success text-white rounded-top-4">
                                <h5 class="modal-title fw-semibold" id="editContactModalLabel">
                                    <i class="fas fa-user-edit me-2"></i>Edit Contact Information
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form
                                action="{{ route('employer.updatehiringpreference.store', session('employer_id')) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Make the modal body scrollable with max-height -->
                                <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">First Name</label>
                                            <input type="text" name="firstName" id="firstName"
                                                class="form-control form-control-lg" placeholder="Enter first name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Last Name</label>
                                            <input type="text" name="lastName" id="lastName"
                                                class="form-control form-control-lg" placeholder="Enter last name">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control form-control-lg" placeholder="example@email.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Phone Number</label>
                                            <input type="text" name="phone_number" id="phone"
                                                class="form-control form-control-lg" placeholder="09xxxxxxxxx">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Complete Address</label>
                                            <input type="text" name="address" id="address"
                                                class="form-control form-control-lg"
                                                placeholder="Street, Barangay, City">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Preferred Contact Method</label>
                                            <select id="contactMethod" name="contact_method"
                                                class="form-select form-select-lg">
                                                <option value="Email">Email</option>
                                                <option value="Phone">Phone</option>
                                                <option value="Sms">Sms</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Best Time to Contact</label>
                                            <select id="contactTime" name="contact_time"
                                                class="form-select form-select-lg">
                                                <option value="">Select best time</option>
                                                <option value="morning">Morning (8AM - 12PM)</option>
                                                <option value="afternoon">Afternoon (12PM - 5PM)</option>
                                                <option value="evening">Evening (5PM - 8PM)</option>
                                                <option value="anytime">Anytime during business hours</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Language Preference</label>
                                            <select id="languagePreference" name="language_preference"
                                                class="form-select form-select-lg">
                                                <option value="english">English</option>
                                                <option value="filipino">Filipino/Tagalog</option>
                                                <option value="cebuano">Cebuano</option>
                                                <option value="ilocano">Ilocano</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer bg-light rounded-bottom-4">
                                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="fas fa-save me-1"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const editLinks = document.querySelectorAll('.edit-link[data-bs-target="#editContactModal"]');

                        editLinks.forEach(link => {
                            link.addEventListener('click', function() {
                                document.getElementById('firstName').value = this.getAttribute(
                                    'data-firstname') || '';
                                document.getElementById('lastName').value = this.getAttribute(
                                    'data-lastname') || '';
                                document.getElementById('email').value = this.getAttribute('data-email') || '';
                                document.getElementById('phone').value = this.getAttribute('data-phone') || '';
                                document.getElementById('address').value = this.getAttribute('data-address') ||
                                    '';
                                document.getElementById('contactMethod').value = this.getAttribute(
                                    'data-contact') || 'Email';
                                document.getElementById('contactTime').value = this.getAttribute('data-time') ||
                                    '';
                                document.getElementById('languagePreference').value = this.getAttribute(
                                    'data-language') || 'english';
                            });
                        });
                    });
                </script>

                <!-- Job Details -->
                <!-- Job Details -->
                <div class="col-12 mb-4">
                    <div class="review-card">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-briefcase text-warning me-2"></i>Job Details
                                </h5>
                                <a href="#" class="edit-link" data-bs-toggle="modal"
                                    data-bs-target="#editJobModal">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="summary-item">
                                        <strong>{{ $retrievedJobDetail->title }}</strong>
                                        <div class="text-muted">
                                            {{ $retrievedJobDetail->department }} •
                                            {{ $retrievedJobDetail->location }} • {{ $retrievedJobDetail->work_type }}
                                        </div>
                                        <div class="text-muted">
                                            {{ $retrievedJobDetail->experience_level }} •
                                            ₱{{ $retrievedJobDetail->job_salary }}/month
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <p class="small">
                                            <strong>Job Description:</strong>
                                            {{ $retrievedJobDetail->job_description }}
                                            <br />
                                            <strong>Job Requirements:</strong>
                                            {{ $retrievedJobDetail->additional_requirements ?? 'No additional requirements' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="tesda-highlight">
                                        <strong>Required TESDA Certifications:</strong>
                                        <div class="mt-2">
                                            @php
                                                $certs = [];

                                                if (!empty($retrievedJobDetail->tesda_certification)) {
                                                    $certsRaw = $retrievedJobDetail->tesda_certification;
                                                } elseif (!empty($retrievedJobDetail->other_certifications)) {
                                                    $certsRaw = $retrievedJobDetail->other_certifications;
                                                } elseif (
                                                    !empty($retrievedJobDetail->none_certifications_qualification)
                                                ) {
                                                    $certsRaw = $retrievedJobDetail->none_certifications_qualification;
                                                } else {
                                                    $certsRaw = null;
                                                }

                                                if ($certsRaw) {
                                                    $decoded = json_decode($certsRaw, true);
                                                    if (is_array($decoded)) {
                                                        $certs = $decoded;
                                                    } else {
                                                        $certs = array_map('trim', explode(',', $certsRaw));
                                                    }
                                                }
                                            @endphp

                                            @if (!empty($certs))
                                                @foreach ($certs as $certification)
                                                    <span class="skill-badge">{{ $certification }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No certifications provided.</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Benefits Offered:</strong>
                                    <div class="mt-2">
                                        @php
                                            $benefits = [];
                                            if (!empty($retrievedJobDetail->benefits)) {
                                                $decoded = json_decode($retrievedJobDetail->benefits, true);
                                                if (is_array($decoded)) {
                                                    $benefits = $decoded;
                                                } else {
                                                    $benefits = array_map(
                                                        'trim',
                                                        explode(',', $retrievedJobDetail->benefits),
                                                    );
                                                }
                                            }
                                        @endphp

                                        @if (!empty($benefits))
                                            @foreach ($benefits as $benefit)
                                                <span class="skill-badge">{{ $benefit }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No benefits selected.</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Job Modal (No Backdrop + Scrollable) -->
                <div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel"
                    aria-hidden="true" data-bs-backdrop="false">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editJobModalLabel">Edit Job Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('employer.updatejobdetails.store', session('employer_id')) }}"
                                    method="POST" id="editJobForm">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3">
                                        <!-- Job Title -->
                                        <div class="col-md-6">
                                            <label for="jobTitle" class="form-label">Job Title</label>
                                            <input type="text" name="title" id="jobTitle" class="form-control"
                                                value="{{ $retrievedJobDetail->title ?? '' }}" required>
                                        </div>

                                        <!-- Department -->
                                        <div class="col-md-6">
                                            <label for="department" class="form-label">Department </label>
                                            <select class="form-select" name="department" id="department" required>
                                                <option value="">
                                                    {{ $retrievedJobDetail->department ?? 'Select department' }}
                                                </option>
                                                @php
                                                    $departments = [
                                                        'Construction',
                                                        'Electrical',
                                                        'Mechanical',
                                                        'Welding & Fabrication',
                                                        'Carpentry',
                                                        'Plumbing',
                                                        'Automotive',
                                                        'Maintenance',
                                                        'Food Production',
                                                        'Quality Control',
                                                        'Operations',
                                                        'Safety & Security',
                                                    ];
                                                @endphp
                                                @foreach ($departments as $dept)
                                                    <option value="{{ $dept }}"
                                                        {{ ($retrievedJobDetail->department ?? '') == $dept ? 'selected' : '' }}>
                                                        {{ $dept }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Salary Range -->
                                        <div class="col-md-6">
                                            <label for="salaryRange" class="form-label">
                                                Salary Range
                                            </label>


                                            <select class="form-select" id="jobSalarySelect"
                                                name="job_salary_range"required>
                                                <option value="{{ $retrievedJobDetail->job_salary ?? '' }}" disabled
                                                    selected>{{ $retrievedJobDetail->job_salary ?? '' }}</option>
                                                <option value="Below 10,000">Below 10,000 monthly</option>
                                                <option value="10,000 - 20,000">10,000 - 20,000 monthly</option>
                                                <option value="20,001 - 30,000">20,001 - 30,000 monthly</option>
                                                <option value="30,001 - 40,000">30,001 - 40,000 monthly</option>
                                                <option value="40,001 - 50,000">40,001 - 50,000 monthly</option>
                                                <option value="50,001 - 60,000">50,001 - 60,000 monthly</option>
                                                <option value="Above 60,000">Above 60,000 monthly</option>
                                            </select>
                                        </div>

                                        <!-- Location -->
                                        <div class="col-md-6">
                                            <label for="jobLocation" class="form-label">Location</label>
                                            <input type="text" name="location" id="jobLocation"
                                                class="form-control"
                                                value="{{ $retrievedJobDetail->location ?? '' }} " required>
                                        </div>

                                        <!-- Work Type -->
                                        <div class="col-md-6">
                                            <label for="workType" class="form-label">Work Type</label>
                                            <select name="work_type" id="workType" class="form-select">
                                                @php
                                                    $workTypes = ['On-site', 'Project-based', 'Contract', 'Seasonal'];
                                                @endphp
                                                @foreach ($workTypes as $type)
                                                    <option value="{{ $type }}"
                                                        {{ ($retrievedJobDetail->work_type ?? '') == $type ? 'selected' : '' }}>
                                                        {{ $type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Experience Level -->
                                        <div class="col-md-6">
                                            <label for="experienceLevel" class="form-label">Experience Level</label>
                                            <select name="experience_level" id="experienceLevel" class="form-select">
                                                @php
                                                    $levels = [
                                                        'Apprentice Level (0-1 years)',
                                                        'Skilled Worker (2-5 years)',
                                                        'Experienced Craftsman (6-10 years)',
                                                        'Master Craftsman (10+ years)',
                                                        'Supervisor/Foreman',
                                                    ];
                                                @endphp
                                                @foreach ($levels as $level)
                                                    <option value="{{ $level }}"
                                                        {{ ($retrievedJobDetail->experience_level ?? '') == $level ? 'selected' : '' }}>
                                                        {{ $level }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Job Description -->
                                        <div class="col-md-12">
                                            <label for="jobDescription" class="form-label">Job Description</label>
                                            <textarea name="job_description" id="jobDescription" rows="4" class="form-control">{{ $retrievedJobDetail->job_description ?? '' }}</textarea>
                                        </div>

                                        <!-- Job Requirements -->
                                        <div class="col-md-12">
                                            <label for="jobRequirements" class="form-label">Job Requirements</label>
                                            <textarea name="additional_requirements" id="jobRequirements" rows="3" class="form-control">{{ $retrievedJobDetail->additional_requirements ?? '' }}</textarea>
                                        </div>

                                        <!-- TESDA Certifications -->
                                        <div class="col-md-12">
                                            <label for="tesdaCerts" class="form-label">TESDA Certifications</label>
                                            <input type="text" name="tesda_certification" id="tesdaCerts"
                                                class="form-control" value="{{ implode(', ', $certs ?? []) }}"
                                                placeholder="e.g. NCII, Housekeeping, Welding">
                                            <small class="text-muted">Separate multiple certifications with
                                                commas</small>
                                        </div>

                                        <!-- Benefits -->
                                        <div class="col-md-12">
                                            <label for="benefits" class="form-label">Benefits Offered</label>
                                            <input type="text" name="benefits" id="benefits"
                                                class="form-control" value="{{ implode(', ', $benefits ?? []) }}"
                                                placeholder="e.g. SSS, PhilHealth, Free meals">
                                            <small class="text-muted">Separate multiple benefits with commas</small>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-warning w-100">Save Changes</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hiring Preferences -->
                <div class="col-12 mb-4">
                    <div class="review-card">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-cog text-info me-2"></i>Hiring Preferences
                                </h5>
                                <a href="#" class="edit-link" data-bs-toggle="modal"
                                    data-bs-target="#editPreferencesModal">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mt-3">
                                <strong>Screening Methods:</strong>
                                @foreach (json_decode($retrievedInterviewScreening->preferred_screening_method ?? '[]') as $interview)
                                    <span class="skill-badge">{{ $interview }}</span>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                <strong>Location of Interview:</strong>
                                <span
                                    class="skill-badge">{{ $retrievedInterviewScreening->preferred_interview_location }}</span>
                            </div>

                            @php
                                $specialReqs = json_decode(
                                    $retrievedSpecialRequirement->special_requirements ?? '[]',
                                    true,
                                );
                                if (!is_array($specialReqs)) {
                                    $specialReqs = []; // fallback to empty array
                                }
                            @endphp

                            <div class="mt-3">
                                <strong>Special Requirements:</strong>
                                <div class="mt-1">
                                    @foreach ($specialReqs as $requirements)
                                        <i class="fas fa-check text-success me-2"></i>{{ $requirements ?? '' }}<br />
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Edit Hiring Preferences Modal (No Backdrop + Scrollable) -->
                <div class="modal fade" id="editPreferencesModal" tabindex="-1"
                    aria-labelledby="editPreferencesModalLabel" aria-hidden="true" data-bs-backdrop="false">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPreferencesModalLabel">Edit Hiring Preferences</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form
                                    action="{{ route('employer.updatereviewreference.store', session('employer_id')) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3">
                                        <!-- Screening Methods -->
                                        <div class="col-md-12">
                                            <label class="form-label">Screening Methods</label>
                                            <div class="row">
                                                @php
                                                    $selectedMethods = json_decode(
                                                        $retrievedInterviewScreening->preferred_screening_method ??
                                                            '[]',
                                                    );
                                                @endphp
                                                <div class="col-md-6">
                                                    @php $methodsLeft = ['Phone/Video interview', 'In-person interview', 'Skills demonstration/test']; @endphp
                                                    @foreach ($methodsLeft as $method)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="preferred_screening_method[]"
                                                                value="{{ $method }}"
                                                                id="{{ str_replace([' ', '/'], '', $method) }}"
                                                                {{ in_array($method, $selectedMethods) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="{{ str_replace([' ', '/'], '', $method) }}">
                                                                {{ $method }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-6">
                                                    @php $methodsRight = ['Reference check', 'Background verification', 'Drug testing']; @endphp
                                                    @foreach ($methodsRight as $method)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="preferred_screening_method[]"
                                                                value="{{ $method }}"
                                                                id="{{ str_replace([' ', '/'], '', $method) }}"
                                                                {{ in_array($method, $selectedMethods) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="{{ str_replace([' ', '/'], '', $method) }}">
                                                                {{ $method }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Interview Location -->
                                        <div class="col-md-12 mt-3">
                                            <label for="interviewLocation" class="form-label">Preferred Interview
                                                Location</label>
                                            @php
                                                $selectedLocation =
                                                    $retrievedInterviewScreening->preferred_interview_location ?? '';
                                            @endphp
                                            <select class="form-select" id="interviewLocation"
                                                name="preferred_interview_location">
                                                <option value="">Select location</option>
                                                <option value="Our office/headquarters"
                                                    {{ $selectedLocation == 'Our office/headquarters' ? 'selected' : '' }}>
                                                    Our office/headquarters</option>
                                                <option value="Job site/project location"
                                                    {{ $selectedLocation == 'Job site/project location' ? 'selected' : '' }}>
                                                    Job site/project location</option>
                                                <option value="Neutral location (cafe, etc.)"
                                                    {{ $selectedLocation == 'Neutral location (cafe, etc.)' ? 'selected' : '' }}>
                                                    Neutral location (cafe, etc.)</option>
                                                <option value="Online/Video call only"
                                                    {{ $selectedLocation == 'Online/Video call only' ? 'selected' : '' }}>
                                                    Online/Video call only</option>
                                                <option value="Flexible - worker's choice"
                                                    {{ $selectedLocation == "Flexible - worker's choice" ? 'selected' : '' }}>
                                                    Flexible - worker's choice</option>
                                            </select>
                                        </div>

                                        <!-- Special Requirements -->
                                        <div class="col-md-12 mt-3">
                                            <label for="specialRequirements" class="form-label">Special
                                                Requirements</label>
                                            @php
                                                $specialReqs = json_decode(
                                                    $retrievedSpecialRequirement->special_requirements ?? '[]',
                                                    true,
                                                );
                                                if (!is_array($specialReqs)) {
                                                    $specialReqs = []; // fallback to empty array
                                                }

                                                $predefinedReqs = [
                                                    'Workers must have safety training certificates',
                                                    'Workers must bring their own basic tools',
                                                    'Provide transportation or allowance',
                                                ];
                                            @endphp

                                            <!-- Predefined checkboxes -->
                                            @foreach ($predefinedReqs as $req)
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input special-checkbox"
                                                        name="special_requirements[]" type="checkbox"
                                                        value="{{ $req }}"
                                                        id="{{ str_replace([' ', '/'], '', $req) }}"
                                                        {{ in_array($req, $specialReqs) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ str_replace([' ', '/'], '', $req) }}">{{ $req }}</label>
                                                </div>
                                            @endforeach

                                            <!-- Textarea for custom special requirements -->
                                            <textarea name="custom_special_requirements" id="specialRequirements" rows="6" class="form-control mt-2"
                                                placeholder="Enter custom special requirements (one per line)">{{ implode("\n", array_diff($specialReqs, $predefinedReqs)) }}</textarea>
                                            <small class="text-muted d-block">
                                                Checked boxes will automatically appear here. You can also add custom
                                                requirements manually.
                                            </small>

                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-info w-100">Save Changes</button>
                                        </div>
                                </form>

                                <script>
                                    // Sync predefined checkboxes with textarea
                                    const specialTextarea = document.getElementById('specialRequirements');
                                    const specialCheckboxes = document.querySelectorAll('.special-checkbox');

                                    specialCheckboxes.forEach(cb => {
                                        cb.addEventListener('change', () => {
                                            let currentValues = specialTextarea.value.split("\n").map(v => v.trim()).filter(v => v);
                                            if (cb.checked && !currentValues.includes(cb.value)) {
                                                currentValues.push(cb.value);
                                            } else if (!cb.checked) {
                                                currentValues = currentValues.filter(v => v !== cb.value);
                                            }
                                            specialTextarea.value = currentValues.join("\n");
                                        });
                                    });
                                </script>


                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!---modal--->


            <!-- Final Checklist -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="final-checklist">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-clipboard-check text-success me-2"></i>Final
                            Checklist
                        </h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="reviewComplete" required />
                            <label class="form-check-label" for="reviewComplete">
                                I have reviewed all information and confirm it is accurate
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required />
                            <label class="form-check-label" for="agreeTerms">
                                I agree to Mangagawang Pinoy's
                                <a href="{{ route('display.termsandconditions') }}"
                                    class="text-decoration-underline">Terms of Service</a>
                                and
                                <a href="{{ route('display.privacypolicy') }}"
                                    class="text-decoration-underline">Privacy Policy</a>
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="communicationConsent" required />
                            <label class="form-check-label" for="communicationConsent">
                                I consent to receiving communications about worker applications
                                and platform updates
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="dataProcessing" required />
                            <label class="form-check-label" for="dataProcessing">
                                I consent to the processing of my company and personal data for
                                hiring purposes in accordance with the Data Privacy Act
                            </label>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>What happens next?</strong><br />
                            You'll receive an email confirmation and can start
                            receiving worker applications.
                        </div>
                        <div class="row justify-content-center mt-4">
                            <div class="col-lg-8">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="previousStep()">
                                        <i class="fas fa-arrow-left me-2"></i>Previous
                                    </button>
                                    <small class="text-muted">Step 4 of 4</small>
                                    <form action="{{ route('employer.sendVerificationEmail') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="account_email"
                                            value="{{ $retriedAccountInfo->email }}">
                                        <button type="submit" class="btn btn-primary-custom"> Submit <i
                                                class="fas fa-arrow-right ms-2"></i></button>

                                    </form>
                                </div>

                            </div>
                        </div>


                        </form>
                    </div>


                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    <script>
                        function submitRegistration() {
                            // Check all required checkboxes
                            const requiredCheckboxes = [
                                "reviewComplete",
                                "agreeTerms",
                                "communicationConsent",
                                "dataProcessing",
                            ];

                            let allChecked = true;
                            requiredCheckboxes.forEach((id) => {
                                if (!document.getElementById(id).checked) {
                                    allChecked = false;
                                }
                            });

                            if (!allChecked) {
                                alert(
                                    "Please complete all required checkboxes before submitting.",
                                );
                                return;
                            }

                            // Show loading state
                            const submitBtn = document.getElementById("submitBtn");
                            submitBtn.innerHTML =
                                '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
                            submitBtn.disabled = true;

                            // Simulate submission delay
                            setTimeout(() => {
                                window.location.href = "{{ route('employer.successregistration.display') }}";
                            }, 2000);
                        }

                        function previousStep() {
                            window.location.href = "{{ route('employer.hiringpreference.display') }}";
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
                    </script>
</body>

</html>
