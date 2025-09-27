 <!-- Messages Dropdown -->
 <div class="nav-dropdown">
     <button class="nav-icon" onclick="toggleDropdown('messagesDropdown')">
         <i class="bi bi-chat-dots"></i>
         <span class="nav-badge" id="messagesBadge">{{ $messages->where('status', 'unread')->count() }}</span>
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
                         $unreadCount = $employerMessages->where('status', 'unread')->count();
                         $lastMessage = $employerMessages->sortByDesc('created_at')->first();
                         $totalMessages = $employerMessages->count();
                     @endphp

                     <div class="employer-item {{ $unreadCount > 0 ? 'unread' : '' }}"
                         data-employer-id="{{ $employerId }}"
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
                             $unreadCount = $employerMessages->where('is_read', 0)->count();
                             $lastMessage = $employerMessages->sortByDesc('created_at')->first();
                         @endphp

                         <div class="employer-list-item {{ $unreadCount > 0 ? 'has-unread' : '' }}"
                             data-employer-id="{{ $employerId }}" onclick="loadConversation({{ $employerId }})">

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

                 <!-- Enhanced Messages Container -->
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
                     <form action="{{ route('applicant.sendmessageemployer.store') }}" method="POST"
                         enctype="multipart/form-data" class="reply-container">
                         @csrf
                         <input type="hidden" name="employer_id" id="replyEmployerId">

                         <div class="message-input-wrapper">
                             <!-- File Upload -->
                             <label class="attachment-btn" for="attachment" title="Attach file">
                                 <i class="bi bi-paperclip"></i>
                             </label>
                             <input type="file" name="attachment" id="attachment" class="d-none">

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
     function openChatWithEmployer(employerId) {
         document.getElementById('chatModal').style.display = 'flex';
         document.body.style.overflow = 'hidden';

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
                <i class="bi bi-chat-square-dots"></i>
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
         const activeItem = document.querySelector(`[data-employer-id="${employerId}"]`);
         if (activeItem) activeItem.classList.add('active');

         const employerMessages = messagesByEmployer[employerId] || [];

         // If no messages, clear display
         if (employerMessages.length === 0) {
             displayMessages([]);
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
            style="width:100%;height:100%;object-fit:cover;">`;
         } else {
             avatarElement.textContent = (employer.address_company?.company_name || 'C').charAt(0).toUpperCase();
         }

         // Load messages into chat area
         displayMessages(employerMessages);

         // Show reply area
         document.getElementById('replyArea').style.display = 'block';

         // Mark messages as read (optional AJAX call)
         markMessagesAsRead(employerId);
     }


     // Display messages in chat
     function displayMessages(messages) {
         const container = document.getElementById('messagesContainer');

         if (messages.length === 0) {
             container.innerHTML = `
            <div class="no-conversation">
                <i class="bi bi-chat-square"></i>
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
         const dropdownItem = document.querySelector(`.employer-item[data-employer-id="${employerId}"]`);
         if (dropdownItem) {
             dropdownItem.classList.remove('unread');
             const unreadIndicator = dropdownItem.querySelector('.unread-indicator');
             if (unreadIndicator) unreadIndicator.remove();
             const unreadCount = dropdownItem.querySelector('.unread-count');
             if (unreadCount) unreadCount.remove();
         }

         const sidebarItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);
         if (sidebarItem) {
             sidebarItem.classList.remove('has-unread');
             const unreadCount = sidebarItem.querySelector('.unread-count');
             if (unreadCount) unreadCount.remove();
         }
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

     document.addEventListener('DOMContentLoaded', function() {
         // Escape key closes modal
         document.addEventListener('keydown', function(e) {
             if (e.key === 'Escape') {
                 closeChatModal();
             }
         });
     });
 </script>
