<!Doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/applicant/profile.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>
    <!-- Header Section -->
    <div class="header-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="tesda-logo">
                    <div class="logo-icon">
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <div>
                        <div>TESDA</div>
                        <small style="font-size: 0.8rem; opacity: 0.9">Technical Education & Skills Development</small>
                    </div>
                </div>

                <!-- @if (request()->routeIs('applicant.getprofile.friend'))
<a href="{{ route('applicant.forum.viewfriendlist.display') }}" class="back-btn">
               <i class="bi bi-arrow-left-circle-fill me-2"></i>
      Back to Friends
  </a>
@else
-->
                <a href="{{ route('applicant.forum.display') }}" class="back-btn">
                    <i class="bi bi-house-door-fill me-2"></i>
                    Back to Community Forum
                </a>
                <!--
@endif -->


            </div>
        </div>
    </div>
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
    <br>

    <!-- Main Content -->
    <div class="profile-container animate-fade-in">
        <!-- Profile Card -->
        <div class="profile-card">
            <!-- Cover Section -->
            <div class="cover-section">
                <img src="https://images.unsplash.com/photo-1493244040629-496f6d136cc3?auto=format&fit=crop&w=1350&q=80"
                    alt="Cover Photo" class="cover-image" />
                <div class="cover-overlay"></div>
                <div class="cover-pattern"></div>



                <div class="profile-photo-container" style="position: relative; width: 100px; height: 100px;">
                    <div class="profile-photo" style="position: relative; width: 100%; height: 100%;">
                        @php
                            $profileImage =
                                !empty($retrievedProfile->work_background) &&
                                !empty($retrievedProfile->work_background->profileimage_path)
                                    ? asset('storage/' . $retrievedProfile->work_background->profileimage_path)
                                    : null;
                        @endphp

                        @if ($profileImage)
                            <!-- Clickable Image -->
                            <img src="{{ $profileImage }}" alt="Profile Picture"
                                style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#viewPhotoModal" />
                        @else
                            <i class="bi bi-person-circle" style="font-size: 100px;"></i>
                        @endif

                        {{-- Online/Offline indicator --}}
                        @php
                            $isOnline = (bool) ($retrievedProfile->is_online ?? false);
                        @endphp
                        <span
                            style="
                position: absolute;
                bottom: 5px;
                right: 5px;
                display: block;
                width: 15px;
                height: 15px;
                border-radius: 50%;
                border: 2px solid white;
                background-color: {{ $isOnline ? '#4CAF50' : '#B0B0B0' }};
                z-index: 10;
            "
                            title="{{ $isOnline ? 'Online' : 'Offline' }}">
                        </span>
                    </div>
                </div>

                <!-- Modal without backdrop -->
                <div class="modal fade" id="viewPhotoModal" tabindex="-1" aria-labelledby="viewPhotoModalLabel"
                    aria-hidden="true" data-bs-backdrop="false">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                @if ($profileImage)
                                    <img src="{{ $profileImage }}" alt="Profile Picture"
                                        style="width: 100%; object-fit: contain;" />
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Profile Info -->
            <!-- Profile Info -->
            <div class="profile-info">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        @if ($retrievedDecryptedProfile['personal_info'])
                            <h1 class="profile-name">
                                {{ $retrievedDecryptedProfile['personal_info']['first_name'] ?? 'First' }}
                                {{ $retrievedDecryptedProfile['personal_info']['last_name'] ?? 'Last' }}
                            </h1>
                            <p class="profile-title">
                                {{ $retrievedDecryptedProfile['work_background']['position'] ?? 'Position' }} |
                                {{ $retrievedDecryptedProfile['work_background']['work_duration'] ?? '0' }}
                                {{ $retrievedDecryptedProfile['work_background']['work_duration_unit'] ?? 'years' }}
                            </p>
                        @endif

                        @if (isset($tesdaCertification) && $tesdaCertification->count() > 0)
                            @foreach ($tesdaCertification as $certification)
                                @if ($certification->status == 'approved')
                                    <div class="certification-badge">
                                        <i class="bi bi-patch-check-fill"></i>
                                        TESDA Certified - {{ $certification->certification_program }}
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">No TESDA Certifications available.</p>
                        @endif
                    </div>

                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        @if ($retrievedProfile->id != session('applicant_id'))
                            @if ($retrievedProfile->id !== session('applicant_id'))
                                {{-- Check if no friend request has been sent --}}
                                @if (!$retrievedProfile->alreadySent)
                                    <form method="POST"
                                        action="{{ route('applicant.forum.addfriend.store', ['id' => $retrievedProfile->id]) }}">
                                        @csrf
                                        <button class="btn btn-tesda btn-primary mt-2">Add Friend</button>
                                    </form>
                                    {{-- If friend request is pending and current user is the receiver --}}
                                @elseif (
                                    $retrievedProfile->alreadySent &&
                                        $retrievedProfile->friendRequestStatus === 'pending' &&
                                        $retrievedProfile->isReceiver)
                                    <form method="POST"
                                        action="{{ route('applicant.forum.friend.accept', ['id' => $retrievedProfile->friendRequestId]) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-success mt-2">Accept Friend Request</button>
                                    </form>
                                    {{-- If friend request is pending and current user is the sender --}}
                                @elseif ($retrievedProfile->alreadySent && $retrievedProfile->friendRequestStatus === 'pending')
                                    <form method="POST"
                                        action="{{ route('applicant.forum.friend.cancel', ['id' => $retrievedProfile->friendRequestId]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger mt-2">Cancel Friend
                                            Request</button>
                                    </form>
                                    {{-- If already friends --}}
                                @elseif ($retrievedProfile->friendRequestStatus === 'accepted')
                                    <form action="{{ route('applicant.unfriend.store', $retrievedProfile->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-success position-relative friend-btn">
                                            You are friends
                                        </button>
                                    </form>
                                @endif
                            @endif

                            @if ($retrievedProfile->friendRequestStatus === 'accepted')
                                <a href="{{ route('applicant.forum.viewfriendlist.display', ['id' => $retrievedProfile->id]) }}"
                                    class="btn btn-tesda btn-secondary-tesda"
                                    style="color: white; text-decoration: none;">
                                    <i class="bi bi-chat-dots me-1"></i>Message
                                </a>
                            @endif
                        @else
                            <button class="btn btn-tesda btn-outline-tesda" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil-square me-1"></i>Edit Profile
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Left Column -->
            <div class="left-column">
                <!-- About Card -->
                <div class="content-card animate-slide-in">
                    <div class="card-header-tesda d-flex justify-content-between align-items-center">
                        <h5 class="card-title-tesda">
                            <i class="bi bi-person-badge-fill"></i> About Me
                        </h5>
                        <!-- Toggle button -->
                        @if ($retrievedProfile->id == session('applicant_id'))
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal"
                                data-bs-target="#editAboutModal">
                                <i class="bi bi-gear-fill"></i>
                            </button>
                        @endif

                    </div>
                    <div class="card-body-tesda">
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div class="about-content">
                                <h6>Email Address</h6>
                                <p>{{ $retrievedProfile->email }}</p>
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="about-content">
                                <h6>Location</h6>
                                <p>
                                    {{ $retrievedDecryptedProfile['personal_info']['street'] ?? '' }}
                                    {{ $retrievedDecryptedProfile['personal_info']['barangay'] ?? '' }},
                                    {{ $retrievedDecryptedProfile['personal_info']['city'] ?? '' }},
                                    {{ $retrievedDecryptedProfile['personal_info']['province'] ?? '' }}
                                </p>
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="bi bi-chat-quote-fill"></i>
                            </div>
                            <div class="about-content">
                                <h6>About</h6>
                                <p>{{ $retrievedDecryptedProfile['template']['description'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Portfolio Card -->
                <div class="content-card animate-slide-in">
                    <div class="card-header-tesda d-flex justify-content-between align-items-center">
                        <h5 class="card-title-tesda">
                            <i class="bi bi-collection-fill"></i>
                            Portfolio
                        </h5>

                        @if (session('applicant_id') == $retrievedProfile->id)
                            <!-- Show upload button only if viewing own profile -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-tesda btn-primary-tesda dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-plus-circle me-1"></i>Add
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#uploadImageModal">
                                            <i class="bi bi-image me-2"></i>Upload Image</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#addYoutubeModal">
                                            <i class="bi bi-youtube me-2"></i>Add YouTube Link</a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="card-body-tesda">
                        {{-- Portfolio Images --}}
                        @foreach ($retrievedPortfolio as $portfolio)
                            <div class="portfolio-item mb-3" data-bs-toggle="modal"
                                data-bs-target="#viewSampleWorkModal{{ $portfolio->id }}">
                                <img src="{{ asset('storage/' . $portfolio->sample_work_image) }}" alt="Sample Work"
                                    class="img-fluid" />
                                <div class="portfolio-overlay">
                                    <i class="bi bi-eye-fill"></i>
                                </div>
                                <div class="portfolio-caption">
                                    <h6 class="portfolio-title">{{ $portfolio->sample_work_title }}</h6>
                                    <p class="portfolio-tech">{{ $portfolio->sample_work_description }}</p>
                                </div>
                            </div>

                            <!-- Matching Modal -->
                            <div class="modal fade" id="viewSampleWorkModal{{ $portfolio->id }}" tabindex="-1"
                                aria-labelledby="viewSampleWorkLabel{{ $portfolio->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <img src="{{ asset('storage/' . $portfolio->sample_work_image) }}"
                                                class="w-100 rounded" alt="Sample Work Enlarged" />
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <span class="text-muted">
                                                {{ $portfolio->sample_work_title }} –
                                                {{ $portfolio->sample_work_description }}
                                            </span>
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- YouTube Embeds --}}
                        @foreach ($retrievedYoutube as $youtube)
                            @php
                                $youtubeUrl = $youtube->sample_work_url ?? '';
                                $videoId = null;

                                if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $youtubeUrl, $matches)) {
                                    $videoId = $matches[1];
                                } elseif (
                                    preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $youtubeUrl, $matches)
                                ) {
                                    $videoId = $matches[1];
                                }

                                $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
                            @endphp

                            @if ($embedUrl)
                                <div class="portfolio-item mb-3">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $embedUrl }}" title="{{ $youtube->sample_work_title }}"
                                            allowfullscreen
                                            style="border-radius: var(--border-radius-lg); border: none;"></iframe>
                                    </div>
                                    <p class="mt-2 fw-semibold">{{ $youtube->sample_work_title }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>


                <!-- Certifications Card -->
                <div class="content-card animate-slide-in">
                    <div class="card-header-tesda">
                        <h5 class="card-title-tesda">
                            <i class="bi bi-award-fill"></i>
                            TESDA Certifications
                        </h5>
                        @if (session('applicant_id') == $retrievedProfile->id)
                            <button class="btn btn-sm btn-tesda btn-primary-tesda" data-bs-toggle="modal"
                                data-bs-target="#uploadCertificationModal">
                                <i class="bi bi-file-earmark-plus me-1"></i>Upload
                            </button>
                        @endif
                    </div>
                    <div class="card-body-tesda">
                        @foreach ($tesdaCertification as $cert)
                            <div
                                class="cert-item d-flex align-items-center justify-content-between mb-3 p-3 border rounded shadow-sm">

                                {{-- Icon --}}
                                <div class="cert-icon me-3">
                                    <i class="bi bi-patch-check-fill text-warning fs-3"></i>
                                </div>

                                {{-- Certification Info --}}
                                <div class="cert-content flex-grow-1">
                                    <h6>{{ $cert->certification_program }}</h6>
                                    <small>
                                        Issued •
                                        {{ \Carbon\Carbon::parse($cert->certification_date_obtained)->format('M d, Y') }}
                                    </small>
                                </div>

                                {{-- Dropdown Actions --}}
                                <div class="dropdown ms-3">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        {{-- Everyone can view the certificate --}}
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#viewCertificationModal-{{ $cert->id }}">
                                                <i class="bi bi-eye me-2"></i> View Certificate
                                            </button>
                                        </li>

                                        {{-- Only owner can delete --}}
                                        @if (session('applicant_id') == $retrievedProfile->id)
                                            <li>
                                                <form
                                                    action="{{ route('applicant.certification.delete', ['id' => $cert->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this certification?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            {{-- View Certificate Modal --}}
                            <div class="modal fade" id="viewCertificationModal-{{ $cert->id }}" tabindex="-1"
                                aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $cert->certification_program }}</h5>
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <iframe src="{{ asset('storage/' . $cert->file_path) }}" width="100%"
                                                height="500px"></iframe>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>

            <!-- Right Column - Recent Posts -->
            <div class="right-column">
                <div class="posts-section animate-fade-in">
                    <div class="posts-header">
                        <h5 class="posts-title">
                            <i class="bi bi-journal-text"></i>
                            Recent Posts
                        </h5>
                        @if (session('applicant_id') == $retrievedProfile->id)
                            <button class="add-post-btn" data-bs-toggle="modal" data-bs-target="#addPostModal">
                                <i class="bi bi-plus-circle"></i>
                                Add Post
                            </button>
                        @endif
                    </div>

                    <div class="posts-body">
                        <!-- Post Item -->
                        <div class="posts-body">
                            <!-- Post Item -->

                            @foreach ($retrievedPosts as $post)
                                <!-- Edit Post Modal -->
                                <!-- Edit Post Modal -->

                                <div class="modal fade" id="editPostModal-{{ $post->id }}" tabindex="-1"
                                    aria-hidden="true" data-bs-backdrop="false">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form
                                                action="{{ route('applicant.applicantposts.update', ['id' => $post->id]) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Post</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Post Content -->
                                                    <div class="mb-3">
                                                        <label for="content-{{ $post->id }}"
                                                            class="form-label">Post
                                                            Content</label>
                                                        <textarea name="content" id="content-{{ $post->id }}" class="form-control" rows="4">{{ $post->content }}</textarea>
                                                    </div>

                                                    <!-- Current Image Preview -->
                                                    @if ($post->image_path)
                                                        <div class="mb-3">
                                                            <label class="form-label">Current Image</label>
                                                            <div>
                                                                <img src="{{ asset('storage/' . $post->image_path) }}"
                                                                    alt="Current Image" class="img-fluid rounded mb-2"
                                                                    style="max-height: 250px; object-fit: cover;">
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Upload New Image -->
                                                    <div class="mb-3">
                                                        <label for="image-{{ $post->id }}"
                                                            class="form-label">Change
                                                            Image</label>
                                                        <input type="file" name="image"
                                                            id="image-{{ $post->id }}" class="form-control">
                                                        <small class="text-muted">Leave blank if you don't want to
                                                            change
                                                            the image.</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save
                                                        Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Post Modal -->
                                <div class="modal fade" id="deletePostModal-{{ $post->id }}" tabindex="-1"
                                    aria-hidden="true" data-bs-backdrop="false">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form
                                                action="{{ route('applicant.applicantposts.delete', ['id' => $post->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-danger">Delete Post</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this post? This action cannot be
                                                    undone.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="post-item mb-4">
                                    <div class="post-header d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center">
                                            <div class="post-avatar me-2">
                                                @if (!empty($post->workBackground) && !empty($post->workBackground->profileimage_path))
                                                    <img src="{{ asset('storage/' . $post->workBackground->profileimage_path) }}"
                                                        alt="User Avatar" class="rounded-circle"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($post->personalInfo->first_name ?? 'U', 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="post-author fw-bold">
                                                    {{ $post->retrievedDecryptedProfile['personal_info']['first_name'] ?? 'Unknown' }}
                                                    {{ $post->retrievedDecryptedProfile['personal_info']['last_name'] ?? '' }}
                                                </div>
                                                <div class="post-time text-muted small">
                                                    {{ optional($post->created_at)->diffForHumans() ?? 'N/A' }}
                                                </div>

                                            </div>
                                        </div>
                                        @if (session('applicant_id') == $post->personal_info_id)
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editPostModal-{{ $post->id }}">
                                                            <i class="bi bi-pencil me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deletePostModal-{{ $post->id }}">
                                                            <i class="bi bi-trash me-2"></i>Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="post-content mt-2">
                                        {{ $post->content }}
                                    </div>

                                    @if ($post->image_path)
                                        <div class="post-image mt-3">
                                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image"
                                                class="img-fluid rounded" />
                                        </div>
                                    @endif

                                    <div class="post-actions mt-3">
                                        <!--like button-->
                                        <form action="{{ route('applicant.likepost.store', $post->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @php
                                                $hasLiked = $post->likes
                                                    ->where('applicant_id', session('applicant_id'))
                                                    ->isNotEmpty();
                                            @endphp

                                            <button type="submit"
                                                class="action-btn like-btn me-2 {{ $hasLiked ? 'text-danger' : '' }}">
                                                <i class="bi {{ $hasLiked ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                <span class="like-count">{{ $post->likes->count() }}</span>
                                                {{ $post->likes->count() === 1 ? 'Like' : 'Likes' }}
                                            </button>
                                        </form>



                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="toggleComments(this)">
                                            <i class="bi bi-chat"></i>
                                            <span class="comment-count"></span>
                                            Comment ({{ $post->comments->count() }})
                                        </button>
                                    </div>


                                    <!-- Comments Section -->
                                    <div class="comments-section mt-3" style="display: none">
                                        <form action="{{ route('applicantaddcomments.store', $post->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="mb-2">
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <textarea class="form-control comment-input" name="comment" rows="2" placeholder="Write a comment..."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-send"></i> Comment
                                            </button>
                                        </form>

                                        <div class="comments-list mt-2">
                                            @foreach ($post->comments as $comment)
                                                <div class="comment-item p-2 mb-2 rounded bg-light position-relative">

                                                    {{-- Show own comment --}}
                                                    @if ($comment->applicant_id == session('applicant_id'))
                                                        <strong>Me:</strong> {{ $comment->comment }}

                                                        {{-- Inline delete button --}}
                                                        <form
                                                            action="{{ route('applicant.comment.delete', $comment->id) }}"
                                                            method="POST"
                                                            class="d-inline-block position-absolute top-0 end-0 mt-1 me-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-link text-muted p-0"
                                                                style="font-size: 0.9rem;"
                                                                onmouseover="this.style.color='red'"
                                                                onmouseout="this.style.color='gray'">
                                                                <i class="bi bi-x-circle"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <strong>
                                                            {{ $comment->decryptedPersonalInfo['first_name'] ?? 'Unknown' }}
                                                            {{ $comment->decryptedPersonalInfo['last_name'] ?? 'Anonymous' }}:
                                                        </strong>
                                                        {{ $comment->comment }}
                                                    @endif

                                                    {{-- Reply button --}}
                                                    <div class="mt-1">
                                                        <button class="btn btn-sm btn-link text-primary p-0"
                                                            onclick="toggleReplyForm({{ $comment->id }})">
                                                            Reply
                                                        </button>
                                                    </div>

                                                    {{-- Hidden reply form --}}
                                                    <div id="reply-form-{{ $comment->id }}" class="mt-2 d-none">
                                                        <form action="" method="POST">
                                                            @csrf
                                                            <textarea name="reply" class="form-control mb-2" rows="2" placeholder="Write a reply..."></textarea>
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="bi bi-send"></i> Reply
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                        <script>
                                            function toggleReplyForm(commentId) {
                                                let form = document.getElementById('reply-form-' + commentId);
                                                form.classList.toggle('d-none');
                                            }
                                        </script>


                                    </div>
                                </div>
                            @endforeach

                        </div>





                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals (keeping your existing modal structure) -->
    <!-- Upload Image Modal -->
    <div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('applicant.portfolio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="personal_info_id" value="{{ $retrievedProfile->personal_info->id }}">
                <input type="hidden" name="work_experience_id"
                    value="{{ $retrievedProfile->work_background->id }}">
                <input type="hidden" name="template_final_step_register_id"
                    value="{{ $retrievedProfile->template->id }}">
                <input type="hidden" name="applicant_id" value="{{ session('applicant_id') }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadImageModalLabel">
                            Upload Portfolio Work
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Select Image</label>
                            <input type="file" name="sample_work_image" class="form-control" accept="image/*"
                                required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project Title</label>
                            <input type="text" name="sample_work_title" class="form-control"
                                placeholder="Enter work title" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="sample_work_description" class="form-control" rows="3"
                                placeholder="Describe your sample work"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-tesda btn-primary-tesda">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add YouTube Modal -->
    <div class="modal fade" id="addYoutubeModal" tabindex="-1" aria-labelledby="addYoutubeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('applicant.youtubevideo.store') }}" method="POST">
                @csrf
                <input type="hidden" name="personal_info_id" value="{{ $retrievedProfile->personal_info->id }}">
                <input type="hidden" name="work_experience_id"
                    value="{{ $retrievedProfile->work_background->id }}">
                <input type="hidden" name="applicant_id" value="{{ session('applicant_id') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addYoutubeModalLabel">
                            Add YouTube Video
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">YouTube URL</label>
                            <input type="url" name="youtube_link" class="form-control"
                                placeholder="https://www.youtube.com/watch?v=..." required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Video Title</label>
                            <input type="text" name="youtube_title" class="form-control"
                                placeholder="Enter video title" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-tesda btn-primary-tesda">Add Video</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Upload Certification Modal -->
    <div class="modal fade" id="uploadCertificationModal" tabindex="-1"
        aria-labelledby="uploadCertificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadCertificationModalLabel">
                            Upload TESDA Certification
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Certificate File</label>
                            <input type="file" class="form-control" accept="application/pdf,image/*" />
                            <small class="text-muted">Accepted: PDF, JPG, PNG (Max 5MB)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Certification Program</label>
                            <select id="certificationSelect" class="form-control" name="certification_program"
                                required>
                                <option disabled selected>Select Certification Program</option>
                                <!-- Automotive & Transportation -->
                                <option value="Automotive Servicing NC I">Automotive Servicing NC I</option>
                                <option value="Automotive Servicing NC II">Automotive Servicing NC II</option>
                                <option value="Driving NC II">Driving NC II</option>
                                <option value="Motorcycle/Small Engine Servicing NC II">Motorcycle/Small Engine
                                    Servicing NC II</option>

                                <!-- Construction -->
                                <option value="Carpentry NC II">Carpentry NC II</option>
                                <option value="Masonry NC I">Masonry NC I</option>
                                <option value="Masonry NC II">Masonry NC II</option>
                                <option value="Plumbing NC II">Plumbing NC II</option>
                                <option value="">Pipefitting NC II</option>
                                <option value="Tile Setting NC II">Tile Setting NC II</option>
                                <option value="Scaffolding Works NC II">Scaffolding Works NC II</option>

                                <!-- Welding -->
                                <option value="Shielded Metal Arc Welding (SMAW) NC I">Shielded Metal Arc Welding
                                    (SMAW) NC I</option>
                                <option value="Shielded Metal Arc Welding (SMAW) NC II">Shielded Metal Arc Welding
                                    (SMAW) NC II</option>
                                <option value="Gas Metal Arc Welding (GMAW) NC II">Gas Metal Arc Welding (GMAW) NC II
                                </option>
                                <option value="Gas Tungsten Arc Welding (GTAW) NC II">Gas Tungsten Arc Welding (GTAW)
                                    NC II</option>
                                <option value="Flux-Cored Arc Welding (FCAW) NC II">Flux-Cored Arc Welding (FCAW) NC II
                                </option>

                                <!-- Electrical & Electronics -->
                                <option value="Electrical Installation & Maintenance NC II">Electrical Installation &
                                    Maintenance NC II</option>
                                <option value="Electronics Products Assembly & Servicing NC II">Electronic Products
                                    Assembly & Servicing NC II</option>
                                <option value="Computer Systems Servicing NC II">Computer Systems Servicing NC II
                                </option>

                                <!-- HVAC/R -->
                                <option value="Refrigeration and Air Conditioning Servicing NC II">Refrigeration and
                                    Air Conditioning Servicing NC II</option>

                                <!-- Agriculture -->
                                <option value="Agricultural Crops Production NC II">Agricultural Crops Production NC II
                                </option>
                                <option value="Organic Agriculture Production NC II">Organic Agriculture Production NC
                                    II</option>
                                <option value="Animal Production NC II">Animal Production NC II</option>

                                <!-- Miscellaneous -->
                                <option value="Domestic Work NC II">Domestic Work NC II</option>
                                <option value="Housekeeping NC II">Housekeeping NC II</option>
                                <option value="Dressmaking NC II">Dressmaking NC II</option>
                                <option value="Tailoring NC II">Tailoring NC II</option>
                                <option value="Food Processing NC II">Food Processing NC II</option>
                                <option value="Barista NC II">Barista NC II</option>
                                <option value="Bartending NC II">Bartending NC II</option>

                                <!-- IT / Programming -->
                                <option value="Web Development NC III">Web Development NC III</option>
                                <option value="Computer Programming NC IV">Computer Programming NC IV</option>

                                <!-- Other -->
                                <option value="Other">Other</option>
                            </select>

                            <!-- Hidden input that appears if 'Other' is selected -->
                            <div id="otherCertInput" style="display: none; margin-top: 10px;">
                                <label for="otherInput" class="form-label">Please specify</label>
                                <input type="text" name="other_certification_program" class="form-control"
                                    id="otherInput" placeholder="Enter your certification">
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const certificationSelect = document.getElementById('certificationSelect');
                                const otherCertInput = document.getElementById('otherCertInput');

                                certificationSelect.addEventListener('change', function() {
                                    if (this.value === 'Other') {
                                        otherCertInput.style.display = 'block';
                                    } else {
                                        otherCertInput.style.display = 'none';
                                    }
                                });
                            });
                        </script>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date Obtained</label>
                        <input type="date" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-tesda btn-primary-tesda">
                        Upload Certificate
                    </button>
                </div>
        </div>
        </form>
    </div>
    </div>

    <!-- View Certification Modal -->
    <div class="modal fade" id="viewCertificationModal" tabindex="-1" aria-labelledby="viewCertificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&h=600&fit=crop"
                        alt="TESDA Certificate" class="w-100 rounded" />
                </div>
                <div class="modal-footer justify-content-between">
                    <span class="text-muted">TESDA National Certificate II - Computer Systems Servicing</span>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>



    </div>

    <!-- Add Post Modal -->
    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('applicant.applicantposts.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- ✅ Add these hidden fields -->
                <input type="hidden" name="personal_info_id"
                    value="{{ $retrievedProfile->personal_info->id ?? '' }}">
                <input type="hidden" name="work_experience_id"
                    value="{{ $retrievedProfile->work_background->id ?? '' }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPostModalLabel">
                            Create New Post
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="postContent" class="form-label">What's on your mind?</label>
                            <textarea name="content" id="postContent" class="form-control" rows="4"
                                placeholder="Share your thoughts, achievements, or updates..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="postImage" class="form-label">Upload Image (optional)</label>
                            <input type="file" name="image" id="postImage" class="form-control"
                                accept="image/*" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-tesda btn-primary-tesda" data-bs-dismiss="modal"
                            onclick="createPost()">
                            Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit About Modal -->
    <div class="modal fade" id="editAboutModal" tabindex="-1" aria-labelledby="editAboutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('applicant.editprofile', ['id' => $retrievedProfile->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAboutModalLabel">Edit About Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ $retrievedProfile->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">House / Street</label>
                            <input type="text" name="house_street" class="form-control"
                                value="{{ $retrievedDecryptedProfile['personal_info']['house_street'] }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Barangay</label>
                            <input type="text" name="barangay" class="form-control"
                                value="{{ $retrievedDecryptedProfile['personal_info']['barangay'] }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control"
                                value="{{ $retrievedDecryptedProfile['personal_info']['city'] }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Province</label>
                            <input type="text" name="province" class="form-control"
                                value="{{ $retrievedDecryptedProfile['personal_info']['province'] }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">About</label>
                            <textarea name="description" rows="3" class="form-control">{{ $retrievedDecryptedProfile['template']['description'] }}</textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-tesda btn-primary-tesda">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple Interactive Functions
        function toggleLike(btn) {
            const icon = btn.querySelector("i");
            const countSpan = btn.querySelector(".like-count");
            let count = parseInt(countSpan.textContent);

            if (btn.classList.contains("liked")) {
                btn.classList.remove("liked");
                icon.classList.remove("bi-heart-fill");
                icon.classList.add("bi-heart");
                countSpan.textContent = count - 1;
            } else {
                btn.classList.add("liked");
                icon.classList.remove("bi-heart");
                icon.classList.add("bi-heart-fill");
                countSpan.textContent = count + 1;
            }
        }

        function toggleComments(btn) {
            const postItem = btn.closest(".post-item");
            const commentsSection = postItem.querySelector(".comments-section");

            if (commentsSection.style.display === "none") {
                commentsSection.style.display = "block";
                btn.classList.add("active");
            } else {
                commentsSection.style.display = "none";
                btn.classList.remove("active");
            }
        }

        function addComment(btn) {
            const inputGroup = btn.closest(".input-group");
            const input = inputGroup.querySelector(".comment-input");
            const commentsList = btn
                .closest(".comments-section")
                .querySelector(".comments-list");

            if (input.value.trim() === "") return;

            const commentHTML = `
        <div class="comment-item mt-2 p-2 rounded">
          <strong>You:</strong> ${input.value}
        </div>
      `;

            commentsList.insertAdjacentHTML("beforeend", commentHTML);
            input.value = "";

            // Update comment count
            const commentBtn = btn
                .closest(".post-item")
                .querySelector(".comment-btn .comment-count");
            const currentCount = parseInt(commentBtn.textContent);
            commentBtn.textContent = currentCount + 1;
        }

        function createPost() {
            console.log("Post created successfully!");
        }

        // Enhanced interactions on load
        document.addEventListener("DOMContentLoaded", function() {
            // Stagger animation for cards
            const cards = document.querySelectorAll(".content-card");
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Handle comment input Enter key
            document.addEventListener("keydown", function(e) {
                if (
                    e.key === "Enter" &&
                    e.target.classList.contains("comment-input")
                ) {
                    const btn = e.target
                        .closest(".input-group")
                        .querySelector(".btn-tesda");
                    addComment(btn);
                }
            });
        });
    </script>
</body>

</html>
