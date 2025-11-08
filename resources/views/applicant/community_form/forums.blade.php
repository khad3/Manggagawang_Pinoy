<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Community Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/forum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/profile.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>

    <!-- Main Forum Container -->
    <div class="forum-wrapper">
        <!-- Header Navigation -->
        <div class="forum-header">
            <div class="container">
                <div class="header-section">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="tesda-logo">
                                <div class="logo-icon">
                                    <div class="nav-logo d-flex flex-column align-items-center">
                                        <div class="logos-wrapper">
                                            <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home"
                                                style="margin-bottom: -20%;" />
                                            <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2"
                                                style="margin-bottom: -20%;" />
                                        </div>
                                        <h5 class="forum-title mt-3">Community Forum</h5>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('applicant.info.homepage.display') }}" class="back-btn">
                                <i class="bi bi-house-door-fill me-2"></i>
                                <div class="bth">Back to Homepage</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <main class="forum-main">
            <nav class="nav-section">
                <div class="nav-buttons">

                    <a href="{{ route('applicant.forum.viewpost.display') }}" class="nav-btn">

                        View My Posts
                    </a>
                    <a href="{{ route('applicant.forum.groupcommunity.display') }}" class="nav-btn">

                        View Groups

                        {{--  Friend Request Badge --}}
                        @if ($pendingJoinGroupRequests > 0)
                            <span
                                class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                                {{ $pendingJoinGroupRequests }}
                            </span>
                        @endif

                    </a>
                    <a href="{{ route('applicant.forum.group.display') }}" class="nav-btn">

                        Create Group
                    </a>
                    <a href="{{ route('applicant.forum.viewfriendlist.display') }}" class="nav-btn position-relative">

                        View Friends

                        {{-- Combined Notification Badge --}}
                        @php
                            $totalNotifications = $friendRequests + $unreadMessagesCount;
                        @endphp

                        @if ($totalNotifications > 0)
                            <span
                                class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">{{ $totalNotifications }}</span>
                        @endif




                    </a>

                </div>
            </nav>
            <div class="container">

                <!-- Content Grid -->
                <div class="content-grid">

                    <!-- Sidebar -->
                    <aside class="forum-sidebar">

                        <!-- Topic Filter -->
                        <div class="filter-section">
                            <h3 class="sidebar-title">Filter by Topic</h3>
                            <select id="topicFilter" class="form-select" aria-label="Filter posts by topic">
                                <option value="">All Topics</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Create Post Button -->
                        <div class="action-section">
                            <button class="btn-create-post" data-bs-toggle="collapse" data-bs-target="#postFormCollapse"
                                aria-expanded="false" aria-controls="postFormCollapse">

                                Create New Post
                            </button>

                        </div>

                    </aside>

                    <!-- Main Feed -->
                    <section class="forum-feed">
                        {{-- Show success message --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert"
                                id="success-alert">
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

                        <!-- Create Post Form -->
                        <div class="collapse" id="postFormCollapse">
                            <div class="post-form-card">
                                <div class="form-header">
                                    <h3>Start a Discussion</h3>
                                    <button class="btn-close" data-bs-toggle="collapse"
                                        data-bs-target="#postFormCollapse">×</button>
                                </div>

                                <form method="POST" action="{{ route('applicant.forum.store') }}"
                                    enctype="multipart/form-data" class="post-form">
                                    @csrf

                                    <div class="form-group">
                                        <input type="text" class="form-input" name="post_title"
                                            placeholder="What's your discussion about?" required maxlength="100">
                                    </div>

                                    <div class="form-group">
                                        <select class="form-select" name="post_topic" required>
                                            <option value="" disabled selected>Choose a topic</option>
                                            <option value="Automotive Servicing">Automotive Servicing</option>
                                            <option value="Bartender">Bartender</option>
                                            <option value="Barista">Barista</option>
                                            <option value="Beauty Care Specialist">Beauty Care Specialist</option>
                                            <option value="Carpenter">Carpenter</option>
                                            <option value="Cook">Cook</option>
                                            <option value="Customer Service Representative">Customer Service
                                                Representative</option>
                                            <option value="Dressmaker/Tailor">Dressmaker/Tailor</option>
                                            <option value="Electrician">Electrician</option>
                                            <option value="Food and Beverage Server">Food and Beverage Server</option>
                                            <option value="General Clerk">General Clerk</option>
                                            <option value="General Salesman">General Salesman</option>
                                            <option value="Hairdresser">Hairdresser</option>
                                            <option value="Housekeeping">Housekeeping</option>
                                            <option value="IT/Computer System Servicing">IT/Computer System Servicing
                                            </option>
                                            <option value="Machine Operator">Machine Operator</option>
                                            <option value="Mason">Mason</option>
                                            <option value="Mechanical Draftsman">Mechanical Draftsman</option>
                                            <option value="Plumber">Plumber</option>
                                            <option value="Receptionist">Receptionist</option>
                                            <option value="Secretary">Secretary</option>
                                            <option value="Tailor">Tailor</option>
                                            <option value="Tourism">Tourism</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-textarea" name="post_content" rows="4" placeholder="Share your thoughts..." required
                                            maxlength="800"></textarea>
                                    </div>

                                    <div class="file-upload-section">
                                        <label class="file-upload-label">
                                            <span class="upload-icon">📎</span>
                                            <span>Add Photo or Video</span>
                                            <input type="file" class="file-input" name="post_media"
                                                accept="image/*,video/*" onchange="previewFile(event)">
                                        </label>
                                        <!-- Preview container -->
                                        <div id="file-preview" style="margin-top: 10px;"></div>
                                    </div>

                                    <script>
                                        function previewFile(event) {
                                            const preview = document.getElementById('file-preview');
                                            preview.innerHTML = ''; // clear previous preview

                                            const file = event.target.files[0];
                                            if (!file) return;

                                            const fileType = file.type;

                                            if (fileType.startsWith('image/')) {
                                                const img = document.createElement('img');
                                                img.src = URL.createObjectURL(file);
                                                img.style.maxWidth = '200px';
                                                img.style.borderRadius = '8px';
                                                preview.appendChild(img);
                                            } else if (fileType.startsWith('video/')) {
                                                const video = document.createElement('video');
                                                video.src = URL.createObjectURL(file);
                                                video.controls = true;
                                                video.style.maxWidth = '200px';
                                                video.style.borderRadius = '8px';
                                                preview.appendChild(video);
                                            } else {
                                                preview.textContent = 'File type not supported for preview.';
                                            }
                                        }
                                    </script>

                                    <button type="submit" class="btn-submit">
                                        <span class="submit-icon">🚀</span>
                                        Publish Post
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Posts Feed -->
                        <div class="posts-feed" id="postsContainer">
                            @inject('str', 'Illuminate\Support\Str')



                            @forelse ($posts as $index => $post)
                                <article class="post-card" data-topic="{{ $post->category }}">
                                    <!-- Post Header -->
                                    <header class="post-header">
                                        <div class="author-info">
                                            <div class="author-avatar">
                                                @if (!empty($post->workBackground->profileimage_path))
                                                    <a href="">
                                                        <img src="{{ asset('storage/' . $post->workBackground->profileimage_path) }}"
                                                            alt="{{ $post->personalInfo->first_name }}'s avatar"
                                                            class="avatar-img">
                                                    </a>
                                                @else
                                                    <a href="">
                                                        <div class="avatar-placeholder">
                                                            {{ substr($post->personalInfo->first_name ?? 'U', 0, 1) }}
                                                            {{ substr($post->personalInfo->last_name ?? '', 0, 1) }}
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>


                                            <div class="author-details">
                                                <h4 class="author-name">
                                                    <a
                                                        href="{{ route('applicant.getprofile.display', ['id' => $post->applicant_id]) }}">
                                                        {{ $retrievedDecryptedPersonalInfo['personalInfo'][$index]['first_name'] ?? 'Unknown' }}
                                                        {{ $retrievedDecryptedPersonalInfo['personalInfo'][$index]['last_name'] ?? '' }}
                                                    </a>
                                                </h4>
                                                <p class="author-position">
                                                    {{ $retrievedDecryptedPersonalInfo['workBackground'][$index]['position'] ?? 'Community Member' }}
                                                </p>
                                                <time
                                                    class="post-timestamp">{{ $post->created_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </header>

                                    <!-- Post Content -->
                                    <div class="post-content">
                                        <h2 class="post-title">{{ $post->title }}</h2>
                                        <p class="post-text">{{ $post->content }}</p>

                                        <div class="post-topic">
                                            <span class="topic-badge">{{ $post->category }}</span>
                                        </div>

                                        <!-- Post Media -->
                                        @if ($post->image_path)
                                            <div class="post-media">
                                                @if ($str::endsWith($post->image_path, ['.jpg', '.jpeg', '.png', '.gif']))
                                                    <img src="{{ asset('storage/' . $post->image_path) }}"
                                                        alt="Post image" class="media-image">
                                                @elseif ($str::endsWith($post->image_path, ['.mp4', '.mov', '.avi']))
                                                    <video controls class="media-video">
                                                        <source src="{{ asset('storage/' . $post->image_path) }}"
                                                            type="video/mp4">
                                                        Your browser does not support video playback.
                                                    </video>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Post Actions -->
                                    <div class="post-actions">
                                        @php
                                            $applicantId = session('applicant_id');
                                            $hasLiked = $post->likes->where('applicant_id', $applicantId)->isNotEmpty();
                                        @endphp

                                        <form action="{{ route('applicant.forum.likes.store', $post->id) }}"
                                            method="POST" class="like-form">
                                            @csrf
                                            <button type="submit" class="btn-like {{ $hasLiked ? 'liked' : '' }}">
                                                <span class="like-icon">👍</span>
                                                <span class="like-count">{{ $post->likes->count() }}</span>
                                                <span
                                                    class="like-text">{{ $post->likes->count() === 1 ? 'Like' : 'Likes' }}</span>
                                            </button>
                                        </form>

                                        <button type="button" class="btn-comments toggle-comments-btn">
                                            <span class="comment-icon">💬</span>
                                            <span class="comment-count">{{ $post->comments->count() }}</span>
                                            <span
                                                class="comment-text">{{ $post->comments->count() === 1 ? 'Comment' : 'Comments' }}</span>
                                        </button>
                                    </div>
                                    <div class="comments-section" style="display: none;">
                                        @if (session('applicant_id'))
                                            <div class="add-comment">
                                                <form method="POST"
                                                    action="{{ route('applicant.forum.comments.store') }}"
                                                    class="comment-form">
                                                    @csrf
                                                    <input type="hidden" name="post_id"
                                                        value="{{ $post->id }}">
                                                    <div class="comment-input-group">
                                                        <input type="text" name="comment" class="comment-input"
                                                            placeholder="Share your thoughts..." maxlength="250"
                                                            required>
                                                        <button type="submit" class="btn-comment-submit">Add
                                                            comment</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        <div class="comments-list">
                                            @foreach ($post->comments as $comment)
                                                <div class="comment-item" data-comment-id="{{ $comment->id }}">
                                                    <div class="comment-header">
                                                        <strong
                                                            class="commenter-name">{{ $comment->applicant->personal_info->first_name ?? 'Unknown' }}
                                                            {{ $comment->applicant->personal_info->last_name ?? '' }}</strong>
                                                        <time>{{ $comment->created_at->diffForHumans() }}</time>
                                                    </div>
                                                    <p class="comment-text">{{ $comment->comment }}</p>

                                                    <div class="comment-actions">
                                                        @if (session('applicant_id'))
                                                            <button type="button" class="btn-reply"
                                                                data-comment-id="{{ $comment->id }}">Reply</button>
                                                        @endif

                                                        @if (session('applicant_id') == $comment->applicant_id)
                                                            <form method="POST"
                                                                action="{{ route('applicant.forum.comments.delete', $comment->id) }}"
                                                                class="delete-form"
                                                                onsubmit="return confirm('Delete this comment?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-delete"
                                                                    data-id="{{ $comment->id }}">Delete</button>
                                                            </form>
                                                        @endif
                                                    </div>

                                                    <!-- Reply Form -->
                                                    <form method="POST"
                                                        action="{{ route('applicant.forum.replycomments.store') }}"
                                                        class="reply-form" style="display:none;">
                                                        @csrf
                                                        <input type="hidden" name="comment_id"
                                                            value="{{ $comment->id }}">
                                                        <div class="reply-input-group">
                                                            <input type="text" name="reply_comment"
                                                                class="reply-input" placeholder="Write a reply..."
                                                                maxlength="250" required>
                                                            <button type="submit"
                                                                class="btn-reply-submit">Reply</button>
                                                        </div>
                                                    </form>

                                                    <div class="replies-list">
                                                        @foreach ($comment->replies as $reply)
                                                            <div class="reply-item">
                                                                <div class="reply-header">
                                                                    <strong
                                                                        class="replier-name">{{ $reply->applicant->personal_info->first_name ?? 'Unknown' }}
                                                                        {{ $reply->applicant->personal_info->last_name ?? '' }}</strong>
                                                                    <time>{{ $reply->created_at->diffForHumans() }}</time>
                                                                </div>
                                                                <p class="reply-text">{{ $reply->reply }}</p>

                                                                @if (session('applicant_id') == $reply->applicant_id)
                                                                    <form method="POST"
                                                                        action="{{ route('applicant.forum.replycomments.delete', $reply->id) }}"
                                                                        class="delete-form"
                                                                        onsubmit="return confirm('Delete this reply?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn-delete-reply"
                                                                            data-id="{{ $reply->id }}">Delete</button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>


                                    <!-- Post Owner Actions -->

                                    @php
                                        $loggedInApplicantId = session('applicant_id');
                                    @endphp

                                    @if ($loggedInApplicantId && $loggedInApplicantId == $post->applicant_id)
                                        <div class="post-owner-actions-wrapper">
                                            <!-- Toggle Button -->
                                            <button class="btn btn-sm btn-outline-secondary toggle-actions-btn"
                                                onclick="togglePostActions(this)">
                                                <i class="bi bi-gear-fill"></i> Post Options
                                            </button>

                                            <!-- Hidden Actions Initially -->
                                            <div class="post-owner-actions d-none mt-2">
                                                <a href="{{ route('applicant.forum.editpost.display', $post->id) }}"
                                                    class="btn btn-sm btn-primary me-2">
                                                    ✏️ Edit
                                                </a>
                                                <form action="{{ route('applicant.forum.delete', $post->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        🗑️ Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif


                                </article>
                            @empty
                                <div class="empty-state">
                                    <div class="empty-icon">📝</div>
                                    <h3>No posts yet</h3>
                                    <p>Be the first to start a discussion in this community!</p>
                                    <button class="btn-create-first" data-bs-toggle="collapse"
                                        data-bs-target="#postFormCollapse">
                                        Create First Post
                                    </button>
                                </div>
                            @endforelse

                        </div>

                    </section>
                </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // LIKE BUTTON
            document.addEventListener('submit', async e => {
                if (!e.target.classList.contains('like-form')) return;
                e.preventDefault();

                const form = e.target;
                const button = form.querySelector('.btn-like');
                const countSpan = form.querySelector('.like-count');
                const textSpan = form.querySelector('.like-text');

                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();
                    button.classList.toggle('liked');
                    countSpan.textContent = data.like_count ?? 0;
                    textSpan.textContent = data.like_count === 1 ? 'Like' : 'Likes';
                } catch (err) {
                    console.error(err);
                }
            });

            // ADD COMMENT
            document.addEventListener('submit', async e => {
                if (!e.target.classList.contains('comment-form')) return;
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);
                const csrfToken = form.querySelector('input[name="_token"]').value;

                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });
                    const data = await res.json();

                    if (data.success) {
                        const commentsSection = form.closest('.comments-section');
                        let commentList = commentsSection.querySelector('.comments-list');
                        if (!commentList) {
                            commentList = document.createElement('div');
                            commentList.classList.add('comments-list');
                            commentsSection.appendChild(commentList);
                        }

                        const newComment = document.createElement('div');
                        newComment.classList.add('comment-item');
                        newComment.dataset.commentId = data.comment_id;
                        newComment.innerHTML = `
                    <div class="comment-header">
                        <strong class="commenter-name">${data.first_name} ${data.last_name}</strong>
                        <time class="comment-time">${data.created_at}</time>
                    </div>
                    <p class="comment-text">${data.comment}</p>
                    <div class="comment-actions">
                        <button type="button" class="btn-reply" data-comment-id="${data.comment_id}">Reply</button>
                        <form method="POST" action="/applicant/forum/comments/delete/${data.comment_id}" class="delete-form">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </div>
                    <form method="POST" action="/applicant/forum/replycomments/store" class="reply-form" style="display:none;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="comment_id" value="${data.comment_id}">
                        <div class="reply-input-group">
                            <input type="text" name="reply_comment" class="reply-input" placeholder="Write a reply..." maxlength="250" required>
                            <button type="submit" class="btn-reply-submit">Reply</button>
                        </div>
                    </form>
                    <div class="replies-list"></div>
                `;
                        commentList.prepend(newComment);
                        form.reset();
                    }
                } catch (err) {
                    console.error(err);
                }
            });

            // TOGGLE REPLY FORM
            document.addEventListener('click', e => {
                if (e.target.classList.contains('btn-reply')) {
                    const commentItem = e.target.closest('.comment-item');
                    const replyForm = commentItem.querySelector('.reply-form');
                    if (replyForm) {
                        replyForm.style.display = replyForm.style.display === 'block' ? 'none' : 'block';
                        replyForm.querySelector('.reply-input').focus();
                    }
                }
            });

            // ADD REPLY
            document.addEventListener('submit', async e => {
                if (!e.target.classList.contains('reply-form')) return;
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });
                    const data = await res.json();

                    if (data.success) {
                        let repliesList = form.closest('.comment-item').querySelector('.replies-list');
                        if (!repliesList) {
                            repliesList = document.createElement('div');
                            repliesList.classList.add('replies-list');
                            form.closest('.comment-item').appendChild(repliesList);
                        }

                        const newReply = document.createElement('div');
                        newReply.classList.add('reply-item');
                        newReply.innerHTML = `
                    <div class="reply-header">
                        <strong class="replier-name">${data.first_name} ${data.last_name}</strong>
                        <time class="reply-time">${data.created_at}</time>
                    </div>
                    <p class="reply-text">${data.reply}</p>
                    <form method="POST" action="/applicant/forum/replycomments/delete/${data.reply_id}" class="delete-form">
                        <input type="hidden" name="_token" value="${form.querySelector('input[name="_token"]').value}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn-delete-reply">Delete</button>
                    </form>
                `;
                        repliesList.appendChild(newReply);
                        form.reset();
                    }
                } catch (err) {
                    console.error(err);
                }
            });

        });
    </script>




    <!-- toggle post actions ---->
    <script>
        function togglePostActions(button) {
            const actions = button.nextElementSibling;
            actions.classList.toggle('d-none');
        }
    </script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Topic Filter
            document.getElementById('topicFilter').addEventListener('change', function() {
                const selectedTopic = this.value;
                const posts = document.querySelectorAll('.post-card');

                posts.forEach(post => {
                    const postTopic = post.getAttribute('data-topic');
                    if (selectedTopic === '' || postTopic === selectedTopic) {
                        post.style.display = 'block';
                    } else {
                        post.style.display = 'none';
                    }
                });
            });

            // Toggle Comments
            document.querySelectorAll('.toggle-comments-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const commentsSection = this.closest('.post-card').querySelector(
                        '.comments-section');
                    const isVisible = commentsSection.style.display !== 'none';

                    commentsSection.style.display = isVisible ? 'none' : 'block';
                    this.querySelector('.comment-text').textContent = isVisible ? 'Comments' :
                        'Hide Comments';
                });
            });

            // Toggle Reply Forms
            document.querySelectorAll('.btn-reply').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    const replyForm = document.querySelector(
                        `form.reply-form[data-parent-id="${commentId}"]`);
                    const isVisible = replyForm.style.display !== 'none';

                    replyForm.style.display = isVisible ? 'none' : 'block';
                    if (!isVisible) {
                        replyForm.querySelector('.reply-input').focus();
                    }
                });
            });

            // Auto-resize textareas
            document.querySelectorAll('.form-textarea').forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            });

            // Like button visual feedback
            document.querySelectorAll('.like-form').forEach(form => {
                form.addEventListener('submit', function() {
                    const button = this.querySelector('.btn-like');
                    button.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        button.style.transform = 'scale(1)';
                    }, 150);
                });
            });

        });
    </script>
</body>

</html>
