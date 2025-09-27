    <!-- Notifications Dropdown -->
    <div class="nav-dropdown">
        <button class="nav-icon" onclick="toggleDropdown('notificationsDropdown')">
            <i class="bi bi-bell"></i>
            @php
                $unreadCount = isset($notifications) ? $notifications->where('is_read', 0)->count() : 0;
                $suspendedCount = isset($suspendedNotifications) ? $suspendedNotifications->count() : 0;
                $totalCount = $unreadCount + $suspendedCount;
            @endphp
            @if ($totalCount > 0)
                <span class="nav-badge" id="notificationsBadge">{{ $totalCount }}</span>
            @endif
        </button>



        <div class="dropdown-menu shadow-sm border-0" id="notificationsDropdown"
            style="min-width: 320px; max-height: 400px; overflow-y: auto;">

            <div class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                <h6 class="mb-0">Notifications</h6>
                <button class="mark-all-read btn btn-sm btn-link text-primary p-0" onclick="markAllAsRead()">
                    Mark all as read
                </button>
            </div>

            <div class="dropdown-content p-2">
                {{-- Regular Notifications --}}
                @if (isset($notifications) && count($notifications) > 0)
                    @foreach ($notifications as $note)
                        <div class="notification-item d-flex align-items-start gap-2 p-2 mb-2 rounded hover-shadow {{ !$note->is_read ? 'unread' : '' }}"
                            style="cursor: pointer;" data-id="{{ $note->id }}" data-note-id="{{ $note->id }}"
                            onclick="markAsRead({{ $note->id }})" data-bs-toggle="modal"
                            data-bs-target="#viewNotificationModal-{{ $note->id }}">

                            {{-- Icon --}}
                            <div class="notification-icon flex-shrink-0">
                                @if ($note->priority === 'urgent' && $note->target_audience === 'applicants')
                                    <i class="bi bi-shield-fill-check text-success fs-5"></i>
                                @elseif ($note->priority)
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px;">
                                        <img src="{{ asset('img/logo.png') }}" alt="Admin Logo"
                                            style="width: 20px; height: 20px; border-radius: 50%; background-color: #0d6efd;">
                                    </div>
                                @else
                                    <i class="bi bi-bell-fill text-primary fs-5"></i>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="notification-content flex-grow-1">
                                <div class="notification-title fw-semibold text-dark mb-1">
                                    {{ $note->title }}
                                </div>
                                <div class="notification-message text-muted small mb-1" style="line-height: 1.2;">
                                    {{ \Illuminate\Support\Str::limit($note->content, 60, '...') }}
                                </div>
                                <div class="notification-time text-muted small">
                                    {{ $note->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="notification-item text-center text-muted p-3">
                        No new notifications
                    </div>
                @endif

                {{-- Suspended Notifications --}}
                @if ($isSuspended)
                    <div
                        class="notification-item d-flex align-items-start gap-2 p-2 mb-2 rounded border border-danger bg-light">
                        <div class="notification-icon flex-shrink-0">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                        </div>
                        <div class="notification-content flex-grow-1">
                            <div class="notification-title fw-semibold text-dark mb-1">
                                {{ $suspendedApplicant->personal_info->first_name ?? 'Unknown' }}
                                {{ $suspendedApplicant->personal_info->last_name ?? '' }}
                            </div>
                            <div class="notification-message text-muted small mb-1" style="line-height:1.3;">
                                Suspended due to:
                                @if ($suspension->reason == 'multiple_user_reports')
                                    <span class="text-danger fw-semibold">Multiple User Reports</span>
                                @elseif ($suspension->reason == 'pending_investigation')
                                    <span class="text-danger fw-semibold">Pending Investigation</span>
                                @elseif ($suspension->reason == 'suspicious_activity')
                                    <span class="text-danger fw-semibold">Suspicious Activity</span>
                                @elseif ($suspension->reason == 'other')
                                    <span class="text-danger fw-semibold">Other:
                                        {{ $suspension->other_reason }}</span>
                                @endif
                            </div>

                            <div class="notification-restriction text-danger small fw-semibold mb-1">
                                You cannot apply for jobs for
                                {{ $suspension->suspension_duration }}
                                {{ $suspension->suspension_duration == 1 ? 'day' : 'days' }}.
                            </div>

                            <div class="notification-time text-muted small">
                                Applies until:
                                {{ $suspension->created_at->addDays($suspension->suspension_duration)->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                @endif

            </div>


            <div class="dropdown-footer border-top p-2 text-center">
                <a href="#" class="view-all-link text-primary small text-decoration-none" data-bs-toggle="modal"
                    data-bs-target="#viewAllNotificationsModal">
                    View All Notifications
                </a>
            </div>

            {{-- View All Notifications Modal --}}
            <div class="modal fade" id="viewAllNotificationsModal" tabindex="-1" aria-hidden="true"
                data-bs-backdrop="false">
                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content rounded-3 shadow">
                        <div class="modal-header">
                            <h5 class="modal-title">All Notifications</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @forelse ($notifications as $note)
                                <div class="border-bottom p-2 mb-2 {{ !$note->is_read ? 'fw-bold' : '' }}"
                                    style="cursor: pointer;" data-bs-toggle="modal"
                                    data-bs-target="#viewNotificationModal-{{ $note->id }}">
                                    <h6>{{ $note->title }}</h6>
                                    <p class="mb-1">{{ $note->content }}</p>
                                    <small class="text-muted">
                                        {{ $note->created_at->format('M d, Y h:i A') }}
                                    </small>
                                </div>

                                {{-- Individual Notification Modal --}}
                                <div class="modal fade" id="viewNotificationModal-{{ $note->id }}" tabindex="-1"
                                    aria-hidden="true" data-bs-backdrop="false">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-3 shadow">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $note->title }}</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ $note->content }}</p>
                                                <small class="text-muted">
                                                    {{ $note->created_at->format('M d, Y h:i A') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-muted">No notifications available</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- JS for marking as read --}}
    <script>
        /**
         * Marks a single notification as read and removes the 'unread' class on success.
         */
        async function markAsRead(id) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const res = await fetch(`notifications/${id}/read`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                if (!res.ok) {
                    console.error('markAsRead failed, status:', res.status);
                    return;
                }

                const data = await res.json();
                if (data.success) {
                    // remove unread highlight
                    const el = document.querySelector(`[data-note-id="${id}"]`) || document.querySelector(
                        `[data-id="${id}"]`);
                    if (el) el.classList.remove('unread');

                    // 🔥 update badge count
                    const badge = document.querySelector('#notificationsBadge');
                    if (badge) {
                        let current = parseInt(badge.innerText) || 0;
                        if (current > 0) {
                            badge.innerText = current - 1;
                            if (current - 1 === 0) {
                                badge.remove(); // hide badge if 0
                            }
                        }
                    }
                }
            } catch (err) {
                console.error('Error in markAsRead:', err);
            }
        }


        async function markAllAsRead() {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const res = await fetch(`notifications/mark-all-read`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                if (!res.ok) {
                    console.error('markAllAsRead failed, status:', res.status);
                    return;
                }

                const data = await res.json();
                if (data.success) {
                    // 🔹 Remove "unread" class from all items
                    document.querySelectorAll('.notification-item.unread').forEach(el => {
                        el.classList.remove('unread');
                    });

                    // 🔹 Reset badge count
                    const badge = document.querySelector('#notificationsBadge');
                    if (badge) {
                        badge.remove(); // hide badge since all are read
                    }
                }
            } catch (err) {
                console.error('Error in markAllAsRead:', err);
            }
        }
    </script>


    <style>
        /* Hover shadow effect */
        .hover-shadow:hover {
            background-color: #f8f9fa;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease-in-out;
        }

        /* Remove underline for links inside notifications */
        .notification-content a {
            text-decoration: none;
            color: inherit;
        }

        /* Unread highlight */
        .notification-item.unread {
            background-color: #e9f5ff;
        }
    </style>
