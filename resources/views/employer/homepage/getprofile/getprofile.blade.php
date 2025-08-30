<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Applicant Assessment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/applicant/employer/profileapplicant.css') }}">
</head>

<body>

    <a href="{{ route('employer.info.homepage.display') }}" class="back-button"><i class="fas fa-arrow-left"></i>
        Back</a>
    <div class="container py-5">

        <div class="candidate-overview-card mb-4">
            <!-- Candidate Overview Card -->
            <div class="candidate-overview-card mb-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="candidate-photo-container">
                            <img src="{{ asset('storage/' . $retrievedProfile->work_background->profileimage_path) }}"
                                alt="Profile Photo" class="candidate-photo" />
                            <div class="status-indicator"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="candidate-basic-info">
                            <h4 class="candidate-name">{{ $retrievedProfile->personal_info->first_name }}
                                {{ $retrievedProfile->personal_info->last_name }}</h4>
                            <div class="candidate-role">{{ $retrievedProfile->work_background->position }}<span
                                    class="experience-badge">{{ $retrievedProfile->work_background->work_duration }}
                                    {{ $retrievedProfile->work_background->work_duration_unit }} experience</span></div>
                            <div class="candidate-location"><i class="fas fa-map-marker-alt"></i>
                                {{ $retrievedProfile->personal_info->house_street }}
                                {{ $retrievedProfile->personal_info->city }}
                                {{ $retrievedProfile->personal_info->province }}
                                {{ $retrievedProfile->personal_info->zipcode }}</div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="candidate-score-card">
                            @php
                                $hasApproved = $tesdaCertification->contains('status', 'approved');
                            @endphp

                            @if ($hasApproved)
                                <div class="certification-badge text-success">
                                    <i class="fas fa-shield-alt"></i> TESDA Certified
                                </div>
                            @else
                                <div class="certification-badge text-muted">
                                    <i class="fas fa-times-circle"></i> Not TESDA Certified
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="assessment-tabs mb-4">
            <nav>
                <div class="nav nav-tabs employer-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-profile" type="button" role="tab">
                        <i class="fas fa-user"></i> Profile
                    </button>
                    <button class="nav-link" id="nav-skills-tab" data-bs-toggle="tab" data-bs-target="#nav-skills"
                        type="button" role="tab">
                        <i class="fas fa-tools"></i> Skills & Portfolio
                    </button>
                    <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews"
                        type="button" role="tab">
                        <i class="fas fa-star"></i> Reviews
                    </button>
                    <button class="nav-link" id="nav-assessment-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-assessment" type="button" role="tab">
                        <i class="fas fa-clipboard-check"></i> Summary
                    </button>
                </div>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="nav-tabContent">
            <!-- Profile Tab -->
            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel">
                <div class="row g-4">
                    <!-- Contact & Basic Info -->
                    <div class="col-lg-6">
                        <div class="info-card">
                            <div class="card-header">
                                <h6><i class="fas fa-address-card"></i> Contact Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <span class="info-label">Email:</span>
                                    <span class="info-value">{{ $retrievedProfile->email }}</span>
                                    <i class="fas fa-copy copy-btn" data-copy="{{ $retrievedProfile->email }}"></i>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Phone:</span>
                                    <span class="info-value">N/A</span>
                                    <i class="fas fa-copy copy-btn" data-copy="+63 912 345 6789"></i>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Location:</span>
                                    <span class="info-value">{{ $retrievedProfile->personal_info->house_street }},
                                        {{ $retrievedProfile->personal_info->city }},
                                        {{ $retrievedProfile->personal_info->province }},
                                        {{ $retrievedProfile->personal_info->zipcode }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Summary -->
                    <div class="col-lg-6">
                        <div class="info-card">
                            <div class="card-header">
                                <h6><i class="fas fa-quote-left"></i> Professional Summary</h6>
                            </div>
                            <div class="card-body">
                                <p class="professional-summary">"{{ $retrievedProfile->template->description }}"</p>
                                <div class="key-strengths">
                                    <!-- <span class="strength-tag">Safety Focused</span>
                                                <span class="strength-tag">Code Compliant</span>
                                                <span class="strength-tag">Customer Service</span>
                                                <span class="strength-tag">Problem Solver</span> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Applicant's Post with Toggleable Comments -->
                    @foreach ($retrievedPosts as $post)
                        <div class="col-12">
                            <div class="card border-0 shadow mb-5 rounded-4 overflow-hidden">
                                <!-- Header -->
                                <div
                                    class="card-header bg-white border-bottom d-flex justify-content-between align-items-start py-3 px-4">
                                    <div>
                                        <h5 class="fw-semibold text-primary mb-1">
                                            <i class="fas fa-pen-nib me-2"></i> Applicant Post
                                        </h5>
                                        <small class="text-muted">
                                            Posted by {{ $post->personalInfo->first_name }}
                                            {{ $post->personalInfo->last_name }} •
                                            {{ $post->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                </div>

                                <!-- Body -->
                                <div class="card-body px-4 py-4 bg-light">
                                    <p class="fs-5 mb-4 text-dark lh-lg">
                                        {{ $post->content }}
                                    </p>

                                    @if ($post->image_path)
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image"
                                                class="img-fluid rounded-3 shadow-sm-border border-1"
                                                style="max-height: 400px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <br>
                                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                        onclick="toggleComments(this)">
                                        <i class="fas fa-comments me-1"></i> Show Comments
                                    </button>
                                </div>



                                <!-- Comments -->
                                <div class="comments-section px-4 pb-4 d-none bg-white">
                                    <hr>
                                    <h6 class="mb-3 text-muted">
                                        <i class="fas fa-comment-dots me-1"></i> Comments
                                    </h6>

                                    <!-- Comment Form -->
                                    <form class="mb-4">
                                        <textarea class="form-control rounded-3 shadow-sm" rows="3" placeholder="Write a comment..."></textarea>
                                        <div class="text-end mt-2">
                                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-4">
                                                <i class="fas fa-paper-plane me-1"></i> Post Comment
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Example Comments -->
                                    <div class="bg-light border-start border-4 border-primary rounded-3 p-3 mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <strong>Michael Cruz</strong>
                                            <small class="text-muted">2 hours ago</small>
                                        </div>
                                        <p class="mb-0">Impressive post! Looking forward to working with you soon.
                                        </p>
                                    </div>
                                    <div class="bg-light border-start border-4 border-success rounded-3 p-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <strong>HR, BuildCorp</strong>
                                            <small class="text-muted">1 day ago</small>
                                        </div>
                                        <p class="mb-0">Great experience summary. We'll reach out for an interview.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Skills & Portfolio Tab -->
            <div class="tab-pane fade" id="nav-skills" role="tabpanel">
                <!-- Certifications Section -->
                <div class="certifications-section mb-4">
                    <h6 class="section-title"><i class="fas fa-certificate"></i> Certifications</h6>
                    <div class="certification-grid">
                        @if ($tesdaCertification->isNotEmpty())
                            @foreach ($tesdaCertification as $cert)
                                <div
                                    class="cert-card d-flex align-items-center justify-content-between p-3 border rounded mb-2">
                                    <!-- Left side: Icon + Info -->
                                    <div class="d-flex align-items-center">
                                        <div class="cert-icon me-3 text-warning">
                                            <i class="fas fa-bolt fa-lg"></i>
                                        </div>

                                        <div class="cert-info">
                                            <h6 class="mb-1 fw-bold">{{ $cert->certification_program }}</h6>
                                            <p class="mb-0 text-muted small">
                                                TESDA • {{ $cert->updated_at->format('M d, Y') }} approved
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Right side: Check + View Button -->
                                    <div class="d-flex align-items-center">
                                        <div class="cert-status text-success me-3">
                                            <i class="fas fa-check-circle fa-lg"></i>
                                        </div>

                                        @if ($cert->file_path)
                                            <a href="{{ asset('storage/' . $cert->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf me-1"></i> View
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No TESDA Certifications available.</p>
                        @endif

                    </div>

                    <!-- Portfolio Section -->
                    <div class="portfolio-section">
                        <h6 class="section-title"><i class="fas fa-images"></i> Work Portfolio</h6>
                        <div class="portfolio-grid">
                            @foreach ($retrievedPortfolio as $portfolio)
                                <div class="portfolio-item">
                                    <div class="portfolio-image">
                                        <img src="{{ asset('storage/' . $portfolio->sample_work_image) }}"
                                            alt="{{ $portfolio->sample_work_title }}">
                                        <div class="portfolio-overlay">
                                            <button class="view-btn" data-bs-toggle="modal"
                                                data-bs-target="#portfolioModal"
                                                data-image="{{ asset('storage/' . $portfolio->sample_work_image) }}"
                                                data-title="{{ $portfolio->sample_work_title }}"
                                                data-description="{{ $portfolio->sample_work_description }}">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="portfolio-info">
                                        <h6>{{ $portfolio->sample_work_title }}</h6>
                                        <p>{{ $portfolio->sample_work_description }}</p>
                                    </div>
                                </div>
                            @endforeach

                            <div class="modal fade" id="portfolioModal" tabindex="-1"
                                aria-labelledby="portfolioModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="portfolioModalLabel">Portfolio Preview</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="modalPortfolioImage" src=""
                                                class="img-fluid rounded mb-3" alt="Expanded Portfolio Image">
                                            <h6 id="modalPortfolioTitle" class="fw-bold"></h6>
                                            <p id="modalPortfolioDescription" class="text-muted"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            @foreach ($retrievedYoutube as $yt)
                                @php
                                    $youtubeID = '';

                                    $parsedUrl = parse_url($yt->sample_work_url);
                                    if (isset($parsedUrl['host'])) {
                                        if (strpos($parsedUrl['host'], 'youtu.be') !== false) {
                                            // Shortened youtu.be format
                                            $youtubeID = ltrim($parsedUrl['path'], '/');
                                        } elseif (strpos($parsedUrl['host'], 'youtube.com') !== false) {
                                            // Standard YouTube URL
                                            parse_str($parsedUrl['query'] ?? '', $ytParams);
                                            $youtubeID = $ytParams['v'] ?? '';
                                        }
                                    }
                                @endphp

                                @if ($youtubeID)
                                    <div class="card mb-4 shadow-sm youtube-card">
                                        <div class="ratio ratio-16x9">
                                            <iframe src="https://www.youtube.com/embed/{{ $youtubeID }}"
                                                allowfullscreen frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                                            </iframe>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">
                                                <i class="fab fa-youtube me-2"></i>{{ $yt->sample_work_title }}
                                            </h5>
                                            <p class="card-text">{{ $yt->description ?? 'No description provided.' }}
                                            </p>
                                            <span class="badge bg-danger"><i class="fab fa-youtube me-1"></i>
                                                YouTube</span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach



                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="nav-reviews" role="tabpanel">
                <div class="reviews-overview mb-4">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="review-stat">
                                <div class="stat-number">{{ $averageRating }}</div>
                                <div class="stat-label">Average Rating</div>
                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($averageRating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - $averageRating < 1)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="review-stat">
                                <div class="stat-number">{{ $totalReviews }}</div>
                                <div class="stat-label">Total Reviews</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($retrievedRating && count($retrievedRating) > 0)
                    @foreach ($retrievedRating as $rating)
                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div>
                                        <h6 class="reviewer-name">
                                            {{ $rating->personalInfo->first_name ?? 'N/A' }}
                                            {{ $rating->personalInfo->last_name ?? '' }}
                                        </h6>
                                        <p class="reviewer-title">
                                            {{ $rating->personalInfo->employer_job_title ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $rating->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="review-date">{{ $rating->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>{{ $rating->review_comments }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No reviews yet.</p>
                @endif



                <hr class="my-4">
                <h6 class="mb-3"><i class="fas fa-pen"></i> Leave a Review</h6>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('employer.sendrating.store') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="applicant_id" value="{{ $retrievedProfile->id }}">

                    <div class="mb-3">
                        <label for="review_content" class="form-label">Your Review</label>
                        <textarea class="form-control" id="review_content" name="review_comment" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="star-rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star{{ $i }}"
                                    value="{{ $i }}" required />
                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Submit Review
                    </button>
                </form>

            </div> <!-- end for the review card--->



        </div>

        <!-- Assessment Tab -->
        <div class="tab-pane fade" id="nav-assessment" role="tabpanel">
            <div class="assessment-section">
                <div class="col-lg-6">
                    <div class="assessment-card">
                        <h6 class="assessment-title"><i class="fas fa-user-check"></i> Candidate Summary</h6>
                        <div class="decision-tools">
                            <div class="assessment-item">
                                <span class="assessment-label">Work Experience:</span>
                                <span
                                    class="assessment-value excellent">{{ $retrievedProfile->work_background->work_duration ?? 'N/A' }}
                                    {{ $retrievedProfile->work_background->work_duration_unit ?? 'N/A' }}</span>
                            </div>

                            <div class="assessment-item">
                                <span class="assessment-label">Completed Jobs:</span>
                                <span class="assessment-value good">{{ $retrievedPortfolio->count() }} Jobs</span>
                            </div>

                            <div class="assessment-item">
                                <span class="assessment-label">TESDA Certification:</span>
                                <span class="assessment-value excellent">
                                    @if ($tesdaCertification->isNotEmpty())
                                        @foreach ($tesdaCertification as $certification)
                                            {{ $certification->certification_program ?? 'N/A' }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>


                            <div class="assessment-item">
                                <span class="assessment-label">Employer Rating:</span>
                                <span class="assessment-value excellent">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($averageRating >= $i)
                                            <i class="fas fa-star text-warning"></i>
                                        @elseif ($averageRating >= $i - 0.5)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-1">{{ $averageRating }} / 5</span>
                                </span>
                            </div>

                            <div class="assessment-item">
                                <span class="assessment-label">Reviews:</span>
                                <span class="assessment-value good">
                                    @if ($uniqueEmployerCount === 1)
                                        1 Employer Reviewed
                                    @else
                                        {{ $uniqueEmployerCount }} Employers Reviewed
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Employer Options -->
                        <div class="quick-actions mt-3">
                            <button class="btn btn-sm btn-outline-success">
                                <i class="fas fa-user-plus"></i> Add to Shortlist
                            </button>
                            <button class="btn btn-sm btn-outline-info">
                                <i class="fas fa-comments"></i> Send Message
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <!-- Hiring Decision Bar -->
        <div class="sticky-hiring-bar d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-outline-danger px-3">
                <i class="fas fa-user-times me-1"></i> Reject
            </button>
            <button type="button" class="btn btn-outline-warning px-3">
                <i class="fas fa-envelope me-1"></i> Send Message
            </button>
            <button type="button" class="btn btn-success px-3">
                <i class="fas fa-user-check me-1"></i> Approve & Hire
            </button>
        </div>
    </div>


    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('portfolioModal');
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const image = button.getAttribute('data-image');
                const title = button.getAttribute('data-title');
                const description = button.getAttribute('data-description');

                document.getElementById('modalPortfolioImage').src = image;
                document.getElementById('modalPortfolioTitle').textContent = title;
                document.getElementById('modalPortfolioDescription').textContent = description;
            });
        });
    </script>

    <script>
        function toggleComments(button) {
            const commentsSection = button.closest('.card').querySelector('.comments-section');
            const isHidden = commentsSection.classList.contains('d-none');

            commentsSection.classList.toggle('d-none');
            button.innerHTML = isHidden ?
                '<i class="fas fa-comment-slash"></i> Hide Comments' :
                '<i class="fas fa-comments"></i> Show Comments';
        }
    </script>



</body>

</html>
