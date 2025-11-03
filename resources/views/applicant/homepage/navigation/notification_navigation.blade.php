<!-- Notifications Dropdown -->
<div class="nav-dropdown">
    <button class="nav-icon" onclick="toggleDropdown('notificationsDropdown')" title="notification">
        <i class="bi bi-bell"></i>

        @php
            $unreadCount = isset($notifications) ? $notifications->where('is_read', 0)->count() : 0;
            $retrieveUnreadCount = isset($notificationRetrieve)
                ? $notificationRetrieve->where('is_read', 0)->count()
                : 0;
            $suspendedCount = isset($suspendedNotifications) ? $suspendedNotifications->count() : 0;
            $totalCount = $unreadCount + $retrieveUnreadCount + $suspendedCount;
        @endphp

        @if ($totalCount > 0)
            <span class="nav-badge" id="notificationsBadge">{{ $totalCount }}</span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div class="dropdown-menu shadow-sm border-0" id="notificationsDropdown"
        style="min-width: 320px; max-height: 400px; overflow-y: auto;">

        <div class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
            <h6 class="mb-0">Notifications</h6>
            <button class="mark-all-read btn btn-sm btn-link text-primary p-0" onclick="markAllAsRead()">
                Mark all as read
            </button>
        </div>

        <div class="dropdown-content p-2">
            {{-- REGULAR NOTIFICATIONS --}}
            @if (isset($notifications) && count($notifications) > 0)
                @foreach ($notifications as $note)
                    <div class="notification-item d-flex align-items-start gap-2 p-2 mb-2 rounded hover-shadow {{ !$note->is_read ? 'unread' : '' }}"
                        style="cursor:pointer;" data-bs-toggle="modal"
                        data-bs-target="#viewNotificationModal-{{ $note->id }}"
                        onclick="markAsReadNotification({{ $note->id }})">

                        <div class="notification-icon flex-shrink-0">
                            <i class="bi bi-bell-fill text-primary fs-5"></i>
                        </div>
                        <div class="notification-content flex-grow-1">
                            <div class="notification-title fw-semibold text-dark mb-1">
                                {{ $note->title ?? 'Untitled Notification' }}
                            </div>
                            <div class="notification-message text-muted small mb-1">
                                {{ Str::limit($note->message ?? ($note->content ?? 'No message available'), 60, '...') }}
                            </div>
                            <div class="notification-time text-muted small">
                                {{ $note->created_at->diffForHumans() }}
                            </div>
                        </div>


                    </div>

                    <!--  Modal for Notification (No Backdrop) -->
                    <div class="modal fade" id="viewNotificationModal-{{ $note->id }}" tabindex="-1"
                        aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow border-0">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title fw-semibold">{{ $note->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">
                                        {{ $note->message ?? ($note->content ?? 'No details available.') }}</p>
                                    <small class="text-secondary">
                                        Received {{ $note->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- RETRIEVED NOTIFICATIONS --}}
            @if (isset($notificationRetrieve) && count($notificationRetrieve) > 0)
                @foreach ($notificationRetrieve as $note)
                    <div id="notification-{{ $note->id }}"
                        class="notification-item d-flex align-items-start gap-2 p-2 mb-2 rounded hover-shadow {{ !$note->is_read ? 'unread' : '' }}"
                        style="cursor:default; position: relative;">

                        <div class="notification-icon flex-shrink-0">
                            <i class="bi bi-info-circle-fill text-success fs-5"></i>
                        </div>

                        <!-- Clickable area (shows modal + mark as read) -->
                        <div class="notification-content flex-grow-1" style="cursor:pointer;" data-bs-toggle="modal"
                            data-bs-target="#viewRetrieveModal-{{ $note->id }}"
                            onclick="markAsReadRetrieve({{ $note->id }})">

                            <div class="notification-title fw-semibold text-dark mb-1">
                                {{ $note->title ?? 'Retrieved Notification' }}
                            </div>

                            <!-- Short preview (limit + remove HTML tags) -->
                            <div class="notification-message text-muted small mb-1">
                                {{ Str::limit(strip_tags($note->message ?? 'No message available'), 120, '...') }}
                            </div>

                            <div class="notification-time text-muted small">
                                {{ $note->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <!--  Delete Button -->
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 me-1 mt-1"
                            style="font-size: 14px;" title="Delete notification"
                            onclick="event.stopPropagation(); deleteNotification({{ $note->id }})">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <!-- Full Notification Modal (No Backdrop, Scrollable Body) -->
                    <div class="modal fade" id="viewRetrieveModal-{{ $note->id }}" tabindex="-1"
                        aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content rounded-4 shadow border-0">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title fw-semibold">{{ $note->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!--  Scrollable Body for long text -->
                                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                    <p class="text-muted">{!! $note->message ?? 'No details available.' !!}</p>
                                    <small class="text-secondary d-block mt-3">
                                        Received {{ $note->created_at->diffForHumans() }}
                                    </small>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif


            {{-- No Notifications --}}
            @if (
                (!isset($notifications) || $notifications->isEmpty()) &&
                    (!isset($notificationRetrieve) || $notificationRetrieve->isEmpty()))
                <div class="notification-item text-center text-muted p-3">
                    No new notifications
                </div>
            @endif
        </div>

        <div class="dropdown-footer border-top p-2 text-center">
            <a href="#" class="view-all-link text-primary small text-decoration-none" data-bs-toggle="modal"
                data-bs-target="#viewAllNotificationsModal">
                View All Notifications
            </a>
        </div>

        <!--  View All Notifications Modal -->
        <div class="modal fade" id="viewAllNotificationsModal" tabindex="-1" aria-hidden="true"
            data-bs-backdrop="false">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content rounded-4 shadow-lg border-0">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title fw-semibold">
                            <i class="bi bi-bell-fill me-2"></i> All Notifications
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>


                </div>
            </div>
        </div>

    </div>
</div>

<!-- JS Handlers -->
<script>
    function deleteNotification(id) {
        if (!confirm('Are you sure you want to delete this notification?')) return;

        fetch(`/applicant/notifications/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notif = document.getElementById(`notification-${id}`);
                    if (notif) {
                        // Smooth fade-out animation
                        notif.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        notif.style.opacity = '0';
                        notif.style.transform = 'translateX(20px)';
                        setTimeout(() => notif.remove(), 300);
                    }

                    // Update notification badge
                    const badge = document.getElementById('notificationsBadge');
                    if (badge) {
                        let count = parseInt(badge.textContent) || 0;
                        count = Math.max(count - 1, 0);
                        if (count > 0) {
                            badge.textContent = count;
                        } else {
                            badge.remove();
                        }
                    }

                    // Check remaining notifications
                    setTimeout(() => {
                        const remaining = document.querySelectorAll('.notification-item').length;
                        if (remaining === 0) {
                            const dropdownContent = document.querySelector('.dropdown-content');
                            if (dropdownContent) {
                                dropdownContent.innerHTML = `
                            <div class="notification-item text-center text-muted p-3">
                                No new notifications
                            </div>`;
                            }
                        }
                    }, 350);

                    console.log('Notification deleted');
                } else {
                    alert('Failed to delete notification.');
                }
            })
            .catch(error => console.error('Error deleting notification:', error));
    }

    function markAsReadNotification(id) {
        fetch(`/notifications/mark-as-read/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    }

    function markAsReadRetrieve(id) {
        fetch(`/notifications/retrieve/mark-as-read/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    }
</script>


{{-- JS for marking as read --}}
<script>
    /**
     * Marks a single notification as read and removes the 'unread' class on success.
     */
    async function markAsReadRetrieve(id) {
        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const res = await fetch(`notifications/retrieve/${id}/read`, {
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

                // update badge count
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

    async function markAsReadNotification(id) {
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

                //  update badge count
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
                // Remove "unread" class from all items
                document.querySelectorAll('.notification-item.unread').forEach(el => {
                    el.classList.remove('unread');
                });

                //  Reset badge count
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
