<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Inside Group Community</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/applicant/inside_community_specific_creator.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>
    <div class="container py-5">

        <!-- Group Banner -->
        <div class="group-banner">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="group-title">{{ $group->group_name }}</h1>
                    <div class="group-meta">
                        <span>👤 <strong>{{ $group->personalInfo->first_name ?? 'Unknown' }}
                                {{ $group->personalInfo->last_name ?? '' }}</strong></span>
                        <span>🔒 <span
                                class="badge {{ $group->privacy === 'public' ? 'bg-light text-dark' : 'bg-dark' }}">{{ ucfirst($group->privacy) }}</span></span>
                        <span>👥 <strong>{{ $group->members_count }} Members</strong></span>
                    </div>
                </div>
                <div>
                    <a href="{{ route('applicant.forum.viewgroupcreator.display') }}"
                        class="btn btn-outline-light me-2">← Back</a>
                    <button class="btn btn-light text-primary" data-bs-toggle="modal" data-bs-target="#newPostModal">+
                        New Post</button>
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
                            Posted by {{ $post->personalInfo->first_name ?? 'Unknown' }}
                            {{ $post->personalInfo->last_name ?? '' }} •
                            {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                        </p>
                        <p class="mt-2">{{ $post->content }}</p>

                        @if ($post->image_path)
                            <img src="{{ Storage::url($post->image_path) }}" alt="Post Image" class="img-fluid mt-2">
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
                                    data-bs-target="#comments-{{ $loop->iteration }}">💬 Comments (2)</button>
                            </div>
                            <span class="text-muted small">Last updated:
                                {{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</span>
                        </div>

                        <div class="collapse mt-3" id="comments-{{ $loop->iteration }}">
                            <div class="border-top pt-3">
                                @foreach ($post->comments as $comment)
                                    <div class="d-flex mb-3">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($comment->personal_info->first_name ?? 'U', 0, 1)) }}
                                            </div>
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
                <div class="member-item">
                    <strong>{{ $group->personalInfo->first_name ?? 'Unknown' }}
                        {{ $group->personalInfo->last_name ?? '' }}</strong>
                    (Group Creator)
                    @if ($applicantId == $group->applicant_id)
                        (You)
                    @endif
                </div>

                @foreach ($members as $member)
                    <div class="member-item">
                        <strong>
                            {{ $member->id == session('applicant_id') ? 'You' : $member->personal_info->first_name ?? 'Unknown' }}
                            {{ $member->id != session('applicant_id') ? $member->personal_info->last_name ?? '' : '' }}
                        </strong>
                        ({{ $member->id == $group->applicant_id ? 'Creator' : 'Member' }})
                    </div>
                @endforeach
            </div>

            <!-- Pending Members Tab -->
            @if ($group->applicant_id == $applicantId)
                <div class="tab-pane fade" id="pending" role="tabpanel">
                    <div class="alert alert-secondary">Pending member approval list goes here...</div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
