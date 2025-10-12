<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Student | Smart QR Attendance</title>

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
        <a class="navbar-brand brand-logo" href="#"><img src="{{ asset('assets/images/logo.svg') }}" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
        <h4 class="mb-0 text-dark fw-bold ps-3">Smart Student Attendance System</h4>
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
      <!-- Sidebar -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item"><a class="nav-link" href="{{ route('admin_dashboard') }}"><i class="mdi mdi-view-dashboard menu-icon"></i><span class="menu-title">Dashboard</span></a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('students.index') }}"><i class="mdi mdi-account-group menu-icon"></i><span class="menu-title">Student Records</span></a></li>
        </ul>
      </nav>

      <!-- Main Panel -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Edit Student Info</h4>

              <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                  <label>Name</label>
                  <input name="name" class="form-control" value="{{ $student->name }}" required>
                </div>

                <div class="mb-3">
                  <label>Student No</label>
                  <input name="studentno" class="form-control" value="{{ $student->studentno }}" required>
                </div>

                <div class="mb-3">
                  <label>Email</label>
                  <input name="email" type="email" class="form-control" value="{{ $student->email }}" required>
                </div>

                <div class="mb-3">
                  <label>Year & Section</label>
                  <select name="yrsec" id="yrsec" class="form-select" onchange="checkNewYrSec(this)">
                    <option value="">Select</option>
                    @foreach($yrsecs as $ys)
                      <option value="{{ $ys }}" {{ $student->yrsec == $ys ? 'selected' : '' }}>{{ $ys }}</option>
                    @endforeach
                    <option value="add_new">+ Add New Year & Section</option>
                  </select>
                  <input type="text" id="newYrSec" name="newYrSec" class="form-control mt-2" placeholder="Enter new Yr & Sec" style="display:none;">
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
              </form>
            </div>
          </div>
        </div>

        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center d-block d-sm-inline-block">© {{ date('Y') }} Smart Student Attendance System</span>
          </div>
        </footer>
      </div>
    </div>
  </div>

  <script>
  function checkNewYrSec(select) {
      const input = document.getElementById('newYrSec');
      if (select.value === 'add_new') {
          input.style.display = 'block';
          input.required = true;
      } else {
          input.style.display = 'none';
          input.required = false;
      }
  }
  </script>

  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
</body>
</html>
