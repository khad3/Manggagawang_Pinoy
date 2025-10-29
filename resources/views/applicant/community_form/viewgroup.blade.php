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
        <style>
            .group-card {
                background: #ffffff;
                border-radius: 12px;
                border: 1px solid #e5e7eb;
                padding: 1.75rem;
                margin-bottom: 1.5rem;
                transition: box-shadow 0.2s ease, border-color 0.2s ease;
            }

            .group-card:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                border-color: #d1d5db;
            }

            .group-header {
                display: flex;
                justify-content: space-between;
                align-items: start;
                margin-bottom: 1.25rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #f3f4f6;
            }

            .group-name {
                font-size: 1.4rem;
                font-weight: 600;
                color: #111827;
                margin-bottom: 0.5rem;
            }

            .creator-info {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: #6b7280;
                font-size: 0.9rem;
            }

            .creator-badge {
                background: #f3f4f6;
                padding: 0.25rem 0.75rem;
                border-radius: 6px;
                font-weight: 500;
                color: #374151;
            }

            .pending-alert {
                background: #fef3c7;
                border-left: 3px solid #f59e0b;
                padding: 0.75rem 1rem;
                border-radius: 6px;
                margin-bottom: 1.25rem;
                color: #92400e;
                font-size: 0.9rem;
                font-weight: 500;
            }

            .group-stats {
                display: flex;
                gap: 2rem;
                margin-bottom: 1.25rem;
                padding: 1rem;
                background: #f9fafb;
                border-radius: 8px;
            }

            .stat-item {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: #374151;
                font-size: 0.95rem;
            }

            .stat-value {
                font-weight: 600;
                color: #111827;
            }

            .group-description {
                margin-bottom: 1.25rem;
            }

            .description-label {
                font-size: 0.85rem;
                font-weight: 600;
                color: #6b7280;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 0.5rem;
            }

            .description-text {
                color: #4b5563;
                line-height: 1.6;
                font-size: 0.95rem;
            }

            .group-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-top: 1rem;
                border-top: 1px solid #f3f4f6;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .privacy-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.4rem 0.9rem;
                border-radius: 6px;
                font-size: 0.85rem;
                font-weight: 500;
            }

            .badge-public {
                background: #d1fae5;
                color: #065f46;
            }

            .badge-private {
                background: #fef3c7;
                color: #92400e;
            }

            .timestamp {
                color: #9ca3af;
                font-size: 0.85rem;
            }

            .btn-clean {
                padding: 0.6rem 1.25rem;
                border-radius: 8px;
                font-size: 0.9rem;
                font-weight: 500;
                border: none;
                cursor: pointer;
                transition: all 0.2s ease;
                text-decoration: none;
                display: inline-block;
            }

            .btn-primary {
                background: #3b82f6;
                color: white;
            }

            .btn-primary:hover {
                background: #2563eb;
                color: white;
            }

            .btn-warning {
                background: #f59e0b;
                color: white;
            }

            .btn-warning:hover {
                background: #d97706;
                color: white;
            }

            .btn-success {
                background: #10b981;
                color: white;
            }

            .btn-success:hover {
                background: #059669;
                color: white;
            }

            .btn-secondary {
                background: #e5e7eb;
                color: #6b7280;
                cursor: not-allowed;
            }

            .btn-danger-disabled {
                background: #fee2e2;
                color: #dc2626;
                cursor: not-allowed;
            }

            .dropdown-toggle-clean {
                background: white;
                border: 1px solid #d1d5db;
                color: #374151;
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-size: 0.9rem;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .dropdown-toggle-clean:hover {
                background: #f9fafb;
                border-color: #9ca3af;
            }

            .dropdown-menu {
                border-radius: 8px;
                border: 1px solid #e5e7eb;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .dropdown-item {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            #groupsContainer {
                max-width: 1100px;
                margin: 0 auto;
            }

            @media (max-width: 768px) {
                .group-stats {
                    flex-direction: column;
                    gap: 0.75rem;
                }

                .group-footer {
                    flex-direction: column;
                    align-items: stretch;
                }

                .btn-clean {
                    width: 100%;
                    text-align: center;
                }
            }
        </style>

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
