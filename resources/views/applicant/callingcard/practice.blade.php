<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Business Card</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aframe/1.4.0/aframe.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ar.js/2.2.2/aframe-ar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: 300;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1em;
        }

        .tabs {
            display: flex;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 5px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .tab {
            flex: 1;
            padding: 12px 20px;
            text-align: center;
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1em;
        }

        .tab.active {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .tab:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .content {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .business-card {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }

        .business-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .business-card h2 {
            margin: 0 0 10px 0;
            font-size: 2em;
            font-weight: 300;
        }

        .business-card .title {
            font-size: 1.2em;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .business-card .contact {
            font-size: 0.9em;
            opacity: 0.8;
        }

        .qr-container {
            text-align: center;
            margin: 20px 0;
        }

        .qr-container canvas {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            margin: 15px 0;
        }

        .ar-instructions {
            background: rgba(255, 193, 7, 0.2);
            border: 2px solid rgba(255, 193, 7, 0.5);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .ar-instructions h3 {
            margin-top: 0;
            color: #ffc107;
        }

        .ar-instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }

        .ar-instructions li {
            margin: 8px 0;
            line-height: 1.4;
        }

        .download-btn {
            display: inline-block;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 10px;
            border: none;
            cursor: pointer;
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .ar-scene {
            width: 100%;
            height: 400px;
            border-radius: 15px;
            overflow: hidden;
            margin: 20px 0;
        }

        .input-group {
            margin: 15px 0;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .input-group input, .input-group textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-group input::placeholder, .input-group textarea::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .input-group input:focus, .input-group textarea:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.15);
        }

        #arButton {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1.1em;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 20px 0;
        }

        #arButton:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .status {
            margin: 10px 0;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }

        .status.success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.5);
            color: #28a745;
        }

        .status.error {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 AR Business Card</h1>
            <p>Create immersive augmented reality business cards with QR codes</p>
        </div>

        <div class="tabs">
            <button class="tab active" onclick="showTab('card')">📋 Card Design</button>
            <button class="tab" onclick="showTab('qr')">📱 QR Code</button>
            <button class="tab" onclick="showTab('ar')">🎯 AR Experience</button>
        </div>

        <div class="content">
            <!-- Card Design Tab -->
            <div id="card-tab" class="tab-content active">
                <h2>Design Your Business Card</h2>
                
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" id="fullName" placeholder="John Doe" value="John Doe">
                </div>
                
                <div class="input-group">
                    <label>Job Title</label>
                    <input type="text" id="jobTitle" placeholder="CEO & Founder" value="CEO & Founder">
                </div>
                
                <div class="input-group">
                    <label>Company</label>
                    <input type="text" id="company" placeholder="TechCorp Inc." value="TechCorp Inc.">
                </div>
                
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" id="email" placeholder="john@techcorp.com" value="john@techcorp.com">
                </div>
                
                <div class="input-group">
                    <label>Phone</label>
                    <input type="tel" id="phone" placeholder="+1 (555) 123-4567" value="+1 (555) 123-4567">
                </div>
                
                <div class="input-group">
                    <label>Website</label>
                    <input type="url" id="website" placeholder="https://techcorp.com" value="https://techcorp.com">
                </div>

                <button class="download-btn" onclick="updateCard()">Update Card Preview</button>

                <div class="business-card" id="businessCard">
                    <h2 id="cardName">John Doe</h2>
                    <div class="title" id="cardTitle">CEO & Founder</div>
                    <div class="title" id="cardCompany">TechCorp Inc.</div>
                    <div class="contact">
                        <div id="cardEmail">john@techcorp.com</div>
                        <div id="cardPhone">+1 (555) 123-4567</div>
                        <div id="cardWebsite">https://techcorp.com</div>
                    </div>
                </div>
            </div>

            <!-- QR Code Tab -->
            <div id="qr-tab" class="tab-content">
                <h2>QR Code Generator</h2>
                <p>Generate a QR code that links to your AR business card experience.</p>
                
                <div class="input-group">
                    <label>AR Experience URL</label>
                    <input type="url" id="arUrl" placeholder="https://yourdomain.com/ar-card" value="https://example.com/ar-business-card">
                </div>
                
                <button class="download-btn" onclick="generateQR()">Generate QR Code</button>
                
                <div class="qr-container">
                    <canvas id="qrcode"></canvas>
                    <div>
                        <button class="download-btn" onclick="downloadQR()">Download QR Code</button>
                    </div>
                </div>
            </div>

            <!-- AR Experience Tab -->
            <div id="ar-tab" class="tab-content">
                <h2>AR Experience</h2>
                
                <div class="ar-instructions">
                    <h3>📱 How to Use AR Business Card</h3>
                    <ol>
                        <li>Click "Start AR Experience" button below</li>
                        <li>Allow camera access when prompted</li>
                        <li>Print the Hiro marker (black square pattern)</li>
                        <li>Point your camera at the marker</li>
                        <li>Watch your 3D business card appear!</li>
                    </ol>
                </div>

                <button id="arButton" onclick="startAR()">🎯 Start AR Experience</button>
                
                <div id="arStatus" class="status" style="display: none;"></div>

                <div class="ar-scene" id="arContainer" style="display: none;">
                    <a-scene 
                        arjs="sourceType: webcam; debugUIEnabled: false; detectionMode: mono_and_matrix; matrixCodeType: 3x3;"
                        vr-mode-ui="enabled: false"
                        renderer="logarithmicDepthBuffer: true; colorManagement: true; physicallyCorrectLights: true;"
                        embedded>
                        
                        <a-assets>
                            <a-mixin id="animation__click" 
                                animation__scale="property: scale; to: 1.2 1.2 1.2; dur: 200; easing: easeInOutQuad"
                                animation__scale_reverse="property: scale; to: 1 1 1; dur: 200; easing: easeInOutQuad; startEvents: animationcomplete__scale">
                            </a-mixin>
                        </a-assets>

                        <a-marker type="pattern" preset="hiro">
                            <!-- Main Card Container -->
                            <a-box 
                                position="0 0.5 0" 
                                rotation="-90 0 0" 
                                width="2" 
                                height="0.1" 
                                depth="1.2"
                                material="color: #2c3e50; metalness: 0.6; roughness: 0.4"
                                animation="property: rotation; to: -90 360 0; dur: 10000; loop: true; easing: linear">
                            </a-box>

                            <!-- Name Text -->
                            <a-text 
                                id="arName"
                                value="JOHN DOE"
                                position="0 0.8 0"
                                align="center"
                                color="#ffffff"
                                font="dejavu"
                                geometry="primitive: plane; width: auto; height: auto"
                                material="color: transparent"
                                animation="property: position; to: 0 1.2 0; dur: 2000; dir: alternate; loop: true; easing: easeInOutSine">
                            </a-text>

                            <!-- Title Text -->
                            <a-text 
                                id="arTitle"
                                value="CEO & Founder"
                                position="0 0.6 0.1"
                                align="center"
                                color="#3498db"
                                font="dejavu"
                                scale="0.8 0.8 0.8">
                            </a-text>

                            <!-- Company Text -->
                            <a-text 
                                id="arCompany"
                                value="TechCorp Inc."
                                position="0 0.4 0.1"
                                align="center"
                                color="#e74c3c"
                                font="dejavu"
                                scale="0.7 0.7 0.7">
                            </a-text>

                            <!-- Interactive Elements -->
                            <a-sphere 
                                position="-0.8 0.8 0"
                                radius="0.15"
                                color="#28a745"
                                mixin="animation__click"
                                animation="property: rotation; to: 360 360 0; dur: 3000; loop: true; easing: linear">
                            </a-sphere>

                            <a-sphere 
                                position="0.8 0.8 0"
                                radius="0.15"
                                color="#ffc107"
                                mixin="animation__click"
                                animation="property: rotation; to: -360 -360 0; dur: 3000; loop: true; easing: linear">
                            </a-sphere>

                            <!-- Floating particles -->
                            <a-box 
                                position="0 1.5 0.5"
                                width="0.1"
                                height="0.1"
                                depth="0.1"
                                color="#ffffff"
                                animation="property: position; to: 0 2.5 0.5; dur: 4000; loop: true; dir: alternate; easing: easeInOutSine">
                            </a-box>

                            <a-box 
                                position="0.3 1.2 -0.3"
                                width="0.08"
                                height="0.08"
                                depth="0.08"
                                color="#3498db"
                                animation="property: position; to: 0.3 2.2 -0.3; dur: 3500; loop: true; dir: alternate; easing: easeInOutSine">
                            </a-box>

                            <!-- Light -->
                            <a-light type="point" intensity="2" position="0 2 0"></a-light>
                        </a-marker>

                        <a-entity camera></a-entity>
                    </a-scene>
                </div>

                <div style="margin-top: 20px;">
                    <h3>📥 Download Hiro Marker</h3>
                    <p>You need to print this marker to use the AR experience:</p>
                    <a href="https://github.com/artoolkit/artoolkit5/blob/master/doc/patterns/Hiro%20pattern.pdf" 
                       target="_blank" 
                       class="download-btn">Download Hiro Marker PDF</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let qrCode = null;
        let arStarted = false;

        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked tab
            event.target.classList.add('active');
        }

        // Update business card preview
        function updateCard() {
            const name = document.getElementById('fullName').value;
            const title = document.getElementById('jobTitle').value;
            const company = document.getElementById('company').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const website = document.getElementById('website').value;

            // Update card preview
            document.getElementById('cardName').textContent = name;
            document.getElementById('cardTitle').textContent = title;
            document.getElementById('cardCompany').textContent = company;
            document.getElementById('cardEmail').textContent = email;
            document.getElementById('cardPhone').textContent = phone;
            document.getElementById('cardWebsite').textContent = website;

            // Update AR text elements if AR is started
            if (arStarted) {
                updateARContent();
            }

            showStatus('Card updated successfully!', 'success');
        }

        // Update AR content
        function updateARContent() {
            const name = document.getElementById('fullName').value.toUpperCase();
            const title = document.getElementById('jobTitle').value;
            const company = document.getElementById('company').value;

            const arName = document.querySelector('#arName');
            const arTitle = document.querySelector('#arTitle');
            const arCompany = document.querySelector('#arCompany');

            if (arName) arName.setAttribute('value', name);
            if (arTitle) arTitle.setAttribute('value', title);
            if (arCompany) arCompany.setAttribute('value', company);
        }

        // Generate QR Code
        function generateQR() {
            const url = document.getElementById('arUrl').value;
            const canvas = document.getElementById('qrcode');

            if (!url) {
                showStatus('Please enter a valid URL', 'error');
                return;
            }

            // Clear previous QR code
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

            // Generate new QR code
            QRCode.toCanvas(canvas, url, {
                width: 256,
                height: 256,
                colorDark: '#000000',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            }, function(error) {
                if (error) {
                    showStatus('Error generating QR code: ' + error, 'error');
                } else {
                    showStatus('QR code generated successfully!', 'success');
                }
            });
        }

        // Download QR Code
        function downloadQR() {
            const canvas = document.getElementById('qrcode');
            const link = document.createElement('a');
            link.download = 'ar-business-card-qr.png';
            link.href = canvas.toDataURL();
            link.click();
        }

        // Start AR Experience
        function startAR() {
            const arContainer = document.getElementById('arContainer');
            const arButton = document.getElementById('arButton');
            
            if (!arStarted) {
                // Request camera permission and start AR
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function(stream) {
                        arContainer.style.display = 'block';
                        arButton.textContent = '🛑 Stop AR Experience';
                        arStarted = true;
                        
                        // Update AR content with current card data
                        setTimeout(updateARContent, 1000);
                        
                        showStatus('AR experience started! Point your camera at the Hiro marker.', 'success');
                        
                        // Stop the stream as AR.js will handle camera access
                        stream.getTracks().forEach(track => track.stop());
                    })
                    .catch(function(err) {
                        showStatus('Camera access denied. Please allow camera access to use AR.', 'error');
                    });
            } else {
                // Stop AR experience
                arContainer.style.display = 'none';
                arButton.textContent = '🎯 Start AR Experience';
                arStarted = false;
                showStatus('AR experience stopped.', 'success');
            }
        }

        // Show status message
        function showStatus(message, type) {
            const status = document.getElementById('arStatus');
            status.textContent = message;
            status.className = 'status ' + type;
            status.style.display = 'block';
            
            // Hide after 3 seconds
            setTimeout(() => {
                status.style.display = 'none';
            }, 3000);
        }

        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            // Generate initial QR code
            generateQR();
            
            // Update card with initial values
            updateCard();

            // Auto-update card when inputs change
            const inputs = ['fullName', 'jobTitle', 'company', 'email', 'phone', 'website'];
            inputs.forEach(inputId => {
                document.getElementById(inputId).addEventListener('input', updateCard);
            });
        });
    </script>
</body>
</html>