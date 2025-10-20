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
                        <input type="text" class="search-input" placeholder="Search users..." id="userSearch">
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
                                            <h4>{{ $user['data']->addressCompany->company_name ?? 'N/A' }}
                                            </h4>
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

                                    @if ($user['type'] === 'applicant')
                                        <button type="button" class="action-btn btn-suspend"
                                            onclick="openSuspendModal(
            {{ $user['data']->id }}, 
            '{{ addslashes($user['data']->personal_info?->first_name ?? '') }}', 
            'applicant',
            {{ $user['reports_received'] ?? 0 }}
        )">
                                            <i class="fas fa-pause-circle"></i>
                                        </button>
                                    @elseif ($user['type'] === 'employer')
                                        <button type="button" class="action-btn btn-suspend"
                                            onclick="openSuspendModal(
            {{ $user['data']->id }}, 
            '{{ addslashes($user['data']->addressCompany?->company_name ?? '') }}', 
            'employer',
            {{ $user['reports_received'] ?? 0 }}
        )">
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
                                        data-bs-target="#confirmDeleteUserModal" data-user-id="{{ $user['data']->id }}"
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
                function openSuspendModal(userId, userName = '', userType = '', reportCount = 0) {
                    document.getElementById('suspendUserId').value = userId;
                    document.getElementById('suspendUserType').value = userType;

                    const infoDiv = document.getElementById('suspendUserInfo');
                    infoDiv.innerHTML = `
        ${userName ? `<p><strong>User:</strong> ${userName}</p>` : ''}
        <p><strong>Reports Received:</strong> ${reportCount}</p>
    `;

                    openModal('suspendUserModals');
                }
            </script>

            <!-- BAN USER MODAL -->
            <div id="banUserModal" class="modal-overlay"
                style="display: none; position: fixed; inset: 0; background: transparent; justify-content: center; align-items: center; z-index: 1050;">
                <div class="modal-content rounded shadow bg-white" style="max-width: 450px; width: 100%;">
                    <!-- Header -->
                    <div class="modal-header d-flex justify-content-between align-items-center border-bottom p-3">
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
