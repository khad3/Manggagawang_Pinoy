<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobHub - Personal Information</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/applicant/personal.css') }}">
</head>

<body>
    <!-- Personal Information Container -->
    <div class="personal-container">
        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-steps">
                <div class="progress-line">
                    <div class="progress-line-fill"></div>
                </div>
                <div class="step completed" data-step="1">
                    <i class="bi bi-check"></i>
                </div>
                <div class="step completed" data-step="2">
                    <i class="bi bi-check"></i>
                </div>
                <div class="step active" data-step="3">3</div>
                <div class="step pending" data-step="4">4</div>
                <div class="step pending" data-step="5">5</div>
            </div>
            <div class="step-labels">
                <span class="step-label completed">Account</span>
                <span class="step-label completed">Verify</span>
                <span class="step-label active">Personal</span>
                <span class="step-label">Work</span>
                <span class="step-label">Profile</span>
            </div>
        </div>

        <!-- Form Content -->
        <div class="form-content">
            <!-- Header -->
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-person-circle" style="font-size: 28px; color: white;"></i>
                </div>
                <h2 class="form-title">Personal Information</h2>
                <p class="form-subtitle">Help us get to know you better</p>
            </div>

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
                            <i class="bi bi-person me-1"></i>First Name
                        </label>
                        <input type="text" class="form-input" id="first_name" name="first_name" required
                            value="{{ old('first_name') }}" oninput="updateProgress()">
                    </div>

                    <div class="form-group animated-field" style="animation-delay: 0.2s;">
                        <label for="last_name" class="form-label">
                            <i class="bi bi-person me-1"></i>Last Name
                        </label>
                        <input type="text" class="form-input" id="last_name" name="last_name" required
                            value="{{ old('last_name') }}" oninput="updateProgress()">
                    </div>
                </div>

                <div class="form-group animated-field" style="animation-delay: 0.3s;">
                    <label for="gender" class="form-label">
                        <i class="bi bi-gender-ambiguous me-1"></i>Gender
                    </label>
                    <select class="form-select" id="gender" name="gender" required onchange="updateProgress()">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
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
                        <i class="bi bi-house me-1"></i>House No. / Street
                    </label>
                    <input type="text" class="form-input" id="house_street" name="house_street" required
                        value="{{ old('house_street') }}" oninput="updateProgress()">
                </div>

                <div class="form-row">
                    <div class="form-group animated-field" style="animation-delay: 0.5s;">
                        <label for="city" class="form-label">
                            <i class="bi bi-building me-1"></i>City / Municipality
                        </label>
                        <select class="form-select" id="city" name="city" required
                            onchange="updateProgress(); updateBarangay()">
                            <option value="">Select City / Municipality</option>
                            <option value="Silang" {{ old('city') == 'Silang' ? 'selected' : '' }}>Silang</option>
                            <option value="Dasmariñas" {{ old('city') == 'Dasmariñas' ? 'selected' : '' }}>Dasmariñas
                            </option>
                            <option value="Imus" {{ old('city') == 'Imus' ? 'selected' : '' }}>Imus</option>
                            <option value="General Trias" {{ old('city') == 'General Trias' ? 'selected' : '' }}>
                                General Trias</option>
                            <option value="Bacoor" {{ old('city') == 'Bacoor' ? 'selected' : '' }}>Bacoor</option>
                        </select>
                    </div>

                    <div class="form-group animated-field" style="animation-delay: 0.6s;">
                        <label for="province" class="form-label">
                            <i class="bi bi-map me-1"></i>Province
                        </label>
                        <input type="text" class="form-input" id="province" name="province" value="Cavite">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group animated-field" style="animation-delay: 0.7s;" id="barangay-container">
                        <label for="barangay" class="form-label">
                            <i class="bi bi-signpost me-1"></i>Barangay
                        </label>
                        <select class="form-select" id="barangay" name="barangay" required
                            onchange="updateProgress()">
                            <option value="">Select Barangay</option>
                        </select>
                    </div>

                    <div class="form-group animated-field" style="animation-delay: 0.8s;">
                        <label for="zip_code" class="form-label">
                            <i class="bi bi-mailbox me-1"></i>Zip Code
                        </label>
                        <input type="text" class="form-input" id="zip_code" name="zipcode" maxlength="4"
                            required value="{{ old('zipcode') }}" oninput="updateProgress()">
                    </div>
                </div>

                <!-- Progress Indicator -->
                <div class="field-progress">
                    <div class="progress-text">
                        <span id="completed-fields">0</span> of <span id="total-fields">8</span> fields completed
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
        // Barangay data
        const barangayOptions = {
            "Silang": ["Lalaan I", "Lalaan II", "Biga I", "Biga II", "Pook"],
            "Dasmariñas": ["Burol", "Paliparan I", "Salitran II", "San Jose"],
            "Imus": ["Anabu I-A", "Buhay na Tubig", "Pag-asa I"],
            "General Trias": ["Manggahan", "San Francisco", "Bagumbayan"],
            "Bacoor": ["Molino I", "Panapaan V", "Zapote I"]
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
    </script>
</body>

</html>
