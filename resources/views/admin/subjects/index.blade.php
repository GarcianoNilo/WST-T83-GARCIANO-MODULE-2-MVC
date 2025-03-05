@extends('layouts.dashboard')

@section('title', 'Manage Subjects')

@section('content')
<!-- Toast Notification System -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header" id="toastHeader">
            <i class="fas fa-info-circle me-2" id="toastIcon"></i>
            <strong class="me-auto" id="toastTitle">Notification</strong>
            <small>Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMessage">
            Action completed successfully
        </div>
    </div>
</div>

<!-- Session Messages -->
@if(session('success') || session('error') || $errors->any())
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex">
                        <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                        <div>
                            <strong>Please check the form for errors:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <!-- Add Subject Modal -->
        <div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold"><i class="fas fa-book text-primary me-2"></i>Add New Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.subjects.store') }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Subject Code</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-code text-primary"></i>
                                    </span>
                                    <input type="text" name="code" class="form-control border-start-0 ps-3" placeholder="Enter subject code" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Subject Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-book-open text-primary"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control border-start-0 ps-3" placeholder="Enter subject name" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Units</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-calculator text-primary"></i>
                                    </span>
                                    <input type="number" name="units" class="form-control border-start-0 ps-3" required min="1" max="6" placeholder="1-6 units">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Course</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-graduation-cap text-primary"></i>
                                    </span>
                                    <input type="text" name="course" class="form-control border-start-0 ps-3" required 
                                           placeholder="Enter course (e.g., BSIT, BSCS, BSIS)">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Year Level</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-level-up-alt text-primary"></i>
                                    </span>
                                    <select name="year_level" class="form-control border-start-0 ps-3" required>
                                        <option value="">Select Year Level</option>
                                        <option value="1">1st Year</option>
                                        <option value="2">2nd Year</option>
                                        <option value="3">3rd Year</option>
                                        <option value="4">4th Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary px-4">Add Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Subject Modal -->
        <div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold"><i class="fas fa-edit text-primary me-2"></i>Edit Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editSubjectForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Subject Code</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-code text-primary"></i>
                                    </span>
                                    <input type="text" name="code" id="edit_code" class="form-control border-start-0 ps-3" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Subject Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-book-open text-primary"></i>
                                    </span>
                                    <input type="text" name="name" id="edit_name" class="form-control border-start-0 ps-3" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Units</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-calculator text-primary"></i>
                                    </span>
                                    <input type="number" name="units" id="edit_units" class="form-control border-start-0 ps-3" required min="1" max="6">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Course</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-graduation-cap text-primary"></i>
                                    </span>
                                    <input type="text" name="course" id="edit_course" class="form-control border-start-0 ps-3" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Year Level</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-level-up-alt text-primary"></i>
                                    </span>
                                    <select name="year_level" id="edit_year_level" class="form-control border-start-0 ps-3" required>
                                        <option value="1">1st Year</option>
                                        <option value="2">2nd Year</option>
                                        <option value="3">3rd Year</option>
                                        <option value="4">4th Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary px-4">Update Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="card mb-4 shadow-sm border-0 rounded-3">
            <div class="card-header pb-0 bg-white">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 text-primary fw-bold py-1">
                            <i class="fas fa-book me-2"></i>Subject Management
                        </h6>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary btn-sm rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                            <i class="fas fa-plus-circle me-1"></i> Add New Subject
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-3 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Code</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Units</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Course</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Year Level</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjects as $subject)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 ps-3 py-3">{{ $subject->code }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 ps-3 py-3">{{ $subject->name }}</p>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border ms-3 py-2">{{ $subject->units }} {{ $subject->units > 1 ? 'units' : 'unit' }}</span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold ps-3 py-3">{{ $subject->course }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle ms-3 py-2">{{ $subject->year_level }}</span>
                                </td>
                                <td class="ps-3 py-3">
                                    <button class="btn btn-info btn-sm rounded-pill me-1 shadow-sm" 
                                            onclick="editSubject({{ $subject->id }}, '{{ $subject->code }}', '{{ $subject->name }}', {{ $subject->units }}, '{{ $subject->course }}', '{{ $subject->year_level }}')"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editSubjectModal">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill shadow-sm" 
                                                onclick="return confirm('Are you sure you want to delete this subject?'); showToast('Subject Deleted', 'Subject has been successfully removed', 'danger');">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-database fa-3x text-secondary opacity-50 mb-3"></i>
                                        <h6 class="text-secondary">No subjects available</h6>
                                        <p class="text-xs text-secondary">Click on "Add New Subject" to create one</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination with info -->
                <div class="px-3 py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-secondary text-xs mb-2 mb-md-0">
                            Showing <span class="fw-bold">{{ $subjects->firstItem() ?? 0 }}</span> to 
                            <span class="fw-bold">{{ $subjects->lastItem() ?? 0 }}</span> of 
                            <span class="fw-bold">{{ $subjects->total() }}</span> subjects
                        </div>
                        <div>
                            {{ $subjects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function editSubject(id, code, name, units, course, yearLevel) {
        document.getElementById('editSubjectForm').action = `/admin/subjects/${id}`;
        document.getElementById('edit_code').value = code;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_units').value = units;
        document.getElementById('edit_course').value = course;
        document.getElementById('edit_year_level').value = yearLevel;
        
        // Show toast notification
        showToast('Editing Subject', 'Now editing ' + name + ' (' + code + ')', 'info');
    }
    
    function showToast(title, message, type) {
        const toast = document.getElementById('liveToast');
        const toastHeader = document.getElementById('toastHeader');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');
        const toastIcon = document.getElementById('toastIcon');
        
        // Reset classes
        toastHeader.className = 'toast-header';
        toastIcon.className = 'fas me-2';
        
        // Set type-specific styles
        if (type === 'success') {
            toastHeader.classList.add('bg-success', 'text-white');
            toastIcon.classList.add('fa-check-circle');
        } else if (type === 'danger') {
            toastHeader.classList.add('bg-danger', 'text-white');
            toastIcon.classList.add('fa-exclamation-circle');
        } else if (type === 'info') {
            toastHeader.classList.add('bg-info', 'text-white');
            toastIcon.classList.add('fa-info-circle');
        } else if (type === 'warning') {
            toastHeader.classList.add('bg-warning');
            toastIcon.classList.add('fa-exclamation-triangle');
        }
        
        toastTitle.innerText = title;
        toastMessage.innerText = message;
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }
    
    // Show toast for actions based on session messages
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showToast('Success', '{{ session('success') }}', 'success');
        @endif
        
        @if(session('error'))
            showToast('Error', '{{ session('error') }}', 'danger');
        @endif
    });
</script>
@endpush