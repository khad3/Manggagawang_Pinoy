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
                        <div id="userRegistrationChart" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>

                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        packages: ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            {!! implode(',', $chartData) !!}
                        ]);

                        var options = {
                            title: 'User Registration Trends',
                            chartArea: {
                                width: '70%'
                            },
                            hAxis: {
                                title: 'Month'
                            },
                            vAxis: {
                                title: 'Total Registrations',
                                minValue: 0,
                                gridlines: {
                                    count: 5
                                },
                                format: '0'
                            },
                            colors: {!! json_encode($colors) !!}
                        };

                        var chart = new google.visualization.ColumnChart(
                            document.getElementById('userRegistrationChart')
                        );
                        chart.draw(data, options);
                    }
                </script>
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
                    </div>
                </div>
            </section>



            <!-- Reports & Analytics Section -->
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
                <div class="reports-container">
                    <div class="reports-header">
                        <div class="report-filters">
                            <div class="filter-group">
                                <label>Time Period:</label>
                                <select class="filter-select" id="timePeriod">
                                    <option value="7days">Last 7 Days</option>
                                    <option value="30days" selected>Last 30 Days</option>
                                    <option value="90days">Last 90 Days</option>
                                    <option value="1year">Last Year</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>User Type:</label>
                                <select class="filter-select" id="userType">
                                    <option value="all">All Users</option>
                                    <option value="applicants">Applicants</option>
                                    <option value="employers">Employers</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="reports-grid">
                        <!-- Report Card -->
                        <div class="report-card">
                            <div class="report-card-header">
                                <h3 class="report-title">User Registrations</h3>
                                <div class="report-actions">
                                    <button class="action-btn btn-view" title="View Details" data-bs-toggle="modal"
                                        data-bs-target="#userRegistrationModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="report-metric">1,247</div>
                            <div class="report-change">
                                <i class="fas fa-trending-up text-success"></i>
                                +18.2% from last period
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="userRegistrationModal" tabindex="-1"
                            aria-labelledby="userRegistrationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="userRegistrationModalLabel">User Registration
                                            Trends</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="userRegistrationChart" style="width: 100%; height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Google Charts -->
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script>
                            google.charts.load('current', {
                                packages: ['corechart']
                            });

                            // Draw chart when modal opens
                            document.getElementById('userRegistrationModal').addEventListener('shown.bs.modal', function() {
                                drawUserRegistrationChart();
                            });

                            function drawUserRegistrationChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Month', 'Registrations'],
                                    ['Jan', 200],
                                    ['Feb', 300],
                                    ['Mar', 250],
                                    ['Apr', 400],
                                    ['May', 350],
                                    ['Jun', 500]
                                ]);

                                var options = {
                                    title: 'User Registration Trends',
                                    chartArea: {
                                        width: '70%'
                                    },
                                    hAxis: {
                                        title: 'Month'
                                    },
                                    vAxis: {
                                        title: 'Total Registrations',
                                        minValue: 0,
                                        format: '0'
                                    },
                                    colors: ['#4CAF50']
                                };

                                var chart = new google.visualization.ColumnChart(
                                    document.getElementById('userRegistrationChart')
                                );
                                chart.draw(data, options);
                            }
                        </script>


                        <div class="report-card">
                            <div class="report-card-header">
                                <h3 class="report-title">Account Bans</h3>
                                <div class="report-actions">
                                    <button class="action-btn btn-view" title="View Details"
                                        onclick="showBanReport()">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="report-metric">23</div>
                            <div class="report-change">
                                <i class="fas fa-trending-down text-danger"></i>
                                -12.8% from last period
                            </div>
                        </div>

                        <div class="report-card">
                            <div class="report-card-header">
                                <h3 class="report-title">Login Activity</h3>
                                <div class="report-actions">
                                    <button class="action-btn btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="report-metric">18,924</div>
                            <div class="report-change">
                                <i class="fas fa-trending-up text-success"></i>
                                +5.7% from last period
                            </div>
                        </div>

                        <div class="report-card">
                            <div class="report-card-header">
                                <h3 class="report-title">Certificate Issuance</h3>
                                <div class="report-actions">
                                    <button class="action-btn btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="report-metric">892</div>
                            <div class="report-change">
                                <i class="fas fa-trending-up text-success"></i>
                                +22.1% from last period
                            </div>
                        </div>

                        <div class="report-card">
                            <div class="report-card-header">
                                <h3 class="report-title">Suspended Accounts</h3>
                                <div class="report-actions">
                                    <button class="action-btn btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="report-metric">156</div>
                            <div class="report-change">
                                <i class="fas fa-trending-up text-warning"></i>
                                +3.4% from last period
                            </div>
                        </div>

                        <div class="report-card">
                            <div class="report-card-header">
                                <h3 class="report-title">Job Applications</h3>
                                <div class="report-actions">
                                    <button class="action-btn btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="report-metric">4,567</div>
                            <div class="report-change">
                                <i class="fas fa-trending-up text-success"></i>
                                +28.9% from last period
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity Log -->
                    <div class="report-card" style="grid-column: 1 / -1;">
                        <div class="report-card-header">
                            <h3 class="report-title">Recent Admin Actions</h3>
                            <div class="report-actions">
                                <button class="action-btn btn-view" title="View All">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                        <div id="activityLog">
                            <div class="activity-item">
                                <div class="activity-icon activity-ban">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>User Banned</h6>
                                    <p>juan.dela@email.com was banned for violating community guidelines</p>
                                </div>
                                <div class="activity-time">2 hours ago</div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon activity-unban">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>User Unbanned</h6>
                                    <p>maria.santos@email.com ban was lifted after appeal review</p>
                                </div>
                                <div class="activity-time">5 hours ago</div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon activity-suspend">
                                    <i class="fas fa-pause"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Account Suspended</h6>
                                    <p>robert.garcia@email.com suspended for 7 days due to multiple reports</p>
                                </div>
                                <div class="activity-time">1 day ago</div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon activity-login">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Mass Login Activity</h6>
                                    <p>Detected 1,247 user logins in the past hour</p>
                                </div>
                                <div class="activity-time">2 days ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- User Management Section -->
            <section id="users" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-users"></i>
                        User Management
                    </h2>
                    <a href="{{ route('admin.export') }}" class="btn btn-primary">
                        <i class="fas fa-download"></i>
                        Export Users
                    </a>
                </div>

                <div class="users-container">
                    <div class="users-header">
                        <div class="users-controls">
                            <div class="filter-group">
                                <select class="filter-select" id="statusFilters">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="banned">Banned</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <select class="filter-select" id="userTypeFilter">
                                    <option value="">All Types</option>
                                    <option value="applicant">Applicants</option>
                                    <option value="employer">Employers</option>

                                </select>
                            </div>
                            <div class="filter-group">
                                <input type="text" class="search-input" placeholder="Search users..."
                                    id="userSearch">
                            </div>
                        </div>
                        <div class="users-stats">
                            <span class="stat-badge">
                                <i class="fas fa-users"></i>
                                <span id="totalUsersCount">{{ count($users) }}</span> Total
                            </span>
                        </div>
                    </div>

                    <table id="usersTable" class="users-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    $status = strtolower(trim($user['data']->status ?? 'inactive'));
                                    $type = strtolower(trim($user['type'] ?? 'applicant'));
                                    $userId = $user['data']->id ?? null;
                                @endphp
                                <tr data-id="{{ $userId }}" data-status="{{ $status }}"
                                    data-type="{{ $type }}">
                                    <td>
                                        <div class="user-info">
                                            <div
                                                class="user-avatar {{ $user['type'] === 'applicant' ? 'avatar-applicant' : 'avatar-employer' }}">
                                                @if ($user['type'] === 'applicant')
                                                    {{ strtoupper(substr($user['data']->personal_info?->first_name ?? 'U', 0, 1)) }}
                                                    {{ strtoupper(substr($user['data']->personal_info?->last_name ?? '', 0, 1)) }}
                                                @else
                                                    {{ strtoupper(substr($user['data']->addressCompany?->company_name ?? 'U', 0, 1)) }}
                                                @endif
                                            </div>

                                            <div class="user-details">
                                                @if ($user['type'] === 'applicant')
                                                    <h4>{{ $user['data']->personal_info?->first_name ?? 'N/A' }}
                                                        {{ $user['data']->personal_info?->last_name ?? '' }}</h4>
                                                    <p>{{ $user['data']->email ?? 'N/A' }}</p>
                                                @else
                                                    <h4>{{ $user['data']->addressCompany->company_name ?? 'N/A' }}</h4>
                                                    <p>{{ $user['data']->email ?? 'N/A' }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span
                                            class="type-badge {{ $user['type'] === 'applicant' ? 'type-applicant' : 'type-employer' }}">
                                            {{ ucfirst($user['type']) }}
                                        </span>
                                    </td>

                                    <td>
                                        @php
                                            $status = strtolower($user['data']->status ?? 'inactive');
                                            $statusClass = match ($status) {
                                                'active' => 'status-active',
                                                'inactive' => 'status-inactive',
                                                'suspended' => 'status-suspended',
                                                'banned' => 'status-banned',
                                                default => 'status-inactive',
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $user['data']->last_login ? \Carbon\Carbon::parse($user['data']->last_login)->diffForHumans() : 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $user['data']->created_at ? \Carbon\Carbon::parse($user['data']->created_at)->format('M d, Y') : 'N/A' }}
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <button class="action-btn btn-view"
                                                onclick="openModal('viewUserModal', {{ $userId }})"
                                                title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if ($user['type'] === 'applicant')
                                                <button type="button" class="action-btn btn-suspend"
                                                    onclick="openSuspendModal({{ $user['data']->id }}, '{{ addslashes($user['data']->personal_info?->first_name ?? '') }}', 'applicant')">
                                                    <i class="fas fa-pause-circle"></i>
                                                </button>
                                            @elseif ($user['type'] === 'employer')
                                                <button type="button" class="action-btn btn-suspend"
                                                    onclick="openSuspendModal({{ $user['data']->id }}, '{{ addslashes($user['data']->addressCompany?->company_name ?? '') }}', 'employer')">
                                                    <i class="fas fa-pause-circle"></i>
                                                </button>
                                            @endif





                                            <!-- Ban User (smaller button like action-btn) -->
                                            @if ($user['data']->status === 'banned')
                                                <!-- Unban Button -->
                                                <button class="action-btn btn-unban text-success"
                                                    onclick="openUnbanModal({{ $user['data']->id }}, '{{ $user['type'] }}')"
                                                    title="Unban User">
                                                    <i class="fas fa-user-check"></i> Unban
                                                </button>
                                            @else
                                                <!-- Ban Button -->
                                                <button class="action-btn btn-ban text-danger"
                                                    onclick="openBanModal(
            {{ $user['data']->id }},
            '{{ addslashes(
                $user['type'] === 'employer'
                    ? $user['data']->addressCompany?->company_name ?? 'Unknown Company'
                    : $user['data']->personal_info?->first_name . ' ' . ($user['data']->personal_info?->last_name ?? ''),
            ) }}',
            '{{ $user['type'] }}'
        )"
                                                    title="Ban User">
                                                    <i class="fas fa-user-slash"></i> Ban
                                                </button>
                                            @endif

                                            <!-- Delete User Button -->
                                            <!-- Delete User Button -->
                                            <button class="action-btn btn-delete text-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmDeleteUserModal"
                                                data-user-id="{{ $user['data']->id }}"
                                                data-user-type="{{ $user['type'] }}" title="Delete User">
                                                <i class="fas fa-user-times"></i>
                                            </button>








                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                    <!--- Modals ---->
                    <!-- VIEW USER MODAL -->
                    <div id="viewUserModal" class="modal-overlay">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">User Details</h3>
                                <button class="modal-close" onclick="closeModal('viewUserModal')">&times;</button>
                            </div>
                            <div class="modal-body">

                                <div class="user-details">
                                    <!-- BASIC INFORMATION -->
                                    <div class="detail-section">
                                        <div class="section-title">👤 Basic Information</div>
                                        <div class="detail-row">
                                            <span class="detail-label">ID:</span>
                                            <span class="detail-value">1</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Name:</span>
                                            <span class="detail-value">Juan Dela Cruz</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Email:</span>
                                            <span class="detail-value">juan.dela@email.com</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Type:</span>
                                            <span class="detail-value">Applicant</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Status:</span>
                                            <span class="detail-value"><span
                                                    class="status-badge status-active">Active</span></span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Region:</span>
                                            <span class="detail-value">NCR</span>
                                        </div>
                                    </div>

                                    <!-- ACCOUNT INFORMATION -->
                                    <div class="detail-section">
                                        <div class="section-title">📅 Account Information</div>
                                        <div class="detail-row">
                                            <span class="detail-label">Registration Date:</span>
                                            <span class="detail-value">December 1, 2024</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Last Login:</span>
                                            <span class="detail-value">Jan 15, 2025, 09:30 AM</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Reports:</span>
                                            <span class="detail-value">0</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CONDITIONAL SECTIONS -->
                                <div class="reports-warning" style="display: none;">
                                    ⚠️ This user has 5 report(s) against them.
                                </div>

                                <div class="ban-info" style="display: none;">
                                    <strong>Ban Information:</strong><br>
                                    Reason: harassment<br>
                                    Date: January 12, 2025
                                </div>

                                <div class="suspend-info" style="display: none;">
                                    <strong>Suspension Information:</strong><br>
                                    Reason: pending_investigation<br>
                                    Date: January 13, 2025
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" onclick="closeModal('viewUserModal')">Close</button>
                            </div>
                        </div>
                    </div>

                    <!-- Suspend User Modal -->
                    <div id="suspendUserModals" class="modal-overlay">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Suspend User Account</h3>
                                <button class="modal-close" type="button"
                                    onclick="closeModal('suspendUserModals')">&times;</button>
                            </div>

                            <form action="{{ route('admin.suspend-user.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" id="suspendUserId">
                                <input type="hidden" name="type" id="suspendUserType">

                                <div class="modal-body">
                                    <div id="suspendUserInfo"></div>

                                    <!-- Suspension Reason -->
                                    <div class="form-group">
                                        <label for="suspendReason">Reason for Suspension:</label>
                                        <select id="suspendReason" name="reason" class="filter-select"
                                            style="width: 100%; margin-bottom: 15px;" onchange="toggleOtherReason()">
                                            <option value="">Select reason...</option>
                                            <option value="pending_investigation">Pending Investigation</option>
                                            <option value="multiple_user_reports">Multiple User Reports</option>
                                            <option value="suspicious_activity">Suspicious Activity</option>
                                            <option value="other">Other</option>
                                        </select>

                                        <!-- Hidden input for "Other" reason -->
                                        <input type="text" name="other_reason" id="otherReasonInput"
                                            class="filter-select" placeholder="Enter custom reason..."
                                            style="width: 100%; margin-bottom: 15px; display: none;" />
                                    </div>

                                    <!-- Suspension Duration -->
                                    <div class="form-group">
                                        <label for="suspendDuration">Suspension Duration:</label>
                                        <select id="suspendDuration" name="suspension_duration" class="filter-select"
                                            style="width: 100%; margin-bottom: 15px;">
                                            <option value="1">1 Day</option>
                                            <option value="3">3 Days</option>
                                            <option value="7">7 Days</option>
                                            <option value="14">14 Days</option>
                                            <option value="30">30 Days</option>
                                        </select>
                                    </div>

                                    <!-- Additional Notes -->
                                    <div class="form-group">
                                        <label for="suspendNotes">Additional Notes:</label>
                                        <textarea name="additional_notes" id="suspendNotes" rows="3"
                                            style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px;"
                                            placeholder="Optional additional details..."></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button"
                                        onclick="closeModal('suspendUserModals')">Cancel</button>
                                    <button class="btn btn-warning" type="submit">
                                        <i class="fas fa-pause"></i> Suspend User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        // Show/hide "Other Reason"
                        function toggleOtherReason() {
                            const select = document.getElementById('suspendReason');
                            const otherInput = document.getElementById('otherReasonInput');
                            if (select.value === 'other') {
                                otherInput.style.display = 'block';
                            } else {
                                otherInput.style.display = 'none';
                                otherInput.value = '';
                            }
                        }

                        // Open suspend modal and set user ID
                        function openSuspendModal(userId, userName = '', userType = '') {
                            document.getElementById('suspendUserId').value = userId;
                            document.getElementById('suspendUserType').value = userType;

                            const infoDiv = document.getElementById('suspendUserInfo');
                            infoDiv.innerHTML = userName ? `<p><strong>User:</strong> ${userName}</p>` : '';

                            openModal('suspendUserModals');
                        }
                    </script>

                    <!-- BAN USER MODAL -->
                    <div id="banUserModal" class="modal-overlay"
                        style="display: none; position: fixed; inset: 0; background: transparent; justify-content: center; align-items: center; z-index: 1050;">
                        <div class="modal-content rounded shadow bg-white" style="max-width: 450px; width: 100%;">
                            <!-- Header -->
                            <div
                                class="modal-header d-flex justify-content-between align-items-center border-bottom p-3">
                                <h3 class="modal-title">Ban User</h3>
                                <button class="modal-close btn-close" onclick="closeBanModal()"></button>
                            </div>

                            <!-- Body -->
                            <div class="modal-body p-3" id="banUserInfo">
                                <!-- Content injected dynamically -->
                            </div>

                            <!-- Footer -->
                            <div class="modal-footer d-flex justify-content-end gap-2 border-top p-3">
                                <button class="btn btn-secondary" onclick="closeBanModal()">Cancel</button>

                                <form id="banUserForm" method="POST" action="">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-user-slash me-1"></i> Ban User
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>


                    <script>
                        // Open Ban Modal and set form action + user name
                        function openBanModal(userId, userName = '', userType = 'applicant') {
                            const form = document.getElementById('banUserForm');

                            // Add type query param
                            form.action = `/admin/users/${userId}/ban?type=${userType.toLowerCase()}`;

                            const infoDiv = document.getElementById('banUserInfo');

                            if (userType.toLowerCase() === 'employer') {
                                infoDiv.innerHTML = `
            <p>Are you sure you want to <strong class="text-danger">ban</strong> the company <strong>${userName}</strong> permanently?</p>
            <p class="text-muted small mb-0">
                Once banned, this company will no longer be able to log in, post jobs, or access the system.
            </p>
        `;
                            } else {
                                infoDiv.innerHTML = `
            <p>Are you sure you want to <strong class="text-danger">ban</strong> <strong>${userName}</strong> permanently?</p>
            <p class="text-muted small mb-0">
                Once banned, this user will no longer be able to log in, apply for jobs, or access the system.
            </p>
        `;
                            }

                            document.getElementById('banUserModal').style.display = 'flex';
                        }

                        function closeBanModal() {
                            document.getElementById('banUserModal').style.display = 'none';
                        }
                    </script>

                    <!-- UNBAN USER Modal -->
                    <div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="banModalLabel">Confirm Unban</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to <strong>unban</strong> this user?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary rounded-pill"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <form id="unbanForm" method="POST" action="">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success rounded-pill">Yes,
                                            Unban</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Script -->
                    <script>
                        function openUnbanModal(userId, userType) {
                            const form = document.getElementById('unbanForm');
                            // Set dynamic action URL with userId & userType
                            form.action = `/admin/users/${userId}/unban?type=${userType.toLowerCase()}`;

                            const unbanModal = new bootstrap.Modal(document.getElementById('banModal'));
                            unbanModal.show();
                        }
                    </script>

                    <!-- DELETE USER MODAL -->
                    <div class="modal fade" id="confirmDeleteUserModal" tabindex="-1"
                        aria-labelledby="confirmDeleteUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteUserModalLabel">Confirm Delete User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <p id="deleteUserMessage">
                                        Are you sure you want to <strong class="text-danger">permanently
                                            delete</strong> this user?
                                    </p>
                                    <p class="text-muted small mb-0">
                                        This action cannot be undone. The account and all related data will be
                                        permanently removed.
                                    </p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary rounded-pill"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <form id="deleteUserForm" method="POST" action="">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill">
                                            <i class="fas fa-user-times me-1"></i> Yes, Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        const deleteUserModal = document.getElementById('confirmDeleteUserModal');

                        deleteUserModal.addEventListener('show.bs.modal', function(event) {
                            const button = event.relatedTarget;
                            const userId = button.getAttribute('data-user-id');
                            const userType = button.getAttribute('data-user-type');

                            // Update form action dynamically
                            const form = document.getElementById('deleteUserForm');
                            form.action = `/admin/users/${userId}/delete?type=${userType.toLowerCase()}`;

                            // Decide label: if employer -> company, else use userType
                            let displayType = userType.toLowerCase() === 'employer' ? 'company' : userType.toLowerCase();

                            // Update modal message
                            const message = document.getElementById('deleteUserMessage');
                            message.innerHTML =
                                `Are you sure you want to <strong class="text-danger">permanently delete</strong> this ${displayType}?`;
                        });
                    </script>



                    <div class="pagination">
                        <div class="pagination-info">
                            Showing <span id="showingStart">1</span>-<span id="showingEnd">10</span> of <span
                                id="totalCount">{{ count($users) }}</span> users
                        </div>
                        <div class="pagination-controls">
                            <button class="pagination-btn" id="prevBtn" onclick="changePage(-1)">
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                            <button class="pagination-btn active">1</button>
                            <button class="pagination-btn">2</button>
                            <button class="pagination-btn">3</button>
                            <button class="pagination-btn" id="nextBtn" onclick="changePage(1)">
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!--Settings Section -->
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
        const statusFilter = document.getElementById('statusFilters');
        const userTypeFilter = document.getElementById('userTypeFilter');
        const userSearch = document.getElementById('userSearch');
        const usersTable = document.getElementById('usersTable').getElementsByTagName('tbody')[0];

        function filterUsers() {
            const status = statusFilter.value.toLowerCase();
            const type = userTypeFilter.value.toLowerCase();
            const searchText = userSearch.value.toLowerCase();

            Array.from(usersTable.rows).forEach(row => {
                const rowStatus = row.getAttribute('data-status').toLowerCase();
                const rowType = row.getAttribute('data-type').toLowerCase();
                const rowText = row.textContent.toLowerCase();

                const matchesStatus = !status || rowStatus === status;
                const matchesType = !type || rowType === type;
                const matchesSearch = !searchText || rowText.includes(searchText);

                row.style.display = (matchesStatus && matchesType && matchesSearch) ? '' : 'none';
            });
        }

        statusFilter.addEventListener('change', filterUsers);
        userTypeFilter.addEventListener('change', filterUsers);
        userSearch.addEventListener('input', filterUsers);
    </script>


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


        function openAddAnnouncementModal() {
            // Set current date/time
            const now = new Date();
            document.getElementById('announcementDate').value = now.toISOString().slice(0, 16);
            openModal('addAnnouncementModal');
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

    <!-- expiratuion timer --->
    <script>
        // 10 minutes timeout (600,000 ms)
        const timeout = 10 * 60 * 1000;

        // Show popup 1 minute before logout (9 minutes = 540,000 ms)
        const warningTime = 9 * 60 * 1000;

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
            window.location.href = "{{ route('admin.login.display') }}";
        }

        // Reset timers on any activity
        document.addEventListener('mousemove', resetTimers);
        document.addEventListener('keydown', resetTimers);
        document.addEventListener('click', resetTimers);
    </script>

</body>

</html>
