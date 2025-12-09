<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Woka . Task</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css" />
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('assets/images/logo-woka.png') }}" />
</head>

<body class="with-welcome-text">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="index.html">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="index.html">
            <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
          </a>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
          @if (auth()->user()->role == 'admin')
          <li class="nav-item fw-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Selamat Datang, <span class="text-black fw-bold">{{ Auth::user()->name }}</span></h1>
            <h3 class="welcome-sub-text">Your performance summary this week </h3>
          </li>
          @endif
          @if (auth()->user()->role == 'PM')
          <li class="nav-item fw-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Selamat Datang, <span class="text-black fw-bold">{{ Auth::user()->name }}</span></h1>
            <h3 class="welcome-sub-text">Your performance summary this week </h3>
          </li>
          @endif
          @if (auth()->user()->role == 'developer')
          <li class="nav-item fw-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Selamat Datang, <span class="text-black fw-bold">{{ Auth::user()->name }}</span></h1>
            <h3 class="welcome-sub-text">Your performance summary this week </h3>
          </li>
          @endif
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item d-none d-lg-block">
            <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
              <span class="input-group-addon input-group-prepend border-right">
                <span class="icon-calendar input-group-text calendar-icon"></span>
              </span>
              <input type="text" class="form-control">
            </div>
          </li>
          <li class="nav-item">
            <form class="search-form" action="#">
              <i class="icon-search"></i>
              <input type="search" class="form-control" placeholder="Search Here" title="Search here">
            </form>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
              <i class="icon-bell"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
              <a class="dropdown-item py-3 border-bottom">
                <p class="mb-0 fw-medium float-start">You have 4 new notifications </p>
                <span class="badge badge-pill badge-primary float-end">View all</span>
              </a>
              <a class="dropdown-item preview-item py-3">
                <div class="preview-thumbnail">
                  <i class="mdi mdi-alert m-auto text-primary"></i>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject fw-normal text-dark mb-1">Application Error</h6>
                  <p class="fw-light small-text mb-0"> Just now </p>
                </div>
              </a>
              <a class="dropdown-item preview-item py-3">
                <div class="preview-thumbnail">
                  <i class="mdi mdi-lock-outline m-auto text-primary"></i>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject fw-normal text-dark mb-1">Settings</h6>
                  <p class="fw-light small-text mb-0"> Private message </p>
                </div>
              </a>
              <a class="dropdown-item preview-item py-3">
                <div class="preview-thumbnail">
                  <i class="mdi mdi-airballoon m-auto text-primary"></i>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject fw-normal text-dark mb-1">New user registration</h6>
                  <p class="fw-light small-text mb-0"> 2 days ago </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="icon-mail icon-lg"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
              <a class="dropdown-item py-3">
                <p class="mb-0 fw-medium float-start">You have 7 unread mails </p>
                <span class="badge badge-pill badge-primary float-end">View all</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="{{ asset('assets/images/faces/face10.jpg') }}" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">Marian Garner </p>
                  <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="assets/images/faces/face12.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">David Grey </p>
                  <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="assets/images/faces/face1.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">Travis Jenkins </p>
                  <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="img-xs rounded-circle" src="assets/images/faces/face8.jpg" alt="Profile image"> </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <img class="img-md rounded-circle" src="assets/images/faces/face8.jpg" alt="Profile image">
                <p class="mb-1 mt-3 fw-semibold">Allen Moreno</p>
                <p class="fw-light text-muted mb-0">allenmoreno@gmail.com</p>
              </div>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger">1</span></a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          @if(auth()->user()->role == 'admin')
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route( 'admin.dashboard') }}">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category">UI Elements</li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('admin.PM.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('admin.PM.index') }}">
              <i class="mdi mdi-account-tie menu-icon"></i>
              <span class="menu-title">PM</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('admin.developer.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('admin.developer.index') }}">
              <i class="mdi mdi-account-cog menu-icon"></i>
              <span class="menu-title">Developer</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('admin.project.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('admin.project.index') }}">
              <i class="mdi mdi-folder-multiple menu-icon"></i>
              <span class="menu-title">Project</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('admin.member.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('admin.member.index') }}">
              <i class="mdi mdi-account-group menu-icon"></i>
              <span class="menu-title">Project Members</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('admin.task.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('admin.task.index') }}">
              <i class="mdi mdi-briefcase-check-outline menu-icon"></i>
              <span class="menu-title">Task</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('admin.collaborator.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('admin.collaborator.index') }}">
              <i class="mdi mdi-briefcase-check-outline menu-icon"></i>
              <span class="menu-title">Task Collaborators</span>
            </a>
          </li>
          @endif
          @if (auth()->user()->role == 'PM')
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('PM.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('PM.dashboard') }}">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category">Menu </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('PM.pengembang.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('PM.pengembang.index') }}">
              <i class="mdi mdi-account-cog menu-icon"></i>
              <span class="menu-title">Developer</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('PM.proyek.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('PM.proyek.index') }}">
              <i class="mdi mdi-folder-multiple menu-icon"></i>
              <span class="menu-title">Project</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('PM.anggota.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('PM.anggota.index') }}">
              <i class="mdi mdi-account-group menu-icon"></i>
              <span class="menu-title">Project Members</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('PM.tugas.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('PM.tugas.index') }}">
              <i class="mdi mdi-briefcase-check-outline menu-icon"></i>
              <span class="menu-title">Task</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('PM.kelompok.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('PM.kelompok.index') }}">
              <i class="mdi mdi-briefcase-check-outline menu-icon"></i>
              <span class="menu-title">Task Collaborators</span>
            </a>
          </li>
          @endif
          @if (auth()->user()->role == 'developer')
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('developer.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('developer.dashboard') }}">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category">Menu </li>
          <li class="nav-item">
            <a class="nav-link" {{ request()->routeIs('developer.pekerjaan.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }} "
                 href=" {{ route('developer.pekerjaan.index') }}">
              <i class="mdi mdi-briefcase-check-outline menu-icon"></i>
              <span class="menu-title">Task</span>
            </a>
          </li>
          @endif


          <li class="nav-item mt-4">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="nav-link logout-link d-flex align-items-center text-dark w-100">
                <i class="mdi mdi-logout menu-icon"></i>
                <span class="menu-title ms-2">Logout</span>
              </button>
            </form>
          </li>
        </ul>
      </nav>

      <!-- partial -->
      @yield('content')
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
  <script src="{{ asset('assets/js/settings.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/todolist.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('assets/js/jquery.cookie.js') }} " type="text/javascript"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
  <!-- End custom js for this page-->
</body>
</html>