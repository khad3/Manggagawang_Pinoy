<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/personal.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>
    <nav>
        <div class="navbar-container">
            <div class="nav-logo d-flex align-items-center">
                <a href="{{ route('display.index') }}" class="d-flex align-items-center gap-2"
                    style="text-decoration:none;">
                    <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home" />
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" />
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
                            <p class="lead text-muted">Showcase your TESDA-certified skills and connect with employers
                                who value your expertise.</p>
                        </div>

                        <!-- Progress Stepper -->
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-10">
                                <div class="d-flex align-items-center justify-content-between">

                                    <!-- Step 1 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-completed" id="step1">1</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Account</small>
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
                                        <div class="step-indicator step-active" id="step3">3</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Personal</small>
                                            <br><small class="text-muted d-none d-sm-block">Personal info</small>
                                        </div>
                                    </div>
                                    <div class="step-line" id="line4"></div>

                                    <!-- Step 4 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step4">4</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Work</small>
                                            <br><small class="text-muted d-none d-sm-block">Work details</small>
                                        </div>
                                    </div>
                                    <div class="step-line" id="line5"></div>

                                    <!-- Step 5 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step5">5</div>
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
                <div class="card-body p-4">
                    <!-- Header -->

                    <h2 class="card-title mb-2">Personal Information</h2>
                    <p class="text-muted mb-0">Help us get to know you better</p>


                    <!-- Personal Information Form -->
                    <form method="POST" action="{{ route('applicant.info.personal.stores') }}" id="personalForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $applicant->id ?? '' }}">

                        <!-- Basic Information Section -->
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-person" style="font-size: 16px;"></i>
                            </div>
                            <h3 class="section-title">Basic Information</h3>
                        </div>

                        <div class="form-row">
                            <div class="form-group animated-field" style="animation-delay: 0.1s;">
                                <label for="first_name" class="form-label">
                                    <i class="bi bi-person me-1"></i>First Name<span
                                        style="color: red;">*</span></label>
                                </label>
                                <input type="text" class="form-input" id="first_name" name="first_name" required
                                    value="{{ old('first_name') }}" oninput="updateProgress()">
                            </div>

                            <div class="form-group animated-field" style="animation-delay: 0.2s;">
                                <label for="last_name" class="form-label">
                                    <i class="bi bi-person me-1"></i>Last Name<span
                                        style="color: red;">*</span></label>
                                </label>
                                <input type="text" class="form-input" id="last_name" name="last_name" required
                                    value="{{ old('last_name') }}" oninput="updateProgress()">
                            </div>
                        </div>

                        <div class="form-group animated-field" style="animation-delay: 0.3s;">
                            <label for="gender" class="form-label">
                                <i class="bi bi-gender-ambiguous me-1"></i>Gender<span
                                    style="color: red;">*</span></label>
                            </label>
                            <select class="form-select" id="gender" name="gender" required
                                onchange="updateProgress()">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Address Section -->
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-geo-alt" style="font-size: 16px;"></i>
                            </div>
                            <h3 class="section-title">Complete Address</h3>
                        </div>

                        <div class="form-group animated-field" style="animation-delay: 0.4s;">
                            <label for="house_street" class="form-label">
                                <i class="bi bi-house me-1"></i>House No. / Street<span
                                    style="color: red;">*</span></label>
                            </label>
                            <input type="text" class="form-input" id="house_street" name="house_street" required
                                value="{{ old('house_street') }}" oninput="updateProgress()">
                        </div>

                        <div class="form-row">
                            <div class="form-group animated-field" style="animation-delay: 0.5s;">
                                <label for="city" class="form-label">
                                    <i class="bi bi-building me-1"></i>City / Municipality<span
                                        style="color: red;">*</span></label>
                                </label>
                                <select class="form-select" id="city" name="city" required
                                    onchange="updateProgress(); updateBarangay()">
                                    <option value="">Select City / Municipality</option>
                                    <option value="Alfonso" {{ old('city') == 'Alfonso' ? 'selected' : '' }}>Alfonso
                                    </option>
                                    <option value="Amadeo" {{ old('city') == 'Amadeo' ? 'selected' : '' }}>Amadeo
                                    </option>
                                    <option value="Bacoor" {{ old('city') == 'Bacoor' ? 'selected' : '' }}>Bacoor
                                    </option>
                                    <option value="Carmona" {{ old('city') == 'Carmona' ? 'selected' : '' }}>Carmona
                                    </option>
                                    <option value="Cavite City" {{ old('city') == 'Cavite City' ? 'selected' : '' }}>
                                        Cavite
                                        City</option>
                                    <option value="Dasmariñas" {{ old('city') == 'Dasmariñas' ? 'selected' : '' }}>
                                        Dasmariñas
                                    </option>
                                    <option value="General Emilio Aguinaldo"
                                        {{ old('city') == 'General Emilio Aguinaldo' ? 'selected' : '' }}>General
                                        Emilio
                                        Aguinaldo</option>
                                    <option value="General Mariano Alvarez"
                                        {{ old('city') == 'General Mariano Alvarez' ? 'selected' : '' }}>General
                                        Mariano
                                        Alvarez</option>
                                    <option value="Imus" {{ old('city') == 'Imus' ? 'selected' : '' }}>Imus</option>
                                    <option value="Indang" {{ old('city') == 'Indang' ? 'selected' : '' }}>Indang
                                    </option>
                                    <option value="Kawit" {{ old('city') == 'Kawit' ? 'selected' : '' }}>Kawit
                                    </option>
                                    <option value="Magallanes" {{ old('city') == 'Magallanes' ? 'selected' : '' }}>
                                        Magallanes
                                    </option>
                                    <option value="Maragondon" {{ old('city') == 'Maragondon' ? 'selected' : '' }}>
                                        Maragondon
                                    </option>
                                    <option value="Mendez" {{ old('city') == 'Mendez' ? 'selected' : '' }}>Mendez
                                    </option>
                                    <option value="Naic" {{ old('city') == 'Naic' ? 'selected' : '' }}>Naic</option>
                                    <option value="Noveleta" {{ old('city') == 'Noveleta' ? 'selected' : '' }}>
                                        Noveleta
                                    </option>
                                    <option value="Rosario" {{ old('city') == 'Rosario' ? 'selected' : '' }}>Rosario
                                    </option>
                                    <option value="Silang" {{ old('city') == 'Silang' ? 'selected' : '' }}>Silang
                                    </option>
                                    <option value="Tagaytay" {{ old('city') == 'Tagaytay' ? 'selected' : '' }}>
                                        Tagaytay
                                    </option>
                                    <option value="Tanza" {{ old('city') == 'Tanza' ? 'selected' : '' }}>Tanza
                                    </option>
                                    <option value="Ternate" {{ old('city') == 'Ternate' ? 'selected' : '' }}>Ternate
                                    </option>
                                    <option value="Trece Martires"
                                        {{ old('city') == 'Trece Martires' ? 'selected' : '' }}>
                                        Trece Martires</option>


                                </select>
                            </div>

                            <div class="form-group animated-field" style="animation-delay: 0.6s;">
                                <label for="province" class="form-label">
                                    <i class="bi bi-map me-1"></i>Province
                                </label>
                                <input type="text" class="form-input" id="province" name="province"
                                    value="Cavite">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group animated-field" style="animation-delay: 0.7s;"
                                id="barangay-container">
                                <label for="barangay" class="form-label">
                                    <i class="bi bi-signpost me-1"></i>Barangay<span
                                        style="color: red;">*</span></label>
                                </label>
                                <select class="form-select" id="barangay" name="barangay" required
                                    onchange="updateProgress()">
                                    <option value="">Select Barangay</option>
                                </select>
                            </div>

                            <div class="form-group animated-field" style="animation-delay: 0.8s;">
                                <label for="zip_code" class="form-label">
                                    <i class="bi bi-mailbox me-1"></i>Zip Code<span style="color: red;">*</span>
                                </label>
                                <input type="text" class="form-input" id="zip_code" name="zipcode"
                                    pattern="\d{4}" title="Please enter exactly 4 digits" maxlength="4" required
                                    value="{{ old('zipcode') }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, ''); updateProgress();">
                            </div>
                        </div>

                        <!-- Progress Indicator -->
                        <div class="field-progress">
                            <div class="progress-text">
                                <span id="completed-fields">0</span> of <span id="total-fields">8</span> fields
                                completed
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" id="progressBar"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="submit-btn" id="submitBtn" disabled>
                            <i class="bi bi-arrow-right me-2"></i>Continue to Work Information
                        </button>
                    </form>
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

                // Barangay data
                const barangayOptions = {
                    "Dasmariñas": ["Burol I", "Langkaan I", "Langkaan II", "Paliparan I", "Victoria Reyes",
                        "Salitran I", "Salitran II", "San Jose", "San Juan", "Santa Maria",
                        "Santo Cristo", "Santo Niño I", "Santo Niño II"
                    ],

                    "Alfonso": ["Esperanza Ibaba", "Esperanza Ilaya", "Kaysuyo", "Kaysuyo Ibaba",
                        "Kaysuyo Ilaya", "Kaytitinga I", "Kaytitinga II", "Kaytitinga III",
                        "Luksuhin Ibaba", "Luksuhin Ilaya", "Mangas I", "Mangas II"
                    ],

                    "Amadeo": ["Barangay I (Poblacion)", "Barangay II (Poblacion)", "Barangay III (Poblacion)",
                        "Barangay IV (Poblacion)", "Buho", "Dagatan", "Halang", "Loma", "Maitim I"
                    ],

                    "Bacoor": ["Alima", "Banalo", "Camposanto", "Daang Bukid", "Habay I", "Mambog I",
                        "Mambog II", "Queens Row East", "Queens Row West", "San Nicolas I", "San Nicolas II",
                        "San Zapote I", "Zapote II"
                    ],

                    "Carmona": ["Bancal", "Cabilang Baybay", "Lantic", "Mabuhay", "Maduya", "Milagro"],

                    "Cavite City": ["Barangay 1", "Barangay 2", "Barangay 3", "Barangay 4", "Barangay 5",
                        "Barangay 6", "Barangay 7", "Barangay 8", "Barangay 9", "Barangay 10"
                    ],

                    "General Emilio Aguinaldo": ["A. Dalusag", "Batas Dao", "Castaños Cerca (urban)",
                        "Castaños Lejos (urban)", "Kabulusan", "Kaymisas", "Kaypaaba",
                        "Lumipa", "Narvaez", "Poblacion I (urban)", "Poblacion II"
                    ],

                    "General Mariano Alvarez": ["Aldiano Olaes", "Bernardo Pulido (Area H)",
                        "Epifanio Malia", "Fiorello Calimag (Area C)", "Francisco De Castro",
                        "San Gabriel (Area K)", "San Jose", "Severino De Las Alas (Area J)",
                        "Tiniente Tiago"
                    ],

                    "General Trias": ["Bacao I", "Bacao II", "Bagumbayan (Poblacion)", "Biclatan",
                        "Buenavista I", "Buenavista II", "Buenavista III",
                        "Corregidor (Poblacion)", "Dulongbayan",
                        "Governor Ferrer (Poblacion)", "Javalera", "Manggahan"
                    ],

                    "Imus": ["Anabu I-A", "Anabu I-B", "Anabu I-C",
                        "Malagasang I-A", "Malagasang I-B", "Malagasang I-C",
                        "Medicion I-A", "Medicion I-B", "Medicion I-C",
                        "Pag-asa I", "Pag-asa II", "Pag-asa III",
                        "Poblacion I-A", "Poblacion I-B", "Poblacion I-C", "Poblacion II-A"
                    ],

                    "Indang": ["Agus-us", "Alulod", "Banaba Cerca", "Banaba Lejos", "Bancod",
                        "Mahabangkahoy Cerca", "Mahabangkahoy Lejos", "Mataas na Lupa",
                        "Pulo", "Tambo Balagbag", "Tambo Ilaya"
                    ],

                    "Kawit": ["Balsahan-Bisita", "Batong Dalig", "Binakayan-Aplaya", "Marulas",
                        "Manggahan-Lawin", "Tabon I", "Tabon II", "Tramo-Bantayan", "Wakas I"
                    ],

                    "Magallanes": ["Baliwag", "Bendita I", "Bendita II", "Barangay 1 (Poblacion)",
                        "Barangay 2 (Poblacion)", "Barangay 3 (Poblacion)", "Caluangan",
                        "Kabulusan", "Medina", "Pacheco", "Ramirez"
                    ],

                    "Maragondon": ["Bucal 1", "Bucal 2", "Bucal 3A", "Caingin Pob.", "Garita 1A",
                        "Garita 1B", "Layong Mabilog", "Mabato", "Pantihan 1",
                        "Pantihan 2", "Talipusngo", "Tulay Silangan", "Tulay Kanluran"
                    ],

                    "Mendez": ["Anuling Cerca I", "Anuling Cerca II", "Anuling Lejos I",
                        "Anuling Lejos II", "Banayad", "Bukal", "Galicia I",
                        "Galicia II", "Palocpoc I", "Palocpoc II", "Panungyan I",
                        "Panungyan II", "Poblacion I", "Poblacion II", "Poblacion III"
                    ],


                    "Naic": ["Bagong Karsada", "Balsahan", "Bancaan", "Bucana Malaki",
                        "Bucana Sasahan", "Calubcob", "Capt. C. Nazareno", "Gomez-Zamora",
                        "Latoria", "Mabolo", "Makina", "Malainen Bago", "Malainen Luma"
                    ],

                    "Noveleta": ["Magdiwang", "Poblacion", "Salcedo I", "Salcedo II",
                        "San Antonio I", "San Antonio II", "San Jose I",
                        "San Jose II", "Santa Rosa I", "Santa Rosa II"
                    ],

                    "Rosario": ["Bagbag I", "Bagbag II", "Kanluran", "Ligtong I", "Ligtong II",
                        "Muzon I", "Muzon II", "Poblacion", "Sapa I", "Sapa II",
                        "Tejeros Convention", "Wawa I", "Wawa II"
                    ],

                    "Silang": ["Acacia", "Adlas", "Anahaw I", "Anahaw II", "Biga I", "Biga II",
                        "Biluso", "Bucal", "Iba", "Inchican", "Lumil", "Maguyam", "Malabag",
                        "Mataas na Burol", "Malaking Tatiao", "Puting Kahoy", "Sabutan",
                        "San Vicente I", "San Vicente II"
                    ],

                    "Tagaytay": ["Asisan", "Bagong Tubig", "Calabuso", "Iruhin East", "Iruhin West",
                        "Mag-Asawang Ilat", "Maharlika East", "Maharlika West", "Silang Crossing East",
                        "Silang Crossing West", "Sungay East", "Sungay West"
                    ],

                    "Tanza": ["Amaya 1", "Amaya 2", "Amaya 3", "Biga", "Biwas", "Bucal",
                        "Bunga", "Calibuyo", "Julugan 1", "Julugan 2", "Julugan 3",
                        "Sahud Ulan", "Sanja Mayor", "Santol", "Tanauan", "Tres Cruses"
                    ],

                    "Ternate": ["Bucana", "Poblacion I", "Poblacion I A", "Poblacion II",
                        "Poblacion III", "San Jose", "San Juan I", "San Juan II",
                        "Sapang I", "Sapang II"
                    ],

                    "Trece Martires": ["Aguado", "Cabezas", "Cabuco", "Conchu", "De Ocampo",
                        "Gregorio", "Inocencio", "Lallana", "Lapidario", "Luciano",
                        "Osorio", "Perez", "San Agustin"
                    ]

                };

                // Update barangay dropdown
                function updateBarangay() {
                    const citySelect = document.getElementById('city');
                    const barangaySelect = document.getElementById('barangay');
                    const barangayContainer = document.getElementById('barangay-container');
                    const selectedCity = citySelect.value;

                    // Clear barangay options
                    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                    if (selectedCity && barangayOptions[selectedCity]) {
                        const barangays = barangayOptions[selectedCity];
                        barangays.forEach(function(barangay) {
                            const option = document.createElement('option');
                            option.value = barangay;
                            option.textContent = barangay;
                            barangaySelect.appendChild(option);
                        });

                        // Animate barangay container
                        barangayContainer.style.opacity = '0.5';
                        setTimeout(() => {
                            barangayContainer.style.opacity = '1';
                        }, 200);
                    }
                }

                // Update progress
                function updateProgress() {
                    const requiredFields = [
                        'first_name', 'last_name', 'gender', 'house_street',
                        'city', 'barangay', 'zip_code'
                    ];

                    let completedCount = 0;
                    const totalFields = requiredFields.length;

                    requiredFields.forEach(fieldName => {
                        const field = document.getElementById(fieldName);
                        if (field && field.value.trim() !== '') {
                            completedCount++;
                        }
                    });

                    // Update progress display
                    document.getElementById('completed-fields').textContent = completedCount;
                    document.getElementById('total-fields').textContent = totalFields;

                    const progressPercentage = (completedCount / totalFields) * 100;
                    document.getElementById('progressBar').style.width = progressPercentage + '%';

                    // Enable/disable submit button
                    const submitBtn = document.getElementById('submitBtn');
                    if (completedCount === totalFields) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Continue to Work Information';
                    } else {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="bi bi-arrow-right me-2"></i>Continue to Work Information';
                    }
                }

                // Initialize animations
                document.addEventListener('DOMContentLoaded', function() {
                    // Trigger animations for fields
                    const animatedFields = document.querySelectorAll('.animated-field');
                    animatedFields.forEach((field, index) => {
                        setTimeout(() => {
                            field.style.animationDelay = (index * 0.1) + 's';
                        }, 100);
                    });

                    // Initial progress update
                    updateProgress();

                    // Add input listeners
                    const inputs = document.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.addEventListener('input', updateProgress);
                        input.addEventListener('change', updateProgress);
                    });
                });

                // Form validation
                document.getElementById('personalForm').addEventListener('submit', function(e) {
                    const requiredFields = document.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.style.borderColor = '#ef4444';
                        } else {
                            field.style.borderColor = '#e5e7eb';
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Please fill in all required fields.');
                    }
                });

                // ======= HAMBURGER MENU FUNCTIONALITY ======= //
                document.addEventListener("DOMContentLoaded", function() {
                    const hamburger = document.getElementById("hamburger");
                    const navLinks = document.getElementById("navLinks");

                    // When hamburger is clicked
                    hamburger.addEventListener("click", function() {
                        hamburger.classList.toggle("active");
                        navLinks.classList.toggle("active");
                        document.body.classList.toggle("noscroll");
                    });

                    // Close menu when clicking a link (optional for mobile)
                    document.querySelectorAll(".nav-links a").forEach(link => {
                        link.addEventListener("click", () => {
                            if (window.innerWidth <= 992) {
                                navLinks.classList.remove("active");
                                hamburger.classList.remove("active");
                                document.body.classList.remove("noscroll");
                            }
                        });
                    });
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
