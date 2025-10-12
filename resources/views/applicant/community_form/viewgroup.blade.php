<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Community Groups</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/viewgroup.css') }}" />
    <style></style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="forum-title">Community Groups</h2>

        {{-- Alert Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('info'))
            <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-4 text-start">
            <a href="{{ route('applicant.forum.display') }}" class="btn btn-outline-primary btn-custom">← Back to forum
                page</a>
            <a href="{{ route('applicant.forum.viewgroupcreator.display') }}" class="btn btn-success btn-custom">View My
                Created Groups</a>
        </div>
        <div id="groupsContainer">
            @foreach ($listOfGroups as $group)
                <div class="post-card mb-4">
                    <div class="post-header d-flex justify-content-between align-items-start">
                        <div>
                            <div class="group-name">{{ $group->group_name }}</div>
                            <div class="post-meta">
                                @if ($group->personalInfo)
                                    @if ($group->applicant_id == session('applicant_id'))
                                        <p>Created by: <strong>You</strong></p>
                                    @else
                                        <p>Created by: <strong>{{ $group->personalInfo->first_name }}
                                                {{ $group->personalInfo->last_name }}</strong></p>
                                    @endif
                                    <p>Applicants Joined: <strong>{{ $group->members_count }}</strong></p>
                                @else
                                    <span class="text-muted">Creator not available</span>
                                @endif
                                <span>{{ $group->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        {{-- 🔹 Only show dropdown if user is creator --}}
                        @if ($group->applicant_id == session('applicant_id'))
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                    id="groupActionsDropdown{{ $group->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="groupActionsDropdown{{ $group->id }}">
                                    <li>
                                        <a class="dropdown-item" href="">
                                            ✏️ Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this group?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit">❌ Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="post-body">
                        <div class="post-title">Description</div>
                        <div class="post-content mb-3">{{ $group->group_description }}</div>

                        @php
                            // 🔹 Membership logic per group
                            $membership = $group->members->firstWhere('id', $applicant_id);
                            $membershipStatus = $membership?->pivot->status ?? null;

                            $isMember = $membershipStatus === 'approved';
                            $isPending = $membershipStatus === 'pending';
                            $isRejected = $membershipStatus === 'rejected';
                            $isCreator = $group->applicant_id == $applicant_id;
                        @endphp

                        <div class="d-flex justify-content-between align-items-center">
                            <span
                                class="badge {{ $group->privacy === 'public' ? 'bg-success' : 'bg-info text-dark' }}">
                                {{ ucfirst($group->privacy) }}
                            </span>

                            <div class="d-flex gap-2">
                                {{-- Not a member, no pending request, not rejected, not creator --}}
                                @if (!$isMember && !$isPending && !$isRejected && !$isCreator)
                                    <form method="POST" action="{{ route('applicant.forum.joingroup.store') }}">
                                        @csrf
                                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                                        <button type="submit"
                                            class="btn btn-{{ $group->privacy === 'public' ? 'primary' : 'warning' }} btn-custom">
                                            {{ $group->privacy === 'public' ? 'Join Group' : 'Request to Join' }}
                                        </button>
                                    </form>
                                @endif

                                {{-- Pending request --}}
                                @if ($isPending)
                                    <button class="btn btn-secondary btn-custom" disabled>
                                        ⏳ Request Pending — Awaiting Creator's Approval
                                    </button>
                                @endif

                                {{-- Rejected request --}}
                                @if ($isRejected)
                                    <button class="btn btn-danger btn-custom" disabled>
                                        ❌ Your request to join this group was declined by the creator.
                                    </button>
                                @endif

                                {{-- Approved member or creator --}}
                                @if ($isMember || $isCreator)
                                    <a href="{{ route('applicant.forum.joinedgroup.display', $group->id) }}"
                                        class="btn btn-success btn-custom">View Group</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
