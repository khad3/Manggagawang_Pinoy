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

<style>
    /* Messages Container - Fixed scrolling and width */
    .messages-container {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 16px 12px;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        gap: 2px;
        max-width: 100%;
        height: calc(100vh - 200px);
    }

    /* Message Bubble Base Styles */
    .message-bubble {
        display: flex;
        margin-bottom: 2px;
        max-width: 100%;
        clear: both;
    }

    /* Employer Messages (Left Side) */
    .message-bubble.from-employer {
        justify-content: flex-start;
        padding-right: 100px;
    }

    .message-bubble.from-employer .message-content {
        background: #e4e6eb;
        color: #050505;
        border-radius: 18px;
        padding: 6px 12px;
        max-width: 45%;
        min-width: fit-content;
        width: auto;
        display: inline-block;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        position: relative;
        font-size: 14px;
        line-height: 1.3;
    }

    /* User/Applicant Messages (Right Side) */
    .message-bubble.from-applicant {
        justify-content: flex-end;
        padding-left: 100px;
    }

    .message-bubble.from-applicant .message-content {
        background: #0084ff;
        color: #ffffff;
        border-radius: 18px;
        padding: 6px 12px;
        max-width: 45%;
        min-width: fit-content;
        width: auto;
        display: inline-block;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        position: relative;
        font-size: 14px;
        line-height: 1.3;
    }

    /* Remove the chat tails */
    .message-bubble.from-employer .message-content::before,
    .message-bubble.from-applicant .message-content::after {
        display: none;
    }

    /* Message Text */
    .message-content {
        font-size: 14px;
        line-height: 1.3;
        white-space: pre-wrap;
        font-weight: 400;
    }

    /* Message Timestamp */
    .message-timestamp {
        font-size: 11px;
        margin-top: 2px;
        display: block;
        opacity: 0.6;
        font-weight: 400;
    }

    .message-timestamp.from-employer {
        color: #65676b;
        text-align: left;
    }

    .message-timestamp.from-applicant {
        color: rgba(255, 255, 255, 0.8);
        text-align: right;
    }

    /* Message Attachment */
    .message-attachment {
        margin-top: 4px;
        border-radius: 8px;
        overflow: hidden;
        max-width: 100%;
    }

    .message-attachment img {
        max-width: 100%;
        max-height: 250px;
        height: auto;
        display: block;
        border-radius: 8px;
        cursor: pointer;
    }

    /* Reply Area - Fixed positioning */
    .reply-area {
        border-top: 1px solid #e4e6eb;
        background: #ffffff;
        padding: 10px 12px;
        position: relative;
        z-index: 10;
    }

    .reply-container {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    /* Attachment Preview */
    .attachment-preview {
        margin-bottom: 6px;
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .preview-item {
        position: relative;
        display: inline-block;
    }

    .preview-item img {
        max-width: 80px;
        max-height: 80px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #e4e6eb;
    }

    .preview-item .file-name {
        padding: 6px 10px;
        background: #f0f2f5;
        border-radius: 8px;
        font-size: 12px;
        color: #050505;
        border: 1px solid #e4e6eb;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .preview-item .remove-btn {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 18px;
        height: 18px;
        background: #000000;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 11px;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.8;
    }

    .preview-item .remove-btn:hover {
        opacity: 1;
    }

    .message-input-wrapper {
        display: flex;
        align-items: flex-end;
        gap: 6px;
        background: #f0f2f5;
        border-radius: 20px;
        padding: 5px 8px;
        min-height: 36px;
        max-width: 100%;
    }

    /* Attachment Button */
    .attachment-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        min-width: 28px;
        min-height: 28px;
        background: transparent;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        color: #0084ff;
        transition: all 0.2s;
        margin: 0;
        padding: 0;
        flex-shrink: 0;
        align-self: flex-end;
    }

    .attachment-btn:hover {
        background: #e4e6eb;
    }

    .attachment-btn i {
        font-size: 18px;
    }

    /* Message Input */
    .reply-input {
        flex: 1;
        min-width: 0;
        border: none;
        outline: none;
        background: transparent;
        resize: none;
        font-size: 14px;
        line-height: 1.3;
        padding: 6px 4px;
        max-height: 90px;
        min-height: 20px;
        height: auto;
        overflow-y: auto;
        overflow-x: hidden;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        color: #050505;
        word-wrap: break-word;
        word-break: break-word;
        white-space: pre-wrap;
    }

    .reply-input::placeholder {
        color: #65676b;
    }

    /* Send Button */
    .send-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        min-width: 28px;
        min-height: 28px;
        background: transparent;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        color: #0084ff;
        transition: all 0.2s;
        flex-shrink: 0;
        align-self: flex-end;
    }

    .send-btn:hover {
        background: #e4e6eb;
    }

    .send-btn i {
        font-size: 18px;
    }

    /* Scrollbar Styling */
    .messages-container::-webkit-scrollbar {
        width: 6px;
    }

    .messages-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .messages-container::-webkit-scrollbar-thumb {
        background: #ccd0d5;
        border-radius: 3px;
    }

    .messages-container::-webkit-scrollbar-thumb:hover {
        background: #b8bcc2;
    }

    .reply-input::-webkit-scrollbar {
        width: 4px;
    }

    .reply-input::-webkit-scrollbar-track {
        background: transparent;
    }

    .reply-input::-webkit-scrollbar-thumb {
        background: #ccd0d5;
        border-radius: 2px;
    }

    /* No Conversation Placeholder */
    .no-conversation {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #65676b;
        text-align: center;
        padding: 30px;
    }

    .no-conversation-icon {
        font-size: 56px;
        margin-bottom: 12px;
        opacity: 0.4;
        color: #bcc0c4;
    }

    .no-conversation h3 {
        font-size: 16px;
        font-weight: 600;
        color: #050505;
        margin-bottom: 4px;
    }

    .no-conversation p {
        font-size: 13px;
        color: #65676b;
        margin: 0;
    }

    /* Typing Indicator */
    .typing-indicator {
        padding: 6px 0;
        color: #65676b;
        font-size: 12px;
        font-style: italic;
    }

    /* Back to List Button - Hidden on Desktop */
    .back-to-list-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: transparent;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        color: #050505;
        margin-right: 12px;
        transition: all 0.2s;
    }

    .back-to-list-btn:hover {
        background: #f0f2f5;
    }

    .back-to-list-btn i {
        font-size: 20px;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .employers-sidebar {
            width: 280px;
        }

        .message-bubble.from-employer .message-content,
        .message-bubble.from-applicant .message-content {
            max-width: 55%;
        }
    }

    @media (max-width: 768px) {
        .employers-sidebar {
            position: absolute;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 20;
            transition: transform 0.3s ease;
            background: #ffffff;
        }

        .employers-sidebar.hide-mobile {
            transform: translateX(-100%);
        }

        .chat-area {
            width: 100%;
        }

        .back-to-list-btn {
            display: flex;
        }

        .messages-container {
            height: calc(100vh - 180px);
            padding: 12px 8px;
        }

        .message-bubble.from-employer {
            padding-right: 50px;
        }

        .message-bubble.from-applicant {
            padding-left: 50px;
        }

        .message-bubble.from-employer .message-content,
        .message-bubble.from-applicant .message-content {
            max-width: 70%;
        }

        .reply-area {
            padding: 8px 10px;
        }

        .message-input-wrapper {
            padding: 4px 6px;
        }
    }

    @media (max-width: 480px) {
        .messages-container {
            padding: 10px 6px;
        }

        .message-bubble.from-employer {
            padding-right: 30px;
        }

        .message-bubble.from-applicant {
            padding-left: 30px;
        }

        .message-bubble.from-employer .message-content,
        .message-bubble.from-applicant .message-content {
            max-width: 80%;
            font-size: 13px;
        }

        .reply-input {
            font-size: 13px;
            padding: 5px 3px;
        }

        .attachment-btn,
        .send-btn {
            width: 26px;
            height: 26px;
            min-width: 26px;
            min-height: 26px;
        }

        .attachment-btn i,
        .send-btn i {
            font-size: 16px;
        }
    }
</style>

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
    let currentEmployerId = null;
    let allMessages = @json($messages);

    const messagesByEmployer = {};
    allMessages.forEach(msg => {
        if (!messagesByEmployer[msg.employer_id]) {
            messagesByEmployer[msg.employer_id] = [];
        }
        messagesByEmployer[msg.employer_id].push(msg);
    });

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

            // Hide employer list on mobile
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
        if (employer.address_company?.company_logo) {
            avatarElement.innerHTML = `<img src="${employer.address_company.company_logo}" 
                alt="${employer.address_company.company_name}" 
                style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        } else {
            avatarElement.textContent = (employer.address_company?.company_name || 'C').charAt(0).toUpperCase();
        }

        displayMessages(employerMessages);

        document.getElementById('replyArea').style.display = 'block';

        // Hide employer list on mobile
        if (window.innerWidth <= 768) {
            document.querySelector('.employers-sidebar').classList.add('hide-mobile');
        }

        markMessagesAsRead(employerId);
    }

    // Function to show employers list on mobile
    function showEmployersList() {
        if (window.innerWidth <= 768) {
            document.querySelector('.employers-sidebar').classList.remove('hide-mobile');
        }
    }

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

        container.scrollTop = container.scrollHeight;
    }

    function markMessagesAsRead(employerId) {
        const dropdownItem = document.querySelector(`.employer-item[data-employer-id="${employerId}"]`);
        const sidebarItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);

        const unreadCount = parseInt(dropdownItem?.dataset.unreadCount || sidebarItem?.dataset.unreadCount || 0);

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
                console.error('Error marking messages as read:', error);
            });
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
