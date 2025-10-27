<div class="page-section" id="notifications-section">
    <div class="content-section">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">
                <i class="bi bi-bell me-2 text-primary"></i>Notifications
                @if ($unreadCount > 0)
                    <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                @endif
            </h3>
            <button class="btn btn-sm btn-outline-primary" onclick="markAllAsRead()">
                <i class="bi bi-check-all me-1"></i>Mark All as Read
            </button>
        </div>

        <!-- Notifications List -->
        <div class="notifications-container">
            @forelse ($allNotifications as $note)
                <div class="notification-item {{ $note->is_read ? '' : 'unread' }}"
                    onclick="openNotificationModal(
                        {{ $note->id }}, 
                        '{{ addslashes($note->title ?? 'No Title') }}', 
                        '{{ addslashes($note->message ?? ($note->content ?? '')) }}', 
                        '{{ $note->priority ?? 'normal' }}', 
                        '{{ $note->target_audience ?? ($note->type ?? 'general') }}', 
                        '{{ isset($note->publication_date) ? $note->publication_date : $note->created_at->format('Y-m-d') }}', 
                        '{{ $note->created_at->diffForHumans() }}', 
                        '{{ !empty($note->image) ? asset('storage/' . $note->image) : '' }}',
                        '{{ get_class($note) }}'
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

                        <div class="notification-footer">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ isset($note->publication_date) ? \Carbon\Carbon::parse($note->publication_date)->format('M d, Y') : $note->created_at->format('M d, Y') }}
                            </small>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>{{ $note->created_at->diffForHumans() }}
                            </small>
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

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="w-100">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div id="modalIcon" class="notification-icon-large"></div>
                        <div class="flex-grow-1">
                            <h5 class="modal-title fw-bold mb-2 text-dark" id="notificationModalLabel"></h5>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span id="modalPriorityBadge" class="badge badge-priority"></span>
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-people me-1"></i><span id="modalAudience"></span>
                                </span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="d-flex gap-3 text-muted small flex-wrap">
                        <span><i class="bi bi-calendar3 me-1"></i><span id="modalPublicationDate"></span></span>
                        <span><i class="bi bi-clock me-1"></i><span id="modalTime"></span></span>
                    </div>
                </div>
            </div>
            <div class="modal-body pt-3">
                <div id="modalContent" class="notification-full-content mb-3"></div>
                <div id="modalImageContainer" class="notification-modal-image" style="display: none;">
                    <img id="modalImage" src="" alt="Notification Image" class="img-fluid rounded-3 shadow-sm">
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Close
                </button>
                <button type="button" class="btn btn-primary" onclick="markAsRead()">
                    <i class="bi bi-check-circle me-1"></i>Mark as Read
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentNotificationId = null;
    let currentNotificationType = null;

    function openNotificationModal(id, title, content, priority, audience, publicationDate, timeAgo, imageUrl = '',
        modelType = '') {
        currentNotificationId = id;
        currentNotificationType = modelType;

        document.getElementById('notificationModalLabel').textContent = title;
        document.getElementById('modalContent').innerHTML = '<p>' + content + '</p>';

        const modalImageContainer = document.getElementById('modalImageContainer');
        const modalImage = document.getElementById('modalImage');

        if (imageUrl && imageUrl.trim() !== '') {
            modalImage.src = imageUrl;
            modalImageContainer.style.display = 'block';
        } else {
            modalImageContainer.style.display = 'none';
            modalImage.src = '';
        }

        const priorityBadge = document.getElementById('modalPriorityBadge');
        priorityBadge.textContent = priority.toUpperCase();
        priorityBadge.className = 'badge badge-priority priority-' + priority.toLowerCase();

        document.getElementById('modalAudience').textContent = audience.charAt(0).toUpperCase() + audience.slice(1);
        document.getElementById('modalPublicationDate').textContent = new Date(publicationDate).toLocaleDateString(
            'en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        document.getElementById('modalTime').textContent = timeAgo;

        const modalIcon = document.getElementById('modalIcon');
        let iconClass = '';
        let bgClass = '';

        switch (priority.toLowerCase()) {
            case 'urgent':
                iconClass = 'bi-exclamation-triangle-fill';
                bgClass = 'bg-urgent';
                break;
            case 'high':
                iconClass = 'bi-exclamation-circle-fill';
                bgClass = 'bg-high';
                break;
            case 'medium':
                iconClass = 'bi-info-circle-fill';
                bgClass = 'bg-medium';
                break;
            case 'low':
                iconClass = 'bi-check-circle-fill';
                bgClass = 'bg-low';
                break;
            default:
                iconClass = 'bi-megaphone-fill';
                bgClass = 'bg-primary';
        }

        modalIcon.className = 'notification-icon-large ' + bgClass;
        modalIcon.innerHTML = '<i class="bi ' + iconClass + ' text-white"></i>';

        const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
        modal.show();
    }

    function markAsRead() {
        if (currentNotificationId) {
            // Determine endpoint based on notification type
            let endpoint = currentNotificationType.includes('Announcement') ?
                `/announcements/${currentNotificationId}/mark-as-read` :
                `/notifications/${currentNotificationId}/mark-as-read`;

            fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('notificationModal')).hide();

                        const notificationItem = document.querySelector(
                            `[onclick*="openNotificationModal(${currentNotificationId}"]`);
                        if (notificationItem) {
                            notificationItem.classList.remove('unread');
                            const newBadge = notificationItem.querySelector('.badge.bg-primary');
                            if (newBadge) {
                                newBadge.remove();
                            }
                        }

                        // Update unread count
                        updateUnreadCount();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    function markAllAsRead() {
        fetch('/notifications/mark-all-as-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                    });
                    document.querySelectorAll('.badge.bg-primary').forEach(badge => {
                        badge.remove();
                    });

                    // Update unread count to 0
                    const unreadBadge = document.querySelector('.badge.bg-danger');
                    if (unreadBadge) {
                        unreadBadge.remove();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateUnreadCount() {
        const unreadItems = document.querySelectorAll('.notification-item.unread').length;
        const unreadBadge = document.querySelector('.badge.bg-danger');

        if (unreadItems > 0) {
            if (unreadBadge) {
                unreadBadge.textContent = unreadItems;
            }
        } else {
            if (unreadBadge) {
                unreadBadge.remove();
            }
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
