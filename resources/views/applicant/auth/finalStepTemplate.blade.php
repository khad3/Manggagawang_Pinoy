<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobHub - Complete Your Profile</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/finalStep.css') }}">

</head>

<body>
      <nav>
        <div class="navbar-container">
            <div class="nav-logo d-flex align-items-center">
                <a href="{{ route('display.index') }}" class="d-flex align-items-center gap-2" style="text-decoration:none;">
                    <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home"/>
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2"/>
                </a>
            </div>

                        <ul class="nav-links" id="navLinks">
                <li><a href="#">Services</a></li>
                <li><a href="{{ route('display.topworker') }}">Top Workers</a></li>
                <li><a href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                <li><a href="{{ route('display.aboutus') }}">About Us</a></li>
                <li class="dropdown">
               <button class="sign-in-b">Sign in</button>
               <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.login.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.login.display') }}">As Employer</a></li>
                    </ul>
                </li>
                <!-- Sign Up Dropdown -->
                <li class="dropdown">
                    <button class="sign-up-b">Sign up</button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.register.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.register.display') }}">As Employer</a></li>
                    </ul>
                </li>
            </ul>


            <div class="hamburger" id="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </nav>
    <!-- Loader -->
    <div id="loader-wrapper">
        <div id="loader-content">
            <div
                style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; font-weight: 700; color: white;">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-width: 100px;">
            </div>
            <div id="loader"></div>
            <div id="loader-text">Please wait...</div>
        </div>
    </div>

<!-- Step Content -->
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card form-card" style="margin-top:100px;">
            <div class="card-header bg-white border-0 py-4">
                <div class="container">

                    <!-- Header -->
                    <div class="text-center mb-5">
                        <h1 class="display-4 fw-bold text-dark mb-3">Worker Registration</h1>
                        <p class="lead text-muted">Showcase your TESDA-certified skills and connect with employers who value your expertise.</p>
                    </div>

                    <!-- Progress Stepper -->
                    <div class="row justify-content-center mb-5">
                        <div class="col-lg-10">
                            <div class="d-flex align-items-center justify-content-between">

                                <!-- Step 1 -->
                                <div class="text-center">
                                    <div class="step-indicator step-completed" id="step1">1</div>
                                    <div class="mt-2">
                                        <small class="fw-semibold text-dark">Account</small>
                                        <br><small class="text-muted d-none d-sm-block">Account setup</small>
                                    </div>
                                </div>
                                <div class="step-line step-line-completed" id="line2"></div>

                                <!-- Step 2 -->
                                <div class="text-center">
                                    <div class="step-indicator step-completed" id="step2">2</div>
                                    <div class="mt-2">
                                        <small class="fw-semibold text-muted">Verify</small>
                                        <br><small class="text-muted d-none d-sm-block">Verification</small>
                                    </div>
                                </div>
                                <div class="step-line step-line-completed" id="line3"></div>

                                <!-- Step 3 -->
                                <div class="text-center">
                                    <div class="step-indicator step-completed" id="step3">3</div>
                                    <div class="mt-2">
                                        <small class="fw-semibold text-muted">Personal</small>
                                        <br><small class="text-muted d-none d-sm-block">Personal info</small>
                                    </div>
                                </div>
                                <div class="step-line step-line-completed" id="line4"></div>

                                <!-- Step 4 -->
                                <div class="text-center">
                                    <div class="step-indicator step-completed" id="step4">4</div>
                                    <div class="mt-2">
                                        <small class="fw-semibold text-muted">Work</small>
                                        <br><small class="text-muted d-none d-sm-block">Work details</small>
                                    </div>
                                </div>
                                <div class="step-line step-line-completed" id="line5"></div>

                                <!-- Step 5 -->
                                <div class="text-center">
                                    <div class="step-indicator step-active" id="step5">5</div>
                                    <div class="mt-2">
                                        <small class="fw-semibold text-muted">Profile</small>
                                        <br><small class="text-muted d-none d-sm-block">Build profile</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- End Stepper -->

                </div>
            </div>
        <!-- Form Content -->
        <div class="form-content">
            <!-- Profile Header -->
            <div class="profile-header">

                <div class="profile-image-container">
                    <img src="{{ Storage::url($workBackgroundDecrypted['profileimage_path'] ?? '') ?: 'https://via.placeholder.com/100x100/667eea/ffffff?text=Avatar' }}"

                         alt="Profile Image" class="profile-image">
                    <div class="profile-badge">
                        <i class="bi bi-check" style="color: white; font-size: 12px;"></i>
                    </div>
                </div>

                <h2 class="profile-name">
                    {{ $personalInfoDecrypted['first_name'] ?? 'First Name' }}
                    {{ $personalInfoDecrypted['last_name'] ?? 'Last Name' }}
                </h2>

                <div class="profile-position">
                    {{ $workBackgroundDecrypted['position'] ?? 'Position' }}
                </div>

                <div class="profile-experience">
                    {{ $workBackgroundDecrypted['work_duration'] ?? '0' }}
                    {{ $workBackgroundDecrypted['work_duration_unit'] ?? 'years' }} of experience
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Form -->
            <form method="POST" enctype="multipart/form-data" action="{{ route('applicant.info.template.store') }}"
                id="profileForm" onsubmit="return handleSubmit(event)">
                @csrf

                <!-- Description -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-chat-quote me-2"></i>Describe Yourself
                    </label>
                    <textarea name="description" class="form-textarea" rows="4" required
                        placeholder="Tell employers about your skills, experience, and what makes you unique..."
                        oninput="updateCharCounter(this)" maxlength="500">{{ old('description') }}</textarea>
                    <div class="char                    dir storage\app\public\<your-path>-counter">
                        <span id="charCount">0</span>/500 characters
                    </div>
                </div>

                <!-- Sample Work Upload -->
                <!-- <div class="upload-section">
                    <label class="form-label">
                        <i class="bi bi-collection me-2"></i>Upload Sample Work
                        <span style="font-weight: 400; color: #6b7280; font-size: 14px;">(Optional)</span>
                    </label>
                     -->
                <!-- Upload Tabs -->
                <!-- <div class="upload-tabs">
                        <button type="button" class="upload-tab active" onclick="switchTab('file')">
                            <i class="bi bi-cloud-upload me-1"></i>Upload File
                        </button>
                        <button type="button" class="upload-tab" onclick="switchTab('youtube')">
                            <i class="bi bi-youtube me-1"></i>YouTube Link
                        </button>
                    </div> -->

                <!-- File Upload Content -->
                <!-- <div class="upload-content active" id="fileContent">
                        <div class="file-upload-area" onclick="document.getElementById('sample_work_file').click()"
                             ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                            <div class="upload-icon">
                                <i class="bi bi-cloud-upload" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div class="upload-text">Click to upload or drag and drop</div>
                            <div class="upload-subtext">Share your best work to showcase your skills</div>
                            <div class="file-types">Supports: JPG, PNG, PDF, DOC, DOCX (Max 10MB)</div>
                            
                            <div class="file-selected" id="fileSelected">
                                <i class="bi bi-check-circle me-2"></i>
                                <span id="fileName"></span>
                                <button type="button" onclick="removeFile()" style="float: right; background: none; border: none; color: #dc2626;">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                        
                        <input type="file" id="sample_work_file" name="sample_work" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                               style="display: none;" onchange="handleFileSelect(this)">
                    </div> -->

                <!-- YouTube URL Content
                    <div class="upload-content" id="youtubeContent">
                        <input type="url" name="sample_work_url" class="url-input"
                               placeholder="Paste your YouTube video link here (e.g., https://youtube.com/watch?v=...)"
                               value="{{ old('sample_work_url') }}" oninput="previewUrl(this)">
                        
                        <div class="url-preview" id="urlPreview">
                            <i class="bi bi-youtube me-1"></i>
                            <span id="urlText"></span>
                        </div>
                    </div> -->
    

        <!-- Submit Button -->
        <button type="submit" class="submit-btn" id="submitBtn">
            <span id="submitText">
                <i class="bi bi-rocket me-2"></i>Complete Registration
            </span>
        </button>
        </form>
    </div>
    </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Hide loader after page load
        window.addEventListener("load", function() {
            setTimeout(function() {
                document.getElementById("loader-wrapper").style.display = "none";
            }, 1500);
        });


        function updateCharCounter(textarea) {
            const charCount = textarea.value.length;
            document.getElementById('charCount').textContent = charCount;
            const counter = document.querySelector('.char-counter');
            if (charCount > 450) {
                counter.style.color = '#dc2626';
            } else if (charCount > 400) {
                counter.style.color = '#f59e0b';
            } else {
                counter.style.color = '#6b7280';
            }
        }

        function switchTab(tabType) {
            document.querySelectorAll('.upload-tab').forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            document.querySelectorAll('.upload-content').forEach(content => content.classList.remove('active'));
            document.getElementById(tabType === 'file' ? 'fileContent' : 'youtubeContent').classList.add('active');
            if (tabType === 'file') {
                document.querySelector('input[name="sample_work_url"]').value = '';
                document.getElementById('urlPreview').style.display = 'none';
            } else {
                document.getElementById('sample_work_file').value = '';
                document.getElementById('fileSelected').style.display = 'none';
            }
        }

        function handleFileSelect(input) {
            const file = input.files[0];
            if (file) {
                if (file.size > 10 * 1024 * 1024) {
                    alert('File size must be less than 10MB');
                    input.value = '';
                    return;
                }
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('fileSelected').style.display = 'block';
            }
        }

        function handleDrop(event) {
            event.preventDefault();
            const uploadArea = event.currentTarget;
            uploadArea.classList.remove('dragover');
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const fileInput = document.getElementById('sample_work_file');
                fileInput.files = files;
                handleFileSelect(fileInput);
            }
        }

        function handleDragOver(event) {
            event.preventDefault();
            event.currentTarget.classList.add('dragover');
        }

        function handleDragLeave(event) {
            event.currentTarget.classList.remove('dragover');
        }

        function removeFile() {
            document.getElementById('sample_work_file').value = '';
            document.getElementById('fileSelected').style.display = 'none';
        }

        function previewUrl(input) {
            const url = input.value;
            const preview = document.getElementById('urlPreview');
            const urlText = document.getElementById('urlText');
            if (url && (url.includes('youtube.com') || url.includes('youtu.be'))) {
                urlText.textContent = url;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        }

        function handleSubmit(event) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const description = document.querySelector('textarea[name="description"]').value.trim();

            if (!description) {
                alert('Please provide a description about yourself.');
                event.preventDefault();
                return false;
            }

            if (description.length < 50) {
                alert('Please provide a more detailed description (at least 50 characters).');
                event.preventDefault();
                return false;
            }

            submitBtn.classList.add('loading');
            submitText.innerHTML = 'Completing Registration...';
            submitBtn.disabled = true;

            return true; // Let the form submit
        }

        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.querySelector('textarea[name="description"]');
            if (textarea.value) {
                updateCharCounter(textarea);
            }
            const urlInput = document.querySelector('input[name="sample_work_url"]');
            if (urlInput.value) {
                previewUrl(urlInput);
            }
        });

document.addEventListener('DOMContentLoaded', function () {
  try {
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('navLinks');
    if (!hamburger || !navLinks) return;

    hamburger.addEventListener('click', function (e) {
      e.stopPropagation();
      hamburger.classList.toggle('active');
      navLinks.classList.toggle('active');
      document.body.classList.toggle('noscroll');
    });

    navLinks.querySelectorAll('.dropdown').forEach(drop => {
      const btn = drop.querySelector('button, .dropdown-toggle');
      const menu = drop.querySelector('.dropdown-menu');
      if (!btn || !menu) return;
      btn.addEventListener('click', function (ev) {
        ev.stopPropagation();
        drop.classList.toggle('open');
        menu.classList.toggle('open');
        if (window.innerWidth <= 900 && !navLinks.classList.contains('active')) {
          navLinks.classList.add('active');
          hamburger.classList.add('active');
          document.body.classList.add('noscroll');
        }
      });
    });

    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', function () {
        if (navLinks.classList.contains('active')) {
          navLinks.classList.remove('active');
          hamburger.classList.remove('active');
          document.body.classList.remove('noscroll');
        }
      });
    });

    document.addEventListener('click', function (e) {
      if (!navLinks.contains(e.target) && !hamburger.contains(e.target)) {
        navLinks.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
      }
    });
  } catch (err) {
    console.error('Nav init error:', err);
  }
});



document.querySelectorAll('.dropdown button').forEach(btn => {
  btn.addEventListener('click', e => {
    const dropdown = btn.closest('.dropdown');
    const isActive = dropdown.classList.contains('active');
    
    // close any open popups first
    document.querySelectorAll('.dropdown.active').forEach(d => d.classList.remove('active'));

    // toggle the current one
    if (!isActive) dropdown.classList.add('active');
  });
});

// close popup when clicking outside or close button
document.addEventListener('click', e => {
  if (e.target.classList.contains('dropdown-menu')) {
    e.target.closest('.dropdown').classList.remove('active');
  }
});

    </script>
</body>

</html>
