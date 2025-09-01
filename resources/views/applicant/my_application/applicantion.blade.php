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
                <!-- Total Applications -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Total Applications</p>
                                <h3 class="stat-number mb-0">{{ $pendingInterviewsCounts['total'] }}</h3>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Pending Review</p>
                                <h3 class="stat-number mb-0" style="color: var(--warning-color)">
                                    {{ $pendingInterviewsCounts['pending'] }}
                                </h3>
                            </div>
                            <div class="stat-icon"
                                style="background: linear-gradient(135deg, var(--warning-color), #f59e0b)">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interviews -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Interviews</p>
                                <h3 class="stat-number mb-0" style="color: var(--info-color)">
                                    {{ $pendingInterviewsCounts['interview'] }}
                                </h3>
                            </div>
                            <div class="stat-icon"
                                style="background: linear-gradient(135deg, var(--info-color), #8b5cf6)">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accepted -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Accepted</p>
                                <h3 class="stat-number mb-0" style="color: var(--success-color)">
                                    {{ $pendingInterviewsCounts['approved'] }}
                                </h3>
                            </div>
                            <div class="stat-icon"
                                style="background: linear-gradient(135deg, var(--success-color), #10b981)">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Rejected</p>
                                <h3 class="stat-number mb-0" style="color: var(--danger-color)">
                                    {{ $pendingInterviewsCounts['rejected'] }}
                                </h3>
                            </div>
                            <div class="stat-icon"
                                style="background: linear-gradient(135deg, var(--danger-color), #ef4444)">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Being Reviewed -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fw-semibold">Being Reviewed</p>
                                <h3 class="stat-number mb-0" style="color: var(--primary-color)">
                                    {{ $pendingInterviewsCounts['being_reviewed'] }}
                                </h3>
                            </div>
                            <div class="stat-icon"
                                style="background: linear-gradient(135deg, var(--primary-color), #3b82f6)">
                                <i class="fas fa-search"></i>
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
                                                data-bs-target="#viewApplicationDetailsModal"
                                                data-job-id="{{ $job->job_id ?? 'No job ID' }}"
                                                data-job-title-application="{{ $job->job->title ?? 'No title' }}"
                                                data-job-company-application="{{ $job->job->employer->addressCompany->company_name ?? 'No company' }}"
                                                data-job-location-application="{{ ($job->job->employer->addressCompany->company_municipality ?? 'No location') . ', ' . ($job->job->employer->addressCompany->company_province ?? '') }}"
                                                data-job-salary-application="₱{{ $job->job->job_salary ?? 'No salary' }}"
                                                data-job-description-application="{{ $job->job->job_description ?? 'No description' }}"
                                                data-job-benefits-application="{{ $job->job->benefits ?? 'N/A' }}"
                                                data-apply-job-status-application="{{ $job->status ?? 'N/A' }}"
                                                data-employer-email-application="{{ $job->job->employer->email ?? 'No email' }}"
                                                data-employer-first-name-application="{{ $job->job->employer->personal_info->first_name ?? 'No first name' }}"
                                                data-employer-last-name-application="{{ $job->job->employer->personal_info->last_name ?? 'No last name' }}"
                                                data-job-type-application="{{ $job->job->job_type ?? 'N/A' }}"
                                                data-job-additional-requirements-application="{{ $job->job->additional_requirements ?? 'N/A' }}">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach




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

                            <!-- Dynamic Saved Jobs -->
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

                                                {{-- CHECK APPLICATION STATUS FOR EACH INDIVIDUAL JOB --}}
                                                @php
                                                    $alreadyApplied = \App\Models\Applicant\ApplyJobModel::where(
                                                        'job_id',
                                                        $savedJob->job->id ?? null,
                                                    )
                                                        ->where('applicant_id', session('applicant_id'))
                                                        ->exists();
                                                @endphp

                                                @if ($alreadyApplied)
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#cancelApplicationModal"
                                                        data-job-id="{{ $savedJob->job->id }}">
                                                        <i class="fas fa-times me-1"></i>Cancel Application
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#applyJobModal"
                                                        data-job-id="{{ $savedJob->job->id }}"
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

    <!-- Cancel Application Modal -->
    <div class="modal fade" id="cancelApplicationModal" tabindex="-1" aria-labelledby="cancelApplicationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('jobs.cancel.delete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="job_id" id="cancelJobId">

                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelApplicationModalLabel">
                            <i class="fas fa-exclamation-triangle text-danger me-2"></i>Cancel Application
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure you want to cancel your application for this job?</p>
                        <p class="text-muted mb-0"><small>This action cannot be undone.</small></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Close
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Yes, Cancel
                        </button>
                    </div>
                </form>
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
                                <div class="detail-value" id="modal-job-title-application"> Loading...</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Company</div>
                                <div class="detail-value" id="modal-job-company-application">Loading...</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Location</div>
                                <div class="detail-value" id="modal-job-location-application">Houston, TX</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Salary Range</div>
                                <div class="detail-value" id="modal-job-salary-application">Loading...</div>
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
                                        Loading...
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-detail-item">
                                <div class="detail-label">Contact Person</div>
                                <div class="detail-value">
                                    <span id="modal-employer-first-name-application"></span>
                                    <span id="modal-employer-last-name-application"></span>
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Contact Email</div>
                                <div class="detail-value" id="modal-employer-email-application">
                                    <a
                                        href="mailto:rogelio.cerenado@metroconstruction.com">rogelio.cerenado@metroconstruction.com</a>
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
                                <div class="detail-value" id="modal-job-description-application">Loading...</div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Requirements</div>
                                <div class="detail-value" id="modal-job-additional-requirements-application">
                                    <ul class="mb-0">
                                        <li>...</li>

                                    </ul>
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="detail-label">Benefits</div>
                                <div class="detail-value">
                                    <ul class="mb-0" id="modal-job-benefits-application">
                                        <li>...</li>

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


                    @php
                        $alreadyApplied = false;
                        if (isset($savedJob)) {
                            $alreadyApplied = \App\Models\Applicant\ApplyJobModel::where('job_id', $savedJob->job_id)
                                ->where('applicant_id', session('applicant_id'))
                                ->exists();
                        }
                    @endphp

                    @if ($alreadyApplied)
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class="fas fa-check me-2"></i>Already Applied
                        </button>
                    @else
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                            onclick="openApplyModal()">
                            <i class="fas fa-paper-plane me-2"></i>Apply Now
                        </button>
                    @endif


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

                    <form action="{{ route('jobs.apply.store') }}" method="POST" enctype="multipart/form-data"
                        id="jobApplicationForm">
                        @csrf
                        <input type="hidden" name="job_id" id="apply-job-id-input">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Phone Number *</label>
                                    <input type="tel" class="form-control" name="phone_number"
                                        placeholder="+63 912 345 6789" required>
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
                            <label for="certi" class="form-label">Upload TESDA Certificate (PDF, DOC)</label>
                            <input type="file" name="tesda_certificate" class="form-control"
                                accept=".pdf,.doc,.docx"
                                @if (isset($tesdaCertification) && $tesdaCertification && $tesdaCertification->status == 'approved') @else 
                                    disabled @endif>

                            @if (isset($tesdaCertification) && $tesdaCertification && $tesdaCertification->status == 'pending')
                                <p class="text-warning mt-2">Your TESDA Certificate is under review. Thank you.</p>
                            @elseif (!isset($tesdaCertification) || !$tesdaCertification || $tesdaCertification->status != 'approved')
                                <p class="text-danger mt-2">Please upload your TESDA Certificate before applying. Thank
                                    you.</p>
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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success" id="submitApplicationBtn">
                                <i class="fas fa-paper-plane me-2"></i>Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle Cancel Application Modal
            const cancelModal = document.getElementById("cancelApplicationModal");
            cancelModal.addEventListener("show.bs.modal", function(event) {
                let button = event.relatedTarget;
                let jobId = button.getAttribute("data-job-id");
                document.getElementById("cancelJobId").value = jobId;
            });

            // Handle Unsave Job Modal
            var viewModal = document.getElementById('viewSavedJobModal');
            viewModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var jobId = button.getAttribute('data-job-id');

                var url = "{{ route('jobs.unsave', ':id') }}";
                url = url.replace(':id', jobId);

                var form = document.getElementById('unsaveForm');
                form.action = url;
            });
        });

        // View the status of application
        document.addEventListener('DOMContentLoaded', function() {
            const statusModal = document.getElementById('viewApplicationDetailsModal');

            if (statusModal) {
                statusModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget; // the button that triggered the modal
                    if (!button) return;

                    // Extract values from data-* attributes
                    const jobTitle = button.getAttribute('data-job-title-application') || 'N/A';
                    const jobCompany = button.getAttribute('data-job-company-application') || 'N/A';
                    const jobLocation = button.getAttribute('data-job-location-application') || 'N/A';
                    const jobSalary = button.getAttribute('data-job-salary-application') || 'N/A';
                    const jobDescription = button.getAttribute('data-job-description-application') || 'N/A';
                    const employerEmail = button.getAttribute('data-employer-email-application') || 'N/A';
                    const employerFirstName = button.getAttribute('data-employer-first-name-application') ||
                        'N/A';
                    const employerLastName = button.getAttribute('data-employer-last-name-application') ||
                        'N/A';
                    const applyStatus = button.getAttribute('data-apply-job-status-application') || 'N/A';
                    const requirements = button.getAttribute(
                        'data-job-additional-requirements-application') || 'N/A';
                    const jobBenefits = button.getAttribute('data-job-benefits-application') || 'N/A';

                    // Update modal content
                    document.getElementById('modal-job-title-application').textContent = jobTitle;
                    document.getElementById('modal-job-company-application').textContent = jobCompany;
                    document.getElementById('modal-job-location-application').textContent = jobLocation;
                    document.getElementById('modal-job-salary-application').textContent = jobSalary;
                    document.getElementById('modal-job-description-application').textContent =
                        jobDescription;

                    // Contact info
                    document.getElementById('modal-employer-first-name-application').textContent =
                        `${employerFirstName} ${employerLastName}`;
                    document.getElementById('modal-employer-email-application').innerHTML =
                        `<a href="mailto:${employerEmail}">${employerEmail}</a>`;

                    // Status badge (dynamic)
                    // Status badge (dynamic)
                    const statusEl = statusModal.querySelector('.modal-detail-item .status-badge');
                    if (statusEl) {
                        let statusHTML = '';

                        switch (applyStatus.toLowerCase()) {
                            case 'pending':
                                statusHTML = `<span class="status-badge status-pending">
                            <i class="fas fa-clock"></i> Pending
                          </span>`;
                                break;
                            case 'being_reviewed':
                                statusHTML = `<span class="status-badge status-reviewed">
                            <i class="fas fa-file-alt"></i> Being Reviewed
                          </span>`;
                                break;
                            case 'interview':
                                statusHTML = `<span class="status-badge status-interview">
                            <i class="fas fa-chart-line"></i> Interview
                          </span>`;
                                break;
                            case 'approved':
                                statusHTML = `<span class="status-badge status-approved">
                            <i class="fas fa-check-circle"></i> Approved
                          </span>`;
                                break;
                            case 'rejected':
                                statusHTML = `<span class="status-badge status-rejected">
                            <i class="fas fa-times-circle"></i> Rejected
                          </span>`;
                                break;
                            default:
                                statusHTML = `<span class="status-badge status-unknown">
                            <i class="fas fa-question-circle"></i> ${applyStatus}
                          </span>`;
                                break;
                        }

                        statusEl.outerHTML = statusHTML; // replace the whole badge content
                    }


                    // Requirements
                    const reqContainer = document.getElementById(
                        'modal-job-additional-requirements-application');
                    if (reqContainer) {
                        reqContainer.innerHTML = requirements !== 'N/A' ?
                            `<ul><li>${requirements.replace(/,/g, '</li><li>')}</li></ul>` :
                            '<span>No additional requirements</span>';
                    }

                    // Benefits
                    // Benefits
                    const benefitList = document.getElementById('modal-job-benefits-application');
                    benefitList.innerHTML = "";

                    if (jobBenefits && jobBenefits !== "N/A") {
                        try {
                            // Try parse as JSON array
                            const parsed = JSON.parse(jobBenefits);
                            if (Array.isArray(parsed)) {
                                parsed.forEach(benefit => {
                                    let li = document.createElement("li");
                                    li.textContent = benefit;
                                    benefitList.appendChild(li);
                                });
                            }
                        } catch (e) {
                            // Fallback: comma-separated string
                            jobBenefits.split(",").forEach(benefit => {
                                let li = document.createElement("li");
                                li.textContent = benefit.trim();
                                benefitList.appendChild(li);
                            });
                        }
                    } else {
                        let li = document.createElement("li");
                        li.textContent = "No benefits listed";
                        benefitList.appendChild(li);
                    }




                });
            }
        });



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
                    reqList.innerHTML = "";

                    if (jobAdditionalRequirements && jobAdditionalRequirements !== "N/A") {
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
                    benefitList.innerHTML = "";

                    if (jobBenefits && jobBenefits !== "N/A") {
                        jobBenefits.split(",").forEach(benefit => {
                            let li = document.createElement("li");
                            li.textContent = benefit.trim();
                            benefitList.appendChild(li);
                        });
                    } else {
                        let li = document.createElement("li");
                        li.textContent = "No benefits listed";
                        benefitList.appendChild(li);
                    }

                    // Update contact email
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
                    const jobId = button.getAttribute('data-job-id');
                    const jobTitle = button.getAttribute('data-job-title');
                    const companyName = button.getAttribute('data-company-name');
                    const jobLocation = button.getAttribute('data-job-location');

                    // Update modal content
                    document.getElementById('apply-job-title').textContent = jobTitle || 'Job Title';
                    document.getElementById('apply-company-name').textContent = companyName || 'Company';
                    document.getElementById('apply-job-location').textContent = jobLocation || 'Location';
                    document.getElementById('apply-job-id-input').value = jobId;

                    // Update modal title
                    document.getElementById('applyJobModalLabel').innerHTML =
                        `<i class="fas fa-paper-plane me-2"></i>Apply for ${jobTitle || 'Position'}`;
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
