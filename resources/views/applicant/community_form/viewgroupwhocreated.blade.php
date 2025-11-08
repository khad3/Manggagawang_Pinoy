<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Created Groups</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/applicant/created_group.css') }}" />
</head>

<body>
    <div class="container py-5">
        <h2 class="section-title">My Created Group Communities</h2>

        @forelse($listOfGroups as $group)
            <div class="group-card mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="group-name">{{ $group->group_name }}</div>
                        <div class="created-time">Created {{ $group->created_at->diffForHumans() }}</div>
                        <div class="members-count">Applicants Joined: <strong>{{ $group->members_count }}</strong></div>
                    </div>
                    <div>
                        @if ($group->privacy === 'public')
                            <span class="badge bg-success badge-custom">Public</span>
                        @else
                            <span class="badge bg-info text-dark badge-custom">Private</span>
                        @endif
                    </div>
                </div>

                <p class="group-description mt-3">{{ $group->group_description }}</p>

                <div class="d-flex justify-content-between align-items-center flex-wrap group-meta">
                    <a href="{{ route('applicant.forum.creatorviewpage.display', $group->id) }}"
                        class="btn btn-outline-primary btn-custom">View Group</a>

                    <form action="{{ route('applicant.forum.deletegroupcreator.delete', $group->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this group?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-custom">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">You haven't created any groups yet.</div>
        @endforelse

        <div class="back-btn text-center">
            <a href="{{ route('applicant.forum.groupcommunity.display') }}" class="btn btn-primary btn-lg">← Back to
                Forum Page</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
