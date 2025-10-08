<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Display the QR scanning page
    public function index()
    {
        return view('student');
    }

    // Handle QR scan data
    public function scan(Request $request)
    {
        $studentno = $request->input('studentno');
        $user = User::where('studentno', $studentno)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Student not found']);
        }

        $today = Carbon::today();

        $attendance = Attendance::firstOrNew([
            'user_id' => $user->id,
            'date' => $today,
        ]);

        if (!$attendance->time_in) {
            $attendance->time_in = Carbon::now()->format('H:i:s');
            $attendance->save();
            return response()->json(['status' => 'success', 'message' => 'Time in recorded']);
        } elseif (!$attendance->time_out) {
            $attendance->time_out = Carbon::now()->format('H:i:s');
            $attendance->save();
            return response()->json(['status' => 'success', 'message' => 'Time out recorded']);
        } else {
            return response()->json(['status' => 'info', 'message' => 'Already timed in and out today']);
        }
    }
}
