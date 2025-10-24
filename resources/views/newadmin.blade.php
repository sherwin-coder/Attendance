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
  
  <style>
    /* Sidebar Toggle Styles */
    .sidebar-toggle-btn {
      position: fixed;
      left: 15px;
      top: 95vh;
      z-index: 1000;
      background: #4B49AC;
      border: none;
      border-radius: 8px;
      width: 45px;
      height: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: white;
      box-shadow: 0 2px 15px rgba(75, 73, 172, 0.3);
      transition: all 0.3s ease;
    }
    
    .sidebar-toggle-btn:hover {
      background: #3a3899;
      transform: scale(1.05);
      box-shadow: 0 4px 20px rgba(75, 73, 172, 0.4);
    }
    
    /* Sidebar Close Button */
    .sidebar-close-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(255, 255, 255, 0.2);
      border: none;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #6c757d;
      transition: all 0.3s ease;
      z-index: 12;
      font-size: 1.1rem;
    }
    
    .sidebar-close-btn:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: rotate(90deg);
      color: #4B49AC;
    }
    
    /* Sidebar Minimized State */
    .sidebar-minimized {
      width: 80px !important;
    }
    
    .sidebar-minimized .menu-title {
      display: none !important;
    }
    
    .sidebar-minimized .nav-item .nav-link {
      padding: 12px 15px !important;
      justify-content: center !important;
    }
    
    .sidebar-minimized .nav-item .menu-icon {
      margin-right: 0 !important;
      font-size: 1.4rem !important;
    }
    
    /* Main content adjustment when sidebar is minimized */
    .sidebar-minimized ~ .main-panel {
      margin-left: 80px !important;
      width: calc(100% - 80px) !important;
    }
    
    /* Smooth transitions */
    .sidebar,
    .main-panel {
      transition: all 0.3s ease;
    }

    /* Fix layout issues */
    .page-body-wrapper {
      min-height: calc(100vh - 70px);
      /* padding-top: 70px; */
    }

    .main-panel {
      width: calc(100% - 260px);
      margin-left: 260px;
      transition: all 0.3s ease;
    }

    /* Ensure sidebar is properly positioned */
    .sidebar {
      position: fixed;
      top: 20px;
      left: 0;
      height: 100vh;
      z-index: 999;
      margin-top: 70px;
    }

    /* Fix content wrapper */
    .content-wrapper {
      padding: 20px;
      /* min-height: calc(100vh - 140px); */
    }
  </style>
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
            <a class="nav-link" href="{{ route('actquiz') }}">
              <i class="mdi mdi-clipboard-text menu-icon"></i>
              <span class="menu-title">Student Tasks</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('newadmin') }}">
              <i class="mdi mdi-cog menu-icon"></i>
              <span class="menu-title">Admin Settings</span>
            </a>
          </li>
        </ul>
            <button class="sidebar-toggle-btn d-none d-lg-block">
      <i class="mdi mdi-arrow-left"></i>
    </button>
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

                  @if($errors->any())
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                  @endif

                  <form method="POST" action="{{ route('admin.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                      <label for="name" class="form-label fw-bold">Full Name</label>
                      <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="email" class="form-label fw-bold">Email Address</label>
                      <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="password" class="form-label fw-bold">Password</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="role" class="form-label fw-bold">Role</label>
                      <select class="form-control" id="role" name="role" required>
                        <option value="">-- Select Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="professor" {{ old('role') == 'professor' ? 'selected' : '' }}>Professor</option>
                      </select>
                    </div>

                    <div class="form-group mb-3" id="subjects-wrapper" style="display: {{ old('role') == 'professor' ? 'block' : 'none' }};">
                      <label for="subjects" class="form-label fw-bold">Assign Subjects (for Professors)</label>
                      <select multiple class="form-control" id="subjects" name="subjects[]" style="height: auto">
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ in_array($subject->id, old('subjects', [])) ? 'selected' : '' }}>
                          {{ $subject->code }} - {{ $subject->name }}
                        </option>
                        @endforeach
                      </select>
                      <small class="text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple subjects.</small>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                      <i class="mdi mdi-account-plus me-2"></i>Create Account
                    </button>
                    <a href="{{ route('newadmin') }}" class="btn btn-secondary mt-3">
                      <i class="mdi mdi-arrow-left me-2"></i>Cancel
                    </a>
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

  <!-- Sidebar Toggle Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('sidebar');
      const closeBtn = document.querySelector('.sidebar-close-btn');
      const toggleBtn = document.querySelector('.sidebar-toggle-btn');
      
      // Close sidebar functionality
      if (closeBtn) {
        closeBtn.addEventListener('click', function() {
          sidebar.classList.toggle('sidebar-minimized');
          updateToggleButtonIcon();
        });
      }
      
      // Toggle sidebar functionality
      if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
          sidebar.classList.toggle('sidebar-minimized');
          updateToggleButtonIcon();
        });
      }
      
      // Update toggle button icon based on sidebar state
      function updateToggleButtonIcon() {
        if (toggleBtn) {
          const icon = toggleBtn.querySelector('i');
          if (sidebar.classList.contains('sidebar-minimized')) {
            icon.className = 'mdi mdi-arrow-right';
          } else {
            icon.className = 'mdi mdi-arrow-left';
          }
        }
      }
      
      // Mobile sidebar close when clicking outside
      document.addEventListener('click', function(event) {
        if (window.innerWidth < 992) {
          const isClickInsideSidebar = sidebar.contains(event.target);
          const isClickOnToggleBtn = toggleBtn.contains(event.target);
          
          if (!isClickInsideSidebar && !isClickOnToggleBtn && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
          }
        }
      });

      // Initialize button icon on page load
      updateToggleButtonIcon();
    });

    // Role selection handler
    document.getElementById('role').addEventListener('change', function() {
      document.getElementById('subjects-wrapper').style.display =
        this.value === 'professor' ? 'block' : 'none';
    });
  </script>

</body>

</html>