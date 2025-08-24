<!DOCTYPE html>
<html>
<head>
  <title>AR Business Card Generator</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      min-height: 100vh;
    }
    .container {
      background: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 15px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 28px;
    }
    .form-section {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 30px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      font-size: 16px;
    }
    input[type="text"] {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      background: rgba(255, 255, 255, 0.9);
      box-sizing: border-box;
      color: #333;
    }
    .generate-btn {
      background: linear-gradient(45deg, #ff6b6b, #ee5a24);
      color: white;
      padding: 20px 40px;
      border: none;
      border-radius: 25px;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      margin: 30px 0;
      transition: all 0.3s;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .generate-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(255, 107, 107, 0.3);
    }
    .business-card-preview {
      display: none;
      background: white;
      color: black;
      border-radius: 15px;
      padding: 30px;
      margin-top: 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      position: relative;
      overflow: hidden;
    }
    .card-content {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 30px;
      align-items: center;
    }
    .card-info h3 {
      font-size: 28px;
      margin: 0 0 10px 0;
      color: #333;
    }
    .card-info .title {
      font-size: 18px;
      color: #666;
      margin-bottom: 20px;
    }
    .card-info .contact {
      font-size: 16px;
      line-height: 1.6;
    }
    .card-info .contact div {
      margin-bottom: 8px;
    }
    .card-qr {
      text-align: center;
    }
    .card-qr canvas {
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .card-qr p {
      margin-top: 10px;
      font-size: 12px;
      color: #666;
      font-weight: bold;
    }
    .profile-image {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #ddd;
      display: none;
    }
    .download-section {
      text-align: center;
      margin-top: 30px;
    }
    .download-btn {
      background: linear-gradient(45deg, #4CAF50, #45a049);
      color: white;
      padding: 15px 30px;
      border: none;
      border-radius: 25px;
      font-size: 18px;
      cursor: pointer;
      margin: 10px;
      transition: all 0.3s;
    }
    .download-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
    }
    .instructions {
      background: rgba(255, 255, 255, 0.1);
      padding: 25px;
      border-radius: 15px;
      margin-top: 30px;
      line-height: 1.8;
    }
    .highlight {
      background: rgba(255, 255, 0, 0.2);
      padding: 2px 6px;
      border-radius: 4px;
      font-weight: bold;
    }
    .test-ar-btn {
      background: linear-gradient(45deg, #9c27b0, #673ab7);
      color: white;
      padding: 15px 30px;
      border: none;
      border-radius: 25px;
      font-size: 18px;
      cursor: pointer;
      margin: 10px;
      transition: all 0.3s;
    }
    .test-ar-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(156, 39, 176, 0.3);
    }
    .ar-experience {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #000;
      z-index: 10000;
    }
    @media (max-width: 768px) {
      .form-section {
        grid-template-columns: 1fr;
      }
      .card-content {
        grid-template-columns: 1fr;
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>🎯 AR Business Card Generator</h2>
    <p style="text-align: center; font-size: 18px; margin-bottom: 30px;">
      Create a business card with QR code that shows your photo and YouTube link in AR!
    </p>
    
    <div class="form-section">
      <div>
        <div class="form-group">
          <label>👤 Full Name:</label>
          <input id="name" type="text" placeholder="John Doe">
        </div>
        
        <div class="form-group">
          <label>💼 Job Title:</label>
          <input id="title" type="text" placeholder="Software Developer">
        </div>
        
        <div class="form-group">
          <label>📧 Email:</label>
          <input id="email" type="text" placeholder="john@example.com">
        </div>
      </div>
      
      <div>
        <div class="form-group">
          <label>📺 YouTube Channel:</label>
          <input id="youtube" type="text" placeholder="https://youtube.com/@johndoe">
        </div>
        
        <div class="form-group">
          <label>📸 Profile Image URL:</label>
          <input id="photo" type="text" placeholder="https://example.com/photo.jpg">
        </div>
        
        <div class="form-group">
          <label>🎨 Card Background Color:</label>
          <input id="cardColor" type="text" placeholder="#ffffff" value="#ffffff">
        </div>
      </div>
    </div>
    
    <button class="generate-btn" onclick="generateCompleteCard()">
      🚀 Generate AR Business Card
    </button>
    
    <div class="business-card-preview" id="cardPreview">
      <div class="card-content">
        <div class="card-info">
          <img id="previewPhoto" class="profile-image" />
          <h3 id="previewName">Your Name</h3>
          <div class="title" id="previewTitle">Your Title</div>
          <div class="contact">
            <div>📧 <span id="previewEmail">your@email.com</span></div>
            <div>📺 <span id="previewYoutube">YouTube Channel</span></div>
          </div>
        </div>
        <div class="card-qr">
          <div id="qrcode"></div>
          <p>📱 Scan for AR Experience</p>
        </div>
      </div>
    </div>
    
    <div class="download-section" id="downloadSection" style="display: none;">
      <h3>📱 Test with Your Phone:</h3>
      <div style="background: rgba(255,255,0,0.1); padding: 15px; border-radius: 10px; margin: 15px 0;">
        <strong>🔍 Easy Phone Testing:</strong><br>
        1. <strong>Take a screenshot</strong> of the business card above (with QR code)<br>
        2. <strong>Open camera app</strong> on your phone<br>
        3. <strong>Point camera at QR code</strong> on your screen<br>
        4. <strong>Tap the notification</strong> to open AR experience<br>
        5. <strong>See your photo & YouTube</strong> appear in 3D AR!
      </div>
      <button class="download-btn" onclick="downloadBusinessCard()">💳 Download Business Card (PNG)</button>
      <button class="test-ar-btn" onclick="testARExperience()">🎯 Test AR Experience</button>
      <button class="download-btn" onclick="downloadARFile()">📱 Download AR Experience (HTML)</button>
      <button class="test-ar-btn" onclick="showQRFullscreen()">📱 Show QR Code Fullscreen</button>
    </div>
    
    <div class="instructions">
      <h3>📱 How This Works:</h3>
      <p>This creates a <span class="highlight">COMPLETE AR solution</span>:</p>
      <ol style="font-size: 16px; line-height: 2;">
        <li>🎨 <strong>Business Card</strong> - Beautiful card with QR code</li>
        <li>📱 <strong>QR Code</strong> - Points to this same page with your data</li>
        <li>🎯 <strong>AR Experience</strong> - Shows your photo and YouTube link in 3D</li>
        <li>🚀 <strong>Instant AR</strong> - Works immediately when scanned!</li>
      </ol>
      <p style="margin-top: 20px; font-size: 16px; background: rgba(255,255,0,0.1); padding: 15px; border-radius: 10px;">
        <strong>🔧 SIMPLE SETUP:</strong><br>
        1. Generate your card above<br>
        2. Test the AR experience using the "Test AR" button<br>
        3. <strong>Result:</strong> Scan QR → Camera opens → Your photo & YouTube link appear in AR!
      </p>
    </div>
  </div>

  <!-- Hidden AR Experience -->
  <div class="ar-experience" id="arExperience">
    <div id="arContainer"></div>
  </div>
  
  <script>
    let currentCardData = {};
    
    // Check if accessed via QR code
    window.addEventListener('load', function() {
      const params = new URLSearchParams(window.location.search);
      if (params.get('ar') === 'true') {
        // Load AR experience with data from URL
        const arData = {
          name: decodeURIComponent(params.get('name') || 'Your Name'),
          title: decodeURIComponent(params.get('title') || 'Your Title'),
          email: decodeURIComponent(params.get('email') || 'your@email.com'),
          youtube: decodeURIComponent(params.get('youtube') || 'https://youtube.com/@yourchannel'),
          photo: decodeURIComponent(params.get('photo') || ''),
          cardColor: decodeURIComponent(params.get('cardColor') || '#ffffff')
        };
        showARExperience(arData);
      }
    });
    
    function generateCompleteCard() {
      // Get form data
      currentCardData = {
        name: document.getElementById('name').value || 'Your Name',
        title: document.getElementById('title').value || 'Your Title',
        email: document.getElementById('email').value || 'your@email.com',
        youtube: document.getElementById('youtube').value || 'https://youtube.com/@yourchannel',
        photo: document.getElementById('photo').value || '',
        cardColor: document.getElementById('cardColor').value || '#ffffff'
      };
      
      // Create QR code URL with parameters
      const qrUrl = createQRUrl(currentCardData);
      
      // Update preview
      updateCardPreview(currentCardData, qrUrl);
      
      // Show preview and download options
      document.getElementById('cardPreview').style.display = 'block';
      document.getElementById('downloadSection').style.display = 'block';
      
      // Scroll to preview
      document.getElementById('cardPreview').scrollIntoView({ behavior: 'smooth' });
    }
    
    function createQRUrl(data) {
      const baseUrl = window.location.href.split('?')[0];
      const params = new URLSearchParams({
        ar: 'true',
        name: encodeURIComponent(data.name),
        title: encodeURIComponent(data.title),
        email: encodeURIComponent(data.email),
        youtube: encodeURIComponent(data.youtube),
        photo: encodeURIComponent(data.photo),
        cardColor: encodeURIComponent(data.cardColor)
      });
      return baseUrl + '?' + params.toString();
    }
    
    function updateCardPreview(data, qrUrl) {
      document.getElementById('previewName').textContent = data.name;
      document.getElementById('previewTitle').textContent = data.title;
      document.getElementById('previewEmail').textContent = data.email;
      document.getElementById('previewYoutube').textContent = 'YouTube Channel';
      
      const photoImg = document.getElementById('previewPhoto');
      if (data.photo) {
        photoImg.src = data.photo;
        photoImg.style.display = 'block';
      } else {
        photoImg.style.display = 'none';
      }
      
      // Generate QR code
      const qrContainer = document.getElementById('qrcode');
      qrContainer.innerHTML = '';
      
      try {
        const canvas = document.createElement('canvas');
        new QRious({
          element: canvas,
          value: qrUrl,
          size: 150,
          foreground: '#333',
          background: '#fff'
        });
        qrContainer.appendChild(canvas);
      } catch (error) {
        qrContainer.innerHTML = '<div style="width:150px;height:150px;background:#ddd;display:flex;align-items:center;justify-content:center;">QR Code</div>';
      }
    }
    
    function showARExperience(data) {
      const arContainer = document.getElementById('arContainer');
      arContainer.innerHTML = createARContent(data);
      document.getElementById('arExperience').style.display = 'block';
      
      // Load AR scripts
      loadARScripts();
    }
    
    function createARContent(data) {
      return `
        <style>
          .ar-overlay { 
            position: fixed; top: 10px; left: 10px; right: 10px; 
            background: rgba(0,0,0,0.9); color: white; padding: 15px; 
            border-radius: 10px; z-index: 1000; font-size: 14px; 
          }
          .ar-instructions { 
            position: fixed; bottom: 10px; left: 10px; right: 10px; 
            background: rgba(0,0,0,0.9); color: white; padding: 15px; 
            border-radius: 10px; text-align: center; z-index: 1000; font-size: 14px; 
          }
          .contact-links a { color: #4fc3f7; text-decoration: none; }
          .start-camera { 
            position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            background: #ff6b6b; color: white; padding: 20px 30px; border: none;
            border-radius: 25px; font-size: 18px; cursor: pointer; z-index: 1000; 
          }
          .youtube-button {
            position: fixed; top: 70px; right: 10px; z-index: 1001;
            background: #ff0000; color: white; padding: 10px 15px;
            border: none; border-radius: 20px; font-size: 14px; cursor: pointer;
            text-decoration: none; display: inline-block;
          }
          .close-ar {
            position: fixed; top: 10px; right: 10px; z-index: 1001;
            background: #333; color: white; padding: 10px; border: none;
            border-radius: 50%; width: 40px; height: 40px; cursor: pointer;
            font-size: 16px;
          }
        </style>
        
        <button class="close-ar" onclick="closeAR()">×</button>
        
        <div id="loading" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-align: center; z-index: 1000;">
          <h2>🎯 ${data.name}'s AR Business Card!</h2>
          <p>Tap to start camera and see the magic!</p>
          <button class="start-camera" onclick="startAR()">📱 Start AR Camera</button>
        </div>
        
        <div class="ar-overlay" id="arInfo" style="display:none;">
          <strong>${data.name}</strong> - ${data.title}<br>
          <div class="contact-links">
            📧 <a href="mailto:${data.email}">${data.email}</a>
          </div>
        </div>
        
        <a href="${data.youtube}" target="_blank" class="youtube-button" id="youtubeBtn" style="display:none;">
          📺 Watch YouTube
        </a>
        
        <div class="ar-instructions" id="arInstructions" style="display:none;">
          🎯 Point your camera at any flat surface to see the 3D business card!<br>
          ${data.photo ? '📸 Your photo and info will appear in AR!' : 'Your info will appear in AR!'}
        </div>

        <a-scene id="arScene" embedded arjs="sourceType: webcam; debugUIEnabled: false; trackingMethod: best;" 
                 renderer="antialias: true; alpha: true; precision: medium;" vr-mode-ui="enabled: false" style="display:none;">
          
          <a-assets>
            ${data.photo ? `<img id="profileImg" src="${data.photo}" crossorigin="anonymous">` : ''}
          </a-assets>

          <a-marker preset="hiro">
            <!-- Main card background -->
            <a-plane color="${data.cardColor}" height="2.5" width="4" position="0 0 0" shadow="receive: true"></a-plane>
            <a-plane color="#333333" height="2.6" width="4.1" position="0 0 -0.001"></a-plane>
            
            <!-- Text information -->
            <a-text value="${data.name}" color="#333333" align="center" position="0 0.8 0.01" scale="1.5 1.5 1"></a-text>
            <a-text value="${data.title}" color="#666666" align="center" position="0 0.4 0.01" scale="1 1 1"></a-text>
            <a-text value="📧 ${data.email}" color="#444444" align="center" position="0 0 0.01" scale="0.8 0.8 1"></a-text>
            
            <!-- YouTube link -->
            <a-text value="📺 YouTube Channel" color="#ff0000" align="center" position="0 -0.4 0.01" scale="0.9 0.9 1"
                    animation="property: scale; from: 0.9 0.9 1; to: 1.1 1.1 1; loop: true; dir: alternate; dur: 2000"></a-text>
            
            <!-- Profile image or placeholder -->
            ${data.photo ? 
            `<a-image src="#profileImg" position="0 1.5 0.01" width="1.5" height="1.5" 
                     animation="property: rotation; from: 0 0 0; to: 0 360 0; loop: true; dur: 10000"></a-image>` : 
            `<a-sphere color="#4fc3f7" radius="0.3" position="0 1.5 0.2"
                      animation="property: position; from: 0 1.5 0.2; to: 0 2 0.2; loop: true; dir: alternate; dur: 3000"></a-sphere>`}
            
            <!-- Decorative elements -->
            <a-box color="#ff6b6b" width="0.2" height="0.2" depth="0.2" position="2 -1 0.5" 
                   animation="property: rotation; to: 360 360 360; loop: true; dur: 4000"></a-box>
            <a-cylinder color="#2ecc71" radius="0.1" height="0.3" position="-2 -1 0.3" 
                        animation="property: scale; from: 1 1 1; to: 1.3 1.3 1.3; loop: true; dir: alternate; dur: 2000"></a-cylinder>
          </a-marker>

          <a-entity camera></a-entity>
        </a-scene>
      `;
    }
    
    function loadARScripts() {
      if (!document.querySelector('script[src*="aframe"]')) {
        const aframeScript = document.createElement('script');
        aframeScript.src = 'https://aframe.io/releases/1.3.0/aframe.min.js';
        aframeScript.onload = function() {
          const arScript = document.createElement('script');
          arScript.src = 'https://raw.githack.com/AR-js-org/AR.js/3.4.5/aframe/build/aframe-ar.js';
          document.head.appendChild(arScript);
        };
        document.head.appendChild(aframeScript);
      }
    }
    
    function startAR() {
      document.getElementById("loading").style.display = "none";
      document.getElementById("arScene").style.display = "block";
      document.getElementById("arInfo").style.display = "block";
      document.getElementById("arInstructions").style.display = "block";
      document.getElementById("youtubeBtn").style.display = "block";
      
      if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ 
          video: { 
            facingMode: "environment",
            width: { ideal: 1280 },
            height: { ideal: 720 }
          } 
        })
        .then(function(stream) { 
          console.log("Camera access granted"); 
        })
        .catch(function(err) { 
          console.log("Camera access denied:", err);
          alert("Please allow camera access to use AR!");
        });
      }
    }
    
    function showQRFullscreen() {
      const qrCanvas = document.querySelector('#qrcode canvas');
      if (!qrCanvas) {
        alert('Please generate the business card first!');
        return;
      }
      
      // Create fullscreen overlay
      const overlay = document.createElement('div');
      overlay.style.cssText = `
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.95); z-index: 10000; display: flex;
        align-items: center; justify-content: center; flex-direction: column;
      `;
      
      // Clone and enlarge QR code
      const largeQR = qrCanvas.cloneNode(true);
      const size = Math.min(window.innerWidth * 0.8, window.innerHeight * 0.8, 400);
      largeQR.style.cssText = `width: ${size}px; height: ${size}px; border-radius: 15px; box-shadow: 0 10px 30px rgba(255,255,255,0.3);`;
      
      // Add instructions
      const instructions = document.createElement('div');
      instructions.style.cssText = 'color: white; text-align: center; margin-top: 30px; font-size: 18px; line-height: 1.6;';
      instructions.innerHTML = `
        <h3 style="margin: 0 0 15px 0;">📱 Scan with Your Phone Camera</h3>
        <p style="margin: 5px 0;">Point your phone camera at this QR code</p>
        <p style="margin: 5px 0;">Tap the notification to open AR experience</p>
        <p style="margin: 15px 0; font-size: 16px; opacity: 0.8;">Tap anywhere to close</p>
      `;
      
      overlay.appendChild(largeQR);
      overlay.appendChild(instructions);
      
      // Close on click
      overlay.addEventListener('click', () => {
        document.body.removeChild(overlay);
      });
      
      document.body.appendChild(overlay);
    }
    
    function closeAR() {
      document.getElementById('arExperience').style.display = 'none';
      window.location.href = window.location.href.split('?')[0];
    }
    
    function testARExperience() {
      showARExperience(currentCardData);
    }
    
    function downloadBusinessCard() {
      try {
        // Get the actual QR code from the preview
        const qrCanvas = document.querySelector('#qrcode canvas');
        if (!qrCanvas) {
          alert('Please generate the business card first to create the QR code!');
          return;
        }
        
        // Create a canvas for the business card
        const canvas = document.createElement('canvas');
        canvas.width = 800;
        canvas.height = 500;
        const ctx = canvas.getContext('2d');
        
        // Fill background
        ctx.fillStyle = currentCardData.cardColor || '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Add border
        ctx.strokeStyle = '#333';
        ctx.lineWidth = 3;
        ctx.strokeRect(10, 10, canvas.width-20, canvas.height-20);
        
        // Add text
        ctx.fillStyle = '#333';
        ctx.font = 'bold 32px Arial';
        ctx.fillText(currentCardData.name, 50, 100);
        
        ctx.font = '24px Arial';
        ctx.fillStyle = '#666';
        ctx.fillText(currentCardData.title, 50, 140);
        
        ctx.font = '18px Arial';
        ctx.fillStyle = '#444';
        ctx.fillText('📧 ' + currentCardData.email, 50, 180);
        ctx.fillText('📺 YouTube Channel', 50, 210);
        
        // Draw the actual QR code
        ctx.drawImage(qrCanvas, 600, 150, 150, 150);
        
        // Add QR code label
        ctx.fillStyle = '#333';
        ctx.font = '14px Arial';
        ctx.fillText('Scan for AR Experience', 580, 320);
        
        // Download the canvas
        const link = document.createElement('a');
        link.download = currentCardData.name.replace(/\s+/g, '-').toLowerCase() + '-business-card.png';
        link.href = canvas.toDataURL();
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        alert('✅ Business card with QR code downloaded successfully!\\n\\n📱 You can now:\\n1. Print this business card\\n2. Scan the QR code with your phone\\n3. Experience the AR!');
        
      } catch (error) {
        console.error('Download failed:', error);
        alert('Please take a screenshot of the business card preview above - it contains the working QR code!');
      }
    }
    
    function downloadARFile() {
      const arContent = createFullARHTML(currentCardData);
      
      try {
        const blob = new Blob([arContent], {type: 'text/html'});
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = currentCardData.name.replace(/\s+/g, '-').toLowerCase() + '-ar-experience.html';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        setTimeout(() => URL.revokeObjectURL(url), 1000);
        alert('AR Experience HTML file downloaded successfully!');
      } catch (error) {
        console.error('Download failed:', error);
        alert('Download failed. Please try again.');
      }
    }
    
    
    
    console.log('AR Business Card Generator loaded successfully!');
  </script>
</body>
</html>