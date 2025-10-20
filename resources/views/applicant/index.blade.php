<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FriendChat</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
        }

        .top-nav {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .main-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .chat-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 350px 1fr;
            height: 600px;
        }

        .friends-section {
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
        }

        .friends-header {
            padding: 2rem 1.5rem 1rem;
            border-bottom: 1px solid #eee;
        }

        .friends-header h3 {
            margin: 0 0 0.5rem;
            color: #333;
        }

        .friends-header p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        .friends-list {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 1.5rem;
        }

        .friend-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
            text-decoration: none;
            color: inherit;
        }

        .friend-card:hover,
        .friend-card.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateX(5px);
        }

        .friend-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1rem;
            position: relative;
        }

        .friend-card.active .friend-avatar {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            position: absolute;
            bottom: 0;
            right: 0;
            border: 2px solid white;
            background: #4CAF50;
        }

        .friend-details h6 {
            margin: 0 0 0.25rem;
            font-weight: 600;
        }

        .friend-details small {
            opacity: 0.8;
        }

        .chat-section {
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
        }

        .chat-user-info {
            display: flex;
            align-items: center;
        }

        .chat-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1rem;
        }

        .messages-container {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .message.sent {
            align-items: flex-end;
        }

        .message.received {
            align-items: flex-start;
        }

        .message-bubble {
            max-width: 70%;
            padding: 0.75rem 1rem;
            border-radius: 15px;
            word-wrap: break-word;
        }

        .message.sent .message-bubble {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .message.received .message-bubble {
            background: white;
            color: #333;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .message-time {
            font-size: 0.75rem;
            color: #666;
            margin-top: 0.25rem;
        }

        .message-input {
            padding: 1.5rem;
            border-top: 1px solid #eee;
            background: white;
        }

        .input-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .message-field {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 25px;
            outline: none;
        }

        .send-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .send-btn:hover {
            transform: scale(1.1);
        }

        .welcome-screen {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            color: #666;
        }

        .welcome-screen i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .no-messages {
            text-align: center;
            color: #666;
            padding: 2rem;
        }

        .no-messages i {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .message img {
            max-width: 200px;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            display: block;
        }

        .preview-image-wrapper {
            margin-top: 0.5rem;
        }

        .btn-light {
            background: #f8f9fa;
            border: 1px solid #ddd;
            color: #666;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <!-- Top Navigation -->
    <div class="top-nav">
        <a href="{{ route('applicant.forum.display') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
        </a>

        <div class="user-info">
            <div class="avatar">
                {{ substr($retrievedApplicantInfo->personal_info->first_name, 0, 1) }}{{ substr($retrievedApplicantInfo->personal_info->last_name, 0, 1) }}
            </div>
            <span class="name">{{ $retrievedApplicantInfo->username }}</span>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <div class="chat-card">
            <!-- Friends Section -->
            <div class="friends-section">
                <div class="friends-header">
                    <h3><i class="fas fa-users me-2"></i>Friends List</h3>
                    <p>Choose someone to chat with</p>
                </div>

                <div class="friends-list">
                    @foreach ($retrievedFriends as $index => $friend)
                        @php
                            $friendUser = $friend->request_id == $applicantID ? $friend->receiver : $friend->sender;
                            $selectedFriendId = request('friend_id');
                            $isActive = $selectedFriendId == $friendUser->id;
                        @endphp

                        @if ($friendUser && $friendUser->personal_info)
                            <a href="?friend_id={{ $friendUser->id }}"
                                class="friend-card {{ $isActive ? 'active' : '' }}">
                                <div class="friend-avatar">
                                    {{ strtoupper(substr($friendUser->personal_info->first_name, 0, 1)) }}{{ strtoupper(substr($friendUser->personal_info->last_name, 0, 1)) }}
                                    <div class="status-dot"></div>
                                </div>
                                <div class="friend-details">
                                    <h6>{{ $friendUser->personal_info->first_name }}
                                        {{ $friendUser->personal_info->last_name }}</h6>
                                    <small>Online now</small>
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
                        $currentMessages = $retrievedMessages
                            ->filter(function ($message) use ($applicantID, $selectedFriendId) {
                                return ($message->sender_id == $applicantID &&
                                    $message->receiver_id == $selectedFriendId) ||
                                    ($message->sender_id == $selectedFriendId && $message->receiver_id == $applicantID);
                            })
                            ->sortBy('created_at');
                    }
                @endphp

                @if ($selectedFriend)
                    <!-- Chat Header -->
                    <div class="chat-header">
                        <div class="chat-user-info">
                            <div class="chat-avatar">
                                {{ strtoupper(substr($selectedFriend->personal_info->first_name, 0, 1)) }}{{ strtoupper(substr($selectedFriend->personal_info->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $selectedFriend->personal_info->first_name }}
                                    {{ $selectedFriend->personal_info->last_name }}</h6>
                                <small class="text-muted">Online now</small>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="messages-container">
                        @if ($currentMessages->count() > 0)
                            @foreach ($currentMessages as $message)
                                @php
                                    $isSent = $message->sender_id == $applicantID;
                                    $messageTime = $message->created_at ? $message->created_at->format('H:i') : 'now';
                                @endphp

                                <div class="message {{ $isSent ? 'sent' : 'received' }}">
                                    <div class="message-bubble">
                                        @if ($message->photo)
                                            <img src="{{ asset('public/uploads/messages/' . $message->photo) }}"
                                                alt="Image" class="img-fluid">
                                        @endif

                                        @if ($message->message)
                                            {{ $message->message }}
                                        @endif
                                    </div>
                                    <div class="message-time">{{ $messageTime }}</div>
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

                    <!-- Message Input -->
                    <form method="POST" action="{{ route('applicant.sendmessage.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $selectedFriend->id }}">

                        <div class="message-input">
                            <div class="input-container">
                                <!-- File Input (Hidden) -->
                                <input type="file" id="photoInput" accept="image/*" name="photo"
                                    style="display: none;">

                                <!-- Upload Button -->
                                <button type="button" class="btn btn-light"
                                    onclick="document.getElementById('photoInput').click()" title="Attach Photo">
                                    <i class="fas fa-paperclip"></i>
                                </button>

                                <!-- Message Text Field -->
                                <input type="text" class="message-field" placeholder="Type your message..."
                                    name="message" required>

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
        // Simple photo preview functionality
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
    </script>
</body>

</html>
