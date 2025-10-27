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
                    <div class="online-indicator">
                        <div class="pulse"></div>
                        Online
                    </div>
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
                            data-email="{{ $applicant->email ?? '' }}" data-unread="{{ $unreadCount }}">

                            <div class="conversation-avatar">
                                {{ strtoupper(substr($applicant->personal_info->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($applicant->personal_info->last_name ?? 'A', 0, 1)) }}
                                @if ($unreadCount > 0)
                                    <div class="online-dot"></div>
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

<script>
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

    let currentApplicantId = null;
    let messagePollingInterval = null;
    let typingTimeout = null;

    function isMobile() {
        return window.innerWidth <= 768;
    }

    backBtn.addEventListener('click', () => {
        if (isMobile()) {
            conversationsPanel.classList.remove('hidden-mobile');
            chatPanel.classList.add('hidden-mobile');
        }
    });

    window.addEventListener('resize', () => {
        if (!isMobile()) {
            conversationsPanel.classList.remove('hidden-mobile');
            chatPanel.classList.remove('hidden-mobile');
        }
    });

    document.getElementById('search').addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const items = applicantsList.querySelectorAll('.conversation-item');

        items.forEach(item => {
            const name = item.getAttribute('data-name').toLowerCase();
            const email = item.getAttribute('data-email').toLowerCase();

            if (name.includes(searchTerm) || email.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadPreview.innerHTML =
                    `<img src="${e.target.result}" class="preview-image" alt="Preview">`;
            };
            reader.readAsDataURL(file);
            cancelBtn.style.display = 'inline-block';
        } else {
            uploadPreview.innerHTML = '';
            cancelBtn.style.display = 'none';
        }
    });

    cancelBtn.addEventListener('click', function() {
        fileInput.value = '';
        uploadPreview.innerHTML = '';
        this.style.display = 'none';
    });

    function updateGlobalNotificationCount() {
        const allUnreadCounts = document.querySelectorAll('.unread-count');
        let totalUnread = 0;

        allUnreadCounts.forEach(badge => {
            const count = parseInt(badge.getAttribute('data-count') || badge.textContent || '0');
            if (!isNaN(count) && count > 0) {
                totalUnread += count;
            }
        });

        console.log('Total unread messages:', totalUnread);

        const globalNotif = document.getElementById('globalNotif');
        if (globalNotif) {
            if (totalUnread > 0) {
                globalNotif.textContent = totalUnread;
                globalNotif.style.display = 'inline-flex';
            } else {
                globalNotif.textContent = '0';
                globalNotif.style.display = 'none';
            }
        }
    }


    function updateUIAfterMarkingRead(applicantId) {
        console.log('Updating UI for applicant:', applicantId);

        // Find the conversation item
        const conversationItem = document.querySelector(`[data-applicant-id="${applicantId}"]`);
        if (conversationItem) {
            // Remove unread count badge
            const unreadBadge = conversationItem.querySelector('.unread-count');
            if (unreadBadge) {
                console.log('Removing unread badge');
                unreadBadge.remove();
            }

            // Remove online dot indicator
            const onlineDot = conversationItem.querySelector('.online-dot');
            if (onlineDot) {
                console.log('Removing online dot');
                onlineDot.remove();
            }

            // Update data attribute
            conversationItem.setAttribute('data-unread', '0');
        }

        // Update local message store
        retrieveMessages.forEach(msg => {
            if (msg.applicant_id == applicantId && msg.sender_type === 'applicant') {
                msg.is_read = true;
            }
        });

        // Update global notification count
        updateGlobalNotificationCount();
    }

    async function markMessagesAsRead(applicantId) {
        try {
            console.log('Marking messages as read for applicant:', applicantId);

            const url = `/employer/messages/mark-as-read/${applicantId}`;
            console.log('Request URL:', url);

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            console.log(' Response status:', response.status);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Response error:', errorText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            console.log('Mark as read response:', result);

            if (result.success) {
                console.log('Successfully marked', result.updated, 'messages as read');

                // Update UI immediately - THIS IS THE KEY FIX
                updateUIAfterMarkingRead(applicantId);

                return true;
            } else {
                console.warn('Mark as read failed:', result.message);
                return false;
            }
        } catch (error) {
            console.error('Error marking messages as read:', error);
            return false;
        }
    }


    function showTypingIndicator() {
        document.getElementById('typingIndicator').style.display = 'flex';
    }

    function hideTypingIndicator() {
        document.getElementById('typingIndicator').style.display = 'none';
    }

    async function sendTypingNotification() {
        if (!currentApplicantId) return;

        try {
            await fetch('/employer/messages/typing', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    applicant_id: currentApplicantId
                })
            });
        } catch (error) {
            console.error('Error sending typing notification:', error);
        }
    }

    function startMessagePolling() {
        stopMessagePolling();

        console.log('Starting message polling for applicant:', currentApplicantId);

        messagePollingInterval = setInterval(async () => {
            if (!currentApplicantId) return;

            try {
                const response = await fetch(`/employer/messages/${currentApplicantId}/fetch`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const data = await response.json();

                    if (data.messages) {
                        const currentMessages = retrieveMessages.filter(m => m.applicant_id ==
                            currentApplicantId);
                        const newMessages = data.messages.filter(newMsg =>
                            !currentMessages.some(existingMsg => existingMsg.id === newMsg.id)
                        );

                        if (newMessages.length > 0) {
                            console.log('New messages received:', newMessages.length);

                            // Update message store
                            retrieveMessages = retrieveMessages.filter(m => m.applicant_id !=
                                currentApplicantId);
                            retrieveMessages = [...retrieveMessages, ...data.messages];

                            // Re-render messages
                            const name = document.getElementById('chatUserName').textContent;
                            renderMessages(data.messages, name);

                            // Mark new messages as read immediately with UI update
                            await markMessagesAsRead(currentApplicantId);
                        }
                    }

                    // Handle typing indicator
                    if (data.is_typing) {
                        showTypingIndicator();
                    } else {
                        hideTypingIndicator();
                    }
                }
            } catch (error) {
                console.error('Error polling messages:', error);
            }
        }, 3000); // Poll every 3 seconds
    }

    function stopMessagePolling() {
        if (messagePollingInterval) {
            clearInterval(messagePollingInterval);
            messagePollingInterval = null;
            console.log('⏹Stopped message polling');
        }
    }


    applicantsList.querySelectorAll('.conversation-item').forEach(item => {
        item.addEventListener('click', async () => {
            console.log(' Applicant clicked');

            // Remove active state from all items
            applicantsList.querySelectorAll('.conversation-item').forEach(i => i.classList.remove(
                'active'));
            item.classList.add('active');

            const applicantId = item.getAttribute('data-applicant-id');
            const name = item.getAttribute('data-name');
            const email = item.getAttribute('data-email');

            currentApplicantId = applicantId;


            // Mobile view handling
            if (isMobile()) {
                conversationsPanel.classList.add('hidden-mobile');
                chatPanel.classList.remove('hidden-mobile');
            }

            // Update header
            chatHeader.style.display = 'flex';
            chatUserName.textContent = name;
            chatUserStatus.textContent = `Active • ${email}`;
            chatAvatar.textContent = name.split(' ').map(n => n[0]).join('').toUpperCase();

            // Update receiver ID for form
            receiverInput.value = applicantId;

            // Show composer
            chatComposer.style.display = 'flex';

            // Filter messages for this applicant
            const messagesForApplicant = retrieveMessages.filter(m => m.applicant_id ==
                applicantId);
            console.log(' Messages for applicant:', messagesForApplicant.length);

            // Render messages
            renderMessages(messagesForApplicant, name);

            // Mark messages as read IMMEDIATELY with UI update
            console.log(' Marking messages as read...');
            const marked = await markMessagesAsRead(applicantId);
            console.log('✓ Mark as read completed:', marked);

            // Start polling for new messages
            startMessagePolling();
        });
    });


    function renderMessages(messages, applicantName) {
        chatMessages.innerHTML = '';

        if (messages.length > 0) {
            messages.forEach(msg => {
                const isSentByEmployer = msg.sender_type === 'employer';
                const messageTime = new Date(msg.created_at).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const messageDiv = document.createElement('div');
                messageDiv.className = `message-bubble ${isSentByEmployer ? 'sent' : 'received'}`;

                messageDiv.innerHTML = `
                <div class="message-content">
                    ${msg.attachment ? `<img src="/storage/${msg.attachment}" alt="Attachment" class="message-image">` : ''}
                    ${msg.message ? `<p class="message-text">${msg.message}</p>` : ''}
                </div>
                <div class="message-time">${messageTime}</div>
                ${isSentByEmployer ? '<div class="message-status">✓✓</div>' : ''}
            `;

                chatMessages.appendChild(messageDiv);
            });

            chatMessages.scrollTop = chatMessages.scrollHeight;
        } else {
            chatMessages.innerHTML = `
            <div class="no-messages">
                <div class="no-messages-icon">💭</div>
                <p>No messages yet with ${applicantName}</p>
                <span>Start the conversation by sending a message below</span>
            </div>
        `;
        }
    }


    chatComposer.addEventListener('submit', async function(e) {
        e.preventDefault();

        const message = messageInput.value.trim();
        const file = fileInput.files[0];

        if (!message && !file) {
            return;
        }

        console.log(' Sending message...');

        // Add sent message to chat immediately
        if (message || file) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message-bubble sent';
            messageDiv.innerHTML = `
            <div class="message-content">
                ${file ? `<img src="${URL.createObjectURL(file)}" alt="Attachment" class="message-image">` : ''}
                ${message ? `<p class="message-text">${message}</p>` : ''}
            </div>
            <div class="message-time">Now</div>
            <div class="message-status">✓</div>
        `;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Prepare form data
        const formData = new FormData(chatComposer);

        // Clear inputs
        messageInput.value = '';
        messageInput.style.height = 'auto';
        fileInput.value = '';
        uploadPreview.innerHTML = '';
        cancelBtn.style.display = 'none';

        try {
            const response = await fetch('{{ route('employer.sendmessage.store') }}', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                console.log(' Message sent successfully');

                const lastMsg = chatMessages.querySelector(
                    '.message-bubble.sent:last-child .message-status');
                if (lastMsg) lastMsg.textContent = '✓✓';

                // Refresh messages from server
                const fetchResponse = await fetch(`/employer/messages/${currentApplicantId}/fetch`);
                const data = await fetchResponse.json();
                if (data.messages) {
                    retrieveMessages = retrieveMessages.filter(m => m.applicant_id != currentApplicantId);
                    retrieveMessages = [...retrieveMessages, ...data.messages];
                }
            } else {
                console.error('Failed to send message');
            }
        } catch (error) {
            console.error(' Error sending message:', error);
        }
    });


    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';

        // Send typing notification
        clearTimeout(typingTimeout);
        sendTypingNotification();
        typingTimeout = setTimeout(() => {
            // Stop typing after 3 seconds
        }, 3000);
    });


    window.addEventListener('beforeunload', () => {
        stopMessagePolling();
    });

    // Initial notification count on page load
    updateGlobalNotificationCount();
</script>
