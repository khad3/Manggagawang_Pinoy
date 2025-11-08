<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TESDA Super Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- fav icon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />

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
                <button class="menu-item" onclick="showSection('users', this)">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
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
            @include('admin.homepage.section.dashboard_section')
            <!-- Officers Management Section -->
            @include('admin.homepage.section.officer_section')
            <!-- Announcements Section -->
            @include('admin.homepage.section.announcement_section')
            <!-- Reports & Analytics Section -->
            @include('admin.homepage.section.report_analytics')
            <!-- User Management Section -->
            @include('admin.homepage.section.user_management')

        </main>
    </div>


    <!---MODALS--->
    <!-- Add Officer Modal -->
    @include('admin.homepage.modal.add_officer_modal')
    <!-- Add Announcement Modal -->
    @include('admin.homepage.modal.add_announcement')
    <!-- Logout Confirmation Modal -->
    @include('admin.homepage.modal.logout')


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
