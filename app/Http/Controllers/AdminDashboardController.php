<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalStudents = User::where('email', '!=', 'admin@gmail.com')->count();

        $todayAttendances = Attendance::whereDate('date', $today)->get();

        $presentToday = $todayAttendances->whereNotNull('time_in')->count();

        $lateCount = $todayAttendances->filter(function ($attendance) {
            return $attendance->time_in && $attendance->time_in > '08:00:00';
        })->count();

        $absentCount = $totalStudents - $presentToday;

        $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $attendanceData = [];
        foreach ($weekDays as $i => $day) {
            $date = Carbon::now()->startOfWeek()->addDays($i);
            $attendanceData[] = Attendance::whereDate('date', $date)->count();
        }

        $recentScans = Attendance::with('user')
            ->whereDate('date', $today)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('admin_dashboard', compact(
            'totalStudents',
            'presentToday',
            'lateCount',
            'absentCount',
            'attendanceData',
            'recentScans',
            'weekDays'
        ));
    }
}
    