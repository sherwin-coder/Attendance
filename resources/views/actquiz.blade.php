<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Student Tasks | Smart QR Attendance</title>

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
                            <i class="mdi mdi-book menu-icon"></i>
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
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="card-title fw-bold text-dark">Student Tasks</h4>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                                            <i class="mdi mdi-plus"></i> Add Task
                                        </button>

                                    </div>

                                    <!-- Subject Filter -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Filter by Subject</label>
                                        <select class="form-select" id="subjectFilter">
                                            <option selected disabled>Select Subject</option>
                                            @foreach($subjects as $subject)
                                            <option value="{{ $subject->code }}">{{ $subject->code }} - {{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Task Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Task Title</th>
                                                    <th>Type</th>
                                                    <th>Subject</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tasks as $task)
                                                <tr>
                                                    <td>{{ $task->title }}</td>
                                                    <td>{{ $task->type }}</td>
                                                    <td>
                                                        {{ $task->subject_code }}
                                                        @if($task->subject)
                                                        - {{ $task->subject->name }}
                                                        @endif
                                                    </td>

                                                    <td>{{ $task->due_date }}</td>
                                                    <td>
                                                        <span class="badge {{ $task->status == 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                            {{ $task->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('task.delete', $task->id) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
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
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('task.add') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskLabel">Add New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="Quiz">Quiz</option>
                                <option value="Activity">Activity</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <select name="subject_code" class="form-select" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->code }}">{{ $subject->code }} - {{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <!-- JS Files -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        document.getElementById('subjectFilter').addEventListener('change', function() {
            const subjectCode = this.value;

            fetch(`/tasks/filter?subject_code=${subjectCode}`)
                .then(res => res.json())
                .then(tasks => {
                    const tbody = document.querySelector('tbody');
                    tbody.innerHTML = '';

                    if (tasks.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No tasks found</td></tr>';
                        return;
                    }

                    tasks.forEach(task => {
                        tbody.innerHTML += `
                    <tr>
                        <td>${task.title}</td>
                        <td>${task.type}</td>
                        <td>${task.subject_code}</td>
                        <td>${task.due_date}</td>
                        <td>
                            <span class="badge ${task.status === 'Completed' ? 'bg-success' : 'bg-warning text-dark'}">${task.status}</span>
                        </td>
                        <td>
                            <form action="/actquiz/${task.id}" method="POST">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>
                            </form>
                        </td>
                    </tr>
                `;
                    });
                });
        });
    </script>

</body>

</html>