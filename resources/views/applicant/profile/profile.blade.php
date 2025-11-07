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

</head>

<body>
    <!-- Header Section -->
    <div class="header-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="tesda-logo">
                    <div class="logo-icon">

                    </div>
                    <div class="nav-logo d-flex align-items-center">

                        <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home" />
                        <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" />

                    </div>
                </div>
                <a href="{{ route('applicant.info.homepage.display') }}" class="back-btn">
                    <i class="bi bi-house-door-fill me-2"></i>
                    <div class="bth"> Back to Homepage</div>
                </a>
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
    <br>
    <div class="profile-container animate-fade-in">
        <!-- Profile Card -->
        <div class="profile-card">
            <!-- Cover Section -->
            <!-- Cover Section -->
            <div class="cover-section">
                <div class="cover-section position-relative">

                    <!-- Cover Photo -->
                    <img src="{{ asset('storage/' . $retrievedDecrytedProfile['work_background']['cover_photo_path']) }}"
                        alt="Cover Photo" class="cover-image w-100 d-block"
                        style="max-height: 350px; object-fit: cover;">

                    <div class="cover-overlay"></div>
                    <div class="cover-pattern"></div>

                    <!-- Gear Button -->
                    <div class="dropdown position-absolute top-0 end-0 m-3" style="z-index: 10;">
                        <button class="settings-btn dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-gear"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#uploadCoverModal">
                                    <i class="bi bi-upload me-2"></i>Upload Cover Photo
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                    data-bs-target="#deleteCoverModal">
                                    <i class="bi bi-trash me-2"></i>Delete Cover Photo
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>



                <!-- Upload Cover Photo Modal -->
                <div class="modal fade" id="uploadCoverModal" tabindex="-1" aria-labelledby="uploadCoverModalLabel"
                    aria-hidden="true" data-bs-backdrop="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('applicant.coverphoto.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadCoverModalLabel">Upload Cover Photo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="file" name="cover_photo" class="form-control" accept="image/*"
                                        required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Cover Photo Modal -->
                <div class="modal fade" id="deleteCoverModal" tabindex="-1" aria-labelledby="deleteCoverModalLabel"
                    aria-hidden="true" data-bs-backdrop="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('applicant.coverphoto.delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteCoverModalLabel">Delete Cover Photo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete your cover photo?</p>
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

                <!-- Profile Photo -->
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
                        @if ($retrievedDecrytedProfile)
                            <h1 class="profile-name">
                                {{ $retrievedDecrytedProfile['personal_info']['first_name'] }}
                                {{ $retrievedDecrytedProfile['personal_info']['last_name'] }}
                            </h1>
                            <p class="profile-title">
                                @if (in_array($retrievedDecrytedProfile['work_background']['position'], [
                                        'Automotive Servicing',
                                        'Bartender',
                                        'Barista',
                                        'Beauty Care Specialist',
                                        'Carpenter',
                                        'Cook',
                                        'Customer Service Representative',
                                        'Dressmaker/Tailor',
                                        'Electrician',
                                        'Food and Beverage Server',
                                        'Hairdresser',
                                        'Heavy Equipment Operator',
                                        'Housekeeping',
                                        'Mason',
                                        'Massage Therapist',
                                        'Mechanic',
                                        'Plumber',
                                        'Security Guard',
                                        'SMAW Welder',
                                        'Tile Setter',
                                        'Tourism Services Staff',
                                        'Waiter/Waitress',
                                    ]))
                                    {{ $retrievedDecrytedProfile['work_background']['position'] }}
                                @else
                                    {{ $retrievedDecrytedProfile['work_background']['position'] }}
                                @endif
                                | {{ $retrievedDecrytedProfile['work_background']['work_duration'] }}
                                {{ $retrievedDecrytedProfile['work_background']['work_duration_unit'] }}
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
        <!-- Edit Profile Modal -->
        @include('applicant.profile.modal.edit_profile')



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
                                    {{ $retrievedDecrytedProfile['personal_info']['street'] ?? '' }}
                                    {{ $retrievedDecrytedProfile['personal_info']['barangay'] ?? '' }},
                                    {{ $retrievedDecrytedProfile['personal_info']['city'] ?? '' }},
                                    {{ $retrievedDecrytedProfile['personal_info']['province'] ?? '' }}
                                </p>
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="bi bi-chat-quote-fill"></i>
                            </div>
                            <div class="about-content">
                                <h6>About</h6>
                                <p>{{ $retrievedDecrytedProfile['template']['description'] }}</p>
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
                                                data-id="{{ $portfolio->id }}"
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
                                                <img id="viewSampleWorkModalImage" src=""
                                                    alt="Portfolio image" class="img-fluid w-100"
                                                    style="max-height:75vh; object-fit:contain;">
                                                <div class="p-3 text-start">
                                                    <p id="viewSampleWorkModalDesc" class="text-muted mb-0"></p>
                                                </div>
                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal" id="closeModalBtn">Close</button>

                                                <!-- Delete Form -->
                                                @if (isset($portfolio))
                                                    <!---Ignored--->
                                                    <form
                                                        action="{{ route('applicant.portfolio.delete', ['id' => $portfolio->id]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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

                                    <!-- Delete Confirmation Modal (no backdrop) -->
                                    <div class="modal fade" id="deleteYoutubeModal{{ $youtube->id }}"
                                        tabindex="-1" aria-labelledby="deleteYoutubeModalLabel{{ $youtube->id }}"
                                        aria-hidden="true" data-bs-backdrop="false">
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

                                    {{-- Status Badge --}}
                                    <span
                                        class="badge mt-1 
                                             @if ($certification->status === 'pending') bg-warning
                                            @elseif ($certification->status === 'approved') bg-success
                                            @elseif ($certification->status === 'rejected') bg-danger
                                            @else bg-dark @endif">
                                        {{ $certification->status === 'request_revision' ? 'Request Revision' : ucfirst($certification->status) }}
                                    </span>

                                    {{-- Show officer comment if status is request_revision and comment exists --}}
                                    @if ($certification->status === 'request_revision' && $certification->officer_comment)
                                        <div class="mt-2 p-2 border rounded bg-light">
                                            <strong>Reason for Revision:</strong>
                                            <p class="mb-0">{{ $certification->officer_comment }}</p>
                                        </div>
                                    @endif

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
                                                    <label for="content-{{ $post->id }}" class="form-label">Post
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
                                                    <label for="image-{{ $post->id }}" class="form-label">Change
                                                        Image</label>
                                                    <input type="file" name="image"
                                                        id="image-{{ $post->id }}" class="form-control">
                                                    <small class="text-muted">Leave blank if you don't want to change
                                                        the image.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
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
                                                Are you sure you want to delete this post? This action cannot be undone.
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

                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
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
                                    <form action="{{ route('applicant.likepost.store', $post->id) }}" method="POST"
                                        class="d-inline">
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

                                                    {{-- Inline delete button (subtle, like Facebook) --}}
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
                                                    <strong>{{ $comment->applicant->personal_info->first_name ?? 'Unknown' }}
                                                        {{ $comment->applicant->personal_info->last_name ?? 'Anonymous' }}:</strong>
                                                    {{ $comment->comment }}
                                                @endif

                                                {{-- Reply button (always visible like FB) --}}
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

    <!-- Modals (keeping your existing modal structure) -->
    <!-- Upload Image Modal -->
    @include('applicant.profile.modal.upload_work')
    <!-- Add YouTube Modal -->
    @include('applicant.profile.modal.upload_youtube_link')

    <!-- Upload Certification Modal -->
    @include('applicant.profile.modal.upload_certification')
    <!-- View Certification Modal -->
    {{-- <div class="modal fade" id="viewCertificationModal" tabindex="-1" aria-labelledby="viewCertificationModalLabel"
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
    </div> --}}



    </div>

    <!-- Add Post Modal -->
    @include('applicant.profile.modal.add_post')
    <!-- Edit About me Modal -->
    @include('applicant.profile.modal.edit_about_me')


    <!-- Bootstrap JS (v5) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        function toggleLike(btn, postId) {
            fetch(`profile/like-post/${id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    const icon = btn.querySelector("i");
                    const countSpan = btn.querySelector(".like-count");
                    let count = parseInt(countSpan.textContent);

                    if (data.status === 'liked') {
                        btn.classList.add("liked");
                        icon.classList.remove("bi-heart");
                        icon.classList.add("bi-heart-fill");
                        countSpan.textContent = count + 1;
                    } else {
                        btn.classList.remove("liked");
                        icon.classList.remove("bi-heart-fill");
                        icon.classList.add("bi-heart");
                        countSpan.textContent = count - 1;
                    }
                });
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
