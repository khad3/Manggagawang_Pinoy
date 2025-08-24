<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FriendChat</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/applicant/friendlist.css') }}">

    <style>

        .friend-request-card {
    border-left: 4px solid #0d6efd;
    border-radius: 8px;
}

.friend-avatar {
    position: relative;
    width: 40px;
    height: 40px;
    background: #6c757d;
    color: white;
    font-weight: bold;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.status-dot {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 10px;
    height: 10px;
    border: 2px solid white;
    border-radius: 50%;
}

.status-dot.online {
    background: #28a745;
}

.status-dot.offline {
    background: #6c757d;
}

    </style>

</head>
<body>
    <!-- Auto-refresh indicator -->
    <div id="refreshIndicator" class="refresh-indicator">
        <i class="fas fa-sync-alt fa-spin me-1"></i>
        Updating messages...
    </div>

    <!-- New message alert -->
    <div id="newMessageAlert" class="new-message-alert" onclick="scrollToBottom()">
        <i class="fas fa-arrow-down me-1"></i>
        New message
    </div>

    <!-- Top Navigation -->
    <div class="top-nav">
        <a href="{{ route('applicant.forum.display') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
        </a>
        
        <div class="user-info">
            <div class="avatar">{{ substr($retrievedApplicantInfo->personal_info->first_name, 0, 1) }}{{ substr($retrievedApplicantInfo->personal_info->last_name, 0, 1) }}</div>
            <a href="{{ route('applicant.profile.display') }}" class="name"><span class="name">{{ $retrievedApplicantInfo->username }}</span></a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <div class="chat-card">
            <!-- Friends Section -->
            <div class="friends-section">
                <button class="back-to-friends d-md-none" onclick="toggleFriends()">
                    <i class="fas fa-arrow-left"></i> Back to Chat
                </button>
                <div class="friends-header">
                    <h3>
                        <i class="fas fa-users me-2"></i>Friends List
                        <span id="totalNotificationBadge" class="header-notification-badge" style="display: none;">0</span>
                    </h3>
                    <p>Choose someone to chat with</p>
                </div>

                <!-- Notification Summary -->
                <div id="notificationSummary" class="notification-summary" style="display: none;">
                    <i class="fas fa-bell"></i>
                    <span id="notificationText">You have unread messages</span>
                </div>

                <!-- Friend Requests Section -->
<div class="friend-requests mb-3">
    <h5 class="mb-2"><i class="fas fa-user-plus me-2"></i> Friend Requests</h5>

   @forelse ($friendRequests as $req)
    <div class="card friend-request-card p-2 d-flex flex-row align-items-center mb-2 shadow-sm">
        
        <div class="friend-avatar me-3">
            @if(!empty($req->sender->work_background->profileimage_path))
                <img src="{{ asset('storage/' . $req->sender->work_background->profileimage_path) }}" 
                     alt="{{ $req->sender->personal_info->first_name }} {{ $req->sender->personal_info->last_name }}" 
                     class="rounded-circle" 
                     style="width: 40px; height: 40px; object-fit: cover;">
            @else
                {{ strtoupper(substr($req->sender->personal_info->first_name, 0, 1)) }}
                {{ strtoupper(substr($req->sender->personal_info->last_name, 0, 1)) }}
            @endif
            <div class="status-dot {{ $req->sender->is_online ? 'online' : 'offline' }}"></div>
        </div>

        <div class="flex-grow-1">
            <strong>{{ $req->sender->personal_info->first_name }} {{ $req->sender->personal_info->last_name }}</strong><br>
            <small class="text-muted">{{ $req->sender->is_online ? 'Online now' : 'Offline' }}</small>
        </div>

        <div class="ms-auto">
            <form method="POST" action="{{ route('applicant.forum.friend.accept', $req->id) }}" class="d-inline">
                @csrf
                @method('PUT')
                <button class="btn btn-success btn-sm me-1">Accept</button>
            </form>
            <form method="POST" action="{{ route('applicant.forum.friend.cancel', $req->id) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Decline</button>
            </form>
        </div>
    </div>
@empty
    <p class="text-muted">No pending friend requests</p>
@endforelse

</div>

<!-- Friends List Section -->
<div class="friends-list" id="friendsList">
    @foreach ($retrievedFriends as $index => $friend)
        @php
            $friendUser = $friend->request_id == $applicantID ? $friend->receiver : $friend->sender;
            $selectedFriendId = request('friend_id');
            $isActive = $selectedFriendId == $friendUser->id;

            // Count unread messages from this friend
            $unreadCount = 0;
            if ($friendUser) {
                $unreadCount = $retrievedMessages->where('sender_id', $friendUser->id)
                                                ->where('receiver_id', $applicantID)
                                                ->where('is_read', false)
                                                ->count();
            }
        @endphp

        @if ($friendUser && $friendUser->personal_info)
            <a href="?friend_id={{ $friendUser->id }}" 
               class="friend-card {{ $isActive ? 'active' : '' }} {{ $unreadCount > 0 ? 'has-unread' : '' }}" 
               data-friend-id="{{ $friendUser->id }}"
               data-unread-count="{{ $unreadCount }}">
                <div class="friend-avatar">
                    {{ strtoupper(substr($friendUser->personal_info->first_name, 0, 1)) }}{{ strtoupper(substr($friendUser->personal_info->last_name, 0, 1)) }}

                    @php
                        $lastSeen = $friendUser->last_seen ?? null;
                        $isOnline = $lastSeen && \Carbon\Carbon::parse($lastSeen)->gt(now()->subMinutes(1));
                    @endphp

                    <div class="status-dot {{ $isOnline ? 'online' : 'offline' }}"></div>

                    @if($unreadCount > 0)
                        <span class="notification-badge">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                    @endif
                </div>
                <div class="friend-details">
                    <h6>{{ $friendUser->personal_info->first_name }} {{ $friendUser->personal_info->last_name }}</h6>
                    <small class="text-muted">
                        @if($unreadCount > 0)
                            <strong>{{ $unreadCount }} new message{{ $unreadCount > 1 ? 's' : '' }}</strong>
                        @elseif ($isOnline)
                            Online now
                        @else
                            Offline
                        @endif
                    </small>
                </div>
            </a>
        @endif
    @endforeach
</div>

            </div>

            <!-- Chat Section -->
            <div class="chat-section">
                @php
                    $selectedFriendId = request('friend_id');
                    $selectedFriend = null;
                    
                    // Find the selected friend
                    if ($selectedFriendId) {
                        foreach ($retrievedFriends as $friend) {
                            $friendUser = $friend->request_id == $applicantID ? $friend->receiver : $friend->sender;
                            if ($friendUser && $friendUser->id == $selectedFriendId) {
                                $selectedFriend = $friendUser;
                                break;
                            }
                        }
                    }
                    
                    // Filter messages for selected friend
                    $currentMessages = [];
                    if ($selectedFriend) {
                        $currentMessages = $retrievedMessages->filter(function($message) use ($applicantID, $selectedFriendId) {
                            return ($message->sender_id == $applicantID && $message->receiver_id == $selectedFriendId) ||
                                   ($message->sender_id == $selectedFriendId && $message->receiver_id == $applicantID);
                        })->sortBy('created_at');
                    }
                @endphp

                @if($selectedFriend)
                    <!-- Chat Header -->
                    <div class="chat-header">
                        <button class="btn btn-sm btn-outline-primary d-md-none" onclick="toggleFriends()">
                            <i class="fas fa-users me-1"></i> Friends
                        </button>

                        <div class="chat-user-info">
                            <div class="chat-avatar">
                                {{ strtoupper(substr($selectedFriend->personal_info->first_name, 0, 1)) }}{{ strtoupper(substr($selectedFriend->personal_info->last_name, 0, 1)) }}
                            </div>
                            <div>
                               <h6>
                                    <a href="{{ route('applicant.getprofile.display', ['id' => $selectedFriend->id]) }}">
                                        {{ $selectedFriend->personal_info->first_name }} {{ $selectedFriend->personal_info->last_name }}
                                    </a>
                                </h6>

                                @php
                                    $lastSeen = $selectedFriend->last_seen ?? null;
                                    $isOnline = $lastSeen && \Carbon\Carbon::parse($lastSeen)->gt(now()->subMinutes(1));
                                @endphp

                                <small class="text-muted">
                                    @if ($isOnline)
                                        Online now
                                    @elseif ($lastSeen)
                                        Offline for {{ \Carbon\Carbon::parse($lastSeen)->diffForHumans(null, true) }}
                                    @else
                                        Offline
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="messages-container" id="messagesContainer">
                        <button id="scrollUpBtn" class="btn btn-light position-absolute" 
                            style="top: 1rem; right: 1rem; z-index: 10;" 
                            onclick="scrollToTop()" title="Scroll to top">
                            <i class="fas fa-arrow-up"></i>
                        </button>

                        <div id="messagesWrapper">
                            @if($currentMessages->count() > 0)
                                @foreach($currentMessages as $index => $message)
                                    @php
                                        $isSent = $message->sender_id == $applicantID;
                                        $messageTime = $message->created_at ? $message->created_at->format('g:i A') : 'now';
                                        $isLastSentByMe = $isSent && $loop->last;
                                    @endphp

                                    <div class="chat-wrapper {{ $isSent ? 'sent' : 'received' }}" data-message-id="{{ $message->id }}">
                                        <div class="bubble-container">
                                            @if($message->image_path)
                                                <div class="message-image">
                                                    <img src="{{ asset($message->image_path) }}" alt="Message Image">
                                                </div>
                                            @endif

                                            @if($message->message)
                                                <div class="message-text">
                                                    <p>{{ $message->message }}</p>
                                                </div>
                                            @endif

                                            <div class="timestamp">
                                                {{ $messageTime }}

                                                @if($isLastSentByMe)
                                                    @if($message->is_read)
                                                        <span class="text-success ms-2">Seen</span>
                                                    @else
                                                        <span class="text-muted ms-2">Delivered</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-messages">
                                    <i class="fas fa-comments"></i>
                                    <h5>No messages yet</h5>
                                    <p>Start the conversation by sending a message!</p>
                                </div>
                            @endif
                        </div>

                        <!-- Typing Indicator -->
                        <div id="typingIndicator" class="typing-indicator">
                            <div class="typing-text">
                                <span id="typingUsername">{{ $selectedFriend->personal_info->first_name }}</span> is typing
                                <div class="typing-dots">
                                    <div class="typing-dot"></div>
                                    <div class="typing-dot"></div>
                                    <div class="typing-dot"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Input -->
                    <form method="POST" action="{{ route('applicant.sendmessage.store') }}" enctype="multipart/form-data" id="messageForm">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $selectedFriend->id }}">
                        
                        <div class="message-input">
                            <div class="input-container">
                                <!-- File Input (Hidden) -->
                                <input type="file" id="photoInput" accept="image/*" name="photo" style="display: none;">

                                <!-- Upload Button -->
                                <button type="button" class="btn btn-light" onclick="document.getElementById('photoInput').click()" title="Attach Photo">
                                    <i class="fas fa-paperclip"></i>
                                </button>

                                <!-- Message Text Field -->
                                <input type="text" class="message-field" placeholder="Type your message..." name="message" id="messageInput">

                                <!-- Send Button -->
                                <button type="submit" class="send-btn">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>

                            <!-- Preview Area -->
                            <div id="photoPreview" class="mt-2"></div>
                        </div>
                    </form>
                @else
                    <!-- Welcome Screen -->
                    <div class="messages-container">
                        <div class="welcome-screen">
                            <i class="fas fa-comments"></i>
                            <h5>Select a friend to start chatting</h5>
                            <p>Choose someone from your friends list to begin a conversation</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        let lastMessageCount = {{ $currentMessages ? $currentMessages->count() : 0 }};
        let isUserAtBottom = true;
        let typingTimeout;
        let isCurrentlyTyping = false;
        let isPageVisible = true;
        let lastSeenUpdateTime = 0;
        let notificationCounts = {};
        const selectedFriendId = {{ $selectedFriend ? $selectedFriend->id : 'null' }};
        const currentUserId = {{ $applicantID ?? 'null' }};

        // Initialize notification counts from DOM
        function initializeNotificationCounts() {
            const friendCards = document.querySelectorAll('.friend-card');
            let totalUnread = 0;
            
            friendCards.forEach(card => {
                const friendId = card.getAttribute('data-friend-id');
                const unreadCount = parseInt(card.getAttribute('data-unread-count') || '0');
                notificationCounts[friendId] = unreadCount;
                totalUnread += unreadCount;
            });
            
            updateNotificationDisplay();
            updateNotificationSummary();
        }

        function updateNotificationDisplay() {
            let totalUnread = 0;
            
            // Update individual friend badges
            Object.keys(notificationCounts).forEach(friendId => {
                const count = notificationCounts[friendId];
                const friendCard = document.querySelector(`[data-friend-id="${friendId}"]`);
                
                if (friendCard) {
                    const badge = friendCard.querySelector('.notification-badge');
                    const friendDetails = friendCard.querySelector('.friend-details small');
                    
                    if (count > 0) {
                        totalUnread += count;
                        friendCard.classList.add('has-unread');
                        
                        if (badge) {
                            badge.textContent = count > 99 ? '99+' : count;
                            badge.style.display = 'flex';
                        } else {
                            // Create badge if it doesn't exist
                            const newBadge = document.createElement('span');
                            newBadge.className = 'notification-badge';
                            newBadge.textContent = count > 99 ? '99+' : count;
                            friendCard.querySelector('.friend-avatar').appendChild(newBadge);
                        }
                        
                        // Update friend details text
                        if (friendDetails) {
                            friendDetails.innerHTML = `<strong>${count} new message${count > 1 ? 's' : ''}</strong>`;
                        }
                    } else {
                        friendCard.classList.remove('has-unread');
                        if (badge) {
                            badge.style.display = 'none';
                        }
                        
                        // Reset to online/offline status
                        if (friendDetails) {
                            const isOnline = friendCard.querySelector('.status-dot.online');
                            friendDetails.innerHTML = isOnline ? 'Online now' : 'Offline';
                        }
                    }
                }
            });
            
            // Update total notification badge
            const totalBadge = document.getElementById('totalNotificationBadge');
            if (totalUnread > 0) {
                totalBadge.textContent = totalUnread > 99 ? '99+' : totalUnread;
                totalBadge.style.display = 'flex';
            } else {
                totalBadge.style.display = 'none';
            }
        }

        function updateNotificationSummary() {
            const totalUnread = Object.values(notificationCounts).reduce((sum, count) => sum + count, 0);
            const summary = document.getElementById('notificationSummary');
            const summaryText = document.getElementById('notificationText');
            
            if (totalUnread > 0) {
                const friendsWithMessages = Object.values(notificationCounts).filter(count => count > 0).length;
                summaryText.textContent = `You have ${totalUnread} unread message${totalUnread > 1 ? 's' : ''} from ${friendsWithMessages} friend${friendsWithMessages > 1 ? 's' : ''}`;
                summary.style.display = 'block';
            } else {
                summary.style.display = 'none';
            }
        }

        function toggleFriends() {
            const friends = document.querySelector('.friends-section');
            friends.classList.toggle('show');
        }
        
        function scrollToTop() {
            const container = document.querySelector(".messages-container");
            container.scrollTop = 0;
        }

        function scrollToBottom() {
            const container = document.querySelector(".messages-container");
            container.scrollTop = container.scrollHeight;
            document.getElementById('newMessageAlert').style.display = 'none';
            isUserAtBottom = true;
        }

        function checkIfUserAtBottom() {
            const container = document.querySelector(".messages-container");
            if (!container) return;
            
            const threshold = 50;
            isUserAtBottom = container.scrollTop + container.clientHeight >= container.scrollHeight - threshold;
        }

        // Auto-mark messages as seen when user is viewing them
        function markMessagesAsSeen() {
            if (!selectedFriendId || !isPageVisible || !isUserAtBottom) return;
            
            // Prevent too frequent requests
            const now = Date.now();
            if (now - lastSeenUpdateTime < 2000) return;
            lastSeenUpdateTime = now;

            // Create a route for marking messages as seen
            fetch(`{{ url('/applicant/mark-messages-seen') }}/${selectedFriendId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    // Clear notification count for this friend when messages are marked as seen
                    notificationCounts[selectedFriendId] = 0;
                    updateNotificationDisplay();
                    updateNotificationSummary();
                }
            }).catch(error => {
                console.log('Mark as seen failed:', error);
            });
        }

        // Auto-refresh messages and notifications
        function refreshMessages() {
            if (!selectedFriendId) return;

            const refreshIndicator = document.getElementById('refreshIndicator');
            refreshIndicator.style.display = 'block';

            fetch(window.location.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const newDoc = parser.parseFromString(html, 'text/html');
                const newMessages = newDoc.querySelector('#messagesWrapper');
                
                if (newMessages) {
                    const currentMessages = document.querySelector('#messagesWrapper');
                    const newMessageCount = newMessages.children.length;
                    const currentContent = currentMessages.innerHTML;
                    const newContent = newMessages.innerHTML;
                    
                    // Update if message count changed OR content changed (for seen/delivered status)
                    if (newMessageCount !== lastMessageCount || currentContent !== newContent) {
                        currentMessages.innerHTML = newMessages.innerHTML;
                        
                        if (isUserAtBottom) {
                            scrollToBottom();
                        } else if (newMessageCount > lastMessageCount) {
                            document.getElementById('newMessageAlert').style.display = 'block';
                        }
                        
                        lastMessageCount = newMessageCount;
                        
                        // Mark as seen if user is viewing
                        setTimeout(markMessagesAsSeen, 500);
                    }
                }
                
                refreshIndicator.style.display = 'none';
            })
            .catch(error => {
                console.error('Error refreshing messages:', error);
                refreshIndicator.style.display = 'none';
            });
        }

        // Refresh notification counts for all friends
        function refreshNotificationCounts() {
            fetch("{{ route('applicant.get.unread.counts') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.unread_counts) {
                    // Update notification counts
                    Object.keys(data.unread_counts).forEach(friendId => {
                        notificationCounts[friendId] = data.unread_counts[friendId];
                    });
                    
                    updateNotificationDisplay();
                    updateNotificationSummary();
                }
            })
            .catch(error => {
                console.log('Failed to refresh notification counts:', error);
            });
        }

        // Typing indicator functions
        function showTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) {
                indicator.style.display = 'block';
                if (isUserAtBottom) {
                    setTimeout(() => {
                        scrollToBottom();
                    }, 100);
                }
            }
        }

        function hideTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) {
                indicator.style.display = 'none';
            }
        }

        function pollFriendTyping() {
            if (!selectedFriendId) return;
            
            fetch("{{ route('applicant.check.typing', ['receiver_id' => '__RECEIVER_ID__']) }}".replace('__RECEIVER_ID__', selectedFriendId), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                if (data.is_typing) {
                    showTypingIndicator();
                } else {
                    hideTypingIndicator();
                }
            })
            .catch(error => {
                console.log('Typing check failed:', error);
                hideTypingIndicator();
            });
        }

        // Page visibility handling
        document.addEventListener('visibilitychange', function() {
            isPageVisible = !document.hidden;
            if (isPageVisible && isUserAtBottom) {
                setTimeout(markMessagesAsSeen, 1000);
            }
        });

        // Initialize on page load
        window.onload = function() {
            // Initialize notification counts from DOM
            initializeNotificationCounts();
            
            const container = document.querySelector(".messages-container");
            if (container) {
                container.scrollTop = container.scrollHeight;
                
                // Add scroll listener
                container.addEventListener('scroll', () => {
                    checkIfUserAtBottom();
                    if (isUserAtBottom) {
                        setTimeout(markMessagesAsSeen, 500);
                    }
                });
            }

            // Mark initial messages as seen
            setTimeout(markMessagesAsSeen, 1000);

            // Start auto-refresh and typing polls
            if (selectedFriendId) {
                setInterval(refreshMessages, 2000); // Refresh every 2 seconds
                setInterval(pollFriendTyping, 1000); // Check typing every 1 second
            }
            
            // Refresh notification counts every 5 seconds for all friends
            setInterval(refreshNotificationCounts, 5000);
        };

        // Handle message form submission
        document.getElementById('messageForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Stop typing indicator when sending message
            if (isCurrentlyTyping) {
                clearTimeout(typingTimeout);
                isCurrentlyTyping = false;
                fetch("{{ route('applicant.typing.stop') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                }).catch(() => {});
            }
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    document.getElementById('messageInput').value = '';
                    clearPhoto();
                    // Immediate refresh after sending
                    setTimeout(() => {
                        refreshMessages();
                        scrollToBottom();
                    }, 100);
                }
            })
            .catch(error => console.error('Error sending message:', error));
        });

        // Typing detection
        const messageInput = document.getElementById('messageInput');
        if (messageInput) {
            messageInput.addEventListener('input', () => {
                if (!isCurrentlyTyping && selectedFriendId) {
                    isCurrentlyTyping = true;
                    fetch("{{ route('applicant.typing.start') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).catch(error => {
                        console.log('Typing start failed:', error);
                    });
                }

                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(() => {
                    if (isCurrentlyTyping) {
                        isCurrentlyTyping = false;
                        fetch("{{ route('applicant.typing.stop') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        }).catch(error => {
                            console.log('Typing stop failed:', error);
                        });
                    }
                }, 1500);
            });

            // Stop typing when user loses focus
            messageInput.addEventListener('blur', () => {
                if (isCurrentlyTyping) {
                    clearTimeout(typingTimeout);
                    isCurrentlyTyping = false;
                    fetch("{{ route('applicant.typing.stop') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).catch(() => {});
                }
            });
        }

        // Update last seen
        setInterval(() => {
            fetch("{{ route('applicant.updatelastseen.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            }).then(response => response.json())
              .then(data => {
                  console.log('Last seen updated');
              }).catch(() => {});
        }, 60000);

        // Photo handling
        document.getElementById('photoInput').addEventListener('change', function() {
            const file = this.files[0];
            const preview = document.getElementById('photoPreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="preview-image-wrapper d-flex align-items-center gap-2">
                            <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="height: 100px;">
                            <button type="button" class="btn btn-danger btn-sm" onclick="clearPhoto()">Remove</button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        function clearPhoto() {
            document.getElementById('photoInput').value = '';
            document.getElementById('photoPreview').innerHTML = '';
        }

        // Sound notification for new messages (optional)
        function playNotificationSound() {
            // You can add a notification sound here
            // const audio = new Audio('/path/to/notification-sound.mp3');
            // audio.play().catch(() => {});
        }

        // Browser notification API (optional)
        function showBrowserNotification(friendName, messageCount) {
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification(`New message${messageCount > 1 ? 's' : ''} from ${friendName}`, {
                    body: `You have ${messageCount} unread message${messageCount > 1 ? 's' : ''}`,
                    icon: '/path/to/chat-icon.png',
                    tag: `friend-${friendName}` // Prevents duplicate notifications
                });
            }
        }

        // Request notification permission on first visit
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    </script>
</body>
</html>