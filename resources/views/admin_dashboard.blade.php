<!DOCTYPE html>
<html lang="en">
<!-- lagay nyo nalang to sa html para walang scroll style="overflow: hidden;" -->
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
  
  .sidebar-minimized .brand-logo {
    display: none !important;
  }
  
  .sidebar-minimized .brand-logo-mini {
    display: block !important;
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
  .sidebar-minimized + .main-panel {
    margin-left: 80px !important;
    width: calc(100% - 80px) !important;
  }
  
  /* Smooth transitions */
  .sidebar,
  .main-panel {
    transition: all 0.3s ease;
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

    <!-- Sidebar Toggle Button -->
<button class="sidebar-toggle-btn d-none d-lg-block">
  <i class="mdi mdi-arrow-left"></i>
</button>


<div class="container-fluid page-body-wrapper">
  <!-- Sidebar -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-header">
      <button class="sidebar-close-btn">
        <i class="mdi mdi-close"></i>
      </button>
    </div>
    
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
      <!-- Summary Cards -->
      <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-primary text-white">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <i class="mdi mdi-account-group display-6 me-3"></i>
              <div>
                <h4 class="card-title mb-1" style="color: white;">Total Students</h4>
                <h2 class="fw-bold mb-0">{{ $totalStudents }}</h2>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-success text-white">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <i class="mdi mdi-check-circle display-6 me-3"></i>
              <div>
                <h4 class="card-title mb-1" style="color: white;">Present Today</h4>
                <h2 class="fw-bold mb-0">{{ $presentToday }}</h2>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-warning text-white">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <i class="mdi mdi-clock-alert display-6 me-3"></i>
              <div>
                <h4 class="card-title mb-1" style="color: white;">Late Today</h4>
                <h2 class="fw-bold mb-0">{{ $lateCount }}</h2>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-danger text-white">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <i class="mdi mdi-account-cancel display-6 me-3"></i>
              <div>
                <h4 class="card-title mb-1" style="color: white;">Absent Today</h4>
                <h2 class="fw-bold mb-0">{{ $absentCount }}</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart and Recent Logs -->
    <div class="row mt-4">
      <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h4 class="card-title mb-0">Weekly Attendance Overview</h4>
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                  This Week
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">This Week</a></li>
                  <li><a class="dropdown-item" href="#">Last Week</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                </ul>
              </div>
            </div>
            <canvas id="attendanceChart" height="120"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Recent Activity</h4>
            <div class="recent-scans-container" style="max-height: 300px; overflow-y: auto;">
              @if($recentScans && count($recentScans) > 0)
                @foreach ($recentScans as $scan)
                <div class="d-flex align-items-center border-bottom py-3">
                  <div class="me-3">
                    @if($scan->time_in && !$scan->time_out)
                      <span class="badge bg-success rounded-circle p-2">
                        <i class="mdi mdi-login"></i>
                      </span>
                    @elseif($scan->time_out)
                      <span class="badge bg-primary rounded-circle p-2">
                        <i class="mdi mdi-logout"></i>
                      </span>
                    @else
                      <span class="badge bg-secondary rounded-circle p-2">
                        <i class="mdi mdi-account"></i>
                      </span>
                    @endif
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-1">{{ $scan->user->name ?? 'Unknown Student' }}</h6>
                    <p class="text-muted mb-0 small">
                      @if($scan->time_in)
                        <span class="text-success">IN</span> {{ \Carbon\Carbon::parse($scan->time_in)->format('h:i A') }}
                      @endif
                      @if($scan->time_out)
                        <span class="text-primary ms-2">OUT</span> {{ \Carbon\Carbon::parse($scan->time_out)->format('h:i A') }}
                      @endif
                    </p>
                  </div>
                  <div class="text-end">
                    <small class="text-muted">{{ \Carbon\Carbon::parse($scan->created_at)->format('M j') }}</small>
                  </div>
                </div>
                @endforeach
              @else
                <div class="text-center py-4">
                  <i class="mdi mdi-information-outline display-4 text-muted"></i>
                  <p class="text-muted mt-2">No recent activity</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row mt-4">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Attendance Rate</h4>
            <div class="d-flex align-items-center justify-content-between">
              <div class="flex-grow-1 me-4">
                <h2 class="fw-bold text-primary">{{ $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 1) : 0 }}%</h2>
                <p class="text-muted">Overall attendance rate for today</p>
              </div>
              <div class="display-6 text-primary">
                <i class="mdi mdi-chart-line"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Quick Actions</h4>
            <div class="row text-center">
              <div class="col-4">
                <a href="{{ route('students.index') }}" class="text-decoration-none">
                  <div class="p-3 border rounded">
                    <i class="mdi mdi-account-plus display-6 text-primary"></i>
                    <p class="mt-2 mb-0">Add Student</p>
                  </div>
                </a>
              </div>
              <div class="col-4">
                <a href="{{ route('attendance.logs') }}" class="text-decoration-none">
                  <div class="p-3 border rounded">
                    <i class="mdi mdi-file-document display-6 text-success"></i>
                    <p class="mt-2 mb-0">View Reports</p>
                  </div>
                </a>
              </div>
              <div class="col-4">
                <a href="{{ route('subjects.index') }}" class="text-decoration-none">
                  <div class="p-3 border rounded">
                    <i class="mdi mdi-book-plus display-6 text-warning"></i>
                    <p class="mt-2 mb-0">Manage Subjects</p>
                  </div>
                </a>
              </div>
            </div>
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
          });
        }
        
        // Toggle sidebar functionality
        if (toggleBtn) {
          toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-minimized');
            
            // Change icon based on state
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('sidebar-minimized')) {
              icon.className = 'mdi mdi-arrow-right';
            } else {
              icon.className = 'mdi mdi-arrow-left';
            }
          });
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
      });
    </script>

    <!-- Chart Script -->
    <script>
      const ctx = document.getElementById('attendanceChart');
      if (ctx) {
        new Chart(ctx, {
          type: 'line',
          data: {
            labels: @json($weekDays),
            datasets: [{
              label: 'Attendance',
              data: @json($attendanceData),
              borderColor: '#4B49AC',
              backgroundColor: 'rgba(75, 73, 172, 0.1)',
              fill: true,
              tension: 0.4
            }]
          },
          options: {
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    </script>

  </div>
</body>

</html>