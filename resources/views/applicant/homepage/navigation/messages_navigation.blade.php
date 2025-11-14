<!-- Messages Dropdown -->
<div class="nav-dropdown">
    <button class="nav-icon" onclick="toggleDropdown('messagesDropdown')" title="messages">
        <i class="bi bi-chat-dots"></i>

        @php
            $unreadCount = $messages->where('sender_type', 'employer')->where('is_read', 0)->count();
        @endphp

        @if ($unreadCount > 0)
            <span class="nav-badge" id="messagesBadge">{{ $unreadCount }}</span>
        @else
            <span class="nav-badge" id="messagesBadge" style="display: none;">0</span>
        @endif
    </button>


    <div class="dropdown-menu" id="messagesDropdown">
        <div class="dropdown-header">
            <h6>Messages</h6>
            <button class="mark-all-read" onclick="markAllAsRead('messages')">Mark all as read</button>
        </div>

        <div class="dropdown-content">
            <div class="messages-list" id="dropdownMessagesList">
                @php
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
                        data-employer-id="{{ $employerId }}" data-unread-count="{{ $unreadCount }}"
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
    // VARIABLES & INITIALIZATION - FIXED WITH LOCALSTORAGE
    // ========================================
    let currentEmployerId = null;
    let allMessages = @json($messages);
    let lastMessageCount = 0;
    let isUserAtBottom = true;
    let isPageVisible = true;
    let lastSeenUpdateTime = 0;
    let lastMessageId = 0;
    let isChatModalOpen = false;
    let isActivelyViewingMessages = false;
    let messageReadTimer = null;
    const markedAsReadEmployers = new Set(); // FIX: Track all marked conversations with a Set

    const messagesByEmployer = {};
    allMessages.forEach(msg => {
        if (!messagesByEmployer[msg.employer_id]) {
            messagesByEmployer[msg.employer_id] = [];
        }
        messagesByEmployer[msg.employer_id].push(msg);
    });

    // Initialize which employers have been marked as read
    Object.keys(messagesByEmployer).forEach(employerId => {
        const unreadCount = messagesByEmployer[employerId].filter(msg =>
            msg.sender_type === 'employer' && msg.is_read === 0
        ).length;
        if (unreadCount === 0) {
            markedAsReadEmployers.add(parseInt(employerId));
        }
    });

    // FIX: Initialize localStorage with current unread count on page load
    function initializeUnreadCountStorage() {
        const currentBadge = document.getElementById('messagesBadge');
        if (currentBadge && currentBadge.textContent) {
            const currentCount = parseInt(currentBadge.textContent) || 0;
            localStorage.setItem('unreadMessagesCount', currentCount.toString());
        }
    }

    // FIX: Restore unread count from localStorage on page load
    function restoreUnreadCountFromStorage() {
        const storedCount = localStorage.getItem('unreadMessagesCount');
        if (storedCount !== null) {
            const badge = document.getElementById('messagesBadge');
            const count = parseInt(storedCount);
            if (badge) {
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        }
    }

    // FIX: Update localStorage when unread count changes
    function updateUnreadCountStorage(newCount) {
        localStorage.setItem('unreadMessagesCount', newCount.toString());
    }

    // ========================================
    // MODAL & NAVIGATION FUNCTIONS
    // ========================================
    function openChatWithEmployer(employerId, firstName, lastName, companyName) {
        document.getElementById('chatModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        isChatModalOpen = true;
        loadConversation(employerId);
    }

    function openAllChats() {
        document.getElementById('chatModal').style.display = 'flex';
        document.body.style.overflow = 'auto';
        isChatModalOpen = true;
    }

    function closeChatModal() {
        document.getElementById('chatModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        isChatModalOpen = false;
        isActivelyViewingMessages = false;
        currentEmployerId = null;

        if (messageReadTimer) {
            clearTimeout(messageReadTimer);
            messageReadTimer = null;
        }

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
        if (messageReadTimer) {
            clearTimeout(messageReadTimer);
            messageReadTimer = null;
        }

        currentEmployerId = employerId;
        isActivelyViewingMessages = false;

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

        // FIX: Only mark as read if not already marked
        if (!markedAsReadEmployers.has(employerId)) {
            messageReadTimer = setTimeout(() => {
                if (isChatModalOpen && currentEmployerId === employerId && isUserAtBottom && isPageVisible) {
                    isActivelyViewingMessages = true;
                    markMessagesAsRead(employerId);
                }
            }, 3000);
        }
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

            const hasValidText = msg.message &&
                msg.message.trim() !== '' &&
                msg.message !== 'Unable to decrypt message' &&
                msg.message !== 'Cannot decrypt message' &&
                !msg.message.includes('decrypt');

            const hasAttachment = msg.attachment && msg.attachment.trim() !== '';

            if (!hasValidText && !hasAttachment) {
                return '';
            }

            let messageTextHtml = '';
            if (hasValidText) {
                messageTextHtml = `<div class="message-text">${escapeHtml(msg.message)}</div>`;
            }

            let attachmentHtml = '';
            if (hasAttachment) {
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
                    ${messageTextHtml}
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
            isUserAtBottom = true;
        }
    }

    function checkIfUserAtBottom() {
        const container = document.getElementById('messagesContainer');
        if (!container) return;

        const threshold = 50;
        const wasAtBottom = isUserAtBottom;
        isUserAtBottom = container.scrollTop + container.clientHeight >= container.scrollHeight - threshold;

        if (!wasAtBottom && isUserAtBottom && currentEmployerId && isActivelyViewingMessages && !markedAsReadEmployers
            .has(currentEmployerId)) {
            if (messageReadTimer) {
                clearTimeout(messageReadTimer);
            }
            messageReadTimer = setTimeout(() => {
                if (isUserAtBottom && isChatModalOpen && isPageVisible && !markedAsReadEmployers.has(
                        currentEmployerId)) {
                    isActivelyViewingMessages = true;
                    markMessagesAsRead(currentEmployerId);
                }
            }, 3000);
        }
    }

    // ========================================
    // REAL-TIME MESSAGE REFRESH - FIXED VERSION
    // ========================================
    function refreshMessages() {
        if (!currentEmployerId || !isChatModalOpen) return;

        fetch(`/applicant/messages/fetch/${currentEmployerId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (!(data && data.success && Array.isArray(data.messages))) return;

                const container = document.getElementById('messagesContainer');
                if (!container) return;

                const wasAtBottom = container.scrollHeight - container.scrollTop - container.clientHeight < 100;

                const existingIds = new Set();
                container.querySelectorAll('[data-message-id]').forEach(el => {
                    const id = el.getAttribute('data-message-id');
                    if (id) {
                        existingIds.add(parseInt(id));
                    }
                });

                let hasNewMessages = false;

                // FIX: Only append truly new messages
                data.messages.forEach(msg => {
                    if (existingIds.has(msg.id)) {
                        return;
                    }

                    const hasValidText = msg.message &&
                        msg.message.trim() !== '' &&
                        msg.message !== 'Unable to decrypt message' &&
                        msg.message !== 'Cannot decrypt message';

                    const hasAttachment = msg.attachment && msg.attachment.trim() !== '';

                    if (!hasValidText && !hasAttachment) {
                        return;
                    }

                    hasNewMessages = true;

                    const messageDiv = document.createElement('div');
                    const bubbleClass = msg.sender_type === 'applicant' ? 'from-applicant' :
                        'from-employer';
                    messageDiv.className = `message-bubble ${bubbleClass}`;
                    messageDiv.setAttribute('data-message-id', msg.id);

                    let contentHtml = '';

                    if (hasValidText) {
                        contentHtml += `<div class="message-text">${escapeHtml(msg.message)}</div>`;
                    }

                    if (hasAttachment) {
                        contentHtml += `<div class="message-attachment mt-2">
                       <img src="/storage/${encodeURI(msg.attachment)}" class="img-fluid rounded-2 shadow-sm" alt="attachment">
                   </div>`;
                    }

                    contentHtml +=
                        `<div class="message-timestamp ${bubbleClass}">${escapeHtml(msg.time || 'Just now')}</div>`;

                    messageDiv.innerHTML = `<div class="message-content">${contentHtml}</div>`;
                    container.appendChild(messageDiv);
                });

                // FIX: Update local message store only with truly new data
                messagesByEmployer[currentEmployerId] = data.messages;

                if (data.messages.length > 0) {
                    lastMessageId = data.messages[data.messages.length - 1].id;
                }

                if (hasNewMessages && wasAtBottom) {
                    setTimeout(() => {
                        container.scrollTop = container.scrollHeight;
                        isUserAtBottom = true;
                    }, 10);
                }

                updateUnreadCountsInUI();
            })
            .catch(error => {
                console.error('Error refreshing messages:', error);
            });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // ========================================
    // UPDATE UI FUNCTIONS
    // ========================================
    function updateUnreadCountsInUI() {
        let totalUnread = 0;
        Object.values(messagesByEmployer).forEach(messages => {
            messages.forEach(msg => {
                if (msg.sender_type === 'employer' && msg.is_read === 0) {
                    totalUnread++;
                }
            });
        });

        const badge = document.getElementById('messagesBadge');
        if (badge) {
            if (totalUnread > 0) {
                badge.textContent = totalUnread;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
            // FIX: Update localStorage whenever UI updates
            updateUnreadCountStorage(totalUnread);
        }

        Object.keys(messagesByEmployer).forEach(employerId => {
            const unreadCount = messagesByEmployer[employerId].filter(msg =>
                msg.sender_type === 'employer' && msg.is_read === 0
            ).length;

            const dropdownItem = document.querySelector(`.employer-item[data-employer-id="${employerId}"]`);
            const sidebarItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);

            if (dropdownItem) {
                dropdownItem.dataset.unreadCount = unreadCount;
                if (unreadCount > 0) {
                    dropdownItem.classList.add('unread');
                } else {
                    dropdownItem.classList.remove('unread');
                    const indicator = dropdownItem.querySelector('.unread-indicator');
                    if (indicator) indicator.remove();
                }
            }

            if (sidebarItem) {
                sidebarItem.dataset.unreadCount = unreadCount;
                if (unreadCount > 0) {
                    sidebarItem.classList.add('has-unread');
                } else {
                    sidebarItem.classList.remove('has-unread');
                    const status = sidebarItem.querySelector('.online-status');
                    if (status) status.remove();
                }
            }
        });
    }

    // ========================================
    // MARK AS READ FUNCTION - FIXED
    // ========================================
    function markMessagesAsRead(employerId) {
        // FIX: Prevent marking as read if already marked
        if (markedAsReadEmployers.has(employerId)) {
            return;
        }

        const dropdownItem = document.querySelector(`.employer-item[data-employer-id="${employerId}"]`);
        const sidebarItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);

        const unreadCount = parseInt(dropdownItem?.dataset.unreadCount || sidebarItem?.dataset.unreadCount || 0);

        if (unreadCount === 0) {
            markedAsReadEmployers.add(employerId);
            return;
        }

        const now = Date.now();
        if (now - lastSeenUpdateTime < 5000) {
            return;
        }
        lastSeenUpdateTime = now;

        console.log('✅ Marking messages as read for employer:', employerId);

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
                    console.log('✅ Messages marked as read successfully');

                    // FIX: Add to marked set to prevent marking again
                    markedAsReadEmployers.add(employerId);

                    if (messagesByEmployer[employerId]) {
                        messagesByEmployer[employerId].forEach(msg => {
                            if (msg.sender_type === 'employer') {
                                msg.is_read = 1;
                            }
                        });
                    }

                    if (dropdownItem) {
                        dropdownItem.classList.remove('unread');
                        dropdownItem.dataset.unreadCount = '0';
                        const indicator = dropdownItem.querySelector('.unread-indicator');
                        if (indicator) indicator.remove();
                    }

                    if (sidebarItem) {
                        sidebarItem.classList.remove('has-unread');
                        sidebarItem.dataset.unreadCount = '0';
                        const onlineStatus = sidebarItem.querySelector('.online-status');
                        if (onlineStatus) onlineStatus.remove();
                    }

                    const badge = document.getElementById('messagesBadge');
                    if (badge) {
                        let currentCount = parseInt(badge.textContent) || 0;
                        const newCount = Math.max(currentCount - unreadCount, 0);
                        badge.textContent = newCount;
                        if (newCount === 0) {
                            badge.style.display = 'none';
                        }
                        // FIX: Update localStorage
                        updateUnreadCountStorage(newCount);
                    }
                }
            })
            .catch(error => {
                console.error('❌ Error marking messages as read:', error);
            });
    }

    // ========================================
    // FORM SUBMISSION
    // ========================================
    document.addEventListener('DOMContentLoaded', function() {
        // FIX: Restore unread count from localStorage on page load
        restoreUnreadCountFromStorage();

        // FIX: Initialize localStorage with current count
        initializeUnreadCountStorage();

        const replyForm = document.getElementById('replyForm');

        replyForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            let messageText = document.getElementById('replyInput').value.trim();
            const attachmentFile = document.getElementById('attachment').files[0];

            if (!messageText && !attachmentFile) {
                return;
            }

            const formData = new FormData(replyForm);

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
                    console.log('✅ Message sent successfully');
                    setTimeout(() => refreshMessages(), 200);
                } else {
                    console.error('❌ Failed to send message');
                }
            } catch (error) {
                console.error('❌ Error:', error);
            }
        });

        const container = document.getElementById('messagesContainer');
        if (container) {
            container.addEventListener('scroll', () => {
                checkIfUserAtBottom();
            });
        }

        document.addEventListener('visibilitychange', function() {
            isPageVisible = !document.hidden;
        });

        if (currentEmployerId && messagesByEmployer[currentEmployerId]) {
            lastMessageCount = messagesByEmployer[currentEmployerId].length;
        }

        console.log('🚀 Starting real-time message system...');

        setInterval(() => {
            if (isPageVisible && isChatModalOpen && currentEmployerId) {
                refreshMessages();
            }
        }, 3000);

        setTimeout(() => {
            if (isChatModalOpen && currentEmployerId) {
                refreshMessages();
            }
        }, 1000);

        console.log('✅ Real-time messaging active');
    });
</script>
