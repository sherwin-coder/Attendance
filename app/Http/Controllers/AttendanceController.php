<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display the QR scanning page.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('student', compact('subjects'));
    }

    /**
     * Handle QR scan data submission.
     */
    public function scan(Request $request)
    {
        $studentNo = $request->studentno;
        $subjectCode = $request->subject_code;

        // Find the student and subject
        $student = User::where('studentno', $studentNo)->first();
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found.']);
        }

        $subject = Subject::where('code', $subjectCode)->first();
        if (!$subject) {
            return response()->json(['status' => 'error', 'message' => 'Invalid subject.']);
        }

        // Check schedule
        $now = now();
        $currentDay = $now->format('D');
        $currentTime = $now->format('H:i');

        $isWithinSchedule = false;

        foreach (explode(',', $subject->schedule ?? '') as $sched) {
            if (preg_match('/([A-Za-z]{3}) (\d{2}:\d{2}[AP]M)-(\d{2}:\d{2}[AP]M)/', trim($sched), $matches)) {
                if ($matches[1] === $currentDay) {
                    $start = date('H:i', strtotime($matches[2]));
                    $end = date('H:i', strtotime($matches[3]));
                    if ($currentTime >= $start && $currentTime <= $end) {
                        $isWithinSchedule = true;
                        break;
                    }
                }
            }
        }

        if (!$isWithinSchedule) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are outside the class schedule for ' . $subject->code . '.'
            ]);
        }

        // ✅ Corrected for your table structure
        $attendance = Attendance::firstOrCreate([
            'user_id' => $student->id,
            'subject_id' => $subject->id,
            'date' => now()->toDateString(),
        ]);

        if (!$attendance->time_in) {
            $attendance->update(['time_in' => $now]);
            return response()->json(['status' => 'success', 'message' => 'Time in recorded for ' . $subject->code]);
        } elseif (!$attendance->time_out) {
            $attendance->update(['time_out' => $now]);
            return response()->json(['status' => 'info', 'message' => 'Time out recorded for ' . $subject->code]);
        } else {
            return response()->json(['status' => 'info', 'message' => 'Attendance already completed for today.']);
        }
    }



    /**
     * Show the attendance logs.
     */
    public function logs(Request $request)
    {
        $selectedSubject = $request->input('subject'); // from dropdown
        $subjects = Subject::all();

        $query = Attendance::with(['user', 'subject'])
            ->orderBy('date', 'desc');

        if ($selectedSubject) {
            $query->whereHas('subject', function ($q) use ($selectedSubject) {
                $q->where('id', $selectedSubject);
            });
        }

        $logs = $query->paginate(10);

        return view('attendancelogs', compact('logs', 'subjects', 'selectedSubject'));
    }
}
