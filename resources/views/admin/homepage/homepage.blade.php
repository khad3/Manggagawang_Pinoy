<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESDA Super Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- fav icon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/admin/homepage.css') }}">



</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="logo">TESDA</div>
                <h2>TESDA Admin</h2>
                <p>Super Administrator</p>
            </div>
            <div class="sidebar-menu">
                <button class="menu-item active" onclick="showSection('dashboard', this)">
                    <i class="fas fa-chart-bar"></i>
                    <span>Dashboard</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <button class="menu-item" onclick="showSection('officers', this)">
                    <i class="fas fa-user-tie"></i>
                    <span>Officers Management</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <button class="menu-item" onclick="showSection('announcements', this)">
                    <i class="fas fa-bullhorn"></i>
                    <span>Announcements</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <button class="menu-item" onclick="showSection('reports', this)">
                    <i class="fas fa-chart-line"></i>
                    <span>Reports & Analytics</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <!-- <button class="menu-item" onclick="showSection('certificates', this)">
                    <i class="fas fa-certificate"></i>
                    <span>Certificates</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button> -->
                <button class="menu-item" onclick="showSection('users', this)">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <button class="menu-item" onclick="showSection('settings', this)">
                    <i class="fas fa-cog"></i>
                    <span>System Settings</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>

                <button class="menu-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
            </div>
        </nav>


        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer"></div>

            <!-- Header -->
            <!-- Officers Management Section -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="header-bar">
                <div>
                    <h1>TESDA Super Admin Dashboard</h1>
                    <p class="subtitle">Welcome back, {{ $retrievePersonal->name ?? 'Admin' }}</p>
                </div>
                <div class="admin-info">
                    <div class="admin-details">
                        <div class="admin-name">Admin User</div>
                        @php
                            use Carbon\Carbon;
                        @endphp

                        <div class="admin-last-login">
                            Last
                            login:{{ $last_login ? Carbon::parse($last_login)->format('F j, Y - g:i A') : 'No record' }}
                        </div>

                    </div>
                    <div class="admin-avatar">SA</div>
                </div>
            </div>

            <!-- Dashboard Section -->
            <section id="dashboard" class="content-section active">
                <div class="stats-grid">
                    <div class="stat-card users">
                        <div class="stat-card-content">
                            <div class="stat-info">
                                <h3 id="totalUsers">{{ $totalUsers ?? 0 }}</h3>
                                <p>Total Users</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="stat-change">
                            <i class="fas fa-trending-up"></i>
                            {{ round($percentageGrowth, 1) }}% this month
                        </div>
                    </div>

                    <div class="stat-card employers">
                        <div class="stat-card-content">
                            <div class="stat-info">
                                <h3 id="totalEmployers">{{ $employerCount ?? 0 }}</h3>
                                <p>Employers</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <div class="stat-change {{ $employersTrendingUp ? 'text-success' : 'text-danger' }}">
                            <i class="fas {{ $employersTrendingUp ? 'fa-trending-up' : 'fa-trending-down' }}"></i>
                            {{ $employersTrendingUp ? '+' : '-' }}{{ number_format(abs($employerChange), 1) }}% this
                            month
                        </div>
                    </div>

                    <div class="stat-card applicants">
                        <div class="stat-card-content">
                            <div class="stat-info">
                                <h3 id="totalApplicants">{{ $applicantsCount }}</h3>
                                <p>Job Applicants</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                        <div class="stat-change {{ $isTrendingUp ? 'text-success' : 'text-danger' }}">
                            <i class="fas {{ $isTrendingUp ? 'fa-trending-up' : 'fa-trending-down' }}"></i>
                            {{ $isTrendingUp ? '+' : '-' }}{{ number_format(abs($change), 1) }}% this month
                        </div>

                    </div>

                    <div class="stat-card certificates">
                        <div class="stat-card-content">
                            <div class="stat-info">
                                <h3 id="totalCertificates">8,945</h3>
                                <p>Certificates Issued</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                        </div>
                        <div class="stat-change">
                            <i class="fas fa-trending-up"></i>
                            +22% this month
                        </div>
                    </div>

                    <div class="stat-card officers">
                        <div class="stat-card-content">
                            <div class="stat-info">
                                <h3 id="totalOfficers">{{ $tesdaOfficersCount ?? 0 }}</h3>
                                <p>TESDA Officers</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="stat-change">
                            <i class="fas fa-trending-up"></i>
                            +{{ $newTesdaOfficers ?? 0 }} new
                        </div>
                    </div>

                    <div class="stat-card announcements">
                        <div class="stat-card-content">
                            <div class="stat-info">
                                <h3 id="totalAnnouncements">{{ $retrieveAnnouncementsTotal }}</h3>
                                <p>Announcements</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                        </div>
                        <div class="stat-change">
                            <i class="fas fa-trending-up"></i>
                            {{ $weeklyAnnouncements }}+ this week
                        </div>
                    </div>
                </div>

                <div class="chart-container">
                    <h3 class="chart-title">User Registration Trends</h3>
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-line"></i>
                        <p>Chart visualization will be displayed here</p>
                    </div>
                </div>
            </section>

            <!-- Officers Management Section -->

            <section id="officers" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-user-tie"></i>
                        Officers Management
                    </h2>
                    <button class="btn btn-primary" onclick="openAddOfficerModal()">
                        <i class="fas fa-plus"></i>
                        Add New Officer
                    </button>
                </div>

                <div id="officersList">
                    @foreach ($retrieveTesdaOfficers as $officer)
                        <div class="card officer-card mb-3 p-3 shadow-sm">
                            <div class="officer-info d-flex align-items-center">
                                <div class="officer-avatar rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center"
                                    style="width:50px; height:50px; font-size:18px;">
                                    {{ strtoupper(substr($officer->first_name, 0, 1)) }}{{ strtoupper(substr($officer->last_name, 0, 1)) }}
                                </div>
                                <div class="officer-details ms-3">
                                    <h5 class="mb-1">{{ $officer->first_name }} {{ $officer->last_name }}</h5>
                                    <p class="email text-muted mb-0">
                                        <i class="fas fa-envelope"></i> {{ $officer->email }}
                                    </p>
                                </div>
                            </div>

                            <div class="officer-actions mt-3 d-flex justify-content-between align-items-center">
                                <span
                                    class="badge {{ $officer->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ ucfirst($officer->status) }}
                                </span>
                                <div class="action-buttons">
                                    <!-- Edit Button opens modal -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editOfficerModal{{ $officer->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.deleteofficer', ['id' => $officer->id]) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this officer?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="editOfficerModal{{ $officer->id }}" tabindex="-1"
                            aria-labelledby="editOfficerModalLabel{{ $officer->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered d-flex justify-content-center">
                                <div class="modal-content custom-modal mx-auto">

                                    <form action="{{ route('admin.updateofficer', ['id' => $officer->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')

                                        <!-- Header -->
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-dark"
                                                id="editOfficerModalLabel{{ $officer->id }}">
                                                <i class="fas fa-user-edit me-2 text-primary"></i> Edit Officer
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <!-- Body -->
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" name="first_name"
                                                        value="{{ $officer->first_name }}" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" name="last_name"
                                                        value="{{ $officer->last_name }}" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email"
                                                        value="{{ $officer->email }}" class="form-control" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">password</label>
                                                    <input type="password" id="password" name="password"
                                                        value="{{ $officer->password }}" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="active"
                                                            {{ $officer->status == 'active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="inactive"
                                                            {{ $officer->status == 'inactive' ? 'selected' : '' }}>
                                                            Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fas fa-save me-1"></i> Save Changes
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </section>

            <!-- Announcements Section -->
            <section id="announcements" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-bullhorn"></i>
                        Announcements Management
                    </h2>
                    <button class="btn btn-primary" onclick="openAddAnnouncementModal()">
                        <i class="fas fa-plus"></i>
                        Create Announcement
                    </button>
                </div>

                <div class="section-content">
                    <div class="announcements-container">
                        <!-- Filter and Search Controls -->
                        <div class="announcements-header">
                            <div class="announcements-controls">
                                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                                    <div class="filter-group">
                                        <label for="priorityFilter">Priority:</label>
                                        <select id="priorityFilter" class="filter-select">
                                            <option value="">All Priorities</option>
                                            <option value="urgent">Urgent</option>
                                            <option value="high">High</option>
                                            <option value="medium">Medium</option>
                                            <option value="low">Low</option>
                                        </select>
                                    </div>

                                    <div class="filter-group">
                                        <label for="statusFilter">Status:</label>
                                        <select id="statusFilter" class="filter-select">
                                            <option value="">All Status</option>
                                            <option value="published">Published</option>
                                            <option value="draft">Draft</option>
                                            <option value="archived">Archived</option>
                                        </select>
                                    </div>

                                    <div class="filter-group">
                                        <label for="searchFilter">Search:</label>
                                        <input type="text" id="searchFilter" class="search-input"
                                            placeholder="Search announcements...">
                                    </div>
                                </div>

                                <div class="announcements-stats">
                                    <div class="stat-badge">
                                        <i class="fas fa-list"></i>
                                        <span id="totalCount">{{ count($retrieveAnnouncements) }}</span> Total
                                    </div>
                                    <div class="stat-badge">
                                        <i class="fas fa-eye"></i>
                                        <span id="publishedCount">{{ $publishedAnnouncementTotal }}</span>
                                        Published
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Announcements List -->
                        <div class="announcements-grid">
                            <!-- Announcements -->
                            @if (isset($retrieveAnnouncements) && count($retrieveAnnouncements) > 0)
                                @foreach ($retrieveAnnouncements as $announcement)
                                    <div class="announcement-item" data-priority="{{ $announcement->priority }}"
                                        data-status="{{ $announcement->status }}">

                                        <div class="announcement-header">
                                            <div class="announcement-badges">
                                                <span class="priority-badge priority-{{ $announcement->priority }}">
                                                    {{ ucfirst($announcement->priority) }}
                                                </span>
                                                <span class="status-badge status-{{ $announcement->status }}">
                                                    {{ ucfirst($announcement->status) }}
                                                </span>
                                            </div>
                                            <div class="announcement-actions">
                                                <button class="action-btn btn-view" title="View Details"
                                                    data-bs-toggle="modal" data-bs-target="#viewAnnouncementModal">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="action-btn btn-edit" title="Edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editAnnouncementModal-{{ $announcement->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <form
                                                    action="{{ route('admin.delete-announcement.destroy', $announcement->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn btn-delete"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this announcement?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <h3 class="announcement-title">{{ $announcement->title }}</h3>
                                        <p class="announcement-content">
                                            {{ $announcement->content }}
                                        </p>

                                        {{-- Show image only if not null --}}
                                        @if ($announcement->image)
                                            <img src="{{ asset('storage/' . $announcement->image) }}"
                                                alt="Announcement Image"
                                                style="width:100%; border-radius:8px; margin-bottom:10px;">
                                        @endif

                                        <div class="tags-container">
                                            @if ($announcement->tag)
                                                @php
                                                    $tags = explode(',', $announcement->tag);
                                                @endphp
                                                @foreach ($tags as $tag)
                                                    <span class="tag">#{{ trim($tag) }}</span>
                                                @endforeach
                                            @endif
                                        </div>

                                        <div class="announcement-meta">
                                            <div class="meta-info">
                                                <div class="meta-item">
                                                    <i class="fas fa-user"></i>
                                                    <span>Admin User</span>
                                                </div>

                                                {{-- Created date --}}
                                                <div class="meta-item">
                                                    <i class="fas fa-calendar-plus"></i>
                                                    <span>
                                                        Created on
                                                        ({{ $announcement->created_at->diffForHumans() }})
                                                    </span>
                                                </div>

                                                {{-- Publication date if exists --}}
                                                @if ($announcement->publication_date)
                                                    <div class="meta-item">
                                                        <i class="fas fa-calendar-check"></i>
                                                        <span>
                                                            Published on
                                                            {{ \Carbon\Carbon::parse($announcement->publication_date)->format('F j, Y \a\t g:i A') }}
                                                            ({{ \Carbon\Carbon::parse($announcement->publication_date)->diffForHumans() }})
                                                        </span>
                                                    </div>
                                                @endif

                                                <div class="meta-item">
                                                    <i class="fas fa-users"></i>
                                                    <span>{{ ucfirst($announcement->target_audience) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>


                        @foreach ($retrieveAnnouncements as $announcement)
                            <!-- Edit Announcement Modal -->
                            <div class="modal fade" id="editAnnouncementModal-{{ $announcement->id }}"
                                tabindex="-1" aria-labelledby="editAnnouncementModalLabel-{{ $announcement->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.update-announcement', $announcement->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="editAnnouncementModalLabel-{{ $announcement->id }}">
                                                    <i class="fas fa-edit me-2"></i>Edit Announcement
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" name="title" class="form-control"
                                                        value="{{ $announcement->title }}" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Content</label>
                                                    <textarea name="content" class="form-control" rows="4" required>{{ $announcement->content }}</textarea>
                                                </div>

                                                {{-- Show current image --}}
                                                @if ($announcement->image)
                                                    <div class="mb-3">
                                                        <label class="form-label d-block">Current Image</label>
                                                        <img src="{{ asset('storage/' . $announcement->image) }}"
                                                            alt="Announcement Image"
                                                            style="width: 150px; border-radius: 8px; margin-bottom:10px;">
                                                    </div>
                                                @endif

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Upload New Image</label>
                                                    <input type="file" name="image" class="form-control">
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Priority</label>
                                                        <select name="priority" class="form-select" required>
                                                            <option value="low"
                                                                {{ $announcement->priority == 'low' ? 'selected' : '' }}>
                                                                Low</option>
                                                            <option value="medium"
                                                                {{ $announcement->priority == 'medium' ? 'selected' : '' }}>
                                                                Medium</option>
                                                            <option value="high"
                                                                {{ $announcement->priority == 'high' ? 'selected' : '' }}>
                                                                High</option>
                                                            <option value="urgent"
                                                                {{ $announcement->priority == 'urgent' ? 'selected' : '' }}>
                                                                Urgent</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Target Audience</label>
                                                        <select name="target_audience" class="form-select" required>
                                                            <option value="all"
                                                                {{ $announcement->target_audience == 'all' ? 'selected' : '' }}>
                                                                All</option>
                                                            <option value="applicants"
                                                                {{ $announcement->target_audience == 'applicants' ? 'selected' : '' }}>
                                                                Applicants</option>
                                                            <option value="employers"
                                                                {{ $announcement->target_audience == 'employers' ? 'selected' : '' }}>
                                                                Employers</option>
                                                            <option value="tesda_officers"
                                                                {{ $announcement->target_audience == 'tesda_officers' ? 'selected' : '' }}>
                                                                TESDA Officers</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Publication Date</label>
                                                    <input type="datetime-local" name="publication_date"
                                                        class="form-control"
                                                        value="{{ $announcement->publication_date ? \Carbon\Carbon::parse($announcement->publication_date)->format('Y-m-d\TH:i') : '' }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="draft"
                                                            {{ $announcement->status == 'draft' ? 'selected' : '' }}>
                                                            Draft</option>
                                                        <option value="published"
                                                            {{ $announcement->status == 'published' ? 'selected' : '' }}>
                                                            Published</option>
                                                        <option value="scheduled"
                                                            {{ $announcement->status == 'scheduled' ? 'selected' : '' }}>
                                                            Scheduled</option>
                                                        <option value="archived"
                                                            {{ $announcement->status == 'archived' ? 'selected' : '' }}>
                                                            Archived</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tags (optional)</label>
                                                    <input type="text" name="tags" class="form-control"
                                                        value="{{ $announcement->tag }}">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <!-- View Announcement Modal -->
                        <div class="modal fade" id="viewAnnouncementModal" tabindex="-1"
                            aria-labelledby="viewAnnouncementModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewAnnouncementModalLabel">
                                            <i class="fas fa-bullhorn me-2"></i> Announcement Details
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="announcement-details">
                                            <h3 id="modalAnnouncementTitle">New Training Facilities Opening</h3>
                                            <p id="modalAnnouncementContent">
                                                We are excited to announce the opening of three new TESDA training
                                                facilities in
                                                Metro Manila. These facilities will offer expanded course offerings and
                                                state-of-the-art equipment for hands-on learning. Grand opening ceremony
                                                scheduled
                                                for February 2025.
                                            </p>

                                            <div class="tags-container" id="modalAnnouncementTags">
                                                <span class="tag">#facilities</span>
                                                <span class="tag">#training</span>
                                                <span class="tag">#expansion</span>
                                                <span class="tag">#manila</span>
                                            </div>

                                            <div class="announcement-meta mt-3">
                                                <div class="meta-item">
                                                    <i class="fas fa-user"></i> <span
                                                        id="modalAnnouncementAuthor">Admin User</span>
                                                </div>
                                                <div class="meta-item">
                                                    <i class="fas fa-calendar"></i> <span
                                                        id="modalAnnouncementDate">Jan 20, 2025</span>
                                                </div>
                                                <div class="meta-item">
                                                    <i class="fas fa-users"></i> <span
                                                        id="modalAnnouncementAudience">All Users</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <script>
                        document.querySelectorAll('.btn-view').forEach(button => {
                            button.addEventListener('click', function() {
                                let parent = this.closest('.announcement-item');

                                document.getElementById('modalAnnouncementTitle').textContent = parent.querySelector(
                                    '.announcement-title').textContent;
                                document.getElementById('modalAnnouncementContent').textContent = parent.querySelector(
                                    '.announcement-content').textContent;
                                document.getElementById('modalAnnouncementAuthor').textContent = parent.querySelector(
                                    '.meta-item:nth-child(1) span').textContent;
                                document.getElementById('modalAnnouncementDate').textContent = parent.querySelector(
                                    '.meta-item:nth-child(2) span').textContent;
                                document.getElementById('modalAnnouncementAudience').textContent = parent.querySelector(
                                    '.meta-item:nth-child(3) span').textContent;

                                // For tags
                                document.getElementById('modalAnnouncementTags').innerHTML = parent.querySelector(
                                    '.tags-container').innerHTML;
                            });
                        });

                        // Filter functionality
                        function filterAnnouncements() {
                            const priorityFilter = document.getElementById('priorityFilter').value;
                            const statusFilter = document.getElementById('statusFilter').value;
                            const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
                            const announcements = document.querySelectorAll('.announcement-item');

                            let visibleCount = 0;
                            let publishedCount = 0;

                            announcements.forEach(announcement => {
                                const priority = announcement.dataset.priority;
                                const status = announcement.dataset.status;
                                const title = announcement.querySelector('.announcement-title').textContent.toLowerCase();
                                const content = announcement.querySelector('.announcement-content').textContent.toLowerCase();
                                const tags = Array.from(announcement.querySelectorAll('.tag')).map(tag => tag.textContent
                                    .toLowerCase());

                                const matchesPriority = !priorityFilter || priority === priorityFilter;
                                const matchesStatus = !statusFilter || status === statusFilter;
                                const matchesSearch = !searchFilter ||
                                    title.includes(searchFilter) ||
                                    content.includes(searchFilter) ||
                                    tags.some(tag => tag.includes(searchFilter));

                                if (matchesPriority && matchesStatus && matchesSearch) {
                                    announcement.style.display = 'block';
                                    visibleCount++;
                                    if (status === 'published') publishedCount++;
                                } else {
                                    announcement.style.display = 'none';
                                }
                            });

                            document.getElementById('totalCount').textContent = visibleCount;
                            document.getElementById('publishedCount').textContent = publishedCount;
                        }

                        // Add event listeners
                        document.getElementById('priorityFilter').addEventListener('change', filterAnnouncements);
                        document.getElementById('statusFilter').addEventListener('change', filterAnnouncements);
                        document.getElementById('searchFilter').addEventListener('input', filterAnnouncements);

                        // Action button handlers (you can customize these)
                        document.addEventListener('click', function(e) {
                            if (e.target.closest('.btn-view')) {
                                console.log('View announcement');
                                // Add your view logic here
                            } else if (e.target.closest('.btn-edit')) {
                                console.log('Edit announcement');
                                // Add your edit logic here
                            } else if (e.target.closest('.btn-delete')) {
                                if (confirm('Are you sure you want to delete this announcement?')) {
                                    console.log('Delete announcement');
                                    // Add your delete logic here
                                }
                            }
                        });
                    </script>
                </div>
            </section>



            <!-- Reports Section -->
            <section id="reports" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-chart-line"></i>
                        Reports & Analytics
                    </h2>
                    <button class="btn btn-primary" onclick="generateReport()">
                        <i class="fas fa-download"></i>
                        Generate Report
                    </button>
                </div>

                <div class="reports-grid">
                    <div class="chart-container">
                        <h4 class="chart-title">Certificate Issuance by Month</h4>
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-bar"></i>
                            <p>Chart visualization</p>
                        </div>
                    </div>

                    <div class="chart-container">
                        <h4 class="chart-title">User Registration Growth</h4>
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-line"></i>
                            <p>Chart visualization</p>
                        </div>
                    </div>

                    <div class="chart-container">
                        <h4 class="chart-title">Top Courses by Enrollment</h4>
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-pie"></i>
                            <p>Chart visualization</p>
                        </div>
                    </div>

                    <div class="chart-container">
                        <h4 class="chart-title">Regional Distribution</h4>
                        <div class="chart-placeholder">
                            <i class="fas fa-map"></i>
                            <p>Chart visualization</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Certificates Section -->
            <!-- <section id="certificates" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-certificate"></i>
                        Certificate Management
                    </h2>
                    <button class="btn btn-primary" onclick="openIssueCertificateModal()">
                        <i class="fas fa-plus"></i>
                        Issue Certificate
                    </button>
                </div>
                
                <div class="card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Certificate ID</th>
                                <th>Recipient</th>
                                <th>Course</th>
                                <th>Issue Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="certificatesTable">
                            <tr>
                                <td>TESDA-2025-001234</td>
                                <td>Juan Dela Cruz</td>
                                <td>Computer Programming NC III</td>
                                <td>Jan 28, 2025</td>
                                <td><span class="status-badge status-active">Valid</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-ban"></i> Revoke
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section> -->

            <!-- Users Section */
            <section id="users" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-users"></i>
                        User Management
                    </h2>
                    <button class="btn btn-secondary" onclick="exportUsers()">
                        <i class="fas fa-download"></i>
                        Export Users
                    </button>
                </div>
                
                <div class="card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTable">
                            <tr>
                                <td>USR-001</td>
                                <td>Juan Dela Cruz</td>
                                <td>juan@email.com</td>
                                <td>Applicant</td>
                                <td>Jan 28, 2025</td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-ban"></i> Block
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

             Settings Section -->
            <section id="settings" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-cog"></i>
                        System Settings
                    </h2>
                </div>

                <div class="card" style="padding: 24px;">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">System Name</label>
                            <input type="text" class="form-input" value="TESDA Job Portal" id="systemName">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Admin Email</label>
                            <input type="email" class="form-input" value="admin@tesda.gov.ph" id="adminEmail">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Registration Status</label>
                            <select class="form-select" id="registrationStatus">
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                                <option value="approval">Admin Approval Required</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Maintenance Mode</label>
                            <select class="form-select" id="maintenanceMode">
                                <option value="disabled">Disabled</option>
                                <option value="enabled">Enabled</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top: 24px;">
                        <button class="btn btn-primary" onclick="saveSettings()">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                        <button class="btn btn-secondary" onclick="resetSettings()">
                            <i class="fas fa-undo"></i> Reset to Default
                        </button>
                    </div>
                </div>
            </section>


        </main>
    </div>

    <!-- Add Officer Modal -->
    <div id="addOfficerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add New Officer</h2>
                <p class="modal-subtitle">Create a new TESDA officer account with full credentials</p>
                <button class="modal-close" onclick="closeModal('addOfficerModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addOfficerForm" action="{{ route('admin.addofficer.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-input" name="first_name" id="officerFirstName"
                                required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-input" name="last_name" id="officerLastName" required>
                        </div>

                        <div class="form-group form-grid-full">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-input" name="email" id="officerEmail" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Temporary Password</label>
                            <input type="password" class="form-input" name="temporary_password" id="officerPassword"
                                required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="officerStatus" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel"
                            onclick="closeModal('addOfficerModal')">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Officer Account
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>



    <!-- Add Announcement Modal -->
    <div id="addAnnouncementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Create New Announcement</h2>
                <p class="modal-subtitle">Create and publish announcements for users</p>
                <button class="modal-close" onclick="closeModal('addAnnouncementModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.create-announcement') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Announcement Title</label>
                        <input type="text" class="form-input" name="title" id="announcementTitle" required
                            placeholder="Enter announcement title">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Content</label>
                        <textarea class="form-input form-textarea" name="content" id="announcementContent" required
                            placeholder="Enter announcement content..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-input" name="image" id="announcementImage"
                            name="image" accept="image/*">
                    </div>


                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Priority Level</label>
                            <select class="form-select" name="priority" id="announcementPriority" required>
                                <option value="">Select Priority</option>
                                <option value="low">Low Priority</option>
                                <option value="medium">Medium Priority</option>
                                <option value="high">High Priority</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Target Audience</label>
                            <select class="form-select" name="audience" id="announcementAudience" required>
                                <option value="">Select Audience</option>
                                <option value="all">All Users</option>
                                <option value="applicants">Job Applicants Only</option>
                                <option value="employers">Employers Only</option>
                                <option value="tesda_officers">TESDA Officers Only</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Publication Date</label>
                            <input type="datetime-local" name="date" class="form-input" id="announcementDate"
                                required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="announcementStatus" required>
                                <option value="">Select Status</option>
                                <option value="draft">Save as Draft</option>
                                <option value="published">Publish Immediately</option>
                                <option value="scheduled">Schedule for Later</option>
                                <option value="archived">archived</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tags (Optional)</label>
                        <input type="text" class="form-input" name="tags" id="announcementTags"
                            placeholder="Enter tags separated by commas">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel"
                            onclick="closeModal('addAnnouncementModal')">Cancel</button>
                        <button type="submit" class="btn btn-primary" onclick="submitAnnouncementForm()">
                            <i class="fas fa-bullhorn"></i> Create Announcement
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Edit Announcement Modal -->
    <div id="editAnnouncementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Announcement</h2>
                <p class="modal-subtitle">Update announcement details and settings</p>
                <button class="modal-close" onclick="closeModal('editAnnouncementModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAnnouncementForm">
                    <input type="hidden" id="editAnnouncementId">
                    <div class="form-group">
                        <label class="form-label">Announcement Title</label>
                        <input type="text" class="form-input" id="editAnnouncementTitle" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Content</label>
                        <textarea class="form-input form-textarea" id="editAnnouncementContent" required></textarea>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Priority Level</label>
                            <select class="form-select" id="editAnnouncementPriority" required>
                                <option value="low">Low Priority</option>
                                <option value="medium">Medium Priority</option>
                                <option value="high">High Priority</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Target Audience</label>
                            <select class="form-select" id="editAnnouncementAudience" required>
                                <option value="all">All Users</option>
                                <option value="applicants">Job Applicants Only</option>
                                <option value="employers">Employers Only</option>
                                <option value="officers">TESDA Officers Only</option>
                                <option value="regional">Regional Offices</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="editAnnouncementStatus" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="scheduled">Scheduled</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel"
                    onclick="closeModal('editAnnouncementModal')">Cancel</button>
                <button type="submit" class="btn btn-primary" onclick="updateAnnouncement()">
                    <i class="fas fa-save"></i> Update Announcement
                </button>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-3 shadow-lg" style="max-width: 400px; margin: auto;">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt me-2"></i>Confirm Logout
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.logout.store') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Global Data Storage


        // Navigation Functions
        function showSection(sectionId, element) {
            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.classList.remove('active'));

            // Show selected section
            document.getElementById(sectionId).classList.add('active');

            // Update menu items
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => item.classList.remove('active'));
            element.classList.add('active');

            // Load section-specific data
            if (sectionId === 'officers') {
                renderOfficers();
            } else if (sectionId === 'announcements') {
                renderAnnouncements();
            }
        }

        // Modal Functions
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = 'auto';

            // Clear form data
            const form = document.querySelector(`#${modalId} form`);
            if (form) {
                form.reset();
            }
        }

        // Alert Functions
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alertId = 'alert-' + Date.now();

            const alert = document.createElement('div');
            alert.id = alertId;
            alert.className = `alert alert-${type}`;
            alert.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
                <button style="margin-left: auto; background: none; border: none; cursor: pointer;" onclick="hideAlert('${alertId}')">
                    <i class="fas fa-times"></i>
                </button>
            `;

            alertContainer.appendChild(alert);

            // Show alert
            setTimeout(() => {
                alert.classList.add('show');
            }, 100);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                hideAlert(alertId);
            }, 5000);
        }

        function hideAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }



        function openAddOfficerModal() {
            // Set current date/time for password generation hint
            const now = new Date();
            document.getElementById('announcementDate').value = now.toISOString().slice(0, 16);
            openModal('addOfficerModal');
        }

        function openEditOfficerModal(officerId) {
            const officer = officers.find(o => o.id === officerId);
            if (officer) {
                document.getElementById('editOfficerId').value = officer.id;
                document.getElementById('editOfficerFirstName').value = officer.firstName;
                document.getElementById('editOfficerLastName').value = officer.lastName;
                document.getElementById('editOfficerPosition').value = officer.position;
                document.getElementById('editOfficerRegion').value = officer.region;
                document.getElementById('editOfficerEmail').value = officer.email;
                document.getElementById('editOfficerPhone').value = officer.phone;
                document.getElementById('editOfficerEmployeeId').value = officer.employeeId;
                document.getElementById('editOfficerAccessLevel').value = officer.accessLevel;
                document.getElementById('editOfficerStatus').value = officer.status;

                openModal('editOfficerModal');
            }
        }

        function submitOfficerForm() {
            const form = document.getElementById('addOfficerForm');
            if (form.checkValidity()) {
                const newOfficer = {
                    id: officers.length + 1,
                    firstName: document.getElementById('officerFirstName').value,
                    lastName: document.getElementById('officerLastName').value,
                    position: document.getElementById('officerPosition').value,
                    region: document.getElementById('officerRegion').value,
                    email: document.getElementById('officerEmail').value,
                    phone: document.getElementById('officerPhone').value,
                    employeeId: document.getElementById('officerEmployeeId').value,
                    username: document.getElementById('officerUsername').value,
                    accessLevel: document.getElementById('officerAccessLevel').value,
                    status: document.getElementById('officerStatus').value,
                    dateCreated: new Date().toISOString().slice(0, 10)
                };

                officers.push(newOfficer);
                renderOfficers();
                updateStats();
                closeModal('addOfficerModal');
                showAlert(`Officer account created successfully for ${newOfficer.firstName} ${newOfficer.lastName}!`);
            } else {
                showAlert('Please fill in all required fields.', 'error');
            }
        }

        function updateOfficer() {
            const officerId = parseInt(document.getElementById('editOfficerId').value);
            const officerIndex = officers.findIndex(o => o.id === officerId);

            if (officerIndex !== -1) {
                officers[officerIndex] = {
                    ...officers[officerIndex],
                    firstName: document.getElementById('editOfficerFirstName').value,
                    lastName: document.getElementById('editOfficerLastName').value,
                    position: document.getElementById('editOfficerPosition').value,
                    region: document.getElementById('editOfficerRegion').value,
                    email: document.getElementById('editOfficerEmail').value,
                    phone: document.getElementById('editOfficerPhone').value,
                    employeeId: document.getElementById('editOfficerEmployeeId').value,
                    accessLevel: document.getElementById('editOfficerAccessLevel').value,
                    status: document.getElementById('editOfficerStatus').value
                };

                renderOfficers();
                closeModal('editOfficerModal');
                showAlert(`Officer information updated successfully!`);
            }
        }

        function deleteOfficer(officerId) {
            const officer = officers.find(o => o.id === officerId);
            if (officer && confirm(
                    `Are you sure you want to delete ${officer.firstName} ${officer.lastName}'s account? This action cannot be undone.`
                )) {
                officers = officers.filter(o => o.id !== officerId);
                renderOfficers();
                updateStats();
                showAlert(`Officer account deleted successfully.`, 'info');
            }
        }

        // Announcement Management Functions
        function renderAnnouncements() {
            const announcementsList = document.getElementById('announcementsList');
            announcementsList.innerHTML = '';

            announcements.forEach(announcement => {
                const announcementCard = document.createElement('div');
                announcementCard.className = 'card announcement-card';
                announcementCard.innerHTML = `
                    <div class="announcement-header">
                        <h4 class="announcement-title">${announcement.title}</h4>
                        <span class="announcement-date">${new Date(announcement.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                    </div>
                    <p class="announcement-content">${announcement.content}</p>
                    <div class="announcement-footer">
                        <span class="status-badge status-${announcement.status === 'published' ? 'active' : announcement.status === 'draft' ? 'draft' : 'inactive'}">${announcement.status.charAt(0).toUpperCase() + announcement.status.slice(1)}</span>
                        <div class="action-buttons">
                            <button class="btn btn-warning btn-sm" onclick="openEditAnnouncementModal(${announcement.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteAnnouncement(${announcement.id})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                `;
                announcementsList.appendChild(announcementCard);
            });
        }

        function openAddAnnouncementModal() {
            // Set current date/time
            const now = new Date();
            document.getElementById('announcementDate').value = now.toISOString().slice(0, 16);
            openModal('addAnnouncementModal');
        }

        function openEditAnnouncementModal(announcementId) {
            const announcement = announcements.find(a => a.id === announcementId);
            if (announcement) {
                document.getElementById('editAnnouncementId').value = announcement.id;
                document.getElementById('editAnnouncementTitle').value = announcement.title;
                document.getElementById('editAnnouncementContent').value = announcement.content;
                document.getElementById('editAnnouncementPriority').value = announcement.priority;
                document.getElementById('editAnnouncementAudience').value = announcement.audience;
                document.getElementById('editAnnouncementStatus').value = announcement.status;

                openModal('editAnnouncementModal');
            }
        }

        function submitAnnouncementForm() {
            const form = document.getElementById('addAnnouncementForm');
            if (form.checkValidity()) {
                const newAnnouncement = {
                    id: announcements.length + 1,
                    title: document.getElementById('announcementTitle').value,
                    content: document.getElementById('announcementContent').value,
                    priority: document.getElementById('announcementPriority').value,
                    audience: document.getElementById('announcementAudience').value,
                    status: document.getElementById('announcementStatus').value,
                    date: document.getElementById('announcementDate').value.slice(0, 10),
                    tags: document.getElementById('announcementTags').value.split(',').map(tag => tag.trim()).filter(
                        tag => tag),
                    author: 'Admin User'
                };

                announcements.push(newAnnouncement);
                renderAnnouncements();
                updateStats();
                closeModal('addAnnouncementModal');
                showAlert(`Announcement "${newAnnouncement.title}" created successfully!`);
            } else {
                showAlert('Please fill in all required fields.', 'error');
            }
        }

        function updateAnnouncement() {
            const announcementId = parseInt(document.getElementById('editAnnouncementId').value);
            const announcementIndex = announcements.findIndex(a => a.id === announcementId);

            if (announcementIndex !== -1) {
                announcements[announcementIndex] = {
                    ...announcements[announcementIndex],
                    title: document.getElementById('editAnnouncementTitle').value,
                    content: document.getElementById('editAnnouncementContent').value,
                    priority: document.getElementById('editAnnouncementPriority').value,
                    audience: document.getElementById('editAnnouncementAudience').value,
                    status: document.getElementById('editAnnouncementStatus').value
                };

                renderAnnouncements();
                closeModal('editAnnouncementModal');
                showAlert(`Announcement updated successfully!`);
            }
        }

        function deleteAnnouncement(announcementId) {
            const announcement = announcements.find(a => a.id === announcementId);
            if (announcement && confirm(`Are you sure you want to delete the announcement "${announcement.title}"?`)) {
                announcements = announcements.filter(a => a.id !== announcementId);
                renderAnnouncements();
                updateStats();
                showAlert(`Announcement deleted successfully.`, 'info');
            }
        }

        // Certificate Functions
        function openIssueCertificateModal() {
            // Set current date
            const today = new Date().toISOString().slice(0, 10);
            document.getElementById('certificateIssueDate').value = today;
            openModal('issueCertificateModal');
        }

        function submitCertificateForm() {
            const form = document.getElementById('issueCertificateForm');
            if (form.checkValidity()) {
                const certificateData = {
                    id: 'TESDA-2025-' + String(Date.now()).slice(-6),
                    recipient: document.getElementById('certificateRecipient').value,
                    course: document.getElementById('certificateCourse').value,
                    assessmentDate: document.getElementById('certificateAssessmentDate').value,
                    issueDate: document.getElementById('certificateIssueDate').value,
                    trainingCenter: document.getElementById('certificateTrainingCenter').value,
                    assessmentCenter: document.getElementById('certificateAssessmentCenter').value,
                    notes: document.getElementById('certificateNotes').value,
                    status: 'valid'
                };

                // Add certificate to table (in a real app, this would be saved to database)
                addCertificateToTable(certificateData);
                updateStats();
                closeModal('issueCertificateModal');
                showAlert(`Certificate ${certificateData.id} issued successfully to ${certificateData.recipient}!`);
            } else {
                showAlert('Please fill in all required fields.', 'error');
            }
        }

        function addCertificateToTable(certificate) {
            const tbody = document.getElementById('certificatesTable');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${certificate.id}</td>
                <td>${certificate.recipient}</td>
                <td>${certificate.course}</td>
                <td>${new Date(certificate.issueDate).toLocaleDateString()}</td>
                <td><span class="status-badge status-active">Valid</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i class="fas fa-ban"></i> Revoke
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        }

        // Settings Functions
        function saveSettings() {
            const settings = {
                systemName: document.getElementById('systemName').value,
                adminEmail: document.getElementById('adminEmail').value,
                registrationStatus: document.getElementById('registrationStatus').value,
                maintenanceMode: document.getElementById('maintenanceMode').value
            };

            // In a real app, this would save to backend
            localStorage.setItem('tesdaSettings', JSON.stringify(settings));
            showAlert('Settings saved successfully!');
        }

        function resetSettings() {
            if (confirm('Are you sure you want to reset all settings to default values?')) {
                document.getElementById('systemName').value = 'TESDA Job Portal';
                document.getElementById('adminEmail').value = 'admin@tesda.gov.ph';
                document.getElementById('registrationStatus').value = 'open';
                document.getElementById('maintenanceMode').value = 'disabled';
                showAlert('Settings reset to default values.', 'info');
            }
        }

        // Report Functions
        function generateReport() {
            showAlert('Generating comprehensive system report...', 'info');

            // Simulate report generation
            setTimeout(() => {
                const reportData = {
                    totalUsers: document.getElementById('totalUsers').textContent,
                    totalOfficers: officers.length,
                    totalAnnouncements: announcements.length,
                    activeOfficers: officers.filter(o => o.status === 'active').length,
                    publishedAnnouncements: announcements.filter(a => a.status === 'published').length,
                    generatedAt: new Date().toLocaleString()
                };

                // In a real app, this would generate a downloadable PDF/Excel file
                console.log('Report Data:', reportData);
                showAlert('Report generated successfully! Check your downloads folder.');
            }, 2000);
        }

        function exportUsers() {
            showAlert('Exporting user data to CSV...', 'info');

            // Simulate CSV export
            setTimeout(() => {
                showAlert('User data exported successfully!');
            }, 1500);
        }

        // Update Statistics
        function updateStats() {
            document.getElementById('totalOfficers').textContent = officers.length;
            document.getElementById('totalAnnouncements').textContent = announcements.length;
        }

        // Real-time statistics simulation
        function simulateRealTimeStats() {
            const statsElements = [{
                    id: 'totalUsers',
                    increment: Math.floor(Math.random() * 5)
                },
                {
                    id: 'totalEmployers',
                    increment: Math.floor(Math.random() * 3)
                },
                {
                    id: 'totalApplicants',
                    increment: Math.floor(Math.random() * 8)
                },
                {
                    id: 'totalCertificates',
                    increment: Math.floor(Math.random() * 6)
                }
            ];

            statsElements.forEach(stat => {
                if (stat.increment > 0) {
                    const element = document.getElementById(stat.id);
                    if (element) {
                        const currentValue = parseInt(element.textContent.replace(/,/g, ''));
                        const newValue = currentValue + stat.increment;
                        element.textContent = newValue.toLocaleString();
                    }
                }
            });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                const activeModal = event.target;
                closeModal(activeModal.id);
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Close modal with Escape key
            if (e.key === 'Escape') {
                const activeModal = document.querySelector('.modal.active');
                if (activeModal) {
                    closeModal(activeModal.id);
                }
            }

            // Navigation shortcuts
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case '1':
                        e.preventDefault();
                        document.querySelector('[onclick*="dashboard"]').click();
                        break;
                    case '2':
                        e.preventDefault();
                        document.querySelector('[onclick*="officers"]').click();
                        break;
                    case '3':
                        e.preventDefault();
                        document.querySelector('[onclick*="announcements"]').click();
                        break;
                    case '4':
                        e.preventDefault();
                        document.querySelector('[onclick*="reports"]').click();
                        break;
                }
            }
        });

        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            console.log('TESDA Super Admin Dashboard loaded successfully!');

            // Load initial data
            renderOfficers();
            renderAnnouncements();
            updateStats();

            // Load saved settings
            const savedSettings = localStorage.getItem('tesdaSettings');
            if (savedSettings) {
                const settings = JSON.parse(savedSettings);
                document.getElementById('systemName').value = settings.systemName || 'TESDA Job Portal';
                document.getElementById('adminEmail').value = settings.adminEmail || 'admin@tesda.gov.ph';
                document.getElementById('registrationStatus').value = settings.registrationStatus || 'open';
                document.getElementById('maintenanceMode').value = settings.maintenanceMode || 'disabled';
            }

            // Start real-time stats simulation
            setInterval(simulateRealTimeStats, 45000); // Update every 45 seconds

            // Welcome message
            setTimeout(() => {
                showAlert('Welcome to TESDA Super Admin Dashboard! All systems are operational.', 'info');
            }, 1000);
        });
    </script>
</body>

</html>
