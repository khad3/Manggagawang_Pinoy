<div class="page-section" id="messages-section">
    <div class="content-section messages-wrapper">
        <!-- Header -->
        <div class="header-row">
            <div class="title">
                <div class="icon">💬</div>
                <div class="title-content">
                    <div class="title-main">
                        <h3>Messages</h3>
                        <span id="globalNotif"
                            class="notif-badge">{{ $retrieveMessages->where('is_read', false)->where('sender_type', 'applicant')->count() }}</span>
                    </div>
                    <div class="subtitle">{{ $retrievedApplicants->count() }} applicants</div>
                </div>
            </div>
            <div class="search-container">
                <div class="search-wrapper">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input id="search" placeholder="Search applicants..." aria-label="Search applicants">
                </div>
            </div>
        </div>

        <!-- Chat Layout -->
        <div class="chat-container">
            <!-- Mobile Header -->
            <div class="mobile-header">
                <button class="back-btn" id="backBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <polyline points="15,18 9,12 15,6"></polyline>
                    </svg>
                </button>
                <div class="mobile-title">Messages</div>
            </div>

            <!-- Left: Applicants List -->
            <div class="conversations-panel" id="conversationsPanel">
                <div class="panel-header">
                    <h4>Applicants</h4>

                </div>
                <div class="conversations-list" id="applicantsList">
                    @foreach ($retrievedApplicants as $applicant)
                        @php
                            $unreadCount = $retrieveMessages
                                ->where('applicant_id', $applicant->id)
                                ->where('is_read', false)
                                ->where('sender_type', 'applicant')
                                ->count();
                        @endphp
                        <div class="conversation-item" data-applicant-id="{{ $applicant->id }}"
                            data-name="{{ $applicant->personal_info->first_name ?? '' }} {{ $applicant->personal_info->last_name ?? '' }}"
                            data-email="{{ $applicant->email ?? '' }}" data-unread="{{ $unreadCount }}"
                            data-online="{{ $applicant->is_online ? '1' : '0' }}">



                            <div class="conversation-avatar">
                                <span class="avatar-initials">
                                    {{ strtoupper(substr($applicant->personal_info->first_name ?? 'U', 0, 1)) }}
                                    {{ strtoupper(substr($applicant->personal_info->last_name ?? 'A', 0, 1)) }}
                                </span>

                                @if ($applicant->is_online)
                                    <span class="status-dot"></span>
                                @endif
                            </div>


                            <div class="conversation-details">
                                <div class="conversation-name">
                                    {{ $applicant->personal_info->first_name ?? '' }}
                                    {{ $applicant->personal_info->last_name ?? '' }}
                                </div>
                                <div class="conversation-preview">Ready to discuss opportunities...</div>
                                <div class="conversation-email">{{ $applicant->email ?? '' }}</div>
                            </div>

                            <div class="conversation-meta">
                                @if ($unreadCount > 0)
                                    <div class="unread-count" data-count="{{ $unreadCount }}">{{ $unreadCount }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Chat Panel -->
            <div class="chat-panel" id="chatPanel">
                <div class="chat-header" id="chatHeader" style="display: none;">
                    <div class="chat-user-info">
                        <div class="chat-avatar" id="chatAvatar">AP</div>
                        <div class="chat-user-details">
                            <div class="chat-user-name" id="chatUserName">Select Applicant</div>
                            <div class="chat-user-status" id="chatUserStatus">Click on an applicant to start chatting
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chat-messages" id="chatMessages">
                    <div class="chat-placeholder">
                        <div class="placeholder-icon">💬</div>
                        <h4>Welcome to Messages</h4>
                        <p>Select an applicant to start a conversation</p>
                    </div>
                </div>

                <div class="typing-indicator" id="typingIndicator" style="display: none;">
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <span class="typing-text">Applicant is typing...</span>
                </div>

                <form class="chat-composer" id="chatComposer" action="{{ route('employer.sendmessage.store') }}"
                    method="POST" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    <input type="hidden" name="sender_id" value="{{ session('employer_id') }}">
                    <input type="hidden" name="receiver_id" id="receiver_id">

                    <div class="composer-actions">
                        <label for="fileInput" class="attach-btn" title="Attach file">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path
                                    d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66L9.64 16.2a2 2 0 0 1-2.83-2.83l8.49-8.49">
                                </path>
                            </svg>
                        </label>
                        <input type="file" name="photo" id="fileInput" accept="image/*" style="display: none;">
                    </div>

                    <div class="message-input-container">
                        <input type="text" name="message" placeholder="Type your message...">
                    </div>

                    <div id="uploadPreview" class="upload-preview"></div>

                    <button type="button" id="cancelPhoto" class="cancel-button" title="Cancel attachment"
                        style="display: none;">
                        <i class="bi bi-x-circle">X</i>
                    </button>

                    <button type="submit" class="send-button" title="Send message">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22,2 15,22 11,13 2,9 22,2"></polygon>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Image Viewer Modal -->
<div id="imageViewerModal" class="image-viewer-modal" style="display: none;">
    <div class="image-viewer-overlay"></div>
    <div class="image-viewer-content">
        <button class="image-viewer-close" id="closeImageViewer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <img id="viewerImage" src="" alt="Full size image">
        <div class="image-viewer-caption" id="viewerCaption"></div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        let retrieveMessages = @json($retrieveMessages);
        const employerId = "{{ session('employer_id') }}";

        const applicantsList = document.getElementById('applicantsList');
        const chatHeader = document.getElementById('chatHeader');
        const chatAvatar = document.getElementById('chatAvatar');
        const chatUserName = document.getElementById('chatUserName');
        const chatUserStatus = document.getElementById('chatUserStatus');
        const chatMessages = document.getElementById('chatMessages');
        const chatComposer = document.getElementById('chatComposer');
        const receiverInput = document.getElementById('receiver_id');
        const conversationsPanel = document.getElementById('conversationsPanel');
        const chatPanel = document.getElementById('chatPanel');
        const backBtn = document.getElementById('backBtn');
        const messageInput = chatComposer.querySelector('input[name="message"]');
        const fileInput = document.getElementById('fileInput');
        const uploadPreview = document.getElementById('uploadPreview');
        const cancelBtn = document.getElementById('cancelPhoto');
        const typingIndicator = document.getElementById('typingIndicator');
        const searchInput = document.getElementById('search');
        const globalNotif = document.getElementById('globalNotif');

        // Image Viewer Elements
        const imageViewerModal = document.getElementById('imageViewerModal');
        const viewerImage = document.getElementById('viewerImage');
        const viewerCaption = document.getElementById('viewerCaption');
        const closeImageViewer = document.getElementById('closeImageViewer');

        let currentApplicantId = null;
        let messagePollingInterval = null;
        let typingTimeout = null;
        let lastMessageId = null;

        // ---------- Image Viewer Functions ----------
        function openImageViewer(imageSrc, caption = '') {
            viewerImage.src = imageSrc;
            viewerCaption.textContent = caption;
            imageViewerModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeImageViewerFunc() {
            imageViewerModal.style.display = 'none';
            document.body.style.overflow = 'auto';
            viewerImage.src = '';
        }

        closeImageViewer.addEventListener('click', closeImageViewerFunc);
        imageViewerModal.querySelector('.image-viewer-overlay').addEventListener('click', closeImageViewerFunc);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && imageViewerModal.style.display === 'flex') {
                closeImageViewerFunc();
            }
        });

        // ---------- Utility ----------
        function isMobile() {
            return window.innerWidth <= 768;
        }

        function showTypingIndicator() {
            typingIndicator.style.display = 'flex';
        }

        function hideTypingIndicator() {
            typingIndicator.style.display = 'none';
        }

        function scrollToBottom() {
            setTimeout(() => {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 100);
        }

        // ---------- Global Notifications ----------
        function updateGlobalNotificationCount() {
            const badges = document.querySelectorAll('.unread-count');
            let total = 0;
            badges.forEach(b => total += parseInt(b.dataset.count || 0));
            if (globalNotif) {
                if (total > 0) {
                    globalNotif.textContent = total;
                    globalNotif.style.display = 'inline-flex';
                } else {
                    globalNotif.style.display = 'none';
                }
            }
        }

        function updateUIAfterMarkingRead(applicantId) {
            const item = document.querySelector(`[data-applicant-id="${applicantId}"]`);
            if (item) {
                const unreadBadge = item.querySelector('.unread-count');
                if (unreadBadge) unreadBadge.remove();
                const onlineDot = item.querySelector('.online-dot');
                if (onlineDot) onlineDot.remove();
                item.dataset.unread = '0';
            }
            retrieveMessages.forEach(m => {
                if (m.applicant_id == applicantId && m.sender_type === 'applicant') m.is_read = true;
            });
            updateGlobalNotificationCount();
        }

        async function markMessagesAsRead(applicantId) {
            try {
                const res = await fetch(`/employer/messages/mark-as-read/${applicantId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                const result = await res.json();
                if (result.success) updateUIAfterMarkingRead(applicantId);
            } catch (err) {
                console.error('Error marking as read:', err);
            }
        }

        // ---------- Render Messages ----------
        function renderMessages(messages, applicantName) {
            chatMessages.innerHTML = '';
            if (messages.length === 0) {
                chatMessages.innerHTML = `
                <div class="no-messages">
                    <div class="no-messages-icon">💭</div>
                    <p>No messages yet with ${applicantName}</p>
                    <span>Start the conversation below</span>
                </div>`;
                return;
            }

            messages.forEach(msg => {
                const isSent = msg.sender_type === 'employer';
                const time = new Date(msg.created_at).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const div = document.createElement('div');
                div.className = `message-bubble ${isSent ? 'sent' : 'received'}`;

                let imageHtml = '';
                if (msg.attachment) {
                    const imageSrc = `/storage/${msg.attachment}`;
                    imageHtml =
                        `<img src="${imageSrc}" class="message-image" alt="Attachment" onclick="openImageViewer('${imageSrc}', 'Sent at ${time}')">`;
                }

                div.innerHTML = `
                <div class="message-content">
                    ${imageHtml}
                    ${msg.message ? `<p class="message-text">${msg.message}</p>` : ''}
                </div>
                <div class="message-time">${time}</div>
                ${isSent ? '<div class="message-status">✓✓</div>' : ''}`;
                chatMessages.appendChild(div);
            });

            chatMessages.querySelectorAll('.message-image').forEach(img => {
                img.addEventListener('click', function() {
                    const src = this.getAttribute('src');
                    const time = this.closest('.message-bubble').querySelector('.message-time')
                        .textContent;
                    openImageViewer(src, `Sent at ${time}`);
                });
            });

            scrollToBottom();
        }

        window.openImageViewer = openImageViewer;

        // ---------- Message Polling ----------
        function startMessagePolling() {
            stopMessagePolling();
            messagePollingInterval = setInterval(refreshMessages, 3000);
        }

        function stopMessagePolling() {
            if (messagePollingInterval) clearInterval(messagePollingInterval);
            messagePollingInterval = null;
        }

        async function refreshMessages() {
            if (!currentApplicantId) return;
            try {
                const res = await fetch(`/employer/messages/fetch/${currentApplicantId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (!data.success || !data.messages) return;

                if (lastMessageId && data.messages.length > 0) {
                    const newLastId = data.messages[data.messages.length - 1].id;
                    if (newLastId === lastMessageId) return;
                }

                const name = chatUserName.textContent;
                renderMessages(data.messages, name);

                if (data.messages.length > 0)
                    lastMessageId = data.messages[data.messages.length - 1].id;

                if (data.is_typing) showTypingIndicator();
                else hideTypingIndicator();

                await markMessagesAsRead(currentApplicantId);
            } catch (err) {
                console.error('Error fetching messages:', err);
            }
        }

        // ---------- Typing Indicator ----------
        function sendTypingNotification(isTyping = true) {
            if (!currentApplicantId) return;
            fetch(`/employer/messages/typing/${currentApplicantId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    is_typing: isTyping
                })
            }).catch(console.error);
        }

        messageInput.addEventListener('input', () => {
            clearTimeout(typingTimeout);
            sendTypingNotification(true);
            typingTimeout = setTimeout(() => sendTypingNotification(false), 2500);
        });

        // ---------- Event: Applicant List Click ----------
        applicantsList.querySelectorAll('.conversation-item').forEach(item => {
            item.addEventListener('click', async () => {
                applicantsList.querySelectorAll('.conversation-item').forEach(i => i
                    .classList.remove('active'));
                item.classList.add('active');

                currentApplicantId = item.dataset.applicantId;
                const name = item.dataset.name;
                const email = item.dataset.email;

                chatHeader.style.display = 'flex';
                chatUserName.textContent = name;

                const isOnline = item.getAttribute('data-online') === '1' || item
                    .getAttribute('data-online') === 'true';

                if (isOnline) {
                    chatUserStatus.innerHTML = `
        <span class="status-dot online-dot"></span>
        Active • ${email} (Online)
    `;
                } else {
                    chatUserStatus.innerHTML = `
        <span class="status-dot offline-dot"></span>
        Offline • ${email} (Offline)
    `;
                }


                chatAvatar.textContent = name
                    .split(' ')
                    .map(n => n[0])
                    .join('')
                    .toUpperCase();


                receiverInput.value = currentApplicantId;
                chatComposer.style.display = 'flex';

                if (isMobile()) {
                    conversationsPanel.classList.add('hidden-mobile');
                    chatPanel.classList.remove('hidden-mobile');
                }

                const msgs = retrieveMessages.filter(m => m.applicant_id ==
                    currentApplicantId);
                renderMessages(msgs, name);
                await markMessagesAsRead(currentApplicantId);
                startMessagePolling();
            });
        });

        // ---------- Send Message ----------
        chatComposer.addEventListener('submit', async e => {
            e.preventDefault();
            const message = messageInput.value.trim();
            const file = fileInput.files[0];
            if (!message && !file) return;

            const formData = new FormData(chatComposer);
            messageInput.value = '';
            fileInput.value = '';
            uploadPreview.innerHTML = '';
            cancelBtn.style.display = 'none';

            const tempDiv = document.createElement('div');
            tempDiv.className = 'message-bubble sent';

            let tempImageHtml = '';
            if (file) {
                const tempSrc = URL.createObjectURL(file);
                tempImageHtml = `<img src="${tempSrc}" class="message-image" alt="Attachment">`;
            }

            tempDiv.innerHTML = `
            <div class="message-content">
                ${tempImageHtml}
                ${message ? `<p class="message-text">${message}</p>` : ''}
            </div>
            <div class="message-time">Now</div>
            <div class="message-status">✓</div>`;
            chatMessages.appendChild(tempDiv);
            scrollToBottom();

            try {
                const res = await fetch('{{ route('employer.sendmessage.store') }}', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.success) refreshMessages();
            } catch (err) {
                console.error('Send message error:', err);
            }
        });

        // ---------- Search ----------
        searchInput.addEventListener('input', e => {
            const term = e.target.value.toLowerCase();
            applicantsList.querySelectorAll('.conversation-item').forEach(item => {
                const name = item.dataset.name.toLowerCase();
                const email = item.dataset.email.toLowerCase();
                item.style.display = (name.includes(term) || email.includes(term)) ? 'flex' :
                    'none';
            });
        });

        // ---------- File Preview ----------
        fileInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = ev => uploadPreview.innerHTML =
                    `<img src="${ev.target.result}" class="preview-image">`;
                reader.readAsDataURL(file);
                cancelBtn.style.display = 'inline-block';
            } else {
                uploadPreview.innerHTML = '';
                cancelBtn.style.display = 'none';
            }
        });

        cancelBtn.addEventListener('click', () => {
            fileInput.value = '';
            uploadPreview.innerHTML = '';
            cancelBtn.style.display = 'none';
        });

        // ---------- Back Button ----------
        backBtn.addEventListener('click', () => {
            if (isMobile()) {
                conversationsPanel.classList.remove('hidden-mobile');
                chatPanel.classList.add('hidden-mobile');
            }
        });

        // ---------- Init ----------
        updateGlobalNotificationCount();
        window.addEventListener('beforeunload', stopMessagePolling);
    });
</script>
