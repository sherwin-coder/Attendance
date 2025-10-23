<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subject;
use App\Models\Student;
use App\Models\StudentTaskScore;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $tasks = Task::with('subject')->latest()->paginate(10);
        return view('actquiz', compact('tasks', 'subjects'));
    }

    public function filter(Request $request)
    {
        $subjectCode = $request->input('subject_code');
        $tasks = Task::where('subject_code', $subjectCode)->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Quiz,Activity',
            'subject_code' => 'required',
            'due_date' => 'required|date',
        ]);

        Task::create($request->all());
        return redirect()->back()->with('success', 'Task added successfully.');
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Task deleted.');
    }

    public function getScores($taskId)
    {
        // Fetch all scores for this task, including the user’s info
        $scores = StudentTaskScore::with('user')
            ->where('task_id', $taskId)
            ->get();

        // Also get task info
        $task = Task::select('id', 'title', 'type', 'status')
            ->findOrFail($taskId);

        return response()->json([
            'task' => $task,
            'scores' => $scores
        ]);
    }

    public function updateScores(Request $request, $taskId)
    {
        $request->validate([
            'scores' => 'required|array',
            'scores.*.user_id' => 'required|integer|exists:users,id',
            'scores.*.score' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->scores as $data) {
            StudentTaskScore::updateOrCreate(
                [
                    'user_id' => $data['user_id'],
                    'task_id' => $taskId,
                ],
                [
                    'score' => $data['score'],
                ]
            );
        }

        // ✅ Return consistent response with success flag for JS handling
        return response()->json(['success' => true, 'message' => 'Scores updated successfully']);
    }

    public function addScore(Request $request, $taskId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'score' => 'required|integer|min:0|max:100',
        ]);

        $exists = StudentTaskScore::where('user_id', $request->user_id)
            ->where('task_id', $taskId)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'This student already has a record for this task.'], 400);
        }

        $newScore = StudentTaskScore::create([
            'user_id' => $request->user_id,
            'task_id' => $taskId,
            'score' => $request->score,
        ]);

        return response()->json([
            'message' => 'Student record added successfully.',
            'data' => $newScore->load('user')
        ]);
    }



    // ✅ Mark task as completed
    public function markAsCompleted($id)
    {
        $task = Task::findOrFail($id);
        $task->update(['status' => 'Completed']);

        return response()->json(['message' => 'Task marked as completed']);
    }
}
