@extends('layouts.dashboard')

@section('title', 'Manage Subjects')

@section('content')
<!-- Add error/success messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
        <div class="card mb-4 shadow-sm">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 py-1">Manage Subjects</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                    <i class="fas fa-plus me-1"></i> Add New Subject
                </button>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Code</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Units</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Course</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Year Level</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 px-2 py-2">{{ $subject->code }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 px-2 py-2">{{ $subject->name }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 px-2 py-2">{{ $subject->units }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 px-2 py-2">{{ $subject->course }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 px-2 py-2">{{ $subject->year_level }}</p>
                                </td>
                                <td class="px-2 py-2">
                                    <button class="btn btn-info btn-sm rounded-1 me-1" 
                                            onclick="editSubject({{ $subject->id }}, '{{ $subject->code }}', '{{ $subject->name }}', {{ $subject->units }}, '{{ $subject->course }}', '{{ $subject->year_level }}')"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editSubjectModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-1" onclick="return confirm('Are you sure you want to delete this subject?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
    function editSubject(id, code, name, units, course, yearLevel) {
        document.getElementById('editSubjectForm').action = `/admin/subjects/${id}`;
        document.getElementById('edit_code').value = code;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_units').value = units;
        document.getElementById('edit_course').value = course;
        document.getElementById('edit_year_level').value = yearLevel;
    }
</script>
@endpush