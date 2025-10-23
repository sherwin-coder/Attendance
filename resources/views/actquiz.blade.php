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
                            <img class="img-xs rounded-circle" src="{{ asset('assets/images/faces/face8.jpg') }}"
                                alt="Profile image">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle mb-2"
                                    src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image">
                                <p class="mb-1 fw-semibold">Admin</p>
                                <p class="fw-light text-muted mb-0">admin@attendance.com</p>
                            </div>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                    class="mdi mdi-account-outline me-2 text-primary"></i>Profile</a>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="#" class="dropdown-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                            <i class="mdi mdi-cog menu-icon"></i>
                            <span class="menu-title">Activities % Quizzes</span>
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
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="card-title fw-bold text-dark">Student Tasks</h4>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#addTaskModal">
                                            <i class="mdi mdi-plus"></i> Add Task
                                        </button>
                                    </div>

                                    <!-- Subject Filter -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Filter by Subject</label>
                                        <select class="form-select" id="subjectFilter">
                                            <option selected disabled>Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->code }}">
                                                    {{ $subject->code }} - {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Task Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle">
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
                                            <tbody id="taskTableBody">
                                                @foreach ($tasks as $task)
                                                    <tr data-id="{{ $task->id }}">
                                                        <td>{{ $task->title }}</td>
                                                        <td>{{ $task->type }}</td>
                                                        <td>{{ $task->subject_code }} - {{ $task->subject->name ?? '' }}
                                                        </td>
                                                        <td>{{ $task->due_date }}</td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $task->status == 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                                {{ $task->status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <button class="btn btn-sm btn-info view-btn"
                                                                    data-id="{{ $task->id }}" data-mode="view"
                                                                    data-bs-toggle="modal" data-bs-target="#scoreModal">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </button>

                                                                <button class="btn btn-sm btn-warning edit-btn"
                                                                    data-id="{{ $task->id }}" data-mode="edit"
                                                                    data-bs-toggle="modal" data-bs-target="#scoreModal">
                                                                    <i class="mdi mdi-pencil"></i>
                                                                </button>

                                                                <form action="{{ route('tasks.destroy', $task->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Delete this task?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-sm btn-danger">
                                                                        <i class="mdi mdi-delete"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
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

                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block d-sm-inline-block">
                            © {{ date('Y') }} Smart Student Attendance System. All Rights Reserved.
                        </span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->code }}">
                                        {{ $subject->code }} - {{ $subject->name }}
                                    </option>
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

    <!-- Score Modal -->
    <div class="modal fade" id="scoreModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="scoreForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Task Scores</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="taskId">

                        <!-- Add Record Button (only visible in Edit mode) -->
                        <div id="addRecordContainer" class="mb-3" style="display: none;">
                            <button type="button" id="addRecordBtn" class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-plus"></i> Add Student Record
                            </button>
                        </div>

                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody id="scoreTableBody">
                                <tr>
                                    <td colspan="2" class="text-center">Loading...</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Hidden New Record Form -->
                        <div id="newRecordForm" class="border p-3 rounded bg-white mt-3" style="display: none;">
                            <h6 class="fw-bold mb-3">Add New Student Record</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Select Student</label>
                                    <select id="newStudentSelect" class="form-select" style="color: black;">
                                        <option value="">-- Choose Student --</option>
                                        @foreach(App\Models\User::all() as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Score</label>
                                    <input type="number" id="newStudentScore" class="form-control" min="0" max="100">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" id="saveNewRecordBtn" class="btn btn-success w-100">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="markCompleteBtn" class="btn btn-success">Mark as Completed</button>
                        <button type="submit" id="saveScoresBtn" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Files -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        // Filter tasks by subject
        document.getElementById('subjectFilter').addEventListener('change', function () {
            const code = this.value;
            fetch(`/tasks/filter?subject_code=${code}`)
                .then(res => res.json())
                .then(tasks => {
                    const tbody = document.getElementById('taskTableBody');
                    tbody.innerHTML = '';
                    if (tasks.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No tasks found</td></tr>';
                        return;
                    }
                    tasks.forEach(task => {
                        tbody.innerHTML += `
                    <tr data-id="${task.id}">
                        <td>${task.title}</td>
                        <td>${task.type}</td>
                        <td>${task.subject_code}</td>
                        <td>${task.due_date}</td>
                        <td><span class="badge ${task.status === 'Completed' ? 'bg-success' : 'bg-warning text-dark'}">${task.status}</span></td>
                        <td>
                            <button class="btn btn-sm btn-info view-btn" data-id="${task.id}" data-mode="view" data-bs-toggle="modal" data-bs-target="#scoreModal"><i class="mdi mdi-eye"></i></button>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="${task.id}" data-mode="edit" data-bs-toggle="modal" data-bs-target="#scoreModal"><i class="mdi mdi-pencil"></i></button>
                        </td>
                    </tr>`;
                    });
                });
        });

        const scoreTableBody = document.getElementById('scoreTableBody');
        const saveScoresBtn = document.getElementById('saveScoresBtn');
        const markCompleteBtn = document.getElementById('markCompleteBtn');
        const addRecordContainer = document.getElementById('addRecordContainer');
        let currentMode = 'view';

        // Open modal (view or edit)
        document.addEventListener('click', e => {
            if (e.target.closest('.view-btn') || e.target.closest('.edit-btn')) {
                const btn = e.target.closest('button');
                const taskId = btn.dataset.id;
                currentMode = btn.dataset.mode;
                document.getElementById('taskId').value = taskId;

                document.querySelector('#scoreModal .modal-title').textContent =
                    currentMode === 'view' ? 'View Scores' : 'Edit Scores';
                saveScoresBtn.style.display = currentMode === 'edit' ? 'inline-block' : 'none';
                addRecordContainer.style.display = currentMode === 'edit' ? 'block' : 'none';

                fetch(`/tasks/${taskId}/scores`)
                    .then(res => res.json())
                    .then(data => {
                        const scores = data.scores || [];
                        if (!scores.length) {
                            scoreTableBody.innerHTML =
                                '<tr><td colspan="2" class="text-center">No student records found.</td></tr>';
                            return;
                        }
                        scoreTableBody.innerHTML = scores.map(s => `
                    <tr>
                        <td>${s.user?.name ?? 'Unknown Student'}</td>
                        <td>${currentMode === 'edit'
                                ? `<input type="number" class="form-control score-input" data-user="${s.user_id}" value="${s.score ?? ''}" min="0" max="100">`
                                : (s.score ?? '-')
                            }</td>
                    </tr>`).join('');
                    })
                    .catch(err => {
                        console.error('Error fetching scores:', err);
                        scoreTableBody.innerHTML =
                            '<tr><td colspan="2" class="text-center text-danger">Failed to load scores.</td></tr>';
                    });
            }
        });

        // ✅ Save updated scores (NEW WORKING FUNCTION)
        saveScoresBtn.addEventListener('click', () => {
            const taskId = document.getElementById('taskId').value;
            const inputs = scoreTableBody.querySelectorAll('.score-input');

            const scores = Array.from(inputs).map(input => ({
                user_id: input.dataset.user,
                score: input.value
            }));

            fetch(`/tasks/${taskId}/scores`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ scores })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Scores updated successfully!');
                        location.reload();
                    } else {
                        alert('Failed to update scores.');
                    }
                })
                .catch(err => {
                    console.error('Error updating scores:', err);
                    alert('An error occurred while updating scores.');
                });
        });

        // Mark as completed
        markCompleteBtn.addEventListener('click', () => {
            const taskId = document.getElementById('taskId').value;
            fetch(`/tasks/${taskId}/complete`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            })
                .then(res => res.json())
                .then(() => {
                    alert('Task marked as completed.');
                    location.reload();
                });
        });

        // Add new student record
        document.getElementById('addRecordBtn').addEventListener('click', () => {
            document.getElementById('newRecordForm').style.display = 'block';
        });

        document.getElementById('saveNewRecordBtn').addEventListener('click', () => {
            const taskId = document.getElementById('taskId').value;
            const userId = document.getElementById('newStudentSelect').value;
            const score = document.getElementById('newStudentScore').value;

            if (!userId || score === '') {
                alert('Please select a student and enter a score.');
                return;
            }

            fetch(`/tasks/${taskId}/scores/add`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ user_id: userId, score })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    const tbody = document.getElementById('scoreTableBody');
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                <td>${data.data.user.name}</td>
                <td><input type="number" class="form-control score-input" 
                        data-user="${data.data.user.id}" value="${data.data.score}" min="0" max="100"></td>`;
                    tbody.appendChild(newRow);

                    document.getElementById('newStudentSelect').value = '';
                    document.getElementById('newStudentScore').value = '';
                    document.getElementById('newRecordForm').style.display = 'none';

                    alert('Student record added successfully!');
                })
                .catch(err => console.error(err));
        });
    </script>


</body>

</html>