<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subject;
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
}
