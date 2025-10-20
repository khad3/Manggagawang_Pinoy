 <section id="officers" class="content-section">
     <div class="section-header">
         <h2 class="section-title">
             <i class="fas fa-user-tie"></i>
             Officers Management
         </h2>
         <button class="btn btn-primary" onclick="openAddOfficerModal()">
             <i class="fas fa-plus"></i>
             Add New Officer
         </button>
     </div>

     <div id="officersList">
         @foreach ($retrieveTesdaOfficers as $officer)
             <div class="card officer-card mb-3 p-3 shadow-sm">
                 <div class="officer-info d-flex align-items-center">
                     <div class="officer-avatar rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center"
                         style="width:50px; height:50px; font-size:18px;">
                         {{ strtoupper(substr($officer->first_name, 0, 1)) }}{{ strtoupper(substr($officer->last_name, 0, 1)) }}
                     </div>
                     <div class="officer-details ms-3">
                         <h5 class="mb-1">{{ $officer->first_name }} {{ $officer->last_name }}</h5>
                         <p class="email text-muted mb-0">
                             <i class="fas fa-envelope"></i> {{ $officer->email }}
                         </p>
                     </div>
                 </div>

                 <div class="officer-actions mt-3 d-flex justify-content-between align-items-center">
                     <span class="badge {{ $officer->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                         {{ ucfirst($officer->status) }}
                     </span>
                     <div class="action-buttons">
                         <!-- Edit Button opens modal -->
                         <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                             data-bs-target="#editOfficerModal{{ $officer->id }}">
                             <i class="fas fa-edit"></i> Edit
                         </button>
                         <!-- Delete Button -->
                         <form action="{{ route('admin.deleteofficer', ['id' => $officer->id]) }}" method="POST"
                             style="display:inline;">
                             @csrf
                             @method('DELETE')
                             <button type="submit" class="btn btn-danger btn-sm"
                                 onclick="return confirm('Are you sure you want to delete this officer?')">
                                 <i class="fas fa-trash"></i> Delete
                             </button>
                         </form>
                     </div>
                 </div>
             </div>

             <div class="modal fade" id="editOfficerModal{{ $officer->id }}" tabindex="-1"
                 aria-labelledby="editOfficerModalLabel{{ $officer->id }}" aria-hidden="true">
                 <div class="modal-dialog modal-lg modal-dialog-centered d-flex justify-content-center">
                     <div class="modal-content custom-modal mx-auto">

                         <form action="{{ route('admin.updateofficer', ['id' => $officer->id]) }}" method="POST">
                             @csrf
                             @method('PUT')

                             <!-- Header -->
                             <div class="modal-header border-0 pb-0">
                                 <h5 class="modal-title fw-bold text-dark"
                                     id="editOfficerModalLabel{{ $officer->id }}">
                                     <i class="fas fa-user-edit me-2 text-primary"></i> Edit Officer
                                 </h5>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal"
                                     aria-label="Close"></button>
                             </div>

                             <!-- Body -->
                             <div class="modal-body">
                                 <div class="row g-3">
                                     <div class="col-md-6">
                                         <label class="form-label">First Name</label>
                                         <input type="text" name="first_name" value="{{ $officer->first_name }}"
                                             class="form-control" required>
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">Last Name</label>
                                         <input type="text" name="last_name" value="{{ $officer->last_name }}"
                                             class="form-control" required>
                                     </div>
                                     <div class="col-md-12">
                                         <label class="form-label">Email</label>
                                         <input type="email" name="email" value="{{ $officer->email }}"
                                             class="form-control" required>
                                     </div>
                                     <div class="col-md-12">
                                         <label class="form-label">password</label>
                                         <input type="password" id="password" name="password"
                                             value="{{ $officer->password }}" class="form-control" required>
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">Status</label>
                                         <select name="status" class="form-select">
                                             <option value="active"
                                                 {{ $officer->status == 'active' ? 'selected' : '' }}>Active
                                             </option>
                                             <option value="inactive"
                                                 {{ $officer->status == 'inactive' ? 'selected' : '' }}>
                                                 Inactive</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>

                             <!-- Footer -->
                             <div class="modal-footer border-0 pt-0">
                                 <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                     Cancel
                                 </button>
                                 <button type="submit" class="btn btn-primary px-4">
                                     <i class="fas fa-save me-1"></i> Save Changes
                                 </button>
                             </div>

                         </form>
                     </div>
                 </div>
             </div>
         @endforeach
     </div>


 </section>
