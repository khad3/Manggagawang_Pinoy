<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobTracker - Application Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/applicant/my_application/applicantion.css') }}" rel="stylesheet">

</head>

<body>

    <div class="container-fluid p-4">
        <a href="{{ route('applicant.info.homepage.display') }}"
            class="btn btn-primary back-button d-inline-flex align-items-center shadow rounded-pill px-4 py-3">
            <i class="fas fa-arrow-left me-2 fs-5"></i>
            Back to Homepage
        </a>
    </div>

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
    <div class="container-fluid dashboard-container">
        <div class="container">
            <!-- Page Header -->
            <div class="text-center mb-5">
                <h1 class="page-title">Job Application Dashboard</h1>
                <p class="page-subtitle">Track your applications and manage your career journey</p>
            </div>

            <!-- Dashboard Stats -->
            <div class="row g-4 mb-5">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Total Applications</p>
                                <h3 class="stat-number mb-0">4</h3>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Pending Review</p>
                                <h3 class="stat-number mb-0" style="color: var(--warning-color)">1</h3>
                            </div>
                            <div class="stat-icon"
                                style="background: linear-gradient(135deg, var(--warning-color), #f59e0b)">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Interviews</p>
                                <h3 class="stat-number mb-0" style="color: var(--info-color)">1</h3>
                            </div>
                            <div class="stat-icon"
                                style="background: linear-gradient(135deg, var(--info-color), #8b5cf6)">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Accepted</p>
                                <h3 class="stat-number mb-0" style="color: var(--success-color)">0</h3>
                            </div>
                            <div class="stat-icon"
                                style="background: linear-gradient(135deg, var(--success-color), #10b981)">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Tabs -->
            <div class="tab-container">
                <ul class="nav nav-tabs custom-tabs" id="mainTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="applications-tab" data-bs-toggle="tab"
                            data-bs-target="#applications" type="button" role="tab">
                            <i class="fas fa-file-alt me-2"></i>My Applications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="saved-tab" data-bs-toggle="tab" data-bs-target="#saved"
                            type="button" role="tab">
                            <i class="fas fa-heart me-2"></i>Saved Jobs
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="mainTabsContent">
                    <!-- Applications Tab -->
                    <div class="tab-pane fade show active" id="applications" role="tabpanel">
                        <div class="p-4">
                            <div class="row mb-4">
                                <div class="col-12 col-md-8">
                                    <h4 class="mb-0 fw-bold">Application Status</h4>
                                    <p class="text-muted mt-1">Monitor your job application progress</p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="d-flex flex-column flex-md-row gap-3">
                                        <div class="search-container flex-grow-1">
                                            <i class="fas fa-search search-icon"></i>
                                            <input type="text" class="form-control search-input"
                                                placeholder="Search applications...">
                                        </div>
                                        <select class="form-select" style="min-width: 140px;">
                                            <option value="all">All Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="reviewed">Being Reviewed</option>
                                            <option value="interview">Interview</option>
                                            <option value="accepted">Accepted</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Static Application Examples -->
                            @foreach ($appliedJobs as $job)
                                <div class="application-card">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-lg-8">
                                            <div
                                                class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 mb-2">
                                                <h5 class="job-title mb-0">{{ $job->job->title ?? 'No title' }}</h5>
                                                @if ($job->status == 'pending')
                                                    <span class="status-badge status-pending">
                                                        <i class="fas fa-clock"></i>
                                                        Pending
                                                    </span>
                                                @elseif ($job->status == 'being_reviewed')
                                                    <span class="status-badge status-reviewed">
                                                        <i class="fas fa-file-alt"></i>
                                                        Being Reviewed
                                                    </span>
                                                @elseif ($job->status == 'interview')
                                                    <span class="status-badge status-interview">
                                                        <i class="fas fa-chart-line"></i>
                                                        Interview
                                                    </span>
                                                @elseif ($job->status == 'approved')
                                                    <span class="status-badge status-approved">
                                                        <i class="fas fa-check-circle"></i>
                                                        Approved
                                                    </span>
                                                @elseif ($job->status == 'rejected')
                                                    <span class="status-badge status-rejected">
                                                        <i class="fas fa-times-circle"></i>
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="status-badge status-unknown">
                                                        <i class="fas fa-question-circle"></i>
                                                        {{ $job->status ?? 'Unknown' }}
                                                    </span>
                                                @endif


                                            </div>
                                            <p class="company-name mb-3">
                                                {{ $job->job->employer->addressCompany->company_name ?? ('No company' ?? 'No company') }}
                                            </p>
                                            <div class="job-details d-flex flex-column flex-md-row gap-3">
                                                <span><i
                                                        class="fas fa-map-marker-alt"></i>{{ $job->job->location ?? 'No location' }}</span>
                                                <span><i class="fas fa-calendar"></i>Applied:
                                                    {{ $job->created_at->format('M d, Y') ?? 'No date' }}</span>
                                                <span>
                                                    <i class="fas fa-coins"></i>
                                                    &#8369;{{ $job->job->job_salary ?? 'No salary' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#viewApplicationDetailsModal">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="application-card">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg-8">
                                        <div
                                            class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 mb-2">
                                            <h5 class="job-title mb-0">Journeyman Electrician</h5>
                                            <span class="status-badge status-reviewed">
                                                <i class="fas fa-file-alt"></i>
                                                Being Reviewed
                                            </span>
                                        </div>
                                        <p class="company-name mb-3">City Electric Services</p>
                                        <div class="job-details d-flex flex-column flex-md-row gap-3">
                                            <span><i class="fas fa-map-marker-alt"></i>Phoenix, AZ</span>
                                            <span><i class="fas fa-calendar"></i>Applied: 1/12/2024</span>
                                            <span><i class="fas fa-dollar-sign"></i>$60,000 - $75,000</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#viewApplicationDetailsModal">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="application-card">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg-8">
                                        <div
                                            class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 mb-2">
                                            <h5 class="job-title mb-0">Plumber</h5>
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-clock"></i>
                                                Pending
                                            </span>
                                        </div>
                                        <p class="company-name mb-3">Ace Plumbing Solutions</p>
                                        <div class="job-details d-flex flex-column flex-md-row gap-3">
                                            <span><i class="fas fa-map-marker-alt"></i>Denver, CO</span>
                                            <span><i class="fas fa-calendar"></i>Applied: 1/18/2024</span>
                                            <span><i class="fas fa-dollar-sign"></i>$50,000 - $65,000</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#viewApplicationDetailsModal">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="application-card">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg-8">
                                        <div
                                            class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 mb-2">
                                            <h5 class="job-title mb-0">Maintenance Technician</h5>
                                            <span class="status-badge status-rejected">
                                                <i class="fas fa-times-circle"></i>
                                                Rejected
                                            </span>
                                        </div>
                                        <p class="company-name mb-3">Industrial Maintenance Corp</p>
                                        <div class="job-details d-flex flex-column flex-md-row gap-3">
                                            <span><i class="fas fa-map-marker-alt"></i>Detroit, MI</span>
                                            <span><i class="fas fa-calendar"></i>Applied: 1/8/2024</span>
                                            <span><i class="fas fa-dollar-sign"></i>$45,000 - $58,000</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#viewApplicationDetailsModal">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Saved Jobs Tab -->
                    <div class="tab-pane fade" id="saved" role="tabpanel">
                        <div class="p-4">
                            <div class="d-flex align-items-center mb-4">
                                <h4 class="mb-0 fw-bold">
                                    @if ($retrievedSavedJobs->count() === 1)
                                        Saved Job ({{ $retrievedSavedJobs->count() }})
                                    @else
                                        Saved Jobs ({{ $retrievedSavedJobs->count() }})
                                    @endif
                                </h4>
                                <p class="text-muted mt-1 ms-3">Jobs you've bookmarked for later</p>
                            </div>

                            <!-- ✅ Dynamic Saved Jobs -->
                            @forelse ($retrievedSavedJobs as $savedJob)
                                <div class="job-card">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-lg-8">
                                            <div
                                                class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 mb-2">
                                                <h5 class="job-title mb-0">{{ $savedJob->job->title ?? 'No title' }}
                                                </h5>
                                                <span class="badge">{{ $savedJob->job->job_type ?? 'N/A' }}</span>
                                            </div>

                                            <p class="company-name mb-3">
                                                {{ $savedJob->job->employer->addressCompany->company_name ?? 'No company' }}
                                            </p>

                                            <div class="job-details d-flex flex-column flex-md-row gap-3">
                                                <span>
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    {{ $savedJob->job->employer->addressCompany->company_municipality ?? 'No location' }}
                                                    {{ $savedJob->job->employer->addressCompany->company_province ?? '' }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-coins"></i>
                                                    &#8369;{{ $savedJob->job->job_salary ?? 'No salary' }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-calendar"></i>
                                                    Posted:
                                                    {{ optional($savedJob->job->created_at)->format('M j, Y') ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                                            <div class="d-flex gap-2 justify-content-lg-end flex-wrap">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#viewSavedJobModal"
                                                    data-job-id="{{ $savedJob->job_id ?? 'No job ID' }}"
                                                    data-job-title="{{ $savedJob->job->title ?? 'No title' }}"
                                                    data-company-name="{{ $savedJob->job->employer->addressCompany->company_name ?? 'No company' }}"
                                                    data-job-location="{{ $savedJob->job->employer->addressCompany->company_municipality ?? 'No location' }} {{ $savedJob->job->employer->addressCompany->company_province ?? '' }}"
                                                    data-job-salary="&#8369;{{ $savedJob->job->job_salary ?? 'No salary' }}"
                                                    data-job-type="{{ $savedJob->job->job_type ?? 'N/A' }}"
                                                    data-posted-date="{{ optional($savedJob->job->created_at)->format('M j, Y') ?? 'N/A' }}"
                                                    data-first-name="{{ $savedJob->job->employer->personal_info->first_name ?? 'No first name' }} {{ $savedJob->job->employer->personal_info->last_name ?? '' }}"
                                                    data-employer-email="{{ $savedJob->job->employer->email ?? 'No email' }}"
                                                    data-experience-level="{{ $savedJob->job->experience_level ?? 'N/A' }}"
                                                    data-job-description="{{ $savedJob->job->job_description ?? 'No description' }}"
                                                    data-job-addtional-requirements="{{ $savedJob->job->additional_requirements ?? 'N/A' }}"
                                                    data-job-benefits="{{ $savedJob->job->benefits ?? 'N/A' }}">

                                                    <i class="fas fa-eye me-1"></i>View Details
                                                </button>

                                                @php
                                                    $alreadyApplied = \App\Models\Applicant\ApplyJobModel::where(
                                                        'job_id',
                                                        $savedJob->job->id ?? null,
                                                    )
                                                        ->where('applicant_id', session('applicant_id'))
                                                        ->exists();
                                                @endphp

                                                @if ($alreadyApplied)
                                                    <button class="btn btn-secondary btn-sm" disabled>
                                                        <i class="fas fa-check me-1"></i>Already Applied
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#applyJobModal"
                                                        data-job-title="{{ $savedJob->job->title ?? 'No title' }}"
                                                        data-company-name="{{ $savedJob->job->employer->addressCompany->company_name ?? 'No company' }}"
                                                        data-job-location="{{ $savedJob->job->employer->addressCompany->company_municipality ?? 'No location' }} {{ $savedJob->job->employer->addressCompany->company_province ?? '' }}">
                                                        <i class="fas fa-paper-plane me-1"></i>Apply Now
                                                    </button>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="fas fa-heart fa-3x text-muted opacity-50"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">No Saved Jobs Yet</h5>
                                    <p class="text-muted">Start browsing jobs and save the ones you're interested in!
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Application Details Modal -->
    <div class="modal fade" id="viewApplicationDetailsModal" tabindex="-1"
        aria-labelledby="viewApplicationDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewApplicationDetailsModalLabel">
                        <i class="fas fa-info-circle me-2"></i>Application Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modal-detail-item">
                                <div class="detail-label">Position</div>
                                <div class="detail-value">Construction Foreman</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Company</div>
                                <div class="detail-value">Metro Construction LLC</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Location</div>
                                <div class="detail-value">Houston, TX</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Salary Range</div>
                                <div class="detail-value">$55,000 - $70,000</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Application Date</div>
                                <div class="detail-value">1/15/2024</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Application Status</div>
                                <div class="detail-value">
                                    <span class="status-badge status-interview">
                                        <i class="fas fa-chart-line"></i>
                                        Interview
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-detail-item">
                                <div class="detail-label">Contact Person</div>
                                <div class="detail-value">Mike Rodriguez</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Contact Email</div>
                                <div class="detail-value">
                                    <a
                                        href="mailto:mike.rodriguez@metroconstruction.com">mike.rodriguez@metroconstruction.com</a>
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Application Notes</div>
                                <div class="detail-value">Interview scheduled for January 25th at 10:00 AM</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Next Steps</div>
                                <div class="detail-value">Prepare for upcoming interview - Review job requirements and
                                    company background</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="modal-detail-item">
                                <div class="detail-label">Job Description</div>
                                <div class="detail-value">Lead construction teams on residential and commercial
                                    projects. Oversee daily operations, ensure safety compliance, and manage project
                                    timelines.</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Requirements</div>
                                <div class="detail-value">
                                    <ul class="mb-0">
                                        <li>5+ years construction experience</li>
                                        <li>OSHA certification</li>
                                        <li>Team leadership experience</li>
                                        <li>Valid driver's license</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Benefits</div>
                                <div class="detail-value">
                                    <ul class="mb-0">
                                        <li>Health insurance</li>
                                        <li>Dental coverage</li>
                                        <li>Retirement plan</li>
                                        <li>Paid time off</li>
                                        <li>Tool allowance</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Update Application
                    </button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-calendar me-2"></i>Schedule Interview
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Saved Job Details Modal -->
    <div class="modal fade" id="viewSavedJobModal" tabindex="-1" aria-labelledby="viewSavedJobModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewSavedJobModalLabel">
                        <i class="fas fa-briefcase me-2"></i>Job Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modal-detail-item">
                                <div class="detail-label">Position</div>
                                <div class="detail-value" id="modal-job-title">Loading...</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Company</div>
                                <div class="detail-value" id="modal-company-name">Loading...</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Location</div>
                                <div class="detail-value" id="modal-job-location">Loading...</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Salary Range</div>
                                <div class="detail-value" id="modal-job-salary">Loading...</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Posted Date</div>
                                <div class="detail-value" id="modal-posted-date">Loading...</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Job Type</div>
                                <div class="detail-value">
                                    <span class="job-type-badge" id="modal-job-type">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-detail-item">
                                <div class="detail-label">Contact Person</div>
                                <div class="detail-value" id="modal-first-name">Loading...</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Contact Email</div>
                                <div class="detail-value">
                                    <a href="mailto:hr@company.com" id="modal-employer-email">Loading...</a>
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Application Deadline</div>
                                <div class="detail-value">Open until filled</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Experience Level</div>
                                <div class="detail-value" id="modal-experience-level">Loading...</div>
                            </div>
                            <!-- <div class="modal-detail-item">
                            <div class="detail-label">Remote Work</div>
                            <div class="detail-value">Hybrid - 3 days in office</div>
                        </div> -->
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="modal-detail-item">
                                <div class="detail-label">Job Description</div>
                                <div class="detail-value" id="modal-job-description">
                                    Loading...
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Requirements</div>
                                <div class="detail-value">
                                    <div class="requirements-list" id="modal-job-additional-requirements">
                                        <ul>
                                            <li>Loading...</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Benefits & Perks</div>
                                <div class="detail-value">
                                    <div class="benefits-list" id="modal-job-benefits">
                                        <ul>
                                            <li>Loading...</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="modal-detail-item">
                            <div class="detail-label">Company Culture</div>
                            <div class="detail-value">
                                We foster an innovative and collaborative work environment where creativity thrives. We believe in work-life balance and provide our employees with the tools and support they need to succeed. Our diverse team is passionate about technology and committed to making a positive impact in the industry. We value continuous learning, open communication, and mutual respect.
                            </div>
                        </div> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                    <form id="unsaveForm" action="" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to remove this job from saved?');">
                            <i class="fas fa-heart-broken me-2"></i>Remove from Saved
                        </button>
                    </form>


                    <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                        onclick="openApplyModal()">
                        <i class="fas fa-paper-plane me-2"></i>Apply Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Apply Job Modal -->
    <div class="modal fade" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyJobModalLabel">
                        <i class="fas fa-paper-plane me-2"></i>Apply for Position
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <h6 class="fw-bold mb-2" id="apply-job-title">Software Engineer</h6>
                                <p class="mb-1 text-muted" id="apply-company-name">TechCorp Solutions</p>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    <span id="apply-job-location">San Francisco, CA</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('jobs.apply.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $savedJob->job_id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Phone Number *</label>
                                    <input type="tel" class="form-control" name="phone_number"
                                        placeholder="+63 912 345 6789">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Resume/CV *</label>
                            <input type="file" class="form-control" name="resume" accept=".pdf,.doc,.docx"
                                required>
                            <div class="form-text">Accepted formats: PDF, DOC, DOCX (Max 5MB)</div>
                        </div>
                        <div class="mb-3">
                            <label for="certi" class="form-label">Upload TESDA Certificate (PDF,
                                DOC)</label>
                            <input type="file" name="tesda_certificate" class="form-control"
                                accept=".pdf,.doc,.docx" @if ($tesdaCertification && $tesdaCertification->status == 'approved') @else disabled @endif>

                            @if ($tesdaCertification && $tesdaCertification->status == 'pending')
                                <p class="text-warning mt-2">Your TESDA Certificate is under review. Thank
                                    you.</p>
                            @elseif (!$tesdaCertification || $tesdaCertification->status != 'approved')
                                <p class="text-danger mt-2">Please upload your TESDA Certificate before
                                    applying. Thank you.</p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Cover Letter</label>
                            <textarea class="form-control" name="cover_letter" rows="4"
                                placeholder="Tell us why you're interested in this position and what makes you a great fit..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Additional Information</label>
                            <textarea class="form-control" name="additional_info" rows="3"
                                placeholder="Any additional information you'd like to share..."></textarea>
                        </div>
                        <!-- <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="termsCheck" name="terms_accepted" required>
                            <label class="form-check-label" for="termsCheck">
                                I agree to the <a href="#" target="_blank">terms and conditions</a> and <a href="#" target="_blank">privacy policy</a> *
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="newsletterCheck" name="newsletter_subscribe">
                            <label class="form-check-label" for="newsletterCheck">
                                Subscribe to our newsletter for job updates and company news
                            </label>
                        </div>
                    </div> -->
                        <div class="modal-footer">

                        </div>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        @php
                            $alreadyApplied = \App\Models\Applicant\ApplyJobModel::where('job_id', $savedJob->job_id)
                                ->where('applicant_id', session('applicant_id'))
                                ->exists();
                        @endphp

                        @if ($alreadyApplied)
                            <button type="button" class="btn btn-secondary" disabled>
                                <i class="fas fa-check me-2"></i>Already Submitted
                            </button>
                        @else
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-2"></i>Submit Application
                            </button>
                        @endif

                    </form>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var viewModal = document.getElementById('viewSavedJobModal');
            viewModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var jobId = button.getAttribute('data-job-id');

                // Generate URL properly using Laravel's route helper
                var url = "{{ route('jobs.unsave', ':id') }}";
                url = url.replace(':id', jobId);

                var form = document.getElementById('unsaveForm');
                form.action = url;
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update saved job modal with data
        document.addEventListener('DOMContentLoaded', function() {
            const savedJobModal = document.getElementById('viewSavedJobModal');
            if (savedJobModal) {
                savedJobModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const jobTitle = button.getAttribute('data-job-title');
                    const companyName = button.getAttribute('data-company-name');
                    const jobLocation = button.getAttribute('data-job-location');
                    const jobSalary = button.getAttribute('data-job-salary');
                    const jobType = button.getAttribute('data-job-type');
                    const postedDate = button.getAttribute('data-posted-date');
                    const firstName = button.getAttribute('data-first-name');
                    const employerEmail = button.getAttribute('data-employer-email');
                    const experienceLevel = button.getAttribute('data-experience-level');
                    const jobDescription = button.getAttribute('data-job-description');
                    const jobAdditionalRequirements = button.getAttribute(
                        'data-job-addtional-requirements');
                    const jobBenefits = button.getAttribute('data-job-benefits');

                    // Update modal content
                    document.getElementById('modal-job-title').textContent = jobTitle;
                    document.getElementById('modal-company-name').textContent = companyName;
                    document.getElementById('modal-job-location').textContent = jobLocation;
                    document.getElementById('modal-job-salary').innerHTML = jobSalary;
                    document.getElementById('modal-job-type').textContent = jobType;
                    document.getElementById('modal-posted-date').textContent = postedDate;
                    document.getElementById('modal-first-name').textContent = firstName;

                    document.getElementById('modal-experience-level').textContent = experienceLevel;
                    document.getElementById('modal-job-description').textContent = jobDescription;

                    const reqList = document.getElementById('modal-job-additional-requirements')
                        .querySelector('ul');
                    reqList.innerHTML = ""; // clear old list

                    if (jobAdditionalRequirements && jobAdditionalRequirements !== "No requirements") {
                        jobAdditionalRequirements.split(",").forEach(req => {
                            let li = document.createElement("li");
                            li.textContent = req.trim();
                            reqList.appendChild(li);
                        });
                    } else {
                        let li = document.createElement("li");
                        li.textContent = "No additional requirements";
                        reqList.appendChild(li);
                    }

                    const benefitList = document.getElementById('modal-job-benefits').querySelector('ul');
                    benefitList.innerHTML = ""; // clear old list

                    if (jobBenefits && jobBenefits !== "No benefits") {
                        jobBenefits.split(",").forEach(benefit => {
                            let li = document.createElement("li");
                            li.textContent = benefit.trim();
                            benefitList.appendChild(li);
                        });
                    } else {
                        let li = document.createElement("li");
                        li.textContent = "No benefits";
                        benefitList.appendChild(li);
                    }

                    // Update contact email
                    // Update modal contact email link
                    const emailLink = document.getElementById('modal-employer-email');
                    emailLink.href = `mailto:${employerEmail}`;
                    emailLink.textContent = employerEmail;
                });
            }

            // Update apply job modal with data
            const applyJobModal = document.getElementById('applyJobModal');
            if (applyJobModal) {
                applyJobModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const jobTitle = button.getAttribute('data-job-title');
                    const companyName = button.getAttribute('data-company-name');
                    const jobLocation = button.getAttribute('data-job-location');

                    // Update modal content
                    document.getElementById('apply-job-title').textContent = jobTitle;
                    document.getElementById('apply-company-name').textContent = companyName;
                    document.getElementById('apply-job-location').textContent = jobLocation;

                    // Update modal title
                    document.getElementById('applyJobModalLabel').innerHTML =
                        `<i class="fas fa-paper-plane me-2"></i>Apply for ${jobTitle}`;
                });
            }

            // Handle form submission
            const applicationForm = document.getElementById('jobApplicationForm');
            if (applicationForm) {
                applicationForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Here you would typically send the form data to your Laravel backend
                    // For now, we'll just show a success message

                    // Close the modal
                    bootstrap.Modal.getInstance(applyJobModal).hide();

                    // Show success message (you can replace this with your preferred notification system)
                    setTimeout(() => {
                        alert(
                            'Application submitted successfully! We will review your application and get back to you soon.'
                        );
                    }, 300);
                });
            }
        });

        // Function to open apply modal from saved job details modal
        function openApplyModal() {
            const jobTitle = document.getElementById('modal-job-title').textContent;
            const companyName = document.getElementById('modal-company-name').textContent;
            const jobLocation = document.getElementById('modal-job-location').textContent;

            // Update apply modal
            document.getElementById('apply-job-title').textContent = jobTitle;
            document.getElementById('apply-company-name').textContent = companyName;
            document.getElementById('apply-job-location').textContent = jobLocation;
            document.getElementById('applyJobModalLabel').innerHTML =
                `<i class="fas fa-paper-plane me-2"></i>Apply for ${jobTitle}`;

            // Show apply modal
            new bootstrap.Modal(document.getElementById('applyJobModal')).show();
        }
    </script>
</body>

</html>
