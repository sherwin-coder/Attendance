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
            <a class="nav-link" href="{{ route('subjects.index') }}">
              <i class="mdi mdi-book-plus menu-icon"></i>
              <span class="menu-title">Subjects</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('actquiz') }}">
              <i class="mdi mdi-clipboard-text menu-icon"></i>
              <span class="menu-title">Student Tasks</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('newadmin') }}">
              <i class="mdi mdi-cog menu-icon"></i>
              <span class="menu-title">Admin Settings</span>
            </a>
          </li>
        </ul>
      </nav>

      <!-- Main Panel -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-8 mx-auto grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">Add New Admin / Professor</h4>

                  @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                  @endif

                  <form method="POST" action="{{ route('admin.store') }}">
                    @csrf
                    <div class="form-group">
                      <label for="name">Full Name</label>
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                      <label for="email">Email Address</label>
                      <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                      @error('password')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="password_confirmation">Confirm Password</label>
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>


                    <div class="form-group">
                      <label for="role">Role</label>
                      <select class="form-control" id="role" name="role" required>
                        <option value="">-- Select Role --</option>
                        <option value="admin">Admin</option>
                        <option value="professor">Professor</option>
                      </select>
                    </div>

                    <div class="form-group" id="subjects-wrapper" style="display: none;">
                      <label for="subjects">Assign Subjects (for Professors)</label>
                      <select multiple class="form-control" id="subjects" name="subjects[]" style="height: auto">
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->name }}</option>
                        @endforeach
                      </select>
                      <small class="text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple subjects.</small>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Create Account</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
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
  <script>
    document.getElementById('role').addEventListener('change', function() {
      document.getElementById('subjects-wrapper').style.display =
        this.value === 'professor' ? 'block' : 'none';
    });
  </script>

</body>

</html>