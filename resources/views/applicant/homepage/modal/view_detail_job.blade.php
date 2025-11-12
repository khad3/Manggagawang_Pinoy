 <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-scrollable"> <!-- Added modal-dialog-scrollable -->
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="viewDetailsModalLabel">Job Details</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

             <!-- Modal Body Scrollable -->
             <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                 <!-- Added max-height and scroll -->
                 <h4 id="modalJobTitle"></h4>
                 @if (!empty($company->company_name))
                     <p>
                         <strong>Company:</strong>
                         <span id="modalCompanyName">{{ $company->company_name }}</span>
                     </p>
                 @else
                     <p>
                         <strong>Individual:</strong>
                         <span id="modalCompanyName">
                             {{ optional($company->employer->personal_info)->first_name . ' ' . optional($company->employer->personal_info)->last_name ?? 'Unknown' }}
                         </span>
                     </p>
                 @endif

                 <p><strong>Industry:</strong> <span id="modalIndustry"></span></p>
                 <p><strong>Location:</strong> <span id="modalLocation"></span></p>
                 <p><strong>Description:</strong></p>
                 <p id="modalDescription"></p>
                 <p><strong>Salary:</strong> ₱<span id="modalSalary"></span> Monthly</p>
                 <p><strong>Benefits:</strong> <span id="modalBenefits"></span></p>
                 <p><strong>Experience Level:</strong> <span id="modalExperienceLevel"></span></p>
                 <p><strong>TESDA Certification:</strong> <span id="modalTESDACertification"></span></p>
                 <p><strong>Other Certifications:</strong> <span id="modalNoneCertificationsQualification"></span></p>
             </div>

             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>
