<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/applicant/profile.css') }}" />
    <style>

    </style>
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
                <a href="{{ route('applicant.info.homepage.display') }}" class="back-btn">
                    <i class="bi bi-house-door-fill me-2"></i>
                    Back to Homepage
                </a>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <center>{{ session('success') }}</center>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
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

                <div class="dropdown">
                    <button class="settings-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-gear"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#uploadCoverModal">
                                <i class="bi bi-upload me-2"></i>Upload Cover Photo</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#">
                                <i class="bi bi-trash me-2"></i>Delete Cover Photo</a>
                        </li>
                    </ul>
                </div>

                <div class="profile-photo-container">
                    <div class="profile-photo">
                        @if ($retrievedProfile->personal_info)
                            @if (!empty($retrievedProfile->work_background) && !empty($retrievedProfile->work_background->profileimage_path))
                                <img src="{{ asset('storage/' . $retrievedProfile->work_background->profileimage_path) }}"
                                    alt="Profile Picture" />
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                        @endif
                        <div class="online-indicator"></div>
                    </div>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="profile-info">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        @if ($retrievedProfile->personal_info)
                            <h1 class="profile-name">
                                {{ $retrievedProfile->personal_info->first_name }}
                                {{ $retrievedProfile->personal_info->last_name }}
                            </h1>
                            <p class="profile-title">
                                {{ $retrievedProfile->work_background->position }} |
                                {{ $retrievedProfile->work_background->work_duration }}
                                {{ $retrievedProfile->work_background->work_duration_unit }}
                            </p>
                        @endif

                        @foreach ($retrievedTesdaCertifacation as $certification)
                            @if ($certification->status == 'approved')
                                <div class="certification-badge">
                                    <i class="bi bi-patch-check-fill"></i>
                                    TESDA Certified - {{ $certification->certification_program }}
                                </div>
                            @endif
                        @endforeach

                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        @if ($retrievedProfile->applicant_id != session('applicant_id'))
                            <button class="btn btn-tesda btn-outline-tesda" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil-square me-1"></i>Edit Profile
                            </button>
                        @else
                            <button class="btn btn-tesda btn-primary-tesda">
                                <i class="bi bi-person-plus-fill me-1"></i>Connect
                            </button>
                            <button class="btn btn-tesda btn-secondary-tesda">
                                <i class="bi bi-chat-dots me-1"></i>Message
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
                        <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editAboutModal">
                            <i class="bi bi-gear-fill"></i>
                        </button>
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
                                    {{ $retrievedProfile->personal_info->house_street }},
                                    {{ $retrievedProfile->personal_info->barangay }},
                                    {{ $retrievedProfile->personal_info->city }},
                                    {{ $retrievedProfile->personal_info->province }}
                                </p>
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="bi bi-chat-quote-fill"></i>
                            </div>
                            <div class="about-content">
                                <h6>About</h6>
                                <p>{{ $retrievedProfile->template->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Portfolio Card -->
                <div class="content-card animate-slide-in">
                    <div class="card-header-tesda">
                        <h5 class="card-title-tesda">
                            <i class="bi bi-collection-fill"></i>
                            Portfolio
                        </h5>
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
                    </div>
                    <div class="card-body-tesda">
                        <!-- Portfolio Grid -->
                        <div class="portfolio-grid row g-3">
                            @foreach ($retrievedPortfolio as $portfolio)
                                <div class="col-sm-6 col-md-4">
                                    <div class="portfolio-card position-relative shadow-sm rounded">
                                        <img src="{{ asset('storage/' . $portfolio->sample_work_image) }}"
                                            alt="{{ $portfolio->sample_work_title }}"
                                            class="img-fluid portfolio-thumb" loading="lazy" />
                                        <div class="portfolio-overlay d-flex align-items-center justify-content-center"
                                            role="button" tabindex="0" title="View"
                                            aria-label="View portfolio item"
                                            data-image="{{ asset('storage/' . $portfolio->sample_work_image) }}"
                                            data-title="{{ $portfolio->sample_work_title }}"
                                            data-desc="{{ $portfolio->sample_work_description }}"
                                            data-bs-toggle="modal" {{-- optional: we call modal via JS but keep bootstrap attribute for accessibility --}}
                                            data-bs-target="#viewSampleWorkModal">
                                            <button type="button" class="btn view-portfolio-btn"
                                                data-image="{{ asset('storage/' . $portfolio->sample_work_image) }}"
                                                data-title="{{ $portfolio->sample_work_title }}"
                                                data-desc="{{ $portfolio->sample_work_description }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </div>
                                        <div class="portfolio-caption p-2">
                                            <h6 class="portfolio-title mb-1">{{ $portfolio->sample_work_title }}</h6>
                                            <p class="portfolio-tech small text-muted mb-0">
                                                {{ $portfolio->sample_work_description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <!-- Single Modal (reused for all items) -->
                        <div class="modal fade" id="viewSampleWorkModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewSampleWorkModalTitle">Preview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" id="closeModalX"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body text-center p-0">
                                        <img id="viewSampleWorkModalImage" src="" alt="Portfolio image"
                                            class="img-fluid w-100" style="max-height:75vh; object-fit:contain;">
                                        <div class="p-3 text-start">
                                            <p id="viewSampleWorkModalDesc" class="text-muted mb-0"></p>
                                        </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal" id="closeModalBtn">Close</button>

                                        <!-- Delete Form -->
                                        <form id="deletePortfolioForm"
                                            action="{{ route('applicant.portfolio.delete', ['id' => $portfolio->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>





                        @php
                            $applicantId = session('applicant_id');
                        @endphp

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

                            @if ($youtube->applicant_id == $applicantId && $embedUrl)
                                <div class="portfolio-item mb-3 position-relative">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $embedUrl }}" title="{{ $youtube->sample_work_title }}"
                                            allowfullscreen
                                            style="border-radius: var(--border-radius-lg); border: none;"></iframe>
                                    </div>
                                    <p class="mt-2 fw-semibold">{{ $youtube->sample_work_title }}</p>

                                    <!-- Delete Button (opens modal) -->
                                    <button type="button"
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteYoutubeModal{{ $youtube->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteYoutubeModal{{ $youtube->id }}"
                                        tabindex="-1" aria-labelledby="deleteYoutubeModalLabel{{ $youtube->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="deleteYoutubeModalLabel{{ $youtube->id }}">
                                                        Confirm Delete
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete the video
                                                    "<strong>{{ $youtube->sample_work_title }}</strong>"?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>

                                                    <!-- FIX: Added action to delete route -->
                                                    <form
                                                        action="{{ route('applicant.youtubevideo.delete', ['id' => $youtube->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Yes,
                                                            Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                        <button class="btn btn-sm btn-tesda btn-primary-tesda" data-bs-toggle="modal"
                            data-bs-target="#uploadCertificationModal">
                            <i class="bi bi-file-earmark-plus me-1"></i>Upload
                        </button>
                    </div>

                    <div class="card-body-tesda">
                        @foreach ($retrievedTesdaCertifacation as $certification)
                            <div
                                class="d-flex align-items-center justify-content-between mb-3 p-3 border rounded shadow-sm cert-item">

                                {{-- Certification Icon --}}
                                <div class="cert-icon me-3">
                                    <i class="bi bi-award-fill text-warning fs-3"></i>
                                </div>

                                {{-- Certification Info --}}
                                <div class="cert-content flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">{{ $certification->certification_program }}</h6>
                                    <small class="text-muted">
                                        Issued:
                                        {{ \Carbon\Carbon::parse($certification->certification_date_obtained)->format('F d, Y') }}
                                    </small>
                                    <br>
                                    <span
                                        class="badge 
                                          @if ($certification->status == 'pending') bg-warning 
                                          @elseif($certification->status == 'approved') bg-success 
                                          @else bg-danger @endif mt-1">
                                        {{ ucfirst($certification->status) }}
                                    </span>
                                </div>

                                {{-- Actions --}}
                                <div class="dropdown ms-3">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ asset('storage/' . $certification->file_path) }}"
                                                target="_blank" class="dropdown-item">
                                                <i class="bi bi-eye me-2"></i> View Certificate
                                            </a>

                                        </li>
                                        <li>
                                            <form
                                                action="{{ route('applicant.certification.delete', ['id' => $certification->id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this certification?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
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
                        <button class="add-post-btn" data-bs-toggle="modal" data-bs-target="#addPostModal">
                            <i class="bi bi-plus-circle"></i>
                            Add Post
                        </button>
                    </div>

                    <div class="posts-body">
                        <!-- Post Item -->

                        @foreach ($retrievedPosts as $post)
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
                                                {{ $post->personalInfo->first_name ?? 'Unknown' }}
                                                {{ $post->personalInfo->last_name ?? '' }}</div>
                                            <div class="post-time text-muted small">
                                                {{ $post->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="#"><i
                                                        class="bi bi-pencil me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#"><i
                                                        class="bi bi-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </div>
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
                                    <button class="action-btn like-btn liked me-2" onclick="toggleLike(this)">
                                        <i class="bi bi-heart"></i> <span class="like-count">12</span> Like
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="toggleComments(this)">
                                        <i class="bi bi-chat"></i> <span class="comment-count">3</span> Comment
                                    </button>
                                </div>

                                <!-- Comments Section -->
                                <div class="comments-section mt-3" style="display: none">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control comment-input"
                                            placeholder="Write a comment..." />
                                        <button class="btn btn-primary" onclick="addComment(this)">
                                            <i class="bi bi-send"></i>
                                        </button>
                                    </div>
                                    <div class="comments-list">
                                        <div class="comment-item mt-2 p-2 rounded bg-light">
                                            <strong>Maria Santos:</strong> Congratulations! Well deserved! 🎉
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <!-- Another Post -->
                        <div class="post-item">
                            <div class="post-header">
                                <div class="post-meta">
                                    <div class="post-avatar">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div>
                                        <div class="post-author">John Doe</div>
                                        <div class="post-time">1 week ago</div>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="bi bi-pencil me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#"><i
                                                    class="bi bi-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="post-content">
                                Starting my portfolio project today! Working on a responsive
                                website using the skills I learned from TESDA. Looking forward
                                to showcasing my abilities.
                            </div>

                            <div class="post-actions">
                                <button class="action-btn like-btn liked" onclick="toggleLike(this)">
                                    <i class="bi bi-heart-fill"></i>
                                    <span class="like-count">8</span> Like
                                </button>
                                <button class="action-btn comment-btn" onclick="toggleComments(this)">
                                    <i class="bi bi-chat"></i>
                                    <span class="comment-count">2</span> Comment
                                </button>
                            </div>

                            <div class="comments-section mt-3" style="display: none">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control comment-input"
                                        placeholder="Write a comment..."
                                        style="border-radius: var(--border-radius-lg); border: 1px solid var(--border-color);" />
                                    <button class="btn btn-tesda btn-primary-tesda" onclick="addComment(this)">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </div>
                                <div class="comments-list">
                                    <div class="comment-item mt-2 p-2 rounded">
                                        <strong>Carlos Rodriguez:</strong> Can't wait to see it!
                                    </div>
                                </div>
                            </div>
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
            <form action="{{ route('applicant.certification.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
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
                            <input type="file" class="form-control" name="certificate_file"
                                accept="application/pdf,image/*" />
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
                                <option value="Pipefitting NC II">Pipefitting NC II</option>
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

                        <div class="mb-3">
                            <label class="form-label">Date Obtained</label>
                            <input type="date" name="date_obtained" class="form-control" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-tesda btn-primary-tesda">
                            Upload Certificate
                        </button>
                    </div>
                </div>
            </form>

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
                                value="{{ $retrievedProfile->personal_info->house_street }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Barangay</label>
                            <input type="text" name="barangay" class="form-control"
                                value="{{ $retrievedProfile->personal_info->barangay }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control"
                                value="{{ $retrievedProfile->personal_info->city }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Province</label>
                            <input type="text" name="province" class="form-control"
                                value="{{ $retrievedProfile->personal_info->province }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">About</label>
                            <textarea name="description" rows="3" class="form-control">{{ $retrievedProfile->template->description }}</textarea>
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


    <!-- Bootstrap JS (v5) -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('viewSampleWorkModal');
            const modalImage = document.getElementById('viewSampleWorkModalImage');
            const modalTitle = document.getElementById('viewSampleWorkModalTitle');
            const modalDesc = document.getElementById('viewSampleWorkModalDesc');

            // One stable modal instance
            const bsModal = new bootstrap.Modal(modalEl, {
                backdrop: false, // allow background clicks
                keyboard: true // allow Esc to close
            });

            // Open modal on button click
            document.querySelectorAll('.view-portfolio-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    modalImage.src = btn.dataset.image || '';
                    modalImage.alt = btn.dataset.title || 'Preview';
                    modalTitle.textContent = btn.dataset.title || 'Preview';
                    modalDesc.textContent = btn.dataset.desc || '';

                    bsModal.show();
                });
            });

            // Fix pointer-events so background is clickable & modal is stable
            modalEl.addEventListener('shown.bs.modal', () => {
                modalEl.style.pointerEvents = "auto";
                modalEl.querySelector('.modal-dialog').style.pointerEvents = "auto";
                document.body.classList.remove('modal-open'); // prevent scroll lock
            });

            // Reset modal content when closed
            modalEl.addEventListener('hidden.bs.modal', () => {
                modalImage.src = '';
                modalTitle.textContent = 'Preview';
                modalDesc.textContent = '';
            });
        });
    </script>






</body>

</html>
