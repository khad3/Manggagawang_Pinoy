<div class="page-section" id="notifications-section">
    <div class="content-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">
                <i class="bi bi-bell me-2 text-primary"></i>Notifications
                @if ($unreadCount > 0)
                    <span class="badge bg-danger rounded-pill" id="unreadCountBadge">{{ $unreadCount }}</span>
                @endif
            </h3>
            <button class="btn btn-sm btn-outline-primary" onclick="markAllAsReadEmployer()">
                <i class="bi bi-check-all me-1"></i>Mark All as Read
            </button>
        </div>

        <!-- Notifications List -->
        <div class="notifications-container">
            @forelse ($allNotifications as $note)
                @php
                    $isAnnouncement = get_class($note) === 'App\\Models\\Announcement\\AnnouncementModel';
                    $notificationType = $isAnnouncement ? 'announcement' : 'employer';
                @endphp

                <div class="notification-item {{ $note->is_read ? '' : 'unread' }}"
                    data-notification-id="{{ $note->id }}" data-notification-type="{{ $notificationType }}"
                    onclick="openEmployerNotificationModal(
                {{ $note->id }},
                '{{ addslashes($note->title ?? 'No Title') }}',
                '{{ addslashes($note->message ?? ($note->content ?? '')) }}',
                '{{ $note->priority ?? 'normal' }}',
                '{{ $note->target_audience ?? ($note->type ?? 'general') }}',
                '{{ isset($note->publication_date) ? $note->publication_date : $note->created_at->format('Y-m-d') }}',
                '{{ $note->created_at->diffForHumans() }}',
                '{{ !empty($note->image) ? asset('storage/' . $note->image) : '' }}',
                '{{ $notificationType }}',
                {{ $note->is_read ? 'true' : 'false' }}
            )">

                    <div class="notification-icon bg-{{ getPriorityColor($note->priority ?? 'normal') }}">
                        <i class="bi bi-{{ getPriorityIcon($note->priority ?? 'normal') }} text-white"></i>
                    </div>

                    <div class="notification-content">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="notification-title mb-0">{{ $note->title ?? 'No Title' }}</h6>
                            <div class="d-flex gap-2">
                                @if (!$note->is_read)
                                    <span class="badge bg-primary">New</span>
                                @endif
                                <span
                                    class="badge badge-priority priority-{{ strtolower($note->priority ?? 'normal') }}">
                                    {{ ucfirst($note->priority ?? 'Normal') }}
                                </span>
                            </div>
                        </div>

                        <p class="notification-message mb-2">
                            {{ Str::limit($note->message ?? ($note->content ?? ''), 100) }}
                        </p>

                        @if (!empty($note->image))
                            <div class="notification-has-image">
                                <i class="bi bi-image-fill me-1"></i>
                                <span>Has Image</span>
                            </div>
                        @endif

                        <div class="notification-footer d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ isset($note->publication_date)
                                        ? \Carbon\Carbon::parse($note->publication_date)->format('M d, Y')
                                        : $note->created_at->format('M d, Y') }}
                                </small>
                                <small class="text-muted ms-2">
                                    <i class="bi bi-clock me-1"></i>{{ $note->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="event.stopPropagation(); deleteNotification({{ $note->id }})"
                                title="Delete Notification">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                    </div>

                    <div class="notification-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="text-center py-5">
                        <i class="bi bi-bell-slash display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No Notifications</h5>
                        <p class="text-muted">You're all caught up! Check back later for updates.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>

<!-- 📬 Notification Modal -->
<div class="modal fade" id="employerNotificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="w-100">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div id="employerModalIcon" class="notification-icon-large"></div>
                        <div class="flex-grow-1">
                            <h5 class="modal-title fw-bold mb-2 text-dark" id="notificationModalLabel"></h5>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span id="employerModalPriorityBadge" class="badge badge-priority"></span>
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-person-badge me-1"></i><span id="employerModalAudience"></span>
                                </span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="d-flex gap-3 text-muted small flex-wrap">
                        <span><i class="bi bi-calendar3 me-1"></i><span id="employerModalPublicationDate"></span></span>
                        <span><i class="bi bi-clock me-1"></i><span id="employerModalTime"></span></span>
                    </div>
                </div>
            </div>

            <div class="modal-body pt-3">
                <div id="employerModalContent" class="notification-full-content mb-3"></div>
                <div id="employerModalImageContainer" class="notification-modal-image" style="display: none;">
                    <img id="employerModalImage" src="" alt="Notification Image"
                        class="img-fluid rounded-3 shadow-sm">
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Close
                </button>
                <button type="button" class="btn btn-primary" id="markAsReadEmployerBtn"
                    onclick="markAsReadEmployerFromModal()">
                    <i class="bi bi-check-circle me-1"></i>Mark as Read
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteNotification(id) {
        if (!confirm('Are you sure you want to delete this notification?')) return;

        fetch(`/employer/notifications/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const notif = document.querySelector(`[data-notification-id="${id}"]`);
                    if (notif) notif.remove();
                } else {
                    alert(data.message || 'Failed to delete notification.');
                }
            })
            .catch(err => console.error(err));
    }
</script>



<script>
    let employerNotifId = null;
    let employerNotifType = null;
    let employerNotifRead = false;

    function openEmployerNotificationModal(id, title, content, priority, audience, date, timeAgo, imageUrl = '', type =
        'notification', isRead = false) {
        employerNotifId = id;
        employerNotifType = type;
        employerNotifRead = isRead;

        document.getElementById('notificationModalLabel').textContent = title;
        document.getElementById('employerModalContent').innerHTML = '<p>' + content + '</p>';

        const imgContainer = document.getElementById('employerModalImageContainer');
        const img = document.getElementById('employerModalImage');

        if (imageUrl) {
            img.src = imageUrl;
            imgContainer.style.display = 'block';
        } else {
            imgContainer.style.display = 'none';
        }

        document.getElementById('employerModalPriorityBadge').textContent = priority.toUpperCase();
        document.getElementById('employerModalPriorityBadge').className = 'badge badge-priority priority-' + priority
            .toLowerCase();

        document.getElementById('employerModalAudience').textContent = audience;
        document.getElementById('employerModalPublicationDate').textContent = new Date(date).toLocaleDateString(
            'en-US');
        document.getElementById('employerModalTime').textContent = timeAgo;

        // set icon
        const modalIcon = document.getElementById('employerModalIcon');
        let iconClass = '',
            bgClass = '';
        switch (priority.toLowerCase()) {
            case 'urgent':
                iconClass = 'bi-exclamation-triangle-fill';
                bgClass = 'bg-danger';
                break;
            case 'high':
                iconClass = 'bi-exclamation-circle-fill';
                bgClass = 'bg-warning';
                break;
            case 'medium':
                iconClass = 'bi-info-circle-fill';
                bgClass = 'bg-info';
                break;
            case 'low':
                iconClass = 'bi-check-circle-fill';
                bgClass = 'bg-success';
                break;
            default:
                iconClass = 'bi-bell-fill';
                bgClass = 'bg-primary';
        }
        modalIcon.className = 'notification-icon-large ' + bgClass;
        modalIcon.innerHTML = `<i class="bi ${iconClass} text-white"></i>`;

        document.getElementById('markAsReadEmployerBtn').style.display = isRead ? 'none' : 'inline-block';
        new bootstrap.Modal(document.getElementById('employerNotificationModal')).show();
    }

    async function markAsReadEmployerFromModal() {
        if (!employerNotifId || employerNotifRead) return;

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const endpoint = employerNotifType === 'announcement' ?
                `/employer/announcements/${employerNotifId}/read` :
                `/employer/notifications/${employerNotifId}/read`;

            console.log("Endpoint:", endpoint);

            const res = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            });

            const data = await res.json();
            console.log("Response:", data);

            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('employerNotificationModal'));
                if (modal) modal.hide();

                const el = document.querySelector(`.notification-item[data-notification-id="${employerNotifId}"]`);
                if (el) {
                    el.classList.remove('unread');
                    const badge = el.querySelector('.badge.bg-primary');
                    if (badge) badge.remove();
                }

                const unreadBadge = document.getElementById('unreadCountBadge');
                if (unreadBadge) {
                    let count = parseInt(unreadBadge.textContent) - 1;
                    if (count <= 0) unreadBadge.remove();
                    else unreadBadge.textContent = count;
                }
            } else {
                console.error("Server responded with error:", data.message);
                alert('Failed to mark announcement as read.');
            }
        } catch (err) {
            console.error("❌ JS Fetch error:", err);
            alert('Failed to mark notification as read.');
        }
    }


    async function markAllAsReadEmployer() {
        if (!confirm('Mark all notifications as read?')) return;

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch('/employer/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            });

            const data = await res.json();
            if (data.success) {
                document.querySelectorAll('.notification-item.unread').forEach(el => el.classList.remove('unread'));
                document.querySelectorAll('.badge.bg-primary').forEach(b => b.remove());
                const unreadBadge = document.getElementById('unreadCountBadge');
                if (unreadBadge) unreadBadge.remove();
            }
        } catch (err) {
            console.error('Error in markAllAsReadEmployer:', err);
        }
    }
</script>



<?php
function getPriorityColor($priority)
{
    switch (strtolower($priority)) {
        case 'urgent':
            return 'danger';
        case 'high':
            return 'warning';
        case 'medium':
            return 'info';
        case 'low':
            return 'success';
        default:
            return 'primary';
    }
}

function getPriorityIcon($priority)
{
    switch (strtolower($priority)) {
        case 'urgent':
            return 'exclamation-triangle-fill';
        case 'high':
            return 'exclamation-circle-fill';
        case 'medium':
            return 'info-circle-fill';
        case 'low':
            return 'check-circle-fill';
        default:
            return 'bell-fill';
    }
}
?>
