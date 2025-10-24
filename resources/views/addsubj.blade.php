<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Subject | Smart QR Attendance</title>

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

    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle-btn d-none d-lg-block">
      <i class="mdi mdi-arrow-left"></i>
    </button>

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
            <a class="nav-link active" href="{{ route('subjects.index') }}">
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
            <a class="nav-link" href="{{ route('newadmin') }}">
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

          <!-- Page Title -->
          <div class="page-header mb-4">
            <h3 class="page-title fw-bold">Add New Subject</h3>
          </div>

          <!-- Flash Messages -->
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

          <!-- Add Subject Form -->
          <div class="card mb-4">
            <div class="card-body">
              <form method="POST" action="{{ route('subjects.store') }}">
                @csrf
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label class="form-label fw-bold">Subject Code</label>
                    <input type="text" name="code" class="form-control" placeholder="e.g. CCS119" required>
                  </div>
                  <div class="col-md-5">
                    <label class="form-label fw-bold">Subject Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Capstone Project and Research 1" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-bold">Schedule</label>
                    <input type="text" name="schedule" class="form-control" placeholder="e.g. Fri 05:30PM-08:30PM" required>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Add Subject</button>
              </form>
            </div>
          </div>

          <!-- Subject List -->
          <div class="card">
            <div class="card-body">
              <h4 class="card-title fw-bold">Existing Subjects</h4>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Subject Code</th>
                      <th>Subject Name</th>
                      <th>Schedule</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($subjects as $index => $subject)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $subject->code }}</td>
                      <td>{{ $subject->name }}</td>
                      <td>{{ $subject->schedule }}</td>
                      <td>
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Delete this subject?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5" class="text-center text-muted">No subjects found.</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
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
          </div>
        </footer>
      </div>
    </div>
  </div>

  <!-- JS Files -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
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
  </script>
</body>

</html>