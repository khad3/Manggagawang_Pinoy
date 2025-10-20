 @foreach ($notifications as $note)
     <div class="modal fade" id="viewNotificationModal-{{ $note->id }}" tabindex="-1"
         aria-labelledby="viewNotificationLabel-{{ $note->id }}" aria-hidden="true" data-bs-backdrop="static"
         data-bs-keyboard="true">
         <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"> {{-- scrollable --}}
             <div class="modal-content border-0 shadow">

                 {{-- Header --}}
                 <div class="modal-header border-bottom-0 pb-2">
                     <div class="d-flex align-items-center">
                         @if ($note->created_by === 'admin')
                             <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width: 40px; height: 40px;">
                                 <i class="bi bi-shield-check text-white"></i>
                             </div>
                         @else
                             <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width: 40px; height: 40px;">
                                 <i class="bi bi-bell text-white"></i>
                             </div>
                         @endif
                         <div>
                             <h6 class="modal-title fw-semibold mb-0" id="viewNotificationLabel-{{ $note->id }}">
                                 {{ $note->created_by === 'admin' ? 'TESDA Administrative Office' : 'System Notification' }}
                             </h6>
                             <small class="text-muted">{{ $note->created_at->format('M d, Y • g:i A') }}</small>
                         </div>
                     </div>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>

                 {{-- Body --}}
                 <div class="modal-body px-4 py-3">
                     {{-- Title --}}
                     <h5 class="fw-bold text-dark mb-3">{{ $note->title }}</h5>

                     {{-- Priority Badge --}}
                     @if (!empty($note->priority))
                         <div class="mb-3">
                             @switch($note->priority)
                                 @case('urgent')
                                     <span class="badge bg-danger px-3 py-2 rounded-pill">
                                         <i class="bi bi-exclamation-triangle-fill me-1"></i>Urgent
                                     </span>
                                 @break

                                 @case('high')
                                     <span class="badge bg-warning px-3 py-2 rounded-pill text-dark">
                                         <i class="bi bi-exclamation-circle-fill me-1"></i>High Priority
                                     </span>
                                 @break

                                 @case('medium')
                                     <span class="badge bg-info px-3 py-2 rounded-pill">
                                         <i class="bi bi-info-circle-fill me-1"></i>Medium Priority
                                     </span>
                                 @break

                                 @default
                                     <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                         <i class="bi bi-circle-fill me-1"></i>Normal Priority
                                     </span>
                             @endswitch
                         </div>
                     @endif

                     {{-- Content --}}
                     <div class="notification-content mb-4">
                         <p class="text-dark lh-lg mb-0" style="font-size: 0.95rem;">
                             {{ $note->content }}
                         </p>
                     </div>

                     {{-- Image if exists --}}
                     @if (!empty($note->image))
                         <div class="text-center mb-4">
                             <div class="border rounded-3 p-2 bg-light"> <img
                                     src="{{ asset('storage/' . $note->image) }}" alt="Notification Image"
                                     class="img-fluid rounded-2 shadow-sm" style="max-height: 300px; width: auto;">
                             </div>
                         </div>
                     @endif

                     {{-- Tags and Target Audience --}}
                     <div class="d-flex flex-wrap gap-2 align-items-center">
                         @if (!empty($note->tag))
                             <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                 <i class="bi bi-tag me-1"></i>{{ $note->tag }}
                             </span>
                         @endif

                         @if (!empty($note->target_audience))
                             <span
                                 class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 rounded-pill">
                                 <i class="bi bi-people me-1"></i>
                                 {{ ucfirst(str_replace('_', ' ', $note->target_audience)) }}
                             </span>
                         @endif
                     </div>
                 </div>

                 {{-- Footer --}}
                 <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                     <div class="d-flex justify-content-between w-100 align-items-center">
                         <small class="text-muted">
                             <i class="bi bi-calendar3 me-1"></i>
                             Published:
                             {{ $note->publication_date ? \Carbon\Carbon::parse($note->publication_date)->format('F j, Y') : 'Not set' }}
                         </small>
                         <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                             data-bs-dismiss="modal">
                             <i class="bi bi-x-lg me-1"></i>Close
                         </button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endforeach
