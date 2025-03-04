<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-buksu.png') }}">
  <title>BukSU Student Information System - Login</title>
  
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
                <div class="card-header pb-0 text-start">
                  <div class="text-center mb-3">
                    <img src="{{ asset('assets/img/logo-buksu.png') }}" alt="BukSU Logo" class="buksu-logo-small">
                  </div>
                  <h4 class="font-weight-bolder text-center">Student Information System</h4>
                  <p class="mb-0 text-center">Enter your credentials to sign in</p>
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
                <div class="card-body">
                  <form role="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                      <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" aria-label="Email">
                    </div>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password">
                    </div>
                    <!--
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div> -->
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
                <!-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-primary text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div> -->
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-start login-panel">
                <img src="{{ asset('assets/img/shapes/pattern-lines.svg') }}" alt="pattern-lines" class="position-absolute opacity-4 start-0">
                
                <!-- Spacer to push content down -->
                <div class="flex-grow-1" style="min-height: 15%;"></div>
                
                <div class="position-relative buksu-hero">
                 
                  <h2 class="text-white font-weight-bolder">Bukidnon State University</h2>
                  <h4 class="text-white font-weight-bolder">Student Information System</h4>
                </div>
                
                <div class="position-relative mt-5">
                  <h5 class="text-white font-weight-bold">Access your academic records</h5>
                  <p class="text-white opacity-8 px-4 mx-auto">Manage your enrollment, check grades, and track your academic progress in one central platform.</p>
                </div>
                
                <!-- Spacer to push content up from bottom -->
                <div class="flex-grow-1"></div>
                
                <div class="position-relative mb-5">
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