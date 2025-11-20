<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Calling Card Generator</title>
    <link rel="stylesheet" href="{{ asset('css/applicant/generate_ar_calling_card.css') }}">
</head>

<body>

    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('applicant.info.homepage.display') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>



    <div class="container">
        <div class="header">
            <div class="logo-container">
                <div class="logo">
                    <img src="{{ asset('img/logo.png') }}" alt="Company Logo">
                </div>
            </div>
            <h1>Calling Card</h1>
            <p class="subtitle">Create Your Digital Business Card</p>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <h2>📝 Enter Your Details</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">👤 Full Name</label>
                    <input type="text" id="name" placeholder="e.g., John Doe"
                        value="{{ $personalInfo->personal_info->first_name ?? '' }} {{ $personalInfo->personal_info->last_name ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="job">💼 Job Title</label>
                    <input type="text" id="job" placeholder="e.g., Senior Software Engineer"
                        value="{{ $personalInfo->work_background->position ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="email"> Email Address</label>
                    <input type="email" id="email" placeholder="e.g., john.doe@example.com"
                        value="{{ $personalInfo->email ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="number"> Phone Number</label>
                    <input type="tel" id="number" placeholder="e.g., +63 917 123 4567"
                        value="{{ $personalInfo->appliedJobs->first()->cellphone_number ?? '' }}">
                </div>
                <div class="form-group full-width">
                    <label for="location"> Location</label>
                    <input type="text" id="location" placeholder="e.g., 123 Main St, Barangay, City, Province"
                        value="{{ $personalInfo->personal_info->house_street ?? '' }} {{ $personalInfo->personal_info->barangay ?? '' }} {{ $personalInfo->personal_info->city ?? '' }} {{ $personalInfo->personal_info->province ?? '' }} ">
                </div>
            </div>
            <div class="button-group">
                <button class="btn-generate" onclick="generateCard()"><span>✨ Generate Card</span></button>
                <button class="btn-example" onclick="loadExample()"><span>📋 Load Example</span></button>
            </div>
        </div>

        <!-- Card Section -->
        <div class="card-section" id="cardSection">
            <h2>🎯 Your Professional Calling Card</h2>
            <div class="flip-card" id="callingCard">
                <div class="flip-card-inner">
                    <!-- Front Side -->
                    <div class="flip-card-front">
                        <div class="calling-card front-card">
                            <div class="card-info front-info">
                                <div class="card-row">
                                    <!-- Left: QR code + AR label -->
                                    <div class="qr-section">
                                        <div class="qr-code"></div>
                                        <div class="qr-label">Augmented Reality Portfolio</div>
                                    </div>

                                    <!-- Right: Mangagawang Pinoy + TESDA -->
                                    <div class="front-badge">
                                        <span class="badge-title">Mangagawang Pinoy</span><br>
                                        <small class="badge-sub">in partnership with TESDA</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Side -->
                    <div class="flip-card-back">
                        <div class="calling-card back-card">
                            <div class="back-card-left">
                                <div class="card-details">
                                    <div class="card-name" id="cardName">Rogelio Cerenao</div>
                                    <div class="card-job" id="cardJob">Sanitary Engineer</div>
                                </div>
                                <div class="card-info back-info">
                                    <div><span class="icon"></span><span id="cardNumber">0*******21</span></div>
                                    <div><span class="icon"></span><span id="cardEmail">rogelio.doe@example.com</span>
                                    </div>
                                    <div><span class="icon"></span><span id="cardLocation">123 Main St, Barangay,
                                            City, Province</span></div>
                                </div>
                            </div>

                            <!-- Right side: Logo only -->
                            <div class="back-card-right">
                                <img id="workerLogo" src="{{ asset('img/logo2.png') }}" crossorigin="anonymous">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="download-btn" onclick="downloadCard()">⬇️ Download Calling Card</button>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function generateCard() {
            const name = document.getElementById('name').value;
            const job = document.getElementById('job').value;
            const email = document.getElementById('email').value;
            const number = document.getElementById('number').value;
            const location = document.getElementById('location').value;

            if (!name || !job || !email || !number || !location) {
                alert('⚠️ Please fill in all fields!');
                return;
            }

            document.getElementById('cardName').textContent = name;
            document.getElementById('cardJob').textContent = job;
            document.getElementById('cardEmail').textContent = email;
            document.getElementById('cardNumber').textContent = number;
            document.getElementById('cardLocation').textContent = location;

            document.getElementById('cardSection').classList.add('show');

            setTimeout(() => {
                document.getElementById('cardSection').scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }, 100);
        }

        function loadExample() {
            document.getElementById('name').value = 'Rogelio Cerenao';
            document.getElementById('job').value = 'Sanitary Engineer';
            document.getElementById('email').value = 'rogelio@company.com';
            document.getElementById('number').value = '09*****0';
            document.getElementById('location').value =
                '123 Main Street, Barangay San Juan, Pasig City, Metro Manila';
        }

        function downloadCard() {
            const card = document.getElementById('callingCard');

            // Show loading state
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳ Generating...';
            btn.disabled = true;

            html2canvas(card, {
                scale: 3,
                backgroundColor: null,
                logging: false,
                useCORS: true,
                allowTaint: true
            }).then(canvas => {
                const link = document.createElement('a');
                const name = document.getElementById('cardName').textContent.replace(/\s+/g, '_');
                link.download = `CallingCard_${name}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();

                // Reset button
                btn.innerHTML = originalText;
                btn.disabled = false;
            }).catch(err => {
                console.error('Download error:', err);
                alert('❌ Error generating card. Please try again.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
    </script>
</body>

</html>
