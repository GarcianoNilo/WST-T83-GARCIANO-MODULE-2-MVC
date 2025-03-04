<!--
=========================================================
* Bukidnon State University Student Information System
=========================================================
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-buksu.png') }}">
  <title>@yield('title') - BukSU Student Information System</title>
  
  <!-- Avenir STD Font -->
  <style>
    @font-face {
      font-family: 'Avenir STD';
      src: url('{{ asset('assets/fonts/AvenirStd-Roman.otf') }}') format('otf'),
          url('{{ asset('assets/fonts/AvenirStd-Roman.otf') }}') format('otf');
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }
    
    @font-face {
      font-family: 'Avenir STD';
      src: url('{{ asset('assets/fonts/AvenirStd-Black.otf') }}') format('otf'),
          url('{{ asset('assets/fonts/AvenirStd-Black.otf') }}') format('otf');
      font-weight: 900;
      font-style: normal;
      font-display: swap;
    }
    
    @font-face {
      font-family: 'Avenir STD';
      src: url('{{ asset('assets/fonts/AvenirStd-Book.otf') }}') format('otf'),
          url('{{ asset('assets/fonts/AvenirStd-Book.otf') }}') format('otf');
      font-weight: 300;
      font-style: normal;
      font-display: swap;
    }
    
    @font-face {
      font-family: 'Avenir STD';
      src: url('{{ asset('assets/fonts/AvenirStd-Medium.otf') }}') format('otf'),
          url('{{ asset('assets/fonts/AvenirStd-Medium.otf') }}') format('otf');
      font-weight: 500;
      font-style: normal;
      font-display: swap;
    }
    
    @font-face {
      font-family: 'Avenir STD';
      src: url('{{ asset('assets/fonts/AvenirStd-Heavy.otf') }}') format('otf'),
          url('{{ asset('assets/fonts/AvenirStd-Heavy.otf') }}') format('otf');
      font-weight: 700;
      font-style: normal;
      font-display: swap;
    }
  </style>
  
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
  
  <!-- BukSU Colors & Avenir STD font -->
  <style>
    :root {
      --buksu-blue: #0066CC;
      --buksu-blue-light: #4D94DB;
      --buksu-blue-dark: #004C99;
      --buksu-blue-pale: #E6F0FF;
      --buksu-accent: #5CACE2;
      --buksu-accent-light: #80BDE8;
      --buksu-gray: #6C757D;
      --buksu-light-gray: #F8F9FA;
    }
    
    body, h1, h2, h3, h4, h5, h6, p, span, a, div, button, input, select, textarea, .nav-link, .navbar-brand {
      font-family: 'Avenir STD', Helvetica, Arial, sans-serif !important;
    }
    
    .bg-gradient-primary {
      background-image: linear-gradient(310deg, var(--buksu-blue), var(--buksu-blue-light)) !important;
    }
    
    .bg-gradient-info {
      background-image: linear-gradient(310deg, var(--buksu-accent), var(--buksu-blue-light)) !important;
    }
    
    .text-primary, a.text-primary, .text-primary i {
      color: var(--buksu-blue) !important;
    }
    
    .text-info {
      color: var(--buksu-accent) !important;
    }
    
    .text-success, .text-success i {
      color: var(--buksu-blue) !important;
    }
    
    /* Dashboard Stats Cards Fix */
    .card .icon {
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: var(--buksu-blue) !important;
      color: #fff !important;
    }
    
    .card .icon i {
      color: #fff !important;
    }
    
    .card .icon.icon-shape {
      width: 48px;
      height: 48px;
      background-color: var(--buksu-blue) !important;
      box-shadow: 0 4px 10px rgba(0, 102, 204, 0.2);
    }
    
    /* Fix positioning in stats row */
    .row > div.col-xl-3 {
      display: block !important;
    }
    
    /* Make sure cards are properly positioned */
    .card.mb-4 {
      margin-bottom: 1.5rem !important;
    }
    
    .card .card-body {
      padding: 1rem 1.5rem;
    }
    
    /* Stats content styling */
    .card h6.text-sm {
      font-size: 0.875rem !important;
      font-weight: 500 !important;
      margin-bottom: 0.375rem !important;
      color: #8392AB !important;
    }
    
    .card h5.font-weight-bolder {
      font-size: 1.25rem !important;
      font-weight: 700 !important;
      margin-bottom: 0 !important;
      color: #344767 !important;
    }
    
    /* Fix icon alignment in the left sidebar */
    .sidenav {
      background: white !important;
      padding-right: 10px;
    }
    
    .sidenav-header {
      height: 80px;
    }
    
    .navbar-vertical .navbar-brand-img {
      max-height: 45px;
    }
    
    /* Fixed icon alignment and colors */
    .navbar-vertical .navbar-nav .nav-item .nav-link {
      margin: 0.5rem 0;
      padding: 0.675rem 1rem;
      display: flex;
      align-items: center;
    }
    
    .navbar-vertical .navbar-nav .nav-link.active {
      background-color: var(--buksu-blue-pale);
      border-radius: 0.5rem;
      margin-right: 10px;
    }
    
    .navbar-vertical .navbar-nav .nav-link.active .icon {
      background-color: var(--buksu-blue) !important;
    }
    
    .navbar-vertical .navbar-nav .nav-link.active .icon i {
      color: white !important;
    }
    
    .navbar-vertical .navbar-nav .nav-link:hover:not(.active) {
      background-color: rgba(230, 240, 255, 0.5);
      border-radius: 0.5rem;
      margin-right: 10px;
    }
    
    .navbar-vertical .navbar-nav .nav-link:hover:not(.active) .nav-link-text {
      color: var(--buksu-blue);
    }
    
    /* Fixed sidebar icon styling */
    .navbar-vertical .navbar-nav .nav-link .icon {
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 0.5rem;
      background: white !important;
      transition: all 0.2s ease-in-out;
      box-shadow: 0 2px 4px rgba(50, 50, 93, 0.1), 0 0 0 0.5px rgba(0, 0, 0, 0.02);
    }
    
    .navbar-vertical .navbar-nav .nav-link.active .icon {
      background: var(--buksu-blue) !important;
    }
    
    .navbar-vertical .navbar-nav .nav-link .icon i {
      font-size: 1rem;
      line-height: 1;
      color: #344767;
    }
    
    .navbar-vertical .navbar-nav .nav-link.active .icon i {
      color: white !important;
    }

    .chart {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .chart-canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }

    
    .nav-link-text {
      font-family: 'Avenir STD', Helvetica, Arial, sans-serif !important;
      font-weight: 500;
      color: #344767;
      font-size: 0.875rem;
    }
    
    .btn-primary {
      background-color: var(--buksu-blue) !important;
      border-color: var(--buksu-blue) !important;
    }
    
    .btn-info {
      background-color: var(--buksu-accent) !important;
      border-color: var(--buksu-accent) !important;
    }
    
    .btn-outline-primary {
      color: var(--buksu-blue) !important;
      border-color: var(--buksu-blue) !important;
    }
    
    .btn-outline-primary:hover {
      background-color: var(--buksu-blue) !important;
      color: white !important;
    }
    
    /* Grade reports styling */
    .grade-report {
      background-color: var(--buksu-blue-pale) !important;
      border-color: var(--buksu-blue-light) !important;
      color: var(--buksu-blue-dark) !important;
    }
    
    .profile-footer {
      position: absolute;
      bottom: 0;
      width: calc(100% - 34px); /* Adjusted for right padding */
      margin: 0 12px;
      padding-bottom: 12px;
      background-color: white;
    }
    
    .buksu-profile {
      border-top: 1px solid #f0f2f5;
      padding-top: 15px;
    }
    
    .innovation-badge {
      background-color: var(--buksu-blue);
      color: white;
      padding: 4px 8px;
      border-radius: 8px;
      font-size: 0.7rem;
      font-weight: 700;
    }
    
    /* Improved student badge with smooth gradient */
    .student-badge {
      background: linear-gradient(135deg, var(--buksu-blue) 0%, var(--buksu-accent) 100%);
      color: white;
      padding: 4px 8px;
      border-radius: 8px;
      font-size: 0.7rem;
      font-weight: 700;
      box-shadow: 0 2px 5px rgba(0, 102, 204, 0.2);
    }

    /* Fix badge placement - inline with name */
    .buksu-profile .d-flex.flex-column {
        flex-direction: row !important;
        align-items: center !important;
    }
    
    .buksu-profile h6.mb-0 {
        margin-right: 8px !important;
    }
    
    .buksu-profile p.mb-0 {
        margin-bottom: 0 !important;
        margin-top: 0 !important;
    }
    
    /* Improved student badge with smooth gradient - properly aligned */
    .student-badge {
        background: linear-gradient(135deg, var(--buksu-blue) 0%, var(--buksu-accent) 100%);
        color: white;
        padding: 3px 6px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        box-shadow: 0 2px 5px rgba(0, 102, 204, 0.2);
        display: inline-block;
        position: relative;
        top: -1px;
    }
    
    .innovation-badge {
        background-color: var(--buksu-blue);
        color: white;
        padding: 3px 6px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        display: inline-block;
        position: relative;
        top: -1px;
    }
    
    /* Fix icon positioning in dashboard cards */
    .icon-shape {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    /* Center icons in their containers */
    .navbar-vertical .navbar-nav .nav-link .icon,
    .card .icon-shape {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .navbar-vertical .navbar-nav .nav-link .icon i,
    .card .icon-shape i {
        margin: 0 !important;
        padding: 0 !important;
        position: static !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
    }
    
    /* Ensure stat icons are properly centered */
    .stat-icon {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Center the logo and text in sidebar header */
    .sidenav-header {
        height: auto;
        padding: 15px 10px;
    }
    
    .sidenav-header .navbar-brand {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 0;
    }
    
    .sidenav-header .navbar-brand-img {
        max-height: 45px !important;
        margin-bottom: 8px;
    }
    
    .sidenav-header .navbar-brand span {
        text-align: center;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    /* Center badge below name */
    .buksu-profile .user-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .buksu-profile .user-info h6 {
        margin-bottom: 5px !important;
    }
    
    .buksu-profile .user-info .badge-container {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    
    /* Improved badges styling */
    .student-badge {
        background: linear-gradient(135deg, var(--buksu-blue) 0%, var(--buksu-accent) 100%);
        color: white;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        box-shadow: 0 2px 5px rgba(0, 102, 204, 0.2);
        display: inline-block;
        margin-top: 2px;
    }
    
    .innovation-badge {
        background-color: var(--buksu-blue);
        color: white;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        display: inline-block;
        margin-top: 2px;
    }
    
    /* Fix icon positioning in dashboard cards */
    .icon-shape {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .navbar-vertical .navbar-nav .nav-link .icon,
    .card .icon-shape {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .navbar-vertical .navbar-nav .nav-link .icon i,
    .card .icon-shape i {
        margin: 0 !important;
        padding: 0 !important;
        position: static !important;
    }

    /* Profile section alignment fixes */
    .buksu-profile {
        border-top: 1px solid #f0f2f5;
        padding-top: 15px;
    }
    
    .buksu-profile .profile-container {
        display: flex;
        align-items: flex-start;
        padding: 0 1rem;
    }
    
    .buksu-profile .avatar {
        margin-top: 4px;
        margin-right: 12px;
    }
    
    .buksu-profile .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .buksu-profile .user-info h6 {
        margin-bottom: 4px !important;
        margin-top: 4px !important;
        font-size: 14px;
    }
    
    .buksu-profile .badge-container {
        display: flex;
        justify-content: flex-start;
        width: 100%;
    }
    
    /* Improved badges styling */
    .student-badge {
        background: linear-gradient(135deg, var(--buksu-blue) 0%, var(--buksu-accent) 100%);
        color: white;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        box-shadow: 0 2px 5px rgba(0, 102, 204, 0.2);
        display: inline-block;
    }
    
    .innovation-badge {
        background-color: var(--buksu-blue);
        color: white;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        display: inline-block;
    }
  </style>
  <!-- Add Chart.js library in the head section, just before the closing </head> tag -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- Sidebar -->
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
        <img src="{{ asset('assets/img/logo-buksu.png') }}" class="navbar-brand-img" alt="BukSU logo">
        <span>BukSU Student Information System</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        @if(auth()->user()->role === 'admin')
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-tachometer-alt"></i>
              </div>
              <span class="nav-link-text ms-1">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-users"></i>
              </div>
              <span class="nav-link-text ms-1">Students</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.enrollments.index') }}" class="nav-link {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-user-check"></i>
              </div>
              <span class="nav-link-text ms-1">Enrollment</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.grades.index') }}" class="nav-link {{ request()->routeIs('admin.grades.*') ? 'active' : '' }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-graduation-cap"></i>
              </div>
              <span class="nav-link-text ms-1">Grades</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.subjects.index') }}" class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-book-open"></i>
              </div>
              <span class="nav-link-text ms-1">Subjects</span>
            </a>
          </li>
        @elseif(auth()->user()->role === 'student')
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-tachometer-alt"></i>
              </div>
              <span class="nav-link-text ms-1">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('grades') }}" class="nav-link {{ request()->routeIs('grades') ? 'active' : '' }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-graduation-cap"></i>
              </div>
              <span class="nav-link-text ms-1">Grades</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('enrolledSubjects') }}" class="nav-link {{ request()->routeIs('enrolledSubjects') ? 'active' : '' }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-clipboard-list"></i>
              </div>
              <span class="nav-link-text ms-1">Enrolled Subjects</span>
            </a>
          </li>
        @endif
      </ul>
    </div>
    
    <div class="profile-footer">
      <hr class="horizontal dark mt-0">
      <div class="buksu-profile mb-3">
        <div class="profile-container">
          <div class="avatar avatar-sm bg-gradient-primary rounded-circle">
            <span class="text-white text-xs">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
          </div>
          <div class="user-info">
            <h6 class="text-sm">{{ auth()->user()->name }}</h6>
            <div class="badge-container">
              @if(auth()->user()->role === 'admin')
                <span class="innovation-badge">Admin</span>
              @else
                <span class="student-badge">Student</span>
              @endif
            </div>
          </div>
        </div>
        <div class="px-4 pt-3">
          <a href="{{ route('logout') }}" 
             class="btn btn-outline-primary btn-sm w-100" 
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out-alt me-2"></i> Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf    
          </form>
        </div>
      </div>
    </div>
  </aside>
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
      @yield('content')
      
      <!-- Simple Footer -->
      <footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-12 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted">
                © <script>document.write(new Date().getFullYear())</script> 
                Bukidnon State University Student Information System
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  
  <!-- Core JS Files -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  
  <script>
    // Initialize perfect scrollbar
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    
    // Sidebar toggle for mobile
    document.addEventListener('DOMContentLoaded', function() {
      const iconNavbarSidenav = document.getElementById('iconNavbarSidenav');
      const iconSidenav = document.getElementById('iconSidenav');
      const sidenav = document.getElementById('sidenav-main');
      
      if (iconNavbarSidenav) {
        iconNavbarSidenav.addEventListener("click", function() {
          if (sidenav) {
            sidenav.classList.toggle("g-sidenav-pinned");
            
            if (sidenav.classList.contains("g-sidenav-pinned")) {
              sidenav.classList.add("g-sidenav-hidden");
            }
            
            setTimeout(function() {
              toggleNavLinksOpacity();
            }, 300);
          }
        });
      }
      
      if (iconSidenav) {
        iconSidenav.addEventListener("click", function() {
          if (sidenav) {
            sidenav.classList.toggle("g-sidenav-pinned");
            
            if (sidenav.classList.contains("g-sidenav-pinned")) {
              sidenav.classList.add("g-sidenav-hidden");
            }
            
            setTimeout(function() {
              toggleNavLinksOpacity();
            }, 300);
          }
        });
      }
      
      function toggleNavLinksOpacity() {
        if (sidenav && !sidenav.classList.contains("g-sidenav-hidden")) {
          sidenav.classList.remove("g-sidenav-hidden");
        }
      }
    });
  </script>
  
  @stack('scripts')
</body>

</html>