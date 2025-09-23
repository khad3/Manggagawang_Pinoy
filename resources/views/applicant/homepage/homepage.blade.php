<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Homepage</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- fav icon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/homepage.css') }}">

</head>

<body>

    <!--- Notification Modal ----->
    @foreach ($notifications as $note)
        <div class="modal fade" id="viewNotificationModal-{{ $note->id }}" tabindex="-1"
            aria-labelledby="viewNotificationLabel-{{ $note->id }}" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"> {{-- scrollable --}}
                <div class="modal-content border-0 shadow">

                    {{-- Header --}}
                    <div class="modal-header border-bottom-0 pb-2">
                        <div class="d-flex align-items-center">
                            @if ($note->created_by === 'admin')
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-shield-check text-white"></i>
                                </div>
                            @else
                                <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-bell text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="modal-title fw-semibold mb-0" id="viewNotificationLabel-{{ $note->id }}">
                                    {{ $note->created_by === 'admin' ? 'TESDA Administrative Office' : 'System Notification' }}
                                </h6>
                                <small class="text-muted">{{ $note->created_at->format('M d, Y • g:i A') }}</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    {{-- Body --}}
                    <div class="modal-body px-4 py-3">
                        {{-- Title --}}
                        <h5 class="fw-bold text-dark mb-3">{{ $note->title }}</h5>

                        {{-- Priority Badge --}}
                        @if (!empty($note->priority))
                            <div class="mb-3">
                                @switch($note->priority)
                                    @case('urgent')
                                        <span class="badge bg-danger px-3 py-2 rounded-pill">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i>Urgent
                                        </span>
                                    @break

                                    @case('high')
                                        <span class="badge bg-warning px-3 py-2 rounded-pill text-dark">
                                            <i class="bi bi-exclamation-circle-fill me-1"></i>High Priority
                                        </span>
                                    @break

                                    @case('medium')
                                        <span class="badge bg-info px-3 py-2 rounded-pill">
                                            <i class="bi bi-info-circle-fill me-1"></i>Medium Priority
                                        </span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                            <i class="bi bi-circle-fill me-1"></i>Normal Priority
                                        </span>
                                @endswitch
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="notification-content mb-4">
                            <p class="text-dark lh-lg mb-0" style="font-size: 0.95rem;">
                                {{ $note->content }}
                            </p>
                        </div>

                        {{-- Image if exists --}}
                        @if (!empty($note->image))
                            <div class="text-center mb-4">
                                <div class="border rounded-3 p-2 bg-light"> <img
                                        src="{{ asset('storage/' . $note->image) }}" alt="Notification Image"
                                        class="img-fluid rounded-2 shadow-sm" style="max-height: 300px; width: auto;">
                                </div>
                            </div>
                        @endif

                        {{-- Tags and Target Audience --}}
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            @if (!empty($note->tag))
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                    <i class="bi bi-tag me-1"></i>{{ $note->tag }}
                                </span>
                            @endif

                            @if (!empty($note->target_audience))
                                <span
                                    class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 rounded-pill">
                                    <i class="bi bi-people me-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $note->target_audience)) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                        <div class="d-flex justify-content-between w-100 align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                Published:
                                {{ $note->publication_date ? \Carbon\Carbon::parse($note->publication_date)->format('F j, Y') : 'Not set' }}
                            </small>
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                data-bs-dismiss="modal">
                                <i class="bi bi-x-lg me-1"></i>Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Header Navigation -->
    <header class="header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Brand -->
                <a href="" class="navbar-brand">
                    <div class="brand-logo"><img src="{{ asset('img/logo.png') }}" alt="Logo" width="40"
                            height="40"></div>
                    <span class="brand-name">MP</span>
                </a>

                <!-- Search -->
                <div class="nav-search d-none d-md-block">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="navSearch" placeholder="Search companies, industries, employers...">
                </div>

                <!-- Navigation Actions -->
                <div class="nav-actions">
                    <a href="{{ route('applicant.forum.display') }}">
                        <button class="nav-icon">
                            <i class="bi bi-people"></i>
                        </button></a>

                    <!-- Messages Dropdown -->
                    <div class="nav-dropdown">
                        <button class="nav-icon" onclick="toggleDropdown('messagesDropdown')">
                            <i class="bi bi-chat-dots"></i>
                            <span class="nav-badge"
                                id="messagesBadge">{{ $messages->where('status', 'unread')->count() }}</span>
                        </button>

                        <div class="dropdown-menu" id="messagesDropdown">
                            <div class="dropdown-header">
                                <h6>Messages</h6>
                                <button class="mark-all-read" onclick="markAllAsRead('messages')">Mark all as
                                    read</button>
                            </div>

                            <div class="dropdown-content">
                                <div class="messages-list">
                                    @forelse($messages->groupBy('employer.id') as $employerId => $employerMessages)
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
                                                        <span
                                                            class="message-time">{{ $lastMessage->created_at->diffForHumans() }}</span>
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
                                            <input type="text" placeholder="Search conversations..."
                                                class="search-input" id="searchInput">
                                        </div>
                                    </div>

                                    <div class="employers-list" id="employersList">
                                        @forelse($messages->groupBy('employer.id') as $employerId => $employerMessages)
                                            @php
                                                $employer = $employerMessages->first()->employer;
                                                $unreadCount = $employerMessages->where('status', 'unread')->count();
                                                $lastMessage = $employerMessages->sortByDesc('created_at')->first();
                                            @endphp

                                            <div class="employer-list-item {{ $unreadCount > 0 ? 'has-unread' : '' }}"
                                                data-employer-id="{{ $employerId }}"
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

                                    <!-- Enhanced Messages Container -->
                                    <div class="messages-container" id="messagesContainer">
                                        <div class="no-conversation">
                                            <div class="no-conversation-icon">
                                                <i class="bi bi-chat-square-dots"></i>
                                            </div>
                                            <h3>Select a conversation</h3>
                                            <p>Choose an employer from the list to view your messages and start chatting
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Enhanced Reply Area -->
                                    <div class="reply-area" id="replyArea" style="display: none;">
                                        <div class="reply-container">
                                            <div class="message-input-wrapper">
                                                <button class="attachment-btn" title="Attach file">
                                                    <i class="bi bi-paperclip"></i>
                                                </button>
                                                <textarea class="reply-input" id="replyInput" placeholder="Type your message..." rows="1"></textarea>
                                                <button class="emoji-btn" title="Add emoji">
                                                    <i class="bi bi-emoji-smile"></i>
                                                </button>
                                            </div>
                                            <button class="send-btn" id="sendBtn" disabled>
                                                <i class="bi bi-send"></i>
                                            </button>
                                        </div>
                                        <div class="typing-indicator" id="typingIndicator" style="display: none;">
                                            <span>Employer is typing...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        /* Enhanced Dropdown Styles */
                        .dropdown-content .messages-list {
                            max-height: 450px;
                            overflow-y: auto;
                        }

                        .employer-item {
                            display: flex;
                            align-items: flex-start;
                            padding: 16px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            border-left: 4px solid transparent;
                            position: relative;
                            gap: 12px;
                            border-radius: 8px;
                            margin: 4px 8px;
                        }

                        .employer-item:hover {
                            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                            transform: translateY(-1px);
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        }

                        .employer-item.unread {
                            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                            border-left-color: #f59e0b;
                            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.2);
                        }

                        .message-avatar {
                            width: 48px;
                            height: 48px;
                            border-radius: 12px;
                            overflow: hidden;
                            flex-shrink: 0;
                            position: relative;
                        }

                        .message-avatar img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                        }

                        .avatar-placeholder {
                            width: 100%;
                            height: 100%;
                            background: linear-gradient(135deg, #667eea, #764ba2);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-weight: 700;
                            font-size: 16px;
                            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
                        }

                        .message-content {
                            flex: 1;
                            min-width: 0;
                        }

                        .sender-name {
                            font-size: 15px;
                            font-weight: 700;
                            color: #1e293b;
                            display: block;
                            margin-bottom: 3px;
                        }

                        .company-name {
                            font-size: 13px;
                            color: #64748b;
                            font-weight: 600;
                            display: block;
                            margin-bottom: 6px;
                        }

                        .message-meta {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 6px;
                        }

                        .message-time {
                            font-size: 12px;
                            color: #94a3b8;
                            font-weight: 500;
                        }

                        .unread-count {
                            background: linear-gradient(135deg, #ef4444, #dc2626);
                            color: white;
                            font-size: 11px;
                            font-weight: 700;
                            padding: 3px 8px;
                            border-radius: 12px;
                            min-width: 20px;
                            text-align: center;
                            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
                        }

                        .message-preview {
                            font-size: 13px;
                            color: #64748b;
                            line-height: 1.4;
                            display: -webkit-box;
                            -webkit-line-clamp: 2;
                            -webkit-box-orient: vertical;
                            overflow: hidden;
                        }

                        /* Professional Chat Modal Styles */
                        .chat-modal {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100vw;
                            height: 100vh;
                            z-index: 9999;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            padding: 0;
                        }

                        .chat-modal-overlay {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8));
                            backdrop-filter: blur(8px);
                            z-index: 1;
                        }

                        .chat-modal-content {
                            position: relative;
                            width: 95vw;
                            max-width: 1400px;
                            height: 90vh;
                            min-height: 600px;
                            background: white;
                            border-radius: 24px;
                            overflow: hidden;
                            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.3);
                            border: 1px solid rgba(255, 255, 255, 0.1);
                            z-index: 2;
                            margin: auto;
                        }

                        .chat-container {
                            width: 100%;
                            height: 100%;
                            display: flex;
                        }

                        /* Enhanced Sidebar Styles */
                        .employers-sidebar {
                            width: 380px;
                            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
                            border-right: 1px solid #e2e8f0;
                            display: flex;
                            flex-direction: column;
                        }

                        .sidebar-header {
                            padding: 24px;
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            color: white;
                            position: relative;
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                        }

                        .header-content h2 {
                            font-size: 20px;
                            font-weight: 700;
                            margin-bottom: 4px;
                            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
                        }

                        .header-content p {
                            font-size: 14px;
                            opacity: 0.9;
                            margin: 0;
                        }

                        .close-chat-btn {
                            background: rgba(255, 255, 255, 0.2);
                            border: none;
                            color: white;
                            font-size: 16px;
                            padding: 8px;
                            border-radius: 8px;
                            cursor: pointer;
                            transition: all 0.3s;
                        }

                        .close-chat-btn:hover {
                            background: rgba(255, 255, 255, 0.3);
                            transform: scale(1.05);
                        }

                        .search-container {
                            padding: 20px;
                            background: white;
                            border-bottom: 1px solid #f1f5f9;
                        }

                        .search-input-wrapper {
                            position: relative;
                            display: flex;
                            align-items: center;
                        }

                        .search-input-wrapper i {
                            position: absolute;
                            left: 12px;
                            color: #94a3b8;
                            font-size: 14px;
                        }

                        .search-input {
                            width: 100%;
                            padding: 12px 16px 12px 40px;
                            border: 2px solid #f1f5f9;
                            border-radius: 12px;
                            font-size: 14px;
                            background: #f8fafc;
                            transition: all 0.3s;
                        }

                        .search-input:focus {
                            outline: none;
                            border-color: #667eea;
                            background: white;
                            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
                        }

                        .employers-list {
                            flex: 1;
                            overflow-y: auto;
                            padding: 12px;
                        }

                        .employer-list-item {
                            padding: 16px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            border-left: 4px solid transparent;
                            display: flex;
                            align-items: flex-start;
                            gap: 12px;
                            border-radius: 12px;
                            margin-bottom: 8px;
                            position: relative;
                        }

                        .employer-list-item:hover {
                            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                            transform: translateX(4px);
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                        }

                        .employer-list-item.active {
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            border-left-color: #4f46e5;
                            color: white;
                            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
                        }

                        .employer-list-item.active .employer-name,
                        .employer-list-item.active .company-name,
                        .employer-list-item.active .last-message-preview,
                        .employer-list-item.active .last-message-time {
                            color: white;
                        }

                        .employer-list-item.has-unread {
                            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                            border-left-color: #f59e0b;
                        }

                        .employer-avatar {
                            width: 52px;
                            height: 52px;
                            border-radius: 14px;
                            overflow: hidden;
                            flex-shrink: 0;
                            position: relative;
                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                        }

                        .online-status {
                            position: absolute;
                            bottom: 2px;
                            right: 2px;
                            width: 14px;
                            height: 14px;
                            background: #10b981;
                            border: 2px solid white;
                            border-radius: 50%;
                        }

                        .employer-info {
                            flex: 1;
                            min-width: 0;
                        }

                        .employer-name {
                            font-size: 15px;
                            font-weight: 700;
                            color: #1e293b;
                            margin-bottom: 3px;
                            line-height: 1.2;
                        }

                        .company-name {
                            font-size: 13px;
                            color: #64748b;
                            font-weight: 600;
                            margin-bottom: 4px;
                        }

                        .last-message-preview {
                            font-size: 12px;
                            color: #94a3b8;
                            line-height: 1.3;
                            margin-bottom: 3px;
                            display: -webkit-box;
                            -webkit-line-clamp: 1;
                            -webkit-box-orient: vertical;
                            overflow: hidden;
                        }

                        .last-message-time {
                            font-size: 11px;
                            color: #cbd5e1;
                            font-weight: 500;
                        }

                        /* Enhanced Chat Area Styles */
                        .chat-area {
                            flex: 1;
                            display: flex;
                            flex-direction: column;
                            background: #fafbfc;
                        }

                        .chat-header {
                            padding: 20px 24px;
                            border-bottom: 1px solid #e2e8f0;
                            background: white;
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                        }

                        .header-left {
                            display: flex;
                            align-items: center;
                            gap: 12px;
                        }

                        .current-employer-avatar {
                            width: 48px;
                            height: 48px;
                            border-radius: 12px;
                            overflow: hidden;
                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                        }

                        .current-employer-info h3 {
                            font-size: 16px;
                            font-weight: 700;
                            color: #1e293b;
                            margin: 0 0 3px 0;
                        }

                        .current-employer-info p {
                            font-size: 13px;
                            color: #64748b;
                            margin: 0 0 2px 0;
                            font-weight: 500;
                        }

                        .online-status-text {
                            font-size: 11px;
                            color: #10b981;
                            font-weight: 600;
                        }

                        .header-actions {
                            display: flex;
                            gap: 8px;
                        }

                        .header-action-btn {
                            width: 40px;
                            height: 40px;
                            border: none;
                            border-radius: 10px;
                            background: #f8fafc;
                            color: #64748b;
                            cursor: pointer;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 16px;
                            transition: all 0.3s;
                        }

                        .header-action-btn:hover {
                            background: #e2e8f0;
                            color: #475569;
                            transform: scale(1.05);
                        }

                        .messages-container {
                            flex: 1;
                            overflow-y: auto;
                            padding: 24px;
                            background: linear-gradient(180deg, #fafbfc 0%, #f1f5f9 100%);
                        }

                        .message-bubble {
                            max-width: 75%;
                            margin-bottom: 16px;
                            display: flex;
                            flex-direction: column;
                            animation: messageSlideIn 0.3s ease-out;
                        }

                        @keyframes messageSlideIn {
                            from {
                                opacity: 0;
                                transform: translateY(10px);
                            }

                            to {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }

                        .message-bubble.from-employer {
                            align-self: flex-start;
                        }

                        .message-bubble.from-applicant {
                            align-self: flex-end;
                        }

                        .message-bubble .message-content {
                            padding: 12px 16px;
                            border-radius: 16px;
                            word-wrap: break-word;
                            font-size: 14px;
                            line-height: 1.5;
                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                        }

                        .message-bubble.from-employer .message-content {
                            background: white;
                            border: 1px solid #e2e8f0;
                            border-bottom-left-radius: 6px;
                            color: #1e293b;
                        }

                        .message-bubble.from-applicant .message-content {
                            background: linear-gradient(135deg, #667eea, #764ba2);
                            color: white;
                            border-bottom-right-radius: 6px;
                        }

                        .message-timestamp {
                            font-size: 11px;
                            color: #94a3b8;
                            margin-top: 6px;
                            padding: 0 6px;
                            font-weight: 500;
                        }

                        .message-bubble.from-applicant .message-timestamp {
                            align-self: flex-end;
                            color: rgba(255, 255, 255, 0.8);
                        }

                        .reply-area {
                            padding: 20px 24px;
                            border-top: 1px solid #e2e8f0;
                            background: white;
                            box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.05);
                        }

                        .reply-container {
                            display: flex;
                            align-items: flex-end;
                            gap: 12px;
                            margin-bottom: 8px;
                        }

                        .message-input-wrapper {
                            flex: 1;
                            position: relative;
                            display: flex;
                            align-items: flex-end;
                            background: #f8fafc;
                            border: 2px solid #e2e8f0;
                            border-radius: 16px;
                            padding: 4px;
                            transition: all 0.3s;
                        }

                        .message-input-wrapper:focus-within {
                            border-color: #667eea;
                            background: white;
                            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
                        }

                        .attachment-btn,
                        .emoji-btn {
                            width: 36px;
                            height: 36px;
                            border: none;
                            background: transparent;
                            color: #64748b;
                            cursor: pointer;
                            border-radius: 8px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 16px;
                            transition: all 0.3s;
                        }

                        .attachment-btn:hover,
                        .emoji-btn:hover {
                            background: #e2e8f0;
                            color: #475569;
                        }

                        .reply-input {
                            flex: 1;
                            min-height: 36px;
                            max-height: 120px;
                            padding: 8px 12px;
                            border: none;
                            background: transparent;
                            font-size: 14px;
                            font-family: inherit;
                            resize: none;
                            outline: none;
                            line-height: 1.5;
                        }

                        .reply-input::placeholder {
                            color: #94a3b8;
                        }

                        .send-btn {
                            width: 44px;
                            height: 44px;
                            border: none;
                            border-radius: 12px;
                            background: linear-gradient(135deg, #667eea, #764ba2);
                            color: white;
                            cursor: pointer;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 16px;
                            transition: all 0.3s;
                            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
                        }

                        .send-btn:hover:not(:disabled) {
                            transform: translateY(-2px);
                            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
                        }

                        .send-btn:disabled {
                            opacity: 0.5;
                            cursor: not-allowed;
                            transform: none;
                            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
                        }

                        .typing-indicator {
                            padding: 8px 16px;
                            font-size: 12px;
                            color: #64748b;
                            font-style: italic;
                        }

                        .no-conversation {
                            flex: 1;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            text-align: center;
                            padding: 60px 40px;
                        }

                        .no-conversation-icon {
                            width: 80px;
                            height: 80px;
                            border-radius: 50%;
                            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin-bottom: 20px;
                        }

                        .no-conversation-icon i {
                            font-size: 32px;
                            color: #64748b;
                        }

                        .no-conversation h3 {
                            font-size: 18px;
                            font-weight: 700;
                            color: #1e293b;
                            margin-bottom: 8px;
                        }

                        .no-conversation p {
                            color: #64748b;
                            font-size: 14px;
                            line-height: 1.5;
                            max-width: 300px;
                        }

                        /* Responsive Design */
                        @media (max-width: 1024px) {
                            .chat-modal-content {
                                width: 95%;
                                height: 85vh;
                            }

                            .employers-sidebar {
                                width: 320px;
                            }
                        }

                        @media (max-width: 768px) {
                            .chat-modal-content {
                                width: 100%;
                                height: 100vh;
                                border-radius: 0;
                            }

                            .employers-sidebar {
                                width: 280px;
                            }

                            .message-bubble {
                                max-width: 85%;
                            }
                        }

                        @media (max-width: 640px) {
                            .chat-container {
                                flex-direction: column;
                            }

                            .employers-sidebar {
                                width: 100%;
                                height: 40%;
                                border-right: none;
                                border-bottom: 1px solid #e2e8f0;
                            }

                            .chat-area {
                                height: 60%;
                            }
                        }
                    </style>
                    <script>
                        let currentEmployerId = null;
                        let allMessages = @json($messages);

                        // Open chat with specific employer
                        function openChatWithEmployer(employerId, firstName, lastName, companyName) {
                            document.getElementById('chatModal').style.display = 'flex';
                            document.body.style.overflow = 'hidden';

                            // Load the specific conversation
                            setTimeout(() => {
                                loadConversation(employerId);
                            }, 100);
                        }

                        // Open all chats
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

                            // Update active state
                            document.querySelectorAll('.employer-list-item').forEach(item => {
                                item.classList.remove('active');
                            });
                            document.querySelector(`[data-employer-id="${employerId}"]`).classList.add('active');

                            // Get employer messages
                            const employerMessages = allMessages.filter(msg => msg.employer.id == employerId);
                            const employer = employerMessages[0].employer;

                            // Update chat header
                            document.getElementById('chatHeader').style.display = 'flex';
                            document.getElementById('currentEmployerName').textContent =
                                `${employer.personal_info.first_name || 'N/A'} ${employer.personal_info.last_name || 'N/A'}`;
                            document.getElementById('currentCompanyName').textContent =
                                employer.addressCompany.company_name || 'Company';

                            // Update avatar
                            const avatarElement = document.getElementById('currentAvatar');
                            if (employer.addressCompany.company_logo) {
                                avatarElement.innerHTML = `<img src="${employer.addressCompany.company_logo}" 
            alt="${employer.addressCompany.company_name}" style="width:100%;height:100%;object-fit:cover;">`;
                            } else {
                                avatarElement.textContent = (employer.addressCompany.company_name || 'C').charAt(0).toUpperCase();
                            }

                            // Load messages
                            displayMessages(employerMessages);

                            // Show reply area
                            document.getElementById('replyArea').style.display = 'block';

                            // Mark messages as read
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

                            // Sort messages by date
                            messages.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));

                            container.innerHTML = messages.map(msg => {
                                const isFromEmployer = msg.sender_type === 'employer' || !msg
                                    .sender_type; // Assuming employer messages
                                const bubbleClass = isFromEmployer ? 'from-employer' : 'from-applicant';

                                return `
            <div class="message-bubble ${bubbleClass}">
                <div class="message-content">
                    ${msg.message}
                </div>
                <div class="message-timestamp">
                    ${formatMessageTime(msg.created_at)}
                </div>
            </div>
        `;
                            }).join('');

                            // Scroll to bottom
                            container.scrollTop = container.scrollHeight;
                        }

                        // Send reply
                        function sendReply() {
                            const replyInput = document.getElementById('replyInput');
                            const message = replyInput.value.trim();
                            if (!message || !currentEmployerId) return;

                            // Add message to UI immediately
                            const container = document.getElementById('messagesContainer');
                            const messageHtml = `
        <div class="message-bubble from-applicant">
            <div class="message-content">
                ${message}
            </div>
            <div class="message-timestamp">
                Just now
            </div>
        </div>
    `;

                            container.innerHTML += messageHtml;
                            container.scrollTop = container.scrollHeight;

                            // Clear input
                            replyInput.value = '';
                            replyInput.style.height = 'auto';
                            document.getElementById('sendBtn').disabled = true;

                            // Here you would make an AJAX call to send the message
                            // sendMessageToServer(currentEmployerId, message);
                        }

                        // Mark messages as read
                        function markMessagesAsRead(employerId) {
                            // Update dropdown item
                            const dropdownItem = document.querySelector(`.employer-item[data-employer-id="${employerId}"]`);
                            if (dropdownItem) {
                                dropdownItem.classList.remove('unread');
                                const unreadIndicator = dropdownItem.querySelector('.unread-indicator');
                                if (unreadIndicator) unreadIndicator.remove();
                                const unreadCount = dropdownItem.querySelector('.unread-count');
                                if (unreadCount) unreadCount.remove();
                            }

                            // Update sidebar item
                            const sidebarItem = document.querySelector(`.employer-list-item[data-employer-id="${employerId}"]`);
                            if (sidebarItem) {
                                sidebarItem.classList.remove('has-unread');
                                const unreadCount = sidebarItem.querySelector('.unread-count');
                                if (unreadCount) unreadCount.remove();
                            }

                            // Here you would make an AJAX call to mark messages as read
                            // markAsReadOnServer(employerId);
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

                        // Initialize chat functionality
                        document.addEventListener('DOMContentLoaded', function() {
                            const replyInput = document.getElementById('replyInput');
                            const sendBtn = document.getElementById('sendBtn');

                            if (replyInput && sendBtn) {
                                // Auto-resize textarea
                                replyInput.addEventListener('input', function() {
                                    this.style.height = 'auto';
                                    this.style.height = this.scrollHeight + 'px';

                                    sendBtn.disabled = !this.value.trim();
                                });

                                // Handle enter key
                                replyInput.addEventListener('keydown', function(e) {
                                    if (e.key === 'Enter' && !e.shiftKey) {
                                        e.preventDefault();
                                        sendReply();
                                    }
                                });

                                // Send button click
                                sendBtn.addEventListener('click', sendReply);
                                sendBtn.disabled = true;
                            }

                            // Handle escape key to close modal
                            document.addEventListener('keydown', function(e) {
                                if (e.key === 'Escape') {
                                    closeChatModal();
                                }
                            });
                        });

                        // Legacy functions for dropdown interactions
                        document.addEventListener('DOMContentLoaded', function() {
                            // Add hover effects and click animations for dropdown items
                            const employerItems = document.querySelectorAll('.employer-item');

                            employerItems.forEach(item => {
                                item.addEventListener('click', function() {
                                    // Add a subtle click effect
                                    this.style.transform = 'scale(0.98)';
                                    setTimeout(() => {
                                        this.style.transform = '';
                                    }, 150);
                                });
                            });
                        });
                    </script>

                    <!-- Notifications Dropdown -->
                    <div class="nav-dropdown">
                        <button class="nav-icon" onclick="toggleDropdown('notificationsDropdown')">
                            <i class="bi bi-bell"></i>
                            @php
                                $unreadCount = isset($notifications) ? $notifications->where('is_read', 0)->count() : 0;
                                $suspendedCount = isset($suspendedNotifications) ? $suspendedNotifications->count() : 0;
                                $totalCount = $unreadCount + $suspendedCount;
                            @endphp
                            @if ($totalCount > 0)
                                <span class="nav-badge" id="notificationsBadge">{{ $totalCount }}</span>
                            @endif
                        </button>



                        <div class="dropdown-menu shadow-sm border-0" id="notificationsDropdown"
                            style="min-width: 320px; max-height: 400px; overflow-y: auto;">

                            <div
                                class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                                <h6 class="mb-0">Notifications</h6>
                                <button class="mark-all-read btn btn-sm btn-link text-primary p-0"
                                    onclick="markAllAsRead()">
                                    Mark all as read
                                </button>
                            </div>

                            <div class="dropdown-content p-2">
                                {{-- Regular Notifications --}}
                                @if (isset($notifications) && count($notifications) > 0)
                                    @foreach ($notifications as $note)
                                        <div class="notification-item d-flex align-items-start gap-2 p-2 mb-2 rounded hover-shadow {{ !$note->is_read ? 'unread' : '' }}"
                                            style="cursor: pointer;" data-id="{{ $note->id }}"
                                            data-note-id="{{ $note->id }}"
                                            onclick="markAsRead({{ $note->id }})" data-bs-toggle="modal"
                                            data-bs-target="#viewNotificationModal-{{ $note->id }}">

                                            {{-- Icon --}}
                                            <div class="notification-icon flex-shrink-0">
                                                @if ($note->priority === 'urgent' && $note->target_audience === 'applicants')
                                                    <i class="bi bi-shield-fill-check text-success fs-5"></i>
                                                @elseif ($note->priority)
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 32px; height: 32px;">
                                                        <img src="{{ asset('img/logo.png') }}" alt="Admin Logo"
                                                            style="width: 20px; height: 20px; border-radius: 50%; background-color: #0d6efd;">
                                                    </div>
                                                @else
                                                    <i class="bi bi-bell-fill text-primary fs-5"></i>
                                                @endif
                                            </div>

                                            {{-- Content --}}
                                            <div class="notification-content flex-grow-1">
                                                <div class="notification-title fw-semibold text-dark mb-1">
                                                    {{ $note->title }}
                                                </div>
                                                <div class="notification-message text-muted small mb-1"
                                                    style="line-height: 1.2;">
                                                    {{ \Illuminate\Support\Str::limit($note->content, 60, '...') }}
                                                </div>
                                                <div class="notification-time text-muted small">
                                                    {{ $note->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="notification-item text-center text-muted p-3">
                                        No new notifications
                                    </div>
                                @endif

                                {{-- Suspended Notifications --}}
                                @if ($isSuspended)
                                    <div
                                        class="notification-item d-flex align-items-start gap-2 p-2 mb-2 rounded border border-danger bg-light">
                                        <div class="notification-icon flex-shrink-0">
                                            <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                                        </div>
                                        <div class="notification-content flex-grow-1">
                                            <div class="notification-title fw-semibold text-dark mb-1">
                                                {{ $suspendedApplicant->personal_info->first_name ?? 'Unknown' }}
                                                {{ $suspendedApplicant->personal_info->last_name ?? '' }}
                                            </div>
                                            <div class="notification-message text-muted small mb-1"
                                                style="line-height:1.3;">
                                                Suspended due to:
                                                @if ($suspension->reason == 'multiple_user_reports')
                                                    <span class="text-danger fw-semibold">Multiple User Reports</span>
                                                @elseif ($suspension->reason == 'pending_investigation')
                                                    <span class="text-danger fw-semibold">Pending Investigation</span>
                                                @elseif ($suspension->reason == 'suspicious_activity')
                                                    <span class="text-danger fw-semibold">Suspicious Activity</span>
                                                @elseif ($suspension->reason == 'other')
                                                    <span class="text-danger fw-semibold">Other:
                                                        {{ $suspension->other_reason }}</span>
                                                @endif
                                            </div>

                                            <div class="notification-restriction text-danger small fw-semibold mb-1">
                                                You cannot apply for jobs for
                                                {{ $suspension->suspension_duration }}
                                                {{ $suspension->suspension_duration == 1 ? 'day' : 'days' }}.
                                            </div>

                                            <div class="notification-time text-muted small">
                                                Applies until:
                                                {{ $suspension->created_at->addDays($suspension->suspension_duration)->format('M d, Y h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>


                            <div class="dropdown-footer border-top p-2 text-center">
                                <a href="#" class="view-all-link text-primary small text-decoration-none"
                                    data-bs-toggle="modal" data-bs-target="#viewAllNotificationsModal">
                                    View All Notifications
                                </a>
                            </div>

                            {{-- View All Notifications Modal --}}
                            <div class="modal fade" id="viewAllNotificationsModal" tabindex="-1" aria-hidden="true"
                                data-bs-backdrop="false">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                                    <div class="modal-content rounded-3 shadow">
                                        <div class="modal-header">
                                            <h5 class="modal-title">All Notifications</h5>
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @forelse ($notifications as $note)
                                                <div class="border-bottom p-2 mb-2 {{ !$note->is_read ? 'fw-bold' : '' }}"
                                                    style="cursor: pointer;" data-bs-toggle="modal"
                                                    data-bs-target="#viewNotificationModal-{{ $note->id }}">
                                                    <h6>{{ $note->title }}</h6>
                                                    <p class="mb-1">{{ $note->content }}</p>
                                                    <small class="text-muted">
                                                        {{ $note->created_at->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>

                                                {{-- Individual Notification Modal --}}
                                                <div class="modal fade"
                                                    id="viewNotificationModal-{{ $note->id }}" tabindex="-1"
                                                    aria-hidden="true" data-bs-backdrop="false">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content rounded-3 shadow">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ $note->title }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $note->content }}</p>
                                                                <small class="text-muted">
                                                                    {{ $note->created_at->format('M d, Y h:i A') }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-center text-muted">No notifications available</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Optional: CSS --}}
                    <style>
                        .hover-shadow:hover {
                            background-color: #f8f9fa;
                            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                            transition: all 0.2s ease-in-out;
                        }

                        .notification-item.unread {
                            background-color: #e9f5ff;
                        }

                        .notification-content a {
                            text-decoration: none;
                            color: inherit;
                        }
                    </style>

                    {{-- JS for marking as read --}}
                    <script>
                        /**
                         * Marks a single notification as read and removes the 'unread' class on success.
                         */
                        async function markAsRead(id) {
                            try {
                                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                const res = await fetch(`notifications/${id}/read`, {
                                    method: 'POST',
                                    credentials: 'same-origin',
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({})
                                });

                                if (!res.ok) {
                                    console.error('markAsRead failed, status:', res.status);
                                    return;
                                }

                                const data = await res.json();
                                if (data.success) {
                                    // remove unread highlight
                                    const el = document.querySelector(`[data-note-id="${id}"]`) || document.querySelector(
                                        `[data-id="${id}"]`);
                                    if (el) el.classList.remove('unread');

                                    // 🔥 update badge count
                                    const badge = document.querySelector('#notificationsBadge');
                                    if (badge) {
                                        let current = parseInt(badge.innerText) || 0;
                                        if (current > 0) {
                                            badge.innerText = current - 1;
                                            if (current - 1 === 0) {
                                                badge.remove(); // hide badge if 0
                                            }
                                        }
                                    }
                                }
                            } catch (err) {
                                console.error('Error in markAsRead:', err);
                            }
                        }


                        async function markAllAsRead() {
                            try {
                                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                const res = await fetch(`notifications/mark-all-read`, {
                                    method: 'POST',
                                    credentials: 'same-origin',
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({})
                                });

                                if (!res.ok) {
                                    console.error('markAllAsRead failed, status:', res.status);
                                    return;
                                }

                                const data = await res.json();
                                if (data.success) {
                                    // 🔹 Remove "unread" class from all items
                                    document.querySelectorAll('.notification-item.unread').forEach(el => {
                                        el.classList.remove('unread');
                                    });

                                    // 🔹 Reset badge count
                                    const badge = document.querySelector('#notificationsBadge');
                                    if (badge) {
                                        badge.remove(); // hide badge since all are read
                                    }
                                }
                            } catch (err) {
                                console.error('Error in markAllAsRead:', err);
                            }
                        }
                    </script>


                    <style>
                        /* Hover shadow effect */
                        .hover-shadow:hover {
                            background-color: #f8f9fa;
                            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                            transition: all 0.2s ease-in-out;
                        }

                        /* Remove underline for links inside notifications */
                        .notification-content a {
                            text-decoration: none;
                            color: inherit;
                        }

                        /* Unread highlight */
                        .notification-item.unread {
                            background-color: #e9f5ff;
                        }
                    </style>









                    <!-- Profile Dropdown -->
                    <div class="nav-dropdown">
                        <button class="profile-pic" onclick="toggleDropdown('profileDropdown')">
                            {{ strtoupper(substr($retrievePersonal->personal_info->first_name, 0, 1)) }}
                            {{ strtoupper(substr($retrievePersonal->personal_info->last_name, 0, 1)) }}
                        </button>
                        <div class="dropdown-menu profile-menu" id="profileDropdown">
                            <div class="profile-header">
                                <div class="profile-avatar">
                                    @if ($retrievePersonal->personal_info)
                                        @if (!empty($retrievePersonal->work_background) && !empty($retrievePersonal->work_background->profileimage_path))
                                            <img src="{{ asset('storage/' . $retrievePersonal->work_background->profileimage_path) }}"
                                                alt="Profile Picture" width="50" height="50"
                                                style="border-radius: 50%;">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                {{ strtoupper(substr($retrievePersonal->first_name ?? 'U', 0, 1)) }}
                                            </div>
                                        @endif
                                    @else
                                        ??
                                    @endif
                                </div>
                                <div class="profile-info">
                                    <div class="profile-name">
                                        {{ $retrievePersonal->personal_info->first_name ?? 'Unknown' }}
                                        {{ $retrievePersonal->personal_info->last_name ?? '' }}
                                    </div>
                                    <div class="profile-email">
                                        {{ $retrievePersonal->email ?? 'Not Provided' }}
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-content">
                                <a href="{{ route('applicant.profile.display') }}" class="dropdown-item">
                                    <i class="bi bi-person"></i>
                                    My Profile
                                </a>
                                <a href="{{ route('applicant.callingcard.display') }}" class="dropdown-item">
                                    <i class="bi bi-person-badge"></i>
                                    Ar calling card
                                </a>
                                <a href="{{ route('applicant.resume.display') }}" class="dropdown-item">
                                    <i class="bi bi-file-text"></i>
                                    Resume Generator
                                </a>
                                <a href="{{ route('applicant.application.status.display') }}" class="dropdown-item">
                                    <i class="bi bi-file-text"></i>
                                    My Applications
                                </a>
                                <!-- <a href="#" class="dropdown-item">
                                    <i class="bi bi-bookmark"></i>
                                    Saved Jobs
                                </a> -->
                                <a href="#" class="dropdown-item">
                                    <i class="bi bi-gear"></i>
                                    Settings
                                </a>
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('applicant.logout.store') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Search -->
            <div class="nav-search d-md-none mt-3">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="mobileNavSearch" placeholder="Search companies, industries, employers...">
            </div>
        </div>
    </header>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" id="success-alert">
            <center>{{ session('success') }}</center>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <script>
            // Hide the alert after 5 seconds (5000 ms)
            setTimeout(() => {
                let alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.remove('show'); // fade out
                    alert.classList.add('fade'); // keep bootstrap fade animation
                    setTimeout(() => alert.remove(), 500); // remove from DOM after fade
                }
            }, 2000); // change to 2000 for 2 seconds
        </script>
    @endif

    <!-- Main Content -->
    <div class="container">
        <div class="main-section">
            <!-- Hero Banner -->
            <section class="hero-banner">
                <div class="hero-content">
                    <h1 class="hero-title">Discover Amazing <br>Career Opportunities</h1>
                    <p class="hero-subtitle">Connect with top employers and find your perfect job match</p>

                    <div class="hero-stats">
                        <div class="stat-card">
                            @if ($applicantCounts == 1)
                                <span class="stat-number">{{ $applicantCounts }}+</span>
                                <div class="stat-label">Skilled Workers Registered</div>
                            @else
                                <span class="stat-number">{{ $applicantCounts }}+</span>
                                <div class="stat-label">Skilled Workers Registered</div>
                            @endif
                        </div>
                        <div class="stat-card">
                            @if ($publishedCounts == 1)
                                <span class="stat-number">{{ $publishedCounts }} </span>
                                <div class="stat-label">Job Openings Available</div>
                            @else
                                <span class="stat-number">{{ $publishedCounts }}+</span>
                                <div class="stat-label">Job Openings Available</div>
                            @endif
                        </div>
                        <div class="stat-card">
                            @if ($tesdaCertificateCounts == 1)
                                <span class="stat-number">{{ $tesdaCertificateCounts }}</span>
                                <div class="stat-label">TESDA-Certified Employees</div>
                            @else
                                <span class="stat-number">{{ $tesdaCertificateCounts }}+</span>
                                <div class="stat-label">TESDA-Certified Employees</div>
                            @endif
                        </div>

                    </div>
                </div>
            </section>

            <!-- Filter Section -->
            <section class="filter-section">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Search Companies</label>
                        <input type="text" id="searchFilter" class="filter-input"
                            placeholder="Type company name or keyword...">
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Industry</label>
                        <select id="industryFilter" class="filter-select">
                            <option value="">All TESDA Industries</option>
                            @foreach ($JobPostRetrieved as $job)
                                @if ($job->status_post === 'published')
                                    <option value="{{ $job->department }}">{{ $job->department }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Location</label>
                        <select id="locationFilter" class="filter-select">
                            <option value="">All Locations in Cavite</option>
                            <!-- Cities -->
                            <option value="Bacoor">Bacoor City</option>
                            <option value="Cavite City">Cavite City</option>
                            <option value="Dasmariñas">Dasmariñas City</option>
                            <option value="Imus">Imus City</option>
                            <option value="Tagaytay">Tagaytay City</option>
                            <option value="Trece Martires">Trece Martires City</option>

                            <!-- Municipalities -->
                            <option value="Alfonso">Alfonso</option>
                            <option value="Amadeo">Amadeo</option>
                            <option value="Carmona">Carmona</option>
                            <option value="General Emilio Aguinaldo">General Emilio Aguinaldo</option>
                            <option value="General Mariano Alvarez">General Mariano Alvarez (GMA)</option>
                            <option value="General Trias">General Trias</option>
                            <option value="Indang">Indang</option>
                            <option value="Kawit">Kawit</option>
                            <option value="Magallanes">Magallanes</option>
                            <option value="Maragondon">Maragondon</option>
                            <option value="Mendez">Mendez</option>
                            <option value="Naic">Naic</option>
                            <option value="Noveleta">Noveleta</option>
                            <option value="Rosario">Rosario</option>
                            <option value="Silang">Silang</option>
                            <option value="Tanza">Tanza</option>
                            <option value="Ternate">Ternate</option>
                        </select>
                    </div>
                    <button class="clear-filters" onclick="clearAllFilters()">Clear All</button>
                </div>

                <!-- Filter Chips -->
                <div class="filter-chips">
                    <div class="filter-chip" data-filter="hiring" onclick="toggleChip(this, 'hiring')">
                        <i class="bi bi-lightning"></i> Actively Hiring
                    </div>
                    <div class="filter-chip" data-filter="urgent" onclick="toggleChip(this, 'urgent')">
                        <i class="bi bi-lightning"></i> Urgent Hiring
                    </div>

                    <!-- <div class="filter-chip" data-filter="remote" onclick="toggleChip(this, 'remote')">
                        <i class="bi bi-house"></i> Remote Work
                    </div>
                    <div class="filter-chip" data-filter="featured" onclick="toggleChip(this, 'featured')">
                        <i class="bi bi-star"></i> Featured
                    </div>
                    <div class="filter-chip" data-filter="startup" onclick="toggleChip(this, 'startup')">
                        <i class="bi bi-rocket"></i> Startup
                    </div> -->
                </div>
            </section>

            <!-- Results Section -->
            <section class="results-section">
                <div class="results-header">
                    <h2 class="results-count">
                        <span class="count" id="resultsCount">8</span> Companies Found
                    </h2>

                    <select class="sort-dropdown" id="sortDropdown" onchange="sortEmployers()">
                        <option value="name">Sort by Name</option>
                        <option value="rating">Sort by Rating</option>
                        <option value="location">Sort by Location</option>
                        <option value="industry">Sort by Industry</option>
                    </select>
                </div>


                <div class="employer-grid" id="employerGrid">
                    @foreach ($JobPostRetrieved as $jobDetail)
                        @if ($jobDetail->status_post === 'published')
                            <div class="employer-card" data-name="{{ $jobDetail->company_name ?? 'N/A' }}"
                                data-industry="{{ $jobDetail->department }}"
                                data-location="{{ $jobDetail->location }}" data-hiring="true" data-remote="false"
                                data-featured="false" data-rating="4.5">

                                <!-- Card Header -->
                                <div class="card-header">
                                    <div class="company-info">
                                        @php
                                            $company = $retrievedAddressCompany->first();
                                        @endphp

                                        @if ($company)
                                            <div class="company-avatar">
                                                {{ Str::limit($company->company_name ?? 'BC', 2, '') }}
                                            </div>
                                        @endif

                                        <div class="company-details">
                                            <h3>{{ $jobDetail->title }}</h3>
                                            <div class="company-industry">
                                                {{ $jobDetail->department }} • {{ $jobDetail->job_type }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="company-badges">
                                        <span class="status-badge status-active">
                                            <i class="bi bi-lightning"></i> Hiring
                                        </span>
                                    </div>
                                </div>

                                <!-- Job Description -->
                                <div class="card-body">
                                    <p class="company-description">{{ $jobDetail->job_description }}</p>

                                    @if ($jobDetail->benefits)
                                        <p class="company-description"><strong>Benefits:</strong>
                                            {{ $jobDetail->benefits }}</p>
                                    @endif
                                    <p class="company-description"><strong>Experience Level:</strong>
                                        {{ $jobDetail->experience_level }} </p>
                                    <p class="company-description"><strong>Salary range: ₱</strong>
                                        {{ $jobDetail->job_salary }} Monthly</p>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer">
                                    <div class="company-stats">
                                        <div class="stat-item">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>{{ $jobDetail->location }}</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="card-actions d-flex gap-2 mt-2">
                                        <!-- View Details -->
                                        <button class="btn btn-primary btn-sm view-details-btn"
                                            data-title="{{ $jobDetail->title }}"
                                            data-company="{{ $retrievedAddressCompany->first()->company_name ?? 'Unknown Company' }}"
                                            data-industry="{{ $jobDetail->department }}"
                                            data-location="{{ $jobDetail->location }}"
                                            data-description="{{ $jobDetail->job_description }}"
                                            data-benefits="{{ $jobDetail->benefits ?? 'None' }}"
                                            data-salary="{{ $jobDetail->job_salary }}"
                                            data-experience="{{ $jobDetail->experience_level ?? 'N/A' }}"
                                            @if (Str::contains($jobDetail->tesda_certification, 'Other')) data-tesda="{{ $jobDetail->other_certifications ?? 'N/A' }}"
                            data-none="N/A"
                        @else
                            data-tesda="{{ $jobDetail->tesda_certification ?? 'N/A' }}"
                            data-none="{{ $jobDetail->none_certifications_qualification ?? 'N/A' }}" @endif
                                            data-bs-toggle="modal" data-bs-target="#viewDetailsModal">
                                            View Details
                                        </button>

                                        <!-- Save/Unsave Job -->
                                        <form action="{{ route('jobs.toggleSave', $jobDetail->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @if (in_array($jobDetail->id, $savedJobIds))
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-bookmark-dash"></i> Unsave Job
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-bookmark-plus"></i> Save Job
                                                </button>
                                            @endif
                                        </form>

                                        @php
                                            // Check if applicant has applied for this job
                                            $applicationRecord = \App\Models\Applicant\ApplyJobModel::where(
                                                'job_id',
                                                $jobDetail->id ?? null,
                                            )
                                                ->where('applicant_id', session('applicant_id'))
                                                ->first(); // Use first() instead of exists() to get the actual record

                                            // Determine if applicant has an active application (not rejected)
                                            $hasActiveApplication =
                                                $applicationRecord && $applicationRecord->status !== 'rejected';
                                        @endphp

                                        @if ($hasActiveApplication)
                                            <!-- Cancel Application Button - Show only if application is pending/approved/interview -->
                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#cancelApplicationModal"
                                                data-job-id="{{ $jobDetail->id }}"
                                                data-title="{{ $jobDetail->title }}"
                                                data-company="{{ $retrievedAddressCompany->first()->company_name ?? 'Unknown Company' }}"
                                                data-location="{{ $jobDetail->location }}">
                                                <i class="fas fa-times me-1"></i> Cancel Application
                                            </button>
                                        @else
                                            {{-- Check if applicant is suspended --}}
                                            @if ($isSuspended)
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="bi bi-slash-circle"></i>
                                                    Suspended ({{ $suspension->suspension_duration }}
                                                    {{ $suspension->suspension_duration == 1 ? 'day' : 'days' }})
                                                </button>
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        You cannot apply until
                                                        {{ $suspension->created_at->addDays($suspension->suspension_duration)->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                            @else
                                                <!-- Apply Job Button - Show if never applied OR application was rejected -->
                                                <button class="btn btn-success btn-sm apply-btn"
                                                    data-job-id="{{ $jobDetail->id }}"
                                                    data-title="{{ $jobDetail->title }}"
                                                    data-company="{{ $retrievedAddressCompany->first()->company_name ?? 'Unknown Company' }}"
                                                    data-location="{{ $jobDetail->location }}"
                                                    data-bs-toggle="modal" data-bs-target="#applyJobModal">
                                                    <i class="bi bi-send-check"></i>
                                                    @if ($applicationRecord && $applicationRecord->status === 'rejected')
                                                        Re-apply Job
                                                    @else
                                                        Apply Job
                                                    @endif
                                                </button>

                                                @if ($applicationRecord && $applicationRecord->status === 'rejected')
                                                    <!-- Show rejection notice -->
                                                    <div class="mt-2">
                                                        <small class="text-danger">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            Your previous application was rejected. You can apply again.
                                                        </small>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif


                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="modal fade" id="cancelApplicationModal" tabindex="-1"
                    aria-labelledby="cancelApplicationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('jobs.cancel.delete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="job_id" id="cancelJobId">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelApplicationModalLabel">
                                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>Cancel Application
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Are you sure you want to cancel your application for this job?</p>
                                    <p class="text-muted mb-0"><small>This action cannot be undone.</small></p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Close
                                    </button>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-1"></i>Yes, Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Apply Job Modal -->
                <div class="modal fade" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <form action="{{ route('jobs.apply.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <!-- FIXED: Changed name to match what's expected -->
                                <input type="hidden" name="job_id" id="apply-job-id-input">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="applyJobModalLabel">
                                        <i class="fas fa-paper-plane me-2"></i>Apply for Position
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- Job Info -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="p-3 bg-light rounded">
                                                <h6 class="fw-bold mb-2" id="apply-job-title">Job Title</h6>
                                                <p class="mb-1 text-muted" id="apply-company-name">Company Name</p>
                                                <p class="mb-0 text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    <span id="apply-job-location">Location</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Phone Number *</label>
                                                <input type="tel" class="form-control" name="phone_number"
                                                    placeholder="+63 912 345 6789" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Resume -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Resume/CV *</label>
                                        <input type="file" class="form-control" name="resume"
                                            accept=".pdf,.doc,.docx" required>
                                        <div class="form-text">Accepted formats: PDF, DOC, DOCX (Max 5MB)</div>
                                    </div>

                                    <!-- TESDA Cert -->
                                    <div class="mb-3">
                                        <label class="form-label">Upload TESDA Certificate (PDF, DOC)</label>
                                        <input type="file" name="tesda_certificate" class="form-control"
                                            accept=".pdf,.doc,.docx"
                                            @if (!$tesdaCertification || $tesdaCertification->status != 'approved') disabled @endif>

                                        @if ($tesdaCertification && $tesdaCertification->status == 'pending')
                                            <p class="text-warning mt-2">Your TESDA Certificate is under review.</p>
                                        @elseif (!$tesdaCertification || $tesdaCertification->status != 'approved')
                                            <p class="text-danger mt-2">Please upload your TESDA Certificate before
                                                applying.</p>
                                        @endif
                                    </div>

                                    <!-- Cover Letter -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Cover Letter</label>
                                        <textarea class="form-control" name="cover_letter" rows="4"
                                            placeholder="Tell us why you're interested in this position..."></textarea>
                                    </div>

                                    <!-- Additional Info -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Additional Information</label>
                                        <textarea class="form-control" name="additional_info" rows="3"
                                            placeholder="Any additional information you'd like to share..."></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- FIXED JavaScript -->
                <script>
                    const applyJobModal = document.getElementById('applyJobModal');
                    if (applyJobModal) {
                        applyJobModal.addEventListener('show.bs.modal', function(event) {
                            const button = event.relatedTarget;
                            const jobId = button.getAttribute('data-job-id');
                            const jobTitle = button.getAttribute('data-title');
                            const companyName = button.getAttribute('data-company');
                            const jobLocation = button.getAttribute('data-location');

                            // Update modal content
                            document.getElementById('apply-job-title').textContent = jobTitle || 'Job Title';
                            document.getElementById('apply-company-name').textContent = companyName || 'Company';
                            document.getElementById('apply-job-location').textContent = jobLocation || 'Location';
                            document.getElementById('apply-job-id-input').value = jobId;

                            // Update modal title
                            document.getElementById('applyJobModalLabel').innerHTML =
                                `<i class="fas fa-paper-plane me-2"></i>Apply for ${jobTitle || 'Position'}`;
                        });
                    }

                    // Handle Cancel Application Modal
                    const cancelModal = document.getElementById("cancelApplicationModal");
                    cancelModal.addEventListener("show.bs.modal", function(event) {
                        let button = event.relatedTarget;
                        let jobId = button.getAttribute("data-job-id");
                        document.getElementById("cancelJobId").value = jobId;
                    });
                </script>




                <!-- View Details Modal -->
                <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewDetailsModalLabel">Job Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4 id="modalJobTitle"></h4>
                                <p><strong>Company:</strong> <span id="modalCompanyName"></span></p>
                                <p><strong>Industry:</strong> <span id="modalIndustry"></span></p>
                                <p><strong>Location:</strong> <span id="modalLocation"></span></p>
                                <p><strong>Description:</strong></p>
                                <p id="modalDescription"></p>
                                <p><strong>Salary:</strong> ₱<span id="modalSalary"></span> Monthly</p>
                                <p><strong>Benefits:</strong> <span id="modalBenefits"></span></p>
                                <p><strong>Experience Level:</strong> <span id="modalExperienceLevel"></span></p>
                                <p><strong>TESDA Certification:</strong> <span id="modalTESDACertification"></span>
                                </p>
                                <p><strong>Other Certifications:</strong> <span
                                        id="modalNoneCertificationsQualification"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
        </div>





        <!-- No Results Message -->
        <div class="no-results hidden" id="noResults">
            <i class="bi bi-search"></i>
            <h3>No employers found</h3>
            <p>Try adjusting your filters or search terms</p>
        </div>
        </section>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Message Modal -->
    <div class="modal-overlay" id="messageModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Message Details</h5>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Message content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button class="btn-reply" onclick="replyToMessage()">Reply</button>
            </div>
        </div>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.view-details-btn');

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('modalJobTitle').textContent = btn.dataset.title;
                    document.getElementById('modalCompanyName').textContent = btn.dataset.company;
                    document.getElementById('modalIndustry').textContent = btn.dataset.industry;
                    document.getElementById('modalLocation').textContent = btn.dataset.location;
                    document.getElementById('modalDescription').textContent = btn.dataset
                        .description;
                    document.getElementById('modalSalary').textContent = btn.dataset.salary;
                    document.getElementById('modalBenefits').textContent = btn.dataset.benefits;
                    document.getElementById('modalExperienceLevel').textContent = btn.dataset
                        .experience;
                    document.getElementById('modalTESDACertification').textContent = btn.dataset
                        .tesda;
                    document.getElementById('modalNoneCertificationsQualification').textContent =
                        btn.dataset.none;

                });
            });
        });
    </script>


    <!-- Messaging and Notification JavaScript -->
    <script>
        // Sample message data
        const messagesData = {
            1: {
                sender: "Sarah Johnson",
                company: "TechCorp Solutions",
                time: "2 min ago",
                subject: "Application Status Update",
                content: "Dear John,\n\nThank you for your application for the Senior Developer position at TechCorp Solutions. We have reviewed your application and are impressed with your qualifications.\n\nWe would like to schedule a technical interview with you next week. Please let us know your availability for the following time slots:\n\n- Monday, 2:00 PM - 4:00 PM\n- Tuesday, 10:00 AM - 12:00 PM\n- Wednesday, 3:00 PM - 5:00 PM\n\nPlease reply with your preferred time slot, and we'll send you the meeting details.\n\nBest regards,\nSarah Johnson\nHR Manager, TechCorp Solutions"
            },
            2: {
                sender: "Mike Chen",
                company: "GreenEnergy Innovations",
                time: "1 hour ago",
                subject: "Interview Invitation",
                content: "Hello John,\n\nWe are excited to inform you that you have been selected for the next round of interviews for the Environmental Engineer position at GreenEnergy Innovations.\n\nThe interview will consist of:\n1. Technical discussion about renewable energy systems\n2. Project portfolio review\n3. Team culture fit assessment\n\nThe interview is scheduled for 90 minutes and will be conducted via video call. We'll send you the meeting link 24 hours before the interview.\n\nPlease confirm your attendance and let us know if you have any questions.\n\nLooking forward to speaking with you!\n\nBest regards,\nMike Chen\nEngineering Manager"
            },
            3: {
                sender: "Lisa Wang",
                company: "FinanceFirst Bank",
                time: "3 hours ago",
                subject: "Application Received",
                content: "Dear John,\n\nThank you for your interest in the Financial Analyst position at FinanceFirst Bank. We have successfully received your application.\n\nOur hiring team will review your application over the next 5-7 business days. If your qualifications match our requirements, we will contact you to schedule an initial phone screening.\n\nIn the meantime, feel free to explore our company culture and values on our website. We believe in fostering an inclusive and innovative work environment.\n\nThank you for considering FinanceFirst Bank as your next career opportunity.\n\nBest regards,\nLisa Wang\nTalent Acquisition Specialist"
            }
        };

        // Dropdown functionality
        function toggleDropdown(dropdownId) {
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu.id !== dropdownId) {
                    menu.classList.remove('show');
                }
            });

            // Toggle the clicked dropdown
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('show');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.nav-dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });



        // Show message modal
        function showMessageModal(messageId) {
            const message = messagesData[messageId];
            if (!message) return;

            document.getElementById('modalTitle').textContent = message.subject;
            document.getElementById('modalBody').innerHTML = `
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #f0f0f0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <strong style="color: #333;">${message.sender}</strong>
                        <span style="color: #888; font-size: 12px;">${message.time}</span>
                    </div>
                    <div style="color: #667eea; font-size: 14px; margin-bottom: 4px;">${message.company}</div>
                </div>
                <div style="white-space: pre-line; line-height: 1.6; color: #333;">${message.content}</div>
            `;

            document.getElementById('messageModal').classList.add('show');

            // Mark message as read
            const messageItem = document.querySelector(`[data-id="${messageId}"]`);
            if (messageItem && messageItem.classList.contains('unread')) {
                messageItem.classList.remove('unread');
                updateMessageBadge();
            }
        }

        // Close modal
        function closeModal() {
            document.getElementById('messageModal').classList.remove('show');
        }

        // Reply to message
        function replyToMessage() {
            showToast('Reply feature will be available soon!', 'info');
            closeModal();
        }

        // Update message badge count
        function updateMessageBadge() {
            const unreadCount = document.querySelectorAll('#messagesDropdown .message-item.unread').length;
            const badge = document.getElementById('messagesBadge');
            badge.textContent = unreadCount;
            if (unreadCount === 0) {
                badge.style.display = 'none';
            } else {
                badge.style.display = 'flex';
            }
        }

        // Toast notification system
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = 'toast';

            let borderColor = '#667eea';
            if (type === 'success') borderColor = '#22c55e';
            if (type === 'warning') borderColor = '#fbbf24';
            if (type === 'error') borderColor = '#ef4444';

            toast.style.borderLeftColor = borderColor;

            toast.innerHTML = `
                <div class="toast-header">
                    <div class="toast-title">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                    <button class="toast-close" onclick="this.parentElement.parentElement.remove()">&times;</button>
                </div>
                <div class="toast-body">${message}</div>
            `;

            document.getElementById('toastContainer').appendChild(toast);

            // Show toast
            setTimeout(() => toast.classList.add('show'), 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }



        // Close modal when clicking overlay
        document.getElementById('messageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    </script>

    <!-- Filter JavaScript -->
    <script>
        // Filter state
        let activeFilters = {
            search: '',
            industry: '',
            location: '',
            chips: []
        };

        // Initialize filters
        document.addEventListener('DOMContentLoaded', function() {
            // Search input listeners
            const searchFilter = document.getElementById('searchFilter');
            const navSearch = document.getElementById('navSearch');
            const mobileNavSearch = document.getElementById('mobileNavSearch');

            searchFilter.addEventListener('input', applyFilters);
            navSearch.addEventListener('input', function() {
                searchFilter.value = this.value;
                applyFilters();
            });
            mobileNavSearch.addEventListener('input', function() {
                searchFilter.value = this.value;
                navSearch.value = this.value;
                applyFilters();
            });

            // Dropdown listeners
            document.getElementById('industryFilter').addEventListener('change', applyFilters);
            document.getElementById('locationFilter').addEventListener('change', applyFilters);

            // Initial count
            updateResultsCount();
        });

        // Apply all filters
        function applyFilters() {
            const searchValue = document.getElementById('searchFilter').value.toLowerCase();
            const industryValue = document.getElementById('industryFilter').value;
            const locationValue = document.getElementById('locationFilter').value;

            const cards = document.querySelectorAll('.employer-card');
            let visibleCount = 0;

            cards.forEach(card => {
                let isVisible = true;

                // Search filter
                if (searchValue) {
                    const name = card.dataset.name.toLowerCase();
                    const industry = card.dataset.industry.toLowerCase();
                    const description = card.querySelector('.company-description').textContent.toLowerCase();

                    if (!name.includes(searchValue) &&
                        !industry.includes(searchValue) &&
                        !description.includes(searchValue)) {
                        isVisible = false;
                    }
                }

                // Industry filter
                if (industryValue && card.dataset.industry !== industryValue) {
                    isVisible = false;
                }

                // Location filter
                if (locationValue && !card.dataset.location.includes(locationValue)) {
                    isVisible = false;
                }

                // Chip filters
                activeFilters.chips.forEach(chip => {
                    if (chip === 'hiring' && card.dataset.hiring !== 'true') {
                        isVisible = false;
                    }
                    if (chip === 'remote' && card.dataset.remote !== 'true') {
                        isVisible = false;
                    }
                    if (chip === 'featured' && card.dataset.featured !== 'true') {
                        isVisible = false;
                    }
                    if (chip === 'startup' && card.dataset.startup !== 'true') {
                        isVisible = false;
                    }
                });

                // Show/hide card
                if (isVisible) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            updateResultsCount(visibleCount);
            toggleNoResults(visibleCount === 0);
        }

        // Toggle filter chip
        function toggleChip(chipElement, filterType) {
            chipElement.classList.toggle('active');

            if (chipElement.classList.contains('active')) {
                if (!activeFilters.chips.includes(filterType)) {
                    activeFilters.chips.push(filterType);
                }
            } else {
                activeFilters.chips = activeFilters.chips.filter(chip => chip !== filterType);
            }

            applyFilters();
        }

        // Clear all filters
        function clearAllFilters() {
            // Clear search inputs
            document.getElementById('searchFilter').value = '';
            document.getElementById('navSearch').value = '';
            document.getElementById('mobileNavSearch').value = '';

            // Clear dropdowns
            document.getElementById('industryFilter').value = '';
            document.getElementById('locationFilter').value = '';

            // Clear chips
            document.querySelectorAll('.filter-chip').forEach(chip => {
                chip.classList.remove('active');
            });

            // Reset filter state
            activeFilters = {
                search: '',
                industry: '',
                location: '',
                chips: []
            };

            // Show all cards
            document.querySelectorAll('.employer-card').forEach(card => {
                card.classList.remove('hidden');
            });

            updateResultsCount();
            toggleNoResults(false);
        }

        // Sort employers
        function sortEmployers() {
            const sortBy = document.getElementById('sortDropdown').value;
            const grid = document.getElementById('employerGrid');
            const cards = Array.from(grid.querySelectorAll('.employer-card:not(.hidden)'));

            cards.sort((a, b) => {
                let aValue, bValue;

                switch (sortBy) {
                    case 'name':
                        aValue = a.dataset.name;
                        bValue = b.dataset.name;
                        break;
                    case 'rating':
                        aValue = parseFloat(a.dataset.rating);
                        bValue = parseFloat(b.dataset.rating);
                        return bValue - aValue; // Descending order for rating
                    case 'location':
                        aValue = a.dataset.location;
                        bValue = b.dataset.location;
                        break;
                    case 'industry':
                        aValue = a.dataset.industry;
                        bValue = b.dataset.industry;
                        break;
                    default:
                        return 0;
                }

                return aValue < bValue ? -1 : aValue > bValue ? 1 : 0;
            });

            // Re-append sorted cards
            cards.forEach(card => grid.appendChild(card));
        }

        // Update results count
        function updateResultsCount(count = null) {
            const resultsCount = document.getElementById('resultsCount');
            if (count === null) {
                count = document.querySelectorAll('.employer-card:not(.hidden)').length;
            }
            resultsCount.textContent = count;
        }

        // Toggle no results message
        function toggleNoResults(show) {
            const noResults = document.getElementById('noResults');
            const employerGrid = document.getElementById('employerGrid');

            if (show) {
                noResults.classList.remove('hidden');
                employerGrid.style.display = 'none';
            } else {
                noResults.classList.add('hidden');
                employerGrid.style.display = 'grid';
            }
        }
    </script>

    <script>
        const timeout = 10 * 60 * 1000; // 10 minutes
        const warningTime = 9 * 60 * 1000; // 1 min before logout

        let warningTimer = setTimeout(showWarning, warningTime);
        let logoutTimer = setTimeout(autoLogout, timeout);

        function resetTimers() {
            clearTimeout(warningTimer);
            clearTimeout(logoutTimer);
            warningTimer = setTimeout(showWarning, warningTime);
            logoutTimer = setTimeout(autoLogout, timeout);
        }

        function showWarning() {
            alert(
                "You will be logged out in 1 minute due to inactivity. Move your mouse or press a key to stay logged in."
            );
        }

        function autoLogout() {
            window.location.href = "{{ route('applicant.login.display') }}";
        }

        document.addEventListener('mousemove', resetTimers);
        document.addEventListener('keydown', resetTimers);
        document.addEventListener('click', resetTimers);
    </script>

</body>

</html>
