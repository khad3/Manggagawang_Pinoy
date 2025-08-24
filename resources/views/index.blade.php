<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FriendChat</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/applicant/friendlist.css') }}">
    

</head>
<body>
    <!-- Top Navigation -->
    <div class="top-nav">
        <a href="{{ route('applicant.forum.display') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
        </a>
        
        <div class="user-info">
            <div class="avatar">{{ substr($retrievedApplicantInfo->personal_info->first_name, 0, 1) }}{{ substr($retrievedApplicantInfo->personal_info->last_name, 0, 1) }}</div>
            <span class="name">{{ $retrievedApplicantInfo->username }}</span>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <div class="chat-card">
            <!-- Friends Section -->
            <div class="friends-section">
                <div class="friends-header">
                    <h3><i class="fas fa-users me-2"></i>Friends List</h3>
                    <p>Choose someone to chat with</p>
                </div>

                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search friends..." id="searchInput">
                </div>


          <!-- View Friend Requests Button -->
<button class="btn btn-outline-primary mb-3" id="toggleRequestsBtn">
  <i class="fas fa-user-friends me-1"></i> View Friend Requests
</button>

<!-- Friend Requests Section (Initially Hidden) -->
<div id="friendRequestsSection" class="d-none">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Friend Requests</h5>
    </div>
    <div class="card-body p-3">

      <!-- Example Friend Request -->
      <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
        <div class="d-flex align-items-center">
          <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px; font-size: 1.1rem;">
            JD
          </div>
          <div>
            <h6 class="mb-0">John Doe</h6>
            <small class="text-muted">Sent you a friend request</small>
          </div>
        </div>
        <div>
          <button class="btn btn-sm btn-success me-1"><i class="fas fa-check"></i></button>
          <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
        </div>
      </div>

      <!-- Add more sample requests here -->
      <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
        <div class="d-flex align-items-center">
          <div class="rounded-circle bg-info text-white d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px; font-size: 1.1rem;">
            AR
          </div>
          <div>
            <h6 class="mb-0">Anna Reyes</h6>
            <small class="text-muted">Sent you a friend request</small>
          </div>
        </div>
        <div>
          <button class="btn btn-sm btn-success me-1"><i class="fas fa-check"></i></button>
          <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
        </div>
      </div>

    </div>
  </div>
</div>



                <div class="friends-list" id="friendsList">
                    @foreach ($retrievedFriends as $index => $friend)
                        @php
                            $friendUser = $friend->request_id == $applicantID ? $friend->receiver : $friend->sender;
                        @endphp

                        @if ($friendUser && $friendUser->personal_info)
                            <div class="friend-card" data-friend="friend_{{ $friendUser->id }}" data-status="online">
                                <div class="friend-info">
                                    <div class="friend-avatar">
                                        {{ strtoupper(substr($friendUser->personal_info->first_name, 0, 1)) }}{{ strtoupper(substr($friendUser->personal_info->last_name, 0, 1)) }}
                                        <div class="status-dot status-online"></div>
                                    </div>
                                    <div class="friend-details">
                                        <h6>{{ $friendUser->personal_info->first_name }} {{ $friendUser->personal_info->last_name }}</h6>
                                        <small>Online now</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Chat Section -->
            <div class="chat-section">
                <!-- Chat Header -->
                <div class="chat-header" id="chatHeader">
                    <div class="chat-user-info">
                        <div class="chat-avatar" id="chatAvatar"></div>
                        <div>
                            <h6 class="mb-0" id="chatName">Select a friend</h6>
                            <small class="text-muted" id="chatStatus">Choose someone to chat with</small>
                        </div>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="messages-container" id="messagesContainer">
                    <div class="welcome-screen" id="welcomeScreen">
                        <i class="fas fa-comments"></i>
                        <h5>Select a friend to start chatting</h5>
                        <p>Choose someone from your friends list to begin a conversation</p>
                    </div>
                </div>

                <!-- Message Input -->
                <form id="messageForm" enctype="multipart/form-data" method="POST" action="{{ route('applicant.sendmessage.store') }}">
                    @csrf
                    <div class="message-input" id="messageInput">
                        <div class="input-container d-flex align-items-center gap-2">

                            <input type="hidden" name="receiver_id" id="receiverId" value="">
                            <!-- File Input (Hidden) -->
                            <input type="file" id="photoInput" accept="image/*" name="photo" style="display: none;">

                            <!-- Upload Button -->
                            <button type="button" class="btn btn-light" id="uploadBtn" title="Attach Photo">
                                <i class="fas fa-paperclip"></i>
                            </button>

                            <!-- Message Text Field -->
                            <input type="text" class="message-field flex-grow-1" placeholder="Type your message..." name="message" id="messageField">

                            <!-- Send Button -->
                            <button type="submit" class="send-btn" >
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>

                        <!-- Preview Area -->
                        <div id="photoPreview" class="mt-2"></div>
                    </div>
                </form>

            </div>
        </div>
    </div>

<script>
    
   document.getElementById("messageForm").addEventListener("submit", function (e) {
    // e.preventDefault(); // Prevent form from reloading the page

    const form = e.target;
    const formData = new FormData(form);
    const receiverId = formData.get('receiver_id');
    const currentChatId = `friend_${receiverId}`;

    fetch(form.action, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Append new message
            if (!friends[currentChatId]) {
                friends[currentChatId] = { messages: [] };
            }

            const newMessage = {
                text: formData.get("message"),
                sender: "You",
                sent: true,
                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
            };

            friends[currentChatId].messages = friends[currentChatId].messages || [];
            friends[currentChatId].messages.push(newMessage);

            form.reset(); // clear message field
            document.getElementById("photoPreview").innerHTML = ''; // clear image preview

            currentFriend = currentChatId; // make sure this stays selected
            selectFriend(currentFriend);  // re-render chat for same friend
        } else {
            alert("Failed to send message.");
        }
    })
    .catch(err => {
        console.error("Error:", err);
    });
});

function displayMessages(friendId) {
    const friendKey = 'friend_' + friendId;
    const messages = messagesGroupedByFriend[friendKey] || [];
    messagesContainer.innerHTML = ""; // Clear previous content

    messages.forEach(msg => {
        const messageDiv = document.createElement("div");
        messageDiv.className = msg.sender === "You" ? "text-end mb-2" : "text-start mb-2";

        let content = `<div class="p-2 rounded ${msg.sender === "You" ? "bg-primary text-white" : "bg-light"}">`;

        if (msg.text) {
            content += `<strong>${msg.sender}:</strong> ${msg.text}<br>`;
        }

        if (msg.image) {
            content += `<img src="/public/uploads/${msg.image}" alt="Image" class="img-fluid mt-1 rounded" style="max-width: 200px;">`;
        }

        content += `</div>`;
        messageDiv.innerHTML = content;

        messagesContainer.appendChild(messageDiv);
    });

    scrollToBottom();
}







    const photoInput = document.getElementById('photoInput');
    const uploadBtn = document.getElementById('uploadBtn');
    const photoPreview = document.getElementById('photoPreview');

    uploadBtn.addEventListener('click', () => {
        photoInput.click();
    });

    photoInput.addEventListener('change', () => {
        const file = photoInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                photoPreview.innerHTML = `
                    <div class="preview-image-wrapper d-flex align-items-center gap-2">
                        <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="height: 100px;">
                        <button type="button" class="btn btn-danger btn-sm" id="removePhoto">Remove</button>
                    </div>
                `;
                document.getElementById('removePhoto').addEventListener('click', () => {
                    photoInput.value = '';
                    photoPreview.innerHTML = '';
                });
            };
            reader.readAsDataURL(file);
        }
    });



    // Extend sendMessage to handle photo (simulation only)
    function sendMessage() {
        const text = messageField.value.trim();
        const photoFile = photoInput.files[0];
        if (!text && !photoFile) return;
        if (!currentFriend) return;

        const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const message = {
            text: text,
            sent: true,
            time: currentTime
        };

        if (photoFile) {
            const reader = new FileReader();
            reader.onload = function (e) {
                message.image = e.target.result;
                appendMessage(message);
            };
            reader.readAsDataURL(photoFile);
        } else {
            appendMessage(message);
        }

        // Clear inputs
        messageField.value = '';
        photoInput.value = '';
        photoPreview.innerHTML = '';
    }

    function appendMessage(message) {
        friends[currentFriend].messages.push(message);

        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${message.sent ? 'sent' : 'received'}`;
        messageDiv.innerHTML = `
            <div class="message-bubble">
                ${message.image ? `<img src="${message.image}" class="img-fluid mb-1 rounded" style="max-width: 200px;">` : ''}
                ${message.text}
            </div>
            <div class="message-time">${message.time}</div>
        `;
        messagesContainer.appendChild(messageDiv);
        scrollToBottom();
    }
</script>

    <script>
    document.getElementById("toggleRequestsBtn").addEventListener("click", function () {
        const section = document.getElementById("friendRequestsSection");
        section.classList.toggle("expanded");
    });
</script>

    <script>
  const toggleBtn = document.getElementById("toggleRequestsBtn");
  const requestsSection = document.getElementById("friendRequestsSection");

  toggleBtn.addEventListener("click", () => {
    requestsSection.classList.toggle("d-none");
    toggleBtn.innerHTML = requestsSection.classList.contains("d-none")
      ? '<i class="fas fa-user-friends me-1"></i> View Friend Requests'
      : '<i class="fas fa-times me-1"></i> Hide Friend Requests';
  });
</script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize friends data from Laravel blade template
       const friends = {};

    @foreach ($retrievedFriends as $friend)
        @php
            $friendUser = $friend->request_id == $applicantID ? $friend->receiver : $friend->sender;
        @endphp

        @if ($friendUser && $friendUser->personal_info)
            friends['friend_{{ $friendUser->id }}'] = {
                id: {{ $friendUser->id }},
                name: @json($friendUser->personal_info->first_name . ' ' . $friendUser->personal_info->last_name),
                avatar: "{{ strtoupper(substr($friendUser->personal_info->first_name, 0, 1)) }}{{ strtoupper(substr($friendUser->personal_info->last_name, 0, 1)) }}",
                status: "online",
                statusText: "Online now"
            };
        @endif
    @endforeach

        let currentFriend = null;
        let isTyping = false;

        // DOM elements
        const chatHeader = document.getElementById('chatHeader');
        const messagesContainer = document.getElementById('messagesContainer');
        const messageInput = document.getElementById('messageInput');
        const messageField = document.getElementById('messageField');
        const sendBtn = document.getElementById('sendBtn');
        const welcomeScreen = document.getElementById('welcomeScreen');
        const searchInput = document.getElementById('searchInput');

        // Initialize app
        document.addEventListener('DOMContentLoaded', function() {
            // Friend selection
            document.querySelectorAll('.friend-card').forEach(card => {
                card.addEventListener('click', function() {
                    const friendId = this.getAttribute('data-friend');
                    selectFriend(friendId);
                });
            });

            // Message sending
          
          

            // Search functionality
            searchInput.addEventListener('input', filterFriends);
        });

       function selectFriend(friendId) {
    document.querySelectorAll('.friend-card').forEach(card => card.classList.remove('active'));
    document.querySelector(`[data-friend="${friendId}"]`).classList.add('active');

    currentFriend = friendId;
    const friend = friends[friendId];

    if (!friend) return;

    // Update chat header
    document.getElementById('chatAvatar').textContent = friend.avatar;
    document.getElementById('chatName').textContent = friend.name;
    document.getElementById('chatStatus').textContent = friend.statusText;

    // Show chat interface
    welcomeScreen.style.display = 'none';
    chatHeader.classList.add('active');
    messageInput.classList.add('active');

    // Set receiver_id in form
    document.getElementById('receiverId').value = friend.id;

    // ✅ Load actual messages for this friend
    const friendNumericId = friend.id;
    displayMessages(friendNumericId);
}


        function loadMessages(messages) {
            messagesContainer.innerHTML = '';

            messages.forEach(message => {
                const messageDiv = createMessageElement(message);
                messagesContainer.appendChild(messageDiv);
            });

            scrollToBottom();
        }

        function createMessageElement(message) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${message.sent ? 'sent' : 'received'}`;

            messageDiv.innerHTML = `
                <div class="message-bubble">
                    ${message.text}
                </div>
                <div class="message-time">
                    ${message.time}
                </div>
            `;

            return messageDiv;
        }

        
       
        function showTypingIndicator() {
            if (isTyping) return;
            isTyping = true;

            const typingDiv = document.createElement('div');
            typingDiv.className = 'typing-indicator';
            typingDiv.id = 'typingIndicator';
            typingDiv.innerHTML = `
                <div class="typing-bubble">
                    <div class="typing-dots">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            `;

            messagesContainer.appendChild(typingDiv);
            scrollToBottom();
        }

        function hideTypingIndicator() {
            const typingIndicator = document.getElementById('typingIndicator');
            if (typingIndicator) {
                typingIndicator.remove();
                isTyping = false;
            }
        }

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function filterFriends() {
            const searchTerm = searchInput.value.toLowerCase();

            document.querySelectorAll('.friend-card').forEach(card => {
                const name = card.querySelector('h6').textContent.toLowerCase();
                card.style.display = name.includes(searchTerm) ? 'block' : 'none';
            });
        }

        // Update friend status indicator in chat
        function updateChatStatus() {
            if (currentFriend) {
                const friend = friends[currentFriend];
                const statusElement = document.getElementById('chatStatus');
                statusElement.textContent = isTyping ? 'Typing...' : friend.statusText;
            }
        }

        // Call updateChatStatus when typing indicators change
        setInterval(updateChatStatus, 500);
    </script>
</body>
</html>   

     <!-- @foreach ($messages as $msg)
    <div class="{{ $msg->sender_id == session('applicant_id') ? 'text-end' : 'text-start' }}">
        <div class="message-box">
            {{ $msg->message }}
        </div>

        @if ($msg->sender_id == session('applicant_id') && $loop->last)
            <small class="text-muted">
                {{ $msg->is_read ? 'Seen' : 'Delivered' }}
            </small>
        @endif
    </div>
@endforeach -->




<!----
arc alling card
<script>
        // Global variables
        let cardData = {
            fullName: 'Maria Santos',
            workApplied: 'UI/UX Designer',
            address: 'Quezon City, Philippines',
            email: 'maria.santos@email.com',
            skills: 'Figma, Adobe XD, Photoshop, Prototyping, User Research'
        };

        let uploadedFile = null;
        let sampleWorkApproved = false;
        let currentFileUrl = null;
        let demoWorkApproved = false;

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            console.log('AR Calling Card application starting...');
            initializeEventListeners();
            updateAllPreviews();
            generateQRCode();
            setupFileUpload();
            console.log('Application initialized successfully!');
        });

        // Initialize all event listeners
        function initializeEventListeners() {
            // Form input listeners (removed Phone from the array)
            const inputs = ['Name', 'WorkApplied', 'Address', 'Email', 'Skills'];
            
            inputs.forEach(field => {
                const input = document.getElementById(`input${field}`);
                if (input) {
                    ['input', 'keyup', 'change', 'paste'].forEach(eventType => {
                        input.addEventListener(eventType, function() {
                            const value = this.value;
                            cardData[field.charAt(0).toLowerCase() + field.slice(1)] = value;
                            updateAllPreviews();
                            showUpdateSuccess();
                            
                            // Debounced QR code generation
                            clearTimeout(window.qrTimeout);
                            window.qrTimeout = setTimeout(() => {
                                generateQRCode();
                                updateValidationStatus();
                            }, 500);
                        });
                    });
                }
            });

            // Tab change listeners
            const tabButtons = document.querySelectorAll('[data-bs-toggle="pill"]');
            tabButtons.forEach(button => {
                button.addEventListener('shown.bs.tab', function(e) {
                    const target = e.target.getAttribute('data-bs-target');
                    if (target === '#preview') {
                        updateFinalPreview();
                    }
                });
            });
        }

        // Approve demo sample work
        function approveDemoWork() {
            demoWorkApproved = true;
            sampleWorkApproved = true;
            document.getElementById('demoSampleWork').classList.add('d-none');
            showUpdateSuccess();
            updateValidationStatus();
            
            // Show validation section
            document.getElementById('validationSection').classList.remove('d-none');
        }

        // Show upload option instead of demo
        function showUploadOption() {
            document.getElementById('demoSampleWork').classList.add('d-none');
            document.getElementById('fileUploadArea').classList.remove('d-none');
        }

        // Setup file upload functionality
        function setupFileUpload() {
            const fileInput = document.getElementById('fileInput');
            const uploadArea = document.getElementById('fileUploadArea');

            // File input change
            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    handleFileUpload(e.target.files[0]);
                }
            });

            // Drag and drop
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                
                if (e.dataTransfer.files.length > 0) {
                    handleFileUpload(e.dataTransfer.files[0]);
                }
            });
        }

        // Handle file upload
        function handleFileUpload(file) {
            // Validate file size (10MB limit)
            if (file.size > 10 * 1024 * 1024) {
                showError('File size must be less than 10MB');
                return;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 
                                'application/pdf', 'application/msword', 
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            
            if (!allowedTypes.includes(file.type)) {
                showError('Unsupported file type. Please upload images, PDF, or Word documents.');
                return;
            }

            uploadedFile = file;
            
            // Show file preview
            displayFilePreview(file);
            
            // Create temporary URL for the file
            currentFileUrl = URL.createObjectURL(file);
            
            // Display sample work viewer
            displaySampleWorkViewer(file);
            
            showUpdateSuccess();
        }

        // Display file preview
        function displayFilePreview(file) {
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const filePreviewImage = document.getElementById('filePreviewImage');

            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';

            // Show preview image if it's an image file
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.width = '80px';
                img.style.height = '80px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                filePreviewImage.innerHTML = '';
                filePreviewImage.appendChild(img);
            } else {
                // Show file icon for non-image files
                filePreviewImage.innerHTML = '<div class="file-placeholder"><i class="fas fa-file-alt"></i></div>';
            }

            // Hide upload area and show preview
            document.getElementById('fileUploadArea').classList.add('d-none');
            filePreview.classList.remove('d-none');
        }

        // Display sample work viewer
        function displaySampleWorkViewer(file) {
            const viewer = document.getElementById('sampleWorkViewer');
            const content = document.getElementById('sampleWorkContent');

            if (file.type.startsWith('image/')) {
                // Display image
                const img = document.createElement('img');
                img.src = currentFileUrl;
                img.style.maxWidth = '100%';
                img.style.height = 'auto';
                img.style.borderRadius = '8px';
                content.innerHTML = '';
                content.appendChild(img);
            } else if (file.type === 'application/pdf') {
                // Display PDF
                const iframe = document.createElement('iframe');
                iframe.src = currentFileUrl;
                iframe.style.width = '100%';
                iframe.style.height = '400px';
                iframe.style.border = 'none';
                iframe.style.borderRadius = '8px';
                content.innerHTML = '';
                content.appendChild(iframe);
            } else {
                // Display download option for other files
                content.innerHTML = `
                    <div class="text-center p-4">
                        <i class="fas fa-file-alt fa-3x text-light-gray mb-3"></i>
                        <h6 class="text-white">${file.name}</h6>
                        <p class="text-light-gray">Document ready for review</p>
                        <button class="btn btn-outline-light btn-sm" onclick="downloadSampleFile()">
                            <i class="fas fa-download me-2"></i>Download to Review
                        </button>
                    </div>
                `;
            }

            viewer.classList.remove('d-none');
        }

        // Approve sample work
        function approveSampleWork() {
            sampleWorkApproved = true;
            document.getElementById('sampleWorkViewer').classList.add('d-none');
            showUpdateSuccess();
            updateValidationStatus();
            
            // Show validation section
            document.getElementById('validationSection').classList.remove('d-none');
        }

        // Reject sample work (allow re-upload)
        function rejectSampleWork() {
            removeFile();
        }

        // Remove uploaded file
        function removeFile() {
            uploadedFile = null;
            sampleWorkApproved = false;
            demoWorkApproved = false;
            currentFileUrl = null;
            
            // Reset file input
            document.getElementById('fileInput').value = '';
            
            // Hide previews and show upload area
            document.getElementById('filePreview').classList.add('d-none');
            document.getElementById('sampleWorkViewer').classList.add('d-none');
            document.getElementById('fileUploadArea').classList.remove('d-none');
            document.getElementById('demoSampleWork').classList.remove('d-none');
            document.getElementById('validationSection').classList.add('d-none');
            
            updateValidationStatus();
        }

        // Download sample file for review
        function downloadSampleFile() {
            if (currentFileUrl) {
                const link = document.createElement('a');
                link.href = currentFileUrl;
                link.download = uploadedFile.name;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        // Update all preview sections (removed phone from here)
        function updateAllPreviews() {
            // Update live preview
            document.getElementById('previewName').textContent = cardData.fullName;
            document.getElementById('previewWorkApplied').textContent = cardData.workApplied;
            document.getElementById('previewAddress').textContent = cardData.address;
            document.getElementById('previewEmail').textContent = cardData.email;

            // Update skills
            const skillsContainer = document.getElementById('previewSkills');
            if (cardData.skills) {
                const skills = cardData.skills.split(',').map(skill => skill.trim()).filter(skill => skill.length > 0);
                skillsContainer.innerHTML = skills.map(skill => 
                    `<span class="skill-badge">${skill}</span>`
                ).join('');
            }

            updateValidationStatus();
        }

        // Update final preview
        function updateFinalPreview() {
            const finalPreview = document.getElementById('finalPreview');
            const livePreview = document.getElementById('callingCardPreview');
            finalPreview.innerHTML = livePreview.innerHTML;
        }

        // Update validation status
        function updateValidationStatus() {
            const basicInfoComplete = cardData.fullName && cardData.workApplied && cardData.address && cardData.email;
            const sampleWorkComplete = (uploadedFile && sampleWorkApproved) || demoWorkApproved;

            // Update checkmarks
            updateCheckmark('checkBasicInfo', basicInfoComplete);
            updateCheckmark('checkSampleWork', sampleWorkComplete);
            updateCheckmark('checkQRCode', true); // QR code is always generated

            // Enable/disable validate button
            const validateBtn = document.getElementById('validateBtn');
            if (validateBtn) {
                const allComplete = basicInfoComplete && sampleWorkComplete;
                validateBtn.disabled = !allComplete;
                
                if (allComplete) {
                    validateBtn.classList.remove('btn-outline-light');
                    validateBtn.classList.add('btn-gradient');
                }
            }
        }

        // Update individual checkmark
        function updateCheckmark(elementId, isComplete) {
            const element = document.getElementById(elementId);
            if (element) {
                const icon = element.querySelector('i');
                if (isComplete) {
                    icon.className = 'fas fa-check-circle';
                    icon.style.color = '#22c55e';
                } else {
                    icon.className = 'fas fa-times-circle';
                    icon.style.color = '#ef4444';
                }
            }
        }

        // Generate QR Code
        function generateQRCode() {
            const vCardData = generateVCardData();
            const canvas = document.getElementById('qrCode');

            if (canvas && window.QRious) {
                try {
                    new QRious({
                        element: canvas,
                        value: vCardData,
                        size: 200,
                        background: 'white',
                        foreground: '#1a1a2e',
                        level: 'M',
                        padding: 10
                    });
                } catch (error) {
                    console.error('Error generating QR code:', error);
                }
            }
        }

        // Generate vCard data (removed phone from here)
        function generateVCardData() {
            const skillsNote = cardData.skills ? `\\nSkills: ${cardData.skills}` : '';
            const sampleWorkNote = (uploadedFile && sampleWorkApproved) || demoWorkApproved ? 
                `\\nSample Work: Available upon scanning - Portfolio included` : '';

            return `BEGIN:VCARD
VERSION:3.0
FN:${cardData.fullName}
TITLE:${cardData.workApplied}
ADR:;;${cardData.address};;;;
EMAIL:${cardData.email}
NOTE:Application for: ${cardData.workApplied}${skillsNote}${sampleWorkNote}
END:VCARD`;
        }

        // Validate and proceed to download
        function validateAndProceed() {
            if (!((uploadedFile && sampleWorkApproved) || demoWorkApproved)) {
                showError('Please upload and approve your sample work first.');
                return;
            }

            const basicInfoComplete = cardData.fullName && cardData.workApplied && cardData.address && cardData.email;
            if (!basicInfoComplete) {
                showError('Please fill in all required basic information.');
                return;
            }

            // Enable download tab
            const downloadTab = document.getElementById('download-tab');
            downloadTab.disabled = false;
            downloadTab.classList.remove('disabled');

            // Switch to download tab
            switchToTab('download');
            
            showSuccess('Validation successful! Your AR calling card is ready for download.');
        }

        // Switch to specific tab
        function switchToTab(tabName) {
            const tabElement = document.getElementById(`${tabName}-tab`);
            if (tabElement && !tabElement.disabled) {
                const tab = new bootstrap.Tab(tabElement);
                tab.show();
            }
        }

        // Download functions
        function downloadVCard() {
            const vCardData = generateVCardData();
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = URL.createObjectURL(blob);
            
            const link = document.createElement('a');
            link.href = url;
            link.download = `${cardData.fullName.replace(/\s+/g, '_')}_contact.vcf`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            
            showSuccess('Contact file downloaded successfully!');
        }

        function downloadQRCode() {
            const canvas = document.getElementById('qrCode');
            if (canvas) {
                canvas.toBlob(function(blob) {
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = `${cardData.fullName.replace(/\s+/g, '_')}_qr_code.png`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                    
                    showSuccess('QR code downloaded successfully!');
                });
            }
        }

        function downloadCardImage() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            canvas.width = 900;
            canvas.height = 550;
            
            // Create modern gradient background
            const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
            gradient.addColorStop(0, '#1e293b');
            gradient.addColorStop(0.5, '#334155');
            gradient.addColorStop(1, '#475569');
            
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            // Add top accent line
            const accentGradient = ctx.createLinearGradient(0, 0, canvas.width, 0);
            accentGradient.addColorStop(0, '#06b6d4');
            accentGradient.addColorStop(0.5, '#3b82f6');
            accentGradient.addColorStop(1, '#8b5cf6');
            
            ctx.fillStyle = accentGradient;
            ctx.fillRect(0, 0, canvas.width, 8);
            
            // Add card content
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 42px Inter, Arial, sans-serif';
            ctx.textAlign = 'left';
            ctx.fillText(cardData.fullName, 60, 120);
            
            ctx.fillStyle = '#06b6d4';
            ctx.font = 'bold 28px Inter, Arial, sans-serif';
            ctx.fillText(cardData.workApplied, 60, 160);
            
            ctx.fillStyle = 'rgba(255, 255, 255, 0.9)';
            ctx.font = '24px Inter, Arial, sans-serif';
            ctx.fillText(cardData.address, 60, 220);
            ctx.fillText(cardData.email, 60, 260);
            
            // Add skills
            if (cardData.skills) {
                ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
                ctx.font = '18px Inter, Arial, sans-serif';
                ctx.fillText('Skills: ' + cardData.skills, 60, 320);
            }
            
            // Add AR indicator
            ctx.fillStyle = '#10b981';
            ctx.font = 'bold 20px Inter, Arial, sans-serif';
            ctx.textAlign = 'right';
            ctx.fillText('AR ENABLED', canvas.width - 60, 60);
            
            // Download the image
            canvas.toBlob(function(blob) {
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = `${cardData.fullName.replace(/\s+/g, '_')}_calling_card.png`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
                
                showSuccess('Calling card image downloaded!');
            });
        }

        // Utility functions
        function showUpdateSuccess() {
            const indicator = document.getElementById('updateSuccess');
            indicator.classList.add('show');
            setTimeout(() => {
                indicator.classList.remove('show');
            }, 2000);
        }

        function showSuccess(message) {
            alert(message);
        }

        function showError(message) {
            alert(message);
        }
    </script>

---->



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Calling Card Generator - Enhanced</title>
    
     External Dependencies -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/applicant/callingcard.css') }}">
</head>

<body> -->
    <!-- Success Indicator -->
    <!-- <div id="updateSuccess" class="update-success">
        <i class="fas fa-check me-2"></i>Card Updated!
    </div>

     Animated Background 
    <div class="animated-bg">
        <div class="bg-orb orb-1"></div>
        <div class="bg-orb orb-2"></div>
        <div class="bg-orb orb-3"></div>
    </div> -->

    <!-- <div class="container-fluid"> -->
        <!-- Header -->
        <!-- <div class="row justify-content-center text-center py-5">
            <div class="col-12">
                <div class="header-content">
                    <div class="d-flex align-items-center justify-content-center gap-3 mb-4">
                        <div class="icon-wrapper">
                            <i class="fas fa-id-card-clip"></i>
                        </div>
                        <h1 class="gradient-text">AR Calling Card</h1>
                    </div>
                    <p class="lead text-light-gray fs-5 mx-auto" style="max-width: 800px;">
                        Create professional AR-enabled calling cards with QR codes that showcase your sample work to employers
                    </p>
                </div>
            </div>
        </div> -->

        <!-- Tab Navigation -->
        <!-- <div class="row justify-content-center mb-5">
            <div class="col-md-6 col-lg-4">
                <div class="glass-tabs">
                    <ul class="nav nav-pills nav-fill" id="mainTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="create-tab" data-bs-toggle="pill" data-bs-target="#create" type="button" role="tab">
                                <i class="fas fa-edit me-2"></i>Create
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="preview-tab" data-bs-toggle="pill" data-bs-target="#preview" type="button" role="tab">
                                <i class="fas fa-eye me-2"></i>Preview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="download-tab" data-bs-toggle="pill" data-bs-target="#download" type="button" role="tab" disabled>
                                <i class="fas fa-download me-2"></i>Download
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div> -->

        <!-- Tab Content -->
        <!-- <div class="tab-content" id="mainTabContent"> -->
            <!-- Create Tab -->
            <!-- <div class="tab-pane fade show active" id="create" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row g-4"> -->
                            <!-- Form Section -->
                            <!-- <div class="col-lg-6">
                                <div class="glass-card">
                                    <div class="card-header">
                                        <h5 class="card-title text-white d-flex align-items-center">
                                            <i class="fas fa-user me-2"></i>
                                            Basic Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="cardForm" action="#">
                                          @csrf 
                                          @foreach ($retrievedProfiles as  $personDetail)
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="inputName" class="form-label">
                                                        <i class="fas fa-user me-2"></i>Full Name *
                                                    </label>
                                                    <input type="text" class="form-control glass-input" id="inputName" 
                                                           value="{{ $personDetail->personal_info->first_name }} {{ $personDetail->personal_info->last_name }}" placeholder="Your full name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputWorkApplied" class="form-label">
                                                        <i class="fas fa-briefcase me-2"></i>Work Applied *
                                                    </label>
                                                    <input type="text" class="form-control glass-input" id="inputWorkApplied" 
                                                           value="{{$personDetail->work_background->position}}" placeholder="Position you're applying for" required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="inputAddress" class="form-label">
                                                        <i class="fas fa-map-marker-alt me-2"></i>Address *
                                                    </label>
                                                    <input type="text" class="form-control glass-input" id="inputAddress" 
                                                           value="{{$personDetail->personal_info->house_street}} {{ $personDetail->personal_info->barangay }} {{ $personDetail->personal_info->city }} {{ $personDetail->personal_info->province }}" placeholder="Your complete address" required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="inputEmail" class="form-label">
                                                        <i class="fas fa-envelope me-2"></i>Email *
                                                    </label>
                                                    <input type="email" class="form-control glass-input" id="inputEmail" 
                                                           value="{{$personDetail->email}}" placeholder="your.email@company.com" required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="inputSkills" class="form-label">
                                                        <i class="fas fa-award me-2"></i>Skills & Expertise
                                                    </label>
                                                    <textarea class="form-control glass-input" id="inputSkills" rows="3" 
                                                              placeholder="List your key skills and expertise">{{ $personDetail->template->description }}</textarea>
                                                </div>
                                            </div>
                                            @endforeach
                                        </form>
                                    </div>
                                </div> -->

                                <!-- Sample Work Upload -->
                                <!-- <div class="glass-card mt-4">
                                    <div class="card-header">
                                        <h5 class="card-title text-white d-flex align-items-center">
                                            <i class="fas fa-upload me-2"></i>
                                            Sample Work Upload *
                                        </h5>
                                        <p class="text-light-gray mb-0">Upload your portfolio or sample work</p>
                                    </div>
                                    <div class="card-body"> -->
                                        <!-- Demo Sample Work -->
                                        <!-- <div id="demoSampleWork" class="sample-work-demo">
                                            <h4><i class="fas fa-palette me-2"></i>Sample Portfolio Preview</h4>
                                            <p class="mb-3">Here's what your uploaded sample work would look like:</p>
                                            <div class="portfolio-grid">
                                                <div class="portfolio-item">
                                                    <i class="fas fa-mobile-alt"></i>
                                                    <h6>Mobile App Design</h6>
                                                    <p>E-commerce App UI</p>
                                                </div>
                                                <div class="portfolio-item">
                                                    <i class="fas fa-desktop"></i>
                                                    <h6>Website Design</h6>
                                                    <p>Corporate Landing Page</p>
                                                </div>
                                                <div class="portfolio-item">
                                                    <i class="fas fa-paint-brush"></i>
                                                    <h6>Brand Identity</h6>
                                                    <p>Logo & Style Guide</p>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-success me-2" onclick="approveDemoWork()">
                                                    <i class="fas fa-check me-2"></i>Approve This Sample Work
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="showUploadOption()">
                                                    <i class="fas fa-upload me-2"></i>Upload Different Work
                                                </button>
                                            </div>
                                        </div>

                                        <div class="file-upload-area d-none" id="fileUploadArea">
                                            <div class="upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <h6 class="text-white mb-2">Upload your sample work</h6>
                                            <p class="text-light-gray mb-3">Drag and drop files here, or click to browse</p>
                                            <input type="file" class="d-none" id="fileInput" accept="image/*,.pdf,.doc,.docx">
                                            <button type="button" class="btn btn-outline-light" onclick="document.getElementById('fileInput').click()">
                                                Browse Files
                                            </button>
                                            <p class="text-light-gray mt-2 mb-0" style="font-size: 0.8rem;">
                                                Supported: Images, PDF, Word documents (Max: 10MB)
                                            </p>
                                        </div> -->
                                        
                                        <!-- File Preview -->
                                        <!-- <div id="filePreview" class="file-preview d-none">
                                            <div class="file-preview-content">
                                                <div class="file-info">
                                                    <div id="filePreviewImage"></div>
                                                    <div>
                                                        <p class="text-white mb-1 fw-bold" id="fileName">Sample File</p>
                                                        <p class="text-light-gray mb-0" id="fileSize">0 MB</p>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-outline-light btn-sm" onclick="removeFile()">
                                                    Remove
                                                </button>
                                            </div>
                                        </div> -->

                                        <!-- Sample Work Viewer -->
                                        <!-- <div id="sampleWorkViewer" class="sample-work-viewer d-none">
                                            <h6 class="text-white mb-3">
                                                <i class="fas fa-eye me-2"></i>Sample Work Preview
                                            </h6>
                                            <div id="sampleWorkContent"></div>
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-success btn-sm me-2" onclick="approveSampleWork()">
                                                    <i class="fas fa-check me-2"></i>Approve & Continue
                                                </button>
                                                <button type="button" class="btn btn-outline-light btn-sm" onclick="rejectSampleWork()">
                                                    <i class="fas fa-times me-2"></i>Replace File
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Live Preview Section -->
                            <!-- <div class="col-lg-6">
                                <div class="glass-card">
                                    <div class="card-header">
                                        <h5 class="card-title text-white">Live Preview</h5>
                                        <p class="text-light-gray mb-0">See how your calling card will look</p>
                                    </div>
                                    <div class="card-body">
                                      @foreach ($retrievedProfiles as $personDetail )
                                        <div class="calling-card-modern" id="callingCardPreview">
                                            <div class="ar-badge-modern">
                                                <i class="fas fa-cube me-1"></i> AR Enabled
                                            </div>

                                            <div class="card-profile-section">
                                                <div class="profile-avatar">
                                                    <i class="fas fa-user-tie"></i>
                                                </div>
                                                <div class="profile-info">
                                                    <h2 id="previewName">{{ $personDetail->personal_info->first_name }} {{ $personDetail->personal_info->last_name }}</h2>
                                                    <div class="position" id="previewWorkApplied">{{ $personDetail->work_background->position }}</div>
                                                    <div class="company">Applying for Position</div>
                                                </div>
                                            </div>

                                            <div class="contact-grid">
                                                <div class="contact-item-modern">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span id="previewAddress">{{ $personDetail->personal_info->house_street }}, {{ $personDetail->personal_info->barangay }}, {{ $personDetail->personal_info->city }}, {{ $personDetail->personal_info->province }}</span>
                                                </div>
                                                <div class="contact-item-modern">
                                                    <i class="fas fa-envelope"></i>
                                                    <span id="previewEmail">{{ $personDetail->email }}</span>
                                                </div>
                                            </div>

                                            <div class="skills-modern" id="previewSkills">
                                                <span class="skill-badge">{{ $personDetail->template->description }}</span>
                                                
                                            </div>

                                            @endforeach -->
                                            <!-- QR Code Section -->
                                            <!-- <div class="qr-section-modern">
                                                <div class="qr-header-modern">
                                                    <i class="fas fa-qrcode"></i>
                                                    <span>Scan to View Portfolio & Contact</span>
                                                </div>
                                                <div class="qr-container-modern" id="qrContainer">
                                                    <canvas id="qrCode" width="200" height="200"></canvas>
                                                </div>
                                                <div class="qr-instruction-modern">
                                                    Point camera to instantly view contact details and sample work portfolio
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- Validation Section -->
                                <!-- <div id="validationSection" class="d-none">
                                    <div class="validation-section">
                                        <div class="validation-header">
                                            <i class="fas fa-shield-check"></i>
                                            Ready for Validation
                                        </div>
                                        <ul class="validation-checklist">
                                            <li id="checkBasicInfo">
                                                <i class="fas fa-times-circle"></i>
                                                Basic information completed
                                            </li>
                                            <li id="checkSampleWork">
                                                <i class="fas fa-times-circle"></i>
                                                Sample work uploaded and approved
                                            </li>
                                            <li id="checkQRCode">
                                                <i class="fas fa-times-circle"></i>
                                                QR code generated successfully
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-gradient w-100 mt-3" onclick="validateAndProceed()" disabled id="validateBtn">
                                            <i class="fas fa-check-double me-2"></i>Validate & Proceed to Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Preview Tab -->
            <!-- <div class="tab-pane fade" id="preview" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-4">
                            <h3 class="text-white mb-3">Final AR Calling Card Preview</h3>
                            <p class="text-light-gray">Review your complete calling card before downloading</p>
                        </div>
                        
                        <div class="calling-card-modern" id="finalPreview"> -->
                            <!-- This will be populated with the same structure as the live preview -->
                        <!-- </div> -->

                        <!-- <div class="text-center mt-4">
                            <button class="btn btn-gradient btn-lg px-5" onclick="switchToTab('download')">
                                Proceed to Download
                            </button>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Download Tab -->
            <!-- <div class="tab-pane fade" id="download" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="glass-card">
                            <div class="card-header">
                                <h5 class="card-title text-white d-flex align-items-center">
                                    <i class="fas fa-download me-2"></i>
                                    Download Your AR Calling Card
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="validation-section">
                                    <div class="validation-header">
                                        <i class="fas fa-check-circle"></i>
                                        Card Validated Successfully!
                                    </div>
                                    <ul class="validation-checklist">
                                        <li><i class="fas fa-check-circle"></i> All information verified</li>
                                        <li><i class="fas fa-check-circle"></i> Sample work approved</li>
                                        <li><i class="fas fa-check-circle"></i> QR code generated</li>
                                        <li><i class="fas fa-check-circle"></i> Ready for distribution</li>
                                    </ul>
                                </div>

                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <button class="btn btn-success w-100" onclick="downloadVCard()">
                                            <i class="fas fa-address-card me-2"></i>
                                            Download Contact (.vcf)
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-outline-light w-100" onclick="downloadQRCode()">
                                            <i class="fas fa-qrcode me-2"></i>
                                            Download QR Code
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-gradient w-100" onclick="downloadCardImage()">
                                            <i class="fas fa-image me-2"></i>
                                            Download Card Image
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-4 p-3" style="background: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.3); border-radius: 8px;">
                                    <h6 class="text-white mb-2">
                                        <i class="fas fa-lightbulb me-2"></i>How it works:
                                    </h6>
                                    <p class="text-light-gray mb-0" style="font-size: 0.9rem;">
                                        1. Share your QR code with employers<br>
                                        2. They scan it to instantly view your contact details<br>
                                        3. Sample work portfolio is accessible through the QR code<br>
                                        4. Professional presentation in AR-enabled format
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- QR Code Library -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script> -->

<!--     
</body>
</html> --> 



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FriendChat</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/applicant/friendlist.css') }}">


</head>
<body>
    <!-- Top Navigation -->
    <div class="top-nav">
        <a href="{{ route('applicant.forum.display') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
        </a>
        
        <div class="user-info">
            <div class="avatar">{{ substr($retrievedApplicantInfo->personal_info->first_name, 0, 1) }}{{ substr($retrievedApplicantInfo->personal_info->last_name, 0, 1) }}</div>
            <a href="{{ route('applicant.profile.display') }}" class="name"><span class="name">{{ $retrievedApplicantInfo->username }}</span></a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container"
        <div class="chat-card">
            <!-- Friends Section -->
            <div class="friends-section">

            <button class="back-to-friends d-md-none" onclick="toggleFriends()">
                <i class="fas fa-arrow-left"></i> Back to Chat
            </button>
                <div class="friends-header">
                    <h3><i class="fas fa-users me-2"></i>Friends List</h3>
                    <p>Choose someone to chat with</p>
                </div>

                <div class="friends-list">
                    @foreach ($retrievedFriends as $index => $friend)
                        @php
                            $friendUser = $friend->request_id == $applicantID ? $friend->receiver : $friend->sender;
                            $selectedFriendId = request('friend_id');
                            $isActive = $selectedFriendId == $friendUser->id;
                        @endphp

                        @if ($friendUser && $friendUser->personal_info)
                            <a href="?friend_id={{ $friendUser->id }}" 
                               class="friend-card {{ $isActive ? 'active' : '' }}">
                                <div class="friend-avatar">
                                    {{ strtoupper(substr($friendUser->personal_info->first_name, 0, 1)) }}{{ strtoupper(substr($friendUser->personal_info->last_name, 0, 1)) }}
                                    <div class="status-dot"></div>
                                </div>
                                <div class="friend-details">
                                    <h6>{{ $friendUser->personal_info->first_name }} {{ $friendUser->personal_info->last_name }}</h6>
                                      @php
                                        $lastSeen = $friendUser->last_seen ?? null;
                                        $isOnline = $lastSeen && \Carbon\Carbon::parse($lastSeen)->gt(now()->subMinutes(10));
                                    @endphp

                                    <small class="text-muted">
                                        {{ $isOnline ? 'Online now' : 'Offline' }}
                                    </small>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Chat Section -->
            <div class="chat-section">
                @php
                    $selectedFriendId = request('friend_id');
                    $selectedFriend = null;
                    
                    // Find the selected friend
                    if ($selectedFriendId) {
                        foreach ($retrievedFriends as $friend) {
                            $friendUser = $friend->request_id == $applicantID ? $friend->receiver : $friend->sender;
                            if ($friendUser && $friendUser->id == $selectedFriendId) {
                                $selectedFriend = $friendUser;
                                break;
                            }
                        }
                    }
                    
                    // Filter messages for selected friend
                    $currentMessages = [];
                    if ($selectedFriend) {
                        $currentMessages = $retrievedMessages->filter(function($message) use ($applicantID, $selectedFriendId) {
                            return ($message->sender_id == $applicantID && $message->receiver_id == $selectedFriendId) ||
                                   ($message->sender_id == $selectedFriendId && $message->receiver_id == $applicantID);
                        })->sortBy('created_at');
                    }
                @endphp

                @if($selectedFriend)
                    <!-- Chat Header -->
                    <div class="chat-header">
                        <button class="btn btn-sm btn-outline-primary d-md-none" onclick="toggleFriends()">
                            <i class="fas fa-users me-1"></i> Friends
                        </button>



                        <div class="chat-user-info">
                            <div class="chat-avatar">
                                {{ strtoupper(substr($selectedFriend->personal_info->first_name, 0, 1)) }}{{ strtoupper(substr($selectedFriend->personal_info->last_name, 0, 1)) }}
                            </div>
                            <div>
                               <h6>
                                    <a href="{{ route('applicant.getprofile.display', ['id' => $friendUser->id]) }}">
                                        {{ $friendUser->personal_info->first_name }} {{ $friendUser->personal_info->last_name }}
                                    </a>
                                </h6>

                                
                                 @php
                                    $lastSeen = $friendUser->last_seen ?? null;
                                    $isOnline = $lastSeen && \Carbon\Carbon::parse($lastSeen)->gt(now()->subMinutes(10));
                                @endphp

                                <small class="text-muted">
                                    @if ($isOnline)
                                        Online now
                                    @elseif ($lastSeen)
                                        Offline for {{ \Carbon\Carbon::parse($lastSeen)->diffForHumans(null, true) }}
                                    @else
                                        Offline
                                    @endif
                                </small>

                           


                            </div>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="messages-container">
                        <button id="scrollUpBtn" class="btn btn-light position-absolute" 
                            style="top: 1rem; right: 1rem; z-index: 10;" 
                            onclick="scrollToTop()" title="Scroll to top">
                            <i class="fas fa-arrow-up"></i>
                        </button>

                        @if($currentMessages->count() > 0)
                            @foreach($currentMessages as $index => $message)
    @php
        $isSent = $message->sender_id == $applicantID;
        $messageTime = $message->created_at ? $message->created_at->format('g:i A') : 'now';
        $isLastSentByMe = $isSent && $loop->last; // last message AND sent by me
    @endphp

    <div class="chat-wrapper {{ $isSent ? 'sent' : 'received' }}">
        <div class="bubble-container">

            @if($message->image_path)
                <div class="message-image">
                    <img src="{{ asset($message->image_path) }}" alt="Message Image">
                </div>
            @endif

            @if($message->message)
                <div class="message-text">
                    <p>{{ $message->message }}</p>
                </div>
            @endif

            <div class="timestamp">
                {{ $messageTime }}

                {{-- ✅ Show "Seen" for the last message sent by me if read --}}
                @if($isLastSentByMe)
                    @if($message->is_read)
                        <span class="text-success ms-2">Seen</span>
                    @else
                        <span class="text-muted ms-2">Delivered</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endforeach

                        @else
                            <div class="no-messages">
                                <i class="fas fa-comments"></i>
                                <h5>No messages yet</h5>
                                <p>Start the conversation by sending a message!</p>
                            </div>
                        @endif
                    </div>

                    <!-- Message Input -->
                    <form method="POST" action="{{ route('applicant.sendmessage.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $selectedFriend->id }}">
                        
                        <div class="message-input">
                            <div class="input-container">
                                <!-- File Input (Hidden) -->
                                <input type="file" id="photoInput" accept="image/*" name="photo" style="display: none;">

                                <!-- Upload Button -->
                                <button type="button" class="btn btn-light" onclick="document.getElementById('photoInput').click()" title="Attach Photo">
                                    <i class="fas fa-paperclip"></i>
                                </button>

                                <!-- Message Text Field -->
                                <input type="text" class="message-field" placeholder="Type your message..." name="message" required>

                                <!-- Send Button -->
                                <button type="submit" class="send-btn">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>

                            <!-- Preview Area -->
                            <div id="photoPreview" class="mt-2"></div>
                        </div>
                    </form>
                @else
                    <!-- Welcome Screen -->
                    <div class="messages-container">
                        <div class="welcome-screen">
                            <i class="fas fa-comments"></i>
                            <h5>Select a friend to start chatting</h5>
                            <p>Choose someone from your friends list to begin a conversation</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <script>

  

        
        function toggleFriends() {
            const friends = document.querySelector('.friends-section');
            friends.classList.toggle('show');
        }
        
        function scrollToTop() {
            const container = document.querySelector(".messages-container");
            container.scrollTop = 0;
        }

        window.onload = function() {
            const container = document.querySelector(".messages-container");
            container.scrollTop = container.scrollHeight;
        };
    </script>


    <script>
       
        document.getElementById('photoInput').addEventListener('change', function() {
            const file = this.files[0];
            const preview = document.getElementById('photoPreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="preview-image-wrapper d-flex align-items-center gap-2">
                            <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="height: 100px;">
                            <button type="button" class="btn btn-danger btn-sm" onclick="clearPhoto()">Remove</button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        function clearPhoto() {
            document.getElementById('photoInput').value = '';
            document.getElementById('photoPreview').innerHTML = '';
        }
    </script>


<script>
    setInterval(() => {
        fetch("{{ route('applicant.updatelastseen.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(response => response.json())
          .then(data => {
              console.log('Last seen updated');
          });
    }, 60000); // every 60 seconds
</script>


</body>
</html>