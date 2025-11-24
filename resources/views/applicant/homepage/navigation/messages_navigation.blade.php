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

        <div class="messages-list" id="dropdownMessagesList" style="max-height: 450px; overflow-y: auto;">
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
                    $unreadCount = $employerMessages->where('sender_type', 'employer')->where('is_read', 0)->count();
                    $initials =
                        $company && !$company->company_logo
                            ? strtoupper(substr($company->company_name ?? 'C', 0, 2))
                            : '';
                @endphp

                <div class="employer-item {{ $unreadCount > 0 ? 'unread' : '' }}" data-employer-id="{{ $employerId }}"
                    data-unread-count="{{ $unreadCount }}"
                    onclick="openChatWithEmployer({{ $employerId }}, '{{ addslashes($employer->personal_info->first_name ?? 'N/A') }}', '{{ addslashes($employer->personal_info->last_name ?? 'N/A') }}', '{{ addslashes($company->company_name ?? 'Company') }}')">

                    @if ($unreadCount > 0)
                        <div class="unread-indicator"></div>
                    @endif

                    <div class="message-avatar-wrapper">
                        @if ($company && $company->company_logo)
                            <img src="{{ asset('storage/' . $company->company_logo) }}"
                                alt="{{ $company->company_name ?? 'Company Logo' }}" class="message-avatar-img">
                        @else
                            <div class="message-avatar-initials">{{ $initials ?: 'C' }}</div>
                        @endif
                    </div>

                    <div class="message-content">
                        <div class="message-header">
                            <span class="sender-name">{{ $employer->personal_info->first_name ?? 'N/A' }} - </span>
                            <span class="company-name">{{ $company->company_name ?? 'Company' }}</span>
                            <span class="message-time">{{ $lastMessage->created_at->diffForHumans() }}</span>
                            @if ($unreadCount > 0)
                                <span class="unread-count">{{ $unreadCount }}</span>
                            @endif
                        </div>

                        <div class="company-name">{{ $company->company_name ?? 'Company' }}</div>

                        <div class="message-preview">
                            {{ Str::limit($lastMessage->message, 50) }}
                        </div>

                        @if ($unreadCount > 0)
                            <span class="unread-count">{{ $unreadCount }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="no-messages text-center p-4">
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

<!-- Chat Modal (friendlist replica) -->
<div id="chatModal" class="chat-modal" style="display: none;">
    <div class="chat-modal-overlay" onclick="closeChatModal()"></div>
    <div class="chat-modal-content">
        <div class="chat-container">
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
                        <div class="no-employers text-center p-4">
                            <i class="bi bi-chat-dots fs-2 mb-2"></i>
                            <p>No conversations yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="chat-area">
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

                <!-- Messages Container - FRIENDLIST REPLICA with Backend Integration -->
                <div class="messages-container" id="messagesContainer" style="display: none;">
                    <button id="scrollUpBtn" class="btn btn-light position-absolute"
                        style="top: 1rem; right: 1rem; z-index: 10;" onclick="scrollToTop()" title="Scroll to top">
                        <i class="fas fa-arrow-up"></i>
                    </button>

                    <div id="messagesWrapper">
                        <!-- Messages will be injected here by JavaScript -->
                    </div>

                    <!-- Typing Indicator -->
                    <div id="typingIndicator" class="typing-indicator" style="display:none;">
                        <div class="typing-text">
                            <span id="typingUsername">Employer</span> is typing
                            <div class="typing-dots">
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reply-area" id="replyArea" style="display: none;">
                    <form id="replyForm" class="reply-container">
                        @csrf
                        <input type="hidden" name="employer_id" id="replyEmployerId">

                        <div id="attachmentPreview" class="attachment-preview"></div>

                        <div class="message-input">
                            <div class="input-container">
                                <!-- File Input (Hidden) -->
                                <input type="file" id="photoInput" accept="image/*" name="photo"
                                    style="display: none;">

                                <!-- Upload Button -->
                                <button type="button" class="btn btn-light"
                                    onclick="document.getElementById('photoInput').click()" title="Attach Photo">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path
                                            d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66L9.64 16.2a2 2 0 0 1-2.83-2.83l8.49-8.49">
                                        </path>
                                    </svg>
                                </button>

                                <!-- Message Text Field -->
                                <input type="text" class="message-field" placeholder="Type your message..."
                                    name="message" id="messageInput">

                                <!-- Send Button -->
                                <button type="submit" class="send-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                        <polygon points="22,2 15,22 11,13 2,9 22,2"></polygon>
                                    </svg>
                                </button>
                            </div>

                            <!-- Preview Area -->
                            <div id="photoPreview" class="mt-2"></div>
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
    // PROFANITY FILTER SYSTEM - AUTO FILTER
    // ========================================

    // ========================================
    // PROFANITY FILTER SYSTEM - AUTO FILTER
    // ========================================

    // Comprehensive bad words list in multiple languages
    const profanityList = [
        // English profanity
        'fuck', 'shit', 'bitch', 'ass', 'bastard', 'damn', 'crap', 'piss',
        'dick', 'cock', 'pussy', 'cunt', 'whore', 'slut', 'fag', 'nigger',
        'retard', 'idiot', 'moron', 'dumbass', 'asshole', 'motherfucker',
        'bullshit', 'goddamn', 'wtf', 'stfu', 'milf', 'dildo', 'jackass',
        'piece of shit', 'bitch ass', 'dumb fuck', 'shut up', 'stupid',
        'hell', 'bloody', 'bugger', 'wanker', 'twat', 'douche',

        // Tagalog/Filipino profanity
        'putang', 'putangina', 'puta', 'gago', 'tangina', 'tarantado',
        'ulol', 'bobo', 'tanga', 'tarantada', 'pakyu', 'punyeta',
        'hayop', 'hindot', 'kantot', 'buwisit', 'leche', 'yawa',
        'peste', 'hinayupak', 'animal', 'kupal', 'kingina', 'potangina',
        'taena', 'tanginamo', 'shibal', 'mamatay',

        // Spanish profanity
        'puta', 'mierda', 'coño', 'joder', 'pendejo', 'idiota',
        'estúpido', 'carajo', 'puto', 'cabron', 'culo', 'verga',

        // Common variations and leetspeak
        'fck', 'fuk', 'sh1t', 'b1tch', 'a$', 'fvck', 'phuck',
        'azz', 'biatch', 'beotch', 'p00sy', 'c0ck', 'sh!t'
    ];

    /**
     * Filter profanity from text - automatically replaces with asterisks
     */
    function filterProfanity(text) {
        if (!text) return text;

        let filteredText = text;

        profanityList.forEach(word => {
            const regex = new RegExp('\\b' + word + '\\b', 'gi');
            filteredText = filteredText.replace(regex, (match) => {
                return '*'.repeat(match.length);
            });
        });

        return filteredText;
    }

    // ========================================
    // VARIABLES & INITIALIZATION
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
    let hasMarkedAsReadForCurrentEmployer = false; // NEW: Track if we've already marked this conversation as read

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
        document.getElementById('messagesContainer').style.display = 'none'; // Hide container
        document.body.style.overflow = 'auto';
        isChatModalOpen = false;
        isActivelyViewingMessages = false;
        currentEmployerId = null;
        hasMarkedAsReadForCurrentEmployer = false;

        if (messageReadTimer) {
            clearTimeout(messageReadTimer);
            messageReadTimer = null;
        }

        document.getElementById('chatHeader').style.display = 'none';
        document.getElementById('replyArea').style.display = 'none';

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
        hasMarkedAsReadForCurrentEmployer = false;



        const replyEmployerInput = document.getElementById('replyEmployerId');
        replyEmployerInput.value = employerId;

        // Highlight active employer
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

        // Start timer to mark as read ONLY ONCE after 3 seconds of viewing
        messageReadTimer = setTimeout(() => {
            if (isChatModalOpen && currentEmployerId === employerId && isUserAtBottom && isPageVisible && !
                hasMarkedAsReadForCurrentEmployer) {
                isActivelyViewingMessages = true;
                markMessagesAsRead(employerId);
            }
        }, 3000);
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
        const wrapper = document.getElementById('messagesWrapper');

        // Show the container when displaying messages
        container.style.display = 'block';

        if (messages.length === 0) {
            wrapper.innerHTML = `
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

        // Sort messages chronologically
        messages.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));

        wrapper.innerHTML = messages.map(msg => renderMessageHtml(msg)).join('');

        if (isUserAtBottom) {
            setTimeout(() => scrollToBottom(), 100);
        }
    }

    // ========================================
    // REFRESH MESSAGES (uses same renderer)
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

                const wrapper = document.getElementById('messagesWrapper');
                if (!wrapper) return;

                const wasAtBottom = wrapper.scrollHeight - wrapper.scrollTop - wrapper.clientHeight < 100;

                // Get existing message IDs
                const existingIds = new Set();
                wrapper.querySelectorAll('[data-message-id]').forEach(el => {
                    const id = el.getAttribute('data-message-id');
                    if (id) existingIds.add(parseInt(id));
                });

                let hasNewMessages = false;

                // Update local store
                messagesByEmployer[currentEmployerId] = data.messages;

                // Append only NEW messages
                data.messages.forEach(msg => {
                    if (existingIds.has(msg.id)) return;

                    const html = renderMessageHtml(msg);
                    if (html) {
                        wrapper.insertAdjacentHTML('beforeend', html);
                        hasNewMessages = true;
                    }
                });

                if (data.messages.length > 0) {
                    lastMessageId = data.messages[data.messages.length - 1].id;
                }

                // Auto-scroll if user was at bottom
                if (hasNewMessages && wasAtBottom) {
                    setTimeout(() => {
                        wrapper.scrollTop = wrapper.scrollHeight;
                        isUserAtBottom = true;
                    }, 10);

                    if (isActivelyViewingMessages && isPageVisible && hasMarkedAsReadForCurrentEmployer) {
                        setTimeout(() => markMessagesAsRead(currentEmployerId), 1000);
                    }
                }

                updateUnreadCountsInUI();
            })
            .catch(error => {
                console.error('Error refreshing messages:', error);
            });
    }

    // ========================================
    // HELPER: RENDER SINGLE MESSAGE
    // ========================================
    function renderMessageHtml(msg) {
        const isFromEmployer = msg.sender_type === 'employer';
        const bubbleClass = isFromEmployer ? 'received' : 'sent';

        const hasValidText = msg.message &&
            msg.message.trim() !== '' &&
            msg.message !== 'Unable to decrypt message' &&
            msg.message !== 'Cannot decrypt message' &&
            !msg.message.includes('decrypt');

        const hasAttachment = msg.attachment && msg.attachment.trim() !== '';

        if (!hasValidText && !hasAttachment) return '';

        let messageTextHtml = '';
        if (hasValidText) {
            messageTextHtml = `<div class="message-text"><p>${escapeHtml(msg.message)}</p></div>`;
        }

        let attachmentHtml = '';
        if (hasAttachment) {
            attachmentHtml = `
            <div class="message-image">
                <img src="/storage/${encodeURI(msg.attachment)}" 
                     alt="Attachment"
                     class="img-fluid rounded"
                     style="max-width: 200px; cursor: pointer;"
                     onclick="previewImage('/storage/${encodeURI(msg.attachment)}')">
            </div>
        `;
        }

        const timestamp = formatMessageTime(msg.created_at);

        let statusHtml = '';
        if (!isFromEmployer) {
            if (msg.is_read === 1 || msg.is_read === true) {
                statusHtml = `<span class="text-success ms-2"><i class="fas fa-check-double"></i> Seen</span>`;
            } else {
                statusHtml = `<span class="text-muted ms-2"><i class="fas fa-check"></i> Delivered</span>`;
            }
        }

        return `
        <div class="chat-wrapper ${bubbleClass}" data-message-id="${msg.id}">
            <div class="bubble-container">
                ${messageTextHtml}
                ${attachmentHtml}
                <div class="timestamp">
                    ${timestamp}
                    ${statusHtml}
                </div>
            </div>
        </div>
    `;
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
        const container = document.getElementById('message-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
            isUserAtBottom = true;
        }
    }

    function checkIfUserAtBottom() {
        const container = document.getElementById('message-container');
        if (!container) return;

        const threshold = 50;
        const wasAtBottom = isUserAtBottom;
        isUserAtBottom = container.scrollTop + container.clientHeight >= container.scrollHeight - threshold;

        // Only trigger mark as read if scrolling TO bottom AND haven't marked yet
        if (!wasAtBottom && isUserAtBottom && currentEmployerId && !isActivelyViewingMessages && !
            hasMarkedAsReadForCurrentEmployer) {
            if (messageReadTimer) {
                clearTimeout(messageReadTimer);
            }
            messageReadTimer = setTimeout(() => {
                if (isUserAtBottom && isChatModalOpen && isPageVisible && !hasMarkedAsReadForCurrentEmployer) {
                    isActivelyViewingMessages = true;
                    markMessagesAsRead(currentEmployerId);
                }
            }, 3000);
        }
    }

    // ========================================
    // REAL-TIME MESSAGE REFRESH - FIXED VERSION
    // ========================================


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
        // Update badge count
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
        }

        // Update individual employer items
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
                    if (!dropdownItem.querySelector('.unread-indicator')) {
                        const indicator = document.createElement('div');
                        indicator.className = 'unread-indicator';
                        dropdownItem.insertBefore(indicator, dropdownItem.firstChild);
                    }
                    let countBadge = dropdownItem.querySelector('.unread-count');
                    if (!countBadge) {
                        countBadge = document.createElement('span');
                        countBadge.className = 'unread-count';
                        dropdownItem.querySelector('.message-meta').appendChild(countBadge);
                    }
                    countBadge.textContent = unreadCount;
                } else {
                    dropdownItem.classList.remove('unread');
                    const indicator = dropdownItem.querySelector('.unread-indicator');
                    if (indicator) indicator.remove();
                    const countBadge = dropdownItem.querySelector('.unread-count');
                    if (countBadge) countBadge.remove();
                }
            }

            if (sidebarItem) {
                sidebarItem.dataset.unreadCount = unreadCount;
                if (unreadCount > 0) {
                    sidebarItem.classList.add('has-unread');
                    if (!sidebarItem.querySelector('.online-status')) {
                        const status = document.createElement('div');
                        status.className = 'online-status';
                        sidebarItem.querySelector('.employer-avatar').appendChild(status);
                    }
                    let countBadge = sidebarItem.querySelector('.unread-count');
                    if (!countBadge) {
                        countBadge = document.createElement('span');
                        countBadge.className = 'unread-count';
                        sidebarItem.appendChild(countBadge);
                    }
                    countBadge.textContent = unreadCount;
                } else {
                    sidebarItem.classList.remove('has-unread');
                    const status = sidebarItem.querySelector('.online-status');
                    if (status) status.remove();
                    const countBadge = sidebarItem.querySelector('.unread-count');
                    if (countBadge) countBadge.remove();
                }
            }
        });
    }

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
                        ${lastMessage.created_at}
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
    // MARK AS READ FUNCTION - IMPROVED
    // ========================================
    function markMessagesAsRead(employerId) {
        // Prevent marking as read if not actively viewing or already marked
        if (!isActivelyViewingMessages || !isChatModalOpen || !isPageVisible || hasMarkedAsReadForCurrentEmployer) {
            console.log('⛔ NOT marking as read - Conditions not met');
            return;
        }

        const dropdownItem = document.querySelector(`.employer-item[data-employer-id="${employerId}"]`);
        const sidebarItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);

        const unreadCount = parseInt(dropdownItem?.dataset.unreadCount || sidebarItem?.dataset.unreadCount || 0);

        if (unreadCount === 0) {
            return;
        }

        const now = Date.now();
        if (now - lastSeenUpdateTime < 5000) {
            console.log('⏱️ Rate limit - waiting before marking as read');
            return;
        }
        lastSeenUpdateTime = now;

        // Set flag to prevent repeated marking
        hasMarkedAsReadForCurrentEmployer = true;

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

                    // Update local message store
                    if (messagesByEmployer[employerId]) {
                        messagesByEmployer[employerId].forEach(msg => {
                            if (msg.sender_type === 'employer') {
                                msg.is_read = 1;
                            }
                        });
                    }

                    // Update UI elements
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
                }
            })
            .catch(error => {
                console.error('❌ Error marking messages as read:', error);
                hasMarkedAsReadForCurrentEmployer = false; // Reset flag on error
            });
    }

    // ========================================
    // FORM SUBMISSION WITH AUTO PROFANITY FILTER
    // ========================================
    document.addEventListener('DOMContentLoaded', function() {
        const replyForm = document.getElementById('replyForm');
        const messageInput = document.getElementById('messageInput');
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');

        if (!replyForm) {
            console.error('Reply form not found');
            return;
        }

        // Handle photo preview
        if (photoInput) {
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                photoPreview.innerHTML = '';

                if (!file) return;

                const fileType = file.type;
                const previewItem = document.createElement('div');
                previewItem.classList.add('preview-item');
                previewItem.style.position = 'relative';
                previewItem.style.display = 'inline-block';
                previewItem.style.marginBottom = '10px';

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '&times;';
                removeBtn.classList.add('remove-btn');
                removeBtn.type = 'button';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '5px';
                removeBtn.style.right = '5px';
                removeBtn.style.background = '#ff6b6b';
                removeBtn.style.color = 'white';
                removeBtn.style.border = 'none';
                removeBtn.style.borderRadius = '50%';
                removeBtn.style.width = '25px';
                removeBtn.style.height = '25px';
                removeBtn.style.cursor = 'pointer';
                removeBtn.style.fontSize = '16px';
                removeBtn.style.padding = '0';

                removeBtn.onclick = () => {
                    photoPreview.innerHTML = '';
                    photoInput.value = '';
                };

                previewItem.appendChild(removeBtn);

                if (fileType.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.maxWidth = '150px';
                    img.style.maxHeight = '150px';
                    img.style.borderRadius = '8px';
                    img.style.objectFit = 'cover';
                    previewItem.appendChild(img);
                } else {
                    const fileName = document.createElement('div');
                    fileName.classList.add('file-name');
                    fileName.textContent = file.name;
                    fileName.style.padding = '10px';
                    fileName.style.background = '#f0f0f0';
                    fileName.style.borderRadius = '8px';
                    previewItem.appendChild(fileName);
                }

                photoPreview.appendChild(previewItem);
            });
        }

        // Handle form submission
        replyForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const employerId = document.getElementById('replyEmployerId').value;
            let messageText = messageInput.value.trim();
            const attachmentFile = photoInput.files[0];

            if (!messageText && !attachmentFile) {
                console.warn('⚠️ No message or attachment to send');
                return;
            }

            // Create FormData
            const formData = new FormData();
            formData.append('employer_id', employerId);

            // Auto-filter profanity from message
            if (messageText) {
                const filteredMessage = filterProfanity(messageText);
                formData.append('message', filteredMessage);
            }

            // Add attachment if exists
            if (attachmentFile) {
                formData.append('attachment', attachmentFile);
            }

            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                'content');
            if (csrfToken) {
                formData.append('_token', csrfToken);
            }

            // Clear input and preview
            messageInput.value = '';
            photoInput.value = '';
            photoPreview.innerHTML = '';

            try {
                const response = await fetch(
                '{{ route('applicant.sendmessageemployer.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const result = await response.json();

                if (result.success) {
                    console.log('✅ Message sent successfully');
                    // Refresh messages after a short delay
                    setTimeout(() => refreshMessages(), 300);
                } else {
                    console.error('❌ Failed to send message:', result.message);
                    messageInput.value = messageText; // Restore message on error
                }
            } catch (error) {
                console.error('❌ Error sending message:', error);
                messageInput.value = messageText; // Restore message on error
            }
        });

        // Add scroll listener
        const container = document.getElementById('messagesContainer');
        if (container) {
            container.addEventListener('scroll', () => {
                checkIfUserAtBottom();
            });
        }

        // Page visibility handling
        document.addEventListener('visibilitychange', function() {
            const previousVisibility = isPageVisible;
            isPageVisible = !document.hidden;

            if (!isPageVisible) {
                isActivelyViewingMessages = false;
                if (messageReadTimer) {
                    clearTimeout(messageReadTimer);
                    messageReadTimer = null;
                }
            } else if (previousVisibility === false && isPageVisible) {
                if (isUserAtBottom && currentEmployerId && isChatModalOpen && !
                    hasMarkedAsReadForCurrentEmployer) {
                    messageReadTimer = setTimeout(() => {
                        if (isUserAtBottom && isChatModalOpen && isPageVisible && !
                            hasMarkedAsReadForCurrentEmployer) {
                            isActivelyViewingMessages = true;
                            markMessagesAsRead(currentEmployerId);
                        }
                    }, 3000);
                }
            }
        });

        // Initialize message count
        if (currentEmployerId && messagesByEmployer[currentEmployerId]) {
            lastMessageCount = messagesByEmployer[currentEmployerId].length;
        }

        // ========================================
        // START REAL-TIME POLLING
        // ========================================
        console.log('🚀 Starting real-time message system with profanity filter...');

        setInterval(() => {
            if (isPageVisible && isChatModalOpen && currentEmployerId) {
                refreshMessages();
            }
        }, 2000);

        setTimeout(() => {
            if (isChatModalOpen && currentEmployerId) {
                refreshMessages();
            }
        }, 1000);

        console.log('✅ Real-time messaging active with auto profanity filter');
    });
    // -------------------------------
    // MOBILE MESSENGER-LIKE UI TOGGLE
    // -------------------------------

    // Make sure the toggle only applies on mobile width
    function isMobile() {
        return window.innerWidth <= 768;
    }

    // Hide sidebar, show chat
    function showChatMobile() {
        if (!isMobile()) return;

        const sidebar = document.querySelector(".employers-sidebar");
        const chat = document.querySelector(".chat-area");

        if (sidebar) sidebar.classList.add("hidden");
        if (chat) chat.classList.add("active");
    }

    // Show sidebar, hide chat
    function showSidebarMobile() {
        if (!isMobile()) return;

        const sidebar = document.querySelector(".employers-sidebar");
        const chat = document.querySelector(".chat-area");

        if (sidebar) sidebar.classList.remove("hidden");
        if (chat) chat.classList.remove("active");
    }

    // Attach back button listener (triggered on mobile)
    document.addEventListener("DOMContentLoaded", () => {
        const backBtn = document.getElementById("backToListBtn");

        if (backBtn) {
            backBtn.addEventListener("click", showSidebarMobile);
        }
    });

    // Preserve the original loadConversation() function
    if (typeof window.loadConversation === "function") {
        window._originalLoadConversation = window.loadConversation;
    }

    // Override loadConversation() with mobile-aware version
    window.loadConversation = function(employerId) {
        // Call your original message loading logic
        if (typeof window._originalLoadConversation === "function") {
            window._originalLoadConversation(employerId);
        }

        // Activate mobile chat toggle
        showChatMobile();
    };

    // Handle resizing (for dev tools testing)
    window.addEventListener("resize", () => {
        if (!isMobile()) {
            // Desktop reset
            document.querySelector(".employers-sidebar")?.classList.remove("hidden");
            document.querySelector(".chat-area")?.classList.remove("active");
        }
    });

    function scrollChatToBottom() {
        const container = document.getElementById("employerMessagesContainer");
        if (!container) return;

        // Wait for DOM to update then scroll
        setTimeout(() => {
            container.scrollTop = container.scrollHeight;
        }, 50);
    }
    window.loadConversation = function(employerId) {
        if (typeof window._originalLoadConversation === "function") {
            window._originalLoadConversation(employerId);
        }

        // Force auto-scroll when switching to a conversation
        scrollChatToBottom();

        // Mobile toggle
        showChatMobile();
    };
</script>
