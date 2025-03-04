@extends('layouts.dashboard')

@section('title', 'Student Dashboard')

@section('content')
<!-- Welcome Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient-primary">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="text-white mb-0">Welcome back, {{ $student->name }}!</h2>
                        <p class="text-white opacity-8 mb-0">{{ $currentAcademicYear }} | {{ $currentSemester }} Semester</p>
                        <p class="text-white opacity-8 mb-4">{{ $student->course }} | {{ $student->year_level }} Year</p>
                        <div class="d-flex">
                            <a href="{{ route('enrolledSubjects') }}" class="btn btn-white btn-sm me-2">View Enrolled Subjects</a>
                            <a href="{{ route('grades') }}" class="btn btn-outline-white btn-sm">Check Grades</a>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                        <div class="text-center text-white">
                            <h1 class="text-white mb-0 display-1" style="font-size: 4rem;">{{ $gwa > 0 ? $gwa : 'N/A' }}</h1>
                            <p class="mb-0">Current GWA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Current Subjects</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $currentEnrollments->count() }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fas fa-book text-lg opacity-10 text-white" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Units</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $totalEnrolledUnits }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                            <i class="fas fa-clock text-lg opacity-10 text-white" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Semester</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $currentSemester }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                            <i class="fas fa-calendar text-lg opacity-10 text-white" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Status</p>
                            <h5 class="font-weight-bolder mb-0 text-success">
                                {{ $student->is_enrolled ? 'Enrolled' : 'Not Enrolled' }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                            <i class="fas fa-user-graduate text-lg opacity-10 text-white" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Current Enrollments -->
    <div class="col-lg-8 mb-lg-0 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h6>Current Enrolled Subjects</h6>
                <p class="text-sm mb-0">
                    <span class="font-weight-bold">{{ $currentAcademicYear }}</span> | {{ $currentSemester }} Semester
                </p>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Code</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subject Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Units</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Schedule</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($currentEnrollments as $enrollment)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $enrollment->subject->code }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $enrollment->subject->name }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-success">{{ $enrollment->subject->units }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $enrollment->subject->schedule ?? 'TBA' }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <p class="text-sm mb-0">You are not currently enrolled in any subjects for this semester.</p>
                                    <p class="text-xs text-secondary">Please contact the registrar for enrollment.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Grade Distribution -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h6>Your Grade Distribution</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart">
                    <canvas id="grade-distribution-chart" class="chart-canvas" height="300"></canvas>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('grades') }}" class="text-sm font-weight-bold text-primary">View Detailed Grade Report</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Recent Activities</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0" style="max-height: 300px; overflow-y: auto;">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Activity</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Details</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $activity)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @if($activity['type'] == 'enrollment')
                                            <div class="icon icon-shape icon-sm bg-gradient-success shadow text-center me-2">
                                                <i class="fas fa-check text-white opacity-10"></i>
                                            </div>
                                            @else
                                            <div class="icon icon-shape icon-sm bg-gradient-info shadow text-center me-2">
                                                <i class="fas fa-chart-bar text-white opacity-10"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">
                                                {{ $activity['type'] == 'enrollment' ? 'Course Enrollment' : 'Grade Posted' }}
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">{{ $activity['subject'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $activity['details'] }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">
                                        {{ Carbon\Carbon::parse($activity['date'])->format('M d, Y') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <p class="text-secondary">No recent activities found.</p>
                                </td>
                            </tr>
                            @endforelse
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
document.addEventListener('DOMContentLoaded', function() {
  // Initialize charts with proper cleanup
  initializeCharts();
  
  function initializeCharts() {
    // Check for chart container
    const chartCanvas = document.getElementById('grade-distribution-chart');
    if (!chartCanvas) return;
    
    // Destroy any existing chart instance to prevent errors
    if (window.gradeDistChart) {
      window.gradeDistChart.destroy();
    }
    
    try {
      // Use existing chart data
      const gradeLabels = {!! isset($gradeDistribution) ? json_encode(array_keys($gradeDistribution)) : '["1.00", "1.25", "1.50", "1.75", "2.00", "2.25", "2.50", "2.75", "3.00", "5.00", "INC", "DRP"]' !!};
      const gradeValues = {!! isset($gradeDistribution) ? json_encode(array_values($gradeDistribution)) : '[3, 6, 8, 4, 2, 1, 1, 1, 1, 0, 0, 0]' !!};
      
      // Color mapping based on grades
      const getColorForGrade = (grade) => {
        // Convert string grade to number if possible
        const numGrade = parseFloat(grade);
        
        // Handle non-numeric grades
        if (isNaN(numGrade)) {
          if (grade === 'INC') return '#FFA726'; // Orange for incomplete
          if (grade === 'DRP') return '#BDBDBD'; // Gray for dropped
          return '#BDBDBD'; // Default gray for unknown
        }
        
        // Color scheme based on grade value
        if (numGrade === 1.00) return '#0066CC'; // BukSU blue - best grade
        if (numGrade <= 1.25) return '#1A75D1';
        if (numGrade <= 1.50) return '#3385D6';
        if (numGrade <= 1.75) return '#4D94DB';
        if (numGrade <= 2.00) return '#66A3E0';
        if (numGrade <= 2.25) return '#80B2E6';
        if (numGrade <= 2.50) return '#99C2EB';
        if (numGrade <= 2.75) return '#B3D1F0';
        if (numGrade <= 3.00) return '#CCE0F5'; // Lightest blue - passing
        if (numGrade === 5.00) return '#F44336'; // Red - failing
        
        return '#E6F0FF'; // Default light blue
      };
      
      // Apply colors based on grades
      const backgroundColors = gradeLabels.map(grade => getColorForGrade(grade));
      
      // Create new chart instance with grade-based colors
      window.gradeDistChart = new Chart(chartCanvas.getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: gradeLabels,
          datasets: [{
            data: gradeValues,
            backgroundColor: backgroundColors,
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '70%',
          plugins: {
            legend: {
              display: true,
              position: 'bottom',
              labels: {
                boxWidth: 12,
                padding: 15
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const label = context.label || '';
                  const value = context.raw || 0;
                  const total = context.dataset.data.reduce((a, b) => a + b, 0);
                  const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                  return `${label}: ${value} (${percentage}%)`;
                }
              }
            }
          }
        }
      });
      
      console.log('Chart initialized successfully with grade-based colors');
      
    } catch (error) {
      console.error('Chart initialization error:', error);
    }
  }
});
</script>

<style>
/* Enhanced styling for dashboard elements */
.chart {
  position: relative;
  height: 300px;
  width: 100%;
  padding: 10px;
}

/* Fix chart container */
.chart-canvas {
  position: relative;
  height: 100% !important;
  width: 100% !important;
}

/* Added legend styling for better readability */
canvas + .chartjs-legend {
  margin-top: 15px;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.chartjs-legend li {
  display: inline-flex;
  align-items: center;
  margin-right: 10px;
  margin-bottom: 5px;
}

.chartjs-legend li span {
  display: inline-block;
  width: 12px;
  height: 12px;
  margin-right: 5px;
  border-radius: 2px;
}

/* Animated hover effects for dashboard cards */
.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

/* Style improvements for icons in cards */
.card .icon {
  transition: all 0.3s ease;
}

.card:hover .icon {
  transform: scale(1.1);
  box-shadow: 0 6px 12px rgba(0, 102, 204, 0.3);
}
</style>
@endpush