<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;



Route::resource('subjects', SubjectController::class);

Route::get('newadmin', [AdminController::class, 'create'])->name('newadmin');
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');


Route::get('/admin_dashboard', [AdminDashboardController::class, 'index'])->name('admin_dashboard');

Route::get('/actquiz', [TaskController::class, 'index'])->name('actquiz');
Route::post('/actquiz/add', [TaskController::class, 'store'])->name('task.add');
Route::delete('/actquiz/{id}', [TaskController::class, 'destroy'])->name('task.delete');
Route::get('/tasks/filter', [TaskController::class, 'filter'])->name('tasks.filter');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/tasks/{taskId}/scores', [TaskController::class, 'getScores']);
Route::post('/tasks/{taskId}/scores', [TaskController::class, 'updateScores']);
Route::post('/tasks/{id}/complete', [TaskController::class, 'markAsCompleted']);
Route::post('/tasks/{taskId}/scores/add', [TaskController::class, 'addScore'])->name('tasks.scores.add');

// Student Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/attendance-logs', [AttendanceController::class, 'logs'])->name('attendance.logs');

});


Route::get('/', [AttendanceController::class, 'index'])->name('attendance.scan');
Route::post('/attendance/scan', [AttendanceController::class, 'scan'])->name('attendance.scan.post');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
