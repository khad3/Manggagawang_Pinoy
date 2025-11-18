<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Calling Card Generator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e40af 50%, #3b82f6 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(147, 197, 253, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeInDown 0.8s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-container {
            margin-bottom: 25px;
        }

        .logo {
            width: 140px;
            height: 140px;
            background: blue;
            border-radius: 30px;
            padding: 20px;
            display: inline-block;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        h1 {
            color: white;
            font-size: 3.2em;
            text-shadow:
                0 2px 10px rgba(0, 0, 0, 0.3),
                0 0 30px rgba(59, 130, 246, 0.5);
            margin-bottom: 15px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.3em;
            font-weight: 400;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .form-section {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 25px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            margin-bottom: 40px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-section h2 {
            color: #1e40af;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #1e40af;
            font-weight: 600;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input {
            width: 100%;
            padding: 16px;
            border: 2px solid #e0e7ff;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            flex-wrap: wrap;
        }

        button {
            flex: 1;
            min-width: 200px;
            padding: 18px 30px;
            border: none;
            border-radius: 14px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        button:hover::before {
            width: 300px;
            height: 300px;
        }

        button span {
            position: relative;
            z-index: 1;
        }

        .btn-generate {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
        }

        .btn-generate:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.4);
        }

        .btn-generate:active {
            transform: translateY(-1px);
        }

        .btn-example {
            background: white;
            color: #2563eb;
            border: 2px solid #2563eb;
            box-shadow: 0 5px 20px rgba(37, 99, 235, 0.1);
        }

        .btn-example:hover {
            background: #eff6ff;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
        }

        .card-section {
            display: none;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 25px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(59, 130, 246, 0.3);
        }

        .card-section.show {
            display: block;
            animation: fadeInUp 0.8s ease;
        }

        .card-section h2 {
            color: #1e40af;
            margin-bottom: 40px;
            text-align: center;
            font-size: 2em;
            font-weight: 700;
        }

        .calling-card {
            max-width: 750px;
            margin: 0 auto 35px;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            border-radius: 25px;
            padding: 50px;
            color: white;
            box-shadow:
                0 25px 70px rgba(30, 58, 138, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .calling-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle, rgba(147, 197, 253, 0.15) 0%, transparent 70%);
            animation: rotateGlow 40s linear infinite;
        }

        @keyframes rotateGlow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .card-header {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .card-logo {
            width: 80px;
            height: 80px;
            background: blue;
            border-radius: 16px;
            padding: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .card-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
        }

        .card-info {
            flex: 1;
        }

        .card-name {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 12px;
            text-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .card-job {
            font-size: 20px;
            margin-bottom: 30px;
            opacity: 0.95;
            font-weight: 600;
        }

        .card-details {
            font-size: 15px;
            line-height: 2.2;
        }

        .card-details div {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 16px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }

        .icon {
            font-size: 20px;
            width: 24px;
            display: inline-flex;
            justify-content: center;
            flex-shrink: 0;
        }

        .qr-section {
            background: white;
            padding: 22px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            min-width: 200px;
            flex-shrink: 0;
        }

        .qr-code {
            width: 180px;
            height: 180px;
            background: url('https://blog.logrocket.com/wp-content/uploads/2023/01/hiro-image.png') center/cover no-repeat;
            border-radius: 12px;
            border: 4px solid #e0e7ff;
        }

        .qr-label {
            text-align: center;
            color: #1e40af;
            font-size: 14px;
            margin-top: 12px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .download-btn {
            display: block;
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
        }

        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.4);
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .header {
                margin-bottom: 30px;
            }

            .logo {
                width: 100px;
                height: 100px;
                border-radius: 20px;
                padding: 15px;
            }

            h1 {
                font-size: 2em;
                margin-bottom: 10px;
            }

            .subtitle {
                font-size: 1em;
            }

            .form-section {
                padding: 25px 20px;
                border-radius: 20px;
                margin-bottom: 25px;
            }

            .form-section h2 {
                font-size: 1.5em;
                margin-bottom: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            label {
                font-size: 14px;
                margin-bottom: 8px;
            }

            input {
                padding: 14px;
                font-size: 15px;
            }

            .button-group {
                gap: 12px;
                margin-top: 25px;
            }

            button {
                min-width: 100%;
                padding: 16px 25px;
                font-size: 16px;
            }

            .card-section {
                padding: 25px 15px;
                border-radius: 20px;
            }

            .card-section h2 {
                font-size: 1.5em;
                margin-bottom: 25px;
            }

            .calling-card {
                padding: 25px 20px;
                border-radius: 20px;
                margin-bottom: 25px;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                margin-bottom: 20px;
                padding-bottom: 20px;
            }

            .card-logo {
                width: 60px;
                height: 60px;
                border-radius: 12px;
                padding: 10px;
            }

            .card-badge {
                padding: 6px 16px;
                font-size: 11px;
                letter-spacing: 1px;
            }

            .card-content {
                flex-direction: column;
                gap: 25px;
                align-items: center;
            }

            .card-info {
                width: 100%;
            }

            .card-name {
                font-size: 24px;
                margin-bottom: 10px;
            }

            .card-job {
                font-size: 16px;
                margin-bottom: 20px;
            }

            .card-details {
                font-size: 13px;
                line-height: 1.8;
            }

            .card-details div {
                margin-bottom: 10px;
                padding: 10px 12px;
                gap: 10px;
                flex-wrap: wrap;
            }

            .icon {
                font-size: 18px;
                width: 20px;
            }

            .qr-section {
                padding: 18px;
                min-width: auto;
                width: 100%;
                max-width: 220px;
            }

            .qr-code {
                width: 150px;
                height: 150px;
                margin: 0 auto;
            }

            .qr-label {
                font-size: 12px;
                margin-top: 10px;
            }

            .download-btn {
                max-width: 100%;
                padding: 18px;
                font-size: 16px;
            }
        }

        /* Extra small devices (phones, 480px and down) */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .logo {
                width: 80px;
                height: 80px;
            }

            h1 {
                font-size: 1.6em;
            }

            .subtitle {
                font-size: 0.9em;
            }

            .form-section {
                padding: 20px 15px;
            }

            .form-section h2 {
                font-size: 1.3em;
            }

            .calling-card {
                padding: 20px 15px;
            }

            .card-name {
                font-size: 20px;
                word-break: break-word;
            }

            .card-job {
                font-size: 14px;
            }

            .card-details {
                font-size: 12px;
            }

            .card-details div {
                padding: 8px 10px;
            }

            .qr-code {
                width: 130px;
                height: 130px;
            }
        }

        /* Landscape orientation on mobile */
        @media (max-width: 768px) and (orientation: landscape) {
            .calling-card {
                padding: 30px 25px;
            }

            .card-content {
                flex-direction: row;
                gap: 20px;
            }

            .card-name {
                font-size: 20px;
            }

            .card-job {
                font-size: 14px;
                margin-bottom: 15px;
            }

            .card-details div {
                margin-bottom: 8px;
                padding: 8px 12px;
            }

            .qr-section {
                max-width: 160px;
            }

            .qr-code {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>

<body>
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
                    <label for="email">📧 Email Address</label>
                    <input type="email" id="email" placeholder="e.g., john.doe@example.com"
                        value="{{ $personalInfo->email ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="number">📱 Phone Number</label>
                    <input type="tel" id="number" placeholder="e.g., +63 917 123 4567"
                        value="{{ $personalInfo->appliedJobs->first()->cellphone_number ?? '' }}">
                </div>
                <div class="form-group full-width">
                    <label for="location">📍 Location</label>
                    <input type="text" id="location" placeholder="e.g., 123 Main St, Barangay, City, Province, 1234"
                        value="{{ $personalInfo->personal_info->house_street ?? '' }} {{ $personalInfo->personal_info->barangay ?? '' }} {{ $personalInfo->personal_info->city ?? '' }} {{ $personalInfo->personal_info->province ?? '' }} {{ $personalInfo->personal_info->zipcode ?? '' }}">
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
            <div class="calling-card" id="callingCard">
                <div class="card-header">
                    <div class="card-logo">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo">
                    </div>
                    <div class="card-badge">BUSINESS CARD</div>
                </div>
                <div class="card-content">
                    <div class="card-info">
                        <div class="card-name" id="cardName">Rogelio Cerenao</div>
                        <div class="card-job" id="cardJob">Sanitary Engineer</div>
                        <div class="card-details">
                            <div>
                                <span class="icon">📧</span>
                                <span id="cardEmail">rogelio.doe@example.com</span>
                            </div>
                            <div>
                                <span class="icon">📱</span>
                                <span id="cardNumber">0*******21</span>
                            </div>
                            <div>
                                <span class="icon">📍</span>
                                <span id="cardLocation">123 Main St, Barangay, City, Province</span>
                            </div>
                        </div>
                    </div>
                    <div class="qr-section">
                        <div class="qr-code"></div>
                        <div class="qr-label">SCAN ME</div>
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
                '123 Main Street, Barangay San Juan, Pasig City, Metro Manila, 1600';
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
