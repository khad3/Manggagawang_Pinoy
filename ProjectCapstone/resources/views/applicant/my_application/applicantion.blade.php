<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobTracker - Application Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #f8fafc;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #8b5cf6;
        }

        body {
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        }

        .dashboard-container {
            padding: 2rem 0;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .tab-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .custom-tabs {
            border-bottom: 1px solid #e2e8f0;
        }

        .custom-tabs .nav-link {
            border: none;
            color: #64748b;
            font-weight: 500;
            padding: 1rem 2rem;
            border-radius: 0;
        }

        .custom-tabs .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .application-card, .job-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .application-card:hover, .job-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-reviewed {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-interview {
            background-color: #e9d5ff;
            color: #7c3aed;
        }

        .status-accepted {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .search-container {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .search-input {
            padding-left: 2.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .company-name {
            color: #64748b;
            font-weight: 500;
        }

        .job-title {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .job-details {
            color: #64748b;
            font-size: 0.875rem;
        }

        .heart-icon {
            color: #ef4444;
        }

        .modal-detail-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .modal-detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem 0;
            }

            .application-card, .job-card {
                padding: 1rem;
            }

            .custom-tabs .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>

    <a href="{{ route('applicant.info.homepage.display') }}" class="btn btn-primary">Back to Homepage</a>

    <div class="container-fluid dashboard-container">
        <div class="container">
            <!-- Dashboard Stats -->
            <div class="row g-4 mb-5">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">Total Applications</p>
                                <h3 class="fw-bold mb-0" id="totalApplications">4</h3>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">Pending Review</p>
                                <h3 class="fw-bold mb-0 text-warning" id="pendingApplications">1</h3>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">Interviews</p>
                                <h3 class="fw-bold mb-0" style="color: var(--info-color)" id="interviewApplications">1</h3>
                            </div>
                            <div class="stat-icon bg-opacity-10 text-white" style="background-color: var(--info-color)">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">Accepted</p>
                                <h3 class="fw-bold mb-0 text-success" id="acceptedApplications">0</h3>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10 text-success">
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
                        <button class="nav-link active" id="applications-tab" data-bs-toggle="tab" data-bs-target="#applications" type="button" role="tab">
                            My Applications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="saved-tab" data-bs-toggle="tab" data-bs-target="#saved" type="button" role="tab">
                            Saved Jobs
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="mainTabsContent">
                    <!-- Applications Tab -->
                    <div class="tab-pane fade show active" id="applications" role="tabpanel">
                        <div class="p-4">
                            <div class="row mb-4">
                                <div class="col-12 col-md-8">
                                    <h4 class="mb-0">Application Status</h4>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="d-flex flex-column flex-md-row gap-2">
                                        <div class="search-container flex-grow-1">
                                            <i class="fas fa-search search-icon"></i>
                                            <input type="text" class="form-control search-input" id="searchInput" placeholder="Search applications...">
                                        </div>
                                        <select class="form-select" id="statusFilter" style="min-width: 120px;">
                                            <option value="all">All Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="reviewed">Reviewed</option>
                                            <option value="interview">Interview</option>
                                            <option value="accepted">Accepted</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="applicationsContainer">
                                <!-- Applications will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Saved Jobs Tab -->
                    <div class="tab-pane fade" id="saved" role="tabpanel">
                        <div class="p-4">
                            <div class="d-flex align-items-center mb-4">
                                <h4 class="mb-0">
                                    <i class="fas fa-heart heart-icon me-2"></i>
                                    Saved Jobs (<span id="savedJobsCount">3</span>)
                                </h4>
                            </div>

                            <div id="savedJobsContainer">
                                <!-- Saved jobs will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel">Application Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalContent">
                        <!-- Content will be populated by JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateApplicationBtn">Update Application</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mock data - Blue Collar Jobs
        const applications = [
            {
                id: 1,
                company: 'Metro Construction LLC',
                position: 'Construction Foreman',
                status: 'interview',
                appliedDate: '2024-01-15',
                location: 'Houston, TX',
                salary: '$55,000 - $70,000',
                description: 'Lead construction teams on residential and commercial projects. Oversee daily operations, ensure safety compliance, and manage project timelines.',
                requirements: ['5+ years construction experience', 'OSHA certification', 'Team leadership experience', 'Valid driver\'s license'],
                benefits: ['Health insurance', 'Dental coverage', 'Retirement plan', 'Paid time off', 'Tool allowance'],
                contactPerson: 'Mike Rodriguez',
                contactEmail: 'mike.rodriguez@metroconstruction.com',
                applicationNotes: 'Interview scheduled for January 25th at 10:00 AM'
            },
            {
                id: 2,
                company: 'City Electric Services',
                position: 'Journeyman Electrician',
                status: 'reviewed',
                appliedDate: '2024-01-12',
                location: 'Phoenix, AZ',
                salary: '$60,000 - $75,000',
                description: 'Install, maintain, and repair electrical systems in residential and commercial buildings. Work with electrical blueprints and follow safety protocols.',
                requirements: ['Journeyman electrician license', '3+ years experience', 'Knowledge of electrical codes', 'Physical ability to work in various conditions'],
                benefits: ['Medical insurance', 'Vision coverage', '401(k) matching', 'Company vehicle', 'Overtime opportunities'],
                contactPerson: 'Sarah Chen',
                contactEmail: 'sarah.chen@cityelectric.com',
                applicationNotes: 'Application under review by hiring manager'
            },
            {
                id: 3,
                company: 'Ace Plumbing Solutions',
                position: 'Plumber',
                status: 'pending',
                appliedDate: '2024-01-18',
                location: 'Denver, CO',
                salary: '$50,000 - $65,000',
                description: 'Perform plumbing installations, repairs, and maintenance for residential and light commercial properties. Respond to emergency service calls.',
                requirements: ['Plumbing license or certification', '2+ years experience', 'Own basic tools', 'Clean driving record'],
                benefits: ['Health insurance', 'Performance bonuses', 'Training opportunities', 'Company uniforms', 'Holiday pay'],
                contactPerson: 'Tom Wilson',
                contactEmail: 'tom.wilson@aceplumbing.com',
                applicationNotes: 'Application submitted, awaiting initial review'
            },
            {
                id: 4,
                company: 'Industrial Maintenance Corp',
                position: 'Maintenance Technician',
                status: 'rejected',
                appliedDate: '2024-01-08',
                location: 'Detroit, MI',
                salary: '$45,000 - $58,000',
                description: 'Maintain and repair industrial equipment, HVAC systems, and facility infrastructure. Perform preventive maintenance and troubleshooting.',
                requirements: ['Technical certification preferred', 'Mechanical aptitude', 'Experience with hand tools', 'Ability to read blueprints'],
                benefits: ['Medical coverage', 'Life insurance', 'Shift differential', 'Safety equipment provided'],
                contactPerson: 'Jennifer Davis',
                contactEmail: 'jennifer.davis@industrialmaint.com',
                applicationNotes: 'Position filled by internal candidate'
            }
        ];

        const savedJobs = [
            {
                id: 1,
                company: 'Highway Construction Inc',
                position: 'Heavy Equipment Operator',
                location: 'Dallas, TX',
                salary: '$55,000 - $68,000',
                postedDate: '2024-01-20',
                type: 'Full-time',
                description: 'Operate bulldozers, excavators, and other heavy machinery for road construction projects.'
            },
            {
                id: 2,
                company: 'Prime Welding Services',
                position: 'Certified Welder',
                location: 'Oklahoma City, OK',
                salary: '$52,000 - $72,000',
                postedDate: '2024-01-19',
                type: 'Full-time',
                description: 'Perform various welding techniques on structural steel and pipeline projects.'
            },
            {
                id: 3,
                company: 'Master Carpentry Co',
                position: 'Finish Carpenter',
                location: 'Austin, TX',
                salary: '$48,000 - $62,000',
                postedDate: '2024-01-17',
                type: 'Full-time',
                description: 'Install trim, cabinets, and custom woodwork for high-end residential projects.'
            }
        ];

        // Utility functions
        function getStatusIcon(status) {
            const icons = {
                pending: 'fas fa-clock',
                reviewed: 'fas fa-file-alt',
                interview: 'fas fa-chart-line',
                accepted: 'fas fa-check-circle',
                rejected: 'fas fa-times-circle'
            };
            return icons[status] || 'fas fa-clock';
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString();
        }

        function showApplicationDetails(applicationId) {
            const application = applications.find(app => app.id === applicationId);
            if (!application) return;

            const modalContent = document.getElementById('modalContent');
            modalContent.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="modal-detail-item">
                            <div class="detail-label">Position</div>
                            <div class="detail-value">${application.position}</div>
                        </div>
                        <div class="modal-detail-item">
                            <div class="detail-label">Company</div>
                            <div class="detail-value">${application.company}</div>
                        </div>
                        <div class="modal-detail-item">
                            <div class="detail-label">Location</div>
                            <div class="detail-value">${application.location}</div>
                        </div>
                        <div class="modal-detail-item">
                            <div class="detail-label">Salary Range</div>
                            <div class="detail-value">${application.salary}</div>
                        </div>
                        <div class="modal-detail-item">
                            <div class="detail-label">Application Date</div>
                            <div class="detail-value">${formatDate(application.appliedDate)}</div>
                        </div>
                        <div class="modal-detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                <span class="status-badge status-${application.status}">
                                    <i class="${getStatusIcon(application.status)}"></i>
                                    ${application.status.charAt(0).toUpperCase() + application.status.slice(1)}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-detail-item">
                            <div class="detail-label">Contact Person</div>
                            <div class="detail-value">${application.contactPerson}</div>
                        </div>
                        <div class="modal-detail-item">
                            <div class="detail-label">Contact Email</div>
                            <div class="detail-value">
                                <a href="mailto:${application.contactEmail}">${application.contactEmail}</a>
                            </div>
                        </div>
                        <div class="modal-detail-item">
                            <div class="detail-label">Application Notes</div>
                            <div class="detail-value">${application.applicationNotes}</div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="modal-detail-item">
                            <div class="detail-label">Job Description</div>
                            <div class="detail-value">${application.description}</div>
                        </div>
                        <div class="modal-detail-item">
                            <div class="detail-label">Requirements</div>
                            <div class="detail-value">
                                <ul class="mb-0">
                                    ${application.requirements.map(req => `<li>${req}</li>`).join('')}
                                </ul>
                            </div>
                        </div>
                        <div class="modal-detail-item">
                            <div class="detail-label">Benefits</div>
                            <div class="detail-value">
                                <ul class="mb-0">
                                    ${application.benefits.map(benefit => `<li>${benefit}</li>`).join('')}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('viewDetailsModal'));
            modal.show();
        }

        // Render functions
        function renderApplications(applicationsToRender = applications) {
            const container = document.getElementById('applicationsContainer');
            
            if (applicationsToRender.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No applications found matching your criteria.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = applicationsToRender.map(app => `
                <div class="application-card">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-8">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2 mb-2">
                                <h5 class="job-title mb-0">${app.position}</h5>
                                <span class="status-badge status-${app.status}">
                                    <i class="${getStatusIcon(app.status)}"></i>
                                    ${app.status.charAt(0).toUpperCase() + app.status.slice(1)}
                                </span>
                            </div>
                            <p class="company-name mb-2">${app.company}</p>
                            <div class="job-details d-flex flex-column flex-md-row gap-2">
                                <span><i class="fas fa-map-marker-alt me-1"></i>${app.location}</span>
                                <span><i class="fas fa-calendar me-1"></i>Applied: ${formatDate(app.appliedDate)}</span>
                                ${app.salary ? `<span><i class="fas fa-dollar-sign me-1"></i>${app.salary}</span>` : ''}
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <button class="btn btn-outline-primary btn-sm" onclick="showApplicationDetails(${app.id})">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function renderSavedJobs() {
            const container = document.getElementById('savedJobsContainer');
            
            container.innerHTML = savedJobs.map(job => `
                <div class="job-card">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-8">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2 mb-2">
                                <h5 class="job-title mb-0">${job.position}</h5>
                                <span class="badge bg-secondary">${job.type}</span>
                            </div>
                            <p class="company-name mb-2">${job.company}</p>
                            <div class="job-details d-flex flex-column flex-md-row gap-2">
                                <span><i class="fas fa-map-marker-alt me-1"></i>${job.location}</span>
                                <span><i class="fas fa-dollar-sign me-1"></i>${job.salary}</span>
                                <span><i class="fas fa-calendar me-1"></i>Posted: ${formatDate(job.postedDate)}</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <div class="d-flex gap-2 justify-content-lg-end">
                                <button class="btn btn-primary btn-sm">Apply Now</button>
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Filter and search functionality
        function filterApplications() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;

            const filtered = applications.filter(app => {
                const matchesSearch = app.company.toLowerCase().includes(searchTerm) ||
                                    app.position.toLowerCase().includes(searchTerm);
                const matchesStatus = statusFilter === 'all' || app.status === statusFilter;
                return matchesSearch && matchesStatus;
            });

            renderApplications(filtered);
        }

        // Update statistics
        function updateStats() {
            const stats = {
                total: applications.length,
                pending: applications.filter(app => app.status === 'pending').length,
                interview: applications.filter(app => app.status === 'interview').length,
                accepted: applications.filter(app => app.status === 'accepted').length
            };

            document.getElementById('totalApplications').textContent = stats.total;
            document.getElementById('pendingApplications').textContent = stats.pending;
            document.getElementById('interviewApplications').textContent = stats.interview;
            document.getElementById('acceptedApplications').textContent = stats.accepted;
            document.getElementById('savedJobsCount').textContent = savedJobs.length;
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            renderApplications();
            renderSavedJobs();

            // Add event listeners
            document.getElementById('searchInput').addEventListener('input', filterApplications);
            document.getElementById('statusFilter').addEventListener('change', filterApplications);
        });
    </script>
</body>
</html>