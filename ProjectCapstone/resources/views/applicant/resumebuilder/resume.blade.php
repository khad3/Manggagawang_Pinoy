<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESDA Blue Collar Resume Builder</title>
    <link rel="stylesheet" href="{{ asset('css/applicant/resumebuilder/resume.css') }}">
</head>

<body>

    <a href="{{ route('applicant.info.homepage.display') }}" class="back-btn" ><i class="bi bi-house-door-fill me-2"></i>
        Back to Homepage
    </a>

    <div class="container">
        <!-- Form Panel -->
        <div class="form-panel">
            <div class="header-logo">
                <div class="tesda-logo">T</div>
                <div>
                    <h1>Blue Collar Resume Builder</h1>
                    <div class="subtitle">Technical Skills Development Authority Inspired</div>
                </div>
            </div>
            
            <!-- Personal Information -->
            <div class="form-section">
                <h2>Personal Information</h2>
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" placeholder="Juan Dela Cruz" value = "{{$retrievedProfiles->personal_info->first_name}} {{ $retrievedProfiles->personal_info->last_name }}">
                </div>
                <div class="form-group">
                    <label for="jobTitle">Trade/Specialization</label>
                    <input type="text" id="jobTitle" placeholder="Master Electrician" value="{{$retrievedProfiles->work_background->position}}">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" placeholder="juan.delacruz@email.com" value="{{$retrievedProfiles->email}}">
                </div>
                <div class="form-group">
                    <label for="phone">Contact Number</label>
                    <input type="tel" id="phone" placeholder="e.g. +63 912 345 6789" >
                </div>
                <div class="form-group">
                    <label for="address">Complete Address</label>
                    <input type="text" id="address" placeholder="123 Rizal Street, Barangay San Jose, Quezon City, Metro Manila" value="{{$retrievedProfiles->personal_info->house_street}} {{ $retrievedProfiles->personal_info->barangay }}, {{ $retrievedProfiles->personal_info->city }} {{ $retrievedProfiles->personal_info->province }}">
                </div>
                <div class="form-group">
                    <label for="yearsExperience">Years of Experience</label>
                    <select id="yearsExperience" > 
                        <option value="{{ $retrievedProfiles->work_background->work_duration }} {{ $retrievedProfiles->work_background->work_duration_unit }}">Select years of experience</option>
                        <option value="Entry Level">Entry Level / Fresh Graduate</option>
                        <option value="1-2 years">1-2 years experience</option>
                        <option value="3-5 years">3-5 years experience</option>
                        <option value="6-10 years">6-10 years experience</option>
                        <option value="10+ years">10+ years experience</option>
                    </select>
                </div>
            </div>

            <!-- Career Objective -->
            <div class="form-section">
                <h2>Career Objective</h2>
                <div class="form-group">
                    <label for="objective">Career Objective Statement</label>
                    <textarea id="objective" placeholder="Dedicated and safety-conscious Master Electrician with 8+ years of experience in residential, commercial, and industrial electrical installations. Seeking to contribute technical expertise and leadership skills to a progressive company while ensuring compliance with all safety regulations and building codes."></textarea>
                </div>
            </div>

            <!-- Technical Skills -->
            <div class="form-section">
                <h2>Technical Competencies</h2>
                <div class="two-column">
                    <div class="form-group">
                        <label for="technicalSkills">Core Technical Skills</label>
                        <textarea id="technicalSkills" placeholder="Electrical wiring and installation, Circuit design and troubleshooting, Motor control systems, PLC programming, Electrical panel assembly"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="equipmentSkills">Tools & Equipment</label>
                        <textarea id="equipmentSkills" placeholder="Multimeter, Oscilloscope, Cable puller, Conduit bender, Power quality analyzer, Hand and power tools"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="softSkills">Professional Skills</label>
                    <textarea id="softSkills" placeholder="Safety compliance (OHSA), Blueprint reading, Project supervision, Quality control, Team leadership, Client communication"></textarea>
                </div>
            </div>

            <!-- Work Experience -->
            <div class="form-section">
                <h2>Work Experience</h2>
                <div id="experienceContainer">
                    <div class="experience-item">
                        <div class="form-group">
                            <label>Job Title</label>
                            <input type="text" class="exp-title" placeholder="Senior Electrician">
                        </div>
                        <div class="form-group">
                            <label>Company/Employer</label>
                            <input type="text" class="exp-company" placeholder="Metro Manila Electric Corporation">
                        </div>
                        <div class="form-group">
                            <label>Employment Period</label>
                            <input type="text" class="exp-dates" placeholder="January 2019 - Present">
                        </div>
                        <div class="form-group">
                            <label>Key Responsibilities & Achievements</label>
                            <textarea class="exp-description" placeholder="• Supervised electrical installations for 50+ residential and commercial projects
• Maintained 100% safety record with zero workplace incidents over 4 years
• Led team of 6 junior electricians and apprentices
• Reduced project completion time by 15% through efficient workflow management"></textarea>
                        </div>
                        <button type="button" class="remove-btn" onclick="removeExperience(this)">Remove</button>
                    </div>
                </div>
                <button type="button" class="add-btn" onclick="addExperience()">Add Work Experience</button>
            </div>

            <!-- Education & Training -->
            <div class="form-section">
                <h2>Education & Technical Training</h2>
                <div id="educationContainer">
                    <div class="education-item">
                        <div class="form-group">
                            <label>Education/Training Program</label>
                            <input type="text" class="edu-degree" placeholder="Electrical Installation & Maintenance NCII">
                        </div>
                        <div class="form-group">
                            <label>Institution/Training Center</label>
                            <input type="text" class="edu-institution" placeholder="TESDA Regional Training Center - NCR">
                        </div>
                        <div class="form-group">
                            <label>Year Completed</label>
                            <input type="text" class="edu-dates" placeholder="2018">
                        </div>
                        <button type="button" class="remove-btn" onclick="removeEducation(this)">Remove</button>
                    </div>
                </div>
                <button type="button" class="add-btn" onclick="addEducation()">Add Education/Training</button>
            </div>

            <!-- Certifications & Licenses -->
            <div class="form-section">
                <h2>Certifications & Licenses</h2>
                <div id="certificationContainer">
                    <div class="certification-item">
                        <div class="form-group">
                            <label>Certification/License</label>
                            <input type="text" class="cert-name" placeholder="Master Electrician License">
                        </div>
                        <div class="form-group">
                            <label>Issuing Authority</label>
                            <input type="text" class="cert-org" placeholder="Professional Regulation Commission (PRC)">
                        </div>
                        <div class="form-group">
                            <label>Validity/Date Issued</label>
                            <input type="text" class="cert-dates" placeholder="Valid until December 2025">
                        </div>
                        <button type="button" class="remove-btn" onclick="removeCertification(this)">Remove</button>
                    </div>
                </div>
                <button type="button" class="add-btn" onclick="addCertification()">Add Certification</button>
            </div>

            <button type="button" class="download-btn" onclick="downloadResume()">Download Resume as PDF</button>
        </div>

        <!-- Preview Panel -->
        <div class="preview-panel">
            <div class="resume" id="resumePreview">
                <div class="resume-header">
                    <div class="resume-name" id="previewName">JUAN DELA CRUZ</div>
                    <div class="resume-title" id="previewTitle">Master Electrician</div>
                    <div class="resume-contact">
                        <div class="contact-item" id="previewEmail">juan.delacruz@email.com</div>
                        <div class="contact-item" id="previewPhone">+63 912 345 6789</div>
                        <div class="contact-item" id="previewAddress">123 Rizal Street, Barangay San Jose, Quezon City</div>
                        <div class="contact-item" id="previewExperience">8+ years experience</div>
                    </div>
                </div>
                
                <div class="resume-body">
                    <div class="resume-section" id="objectiveSection">
                        <h3>Career Objective</h3>
                        <p class="objective-text" id="previewObjective">Dedicated and safety-conscious Master Electrician with 8+ years of experience in residential, commercial, and industrial electrical installations. Seeking to contribute technical expertise and leadership skills to a progressive company while ensuring compliance with all safety regulations and building codes.</p>
                    </div>

                    <div class="resume-section" id="skillsSection">
                        <h3>Technical Competencies</h3>
                        <div class="skills-grid" id="previewSkills">
                            <div class="skill-category">
                                <h4>Core Technical Skills</h4>
                                <ul class="skill-list">
                                    <li>Electrical wiring and installation</li>
                                    <li>Circuit design and troubleshooting</li>
                                    <li>Motor control systems</li>
                                    <li>PLC programming</li>
                                    <li>Electrical panel assembly</li>
                                </ul>
                            </div>
                            <div class="skill-category">
                                <h4>Tools & Equipment</h4>
                                <ul class="skill-list">
                                    <li>Multimeter</li>
                                    <li>Oscilloscope</li>
                                    <li>Cable puller</li>
                                    <li>Conduit bender</li>
                                    <li>Power quality analyzer</li>
                                </ul>
                            </div>
                            <div class="skill-category">
                                <h4>Professional Skills</h4>
                                <ul class="skill-list">
                                    <li>Safety compliance (OHSA)</li>
                                    <li>Blueprint reading</li>
                                    <li>Project supervision</li>
                                    <li>Quality control</li>
                                    <li>Team leadership</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="resume-section" id="experienceSection">
                        <h3>Work Experience</h3>
                        <div id="previewExperiences">
                            <div class="experience-entry">
                                <div class="entry-header">
                                    <div>
                                        <div class="entry-title">Senior Electrician</div>
                                        <div class="entry-company">Metro Manila Electric Corporation</div>
                                    </div>
                                    <div class="entry-dates">Jan 2019 - Present</div>
                                </div>
                                <div class="entry-description">
                                    • Supervised electrical installations for 50+ residential and commercial projects<br>
                                    • Maintained 100% safety record with zero workplace incidents over 4 years<br>
                                    • Led team of 6 junior electricians and apprentices<br>
                                    • Reduced project completion time by 15% through efficient workflow management
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="resume-section" id="educationSection">
                        <h3>Education & Technical Training</h3>
                        <div id="previewEducation">
                            <div class="education-entry">
                                <div class="entry-header">
                                    <div>
                                        <div class="entry-title">Electrical Installation & Maintenance NCII</div>
                                        <div class="entry-company">TESDA Regional Training Center - NCR</div>
                                    </div>
                                    <div class="entry-dates">2018</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="resume-section" id="certificationSection">
                        <h3>Certifications & Licenses</h3>
                        <div id="previewCertifications">
                            <div class="certification-entry">
                                <div class="entry-header">
                                    <div>
                                        <div class="entry-title">Master Electrician License</div>
                                        <div class="entry-company">Professional Regulation Commission (PRC)</div>
                                    </div>
                                    <div class="entry-dates">Valid until Dec 2025</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // Update preview in real-time
        function updatePreview() {
            // Personal info
            const name = document.getElementById('fullName').value || 'JUAN DELA CRUZ';
            document.getElementById('previewName').textContent = name.toUpperCase();
            document.getElementById('previewTitle').textContent = document.getElementById('jobTitle').value || 'Master Electrician';
            document.getElementById('previewEmail').textContent = document.getElementById('email').value || 'juan.delacruz@email.com';
            document.getElementById('previewPhone').textContent = document.getElementById('phone').value || '+63 912 345 6789';
            document.getElementById('previewAddress').textContent = document.getElementById('address').value || '123 Rizal Street, Barangay San Jose, Quezon City';
            
            const experience = document.getElementById('yearsExperience').value || '8+ years experience';
            document.getElementById('previewExperience').textContent = experience;
            
            // Career objective
            document.getElementById('previewObjective').textContent = document.getElementById('objective').value || 'Dedicated and safety-conscious Master Electrician with 8+ years of experience in residential, commercial, and industrial electrical installations. Seeking to contribute technical expertise and leadership skills to a progressive company while ensuring compliance with all safety regulations and building codes.';
            
            // Skills
            updateSkillsPreview();
            
            // Experience
            updateExperiencePreview();
            
            // Education
            updateEducationPreview();
            
            // Certifications
            updateCertificationPreview();
        }

        function updateSkillsPreview() {
            const skillsContainer = document.getElementById('previewSkills');
            const technicalSkills = document.getElementById('technicalSkills').value || 'Electrical wiring and installation, Circuit design and troubleshooting, Motor control systems, PLC programming, Electrical panel assembly';
            const equipmentSkills = document.getElementById('equipmentSkills').value || 'Multimeter, Oscilloscope, Cable puller, Conduit bender, Power quality analyzer, Hand and power tools';
            const softSkills = document.getElementById('softSkills').value || 'Safety compliance (OHSA), Blueprint reading, Project supervision, Quality control, Team leadership, Client communication';
            
            skillsContainer.innerHTML = `
                <div class="skill-category">
                    <h4>Core Technical Skills</h4>
                    <ul class="skill-list">
                        ${technicalSkills.split(',').map(skill => `<li>${skill.trim()}</li>`).join('')}
                    </ul>
                </div>
                <div class="skill-category">
                    <h4>Tools & Equipment</h4>
                    <ul class="skill-list">
                        ${equipmentSkills.split(',').map(skill => `<li>${skill.trim()}</li>`).join('')}
                    </ul>
                </div>
                <div class="skill-category">
                    <h4>Professional Skills</h4>
                    <ul class="skill-list">
                        ${softSkills.split(',').map(skill => `<li>${skill.trim()}</li>`).join('')}
                    </ul>
                </div>
            `;
        }

        function updateExperiencePreview() {
            const experienceContainer = document.getElementById('previewExperiences');
            const experienceItems = document.querySelectorAll('.experience-item');
            
            experienceContainer.innerHTML = '';
            
            experienceItems.forEach(item => {
                const title = item.querySelector('.exp-title').value;
                const company = item.querySelector('.exp-company').value;
                const dates = item.querySelector('.exp-dates').value;
                const description = item.querySelector('.exp-description').value;
                
                if (title || company || dates || description) {
                    const expEntry = document.createElement('div');
                    expEntry.className = 'experience-entry';
                    expEntry.innerHTML = `
                        <div class="entry-header">
                            <div>
                                <div class="entry-title">${title || 'Job Title'}</div>
                                <div class="entry-company">${company || 'Company Name'}</div>
                            </div>
                            <div class="entry-dates">${dates || 'Employment Period'}</div>
                        </div>
                        <div class="entry-description">${(description || 'Key responsibilities and achievements...').replace(/\n/g, '<br>')}</div>
                    `;
                    experienceContainer.appendChild(expEntry);
                }
            });
        }

        function updateEducationPreview() {
            const educationContainer = document.getElementById('previewEducation');
            const educationItems = document.querySelectorAll('.education-item');
            
            educationContainer.innerHTML = '';
            
            educationItems.forEach(item => {
                const degree = item.querySelector('.edu-degree').value;
                const institution = item.querySelector('.edu-institution').value;
                const dates = item.querySelector('.edu-dates').value;
                
                if (degree || institution || dates) {
                    const eduEntry = document.createElement('div');
                    eduEntry.className = 'education-entry';
                    eduEntry.innerHTML = `
                        <div class="entry-header">
                            <div>
                                <div class="entry-title">${degree || 'Education/Training Program'}</div>
                                <div class="entry-company">${institution || 'Institution/Training Center'}</div>
                            </div>
                            <div class="entry-dates">${dates || 'Year'}</div>
                        </div>
                    `;
                    educationContainer.appendChild(eduEntry);
                }
            });
        }

        function updateCertificationPreview() {
            const certContainer = document.getElementById('previewCertifications');
            const certItems = document.querySelectorAll('.certification-item');
            
            certContainer.innerHTML = '';
            
            certItems.forEach(item => {
                const name = item.querySelector('.cert-name').value;
                const org = item.querySelector('.cert-org').value;
                const dates = item.querySelector('.cert-dates').value;
                
                if (name || org || dates) {
                    const certEntry = document.createElement('div');
                    certEntry.className = 'certification-entry';
                    certEntry.innerHTML = `
                        <div class="entry-header">
                            <div>
                                <div class="entry-title">${name || 'Certification/License'}</div>
                                <div class="entry-company">${org || 'Issuing Authority'}</div>
                            </div>
                            <div class="entry-dates">${dates || 'Date/Validity'}</div>
                        </div>
                    `;
                    certContainer.appendChild(certEntry);
                }
            });
        }

        function addExperience() {
            const container = document.getElementById('experienceContainer');
            const newItem = document.createElement('div');
            newItem.className = 'experience-item';
            newItem.innerHTML = `
                <div class="form-group">
                    <label>Job Title</label>
                    <input type="text" class="exp-title" placeholder="Job Title">
                </div>
                <div class="form-group">
                    <label>Company/Employer</label>
                    <input type="text" class="exp-company" placeholder="Company Name">
                </div>
                <div class="form-group">
                    <label>Employment Period</label>
                    <input type="text" class="exp-dates" placeholder="Start Date - End Date">
                </div>
                <div class="form-group">
                    <label>Key Responsibilities & Achievements</label>
                    <textarea class="exp-description" placeholder="• Describe your key responsibilities and achievements
• Include specific accomplishments with numbers when possible
• Highlight safety record and compliance achievements
• Use bullet points for clarity"></textarea>
                </div>
                <button type="button" class="remove-btn" onclick="removeExperience(this)">Remove</button>
            `;
            container.appendChild(newItem);
            attachEventListeners();
        }

        function removeExperience(button) {
            button.parentElement.remove();
            updatePreview();
        }

        function addEducation() {
            const container = document.getElementById('educationContainer');
            const newItem = document.createElement('div');
            newItem.className = 'education-item';
            newItem.innerHTML = `
                <div class="form-group">
                    <label>Education/Training Program</label>
                    <input type="text" class="edu-degree" placeholder="TESDA Program or Educational Degree">
                </div>
                <div class="form-group">
                    <label>Institution/Training Center</label>
                    <input type="text" class="edu-institution" placeholder="TESDA Center or School Name">
                </div>
                <div class="form-group">
                    <label>Year Completed</label>
                    <input type="text" class="edu-dates" placeholder="Year">
                </div>
                <button type="button" class="remove-btn" onclick="removeEducation(this)">Remove</button>
            `;
            container.appendChild(newItem);
            attachEventListeners();
        }

        function removeEducation(button) {
            button.parentElement.remove();
            updatePreview();
        }

        function addCertification() {
            const container = document.getElementById('certificationContainer');
            const newItem = document.createElement('div');
            newItem.className = 'certification-item';
            newItem.innerHTML = `
                <div class="form-group">
                    <label>Certification/License</label>
                    <input type="text" class="cert-name" placeholder="Professional License or Certification">
                </div>
                <div class="form-group">
                    <label>Issuing Authority</label>
                    <input type="text" class="cert-org" placeholder="PRC, TESDA, or Other Authority">
                </div>
                <div class="form-group">
                    <label>Validity/Date Issued</label>
                    <input type="text" class="cert-dates" placeholder="Valid until or Date Issued">
                </div>
                <button type="button" class="remove-btn" onclick="removeCertification(this)">Remove</button>
            `;
            container.appendChild(newItem);
            attachEventListeners();
        }

        function removeCertification(button) {
            button.parentElement.remove();
            updatePreview();
        }

        function downloadResume() {
            const element = document.getElementById('resumePreview');
            const name = document.getElementById('fullName').value || 'Blue_Collar_Resume';
            
            const opt = {
                margin: [0.5, 0.5, 0.5, 0.5],
                filename: `${name.replace(/\s+/g, '_')}_Resume.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { 
                    scale: 2,
                    useCORS: true,
                    letterRendering: true
                },
                jsPDF: { 
                    unit: 'in', 
                    format: 'letter', 
                    orientation: 'portrait' 
                }
            };
            
            html2pdf().set(opt).from(element).save();
        }

        function attachEventListeners() {
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.removeEventListener('input', updatePreview);
                input.addEventListener('input', updatePreview);
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            attachEventListeners();
            updatePreview();
        });
    </script>
</body>
</html>