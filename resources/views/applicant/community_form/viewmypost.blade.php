<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>My Forum Posts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{{ asset('css/applicant/forum.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/applicant/created_group.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>
    <div class="container">
        <h2 class="forum-title">My Forum Posts</h2>
        <!-- return to forum -->
        <div class = "viewmypost">
            <a href="{{ route('applicant.forum.display') }}" class="btn btn-primary">Return to forum</a>
        </div>

        <!-- Filter by Topic (if you want to filter your own posts by topic) -->
        <div class="mb-3">
            <label for="topicFilter" class="form-label">Filter by Topic</label>
            <select id="topicFilter" class="form-select" aria-label="Filter posts by topic">
                <option value="">All Topics</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>

        @inject('str', 'Illuminate\Support\Str')
        <div id="postsContainer">
            @forelse ($posts as $singlePost)
                <div class="post-card" data-topic="{{ $singlePost->category }}">
                    <div class="post-header">
                        <strong>
                            @if (!empty($singlePost->workBackground->profileimage_path))
                                <img src="{{ asset('storage/' . $singlePost->workBackground->profileimage_path) }}"
                                    alt="Profile Image"
                                    style="width:40px; height:40px; border-radius:50%; object-fit:cover; vertical-align:middle; margin-right:8px;">
                            @endif
                            {{ $singlePost->personalInfo->first_name ?? 'Unknown' }}
                            {{ $singlePost->personalInfo->last_name ?? '' }}
                        </strong>
                        <div class="post-job">{{ $singlePost->workBackground->position ?? 'No Position' }}</div>
                        <div class="post-time">{{ $singlePost->created_at->diffForHumans() }}</div>
                    </div>

                    <div class="post-body">
                        <div class="post-title">{{ $singlePost->title }}</div>
                        <div class="post-content">{{ $singlePost->content }}</div>
                        <div class="text-end">
                            <span class="me-1 text-muted">Topic:</span>
                            <span class="badge rounded-pill bg-success">{{ $singlePost->category }}</span>
                        </div>
                        <div class="post-media">
                            @if ($singlePost->image_path)
                                @if ($str::endsWith($singlePost->image_path, ['.jpg', '.jpeg', '.png']))
                                    <img src="{{ asset('storage/' . $singlePost->image_path) }}" alt="Post Media"
                                        style="width: 100%; height: 80%;" />
                                @elseif ($str::endsWith($singlePost->image_path, ['.mp4', '.mov', '.avi']))
                                    <video controls width="100%">
                                        <source src="{{ asset('storage/' . $singlePost->image_path) }}"
                                            type="video/mp4" />
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Post actions -->
                    @php
                        $applicantId = session('applicant_id');
                        $hasLiked = $singlePost->likes->where('applicant_id', $applicantId)->isNotEmpty();
                    @endphp

                    <div class="post-actions">
                        <form action="{{ route('applicant.forum.likes.store', $singlePost->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-like" aria-label="Like post">
                                👍 <span style="{{ $hasLiked ? 'font-weight: bold;' : '' }}">Likes:</span>
                                {{ $singlePost->likes->count() }}
                            </button>
                        </form>
                    </div>

                    <!-- Comments, replies, and delete post logic as in your reference file -->
                    <!-- Comment section --->

                    <button type="button" class="toggle-comments-btn">View Comments
                        ({{ $singlePost->comments->count() }})
                    </button>

                    <div class="comments-container" style="display: none;">

                        <div class="comment-box">
                            @if (session('applicant_id'))
                                <!-- Comment form -->
                                <form method="POST" action="{{ route('applicant.forum.comments.store') }}">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $singlePost->id }}">
                                    <input type="text" class="comment-input" placeholder="Write a comment..."
                                        name="comment" maxlength="250" required spellcheck="false" inputmode="text"
                                        autocomplete="off" />
                                    <button type="submit" class="comment-submit-btn"
                                        aria-label="Add Comment">Add</button>
                                </form>
                            @else
                                <p style="color:red;">Applicant not logged in. Cannot comment.</p>
                            @endif
                        </div>

                        @if ($singlePost->comments->isNotEmpty())
                            <ul class="comment-list mt-2">
                                @foreach ($singlePost->comments as $comment)
                                    <li style="margin-bottom: 1rem;">

                                        <strong>
                                            {{ $comment->applicant->personal_info->first_name ?? 'Unknown' }}
                                            {{ $comment->applicant->personal_info->last_name ?? '' }}:
                                        </strong>
                                        {{ $comment->comment }}
                                        <br>
                                        <small><em>{{ $comment->created_at->diffForHumans() }}</em></small>

                                        <!-- Reply button -->
                                        @if (session('applicant_id'))
                                            <button type="button" class="reply-btn"
                                                data-comment-id="{{ $comment->id }}"
                                                style="margin-left: 1rem; font-size: 0.9rem;">Reply</button>
                                        @endif

                                        <!-- Delete button (only for owner) -->
                                        @if (session('applicant_id') == $comment->applicant_id)
                                            <form method="POST"
                                                action="{{ route('applicant.forum.comments.delete', $comment->id) }}"
                                                style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="margin-left: 1rem; font-size: 0.9rem; color: red;">Delete</button>
                                            </form>
                                        @endif

                                        <!-- Reply form (hidden by default) -->
                                        <form method="POST"
                                            action="{{ route('applicant.forum.replycomments.store') }}"
                                            class="reply-form" data-parent-id="{{ $comment->id }}"
                                            style="display:none; margin-top: 0.5rem;">
                                            @csrf
                                            <input type="hidden" name="post_id" value="{{ $singlePost->id }}">
                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                            <input type="text" name="reply_comment" class="reply-input"
                                                placeholder="Write a reply..." maxlength="250" required
                                                spellcheck="false" inputmode="text" autocomplete="off"
                                                style="width: 80%;" />
                                            <button type="submit" style="font-size: 0.9rem;">Reply</button>
                                        </form>

                                        <!-- Show replies nested -->
                                        @if ($comment->replies && $comment->replies->isNotEmpty())
                                            <ul class="reply-list" style="margin-left: 2rem; margin-top: 0.5rem;">
                                                @foreach ($comment->replies as $reply)
                                                    <li>
                                                        <strong>
                                                            {{ $reply->applicant->personal_info->first_name ?? 'Unknown' }}
                                                            {{ $reply->applicant->personal_info->last_name ?? '' }}:
                                                        </strong>
                                                        {{ $reply->reply }}
                                                        <br>
                                                        <small><em>{{ $reply->created_at->diffForHumans() }}</em></small>

                                                        {{-- Delete reply button (only for the owner) --}}
                                                        @if (session('applicant_id') == $reply->applicant_id)
                                                            <form method="POST"
                                                                action="{{ route('applicant.forum.replycomments.delete', $reply->id) }}"
                                                                style="display:inline;"
                                                                onsubmit="return confirm('Are you sure you want to delete this reply?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    style="margin-left: 1rem; font-size: 0.9rem; color: red; background: none; border: none; cursor: pointer;">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif


                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No comments yet.</p>
                        @endif
                    </div>

                    <!-- Delete post button -->
                    @if ($applicantId && $applicantId == $singlePost->applicant_id)
                        <form action="{{ route('applicant.forum.delete', $singlePost->id) }}" method="POST"
                            class="mt-2 text-end">
                            @csrf
                            @method('DELETE')

                            <!--- for edit button -->
                            <div class = "viewmypost">
                                <a href="{{ route('applicant.forum.editpost.display', $singlePost->id) }}"
                                    class="btn btn-warning">Edit</a>

                            </div><br>

                            <!--- for delete button -->
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this post?')">
                                🗑️ Delete Post
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="alert alert-info mt-4">You haven't posted anything yet.</div>
            @endforelse
        </div>
    </div>

    <script>
        // Toggle comment section
        document.querySelectorAll('.toggle-comments-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Assuming comments container is the next sibling element
                const commentsContainer = button.nextElementSibling;

                if (!commentsContainer) return;

                if (commentsContainer.style.display === 'none' || commentsContainer.style.display === '') {
                    commentsContainer.style.display = 'block';
                    button.textContent = 'Hide Comments';
                } else {
                    commentsContainer.style.display = 'none';
                    button.textContent = 'View Comments';
                }
            });
        });

        // Show/hide reply forms
        document.querySelectorAll('.reply-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.dataset.commentId;
                const replyForm = document.querySelector(`form.reply-form[data-parent-id="${commentId}"]`);
                if (replyForm.style.display === 'none' || replyForm.style.display === '') {
                    replyForm.style.display = 'block';
                } else {
                    replyForm.style.display = 'none';
                }
            });
        });
        // Filter posts by topic
        document.getElementById('topicFilter').addEventListener('change', function() {
            const selectedTopic = this.value;
            const posts = document.querySelectorAll('#postsContainer .post-card');
            posts.forEach(post => {
                const postTopic = post.getAttribute('data-topic');
                post.style.display = (selectedTopic === '' || postTopic === selectedTopic) ? '' : 'none';
            });
        });
    </script>
</body>

</html>
