<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Dashboard | Smart QR Attendance</title>

  <!-- CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <!-- Top Navbar -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route('admin_dashboard') }}">
          <img src="{{ asset('assets/images/smart-icon.jpg') }}" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="#">
          <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
        <h4 class="mb-0 text-dark fw-bold ps-3">Smart Student Attendance System</h4>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown">
              <img class="img-xs rounded-circle" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <img class="img-md rounded-circle mb-2" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image">
                <p class="mb-1 fw-semibold">Admin</p>
                <p class="fw-light text-muted mb-0">admin@attendance.com</p>
              </div>
              <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="mdi mdi-account-outline me-2 text-primary"></i>Profile</a>
              <form method="POST" action="{{ route('logout') }}" id="logout-form">
                  @csrf
                  <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="mdi mdi-logout me-2 text-primary"></i> Logout
                  </a>
              </form>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
      <!-- Sidebar -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin_dashboard') }}">
              <i class="mdi mdi-view-dashboard menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('students.index') }}">
              <i class="mdi mdi-account-group menu-icon"></i>
              <span class="menu-title">Student Records</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('attendance.logs') }}">
              <i class="mdi mdi-calendar-check menu-icon"></i>
              <span class="menu-title">Attendance Logs</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin_dashboard') }}">
              <i class="mdi mdi-chart-bar menu-icon"></i>
              <span class="menu-title">Reports</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin_dashboard') }}">
              <i class="mdi mdi-cog menu-icon"></i>
              <span class="menu-title">Settings</span>
            </a>
          </li>
        </ul>
      </nav>

      <!-- Main Panel -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            
        <div class="container">
            <h2 class="mb-4">Attendance Logs</h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $index => $log)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $log->user->studentno ?? 'N/A' }}</td>
                        <td>{{ $log->user->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->date)->format('Y-m-d') }}</td>
                        <td>{{ $log->time_in ?? '-' }}</td>
                        <td>{{ $log->time_out ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $logs->links() }}
        </div>

        <!-- Footer -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center d-block d-sm-inline-block">
              © {{ date('Y') }} Smart Student Attendance System. All Rights Reserved.
            </span>
            <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">
              Developed by Admin Team
            </span>
          </div>
        </footer>
      </div>
    </div>
  </div>

  <!-- JS Files -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>

</body>
</html>
