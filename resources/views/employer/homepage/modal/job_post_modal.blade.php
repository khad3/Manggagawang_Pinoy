 <div class="modal fade" id="newJobModal" tabindex="-1" aria-labelledby="newJobModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="newJobModalLabel" style="color: black;">Post New Job</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

             <div class="modal-body">
                 <form action="{{ route('employer.jobsposts.store') }}" method="POST">
                     @csrf
                     <div class="row g-3">
                         <div class="col-12">
                             <label for="jobTitle" class="form-label">Job Title</label>
                             <input type="text" class="form-control" id="jobTitle" name="job_title"
                                 placeholder="e.g. Senior Electrician">
                         </div>
                         <div class="col-md-6">
                             <label for="jobCategory" class="form-label">Category</label>
                             <select class="form-select" id="jobCategory" name="job_department">
                                 <option selected disabled>Choose category...</option>
                                 <option value="Construction">Construction</option>
                                 <option value="Electrical">Electrical</option>
                                 <option value="Plumbing">Plumbing</option>
                                 <option value="Culinary">Culinary</option>
                                 <option value="Maintenance">Maintenance</option>
                                 <option value="Housekeeping">Housekeeping</option>
                                 <option value="Caregiving">Caregiving</option>
                                 <option value="IT / Tech Support">IT / Tech Support</option>
                                 <option value="Customer Service">Customer Service</option>
                                 <option value="Teaching / Tutoring">Teaching / Tutoring</option>
                                 <option value="Driving / Delivery">Driving / Delivery</option>
                                 <option value="Laundry Services">Laundry Services</option>
                                 <option value="Beauty / Wellness">Beauty / Wellness</option>
                                 <option value="Administrative / Office Work">Administrative / Office Work</option>
                                 <option value="Carpentry">Carpentry</option>
                                 <option value="Welding">Welding</option>
                                 <option value="Gardening / Landscaping">Gardening / Landscaping</option>
                                 <option value="Repair Services">Repair Services</option>
                                 <option value="Security Services">Security Services</option>
                                 <option value="Other">Others</option>
                             </select>

                             <div id="otherCategory" style="display: none; ">
                                 <label for="otherCategoryInput" class="form-label">Other Category</label>
                                 <input type="text" class="form-control" id="otherCategoryInput"
                                     name="other_department" placeholder="Enter other category">
                             </div>

                         </div>
                         <div class="col-md-6">
                             <label for="jobType" class="form-label">Job Type</label>
                             <select class="form-select" id="jobType" name="job_type">
                                 <option selected>Choose type...</option>
                                 <option>Full-time</option>
                                 <option>Part-time</option>
                                 <option>Contract</option>
                                 <option>Temporary</option>

                             </select>
                         </div>

                         <div class="col-md-6">
                             <label for="workType" class="form-label">Work Type </label>
                             <select class="form-select" name="job_work_type" id="workType" required>
                                 <option value="">Select work type</option>
                                 <option value="Onsite">On-site</option>
                                 <option value="Project-based">Project-based</option>
                                 <option value="Contract">Contract Work</option>
                                 <option value="Seasonal">Seasonal</option>
                             </select>
                         </div>
                         <div class="col-md-6">
                             <label for="jobLocation" class="form-label">Location</label>
                             <input type="text" class="form-control" name="job_location" id="jobLocation"
                                 placeholder="e.g. Silang, Cavite">
                         </div>
                         <div class="col-md-6">
                             <label for="jobSalary" class="form-label">Salary Range</label>
                             <select class="form-select" id="jobSalary" name="job_salary_range" required>
                                 <option value="" disabled selected>Select Salary Range</option>
                                 <option value="Below 10,000">Below 10,000 monthly</option>
                                 <option value="10,000 - 20,000">10,000 - 20,000 monthly</option>
                                 <option value="20,001 - 30,000">20,001 - 30,000 monthly</option>
                                 <option value="30,001 - 40,000">30,001 - 40,000 monthly</option>
                                 <option value="40,001 - 50,000">40,001 - 50,000 monthly</option>
                                 <option value="50,001 - 60,000">50,001 - 60,000 monthly</option>
                                 <option value="Above 60,000">Above 60,000 monthly</option>
                             </select>
                         </div>

                         <div class="col-md-6">
                             <label for="experience" class="form-label">Experience Level *</label>
                             <select class="form-select" id="experience" name="job_experience" required>
                                 <option value="">Select experience</option>
                                 <option value="Apprentice Level (0-1 years)">Apprentice Level (0-1 years)</option>
                                 <option value="Skilled Worker (2-5 years)">Skilled Worker (2-5 years)</option>
                                 <option value="Experienced Craftsman (6-10 years)">Experienced Craftsman (6-10
                                     years)</option>
                                 <option value="Master Craftsman (10+ years)">Master Craftsman (10+ years)</option>
                                 <option value="Supervisor/Foreman">Supervisor/Foreman</option>
                             </select>
                         </div>

                         <div class="col-12">
                             <label for="jobDescription" class="form-label">Job Description</label>
                             <textarea class="form-control" name="job_description" id="jobDescription" rows="4"
                                 placeholder="Describe the job requirements, responsibilities, and qualifications..."></textarea>
                         </div>
                         <div class="col-12">
                             <label for="jobRequirements" class="form-label">Additional Requirements
                                 (comma-separated)</label>
                             <input type="text" class="form-control" name="job_additional_requirements"
                                 id="jobRequirements"
                                 placeholder="e.g. 5+ years experience, Licensed, Safety Certified">
                         </div>
                         <!--- Tesda certification ---->
                         <!-- TESDA Certification Requirements -->
                         <div class="tesda-section">
                             <h5 class="text-warning mb-3">
                                 <i class="fas fa-certificate me-2"></i>TESDA Certification Requirements
                             </h5>
                             <p class="mb-3">Select the required TESDA certifications for this position:</p>

                             <!-- None Certification Toggle -->
                             <div class="mb-3">
                                 <div class="form-check">
                                     <input class="form-check-input" name="none_certifications" value="on"
                                         type="checkbox" id="nonecertification" onchange="toggleTesdaCerts(this)">
                                     <label class="form-check-label fw-bold" for="nonecertification"> None
                                         Certification </label>
                                     <small class="text-muted d-block">Check this if no TESDA certificate is
                                         required</small>
                                 </div>
                             </div>


                             <!-- TESDA Certifications Section -->
                             <div id="tesdacertifications"
                                 class="tesda-certification-section p-4 rounded shadow-sm mb-4">
                                 <h5 class="text-warning mb-3">
                                     <i class="fas fa-certificate me-2"></i>TESDA Certification Requirements
                                 </h5>

                                 <div class="row g-3">
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <label class="form-check-label" for="welding">Welding
                                                 (SMAW/GMAW/GTAW)</label>
                                             <input class="form-check-input" name="job_tesda_certification[]"
                                                 value="Welding (SMAW/GMAW/GTAW)" type="checkbox" id="welding">
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_tesda_certification[]"
                                                 value="Electrical Installation & Maintenance" type="checkbox"
                                                 id="electrical">
                                             <label class="form-check-label" for="electrical">Electrical
                                                 Installation & Maintenance</label>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_tesda_certification[]"
                                                 value="Plumbing Installation & Maintenance" type="checkbox"
                                                 id="plumbing">
                                             <label class="form-check-label" for="plumbing">Plumbing Installation &
                                                 Maintenance</label>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_tesda_certification[]"
                                                 value="Carpentry & Joinery" type="checkbox" id="carpentry">
                                             <label class="form-check-label" for="carpentry">Carpentry &
                                                 Joinery</label>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_tesda_certification[]"
                                                 value="Automotive Servicing" type="checkbox" id="automotive">
                                             <label class="form-check-label" for="automotive">Automotive
                                                 Servicing</label>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_tesda_certification[]"
                                                 value="HVAC Installation & Servicing" type="checkbox"
                                                 id="hvac">
                                             <label class="form-check-label" for="hvac">HVAC Installation &
                                                 Servicing</label>
                                         </div>
                                     </div>

                                     <!-- OTHER Certification Option -->
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_tesda_certification[]"
                                                 value="Other" type="checkbox" id="otherCertCheckbox"
                                                 onchange="toggleOtherCertInput()">
                                             <label class="form-check-label fw-bold" for="otherCertCheckbox">Other
                                                 Certification</label>
                                             <small class="text-muted d-block">Check this if the desired
                                                 certification is not listed</small>
                                         </div>
                                     </div>

                                     <!-- Input for custom cert (hidden by default) -->
                                     <div class="col-md-6" id="otherCertInput" style="display: none;">
                                         <input type="text" class="form-control" name="other_certification"
                                             id="otherCertification" placeholder="Enter specific certification name">
                                     </div>
                                 </div>
                             </div>

                             <!-- Non-TESDA Certification Section (Initially Hidden) -->
                             <div id="nonTesdaCertifications" style="display: none;">
                                 <h5 class="text-success mt-4 mb-3">
                                     <i class="fas fa-clipboard-check me-2"></i> Non-Certification Requirements
                                 </h5>
                                 <p class="mb-3">Select non-certification qualifications required for this
                                     position:</p>
                                 <div class="row g-3">
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_non_tesda_certification[]"
                                                 value="At least 1 year work experience" type="checkbox"
                                                 id="experience">
                                             <label class="form-check-label fw-bold" for="experience">At least 1
                                                 year work experience</label>
                                             <small class="text-muted d-block">In any related job or trade</small>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_non_tesda_certification[]"
                                                 value="Strong teamwork and collaboration" type="checkbox"
                                                 id="teamwork">
                                             <label class="form-check-label fw-bold" for="teamwork">Strong teamwork
                                                 and collaboration</label>
                                             <small class="text-muted d-block">Ability to work well with
                                                 others</small>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_non_tesda_certification[]"
                                                 value="Good communication skills" type="checkbox"
                                                 id="communication">
                                             <label class="form-check-label fw-bold" for="communication">Good
                                                 communication skills</label>
                                             <small class="text-muted d-block">Verbal and written</small>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" name="job_non_tesda_certification[]"
                                                 value="Flexible and adaptable" type="checkbox" id="flexibility">
                                             <label class="form-check-label fw-bold" for="flexibility">Flexible and
                                                 adaptable</label>
                                             <small class="text-muted d-block">Can adjust to various working
                                                 conditions</small>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <!-- Benefits & Compensation -->
                         <div class="mb-4">
                             <label class="form-label">Benefits & Compensation Offered</label>
                             <p class="text-muted small mb-3">Select benefits you offer:</p>
                             <div id="benefits-container">
                                 <span class="skill-badge" onclick="toggleSkill(this)">SSS Contribution</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">PhilHealth</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">Pag-IBIG</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">13th Month Pay</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">Overtime Pay</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">Holiday Pay</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">Free Meals</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">Transportation
                                     Allowance</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">Safety Equipment
                                     Provided</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">Skills Training</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">Performance Bonus</span>
                                 <span class="skill-badge" onclick="toggleSkill(this)">Health Insurance</span>
                             </div>

                             <input type="hidden" name="job_benefits[]" id="benefits" value="">
                         </div>

                         <hr>
                         <!-- Communication Preferences -->
                         <div class="section-divider">
                             <h5 class="fw-bold mb-3">
                                 <i class="fas fa-comments text-success me-2"></i>Communication Preferences
                             </h5>

                             <div class="row">
                                 <div class="col-md-6">
                                     <label class="form-label">Preferred Contact Method *</label>
                                     <div class="form-check mb-2">
                                         <input class="form-check-input" type="radio" name="contact_method"
                                             id="contactEmail" value="email" required />
                                         <label class="form-check-label" for="contactEmail">
                                             <i class="fas fa-envelope me-2"></i>Email
                                         </label>
                                     </div>
                                     <div class="form-check mb-2">
                                         <input class="form-check-input" type="radio" name="contact_method"
                                             id="contactPhone" value="phone" />
                                         <label class="form-check-label" for="contactPhone">
                                             <i class="fas fa-phone me-2"></i>Phone Call
                                         </label>
                                     </div>
                                     <div class="form-check mb-2">
                                         <input class="form-check-input" type="radio" name="contact_method"
                                             id="contactSMS" value="sms" />
                                         <label class="form-check-label" for="contactSMS">
                                             <i class="fas fa-sms me-2"></i>SMS/Text Message
                                         </label>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <label class="form-label">Best Time to Contact</label>
                                     <select class="form-select" id="contactTime" name="contact_time">
                                         <option value="">Select best time</option>
                                         <option value="morning">Morning (8AM - 12PM)</option>
                                         <option value="afternoon">Afternoon (12PM - 5PM)</option>
                                         <option value="evening">Evening (5PM - 8PM)</option>
                                         <option value="anytime">Anytime during business hours</option>
                                     </select>

                                     <label class="form-label mt-3">Language Preference</label>
                                     <select class="form-select" id="language" name="language_preference">
                                         <option value="english">English</option>
                                         <option value="filipino">Filipino/Tagalog</option>
                                         <option value="cebuano">Cebuano</option>
                                         <option value="ilocano">Ilocano</option>
                                         <option value="other">Other</option>
                                     </select>
                                 </div>
                             </div>
                         </div>


                         <!-- Interview & Screening Preferences -->
                         <div class="preference-card">
                             <h5 class="fw-bold mb-3">
                                 <i class="fas fa-clipboard-check text-warning me-2"></i>Interview & Screening
                                 Preferences
                             </h5>

                             <div class="mb-3">
                                 <label class="form-label">Preferred Screening Methods</label>
                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" type="checkbox"
                                                 name="preferred_screening_method[]" value="Phone/Video interview"
                                                 id="phoneInterview" />
                                             <label class="form-check-label" for="phoneInterview">Phone/Video
                                                 interview</label>
                                         </div>
                                         <div class="form-check">
                                             <input class="form-check-input" type="checkbox"
                                                 name="preferred_screening_method[]" value="In-person interview"
                                                 id="inPersonInterview" />
                                             <label class="form-check-label" for="inPersonInterview">In-person
                                                 interview</label>
                                         </div>
                                         <div class="form-check">
                                             <input class="form-check-input" type="checkbox"
                                                 name="preferred_screening_method[]" value="Skills demonstration/test"
                                                 id="skillsDemo" />
                                             <label class="form-check-label" for="skillsDemo">Skills
                                                 demonstration/test</label>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check">
                                             <input class="form-check-input" type="checkbox"
                                                 name="preferred_screening_method[]" value="Reference check"
                                                 id="referenceCheck" />
                                             <label class="form-check-label" for="referenceCheck">Reference
                                                 check</label>
                                         </div>
                                         <div class="form-check">
                                             <input class="form-check-input" type="checkbox"
                                                 name="preferred_screening_method[]" value="Background verification"
                                                 id="backgroundCheck" />
                                             <label class="form-check-label" for="backgroundCheck">Background
                                                 verification</label>
                                         </div>
                                         <div class="form-check">
                                             <input class="form-check-input" type="checkbox"
                                                 name="preferred_screening_method[]" value="Drug testing"
                                                 id="drugTest" />
                                             <label class="form-check-label" for="drugTest">Drug testing</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="mb-3">
                                 <label for="interviewLocation" class="form-label">Preferred Interview
                                     Location</label>
                                 <select class="form-select" id="interviewLocation"
                                     name="preferred_interview_location">
                                     <option value="">Select location</option>
                                     <option value="Our office/headquarters">Our office/headquarters</option>
                                     <option value="Job site/project location">Job site/project location</option>
                                     <option value="Neutral location (cafe, etc.)">Neutral location (cafe, etc.)
                                     </option>
                                     <option value="Online/Video call only">Online/Video call only</option>
                                     <option value="Flexible - worker's choice">Flexible - worker's choice</option>
                                 </select>
                             </div>
                         </div>
                         <hr>

                         <!-- Special Requirements -->
                         <div class="preference-card">
                             <h5 class="fw-bold mb-3">
                                 <i class="fas fa-exclamation-triangle text-danger me-2"></i>Special Requirements
                             </h5>

                             <div class="switch-container">
                                 <div>
                                     <strong>Safety Training Required</strong>
                                     <div class="text-muted small">
                                         Workers must have safety training certificates
                                     </div>
                                 </div>
                                 <div class="form-check form-switch">
                                     <input class="form-check-input" name="special_requirements[]"
                                         value="Workers must have safety training certificates" type="checkbox"
                                         id="safetyTraining" />
                                 </div>
                             </div>

                             <div class="switch-container">
                                 <div>
                                     <strong>Own Tools Required</strong>
                                     <div class="text-muted small">
                                         Workers must bring their own basic tools
                                     </div>
                                 </div>
                                 <div class="form-check form-switch">
                                     <input class="form-check-input" name="special_requirements[]"
                                         value="Workers must bring their own basic tools" type="checkbox"
                                         id="ownTools" />
                                 </div>
                             </div>

                             <div class="switch-container">
                                 <div>
                                     <strong>Transportation Assistance</strong>
                                     <div class="text-muted small">
                                         Provide transportation or allowance
                                     </div>
                                 </div>
                                 <div class="form-check form-switch">
                                     <input class="form-check-input" name="special_requirements[]"
                                         value="Provide Transportation or allowance" type="checkbox"
                                         id="transportation" />
                                 </div>
                             </div>

                             <div class="mt-3">
                                 <label for="additionalRequirements" class="form-label">Additional Requirements
                                     or
                                     Notes</label>
                                 <textarea class="form-control" name="additional_requirements" id="additionalRequirements" rows="3"
                                     placeholder="Any specific requirements, work conditions, or special instructions..."></textarea>
                             </div>
                         </div>

                     </div>
                     <div class="modal-footer">
                         <button type="button" name="action" value="draft" class="btn btn-secondary"
                             data-bs-dismiss="modal">Save as Draft</button>
                         <button type="submit" name="action" value="publish" class="btn btn-primary">Publish
                             Job</button>
                     </div>
                 </form>
             </div>

         </div>
     </div>
 </div>
