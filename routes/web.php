<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StudentController;

Route::get('/admin_dashboard', [AdminDashboardController::class, 'index'])->name('admin_dashboard');

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

require __DIR__.'/auth.php';
