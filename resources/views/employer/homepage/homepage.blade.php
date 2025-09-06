<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - MangagawangPinoy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Welcome Section -->
        <div class="welcome-header">
            <div class="welcome-title">Welcome back, {{ $retrievePersonal->first_name ?? 'Employer' }}
                {{ $retrievePersonal->last_name ?? '' }}! 👋</div>
            <div class="welcome-subtitle">Here's what's happening with your job postings today</div>
        </div>

        <!-- Dashboard Section -->
        <div class="page-section active" id="dashboard-section">
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">128</div>
                            <div class="stat-label">Total Applicants Hired</div>
                        </div>
                        <div class="stat-icon primary">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ $JobPostRetrieved->where('status_post', 'published')->count() }}
                            </div>
                            <div class="stat-label">Active Job Posts</div>
                        </div>
                        <div class="stat-icon success">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">5</div>
                            <div class="stat-label">Unread Messages</div>
                        </div>
                        <div class="stat-icon warning">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Applicants Section -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-clock"></i>
                        Recent Applicants
                    </div>
                    <div class="section-actions">
                        <button class="btn-modern btn-primary-modern">
                            <i class="fas fa-plus"></i> View All
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Applied Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="applicant-info">
                                        <div class="applicant-avatar">JD</div>
                                        <div class="applicant-details">
                                            <h6>Juan Dela Cruz</h6>
                                            <p>juan.delacruz@email.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td>Electrician</td>
                                <td><span class="status-badge status-approved">Approved</span></td>
                                <td>July 7, 2025</td>
                                <td>
                                    <button class="action-btn primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="applicant-info">
                                        <div class="applicant-avatar">AS</div>
                                        <div class="applicant-details">
                                            <h6>Ana Santos</h6>
                                            <p>ana.santos@email.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td>Cook</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>July 6, 2025</td>
                                <td>
                                    <button class="action-btn primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="applicant-info">
                                        <div class="applicant-avatar">MR</div>
                                        <div class="applicant-details">
                                            <h6>Mark Reyes</h6>
                                            <p>mark.reyes@email.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td>Construction Worker</td>
                                <td><span class="status-badge status-rejected">Rejected</span></td>
                                <td>July 5, 2025</td>
                                <td>
                                    <button class="action-btn primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Applicants Section -->
        <div class="page-section" id="applicants-section">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="mb-2 fw-bold">Applicant Management</h2>
                    <p class="text-muted mb-0">Review and manage job applications</p>
                </div>
            </div>

            <!-- Filter Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">
                                {{ isset($retrievedApplicants) ? $retrievedApplicants->count() : '0' }}</div>
                            <div class="stat-label">Total Applicants</div>
                        </div>
                        <div class="stat-icon primary">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">156</div>
                            <div class="stat-label">Pending Review</div>
                        </div>
                        <div class="stat-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">89</div>
                            <div class="stat-label">Approved</div>
                        </div>
                        <div class="stat-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applicants Table -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-users"></i>
                        All Applicants
                    </div>
                    <div class="section-actions">
                        <div class="search-input">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" placeholder="Search by name or location..."
                                id="searchApplicants">
                        </div>
                        <select class="form-select" id="positionFilter" style="width: auto;">
                            <option value="">Filter by Position</option>
                            @if (isset($retrievedApplicants))
                                @foreach ($retrievedApplicants->pluck('work_background.position')->filter()->unique() as $position)
                                    <option value="{{ $position }}">{{ $position }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table modern-table" id="applicantsTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="form-check-input"></th>
                                <th>Applicant</th>
                                <th>Position Applied</th>
                                <th>Experience</th>
                                <th>Rating</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($retrievedApplicants))
                                @foreach ($retrievedApplicants as $applicant)
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>
                                            <div class="applicant-info">
                                                <div class="applicant-avatar">
                                                    {{ strtoupper(substr($applicant->personal_info->first_name ?? 'N', 0, 1)) }}{{ strtoupper(substr($applicant->personal_info->last_name ?? 'A', 0, 1)) }}
                                                </div>
                                                <div class="applicant-details">
                                                    <h6>{{ $applicant->personal_info->first_name ?? 'N/A' }}
                                                        {{ $applicant->personal_info->last_name ?? '' }}</h6>
                                                    <p>{{ $applicant->email ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>
                                                @if (isset($applicant->work_background->position) || isset($applicant->work_background->other_position))
                                                    {{ $applicant->work_background->position ?? '' }}
                                                    {{ $applicant->work_background->other_position ?? '' }}
                                                @else
                                                    N/A
                                                @endif
                                            </strong><br>
                                            <small class="text-muted">
                                                {{ isset($applicant->work_background->employed) && $applicant->work_background->employed ? 'Employed' : 'Not Employed' }}
                                                •
                                                {{ $applicant->personal_info->city ?? '' }}
                                                {{ $applicant->personal_info->province ?? '' }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $applicant->work_background->work_duration ?? 'N/A' }}
                                                {{ $applicant->work_background->work_duration_unit ?? '' }}
                                            </span>
                                        <td>
                                            @php
                                                $averageRating = $applicant->rating ?? 0;
                                            @endphp
                                            <div class="stars d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($averageRating))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @elseif($i - $averageRating < 1)
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                                <small
                                                    class="ms-1 text-muted">{{ number_format($averageRating, 1) }}</small>
                                            </div>
                                        </td>


                                        <td>
                                            <a href="{{ route('employer.applicantsprofile.display', $applicant->id) }}"
                                                class="action-btn primary" title="View Profile">
                                                <i class="fas fa-eye"></i>
                                            </a>


                                            <button class="action-btn success" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="action-btn danger" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button class="action-btn" title="Message">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No applicants found</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (isset($retrievedApplicants) && method_exists($retrievedApplicants, 'links'))
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="text-muted">
                            Showing {{ $retrievedApplicants->firstItem() }} to {{ $retrievedApplicants->lastItem() }}
                            out of {{ $retrievedApplicants->total() }} applicants
                        </div>
                        <div>
                            {{ $retrievedApplicants->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Job Posts Section -->
        <div class="page-section" id="jobposts-section">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="mb-2 fw-bold">Job Posts Management</h2>
                    <p class="text-muted mb-0">Create and manage your job postings</p>
                </div>
                <button class="btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#newJobModal">
                    <i class="fas fa-plus"></i> Post New Job
                </button>
            </div>

            <!-- Job Stats Cards -->
            <div class="stats-grid">
                <!-- Repeat this structure for each stat -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">
                                {{ $JobPostRetrieved->where('status_post', 'published')->count() }}</div>
                            <div class="stat-label">Active Jobs</div>
                            <!-- <small class="text-success mt-1">↗ 12% this month</small> -->
                        </div>
                        <div class="stat-icon primary">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ $JobPostRetrieved->where('status_post', 'draft')->count() }}
                            </div>
                            <div class="stat-label">Draft Jobs</div>
                            <small class="text-warning mt-1">⏱ Pending review</small>
                        </div>
                        <div class="stat-icon warning">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
                <!-- <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">89</div>
                    <div class="stat-label">Expired Jobs</div>
                    <small class="text-danger mt-1">⚠ Need renewal</small>
                </div>
                <div class="stat-icon danger">
                    <i class="fas fa-calendar-times"></i>
                </div>
            </div>
        </div> -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ $retrievedApplicantApproved }}</div>
                            @if ($retrievedApplicantApproved == 1)
                                <div class="stat-label">Total Applicant Approved</div>
                            @else
                                <div class="stat-label">Total Applicants Approved</div>
                            @endif
                            {{-- <small class="text-primary mt-1"> This quarter</small> --}}
                        </div>
                        <div class="stat-icon success">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Posts Grid -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('deleted'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <i class="fas fa-trash-alt me-1"></i> {{ session('deleted') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="job-cards-grid">
                @forelse ($JobPostRetrieved as $jobDetail)
                    <div class="job-card">
                        <div class="job-card-header">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span
                                    class="status-badge {{ $jobDetail->status_post === 'published' ? 'status-active' : 'status-draft' }}">
                                    {{ ucfirst($jobDetail->status_post) }}
                                </span>

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">

                                        @if ($jobDetail->status_post !== 'draft')
                                            <li>
                                                <form
                                                    action="{{ route('employer.updatejobpost.store', ['id' => $jobDetail->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status_post" value="draft">
                                                    <button class="dropdown-item text-warning" type="submit">
                                                        <i class="fas fa-file-alt me-2"></i> Save as Draft
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        @if ($jobDetail->status_post !== 'published')
                                            <li>
                                                <form
                                                    action="{{ route('employer.updatejobpost.store', ['id' => $jobDetail->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status_post" value="published">
                                                    <button class="dropdown-item text-success" type="submit">
                                                        <i class="fas fa-bullhorn me-2"></i> Publish
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        <li>
                                            <form
                                                action="{{ route('employer.deletejobpost.store', ['id' => $jobDetail->id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this job post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">
                                                    <i class="fas fa-trash-alt me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>

                                </div>
                            </div>

                            <h5 class="job-title">{{ $jobDetail->title }}</h5>
                            <p class="mb-1 text-muted small">
                                <i class="fas fa-briefcase me-1"></i> Category: {{ $jobDetail->department }}
                            </p>
                            <div class="job-meta">
                                <span><i class="fas fa-map-marker-alt me-1"></i> {{ $jobDetail->location }}</span>
                                <span><i class="fas fa-clock me-1"></i> {{ $jobDetail->job_type }}</span>
                                <span><i class="fas fa-peso-sign me-1"></i> ₱{{ $jobDetail->job_salary ?? 'N/A' }} /
                                    month</span>
                            </div>
                        </div>

                        <div class="job-body">
                            <p class="job-description">
                                {{ Str::limit($jobDetail->job_description, 150) }}
                            </p>

                            <div class="requirement-tags">
                                <span class="requirement-tag">{{ $jobDetail->experience_level }}</span>
                                @if ($jobDetail->tesda_certification)
                                    <span class="requirement-tag">TESDA: {{ $jobDetail->tesda_certification }}</span>
                                @elseif($jobDetail->none_certifications_qualification)
                                    <span class="requirement-tag">Other Cert:
                                        {{ $jobDetail->none_certifications_qualification }}</span>
                                @endif
                            </div>

                            <div class="job-stats mt-3">
                                <div class="job-stat">
                                    <strong>{{ $jobDetail->applications->count() }}</strong>
                                    <small>Applications</small>
                                </div>
                                <div class="job-stat">
                                    <strong>12</strong>
                                    <small>Shortlisted</small>
                                </div>
                                <div class="job-stat">
                                    <strong>3</strong>
                                    <small>Hired</small>
                                </div>
                            </div>

                            {{-- Button to open modal --}}
                            {{-- Button to open modal --}}
                            <button class="btn btn-outline-primary w-100 mt-3" data-bs-toggle="modal"
                                data-bs-target="#applicationsModal-{{ $jobDetail->id }}">
                                <i class="fas fa-users me-2"></i> View Applications
                                {{ $jobDetail->applications->count() }}

                            </button>

                            <small class="text-muted d-block mt-2">Posted
                                {{ $jobDetail->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Balanced Theme Professional Job Applications Modal -->
                    <div class="modal fade balanced-modal" id="applicationsModal-{{ $jobDetail->id }}"
                        tabindex="-1" aria-labelledby="applicationsModalLabel-{{ $jobDetail->id }}"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content bg-balanced border-0 shadow-lg">
                                <!-- Professional Header -->
                                <div class="modal-header bg-gradient-balanced text-white border-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-users-cog fa-lg text-accent-blue"></i>
                                        </div>
                                        <div>
                                            <h5 class="modal-title mb-0 text-white"
                                                id="applicationsModalLabel-{{ $jobDetail->id }}">
                                                Job Applications
                                            </h5>
                                            <small
                                                class="text-balanced-light opacity-90">{{ $jobDetail->title }}</small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body p-0 bg-balanced-secondary">
                                    <!-- Statistics Dashboard -->
                                    <div
                                        class="stats-dashboard p-3 bg-balanced-tertiary border-bottom border-balanced">
                                        <div class="row g-2">
                                            <div class="col-6 col-md-3">
                                                <div
                                                    class="stat-card bg-balanced-card p-3 rounded shadow-sm border-start border-4 border-accent-blue">
                                                    <div class="d-flex d-md-block text-center text-md-start">
                                                        <div class="me-2 me-md-0 mb-md-1">
                                                            <i class="fas fa-users text-accent-blue"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold text-accent-blue">
                                                                {{ $jobDetail->applications->count() }}</h6>
                                                            <small class="text-balanced-muted">Total</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div
                                                    class="stat-card bg-balanced-card p-3 rounded shadow-sm border-start border-4 border-accent-orange">
                                                    <div class="d-flex d-md-block text-center text-md-start">
                                                        <div class="me-2 me-md-0 mb-md-1">
                                                            <i class="fas fa-clock text-accent-orange"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold text-accent-orange">
                                                                {{ $jobDetail->applications->where('status', 'pending')->count() }}
                                                            </h6>
                                                            <small class="text-balanced-muted">Pending</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div
                                                    class="stat-card bg-balanced-card p-3 rounded shadow-sm border-start border-4 border-accent-purple">
                                                    <div class="d-flex d-md-block text-center text-md-start">
                                                        <div class="me-2 me-md-0 mb-md-1">
                                                            <i class="fas fa-eye text-accent-purple"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold text-accent-purple">
                                                                {{ $jobDetail->applications->where('status', 'reviewed')->count() }}
                                                            </h6>
                                                            <small class="text-balanced-muted">Reviewed</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div
                                                    class="stat-card bg-balanced-card p-3 rounded shadow-sm border-start border-4 border-accent-green">
                                                    <div class="d-flex d-md-block text-center text-md-start">
                                                        <div class="me-2 me-md-0 mb-md-1">
                                                            <i class="fas fa-check-circle text-accent-green"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold text-accent-green">
                                                                {{ $jobDetail->applications->where('status', 'approved')->count() }}
                                                            </h6>
                                                            <small class="text-balanced-muted">Approved</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Applications List -->
                                    <div class="applications-section p-3">
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
                                            <h6 class="mb-0 text-balanced-dark fw-semibold">
                                                <i class="fas fa-list me-2 text-accent-blue"></i>
                                                Applications
                                            </h6>
                                            <select
                                                class="form-select form-select-sm bg-balanced-card text-balanced-dark border-balanced-light"
                                                style="max-width: 200px;">
                                                <option>All Status</option>
                                                <option>Pending</option>
                                                <option>Reviewed</option>
                                                <option>Approved</option>
                                                <option>Rejected</option>
                                            </select>
                                        </div>

                                        <div class="applications-list">
                                            @forelse ($jobDetail->applications as $application)
                                                <div class="application-item mb-3 bg-balanced-card rounded shadow-sm border border-balanced-light"
                                                    id="application-{{ $application->id }}">
                                                    <!-- Candidate Info Header -->
                                                    <div class="p-3 border-bottom border-balanced">
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-12 col-sm-8">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="candidate-avatar me-3 flex-shrink-0">
                                                                        <div class="bg-gradient-accent text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                                            style="width: 45px; height: 45px; font-size: 14px; font-weight: 600;">
                                                                            {{ strtoupper(substr($application->applicant->personal_info->first_name ?? 'N', 0, 1)) }}{{ strtoupper(substr($application->applicant->personal_info->last_name ?? 'A', 0, 1)) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="candidate-details min-w-0 flex-grow-1">
                                                                        <h6
                                                                            class="mb-1 fw-bold text-truncate text-balanced-dark">
                                                                            {{ $application->applicant->personal_info->first_name ?? 'No name' }}
                                                                            {{ $application->applicant->personal_info->last_name ?? '' }}
                                                                        </h6>
                                                                        <div class="text-balanced-muted small">
                                                                            <div class="mb-1">
                                                                                <i
                                                                                    class="fas fa-envelope me-1 text-accent-blue"></i>
                                                                                <span
                                                                                    class="text-truncate d-inline-block"
                                                                                    style="max-width: 200px;">{{ $application->applicant->email ?? 'No email' }}</span>
                                                                            </div>
                                                                            <div class="d-none d-sm-block">
                                                                                <i
                                                                                    class="fas fa-phone me-1 text-accent-blue"></i>
                                                                                {{ $application->cellphone_number ?? 'No phone' }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-4 text-start text-sm-end">
                                                                <div
                                                                    class="d-flex flex-column align-items-start align-items-sm-end gap-1">
                                                                    <span
                                                                        class="badge fw-medium px-3 py-1 rounded-pill shadow-sm
                                @if ($application->status == 'approved') bg-success-balanced text-white
                                @elseif($application->status == 'rejected') bg-danger-balanced text-white
                                @elseif($application->status == 'interview') bg-info-balanced text-white
                                @else bg-warning-balanced text-dark @endif">
                                                                        <i class="fas fa-circle me-1"
                                                                            style="font-size: 6px;"></i>
                                                                        {{ ucfirst($application->status ?? 'Pending') }}
                                                                    </span>
                                                                    <small class="text-balanced-muted">
                                                                        {{ $application->created_at->diffForHumans() }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Application Details -->
                                                    <div class="p-3">
                                                        <div class="row g-3">
                                                            <div class="col-12 col-lg-6">
                                                                <div class="content-section">
                                                                    <h6 class="text-accent-blue mb-2 fw-semibold">
                                                                        <i class="fas fa-file-alt me-1"></i> Cover
                                                                        Letter
                                                                    </h6>
                                                                    <div
                                                                        class="bg-balanced-tertiary p-3 rounded border-start border-3 border-accent-blue">
                                                                        <p
                                                                            class="mb-0 text-balanced-dark small lh-base">
                                                                            {{ Str::limit($application->cover_letter ?? 'No cover letter provided.', 100) }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="content-section">
                                                                    <h6 class="text-accent-purple mb-2 fw-semibold">
                                                                        <i class="fas fa-info-circle me-1"></i>
                                                                        Additional Info
                                                                    </h6>
                                                                    <div
                                                                        class="bg-balanced-tertiary p-3 rounded border-start border-3 border-accent-purple">
                                                                        <p
                                                                            class="mb-0 text-balanced-dark small lh-base">
                                                                            {{ Str::limit($application->additional_information ?? 'No additional information provided.', 100) }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Actions Footer -->
                                                    <div class="p-3 border-top border-balanced bg-balanced-tertiary">
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-12 col-md-6">
                                                                <div class="d-flex flex-wrap gap-2">
                                                                    @if ($application->resume)
                                                                        <a href="{{ asset('storage/' . $application->resume) }}"
                                                                            target="_blank"
                                                                            class="btn btn-outline-balanced btn-sm text-accent-blue border-accent-blue">
                                                                            <i class="fas fa-file-pdf me-1"></i>
                                                                            <span class="d-none d-sm-inline">View
                                                                            </span>Resume
                                                                        </a>
                                                                    @else
                                                                        <button
                                                                            class="btn btn-outline-muted-balanced btn-sm text-balanced-muted"
                                                                            disabled>
                                                                            <i class="fas fa-file-times me-1"></i>
                                                                            No Resume
                                                                        </button>
                                                                    @endif

                                                                    @if ($application->tesda_certification)
                                                                        <a href="{{ asset('storage/' . $application->tesda_certification) }}"
                                                                            target="_blank"
                                                                            class="btn btn-outline-balanced btn-sm text-accent-orange border-accent-orange">
                                                                            <i class="fas fa-certificate me-1"></i>
                                                                            <span
                                                                                class="d-none d-sm-inline">TESDA</span>
                                                                        </a>
                                                                    @else
                                                                        <button
                                                                            class="btn btn-outline-muted-balanced btn-sm text-balanced-muted"
                                                                            disabled>
                                                                            <i class="fas fa-certificate me-1"></i>
                                                                            No TESDA
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div
                                                                    class="d-flex justify-content-start justify-content-md-end gap-1 flex-wrap">
                                                                    <!-- Approve Button -->
                                                                    <form
                                                                        action="{{ route('employer.approveapplicant.store', $application->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit"
                                                                            class="btn btn-success-balanced btn-sm text-white shadow-sm">
                                                                            <i class="fas fa-check me-1"></i>
                                                                            <span
                                                                                class="d-none d-sm-inline">Approve</span>
                                                                        </button>
                                                                    </form>
                                                                    <button
                                                                        class="btn btn-info-balanced btn-sm text-white shadow-sm">
                                                                        <i class="fas fa-calendar me-1"></i>
                                                                        <span
                                                                            class="d-none d-sm-inline">Interview</span>
                                                                    </button>

                                                                    <!-- Modified Reject Button with JavaScript -->
                                                                    <form
                                                                        action="{{ route('employer.rejectapplicant.store', $application->id) }}"
                                                                        method="POST" class="d-inline reject-form">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit"
                                                                            class="btn btn-outline-balanced btn-sm text-accent-red border-accent-red reject-btn"
                                                                            data-application-id="{{ $application->id }}">
                                                                            <i class="fas fa-times me-1"></i>
                                                                            <span
                                                                                class="d-none d-sm-inline">Reject</span>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-5" id="no-applications">
                                                    <div class="mb-3">
                                                        <i
                                                            class="fas fa-inbox fa-3x text-balanced-muted opacity-50"></i>
                                                    </div>
                                                    <h6 class="text-balanced-muted mb-2">No Applications Yet</h6>
                                                    <p class="text-balanced-muted small">Applications will appear here
                                                        when candidates apply.</p>
                                                </div>
                                            @endforelse
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Handle reject button clicks
                                                document.querySelectorAll('.reject-form').forEach(form => {
                                                    form.addEventListener('submit', function(e) {
                                                        e.preventDefault(); // Prevent default form submission

                                                        const applicationId = this.querySelector('.reject-btn').dataset.applicationId;
                                                        const applicationElement = document.getElementById(
                                                            `application-${applicationId}`);

                                                        // Show confirmation dialog
                                                        if (confirm('Are you sure you want to reject this application?')) {
                                                            // Add fade out animation
                                                            applicationElement.style.transition =
                                                                'opacity 0.5s ease-out, transform 0.5s ease-out';
                                                            applicationElement.style.opacity = '0';
                                                            applicationElement.style.transform = 'translateX(-20px)';

                                                            // Submit the form via AJAX
                                                            const formData = new FormData(this);

                                                            fetch(this.action, {
                                                                    method: 'POST',
                                                                    body: formData,
                                                                    headers: {
                                                                        'X-Requested-With': 'XMLHttpRequest'
                                                                    }
                                                                })
                                                                .then(response => {
                                                                    if (response.ok) {
                                                                        // Remove element after animation completes
                                                                        setTimeout(() => {
                                                                            applicationElement.remove();

                                                                            // Check if no applications left, show empty state
                                                                            const remainingApplications = document
                                                                                .querySelectorAll('.application-item');
                                                                            if (remainingApplications.length === 0) {
                                                                                document.querySelector('.applications-list')
                                                                                    .innerHTML = `
                                    <div class="text-center py-5" id="no-applications">
                                        <div class="mb-3">
                                            <i class="fas fa-inbox fa-3x text-balanced-muted opacity-50"></i>
                                        </div>
                                        <h6 class="text-balanced-muted mb-2">No Applications Yet</h6>
                                        <p class="text-balanced-muted small">Applications will appear here when candidates apply.</p>
                                    </div>
                                `;
                                                                            }
                                                                        }, 500);

                                                                        // Show success message (optional)
                                                                        showNotification('Application rejected successfully',
                                                                            'success');
                                                                    } else {
                                                                        // Revert animation if request failed
                                                                        applicationElement.style.opacity = '1';
                                                                        applicationElement.style.transform = 'translateX(0)';
                                                                        showNotification('Failed to reject application', 'error');
                                                                    }
                                                                })
                                                                .catch(error => {
                                                                    // Revert animation if request failed
                                                                    applicationElement.style.opacity = '1';
                                                                    applicationElement.style.transform = 'translateX(0)';
                                                                    showNotification('An error occurred', 'error');
                                                                });
                                                        }
                                                    });
                                                });
                                            });

                                            // Optional: Simple notification function
                                            function showNotification(message, type = 'info') {
                                                // Create notification element
                                                const notification = document.createElement('div');
                                                notification.className =
                                                    `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
                                                notification.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 300px;';
                                                notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

                                                document.body.appendChild(notification);

                                                // Auto remove after 3 seconds
                                                setTimeout(() => {
                                                    if (notification.parentNode) {
                                                        notification.remove();
                                                    }
                                                }, 3000);
                                            }
                                        </script>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="modal-footer bg-balanced-tertiary border-top border-balanced p-3">
                                    <div
                                        class="d-flex flex-column flex-sm-row justify-content-between align-items-center w-100 gap-2">
                                        <small class="text-balanced-muted order-2 order-sm-1">
                                            <i class="fas fa-clock me-1"></i>
                                            Updated {{ now()->format('M d, Y') }}
                                        </small>
                                        <div class="order-1 order-sm-2 d-flex gap-2">
                                            <button
                                                class="btn btn-outline-balanced btn-sm text-balanced-dark border-balanced-light"
                                                data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>
                                                Close
                                            </button>
                                            <button class="btn btn-accent-balanced btn-sm text-white shadow-sm"
                                                onclick="exportApplications()">
                                                <i class="fas fa-download me-1"></i>
                                                Export
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                @empty
                    <p class="text-muted">No job posts available.</p>
                @endforelse
            </div>
        </div>


        <!-- Messages Section -->
        <div class="page-section" id="messages-section">
            <div class="content-section">
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                    <h3 class="mb-2">Messages</h3>
                    <p class="text-muted">Message management will appear here...</p>
                </div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="page-section" id="analytics-section">
            <div class="content-section">
                <div class="text-center py-5">
                    <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                    <h3 class="mb-2">Analytics</h3>
                    <p class="text-muted">Analytics dashboard will appear here...</p>
                </div>
            </div>
        </div>

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
                                    <label for="additionalRequirements" class="form-label">Additional Requirements or
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
        const applicantRows = document.querySelectorAll('#applicantsTable tbody tr');

        function filterApplicants() {
            const searchValue = searchInput ? searchInput.value.toLowerCase() : '';
            const selectedPosition = positionFilter ? positionFilter.value : '';

            applicantRows.forEach(row => {
                const nameCell = row.querySelector('.applicant-details h6');
                const positionCell = row.querySelector('td:nth-child(3) strong');
                const locationCell = row.querySelector('td:nth-child(3) small');

                const name = nameCell ? nameCell.textContent.toLowerCase() : '';
                const position = positionCell ? positionCell.textContent.trim() : '';
                const location = locationCell ? locationCell.textContent.toLowerCase() : '';

                const matchesSearch = name.includes(searchValue) || location.includes(searchValue);
                const matchesPosition = !selectedPosition || position === selectedPosition;

                row.style.display = (matchesSearch && matchesPosition) ? '' : 'none';
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterApplicants);
        }
        if (positionFilter) {
            positionFilter.addEventListener('change', filterApplicants);
        }

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


</body>

</html>
