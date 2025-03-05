@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Students</p>
              <h5 class="font-weight-bolder mb-0">
                {{ $totalStudents }}
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape shadow-lg text-center border-radius-md" style="background: linear-gradient(310deg, #17ad37, #98ec2d)">
              <i class="fas fa-users text-lg opacity-10 text-white" aria-hidden="true"></i>
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
              <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Subjects</p>
              <h5 class="font-weight-bolder mb-0">
                {{ $totalSubjects }}
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape shadow-lg text-center border-radius-md" style="background: linear-gradient(310deg, #2152ff, #21d4fd)">
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
              <p class="text-sm mb-0 text-capitalize font-weight-bold">Enrolled Students</p>
              <h5 class="font-weight-bolder mb-0">
                {{ $enrolledStudents }}
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape shadow-lg text-center border-radius-md" style="background: linear-gradient(310deg, #f53939, #fbcf33)">
              <i class="fas fa-user-check text-lg opacity-10 text-white" aria-hidden="true"></i>
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
              <p class="text-sm mb-0 text-capitalize font-weight-bold">Average GWA</p>
              <h5 class="font-weight-bolder mb-0">
                {{ $averageGwa }}
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape shadow-lg text-center border-radius-md" style="background: linear-gradient(310deg, #7928ca, #ff0080)">
              <i class="fas fa-chart-line text-lg opacity-10 text-white" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Monthly Enrollments ({{ Carbon\Carbon::now()->year }})</h6>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-subjects" class="chart-canvas" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h6>Top Performing Students</h6>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">GWA</th>
              </tr>
            </thead>
            <tbody>
              @foreach($topStudents as $student)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-xs">{{ $student->name }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $student->email }}</p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $student->course }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $student->gwa > 0 ? $student->gwa : 'N/A' }}</span>
                </td>
              </tr>
              @endforeach
              
              @if($topStudents->isEmpty())
              <tr>
                <td colspan="3" class="text-center">
                  <p class="text-xs">No student data available</p>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Replace the existing Student List card with this enhanced version -->
<div class="card mb-4 shadow-sm border-0 rounded-3">
  <div class="card-header pb-0 bg-white">
    <div class="row align-items-center">
      <div class="col">
        <h6 class="mb-0 text-primary fw-bold py-1">
          <i class="fas fa-user-graduate me-2"></i>Student Performance
        </h6>
      </div>
      <div class="col text-end">
        <a href="{{ route('admin.students.index') }}" class="btn btn-primary btn-sm rounded-pill shadow-sm">
          <i class="fas fa-users me-1"></i> View All Students
        </a>
      </div>
    </div>
  </div>
  
  <div class="card-body px-0 pt-3 pb-2">
    <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">
        <thead>
          <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Student</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Student ID</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Course</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">GWA</th>
          </tr>
        </thead>
        <tbody>
          @forelse($topStudents as $student)
          <tr>
            <td>
              <div class="d-flex px-2 py-1">
                <div class="avatar avatar-sm me-3 bg-primary-subtle rounded-circle">
                  <i class="fas fa-user text-primary position-absolute top-50 start-50 translate-middle"></i>
                </div>
                <div class="d-flex flex-column justify-content-center">
                  <h6 class="mb-0 text-sm">{{ $student->name }}</h6>
                  <p class="text-xs text-secondary mb-0">{{ $student->email }}</p>
                </div>
              </div>
            </td>
            <td>
              <p class="text-sm font-weight-bold mb-0 ps-3">{{ $student->student_id }}</p>
            </td>
            <td>
              <span class="badge bg-info-subtle text-info py-2 px-3">{{ $student->course }}</span>
            </td>
            <td>
              @if($student->gwa > 0)
                <span class="badge bg-{{ $student->gwa <= 1.75 ? 'success' : ($student->gwa <= 2.5 ? 'primary' : 'warning') }}-subtle 
                      text-{{ $student->gwa <= 1.75 ? 'success' : ($student->gwa <= 2.5 ? 'primary' : 'warning') }} py-2 px-3">
                  {{ $student->gwa }}
                </span>
              @else
                <span class="badge bg-secondary-subtle text-secondary py-2 px-3">N/A</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center py-4">
              <div class="d-flex flex-column align-items-center">
                <i class="fas fa-chart-line fa-3x text-secondary opacity-50 mb-3"></i>
                <h6 class="text-secondary">No student performance data available</h6>
                <p class="text-xs text-secondary">Student GWA will appear here once grades are recorded</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    
    <div class="px-3 py-3">
      <div class="d-flex justify-content-between align-items-center">
        <div class="text-secondary text-xs">
          <i class="fas fa-info-circle me-1"></i> Showing top {{ $topStudents->count() }} students sorted by GWA
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
// Fix canvas-related errors 
document.addEventListener('DOMContentLoaded', function() {
  var ctx = document.getElementById("chart-subjects");
  
  if (ctx) {
    ctx = ctx.getContext("2d");
    
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: {!! json_encode($enrollmentByMonth) !!},
        datasets: [{
          label: "Student Enrollments",
          data: {!! json_encode($monthlyEnrollments) !!},
          backgroundColor: "#cb0c9f",
          borderWidth: 1,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#b2b9bf',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#b2b9bf',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
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
@endpush