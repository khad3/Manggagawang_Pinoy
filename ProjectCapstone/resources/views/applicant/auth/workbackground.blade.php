<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobHub - Work Background</title>
    
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
        .work-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 600px;
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
            width: 75%; /* Step 4 of 5 */
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
            margin-bottom: 30px;
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 12px;
            display: block;
            font-size: 16px;
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
        
        /* Duration Input Group */
        .duration-group {
            display: flex;
            gap: 12px;
        }
        
        .duration-group .form-input {
            flex: 2;
        }
        
        .duration-group .form-select {
            flex: 1;
        }
        
        /* Employment Status Toggle */
        .employment-toggle {
            display: flex;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 6px;
            margin-top: 12px;
        }
        
        .toggle-option {
            flex: 1;
            padding: 12px 20px;
            border: none;
            background: transparent;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .toggle-option.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }
        
        .toggle-option:not(.active) {
            color: #64748b;
        }
        
        .toggle-option:hover:not(.active) {
            background: #e2e8f0;
        }
        
        /* File Upload */
        .file-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            background: #f9fafb;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 12px;
        }
        
        .file-upload-area:hover {
            border-color: #667eea;
            background: #f0f4ff;
        }
        
        .file-upload-area.dragover {
            border-color: #667eea;
            background: #f0f4ff;
            transform: scale(1.02);
        }
        
        .upload-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .upload-text {
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }
        
        .upload-subtext {
            font-size: 14px;
            color: #6b7280;
        }
        
        .file-selected {
            margin-top: 15px;
            padding: 12px;
            background: #ecfdf5;
            border: 1px solid #d1fae5;
            border-radius: 8px;
            color: #059669;
            font-size: 14px;
            display: none;
        }
        
        /* Other Position Field */
        .other-position {
            margin-top: 15px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            max-height: 0;
            overflow: hidden;
        }
        
        .other-position.show {
            opacity: 1;
            transform: translateY(0);
            max-height: 100px;
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
            margin-top: 20px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .work-container {
                margin: 10px;
            }
            
            .form-content {
                padding: 30px 25px;
            }
            
            .duration-group {
                flex-direction: column;
                gap: 15px;
            }
            
            .employment-toggle {
                flex-direction: column;
                gap: 6px;
            }
            
            .toggle-option {
                padding: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Work Background Container -->
    <div class="work-container">
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
                <div class="step completed" data-step="3">
                    <i class="bi bi-check"></i>
                </div>
                <div class="step active" data-step="4">4</div>
                <div class="step pending" data-step="5">5</div>
            </div>
            <div class="step-labels">
                <span class="step-label completed">Account</span>
                <span class="step-label completed">Verify</span>
                <span class="step-label completed">Personal</span>
                <span class="step-label active">Work</span>
                <span class="step-label">Profile</span>
            </div>
        </div>

        <!-- Form Content -->
        <div class="form-content">
            <!-- Header -->
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-briefcase" style="font-size: 28px; color: white;"></i>
                </div>
                <h2 class="form-title">Work Background</h2>
                <p class="form-subtitle">Tell us about your professional experience</p>
            </div>

            <!-- Work Background Form -->
            <form action="{{ route('applicant.info.workbackground.store') }}" method="POST" enctype="multipart/form-data" id="workForm">
                @csrf
                <input type="hidden" name="id" value="{{ $applicant->id ?? '' }}">

                <!-- Position -->
                <div class="form-group fade-in" style="animation-delay: 0.1s;">
                    <label for="position" class="form-label">
                        <i class="bi bi-person-workspace me-2"></i>What position are you applying for?
                    </label>
                    <select class="form-select" id="position" name="position" required onchange="toggleOtherPosition()">
                        <option value="" disabled selected>Select job position</option>
                        <option value="Automotive Servicing">Automotive Servicing</option>
                        <option value="Bartender">Bartender</option>
                        <option value="Barista">Barista</option>
                        <option value="Beauty Care Specialist">Beauty Care Specialist</option>
                        <option value="Carpenter">Carpenter</option>
                        <option value="Cook">Cook</option>
                        <option value="Customer Service Representative">Customer Service Representative</option>
                        <option value="Dressmaker/Tailor">Dressmaker/Tailor</option>
                        <option value="Electrician">Electrician</option>
                        <option value="Food and Beverage Server">Food and Beverage Server</option>
                        <option value="Hairdresser">Hairdresser</option>
                        <option value="Heavy Equipment Operator">Heavy Equipment Operator</option>
                        <option value="Housekeeping">Housekeeping</option>
                        <option value="Mason">Mason</option>
                        <option value="Massage Therapist">Massage Therapist</option>
                        <option value="Mechanic">Mechanic</option>
                        <option value="Plumber">Plumber</option>
                        <option value="Security Guard">Security Guard</option>
                        <option value="SMAW Welder">SMAW Welder</option>
                        <option value="Tile Setter">Tile Setter</option>
                        <option value="Tourism Services Staff">Tourism Services Staff</option>
                        <option value="Waiter/Waitress">Waiter/Waitress</option>
                        <option value="Other">Other (Please specify)</option>
                    </select>
                    
                    <!-- Other Position Input -->
                    <div class="other-position" id="otherPositionContainer">
                        <input type="text" class="form-input" id="other_position" name="other_position" 
                               placeholder="Please specify your position">
                    </div>
                </div>

                <!-- Work Experience -->
                <div class="form-group fade-in" style="animation-delay: 0.2s;">
                    <label class="form-label">
                        <i class="bi bi-clock-history me-2"></i>How long have you been working?
                    </label>
                    <div class="duration-group">
                        <input type="number" class="form-input" id="work_duration" name="work_duration" 
                               min="0" placeholder="Enter duration" required>
                        <select class="form-select" id="work_duration_unit" name="work_duration_unit" required>
                            <option value="years" selected>Years</option>
                            <option value="months">Months</option>
                        </select>
                    </div>
                </div>

                <!-- Currently Employed -->
                <div class="form-group fade-in" style="animation-delay: 0.3s;">
                    <label class="form-label">
                        <i class="bi bi-person-check me-2"></i>Are you currently employed?
                    </label>
                    <div class="employment-toggle">
                        <button type="button" class="toggle-option" data-value="yes" onclick="setEmploymentStatus('yes')">
                            <i class="bi bi-check-circle me-1"></i>Yes, I am employed
                        </button>
                        <button type="button" class="toggle-option" data-value="no" onclick="setEmploymentStatus('no')">
                            <i class="bi bi-x-circle me-1"></i>No, I'm not employed
                        </button>
                    </div>
                    <input type="hidden" name="employed" id="employed" required>
                </div>

                <!-- Profile Picture Upload -->
                <div class="form-group fade-in" style="animation-delay: 0.4s;">
                    <label class="form-label">
                        <i class="bi bi-camera me-2"></i>Upload Profile Picture
                        <span style="font-weight: 400; color: #6b7280; font-size: 14px;">(Optional)</span>
                    </label>
                    
                    <div class="file-upload-area" onclick="document.getElementById('profile_picture').click()" 
                         ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-upload" style="color: white; font-size: 20px;"></i>
                        </div>
                        <div class="upload-text">Click to upload or drag and drop</div>
                        <div class="upload-subtext">PNG, JPG, GIF up to 5MB</div>
                        
                        <div class="file-selected" id="fileSelected">
                            <i class="bi bi-check-circle me-1"></i>
                            <span id="fileName"></span>
                        </div>
                    </div>
                    
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" 
                           style="display: none;" onchange="handleFileSelect(this)">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn" id="submitBtn" disabled>
                    <i class="bi bi-arrow-right me-2"></i>Continue to Profile Setup
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle other position field
        function toggleOtherPosition() {
            const positionSelect = document.getElementById("position");
            const otherContainer = document.getElementById("otherPositionContainer");
            const otherInput = document.getElementById("other_position");

            if (positionSelect.value === "Other") {
                otherContainer.classList.add("show");
                otherInput.setAttribute("required", "required");
            } else {
                otherContainer.classList.remove("show");
                otherInput.removeAttribute("required");
                otherInput.value = "";
            }
            
            validateForm();
        }

        // Set employment status
        function setEmploymentStatus(status) {
            const buttons = document.querySelectorAll('.toggle-option');
            const hiddenInput = document.getElementById('employed');
            
            buttons.forEach(btn => btn.classList.remove('active'));
            document.querySelector(`[data-value="${status}"]`).classList.add('active');
            hiddenInput.value = status;
            
            validateForm();
        }

        // File upload handlers
        function handleFileSelect(input) {
            const file = input.files[0];
            if (file) {
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
                const fileInput = document.getElementById('profile_picture');
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

        // Form validation
        function validateForm() {
            const position = document.getElementById('position').value;
            const workDuration = document.getElementById('work_duration').value;
            const workDurationUnit = document.getElementById('work_duration_unit').value;
            const employed = document.getElementById('employed').value;
            const otherPosition = document.getElementById('other_position');
            
            let isValid = true;
            
            // Check required fields
            if (!position || !workDuration || !workDurationUnit || !employed) {
                isValid = false;
            }
            
            // Check other position if "Other" is selected
            if (position === "Other" && (!otherPosition.value || !otherPosition.value.trim())) {
                isValid = false;
            }
            
            // Enable/disable submit button
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = !isValid;
            
            if (isValid) {
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Continue to Profile Setup';
            } else {
                submitBtn.innerHTML = '<i class="bi bi-arrow-right me-2"></i>Continue to Profile Setup';
            }
        }

        // Initialize form
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners for form validation
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('input', validateForm);
                input.addEventListener('change', validateForm);
            });
            
            // Work duration unit change handler
            document.getElementById('work_duration_unit').addEventListener('change', function() {
                const durationInput = document.getElementById('work_duration');
                if (this.value === 'months') {
                    durationInput.placeholder = 'Enter months (max 11)';
                    durationInput.max = 11;
                } else {
                    durationInput.placeholder = 'Enter years';
                    durationInput.removeAttribute('max');
                }
            });
            
            // Initial validation
            validateForm();
        });

        // Form submission handler
        document.getElementById('workForm').addEventListener('submit', function(e) {
            if (!document.getElementById('employed').value) {
                e.preventDefault();
                alert('Please select your current employment status.');
                return;
            }
            
            const position = document.getElementById('position').value;
            const otherPosition = document.getElementById('other_position').value;
            
            if (position === 'Other' && !otherPosition.trim()) {
                e.preventDefault();
                alert('Please specify your position.');
                return;
            }
        });
    </script>
</body>
</html>