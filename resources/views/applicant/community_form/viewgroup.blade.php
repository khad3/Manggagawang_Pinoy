<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Community Groups</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/viewgroup.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />


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

        <div id="groupsContainer" class="mt-3">
            @foreach ($listOfGroups as $group)
                @php
                    $membership = $group->members->firstWhere('id', $applicant_id);
                    $membershipStatus = $membership?->pivot->status ?? null;
                    $isMember = $membershipStatus === 'approved';
                    $isPending = $membershipStatus === 'pending';
                    $isRejected = $membershipStatus === 'rejected';
                    $isCreator = $group->applicant_id == $applicant_id;
                @endphp

                <div class="group-card">
                    {{-- Header Section --}}
                    <div class="group-header">
                        <div>
                            <div class="group-name">{{ $group->group_name }}</div>
                            <div class="creator-info">
                                @if ($isCreator)
                                    <span>Created by</span>
                                    <span class="creator-badge">You</span>
                                @elseif ($group->personalInfo)
                                    <span>Created by</span>
                                    <strong>{{ $group->personalInfo->first_name }}
                                        {{ $group->personalInfo->last_name }}</strong>
                                @endif
                            </div>
                        </div>

                        {{-- Actions Dropdown for Creator --}}
                        @if ($isCreator)
                            <div class="dropdown">
                                <button class="dropdown-toggle-clean" type="button"
                                    id="groupActionsDropdown{{ $group->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="groupActionsDropdown{{ $group->id }}">
                                    <li><a class="dropdown-item" href="#">Edit Group</a></li>
                                    <li>
                                        <form action="#" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this group?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit">Delete
                                                Group</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- Pending Requests Alert --}}
                    @if ($isCreator && $group->pending_members_count > 0)
                        <div class="pending-alert">
                            {{ $group->pending_members_count }} pending join
                            request{{ $group->pending_members_count > 1 ? 's' : '' }}
                        </div>
                    @endif

                    {{-- Statistics --}}
                    <div class="group-stats">
                        <div class="stat-item">
                            @php
                                $totalMembers = $group->members_count + 1;
                            @endphp

                            <span>👥</span>
                            <span><span class="stat-value">{{ $totalMembers }}</span>
                                {{ $totalMembers === 1 ? 'Member' : 'Members' }}</span>

                        </div>
                        <div class="stat-item">
                            <span>{{ $group->privacy === 'public' ? '🌐' : '🔒' }}</span>
                            <span><span class="stat-value">{{ ucfirst($group->privacy) }}</span> group</span>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="group-description">
                        <div class="description-label">Description</div>
                        <div class="description-text">
                            {{ $group->group_description ?? 'No description provided.' }}
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="group-footer">
                        <div class="d-flex align-items-center gap-3">
                            <span
                                class="privacy-badge {{ $group->privacy === 'public' ? 'badge-public' : 'badge-private' }}">
                                {{ $group->privacy === 'public' ? '🌐' : '🔒' }}
                                {{ ucfirst($group->privacy) }}
                            </span>
                            <span class="timestamp">{{ $group->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="d-flex gap-2">
                            {{-- Join button logic --}}
                            @if (!$isMember && !$isPending && !$isRejected && !$isCreator)
                                <form method="POST" action="{{ route('applicant.forum.joingroup.store') }}">
                                    @csrf
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <button type="submit"
                                        class="btn-clean btn-{{ $group->privacy === 'public' ? 'primary' : 'warning' }}">
                                        {{ $group->privacy === 'public' ? 'Join Group' : 'Request to Join' }}
                                    </button>
                                </form>
                            @endif

                            @if ($isPending)
                                <button class="btn-clean btn-secondary" disabled>
                                    Request Pending
                                </button>
                            @endif

                            @if ($isRejected)
                                <button class="btn-clean btn-danger-disabled" disabled>
                                    Request Declined
                                </button>
                            @endif

                            @if ($isMember || $isCreator)
                                <a href="{{ route('applicant.forum.joinedgroup.display', $group->id) }}"
                                    class="btn-clean btn-success">
                                    View Group
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
