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
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        /* Main Container */
        .personal-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 700px;
        }
        
        /* Progress Bar */
        .progress-container {
            background: #f8fafc;
            padding: 30px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .step {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-weight: 600;
            font-size: 14px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .step.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: scale(1.1);
        }
        
        .step.completed {
            background: #10b981;
            color: white;
        }
        
        .step.pending {
            background: #e2e8f0;
            color: #64748b;
        }
        
        .progress-line {
            position: absolute;
            top: 50%;
            left: 50px;
            right: 50px;
            height: 2px;
            background: #e2e8f0;
            z-index: 1;
        }
        
        .progress-line-fill {
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: width 0.3s ease;
            width: 50%; /* Step 3 of 5 */
        }
        
        .step-labels {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
            margin-top: 10px;
        }
        
        .step-label.active {
            color: #667eea;
        }
        
        .step-label.completed {
            color: #10b981;
        }
        
        /* Form Content */
        .form-content {
            padding: 40px;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .form-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }
        
        .form-subtitle {
            color: #64748b;
            font-size: 16px;
        }
        
        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }
        
        .form-input, .form-select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .form-input.with-icon {
            padding-left: 50px;
        }
        
        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            transition: color 0.3s ease;
        }
        
        .form-group:focus-within .input-icon {
            color: #667eea;
        }
        
        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 35px 0 25px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f1f5f9;
        }
        
        .section-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Two Column Layout */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        /* Animated Field */
        .animated-field {
            opacity: 0;
            transform: translateY(20px);
            animation: slideIn 0.5s ease forwards;
        }
        
        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 30px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        /* Progress Indicator */
        .field-progress {
            margin-top: 30px;
            text-align: center;
        }
        
        .progress-text {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 10px;
        }
        
        .progress-bar-container {
            background: #e5e7eb;
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: width 0.3s ease;
            width: 0%;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .personal-container {
                margin: 10px;
            }
            
            .form-content {
                padding: 30px 25px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .form-title {
                font-size: 24px;
            }
        }
        
        @media (max-width: 576px) {
            .progress-container {
                padding: 20px;
            }
            
            .step {
                width: 35px;
                height: 35px;
                font-size: 12px;
            }
            
            .step-labels {
                font-size: 10px;
            }
        }
    </style>
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
                        <select class="form-select" id="city" name="city" required onchange="updateProgress(); updateBarangay()">
                            <option value="">Select City / Municipality</option>
                            <option value="Silang" {{ old('city') == 'Silang' ? 'selected' : '' }}>Silang</option>
                            <option value="Dasmariñas" {{ old('city') == 'Dasmariñas' ? 'selected' : '' }}>Dasmariñas</option>
                            <option value="Imus" {{ old('city') == 'Imus' ? 'selected' : '' }}>Imus</option>
                            <option value="General Trias" {{ old('city') == 'General Trias' ? 'selected' : '' }}>General Trias</option>
                            <option value="Bacoor" {{ old('city') == 'Bacoor' ? 'selected' : '' }}>Bacoor</option>
                        </select>
                    </div>

                    <div class="form-group animated-field" style="animation-delay: 0.6s;">
                        <label for="province" class="form-label">
                            <i class="bi bi-map me-1"></i>Province
                        </label>
                        <input type="text" class="form-input" id="province" name="province" value="Cavite" >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group animated-field" style="animation-delay: 0.7s;" id="barangay-container">
                        <label for="barangay" class="form-label">
                            <i class="bi bi-signpost me-1"></i>Barangay
                        </label>
                        <select class="form-select" id="barangay" name="barangay" required onchange="updateProgress()">
                            <option value="">Select Barangay</option>
                        </select>
                    </div>

                    <div class="form-group animated-field" style="animation-delay: 0.8s;">
                        <label for="zip_code" class="form-label">
                            <i class="bi bi-mailbox me-1"></i>Zip Code
                        </label>
                        <input type="text" class="form-input" id="zip_code" name="zipcode" maxlength="4" required 
                               value="{{ old('zipcode') }}" oninput="updateProgress()">
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