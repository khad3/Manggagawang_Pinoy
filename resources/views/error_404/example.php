<!-- Employer View Applicant Profile Modal -->
    <div class="modal fade" id="viewApplicantProfileModal" tabindex="-1" aria-labelledby="viewApplicantProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="viewApplicantProfileModalLabel">Applicant Assessment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Candidate Overview Card -->
                    <div class="candidate-overview-card mb-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="candidate-photo-container">
                                    <img src="{{ asset('storage/' . $retrievedProfile->work_background->profileimage_path) }}" alt="Profile Photo" class="candidate-photo" />
                                    <div class="status-indicator"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="candidate-basic-info">
                                    <h4 class="candidate-name">{{  $retrievedProfile->personal_info->first_name }} {{  $retrievedProfile->personal_info->last_name }}</h4>
                                    <div class="candidate-role">Electrician <span class="experience-badge">5 Years Experience</span></div>
                                    <div class="candidate-location"><i class="fas fa-map-marker-alt"></i> Silang, Cavite</div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="candidate-score-card">
                                    <div class="certification-badge">
                                        <i class="fas fa-shield-alt"></i> TESDA Certified
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Assessment Tabs -->
                    <div class="assessment-tabs mb-4">
                        <nav>
                            <div class="nav nav-tabs employer-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab">
                                    <i class="fas fa-user"></i> Profile
                                </button>
                                <button class="nav-link" id="nav-skills-tab" data-bs-toggle="tab" data-bs-target="#nav-skills" type="button" role="tab">
                                    <i class="fas fa-tools"></i> Skills & Portfolio
                                </button>
                                <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews" type="button" role="tab">
                                    <i class="fas fa-star"></i> Reviews
                                </button>
                                <button class="nav-link" id="nav-assessment-tab" data-bs-toggle="tab" data-bs-target="#nav-assessment" type="button" role="tab">
                                    <i class="fas fa-clipboard-check"></i> Assessment
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
                                                <span class="info-value">juan@example.com</span>
                                                <i class="fas fa-copy copy-btn" data-copy="juan@example.com"></i>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Phone:</span>
                                                <span class="info-value">+63 912 345 6789</span>
                                                <i class="fas fa-copy copy-btn" data-copy="+63 912 345 6789"></i>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Location:</span>
                                                <span class="info-value">Silang, Cavite</span>
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
                                            <p class="professional-summary">"Passionate about quality workmanship and safety standards. Experienced in residential and commercial electrical installations with a strong focus on code compliance and customer satisfaction."</p>
                                            <div class="key-strengths">
                                                <span class="strength-tag">Safety Focused</span>
                                                <span class="strength-tag">Code Compliant</span>
                                                <span class="strength-tag">Customer Service</span>
                                                <span class="strength-tag">Problem Solver</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Skills & Portfolio Tab -->
                        <div class="tab-pane fade" id="nav-skills" role="tabpanel">
                            <!-- Certifications Section -->
                            <div class="certifications-section mb-4">
                                <h6 class="section-title"><i class="fas fa-certificate"></i> Certifications</h6>
                                <div class="certification-grid">
                                    <div class="cert-card">
                                        <div class="cert-icon">
                                            <i class="fas fa-bolt"></i>
                                        </div>
                                        <div class="cert-info">
                                            <h6>NC II - Electrical Installation</h6>
                                            <p>TESDA • June 2024</p>
                                        </div>
                                        <div class="cert-status verified">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                    <div class="cert-card">
                                        <div class="cert-icon">
                                            <i class="fas fa-fire"></i>
                                        </div>
                                        <div class="cert-info">
                                            <h6>NC I - Arc Welding</h6>
                                            <p>TESDA • March 2023</p>
                                        </div>
                                        <div class="cert-status verified">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Portfolio Section -->
                            <div class="portfolio-section">
                                <h6 class="section-title"><i class="fas fa-images"></i> Work Portfolio</h6>
                                <div class="portfolio-grid">
                                    <div class="portfolio-item">
                                        <div class="portfolio-image">
                                            <img src="https://via.placeholder.com/300x200" alt="Electrical Panel">
                                            <div class="portfolio-overlay">
                                                <button class="view-btn" data-bs-toggle="modal" data-bs-target="#portfolioModal">
                                                    <i class="fas fa-expand"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="portfolio-info">
                                            <h6>Electrical Panel Installation</h6>
                                            <p>Residential Complex, Makati</p>
                                            <span class="project-tag">Commercial</span>
                                        </div>
                                    </div>
                                    <div class="portfolio-item">
                                        <div class="portfolio-video">
                                            <div class="video-thumbnail">
                                                <img src="https://via.placeholder.com/300x200" alt="Safety Demo">
                                                <div class="play-button">
                                                    <i class="fas fa-play"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="portfolio-info">
                                            <h6>Safety Procedures Demo</h6>
                                            <p>Equipment Setup & Safety</p>
                                            <span class="project-tag">Training</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="nav-reviews" role="tabpanel">
                            <div class="reviews-overview mb-4">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <div class="review-stat">
                                            <div class="stat-number">4.8</div>
                                            <div class="stat-label">Average Rating</div>
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="review-stat">
                                            <div class="stat-number">47</div>
                                            <div class="stat-label">Total Reviews</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="review-stat">
                                            <div class="stat-number">96%</div>
                                            <div class="stat-label">Recommend Rate</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="review-stat">
                                            <div class="stat-number">98%</div>
                                            <div class="stat-label">On-Time Delivery</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="reviews-list">
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <img src="https://i.pravatar.cc/40?img=11" alt="Reviewer" class="reviewer-avatar">
                                            <div>
                                                <h6 class="reviewer-name">Kristine Morales</h6>
                                                <p class="reviewer-title">Project Manager, BuildCorp</p>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="review-date">3 days ago</span>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <p>"Impressive work! Juan completed our office electrical installation ahead of schedule. His attention to detail and safety protocols were exceptional. Professional and knowledgeable throughout the project."</p>
                                        <div class="review-tags">
                                            <span class="review-tag">Quality Work</span>
                                            <span class="review-tag">On Time</span>
                                            <span class="review-tag">Professional</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <img src="https://i.pravatar.cc/40?img=7" alt="Reviewer" class="reviewer-avatar">
                                            <div>
                                                <h6 class="reviewer-name">Miguel Fernandez</h6>
                                                <p class="reviewer-title">Construction Supervisor</p>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <span class="review-date">1 week ago</span>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <p>"Juan's safety video demonstration was incredibly informative. His knowledge of electrical safety protocols is exceptional. Reliable and trustworthy professional."</p>
                                        <div class="review-tags">
                                            <span class="review-tag">Safety Expert</span>
                                            <span class="review-tag">Knowledgeable</span>
                                            <span class="review-tag">Reliable</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Assessment Tab -->
                        <div class="tab-pane fade" id="nav-assessment" role="tabpanel">
                            <div class="assessment-section">
                                <div class="row g-4">
                                    <!-- Skills Assessment -->
                                    <div class="col-lg-6">
                                        <div class="assessment-card">
                                            <h6 class="assessment-title"><i class="fas fa-cogs"></i> Technical Skills</h6>
                                            <div class="skill-assessment">
                                                <div class="skill-item">
                                                    <span class="skill-name">Electrical Installation</span>
                                                    <div class="skill-bar">
                                                        <div class="skill-progress" style="width: 92%"></div>
                                                    </div>
                                                    <span class="skill-score">92%</span>
                                                </div>
                                                <div class="skill-item">
                                                    <span class="skill-name">Safety Protocols</span>
                                                    <div class="skill-bar">
                                                        <div class="skill-progress" style="width: 96%"></div>
                                                    </div>
                                                    <span class="skill-score">96%</span>
                                                </div>
                                                <div class="skill-item">
                                                    <span class="skill-name">Code Compliance</span>
                                                    <div class="skill-bar">
                                                        <div class="skill-progress" style="width: 88%"></div>
                                                    </div>
                                                    <span class="skill-score">88%</span>
                                                </div>
                                                <div class="skill-item">
                                                    <span class="skill-name">Problem Solving</span>
                                                    <div class="skill-bar">
                                                        <div class="skill-progress" style="width: 85%"></div>
                                                    </div>
                                                    <span class="skill-score">85%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Employer Decision Tools -->
                                    <div class="col-lg-6">
                                        <div class="assessment-card">
                                            <h6 class="assessment-title"><i class="fas fa-clipboard-check"></i> Hiring Assessment</h6>
                                            <div class="decision-tools">
                                                <div class="assessment-item">
                                                    <span class="assessment-label">Experience Match:</span>
                                                    <span class="assessment-value excellent">Excellent</span>
                                                </div>
                                                <div class="assessment-item">
                                                    <span class="assessment-label">Salary Expectation:</span>
                                                    <span class="assessment-value good">Within Range</span>
                                                </div>
                                                <div class="assessment-item">
                                                    <span class="assessment-label">Location Proximity:</span>
                                                    <span class="assessment-value excellent">25km</span>
                                                </div>
                                                <div class="assessment-item">
                                                    <span class="assessment-label">Background Check:</span>
                                                    <span class="assessment-value excellent">Verified</span>
                                                </div>
                                                <div class="assessment-item">
                                                    <span class="assessment-label">References:</span>
                                                    <span class="assessment-value excellent">All Positive</span>
                                                </div>
                                            </div>

                                            <!-- Quick Actions -->
                                            <div class="quick-actions mt-3">
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-bookmark"></i> Save for Later
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-calendar"></i> Schedule Interview
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <div class="hiring-decision-bar">
                        <div class="decision-buttons">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                            <button type="button" class="btn btn-outline-danger">
                                <i class="fas fa-user-times"></i> Reject
                            </button>
                            <button type="button" class="btn btn-warning">
                                <i class="fas fa-envelope"></i> Send Message
                            </button>
                            <button type="button" class="btn btn-success">
                                <i class="fas fa-user-check"></i> Approve & Hire
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
