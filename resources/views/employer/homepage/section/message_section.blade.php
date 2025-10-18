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
                            class="notif-badge">{{ $retrieveMessages->where('is_read', false)->count() }}</span>
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
                        <div class="conversation-item" data-applicant-id="{{ $applicant->id }}"
                            data-name="{{ $applicant->personal_info->first_name ?? '' }} {{ $applicant->personal_info->last_name ?? '' }}"
                            data-email="{{ $applicant->email ?? '' }}">

                            <div class="conversation-avatar">
                                {{ strtoupper(substr($applicant->personal_info->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($applicant->personal_info->last_name ?? 'A', 0, 1)) }}
                                <div class="online-dot"></div>
                            </div>

                            <div class="conversation-details">
                                <div class="conversation-name">
                                    {{ $applicant->personal_info->first_name ?? '' }}
                                    {{ $applicant->personal_info->last_name ?? '' }}
                                </div>
                                <div class="conversation-preview">Ready to discuss opportunities...</div>
                                <div class="conversation-email">{{ $applicant->email ?? '' }}
                                </div>
                            </div>

                            <div class="conversation-meta">
                                <div class="conversation-time">2min</div>
                                <div class="unread-count">1</div>
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
                            <div class="chat-user-status" id="chatUserStatus">Click on an applicant to start
                                chatting</div>
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

                    <!-- Photo preview container -->
                    <div id="uploadPreview" class="upload-preview"></div>

                    <!-- Cancel button (hidden by default) -->
                    <button type="button" id="cancelPhoto" class="cancel-button" title="Cancel attachment"
                        style="display: none;"><i class="bi bi-x-circle">X</i></button>

                    <button type="submit" class="send-button" title="Send message">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22,2 15,22 11,13 2,9 22,2"></polygon>
                        </svg>
                    </button>
                </form>

                <script>
                    const fileInput = document.getElementById('fileInput');
                    const uploadPreview = document.getElementById('uploadPreview');
                    const cancelBtn = document.getElementById('cancelPhoto');

                    fileInput.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                uploadPreview.innerHTML =
                                    `<img src="${e.target.result}" class="preview-image" alt="Preview">`;
                            };
                            reader.readAsDataURL(file);

                            cancelBtn.style.display = 'inline-block'; // show cancel button
                        } else {
                            uploadPreview.innerHTML = '';
                            cancelBtn.style.display = 'none';
                        }
                    });

                    cancelBtn.addEventListener('click', function() {
                        fileInput.value = ''; // clear file
                        uploadPreview.innerHTML = ''; // clear preview
                        this.style.display = 'none'; // hide cancel button
                    });
                </script>
            </div>
        </div>
    </div>
</div>


<script>
    const retrieveMessages = @json($retrieveMessages);
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
    const messageInput = document.getElementById('messageInput');

    // Mobile responsiveness
    function isMobile() {
        return window.innerWidth <= 768;
    }

    // Handle back button for mobile
    backBtn.addEventListener('click', () => {
        if (isMobile()) {
            conversationsPanel.classList.remove('hidden-mobile');
            chatPanel.classList.add('hidden-mobile');
        }
    });

    // Search functionality
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

    // Handle applicant selection
    applicantsList.querySelectorAll('.conversation-item').forEach(item => {
        item.addEventListener('click', () => {
            // Remove active state from all items
            applicantsList.querySelectorAll('.conversation-item').forEach(i => i.classList.remove(
                'active'));
            // Add active state to clicked item
            item.classList.add('active');

            const applicantId = item.getAttribute('data-applicant-id');
            const name = item.getAttribute('data-name');
            const email = item.getAttribute('data-email');

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
            const messagesForApplicant = retrieveMessages.filter(m => m.applicant.id == applicantId);

            // Render messages
            renderMessages(messagesForApplicant, name);
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

            chatMessages.scrollTop = chatMessages.scrollHeight; // scroll to bottom
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



    // Handle form submission
    chatComposer.addEventListener('submit', function(e) {
        const message = messageInput.value.trim();
        if (!message && !document.getElementById('fileInput').files[0]) {
            e.preventDefault();
            return;
        }

        // Add sent message to chat immediately for better UX
        if (message) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message-bubble sent';
            messageDiv.innerHTML = `
                <div class="message-content">
                    <p class="message-text">${message}</p>
                </div>
                <div class="message-time">Now</div>
                <div class="message-status">✓</div>
            `;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            messageInput.value = '';
        }
    });

    // Auto-resize message input
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Simulate typing indicator (optional)
    let typingTimeout;
    messageInput.addEventListener('input', () => {
        clearTimeout(typingTimeout);
        // You can implement real-time typing indicators here
    });

    // Handle window resize
    window.addEventListener('resize', () => {
        if (!isMobile()) {
            conversationsPanel.classList.remove('hidden-mobile');
            chatPanel.classList.remove('hidden-mobile');
        }
    });
</script>
