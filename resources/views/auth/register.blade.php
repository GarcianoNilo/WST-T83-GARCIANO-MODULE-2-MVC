<!--
=========================================================
* Soft UI Dashboard 3 PRO - v1.2.0
=========================================================

* Product Page:  https://www.creative-tim.com/product/soft-ui-dashboard-pro 
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>BukSU Student Information System - Register</title>
  
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.min.css') }}" rel="stylesheet" />
  
  <!-- BukSU Colors -->
  <style>
    :root {
      --buksu-blue: #0066CC;
      --buksu-blue-light: #4D94DB;
      --buksu-blue-dark: #004C99;
      --buksu-blue-pale: #E6F0FF;
      --buksu-accent: #5CACE2;
      --buksu-accent-light: #80BDE8;
    }
    
    .bg-primary,
    .bg-gradient-primary,
    .btn-primary {
      background-color: var(--buksu-blue) !important;
      border-color: var(--buksu-blue) !important;
    }
    
    .bg-gradient-primary {
      background-image: linear-gradient(310deg, var(--buksu-blue), var(--buksu-blue-light)) !important;
    }
    
    .text-primary, 
    .text-primary i {
      color: var(--buksu-blue) !important;
    }
    
    .text-gradient.text-primary {
      background-image: linear-gradient(310deg, var(--buksu-blue), var(--buksu-accent)) !important;
      background-clip: text;
      -webkit-background-clip: text;
    }
    
    .form-control:focus,
    .form-check-input:checked {
      border-color: var(--buksu-blue) !important;
    }
    
    .form-check-input:checked {
      background-color: var(--buksu-blue) !important;
    }
    
    .buksu-hero {
      background: url('{{ asset("assets/img/logo-buksu.png") }}');
      background-size: 80px;
      background-repeat: no-repeat;
      background-position: top center;
      padding-top: 100px;
    }
    
    .buksu-logo-small {
      height: 40px;
      margin-bottom: 20px;
    }
    
    .login-panel {
      border-radius: 10px;
    }
    
    label {
      font-size: 0.875rem;
      font-weight: 500;
      color: #344767;
    }
    
    .form-check-label {
      font-size: 0.875rem;
    }
  </style>
</head>

<body>
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
      </div>
    </div>
  </div>
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-left">
                  <div class="text-center mb-3">
                    <img src="{{ asset('assets/img/logo-buksu.png') }}" alt="BukSU Logo" class="buksu-logo-small">
                  </div>
                  <h4 class="font-weight-bolder text-center">Student Registration</h4>
                  <p class="mb-0 text-center">Create your BukSU SIS account</p>
                  @if ($errors->any())
                    <div class="alert alert-danger text-white mt-3">
                      <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                </div>
                <div class="card-body pb-3">
                  <form role="form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <label>Student ID</label>
                    <div class="mb-3">
                      <input type="text" name="student_id" class="form-control" placeholder="Student ID" aria-label="Student ID" required>
                    </div>
                    <label>Name</label>
                    <div class="mb-3">
                      <input type="text" name="name" class="form-control" placeholder="Name" aria-label="Name" required>
                    </div>
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" required>
                    </div>
                    <label>Course (BSIT/BSCS/BSIS)</label>
                    <div class="mb-3">
                      <input type="text" name="course" class="form-control" placeholder="Enter course code (e.g. BSIT)" aria-label="Course" required maxlength="4">
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" required>
                    </div>
                    <label>Confirm Password</label>
                    <div class="mb-3">
                      <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" aria-label="Confirm Password" required>
                    </div>
                    <div class="form-check form-check-info text-left">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                      <label class="form-check-label" for="flexCheckDefault">
                        I agree to the <a href="#" class="text-primary font-weight-bolder">Terms and Conditions</a>
                      </label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Register</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-sm-4 px-1">
                  <p class="mb-4 mx-auto">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-primary text-gradient font-weight-bold">Sign in</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center login-panel">
                <img src="{{ asset('assets/img/shapes/pattern-lines.svg') }}" alt="pattern-lines" class="position-absolute opacity-4 start-0">
                <div class="position-relative buksu-hero">
                  <h2 class="mt-5 text-white font-weight-bolder">Bukidnon State University</h2>
                  <h4 class="text-white font-weight-bolder">Student Information System</h4>
                </div>
                <div class="position-relative mt-5">
                  <h5 class="text-white font-weight-bold">Begin your academic journey</h5>
                  <p class="text-white opacity-8">Create your account to access course registration, view grades, and track your progress toward your degree.</p>
                </div>
                <div class="position-relative mt-auto mb-5">
                  <p class="text-white opacity-8 small">© {{ date('Y') }} Bukidnon State University</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- Core JS Files -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
</body>
</html>