<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESDA Officers - Certification Portal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 24px 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
            letter-spacing: -0.025em;
        }

        .header-subtitle {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: 16px;
        }

        .header-btn {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fecaca;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            opacity: 0.8;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        /* Main Content */
        .main-content {
            padding: 32px 0;
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            letter-spacing: -0.025em;
        }

        .page-description {
            color: #64748b;
            font-size: 16px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .stat-icon.pending { background: #fef3c7; color: #d97706; }
        .stat-icon.approved { background: #dcfce7; color: #16a34a; }
        .stat-icon.total { background: #dbeafe; color: #2563eb; }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .stat-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .stat-change {
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .stat-change.positive { color: #16a34a; }
        .stat-change.neutral { color: #64748b; }

        /* Main Card */
        .main-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 24px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .card-description {
            color: #64748b;
            font-size: 14px;
        }

        .card-content {
            padding: 24px;
        }

        /* Action Buttons */
        .action-section {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .table th {
            background: #f8fafc;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
        }

        .table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .table tr:hover {
            background: #f8fafc;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-approved { background: #dcfce7; color: #166534; }
        .status-review { background: #fef2f2; color: #991b1b; }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-header {
            padding: 24px 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #64748b;
            padding: 4px;
            border-radius: 4px;
        }

        .close-btn:hover {
            background: #f1f5f9;
        }

        .modal-body {
            padding: 24px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: white;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            margin-top: 24px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0 16px;
            }

            .header-content {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }

            .user-section {
                flex-direction: column;
                gap: 12px;
            }

            .header-actions {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-section {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }

            .table-container {
                margin: 0 -24px;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .card-content {
                padding: 16px;
            }
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f4f6;
            border-top: 2px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo">T</div>
                    <div>
                        <div class="header-title">TESDA Officers Portal</div>
                        <div class="header-subtitle">Certification Management System</div>
                    </div>
                </div>
                <div class="user-section">
                    <div class="user-info">
                        <div class="user-name">Admin Officer</div>
                        <div class="user-role">Certification Specialist</div>
                    </div>
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="header-actions">
                        <button class="header-btn" onclick="openModal('settingsModal')" title="Settings">
                            <i class="fas fa-cog"></i>
                        </button>

                        <form action="{{ route('tesda-officer.logout.store') }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to logout?');">
                            @csrf
                            <button type="submit" class="header-btn logout-btn" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Certification Dashboard</h1>
                <p class="page-description">Manage and validate technical education certifications</p>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">12</div>
                    <div class="stat-label">Pending Review</div>
                    <div class="stat-change positive">+3 from yesterday</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon approved">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number">84</div>
                    <div class="stat-label">Approved This Month</div>
                    <div class="stat-change positive">+12% from last month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon total">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="stat-number">156</div>
                    <div class="stat-label">Total Processed</div>
                    <div class="stat-change neutral">This quarter</div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="main-card">
                <div class="card-header">
                    <div class="card-title">Certification Applications</div>
                    <div class="card-description">Review and validate submitted certification documents</div>
                </div>
                <div class="card-content">
                    <!-- Action Buttons -->
                    <div class="action-section">
                        <button class="btn btn-primary" onclick="openModal('reviewModal')">
                            <i class="fas fa-eye"></i> Review Application
                        </button>
                        <button class="btn btn-secondary" onclick="openModal('verificationModal')">
                            <i class="fas fa-shield-alt"></i> Certificate Verification
                        </button>
                        <button class="btn btn-secondary" onclick="generateReport()">
                            <i class="fas fa-download"></i> Export Report
                        </button>
                    </div>

                    <!-- Applications Table -->
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Application ID</th>
                                    <th>Applicant Name</th>
                                    <th>Program</th>
                                    <th>Submitted</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>APP-2024-001</strong></td>
                                    <td>Juan Carlos Santos</td>
                                    <td>Computer Systems Servicing NC II</td>
                                    <td>Aug 20, 2024</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>
                                        <button class="btn btn-primary" style="padding: 8px 12px; font-size: 12px;" onclick="reviewApplication('APP-2024-001')">
                                            Review
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>APP-2024-002</strong></td>
                                    <td>Maria Elena Rodriguez</td>
                                    <td>Cookery NC II</td>
                                    <td>Aug 19, 2024</td>
                                    <td><span class="status-badge status-approved">Approved</span></td>
                                    <td>
                                        <button class="btn btn-secondary" style="padding: 8px 12px; font-size: 12px;" onclick="viewDetails('APP-2024-002')">
                                            View
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>APP-2024-003</strong></td>
                                    <td>Robert Chen Lim</td>
                                    <td>Automotive Servicing NC II</td>
                                    <td>Aug 18, 2024</td>
                                    <td><span class="status-badge status-review">Review</span></td>
                                    <td>
                                        <button class="btn btn-primary" style="padding: 8px 12px; font-size: 12px;" onclick="reviewApplication('APP-2024-003')">
                                            Review
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>APP-2024-004</strong></td>
                                    <td>Ana Marie Dela Cruz</td>
                                    <td>Electrical Installation NC II</td>
                                    <td>Aug 17, 2024</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>
                                        <button class="btn btn-primary" style="padding: 8px 12px; font-size: 12px;" onclick="reviewApplication('APP-2024-004')">
                                            Review
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Application Modal -->
    <div class="modal" id="reviewModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Review Certification Application</h3>
                <button class="close-btn" onclick="closeModal('reviewModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="reviewForm">
                    <div class="form-group">
                        <label class="form-label">Application ID</label>
                        <input type="text" class="form-input" id="appId" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Review Status</label>
                        <select class="form-select" required>
                            <option value="">Select review status</option>
                            <option value="approved">Approve Certification</option>
                            <option value="rejected">Reject Application</option>
                            <option value="needs-revision">Request Revision</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Officer Comments</label>
                        <textarea class="form-textarea" placeholder="Add your review comments and recommendations..." required></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('reviewModal')">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Certificate Verification Modal -->
    <div class="modal" id="verificationModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Certificate Verification</h3>
                <button class="close-btn" onclick="closeModal('verificationModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="verificationForm">
                    <div class="form-group">
                        <label class="form-label">Certificate Number</label>
                        <input type="text" class="form-input" placeholder="Enter certificate number to verify" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Verification Type</label>
                        <select class="form-select" required>
                            <option value="">Select verification type</option>
                            <option value="authenticity">Authenticity Check</option>
                            <option value="status">Status Verification</option>
                            <option value="duplicate">Duplicate Request</option>
                            <option value="replacement">Replacement Certificate</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Requesting Entity</label>
                        <input type="text" class="form-input" placeholder="Organization or individual requesting verification" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Verification Notes</label>
                        <textarea class="form-textarea" placeholder="Add verification details and purpose..." required></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('verificationModal')">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shield-alt"></i> Verify Certificate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div class="modal" id="settingsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">System Settings</h3>
                <button class="close-btn" onclick="closeModal('settingsModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="settingsForm">
                    <h4 style="color: #374151; margin-bottom: 16px; font-size: 16px; font-weight: 600;">Account Settings</h4>
                    
                    <div class="form-group">
                        <label class="form-label">Display Name</label>
                        <input type="text" class="form-input" value="Admin Officer" required>
                    </div>
                    
                    <!-- <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input" value="admin@tesda.gov.ph" required>
                    </div> -->
                    
                    <!-- <div class="form-group">
                        <label class="form-label">Officer Position</label>
                        <select class="form-select" required>
                            <option value="certification-specialist" selected>Certification Specialist</option>
                            <option value="senior-officer">Senior Officer</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div> -->

                    <hr style="margin: 24px 0; border: none; border-top: 1px solid #e5e7eb;">
                    
                    <h4 style="color: #374151; margin-bottom: 16px; font-size: 16px; font-weight: 600;">System Preferences</h4>
                    
                    <div class="form-group">
                        <label class="form-label">Default Items Per Page</label>
                        <select class="form-select">
                            <option value="10" selected>10 items</option>
                            <option value="25">25 items</option>
                            <option value="50">50 items</option>
                        </select>
                    </div>
                    
                    <!-- <div class="form-group">
                        <label class="form-label">Email Notifications</label>
                        <select class="form-select">
                            <option value="all" selected>All notifications</option>
                            <option value="important">Important only</option>
                            <option value="none">Disabled</option>
                        </select>
                    </div> -->

                    <div class="form-group">
                        <label class="form-label">Auto-refresh Dashboard</label>
                        <select class="form-select">
                            <option value="30" selected>Every 30 seconds</option>
                            <option value="60">Every 1 minute</option>
                            <option value="300">Every 5 minutes</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('settingsModal')">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Application review functionality
        function reviewApplication(appId) {
            document.getElementById('appId').value = appId;
            openModal('reviewModal');
        }

        function viewDetails(appId) {
            alert(`Viewing details for application: ${appId}`);
        }

        // Generate report functionality
        function generateReport() {
            const btn = event.target;
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<span class="spinner"></span> Generating...';
            btn.classList.add('loading');
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('loading');
                alert('Report generated successfully!');
            }, 2000);
        }

        // Form submissions
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="spinner"></span> Processing...';
            
            setTimeout(() => {
                alert('Review submitted successfully!');
                closeModal('reviewModal');
                btn.innerHTML = '<i class="fas fa-check"></i> Submit Review';
                updateTableStatus();
            }, 1500);
        });

        // // Settings and logout functionality
        // function logout() {
        //     if (confirm('Are you sure you want to logout?')) {
        //         // Add logout animation
        //         document.body.style.opacity = '0.5';
        //         setTimeout(() => {
        //             alert('Logout successful. Redirecting to login page...');
        //             // In real implementation, redirect to login page
        //             // window.location.href = '/login';
        //             document.body.style.opacity = '1';
        //         }, 1000);
        //     }
        // }

        document.getElementById('verificationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="spinner"></span> Verifying...';
            
            setTimeout(() => {
                alert('Certificate verification completed successfully!');
                closeModal('verificationModal');
                btn.innerHTML = '<i class="fas fa-shield-alt"></i> Verify Certificate';
            }, 1500);
        });

        document.getElementById('settingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="spinner"></span> Saving...';
            
            setTimeout(() => {
                alert('Settings saved successfully!');
                closeModal('settingsModal');
                btn.innerHTML = '<i class="fas fa-save"></i> Save Settings';
            }, 1500);
        });

        // Update table status after review
        function updateTableStatus() {
            const rows = document.querySelectorAll('.table tbody tr');
            if (rows.length > 0) {
                const firstPendingRow = Array.from(rows).find(row => 
                    row.querySelector('.status-pending')
                );
                if (firstPendingRow) {
                    const statusCell = firstPendingRow.querySelector('.status-badge');
                    statusCell.textContent = 'Approved';
                    statusCell.className = 'status-badge status-approved';
                }
            }
        }

        // Close modals on outside click
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('TESDA Certification Portal loaded');
        });
    </script>
</body>
</html>