<!-- Messages Dropdown -->
<div class="nav-dropdown">
    <button class="nav-icon" onclick="toggleDropdown('messagesDropdown')" title="messages">
        <i class="bi bi-chat-dots"></i>
        @php
            $unreadCount = $messages->where('sender_type', 'employer')->where('is_read', 0)->count();
        @endphp
        @if ($unreadCount > 0)
            <span class="nav-badge" id="messagesBadge">{{ $unreadCount }}</span>
        @endif
    </button>


    <div class="dropdown-menu" id="messagesDropdown">
        <div class="dropdown-header">
            <h6>Messages</h6>
            <button class="mark-all-read" onclick="markAllAsRead('messages')">Mark all as
                read</button>
        </div>

        <div class="dropdown-content">
            <div class="messages-list">
                @forelse($messages->groupBy('employer_id') as $employerId => $employerMessages)
                    @php
                        $employer = $employerMessages->first()->employer;
                        $unreadCount = $employerMessages
                            ->where('sender_type', 'employer')
                            ->where('is_read', 0)
                            ->count();
                        $lastMessage = $employerMessages->sortByDesc('created_at')->first();
                        $totalMessages = $employerMessages->count();
                    @endphp

                    <div class="employer-item {{ $unreadCount > 0 ? 'unread' : '' }}"
                        data-employer-id="{{ $employerId }}" data-unread-count="{{ $unreadCount }}"
                        onclick="openChatWithEmployer({{ $employerId }}, '{{ addslashes($employer->personal_info->first_name ?? 'N/A') }}', '{{ addslashes($employer->personal_info->last_name ?? 'N/A') }}', '{{ addslashes($employer->addressCompany->company_name ?? 'Company') }}')">

                        @if ($unreadCount > 0)
                            <div class="unread-indicator"></div>
                        @endif

                        <div class="message-avatar">
                            @if ($employer->addressCompany->company_logo)
                                <img src="{{ $employer->addressCompany->company_logo }}"
                                    alt="{{ $employer->addressCompany->company_name }}">
                            @else
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($employer->addressCompany->company_name ?? 'C', 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="message-content">
                            <div class="message-header">
                                <span class="sender-name">
                                    {{ $employer->personal_info->first_name ?? 'N/A' }}
                                    {{ $employer->personal_info->last_name ?? 'N/A' }}
                                </span>
                                <span class="company-name">
                                    {{ $employer->addressCompany->company_name ?? 'Company' }}
                                </span>
                                <div class="message-meta">
                                    <span class="message-time">{{ $lastMessage->created_at->diffForHumans() }}</span>
                                    @if ($unreadCount > 0)
                                        <span class="unread-count">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="message-preview">
                                {{ $totalMessages }} message{{ $totalMessages > 1 ? 's' : '' }} •
                                {{ Str::limit($lastMessage->message, 60) }}
                            </div>
                        </div>

                        <button class="message-actions"
                            onclick="event.stopPropagation(); openChatWithEmployer({{ $employerId }}, '{{ addslashes($employer->personal_info->first_name ?? 'N/A') }}', '{{ addslashes($employer->personal_info->last_name ?? 'N/A') }}', '{{ addslashes($employer->addressCompany->company_name ?? 'Company') }}')"
                            title="Open chat">
                            <i class="bi bi-chat-square-text"></i>
                        </button>
                    </div>
                @empty
                    <div class="no-messages">
                        <i class="bi bi-chat-dots"></i>
                        <p>No conversations yet</p>
                    </div>
                @endforelse
            </div>

            <div class="dropdown-footer">
                <a href="#" class="view-all-link" onclick="openAllChats()">
                    <i class="bi bi-arrow-right"></i>
                    Open Chat System
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Professional Chat Modal/System -->
<div id="chatModal" class="chat-modal" style="display: none;">
    <div class="chat-modal-overlay" onclick="closeChatModal()"></div>
    <div class="chat-modal-content">
        <div class="chat-container">
            <!-- Enhanced Employers Sidebar -->
            <div class="employers-sidebar">
                <div class="sidebar-header">
                    <div class="header-content">
                        <h2>Messages</h2>
                        <p>Conversations with employers</p>
                    </div>
                    <button class="close-chat-btn" onclick="closeChatModal()">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="search-container">
                    <div class="search-input-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Search conversations..." class="search-input"
                            id="searchInput">
                    </div>
                </div>

                <div class="employers-list" id="employersList">
                    @forelse($messages->groupBy('employer_id') as $employerId => $employerMessages)
                        @php
                            $employer = $employerMessages->first()->employer;
                            $unreadCount = $employerMessages
                                ->where('sender_type', 'employer')
                                ->where('is_read', 0)
                                ->count();
                            $lastMessage = $employerMessages->sortByDesc('created_at')->first();
                        @endphp

                        <div class="employer-list-item {{ $unreadCount > 0 ? 'has-unread' : '' }}"
                            data-employer-id="{{ $employerId }}" data-unread-count="{{ $unreadCount }}"
                            onclick="loadConversation({{ $employerId }})">

                            <div class="employer-avatar">
                                @if ($employer->addressCompany->company_logo)
                                    <img src="{{ $employer->addressCompany->company_logo }}"
                                        alt="{{ $employer->addressCompany->company_name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($employer->addressCompany->company_name ?? 'C', 0, 1)) }}
                                    </div>
                                @endif
                                @if ($unreadCount > 0)
                                    <div class="online-status"></div>
                                @endif
                            </div>

                            <div class="employer-info">
                                <div class="employer-name">
                                    {{ $employer->personal_info->first_name ?? 'N/A' }}
                                    {{ $employer->personal_info->last_name ?? 'N/A' }}
                                </div>
                                <div class="company-name">
                                    {{ $employer->addressCompany->company_name ?? 'Company' }}
                                </div>
                                <div class="last-message-preview">
                                    {{ Str::limit($lastMessage->message, 30) }}
                                </div>
                                <div class="last-message-time">
                                    {{ $lastMessage->created_at->diffForHumans() }}
                                </div>
                            </div>

                            @if ($unreadCount > 0)
                                <span class="unread-count">{{ $unreadCount }}</span>
                            @endif
                        </div>
                    @empty
                        <div class="no-employers">
                            <i class="bi bi-chat-dots"></i>
                            <p>No conversations yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Enhanced Chat Area -->
            <div class="chat-area">
                <!-- Professional Chat Header -->
                <div class="chat-header" id="chatHeader" style="display: none;">
                    <div class="header-left">
                        <div class="current-employer-avatar">
                            <div class="avatar-placeholder" id="currentAvatar">E</div>
                        </div>
                        <div class="current-employer-info">
                            <h3 id="currentEmployerName">Select an employer</h3>
                            <p id="currentCompanyName">to start chatting</p>
                            <span class="online-status-text">Online</span>
                        </div>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="messages-container" id="messagesContainer">
                    <div class="no-conversation">
                        <div class="no-conversation-icon">
                            <i class="bi bi-chat-square-dots"></i>
                        </div>
                        <h3>Select a conversation</h3>
                        <p>Choose an employer from the list to view your messages</p>
                    </div>
                </div>
                <!-- Reply Area -->
                <div class="reply-area" id="replyArea" style="display: none;">
                    <form id="replyForm" class="reply-container">
                        @csrf
                        <input type="hidden" name="employer_id" id="replyEmployerId">

                        <div class="message-input-wrapper">
                            <!-- File Upload -->
                            <label class="attachment-btn" for="attachment" title="Attach file">
                                <i class="bi bi-paperclip"></i>
                            </label>
                            <input type="file" name="attachment" id="attachment" class="d-none"
                                accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">

                            <!-- File Preview -->
                            <div id="attachmentPreview" class="attachment-preview mt-2"></div>


                            <!-- Message -->
                            <textarea class="reply-input" id="replyInput" name="message" placeholder="Type your message..." rows="1"
                                required></textarea>
                        </div>

                        <!-- Send Button -->
                        <button type="submit" class="send-btn" title="Send message">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>

                    <div class="typing-indicator" id="typingIndicator" style="display: none;">
                        <span>Employer is typing...</span>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!---Photo review--->
<script>
    document.getElementById('attachment').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('attachmentPreview');
        previewContainer.innerHTML = ''; // clear previous preview

        if (!file) return;

        const fileType = file.type;

        const previewItem = document.createElement('div');
        previewItem.classList.add('preview-item');

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '&times;';
        removeBtn.classList.add('remove-btn');
        removeBtn.onclick = () => {
            previewContainer.innerHTML = '';
            document.getElementById('attachment').value = ''; // reset file input
        };

        previewItem.appendChild(removeBtn);

        if (fileType.startsWith('image/')) {
            // Show image preview
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            previewItem.appendChild(img);
        } else {
            // Show file name for docs or PDFs
            const fileName = document.createElement('div');
            fileName.classList.add('file-name');
            fileName.textContent = file.name;
            previewItem.appendChild(fileName);
        }

        previewContainer.appendChild(previewItem);
    });
</script>

<script>
    let currentEmployerId = null;
    // Pass messages from backend (already eager-loaded with employer info)
    let allMessages = @json($messages);

    // Group messages by employer_id for easier access
    const messagesByEmployer = {};
    allMessages.forEach(msg => {
        if (!messagesByEmployer[msg.employer_id]) {
            messagesByEmployer[msg.employer_id] = [];
        }
        messagesByEmployer[msg.employer_id].push(msg);
    });

    // Open chat with specific employer
    function openChatWithEmployer(employerId, firstName, lastName, companyName) {
        document.getElementById('chatModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';

        // Load conversation (which will mark as read)
        loadConversation(employerId);
    }

    // Open all chats (just show modal without selecting)
    function openAllChats() {
        document.getElementById('chatModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Close chat modal
    function closeChatModal() {
        document.getElementById('chatModal').style.display = 'none';
        document.body.style.overflow = 'auto';

        // Reset chat area
        document.getElementById('chatHeader').style.display = 'none';
        document.getElementById('replyArea').style.display = 'none';
        document.getElementById('messagesContainer').innerHTML = `
            <div class="no-conversation">
                <div class="no-conversation-icon">
                    <i class="bi bi-chat-square-dots"></i>
                </div>
                <h3>Select a conversation</h3>
                <p>Choose an employer from the list to view your messages</p>
            </div>
        `;

        // Remove active states
        document.querySelectorAll('.employer-list-item').forEach(item => {
            item.classList.remove('active');
        });
    }

    // Load conversation for selected employer
    function loadConversation(employerId) {
        currentEmployerId = employerId;

        // Set hidden input for reply form
        const replyEmployerInput = document.getElementById('replyEmployerId');
        replyEmployerInput.value = employerId;

        // Update active state in sidebar
        document.querySelectorAll('.employer-list-item').forEach(item => {
            item.classList.remove('active');
        });
        const activeItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);
        if (activeItem) activeItem.classList.add('active');

        const employerMessages = messagesByEmployer[employerId] || [];

        // If no messages, clear display
        if (employerMessages.length === 0) {
            displayMessages([]);
            document.getElementById('chatHeader').style.display = 'flex';
            document.getElementById('replyArea').style.display = 'block';
            return;
        }

        const employer = employerMessages[0].employer;

        // Update chat header
        const chatHeader = document.getElementById('chatHeader');
        chatHeader.style.display = 'flex';
        document.getElementById('currentEmployerName').textContent =
            `${employer.personal_info?.first_name || 'N/A'} ${employer.personal_info?.last_name || ''}`;
        document.getElementById('currentCompanyName').textContent =
            employer.address_company?.company_name || 'Company';

        // Update avatar
        const avatarElement = document.getElementById('currentAvatar');
        if (employer.address_company?.company_logo) {
            avatarElement.innerHTML = `<img src="${employer.address_company.company_logo}" 
                alt="${employer.address_company.company_name}" 
                style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        } else {
            avatarElement.textContent = (employer.address_company?.company_name || 'C').charAt(0).toUpperCase();
        }

        // Load messages into chat area
        displayMessages(employerMessages);

        // Show reply area
        document.getElementById('replyArea').style.display = 'block';

        // Mark messages as read via AJAX
        markMessagesAsRead(employerId);
    }

    // Display messages in chat
    function displayMessages(messages) {
        const container = document.getElementById('messagesContainer');

        if (messages.length === 0) {
            container.innerHTML = `
                <div class="no-conversation">
                    <div class="no-conversation-icon">
                        <i class="bi bi-chat-square"></i>
                    </div>
                    <h3>No messages yet</h3>
                    <p>Start the conversation by sending a message</p>
                </div>
            `;
            return;
        }

        // Sort messages by creation time
        messages.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));

        container.innerHTML = messages.map(msg => {
            const isFromEmployer = msg.sender_type === 'employer';
            const bubbleClass = isFromEmployer ? 'from-employer' : 'from-applicant';

            // Attachment HTML
            let attachmentHtml = '';
            if (msg.attachment) {
                attachmentHtml = `
                    <div class="message-attachment mt-2">
                        <img src="/storage/${msg.attachment}" 
                             alt="Attachment" 
                             class="img-fluid rounded-2 shadow-sm"
                             style="max-height: 200px; width: auto;">
                    </div>
                `;
            }

            // Format timestamp for display and tooltip
            const timestamp = formatMessageTime(msg.created_at);
            const fullDate = new Date(msg.created_at).toLocaleString();

            return `
                <div class="message-bubble ${bubbleClass}">
                    <div class="message-content">
                        ${msg.message || ''}
                        ${attachmentHtml}
                        <div class="message-timestamp ${bubbleClass}" title="${fullDate}">
                            ${timestamp}
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
    }

    // Mark messages as read
    function markMessagesAsRead(employerId) {
        // Get unread count before marking as read
        const dropdownItem = document.querySelector(`.employer-item[data-employer-id="${employerId}"]`);
        const sidebarItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);

        const unreadCount = parseInt(dropdownItem?.dataset.unreadCount || sidebarItem?.dataset.unreadCount || 0);

        // Only make API call if there are unread messages
        if (unreadCount === 0) {
            console.log('No unread messages to mark');
            return;
        }

        fetch(`/applicant/read-message/${employerId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Messages marked as read');

                    // Update dropdown item
                    if (dropdownItem) {
                        dropdownItem.classList.remove('unread');
                        dropdownItem.dataset.unreadCount = '0';

                        const unreadIndicator = dropdownItem.querySelector('.unread-indicator');
                        if (unreadIndicator) unreadIndicator.remove();

                        const unreadCountBadge = dropdownItem.querySelector('.unread-count');
                        if (unreadCountBadge) unreadCountBadge.remove();
                    }

                    // Update sidebar item
                    if (sidebarItem) {
                        sidebarItem.classList.remove('has-unread');
                        sidebarItem.dataset.unreadCount = '0';

                        const onlineStatus = sidebarItem.querySelector('.online-status');
                        if (onlineStatus) onlineStatus.remove();

                        const unreadCountBadge = sidebarItem.querySelector('.unread-count');
                        if (unreadCountBadge) unreadCountBadge.remove();
                    }

                    // Update total unread badge in navbar
                    const badge = document.getElementById('messagesBadge');
                    if (badge && unreadCount > 0) {
                        let currentCount = parseInt(badge.textContent) || 0;
                        const newCount = Math.max(currentCount - unreadCount, 0);
                        badge.textContent = newCount;

                        if (newCount === 0) {
                            badge.style.display = 'none';
                        }
                    }

                    // Update local message data
                    if (messagesByEmployer[employerId]) {
                        messagesByEmployer[employerId].forEach(msg => {
                            if (msg.sender_type === 'employer') {
                                msg.is_read = 1;
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error marking messages as read:', error);
            });
    }

    // Format message time
    function formatMessageTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInMinutes = Math.floor((now - date) / 1000 / 60);

        if (diffInMinutes < 1) return 'Just now';
        if (diffInMinutes < 60) return `${diffInMinutes}m ago`;
        if (diffInMinutes < 1440) return `${Math.floor(diffInMinutes / 60)}h ago`;
        return date.toLocaleDateString();
    }

    // Handle form submission with AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const replyForm = document.getElementById('replyForm');

        replyForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent redirect

            const formData = new FormData(replyForm);
            const messageText = document.getElementById('replyInput').value.trim();
            const attachmentFile = document.getElementById('attachment').files[0];

            if (!messageText && !attachmentFile) {
                return;
            }

            // Add message to chat immediately
            if (messageText || attachmentFile) {
                const container = document.getElementById('messagesContainer');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message-bubble from-applicant';
                messageDiv.innerHTML = `
                    <div class="message-content">
                        ${messageText || ''}
                        ${attachmentFile ? `<div class="message-attachment mt-2"><img src="${URL.createObjectURL(attachmentFile)}" class="img-fluid rounded-2 shadow-sm" style="max-height: 200px; width: auto;"></div>` : ''}
                        <div class="message-timestamp from-applicant">Just now</div>
                    </div>
                `;
                container.appendChild(messageDiv);
                container.scrollTop = container.scrollHeight;
            }

            // Clear form
            document.getElementById('replyInput').value = '';
            document.getElementById('attachment').value = '';

            try {
                // Send via AJAX
                const response = await fetch(
                    '{{ route('applicant.sendmessageemployer.store') }}', {
                        method: 'POST',
                        body: formData
                    });

                const result = await response.json();

                if (result.success) {
                    console.log('Message sent successfully');
                } else {
                    console.error('Failed to send message');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
</script>
