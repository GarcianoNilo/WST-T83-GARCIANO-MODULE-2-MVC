@extends('layouts.dashboard')

@section('title', 'Manage Grades')

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
        <!-- Add Grade Modal -->
        <div class="modal fade" id="addGradeModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold"><i class="fas fa-graduation-cap text-primary me-2"></i>Add New Grade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.grades.store') }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Student ID</label>
                                <div class="position-relative">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                            <i class="fas fa-id-card text-dark"></i>
                                        </span>
                                        <input type="text" id="student_id_input" class="form-control border-start-0 ps-3" 
                                               placeholder="Enter Student ID" autocomplete="off" required>
                                    </div>
                                    <div id="student_suggestions" class="position-absolute w-100 mt-1 shadow border rounded bg-white" 
                                         style="display:none; z-index:1000; max-height:200px; overflow-y:auto;"></div>
                                </div>
                                <input type="hidden" name="user_id" id="user_id_input">
                                <div id="student_details" class="mt-2 text-sm"></div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Subject Code</label>
                                <div class="position-relative">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                            <i class="fas fa-book text-dark"></i>
                                        </span>
                                        <input type="text" id="subject_code_input" class="form-control border-start-0 ps-3"
                                               placeholder="Enter Subject Code" autocomplete="off" disabled required>
                                    </div>
                                    <div id="subject_suggestions" class="position-absolute w-100 mt-1 shadow border rounded bg-white" 
                                         style="display:none; z-index:1000; max-height:200px; overflow-y:auto;"></div>
                                </div>
                                <input type="hidden" name="enrollment_id" id="enrollment_id_input">
                                <div id="subject_details" class="mt-2 text-sm"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label class="form-label fw-bold text-dark">Final Grade</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                            <i class="fas fa-star text-dark"></i>
                                        </span>
                                        <select name="final_grade" class="form-control border-start-0 ps-3" required>
                                            <option value="">Select Grade</option>
                                            <option value="1.00">1.00</option>
                                            <option value="1.25">1.25</option>
                                            <option value="1.50">1.50</option>
                                            <option value="1.75">1.75</option>
                                            <option value="2.00">2.00</option>
                                            <option value="2.25">2.25</option>
                                            <option value="2.50">2.50</option>
                                            <option value="2.75">2.75</option>
                                            <option value="3.00">3.00</option>
                                            <option value="5.00">5.00</option>
                                            <option value="INC">INC</option>
                                            <option value="DRP">DRP</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <label class="form-label fw-bold text-dark">Academic Year</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                            <i class="fas fa-calendar-alt text-dark"></i>
                                        </span>
                                        <input type="text" name="academic_year" id="academic_year_input" class="form-control border-start-0 ps-3 bg-light"
                                               readonly required>
                                    </div>
                                    <div class="text-muted small mt-1">
                                        <i class="fas fa-info-circle me-1"></i> Automatically set to current academic year
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <label class="form-label fw-bold text-dark">Semester</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                            <i class="fas fa-university text-dark"></i>
                                        </span>
                                        <input type="text" name="semester" id="semester_input" class="form-control border-start-0 ps-3 bg-light"
                                               readonly required>
                                    </div>
                                    <div class="text-muted small mt-1">
                                        <i class="fas fa-info-circle me-1"></i> Automatically set to current semester
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary px-4">Add Grade</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Grade Modal -->
        <div class="modal fade" id="editGradeModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold"><i class="fas fa-edit text-primary me-2"></i>Edit Grade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editGradeForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Student:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-user-graduate text-dark"></i>
                                    </span>
                                    <div id="edit_student_name" class="form-control bg-light"></div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Subject:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-book-open text-dark"></i>
                                    </span>
                                    <div id="edit_subject_name" class="form-control bg-light"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Final Grade</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="width: 40px; justify-content: center;">
                                        <i class="fas fa-star text-dark"></i>
                                    </span>
                                    <select name="final_grade" id="edit_grade" class="form-control border-start-0 ps-3" required>
                                        <option value="1.00">1.00</option>
                                        <option value="1.25">1.25</option>
                                        <option value="1.50">1.50</option>
                                        <option value="1.75">1.75</option>
                                        <option value="2.00">2.00</option>
                                        <option value="2.25">2.25</option>
                                        <option value="2.50">2.50</option>
                                        <option value="2.75">2.75</option>
                                        <option value="3.00">3.00</option>
                                        <option value="5.00">5.00</option>
                                        <option value="INC">INC</option>
                                        <option value="DRP">DRP</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary px-4">Update Grade</button>
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
                            <i class="fas fa-graduation-cap me-2"></i>Grades Management
                        </h6>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary btn-sm rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addGradeModal">
                            <i class="fas fa-plus-circle me-1"></i> Add New Grade
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-3 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Student</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Subject</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Grade</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Remarks</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Academic Details</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $grade->enrollment->student->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">ID: {{ $grade->enrollment->student->student_id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column px-3 py-2">
                                        <h6 class="mb-0 text-sm">{{ $grade->enrollment->subject->name }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $grade->enrollment->subject->code }}</p>
                                    </div>
                                </td>
                                <td class="px-3 py-2">
                                    @php
                                        $badgeClass = 'bg-success';
                                        if ($grade->final_grade == '5.00') {
                                            $badgeClass = 'bg-danger';
                                        } elseif ($grade->final_grade == 'INC') {
                                            $badgeClass = 'bg-warning';
                                        } elseif ($grade->final_grade == 'DRP') {
                                            $badgeClass = 'bg-secondary';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }} bg-opacity-10 text-{{ str_replace('bg-', '', $badgeClass) }} border border-{{ str_replace('bg-', '', $badgeClass) }}-subtle py-2 px-2">
                                        {{ $grade->final_grade }}
                                    </span>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="badge bg-{{ $grade->remarks == 'Failed' ? 'danger' : ($grade->remarks == 'Incomplete' || $grade->remarks == 'Dropped' ? 'warning' : 'success') }}-subtle text-{{ $grade->remarks == 'Failed' ? 'danger' : ($grade->remarks == 'Incomplete' || $grade->remarks == 'Dropped' ? 'warning' : 'success') }} py-2">
                                        {{ $grade->remarks }}
                                    </span>
                                </td>
                                <td class="px-3 py-2">
                                    <small class="text-xs text-secondary">
                                        {{ $grade->enrollment->academic_year }} · {{ $grade->enrollment->semester }} Semester
                                    </small>
                                </td>
                                <td class="px-3 py-2">
                                    <button class="btn btn-info btn-sm rounded-pill me-1 shadow-sm" 
                                            onclick="editGrade({{ $grade->id }})"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editGradeModal">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.grades.destroy', $grade->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill shadow-sm" 
                                                onclick="return confirm('Are you sure you want to delete this grade?'); showToast('Grade Deleted', 'Grade has been successfully removed', 'danger');">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-graduation-cap fa-3x text-secondary opacity-50 mb-3"></i>
                                        <h6 class="text-secondary">No grades available</h6>
                                        <p class="text-xs text-secondary">Click on "Add New Grade" to create one</p>
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
                            Showing <span class="fw-bold">{{ $grades->firstItem() ?? 0 }}</span> to 
                            <span class="fw-bold">{{ $grades->lastItem() ?? 0 }}</span> of 
                            <span class="fw-bold">{{ $grades->total() }}</span> grades
                        </div>
                        <div>
                            {{ $grades->links() }}
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
// Fix any canvas-related errors by checking if the element exists before using it
document.addEventListener('DOMContentLoaded', function() {
    // Set current academic year and semester automatically
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1; // Months are 0-indexed
    const currentYear = currentDate.getFullYear();
    
    // Academic year calculation
    // If we're in June to December, it's the current year to next year
    // If we're in January to May, it's the previous year to current year
    let academicYear;
    if (currentMonth >= 6) {
        academicYear = `${currentYear}-${currentYear + 1}`;
    } else {
        academicYear = `${currentYear - 1}-${currentYear}`;
    }
    
    // Semester calculation
    // 1st semester: June to October
    // 2nd semester: November to May
    let semester;
    if (currentMonth >= 6 && currentMonth <= 10) {
        semester = '1st';
    } else {
        semester = '2nd';
    }
    
    // Set the values in the form
    if (document.getElementById('academic_year_input')) {
        document.getElementById('academic_year_input').value = academicYear;
    }
    if (document.getElementById('semester_input')) {
        document.getElementById('semester_input').value = semester;
    }
    
    // Prevent error for missing orbit-controls.js
    const oldCreateElement = document.createElement;
    document.createElement = function(tag) {
        const element = oldCreateElement.call(document, tag);
        if (tag.toLowerCase() === 'script') {
            setTimeout(() => {
                if (element.src && element.src.includes('orbit-controls.js')) {
                    element.onload = null;
                    element.onerror = null;
                }
            }, 0);
        }
        return element;
    };
    
    // Fix "Cannot read properties of null (reading 'getContext')" error
    const canvasInitializers = [];
    const originalGetElementById = document.getElementById;
    document.getElementById = function(id) {
        const element = originalGetElementById.call(document, id);
        // If element not found and it might be a canvas that's being looked for
        if (!element && id.includes('chart')) {
            return {
                getContext: function() { return { font: '', fillStyle: '', fillRect: function() {}, fillText: function() {} }; }
            };
        }
        return element;
    };

    // Initialize the subject_code_input as disabled until a student is selected
    if(document.getElementById('subject_code_input')) {
        document.getElementById('subject_code_input').disabled = true;
    }

    // Reset form fields when modal is hidden
    const modal = document.getElementById('addGradeModal');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('student_id_input').value = '';
            document.getElementById('student_details').innerHTML = '';
            document.getElementById('user_id_input').value = '';
            document.getElementById('subject_code_input').value = '';
            document.getElementById('subject_details').innerHTML = '';
            document.getElementById('enrollment_id_input').value = '';
            document.getElementById('subject_code_input').disabled = true;
        });
    }
});

// Main functionality
let searchTimeout;

function updateStudentDetails(student) {
    if (student) {
        document.getElementById('student_details').innerHTML = 
            `<div class="card border-0 shadow-sm mb-0 mt-2">
                <div class="card-body p-3 bg-gray-100">
                    <h6 class="mb-2 text-dark"><i class="fas fa-user-graduate me-2"></i>Student Information</h6>
                    <div class="mb-1"><strong>Name:</strong> ${student.name}</div>
                    <div class="mb-1"><strong>Course:</strong> ${student.course}</div>
                    <div class="mb-0"><strong>Year Level:</strong> ${student.year_level}</div>
                </div>
            </div>`;
        document.getElementById('user_id_input').value = student.id;
        document.getElementById('student_id_input').value = student.student_id;
        
        // Enable subject input after student is selected
        document.getElementById('subject_code_input').disabled = false;
        document.getElementById('subject_code_input').focus(); // Focus on subject input
        document.getElementById('student_suggestions').style.display = 'none';
    }
}

function updateSubjectDetails(subject) {
    if (subject) {
        document.getElementById('subject_details').innerHTML = 
            `<div class="card border-0 shadow-sm mb-0 mt-2">
                <div class="card-body p-3 bg-gray-100">
                    <h6 class="mb-2 text-dark"><i class="fas fa-book-open me-2"></i>Subject Information</h6>
                    <div class="mb-1"><strong>Name:</strong> ${subject.name}</div>
                    <div class="mb-1"><strong>Code:</strong> ${subject.code}</div>
                    <div class="mb-0"><strong>Units:</strong> ${subject.units}</div>
                </div>
            </div>`;
        document.getElementById('enrollment_id_input').value = subject.enrollment_id;
        document.getElementById('subject_code_input').value = subject.code;
        document.getElementById('subject_suggestions').style.display = 'none';
    }
}

// Add student search functionality
document.getElementById('student_id_input').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    const searchTerm = e.target.value.trim();
    const suggestionsDiv = document.getElementById('student_suggestions');

    if (searchTerm.length < 2) {
        suggestionsDiv.style.display = 'none';
        return;
    }

    searchTimeout = setTimeout(() => {
        // Show loading indicator
        suggestionsDiv.innerHTML = '<div class="p-2 text-center"><div class="spinner-border spinner-border-sm text-secondary" role="status"></div> Searching...</div>';
        suggestionsDiv.style.display = 'block';
        
        fetch(`/admin/search-students/${searchTerm}`)
            .then(response => response.json())
            .then(students => {
                if (students.length > 0) {
                    suggestionsDiv.innerHTML = students.map(student => `
                        <div class="p-3 border-bottom cursor-pointer hover-bg-light" 
                             onclick="updateStudentDetails(${JSON.stringify(student).replace(/"/g, '&quot;')})">
                            <div class="d-flex justify-content-between">
                                <strong>${student.student_id}</strong>
                                <span class="badge bg-secondary text-white">${student.course}</span>
                            </div>
                            <div>${student.name}</div>
                        </div>
                    `).join('');
                    suggestionsDiv.style.display = 'block';
                } else {
                    suggestionsDiv.innerHTML = '<div class="p-3 text-center text-muted">No students found</div>';
                }
            })
            .catch(err => {
                suggestionsDiv.innerHTML = '<div class="p-3 text-center text-danger">Error searching students</div>';
            });
    }, 300);
});

// Add subject search functionality with corrected route
document.getElementById('subject_code_input').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    const searchTerm = e.target.value.trim();
    const suggestionsDiv = document.getElementById('subject_suggestions');
    const studentId = document.getElementById('user_id_input').value;

    if (!studentId) {
        alert('Please select a student first');
        return;
    }

    if (searchTerm.length < 2) {
        suggestionsDiv.style.display = 'none';
        return;
    }

    searchTimeout = setTimeout(() => {
        // Show loading indicator
        suggestionsDiv.innerHTML = '<div class="p-2 text-center"><div class="spinner-border spinner-border-sm text-secondary" role="status"></div> Searching...</div>';
        suggestionsDiv.style.display = 'block';
        
        fetch(`/admin/search-subjects/${searchTerm}/${studentId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(subjects => {
                if (subjects.length > 0) {
                    suggestionsDiv.innerHTML = subjects.map(subject => `
                        <div class="p-3 border-bottom cursor-pointer hover-bg-light" 
                             onclick="updateSubjectDetails(${JSON.stringify(subject).replace(/"/g, '&quot;')})">
                            <div class="d-flex justify-content-between">
                                <strong>${subject.code}</strong>
                                <span class="badge bg-dark text-white">${subject.units} units</span>
                            </div>
                            <div>${subject.name}</div>
                        </div>
                    `).join('');
                    suggestionsDiv.style.display = 'block';
                } else {
                    suggestionsDiv.innerHTML = '<div class="p-3 text-center text-muted">No subjects available for grading</div>';
                    suggestionsDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching subjects:', error);
                suggestionsDiv.innerHTML = '<div class="p-3 text-center text-danger">Error fetching subjects</div>';
                suggestionsDiv.style.display = 'block';
            });
    }, 300);
});

// Close suggestions when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('#student_id_input')) {
        document.getElementById('student_suggestions').style.display = 'none';
    }
    if (!e.target.closest('#subject_code_input')) {
        document.getElementById('subject_suggestions').style.display = 'none';
    }
});

// Function to edit a grade
function editGrade(gradeId) {
    fetch(`/admin/grades/${gradeId}`)
        .then(response => response.json())
        .then(grade => {
            document.getElementById('edit_student_name').textContent = grade.enrollment.student.name + 
                                                                       ' (' + grade.enrollment.student.student_id + ')';
            document.getElementById('edit_subject_name').textContent = grade.enrollment.subject.code + 
                                                                       ' - ' + grade.enrollment.subject.name;
            document.getElementById('edit_grade').value = grade.final_grade;
            
            // Set the form action URL
            document.getElementById('editGradeForm').action = `/admin/grades/${gradeId}`;
        });
}
</script>

<script>
// Prevent duplicate declarations
if (typeof iconNavbarSidenav === 'undefined') {
    var iconNavbarSidenav;
    var iconSidenav;
    var sidenav;
    var iconRTL;
    var sidenavToggler;
    var referenceButtons;
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