@extends('layouts.dashboard')

@section('title', 'Manage Students')

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

<!-- Alert Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <span class="alert-icon"><i class="fas fa-check-circle me-2"></i></span>
        <span class="alert-text">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <span class="alert-icon"><i class="fas fa-exclamation-circle me-2"></i></span>
        <span class="alert-text">{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <!-- Add Student Modal -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold"><i class="fas fa-user-plus text-primary me-2"></i>Add New Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.students.store') }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Student ID</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-id-card text-primary"></i>
                                    </span>
                                    <input type="text" name="student_id" class="form-control border-start-0 ps-3" placeholder="Enter student ID" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control border-start-0 ps-3" placeholder="Enter full name" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-3" placeholder="Enter email address" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Course</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-graduation-cap text-primary"></i>
                                    </span>
                                    <input type="text" name="course" class="form-control border-start-0 ps-3" placeholder="Enter course" required>
                                </div>
                            </div>
                            <div class="mb-4">
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
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-lock text-primary"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-3" placeholder="Enter password" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary px-4">Add Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Student Modal -->
        <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold"><i class="fas fa-user-edit text-primary me-2"></i>Edit Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editStudentForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Student ID</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-id-card text-primary"></i>
                                    </span>
                                    <input type="text" name="student_id" id="edit_student_id" class="form-control border-start-0 ps-3" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <input type="text" name="name" id="edit_name" class="form-control border-start-0 ps-3" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" name="email" id="edit_email" class="form-control border-start-0 ps-3" required>
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
                            <button type="submit" class="btn btn-primary px-4">Update Student</button>
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
                            <i class="fas fa-user-graduate me-2"></i>Student Management
                        </h6>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary btn-sm rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="fas fa-plus-circle me-1"></i> Add New Student
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body px-0 pt-3 pb-2">
                <!-- Nav tabs for separating students -->
                <ul class="nav nav-tabs mx-4 mb-3" id="studentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="enrolled-tab" data-bs-toggle="tab" data-bs-target="#enrolled" type="button" role="tab" aria-controls="enrolled" aria-selected="true">
                            <i class="fas fa-user-check text-success me-1"></i> Enrolled Students
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="unenrolled-tab" data-bs-toggle="tab" data-bs-target="#unenrolled" type="button" role="tab" aria-controls="unenrolled" aria-selected="false">
                            <i class="fas fa-user-times text-warning me-1"></i> Unenrolled Students
                        </button>
                    </li>
                </ul>
                
                <!-- Tab content -->
                <div class="tab-content">
                    <!-- Enrolled Students Tab -->
                    <div class="tab-pane fade show active" id="enrolled" role="tabpanel" aria-labelledby="enrolled-tab">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Student ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Course</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Year Level</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($enrolledStudents as $student)
                                        <tr>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-3">{{ $student->student_id }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $student->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-3">{{ $student->email }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-3">{{ $student->course }}</p>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary py-2">Year {{ $student->year_level }}</span>
                                            </td>
                                            <td class="align-middle ps-3">
                                                <button class="btn btn-info btn-sm rounded-pill shadow-sm" 
                                                        onclick="editStudent({{ $student->id }}, '{{ $student->name }}', '{{ $student->email }}', '{{ $student->course }}', '{{ $student->year_level }}', '{{ $student->student_id }}')"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editStudentModal">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-user-graduate fa-3x text-secondary opacity-50 mb-3"></i>
                                                    <h6 class="text-secondary">No enrolled students found</h6>
                                                    <p class="text-xs text-secondary">Students will appear here once they are enrolled</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination for enrolled students -->
                        <div class="px-3 py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="text-secondary text-xs mb-2 mb-md-0">
                                    Showing <span class="fw-bold">{{ $enrolledStudents->firstItem() ?? 0 }}</span> to 
                                    <span class="fw-bold">{{ $enrolledStudents->lastItem() ?? 0 }}</span> of 
                                    <span class="fw-bold">{{ $enrolledStudents->total() }}</span> enrolled students
                                </div>
                                <div>
                                    {{ $enrolledStudents->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Unenrolled Students Tab -->
                    <div class="tab-pane fade" id="unenrolled" role="tabpanel" aria-labelledby="unenrolled-tab">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Student ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Course</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Year Level</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unenrolledStudents as $student)
                                        <tr>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-3">{{ $student->student_id }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $student->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-3">{{ $student->email }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-3">{{ $student->course }}</p>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary py-2">Year {{ $student->year_level }}</span>
                                            </td>
                                            <td class="align-middle ps-3">
                                                <button class="btn btn-info btn-sm rounded-pill shadow-sm me-1" 
                                                        onclick="editStudent({{ $student->id }}, '{{ $student->name }}', '{{ $student->email }}', '{{ $student->course }}', '{{ $student->year_level }}', '{{ $student->student_id }}')"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editStudentModal">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </button>
                                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill shadow-sm" 
                                                           onclick="return confirm('Are you sure you want to delete this student?')">
                                                        <i class="fas fa-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-user-times fa-3x text-secondary opacity-50 mb-3"></i>
                                                    <h6 class="text-secondary">No unenrolled students found</h6>
                                                    <p class="text-xs text-secondary">Click on "Add New Student" to create one</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination for unenrolled students -->
                        <div class="px-3 py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="text-secondary text-xs mb-2 mb-md-0">
                                    Showing <span class="fw-bold">{{ $unenrolledStudents->firstItem() ?? 0 }}</span> to 
                                    <span class="fw-bold">{{ $unenrolledStudents->lastItem() ?? 0 }}</span> of 
                                    <span class="fw-bold">{{ $unenrolledStudents->total() }}</span> unenrolled students
                                </div>
                                <div>
                                    {{ $unenrolledStudents->links() }}
                                </div>
                            </div>
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
    function editStudent(id, name, email, course, yearLevel, studentId) {
        document.getElementById('editStudentForm').action = `/admin/students/${id}`;
        document.getElementById('edit_student_id').value = studentId;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_course').value = course;
        document.getElementById('edit_year_level').value = yearLevel;
    }
    
    // Show toast notification function
    function showToast(title, message, type) {
        const toastEl = document.getElementById('liveToast');
        const toastHeader = document.getElementById('toastHeader');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');
        const toastIcon = document.getElementById('toastIcon');
        
        // Set toast content
        toastTitle.textContent = title;
        toastMessage.textContent = message;
        
        // Set toast type/color
        toastHeader.className = 'toast-header';
        if (type === 'success') {
            toastHeader.classList.add('bg-success', 'text-white');
            toastIcon.className = 'fas fa-check-circle me-2';
        } else if (type === 'danger') {
            toastHeader.classList.add('bg-danger', 'text-white');
            toastIcon.className = 'fas fa-exclamation-circle me-2';
        } else if (type === 'warning') {
            toastHeader.classList.add('bg-warning', 'text-white');
            toastIcon.className = 'fas fa-exclamation-triangle me-2';
        } else {
            toastHeader.classList.add('bg-primary', 'text-white');
            toastIcon.className = 'fas fa-info-circle me-2';
        }
        
        // Show toast
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
</script>

<style>
.cursor-pointer { cursor: pointer; }
.hover-bg-light:hover { background-color: #f8f9fa; }
.bg-gray-100 { background-color: #f8f9fa; }
.text-xs { font-size: 0.75rem; }
.text-sm { font-size: 0.875rem; }
</style>
@endpush