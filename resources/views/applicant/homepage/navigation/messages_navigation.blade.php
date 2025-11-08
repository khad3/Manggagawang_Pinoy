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
            <div class="messages-list" id="dropdownMessagesList">
                @php
                    // Sort employers by latest message
                    $groupedMessages = $messages
                        ->groupBy('employer_id')
                        ->map(function ($employerMessages) {
                            return $employerMessages->sortByDesc('created_at');
                        })
                        ->sortByDesc(function ($employerMessages) {
                            return $employerMessages->first()->created_at;
                        });
                @endphp

                @forelse($groupedMessages as $employerId => $employerMessages)
                    @php
                        $lastMessage = $employerMessages->first();
                        $employer = $lastMessage->employer;
                        $company = $employer->addressCompany ?? null;
                        $unreadCount = $employerMessages
                            ->where('sender_type', 'employer')
                            ->where('is_read', 0)
                            ->count();
                        $initials =
                            $company && !$company->company_logo
                                ? strtoupper(substr($company->company_name ?? 'C', 0, 2))
                                : '';
                    @endphp

                    <div class="employer-item {{ $unreadCount > 0 ? 'unread' : '' }}"
                        data-employer-id="{{ $employerId }}"
                        onclick="openChatWithEmployer({{ $employerId }}, '{{ addslashes($employer->personal_info->first_name ?? 'N/A') }}', '{{ addslashes($employer->personal_info->last_name ?? 'N/A') }}', '{{ addslashes($company->company_name ?? 'Company') }}')">

                        {{-- Unread indicator --}}
                        @if ($unreadCount > 0)
                            <div class="unread-indicator"></div>
                        @endif

                        {{-- Avatar --}}
                        <div class="message-avatar-wrapper">
                            @if ($company && $company->company_logo)
                                <img src="{{ asset('storage/' . $company->company_logo) }}"
                                    alt="{{ $company->company_name ?? 'Company Logo' }}" class="message-avatar-img">
                            @else
                                <div class="message-avatar-initials">{{ $initials ?: 'C' }}</div>
                            @endif
                        </div>

                        {{-- Message content --}}
                        <div class="message-content">
                            <div class="message-header">
                                <span class="sender-name">{{ $employer->personal_info->first_name ?? 'N/A' }} - </span>
                                <span class="company-name">{{ $company->company_name ?? 'Company' }}</span>
                                <span class="message-time">{{ $lastMessage->created_at->diffForHumans() }}</span>
                                @if ($unreadCount > 0)
                                    <span class="unread-count">{{ $unreadCount }}</span>
                                @endif
                            </div>

                            <div class="message-preview">
                                {{ Str::limit($lastMessage->message, 50) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-messages text-center">
                        <i class="bi bi-chat-dots fs-2 mb-2"></i>
                        <p class="mb-0">No conversations yet</p>
                    </div>
                @endforelse
            </div>

            <div class="dropdown-footer text-center">
                <a href="#" class="view-all-link" onclick="openAllChats()">
                    <i class="bi bi-arrow-right"></i> Open Chat System
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
                    @php
                        // Group messages by employer and sort each group by latest message
                        $groupedMessages = $messages
                            ->groupBy('employer_id')
                            ->map(function ($employerMessages) {
                                return $employerMessages->sortByDesc('created_at');
                            })
                            ->sortByDesc(function ($employerMessages) {
                                return $employerMessages->first()->created_at;
                            });
                    @endphp

                    @forelse($groupedMessages as $employerId => $employerMessages)
                        @php
                            $lastMessage = $employerMessages->first();
                            $employer = $lastMessage->employer;
                            $company = $employer->addressCompany ?? null;
                            $unreadCount = $employerMessages
                                ->where('sender_type', 'employer')
                                ->where('is_read', 0)
                                ->count();
                            $initials =
                                $company && !$company->company_logo
                                    ? strtoupper(substr($company->company_name ?? 'C', 0, 2))
                                    : '';
                        @endphp

                        <div class="employer-list-item {{ $unreadCount > 0 ? 'has-unread' : '' }}"
                            data-employer-id="{{ $employerId }}" data-unread-count="{{ $unreadCount }}"
                            onclick="loadConversation({{ $employerId }})">

                            {{-- Avatar --}}
                            <div class="employer-avatar-wrapper">
                                @if ($company && $company->company_logo)
                                    <img src="{{ asset('storage/' . $company->company_logo) }}"
                                        alt="{{ $company->company_name ?? 'Company Logo' }}"
                                        class="employer-avatar-img">
                                @elseif ($company)
                                    <div class="employer-avatar-initials">{{ $initials }}</div>
                                @else
                                    <div class="employer-avatar-initials">C</div>
                                @endif

                                @if ($unreadCount > 0)
                                    <div class="online-status"></div>
                                @endif
                            </div>

                            {{-- Employer Info --}}
                            <div class="employer-info">
                                <div class="employer-name">
                                    {{ $employer->personal_info->first_name ?? 'N/A' }}
                                    {{ $employer->personal_info->last_name ?? 'N/A' }}
                                </div>
                                <div class="company-name">
                                    {{ $company->company_name ?? 'Company' }}
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
                        <div class="no-employers text-center">
                            <i class="bi bi-chat-dots fs-2 mb-2"></i>
                            <p>No conversations yet</p>
                        </div>
                    @endforelse
                </div>

            </div>

            <!-- Enhanced Chat Area -->
            <div class="chat-area">
                <!-- Professional Chat Header -->
                <div class="chat-header" id="chatHeader" style="display: none;">
                    <button class="back-to-list-btn" id="backToListBtn" onclick="showEmployersList()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div class="header-left">
                        <div class="current-employer-avatar">
                            <div class="avatar-placeholder" id="currentAvatar">E</div>
                        </div>
                        <div class="current-employer-info">
                            <h3 id="currentEmployerName">Select an employer</h3>
                            <p id="currentCompanyName">to start chatting</p>
                            @php
                                // Check if $employerId is set and not null
                                $is_online = isset($employerId)
                                    ? \App\Models\Employer\AccountInformationmodel::where('id', $employerId)->value(
                                        'is_online',
                                    )
                                    : null;
                            @endphp

                            @if ($is_online === 1)
                                <span class="online-status-text">Online</span>
                            @elseif ($is_online === 0)
                                <span class="offline-status-text">Offline</span>
                            @else
                                <span class="offline-status-text">No Employer</span>
                            @endif


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


                <div class="reply-area" id="replyArea" style="display: none;">
                    <form id="replyForm" class="reply-container">
                        @csrf
                        <input type="hidden" name="employer_id" id="replyEmployerId">

                        <!-- Attachment Preview Container -->
                        <div id="attachmentPreview" class="attachment-preview"></div>

                        <div class="message-input-wrapper">
                            <!-- File Upload -->
                            <label class="attachment-btn" for="attachment" title="Attach file">
                                <i class="bi bi-paperclip"></i>
                            </label>
                            <input type="file" name="attachment" id="attachment" class="d-none"
                                accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">

                            <!-- Message -->
                            <textarea class="reply-input" id="replyInput" name="message" placeholder="Type your message..." rows="2"></textarea>

                            <!-- Send Button -->
                            <button type="submit" class="send-btn" title="Send message">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>

                    <div class="typing-indicator" id="typingIndicator" style="display: none;">
                        <span>Employer is typing...</span>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

<!-- New message alert -->
<div id="newMessageAlert" class="new-message-alert" onclick="scrollToBottom()"
    style="display: none; position: fixed; bottom: 100px; right: 30px; background: #007bff; color: white; padding: 10px 20px; border-radius: 25px; cursor: pointer; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
    <i class="bi bi-arrow-down me-1"></i>
    New message
</div>

<!-- Auto-refresh indicator -->
<div id="refreshIndicator" class="refresh-indicator"
    style="display: none; position: fixed; top: 20px; right: 20px; background: rgba(0,0,0,0.7); color: white; padding: 8px 15px; border-radius: 20px; z-index: 9999; font-size: 14px;">
    <i class="bi bi-arrow-repeat spin-animation me-1"></i>
    Updating...
</div>



<!---Photo review--->
<script>
    document.getElementById('attachment').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('attachmentPreview');
        previewContainer.innerHTML = '';

        if (!file) return;

        const fileType = file.type;

        const previewItem = document.createElement('div');
        previewItem.classList.add('preview-item');

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '&times;';
        removeBtn.classList.add('remove-btn');
        removeBtn.type = 'button';
        removeBtn.onclick = () => {
            previewContainer.innerHTML = '';
            document.getElementById('attachment').value = '';
        };

        previewItem.appendChild(removeBtn);

        if (fileType.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            previewItem.appendChild(img);
        } else {
            const fileName = document.createElement('div');
            fileName.classList.add('file-name');
            fileName.textContent = file.name;
            previewItem.appendChild(fileName);
        }

        previewContainer.appendChild(previewItem);
    });
</script>

<script>
    // ========================================
    // VARIABLES & INITIALIZATION
    // ========================================
    let currentEmployerId = null;
    let allMessages = @json($messages);
    let lastMessageCount = 0;
    let isUserAtBottom = true;
    let isPageVisible = true;
    let lastSeenUpdateTime = 0;

    const messagesByEmployer = {};
    allMessages.forEach(msg => {
        if (!messagesByEmployer[msg.employer_id]) {
            messagesByEmployer[msg.employer_id] = [];
        }
        messagesByEmployer[msg.employer_id].push(msg);
    });

    // ========================================
    // MODAL & NAVIGATION FUNCTIONS
    // ========================================
    function openChatWithEmployer(employerId, firstName, lastName, companyName) {
        document.getElementById('chatModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        loadConversation(employerId);
    }

    function openAllChats() {
        document.getElementById('chatModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeChatModal() {
        document.getElementById('chatModal').style.display = 'none';
        document.body.style.overflow = 'auto';

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

        document.querySelectorAll('.employer-list-item').forEach(item => {
            item.classList.remove('active');
        });
    }

    function loadConversation(employerId) {
        currentEmployerId = employerId;

        const replyEmployerInput = document.getElementById('replyEmployerId');
        replyEmployerInput.value = employerId;

        document.querySelectorAll('.employer-list-item').forEach(item => {
            item.classList.remove('active');
        });
        const activeItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);
        if (activeItem) activeItem.classList.add('active');

        const employerMessages = messagesByEmployer[employerId] || [];

        if (employerMessages.length === 0) {
            displayMessages([]);
            document.getElementById('chatHeader').style.display = 'flex';
            document.getElementById('replyArea').style.display = 'block';

            if (window.innerWidth <= 768) {
                document.querySelector('.employers-sidebar').classList.add('hide-mobile');
            }
            return;
        }

        const employer = employerMessages[0].employer;

        const chatHeader = document.getElementById('chatHeader');
        chatHeader.style.display = 'flex';
        document.getElementById('currentEmployerName').textContent =
            `${employer.personal_info?.first_name || 'N/A'} ${employer.personal_info?.last_name || ''}`;
        document.getElementById('currentCompanyName').textContent =
            employer.address_company?.company_name || 'Company';

        const avatarElement = document.getElementById('currentAvatar');
        avatarElement.style.width = '50px';
        avatarElement.style.height = '50px';
        avatarElement.style.borderRadius = '50%';
        avatarElement.style.overflow = 'hidden';
        avatarElement.style.display = 'flex';
        avatarElement.style.alignItems = 'center';
        avatarElement.style.justifyContent = 'center';
        avatarElement.style.backgroundColor = '#f1f3f5';
        avatarElement.style.color = '#495057';
        avatarElement.style.fontWeight = '600';
        avatarElement.style.fontSize = '1.2rem';
        avatarElement.style.textTransform = 'uppercase';

        if (employer.address_company?.company_logo) {
            avatarElement.innerHTML = `<img src="/storage/${employer.address_company.company_logo}" 
        alt="${employer.address_company.company_name}" 
        style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        } else {
            avatarElement.textContent = (employer.address_company?.company_name || 'C').charAt(0).toUpperCase();
        }


        displayMessages(employerMessages);
        lastMessageCount = employerMessages.length;

        document.getElementById('replyArea').style.display = 'block';

        if (window.innerWidth <= 768) {
            document.querySelector('.employers-sidebar').classList.add('hide-mobile');
        }

        markMessagesAsRead(employerId);
    }

    function showEmployersList() {
        if (window.innerWidth <= 768) {
            document.querySelector('.employers-sidebar').classList.remove('hide-mobile');
        }
    }

    // ========================================
    // MESSAGE DISPLAY FUNCTIONS
    // ========================================
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

        messages.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));

        container.innerHTML = messages.map(msg => {
            const isFromEmployer = msg.sender_type === 'employer';
            const bubbleClass = isFromEmployer ? 'from-employer' : 'from-applicant';

            let attachmentHtml = '';
            if (msg.attachment) {
                attachmentHtml = `
                    <div class="message-attachment mt-2">
                        <img src="/storage/${msg.attachment}" 
                             alt="Attachment" 
                             class="img-fluid rounded-2 shadow-sm">
                    </div>
                `;
            }

            const timestamp = formatMessageTime(msg.created_at);
            const fullDate = new Date(msg.created_at).toLocaleString();

            return `
                <div class="message-bubble ${bubbleClass}" data-message-id="${msg.id}">
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

        if (isUserAtBottom) {
            setTimeout(() => scrollToBottom(), 100);
        }
    }

    function formatMessageTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInMinutes = Math.floor((now - date) / 1000 / 60);

        if (diffInMinutes < 1) return 'Just now';
        if (diffInMinutes < 60) return `${diffInMinutes}m ago`;
        if (diffInMinutes < 1440) return `${Math.floor(diffInMinutes / 60)}h ago`;
        return date.toLocaleDateString();
    }

    // ========================================
    // SCROLL FUNCTIONS
    // ========================================
    function scrollToBottom() {
        const container = document.getElementById('messagesContainer');
        if (container) {
            container.scrollTop = container.scrollHeight;
            document.getElementById('newMessageAlert').style.display = 'none';
            isUserAtBottom = true;
        }
    }

    function checkIfUserAtBottom() {
        const container = document.getElementById('messagesContainer');
        if (!container) return;

        const threshold = 50;
        isUserAtBottom = container.scrollTop + container.clientHeight >= container.scrollHeight - threshold;
    }

    // ========================================
    // REAL-TIME MESSAGE REFRESH
    // ========================================
    let lastMessageId = null; // track the last message received

    function refreshMessages() {
        if (!currentEmployerId) return;

        fetch(`/applicant/messages/fetch/${currentEmployerId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.messages) {
                    const container = document.getElementById('messagesContainer');

                    // Filter only new messages (based on last message ID)
                    let newMessages = lastMessageId ?
                        data.messages.filter(msg => msg.id > lastMessageId) :
                        data.messages;

                    // Append new messages
                    newMessages.forEach(msg => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'message-bubble ' +
                            (msg.sender_type === 'applicant' ? 'from-applicant' : 'from-employer');
                        messageDiv.innerHTML = `
                    <div class="message-content">
                        ${msg.message || ''}
                        ${msg.attachment ? 
                            `<div class="message-attachment mt-2">
                                <img src="/storage/${msg.attachment}" class="img-fluid rounded-2 shadow-sm">
                             </div>` 
                            : ''}
                        <div class="message-timestamp ${msg.sender_type}">
                            ${msg.time}
                        </div>
                    </div>
                `;
                        container.appendChild(messageDiv);
                    });

                    // Update last message ID
                    if (data.messages.length > 0) {
                        lastMessageId = data.messages[data.messages.length - 1].id;
                    }

                    // Handle scrolling and read logic
                    if (newMessages.length > 0) {
                        const isAtBottom = container.scrollHeight - container.scrollTop - container.clientHeight <
                            50;

                        // Auto-scroll if you're already at the bottom or the new message is from you
                        if (isAtBottom || newMessages.some(m => m.sender_type === 'applicant')) {
                            container.scrollTop = container.scrollHeight;
                        }

                        // ✅ Only mark as read if:
                        //    1) user is at bottom, and
                        //    2) the tab is visible
                        if (isAtBottom && document.visibilityState === 'visible') {
                            setTimeout(() => markMessagesAsRead(currentEmployerId), 800);
                        } else {
                            // Show alert for new message if not at bottom
                            const alertEl = document.getElementById('newMessageAlert');
                            if (alertEl) alertEl.style.display = 'block';
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error refreshing messages:', error);
            });
    }

    // ========================================
    // UPDATE UI FUNCTIONS
    // ========================================
    function updateEmployersList(newMessagesByEmployer) {
        const employersList = document.getElementById('employersList');
        if (!employersList) return;

        const employerEntries = Object.entries(newMessagesByEmployer);

        if (employerEntries.length === 0) {
            employersList.innerHTML = `
                <div class="no-employers">
                    <i class="bi bi-chat-dots"></i>
                    <p>No conversations yet</p>
                </div>
            `;
            return;
        }

        employerEntries.sort((a, b) => {
            const lastA = a[1].reduce((latest, msg) =>
                new Date(msg.created_at) > new Date(latest.created_at) ? msg : latest
            );
            const lastB = b[1].reduce((latest, msg) =>
                new Date(msg.created_at) > new Date(latest.created_at) ? msg : latest
            );
            return new Date(lastB.created_at) - new Date(lastA.created_at);
        });

        let html = '';

        employerEntries.forEach(([employerId, employerMessages]) => {
            const employer = employerMessages[0].employer;
            const unreadCount = employerMessages.filter(msg =>
                msg.sender_type === 'employer' && msg.is_read === 0
            ).length;
            const lastMessage = employerMessages.reduce((latest, msg) =>
                new Date(msg.created_at) > new Date(latest.created_at) ? msg : latest
            );

            html += `
                <div class="employer-list-item ${unreadCount > 0 ? 'has-unread' : ''} ${currentEmployerId == employerId ? 'active' : ''}"
                    data-employer-id="${employerId}" 
                    data-unread-count="${unreadCount}"
                    onclick="loadConversation(${employerId})">

                    <div class="employer-avatar">
                        ${employer.address_company?.company_logo 
                            ? `<img src="${employer.address_company.company_logo}" alt="${employer.address_company.company_name}">`
                            : `<div class="avatar-placeholder">${(employer.address_company?.company_name || 'C').charAt(0).toUpperCase()}</div>`
                        }
                        ${unreadCount > 0 ? '<div class="online-status"></div>' : ''}
                    </div>

                    <div class="employer-info">
                        <div class="employer-name">
                            ${employer.personal_info?.first_name || 'N/A'} ${employer.personal_info?.last_name || ''}
                        </div>
                        <div class="company-name">
                            ${employer.address_company?.company_name || 'Company'}
                        </div>
                        <div class="last-message-preview">
                            ${lastMessage.message ? lastMessage.message.substring(0, 30) : 'Attachment'}
                        </div>
                        <div class="last-message-time">
                            ${formatMessageTime(lastMessage.created_at)}
                        </div>
                    </div>

                    ${unreadCount > 0 ? `<span class="unread-count">${unreadCount}</span>` : ''}
                </div>
            `;
        });

        employersList.innerHTML = html;
    }

    function updateDropdownList(newMessagesByEmployer) {
        const messagesList = document.getElementById('dropdownMessagesList');
        if (!messagesList) return;

        const employerEntries = Object.entries(newMessagesByEmployer);

        if (employerEntries.length === 0) {
            messagesList.innerHTML = `
                <div class="no-messages">
                    <i class="bi bi-chat-dots"></i>
                    <p>No conversations yet</p>
                </div>
            `;
            return;
        }

        employerEntries.sort((a, b) => {
            const lastA = a[1].reduce((latest, msg) =>
                new Date(msg.created_at) > new Date(latest.created_at) ? msg : latest
            );
            const lastB = b[1].reduce((latest, msg) =>
                new Date(msg.created_at) > new Date(latest.created_at) ? msg : latest
            );
            return new Date(lastB.created_at) - new Date(lastA.created_at);
        });

        let html = '';

        employerEntries.forEach(([employerId, employerMessages]) => {
            const employer = employerMessages[0].employer;
            const unreadCount = employerMessages.filter(msg =>
                msg.sender_type === 'employer' && msg.is_read === 0
            ).length;
            const lastMessage = employerMessages.reduce((latest, msg) =>
                new Date(msg.created_at) > new Date(latest.created_at) ? msg : latest
            );
            const totalMessages = employerMessages.length;

            html += `
                <div class="employer-item ${unreadCount > 0 ? 'unread' : ''}"
                    data-employer-id="${employerId}" data-unread-count="${unreadCount}"
                    onclick="openChatWithEmployer(${employerId}, '${(employer.personal_info?.first_name || 'N/A').replace(/'/g, "\\'")}', '${(employer.personal_info?.last_name || '').replace(/'/g, "\\'")}', '${(employer.address_company?.company_name || 'Company').replace(/'/g, "\\'")}')">

                    ${unreadCount > 0 ? '<div class="unread-indicator"></div>' : ''}

                    <div class="message-avatar">
                        ${employer.address_company?.company_logo 
                            ? `<img src="${employer.address_company.company_logo}" alt="${employer.address_company.company_name}">`
                            : `<div class="avatar-placeholder">${(employer.address_company?.company_name || 'C').charAt(0).toUpperCase()}</div>`
                        }
                    </div>

                    <div class="message-content">
                        <div class="message-header">
                            <span class="sender-name">
                                ${employer.personal_info?.first_name || 'N/A'} ${employer.personal_info?.last_name || ''}
                            </span>
                            <span class="company-name">
                                ${employer.address_company?.company_name || 'Company'}
                            </span>
                            <div class="message-meta">
                                <span class="message-time">${formatMessageTime(lastMessage.created_at)}</span>
                                ${unreadCount > 0 ? `<span class="unread-count">${unreadCount}</span>` : ''}
                            </div>
                        </div>
                        <div class="message-preview">
                            ${totalMessages} message${totalMessages > 1 ? 's' : ''} •
                            ${lastMessage.message ? lastMessage.message.substring(0, 60) : 'Attachment'}
                        </div>
                    </div>

                    <button class="message-actions"
                        onclick="event.stopPropagation(); openChatWithEmployer(${employerId}, '${(employer.personal_info?.first_name || 'N/A').replace(/'/g, "\\'")}', '${(employer.personal_info?.last_name || '').replace(/'/g, "\\'")}', '${(employer.address_company?.company_name || 'Company').replace(/'/g, "\\'")}')"
                        title="Open chat">
                        <i class="bi bi-chat-square-text"></i>
                    </button>
                </div>
            `;
        });

        messagesList.innerHTML = html;
    }

    function updateBadgeCount(messages) {
        const badge = document.getElementById('messagesBadge');
        if (!badge) return;

        // Count only unread messages from employer
        const totalUnread = messages.reduce((count, msg) => {
            if (msg.sender_type === 'employer' && msg.is_read === 0) {
                return count + 1;
            }
            return count;
        }, 0);

        if (totalUnread > 0) {
            badge.textContent = totalUnread;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }


    // ========================================
    // MARK AS READ FUNCTION
    // ========================================
    function markMessagesAsRead(employerId) {
        const dropdownItem = document.querySelector(`.employer-item[data-employer-id="${employerId}"]`);
        const sidebarItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);

        const unreadCount = parseInt(dropdownItem?.dataset.unreadCount || sidebarItem?.dataset.unreadCount || 0);

        if (unreadCount === 0) {
            return;
        }

        // Prevent too frequent requests
        const now = Date.now();
        if (now - lastSeenUpdateTime < 2000) return;
        lastSeenUpdateTime = now;

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

                    if (dropdownItem) {
                        dropdownItem.classList.remove('unread');
                        dropdownItem.dataset.unreadCount = '0';

                        const unreadIndicator = dropdownItem.querySelector('.unread-indicator');
                        if (unreadIndicator) unreadIndicator.remove();

                        const unreadCountBadge = dropdownItem.querySelector('.unread-count');
                        if (unreadCountBadge) unreadCountBadge.remove();
                    }

                    if (sidebarItem) {
                        sidebarItem.classList.remove('has-unread');
                        sidebarItem.dataset.unreadCount = '0';

                        const onlineStatus = sidebarItem.querySelector('.online-status');
                        if (onlineStatus) onlineStatus.remove();

                        const unreadCountBadge = sidebarItem.querySelector('.unread-count');
                        if (unreadCountBadge) unreadCountBadge.remove();
                    }

                    const badge = document.getElementById('messagesBadge');
                    if (badge && unreadCount > 0) {
                        let currentCount = parseInt(badge.textContent) || 0;
                        const newCount = Math.max(currentCount - unreadCount, 0);
                        badge.textContent = newCount;

                        if (newCount === 0) {
                            badge.style.display = 'none';
                        }
                    }

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
                console.error(' Error marking messages as read:', error);
            });
    }

    // ========================================
    // FORM SUBMISSION
    // ========================================
    document.addEventListener('DOMContentLoaded', function() {
        const replyForm = document.getElementById('replyForm');

        replyForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(replyForm);
            const messageText = document.getElementById('replyInput').value.trim();
            const attachmentFile = document.getElementById('attachment').files[0];

            if (!messageText && !attachmentFile) {
                return;
            }

            // Optimistically add message to UI
            if (messageText || attachmentFile) {
                const container = document.getElementById('messagesContainer');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message-bubble from-applicant';
                messageDiv.innerHTML = `
                    <div class="message-content">
                        ${messageText || ''}
                        ${attachmentFile ? `<div class="message-attachment mt-2"><img src="${URL.createObjectURL(attachmentFile)}" class="img-fluid rounded-2 shadow-sm"></div>` : ''}
                        <div class="message-timestamp from-applicant">Just now</div>
                    </div>
                `;
                container.appendChild(messageDiv);
                container.scrollTop = container.scrollHeight;
            }

            // Clear input
            document.getElementById('replyInput').value = '';
            document.getElementById('attachment').value = '';
            document.getElementById('attachmentPreview').innerHTML = '';

            try {
                const response = await fetch(
                    '{{ route('applicant.sendmessageemployer.store') }}', {
                        method: 'POST',
                        body: formData
                    });

                const result = await response.json();

                if (result.success) {
                    console.log(' Message sent successfully');
                    // Immediate refresh after sending
                    setTimeout(() => {
                        refreshMessages();
                    }, 100);
                } else {
                    console.error(' Failed to send message');
                }
            } catch (error) {
                console.error(' Error:', error);
            }
        });

        // Add scroll listener
        const container = document.getElementById('messagesContainer');
        if (container) {
            container.addEventListener('scroll', () => {
                checkIfUserAtBottom();
                if (isUserAtBottom && currentEmployerId) {
                    setTimeout(() => markMessagesAsRead(currentEmployerId), 500);
                }
            });
        }

        // Page visibility handling
        document.addEventListener('visibilitychange', function() {
            isPageVisible = !document.hidden;
            if (isPageVisible && isUserAtBottom && currentEmployerId) {
                setTimeout(() => markMessagesAsRead(currentEmployerId), 1000);
            }
        });

        // Initialize message count
        if (currentEmployerId && messagesByEmployer[currentEmployerId]) {
            lastMessageCount = messagesByEmployer[currentEmployerId].length;
        }

        // ========================================
        // START REAL-TIME POLLING
        // ========================================
        console.log('Starting real-time message system...');

        // Refresh messages every 2 seconds
        setInterval(() => {
            if (isPageVisible) {
                refreshMessages();
            }
        }, 2000);

        // Initial refresh after 1 second
        setTimeout(refreshMessages, 1000);

        console.log(' Real-time messaging active (polling every 2 seconds)');
    });
</script>
