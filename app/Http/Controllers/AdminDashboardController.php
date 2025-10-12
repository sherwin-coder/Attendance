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

        // Summary counts
        $totalStudents = User::where('email', '!=', 'admin@gmail.com')->count();

        $presentToday = Attendance::whereDate('date', $today)
            ->whereNotNull('time_in')
            ->count();

        $lateCount = Attendance::whereDate('date', $today)
            ->whereTime('time_in', '>', '08:00:00')
            ->count();

        $absentCount = $totalStudents - $presentToday;

        // Attendance data for chart
        $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri','Sat'];
        $attendanceData = [];
        foreach ($weekDays as $i => $day) {
            $date = Carbon::now()->startOfWeek()->addDays($i);
            $attendanceData[] = Attendance::whereDate('date', $date)->count();
        }

        // Recent scans
        $recentScans = Attendance::with('user')
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
