@extends('layouts.dashboard')

@section('title', 'Manage Students')

@section('content')
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
        <div class="card mb-4 shadow-sm">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 py-1">Manage Students</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="fas fa-plus me-1"></i> Add New Student
                </button>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 px-3 py-2">{{ $student->student_id }}</p>
                                </td>
                                <td>
                                    <div class="d-flex px-3 py-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $student->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 px-3 py-2">{{ $student->email }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 px-3 py-2">{{ $student->course }}</p>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="badge bg-{{ $student->is_enrolled ? 'success' : 'warning' }} px-3 py-2">
                                        {{ $student->is_enrolled ? 'Enrolled' : 'Not Enrolled' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2">
                                    <button class="btn btn-info btn-sm rounded-1 me-1" 
                                            onclick="editStudent({{ $student->id }}, '{{ $student->name }}', '{{ $student->email }}', '{{ $student->course }}', '{{ $student->year_level }}', '{{ $student->student_id }}')"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editStudentModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if(!$student->is_enrolled)
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-1" onclick="return confirm('Are you sure you want to delete this student?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
</script>
@endpush