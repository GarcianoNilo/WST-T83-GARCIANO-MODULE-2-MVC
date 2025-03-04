@extends('layouts.dashboard')

@section('title', 'Enrolled Subjects')

@section('content')
<!-- Header -->
<div class="card bg-gradient-info mb-4">
  <div class="card-body p-4">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h3 class="text-white mb-0">Enrolled Subjects</h3>
        <p class="text-white opacity-8 mb-0">View all your enrolled subjects for the current academic year and semester</p>
      </div>
      <div class="col-md-4 text-end">
        <a href="{{ route('dashboard') }}" class="btn btn-white btn-sm">Back to Dashboard</a>
      </div>
    </div>
  </div>
</div>

<!-- Filter Controls -->
<div class="card mb-4">
  <div class="card-body p-3">
    <form action="{{ route('enrolledSubjects') }}" method="GET" class="row align-items-center">
      <div class="col-md-4">
        <label class="form-label mb-0">Academic Year</label>
        <select name="academic_year" class="form-control form-control-sm" onchange="this.form.submit()">
          @foreach($academicYears as $year)
            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
              {{ $year }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label mb-0">Semester</label>
        <select name="semester" class="form-control form-control-sm" onchange="this.form.submit()">
          <option value="1st" {{ $selectedSemester == '1st' ? 'selected' : '' }}>1st Semester</option>
          <option value="2nd" {{ $selectedSemester == '2nd' ? 'selected' : '' }}>2nd Semester</option>
        </select>
      </div>
      <div class="col-md-4 d-flex align-items-center justify-content-end">
        <div class="badge bg-gradient-primary">
          <span class="badge-value">{{ $enrollments->count() }}</span> Subjects
        </div>
        <div class="badge bg-gradient-success ms-2">
          <span class="badge-value">{{ $totalUnits }}</span> Total Units
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Main Content -->
<div class="card">
  <div class="card-header p-3">
    <div class="row">
      <div class="col-md-8">
        <h6 class="mb-0">{{ $selectedYear }} | {{ $selectedSemester }} Semester</h6>
      </div>
      <div class="col-md-4">
        <div class="input-group input-group-sm">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
          <input type="text" id="subjectSearch" class="form-control" placeholder="Search subjects...">
        </div>
      </div>
    </div>
  </div>
  
  <div class="table-responsive">
    <table class="table align-items-center mb-0" id="subjectsTable">
      <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Class</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Code</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Units</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Instructor</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Section</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($enrollments as $index => $enrollment)
        <tr>
          <td>
            <div class="d-flex px-2 py-1">
              <div class="icon icon-shape icon-sm bg-gradient-{{ ['primary', 'info', 'success', 'warning', 'danger', 'dark'][$index % 6] }} shadow text-center me-2 d-flex align-items-center justify-content-center rounded-circle">
                <span class="text-white text-xs">T{{ 83 - $index }}</span>
              </div>
              <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-xs">T{{ 83 - $index }}</h6>
              </div>
            </div>
          </td>
          <td>
            <div class="d-flex px-2 py-1">
              <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-xs">{{ $enrollment->subject->code }}</h6>
              </div>
            </div>
          </td>
          <td>
            <div class="d-flex px-2 py-1">
              <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-xs">{{ $enrollment->subject->name }}</h6>
                <p class="text-xs text-secondary mb-0">{{ $enrollment->subject->description ?? 'No description available' }}</p>
              </div>
            </div>
          </td>
          <td class="align-middle text-center">
            <span class="badge badge-sm bg-gradient-success">{{ $enrollment->subject->units }}</span>
          </td>
          <td>
            <div class="d-flex px-2 py-1">
              <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-xs">{{ $instructors[$enrollment->subject->code] ?? 'TBA' }}</h6>
              </div>
            </div>
          </td>
          <td>
            <div class="d-flex px-2 py-1">
              <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-xs">{{ $student->course }} {{ $student->year_level }}{{ chr(64 + 1) }}</h6>
              </div>
            </div>
          </td>
          <td>
            <span class="badge badge-sm bg-gradient-primary">Active</span>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center py-4">
            <div class="d-flex flex-column align-items-center">
              <i class="fas fa-book-open fa-3x text-secondary mb-2"></i>
              <h6 class="text-secondary">No subjects enrolled for this semester</h6>
              <p class="text-xs text-secondary">Please contact the registrar for enrollment assistance</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modify the Summary Card section with better spacing -->
<div class="row mt-4">
  <div class="col-lg-8">
    <div class="card z-index-2">
      <div class="card-body p-3">
        <div class="row align-items-center">
          <div class="col-8">
            <h6 class="text-capitalize mb-2">Summary</h6>
            <div class="d-flex flex-column">
              <div class="d-flex justify-content-between mb-1">
                <span class="text-sm font-weight-bold">Total Subjects:</span>
                <span class="text-sm">{{ $enrollments->count() }}</span>
              </div>
              <div class="d-flex justify-content-between mb-1">
                <span class="text-sm font-weight-bold">Total Units:</span>
                <span class="text-sm">{{ $totalUnits }}</span>
              </div>
              <div class="d-flex justify-content-between">
                <span class="text-sm font-weight-bold">Academic Term:</span>
                <span class="text-sm">{{ $selectedYear }} ({{ $selectedSemester }} Semester)</span>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="chart" style="height: 80px;">
              <canvas id="units-chart" class="chart-canvas" height="80"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="card z-index-2 h-100">
      <div class="card-body p-3 d-flex flex-column justify-content-center text-center">
        <h6 class="text-capitalize mb-0">Enrollment Status</h6>
        <hr class="horizontal dark my-2">
        <h5 class="mb-0 text-success">Officially Enrolled</h5>
        <p class="text-sm mb-0">Last updated {{ Carbon\Carbon::now()->format('M d, Y') }}</p>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Simple subject search functionality
  document.getElementById('subjectSearch').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.getElementById('subjectsTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
      const subjectCode = rows[i].getElementsByTagName('td')[1]?.textContent.toLowerCase() || '';
      const description = rows[i].getElementsByTagName('td')[2]?.textContent.toLowerCase() || '';
      const instructor = rows[i].getElementsByTagName('td')[4]?.textContent.toLowerCase() || '';
      
      if (subjectCode.includes(searchTerm) || description.includes(searchTerm) || instructor.includes(searchTerm)) {
        rows[i].style.display = '';
      } else {
        rows[i].style.display = 'none';
      }
    }
  });
  
  // Units distribution pie chart
  var ctx = document.getElementById('units-chart');
  if (ctx) {
    ctx = ctx.getContext('2d');
    
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Major', 'Minor', 'Gen Ed'],
        datasets: [{
          label: 'Units',
          data: [{{ $totalUnits * 0.6 }}, {{ $totalUnits * 0.2 }}, {{ $totalUnits * 0.2 }}],
          backgroundColor: [
            'rgba(66, 135, 245, 0.8)',
            'rgba(66, 204, 245, 0.8)',
            'rgba(245, 171, 66, 0.8)'
          ],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        cutout: '70%'
      }
    });
  }
});
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
.badge-value {
  font-size: 0.9rem;
  font-weight: 600;
}

/* Fix for Summary Card spacing */
.card .card-body {
  padding: 1rem;
}

/* Better alignment for summary text */
.card .text-sm {
  font-size: 0.8rem !important;
  line-height: 1.4;
}

/* Match heights of summary cards */
.row.mt-4 .card {
  height: 100%;
}

/* Adjust chart size */
#units-chart {
  max-height: 80px !important;
}

/* Improved chart label styling */
Chart.defaults.font.size = 10;
</style>
@endpush
