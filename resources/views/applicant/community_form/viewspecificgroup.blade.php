<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Inside Group Community</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/applicant/created_group.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/applicant/inside_community.css') }}" />



</head>

<body>
    <div class="container py-5">

        <!-- Group Banner -->
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
        <div class="group-banner">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="group-title">{{ $group->group_name }}</h1>
                    <div class="group-meta">
                        <span>👤 <strong>{{ $group->personalInfo->first_name ?? 'Unknown' }}
                                {{ $group->personalInfo->last_name ?? '' }}</strong></span>
                        <span>🔒 <span
                                class="badge {{ $group->privacy === 'public' ? 'bg-light text-dark' : 'bg-dark' }}">{{ ucfirst($group->privacy) }}</span></span>
                        <span>👥 <strong>
                                @php
                                    $totalMembers = $group->members_count + 1; // include the creator
                                @endphp
                                {{ $totalMembers }}
                                {{ $totalMembers === 1 ? 'Member' : 'Members' }}
                            </strong></span>
                    </div>
                </div>
                <div>
                    <a href="{{ route('applicant.forum.groupcommunity.display') }}"
                        class="btn btn-outline-light me-2">←
                        Back</a>
                    @php
                        // Check if current user is a member of the group
                        $isMember =
                            $group->members->contains('id', session('applicant_id')) ||
                            $group->applicant_id == session('applicant_id');
                    @endphp

                    <button class="btn btn-light text-primary" data-bs-toggle="modal" data-bs-target="#newPostModal"
                        {{ !$isMember ? 'disabled' : '' }}>
                        + New Post
                    </button>
                </div>
            </div>
        </div>

        <!-- New Post Modal -->
        <div class="modal fade" id="newPostModal" tabindex="-1" aria-labelledby="newPostModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST"
                        action="{{ route('applicant.forum.addpostgroup.store', ['groupId' => $group->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newPostModalLabel">Create New Post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Post Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Post Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image (optional)</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Group Tabs -->
        <ul class="nav nav-tabs group-tabs" id="groupTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts"
                    type="button" role="tab">Posts</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button"
                    role="tab">Members</button>
            </li>
            @if ($group->privacy === 'private')
                @if ($group->applicant_id == $applicantId)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                            type="button" role="tab">Pending Members</button>
                    </li>
                @endif
            @endif
        </ul>

        <div class="tab-content mt-3" id="groupTabContent">
            <!-- Posts Tab -->
            <div class="tab-pane fade show active" id="posts" role="tabpanel">
                @forelse($retrievePosts as $post)
                    <div class="post-card">


                        <h5 class="mb-1">{{ $post->title }}</h5>
                        <p class="text-muted mb-0">
                            Posted by {{ $post->decryptedAuthor['first_name'] ?? 'Unknown' }}
                            {{ $post->decryptedAuthor['last_name'] ?? '' }} •
                            {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                        </p>
                        <p class="mt-2">{{ $post->content }}</p>

                        @if ($post->image_path)
                            <img src="{{ Storage::url($post->image_path) }}" alt="Post Image"
                                class="img-fluid mt-2">
                        @endif
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                @php
                                    $liked = $post->likes?->where('applicant_id', session('applicant_id'))->first();
                                @endphp


                                <form method="POST"
                                    action="{{ route('applicant.forum.groupaddlike.store', ['groupId' => $group->id, 'postId' => $post->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary me-2">
                                        👍 Like ({{ $post->likes->count() ?? 0 }})
                                    </button>
                                </form>


                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse"
                                    data-bs-target="#comments-{{ $loop->iteration }}">💬 Comments
                                    ({{ $post->comments->count() }})
                                </button>
                            </div>
                            <span class="text-muted small">Last updated:
                                {{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</span>
                        </div>

                        <div class="collapse mt-3" id="comments-{{ $loop->iteration }}">
                            <div class="border-top pt-3">
                                @foreach ($post->comments as $comment)
                                    <div class="d-flex mb-3">
                                        <div class="me-3">
                                            @php
                                                $profileImage =
                                                    !empty($comment->applicant) &&
                                                    !empty($comment->applicant->work_background) &&
                                                    !empty($comment->applicant->work_background->profileimage_path) &&
                                                    file_exists(
                                                        storage_path(
                                                            'app/public/' .
                                                                $comment->applicant->work_background->profileimage_path,
                                                        ),
                                                    )
                                                        ? asset(
                                                            'storage/' .
                                                                $comment->applicant->work_background->profileimage_path,
                                                        )
                                                        : asset('img/worker-default.png'); // default image
                                            @endphp

                                            <img src="{{ $profileImage }}"
                                                alt="{{ $comment->applicant->personal_info->first_name ?? 'User' }} Profile"
                                                class="rounded-circle me-2"
                                                style="width: 40px; height: 40px; object-fit: cover;">

                                        </div>
                                        <div class="flex-grow-1 bg-light p-3 rounded shadow-sm">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <strong>{{ $comment->personal_info->first_name ?? 'Unknown' }}
                                                    {{ $comment->personal_info->last_name ?? '' }}</strong>
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                                            </div>
                                            <div class="text-body">
                                                {{ $comment->comment }}
                                            </div>

                                            @if ($comment->applicant_id == session('applicant_id'))
                                                <form
                                                    action="{{ route('applicant.forum.groupcomments.delete', ['groupId' => $group->id, 'commentId' => $comment->id]) }}"
                                                    method="POST" class="mt-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                                                </form>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach







                                <form
                                    action="{{ route('applicant.forum.groupcomments.store', ['groupId' => $group->id]) }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="per_group_community_post_id"
                                        value="{{ $post->id }}">

                                    <div class="input-group">
                                        <input type="text" name="comment" class="form-control"
                                            placeholder="Add a comment..." required />
                                        <button type="submit" class="btn btn-primary">Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">No posts yet in this group.</div>
                @endforelse
            </div>



            <!-- Members Tab -->
            <div class="tab-pane fade" id="members" role="tabpanel">
                <div class="member-item d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>{{ $group->personalInfo->first_name ?? 'Unknown' }}
                            {{ $group->personalInfo->last_name ?? '' }}</strong>
                        <span class="text-muted ms-1">(Group Creator)</span>
                        @if ($applicantId == $group->applicant_id)
                            <span class="badge bg-success ms-2">You</span>
                        @endif
                    </div>
                </div>

                @foreach ($members as $member)
                    <div class="member-item d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <strong>
                                {{ $member->id == session('applicant_id') ? 'You' : $member->personal_info->first_name ?? 'Unknown' }}
                                {{ $member->id != session('applicant_id') ? $member->personal_info->last_name ?? '' : '' }}
                            </strong>
                            <span class="text-muted ms-1">
                                ({{ $member->id == $group->applicant_id ? 'Creator' : 'Member' }})
                            </span>
                        </div>

                        @if ($group->applicant_id == session('applicant_id') && $member->id != session('applicant_id'))
                            <form
                                action="{{ route('group.kickMember', ['groupId' => $group->id, 'memberId' => $member->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to remove this member?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-person-dash"></i> Kick
                                </button>
                            </form>
                        @endif

                    </div>
                @endforeach
            </div>


            <!-- 🕒 Pending Members Tab -->
            @if ($group->applicant_id == $applicantId)
                <div class="tab-pane fade" id="pending" role="tabpanel">
                    @if ($retrievedJoinRequests->isEmpty())
                        <div class="alert alert-secondary text-center">No pending member requests.</div>
                    @else
                        @foreach ($retrievedJoinRequests as $joinRequest)
                            <div
                                class="d-flex justify-content-between align-items-center border p-3 rounded mb-2 member-item">
                                <div>
                                    <strong>
                                        {{ $joinRequest->personal_info->first_name ?? 'Unknown' }}
                                        {{ $joinRequest->personal_info->last_name ?? '' }}
                                    </strong>
                                    <p class="text-muted mb-0">Requested to join
                                        {{ \Carbon\Carbon::parse($joinRequest->pivot->created_at)->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="d-flex gap-2">
                                    <!-- ✅ Accept -->
                                    <form
                                        action="{{ route('applicant.forum.groupmembers.accept', ['groupId' => $group->id, 'applicantId' => $joinRequest->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Accept
                                        </button>
                                    </form>

                                    <!-- ❌ Reject -->
                                    <form
                                        action="{{ route('applicant.forum.groupmembers.reject', ['groupId' => $group->id, 'applicantId' => $joinRequest->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
