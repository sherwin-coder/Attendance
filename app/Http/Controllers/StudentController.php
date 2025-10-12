<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
        ->where('email', '!=', 'admin@gmail.com');

        // Filtering by year & section
        if ($request->filled('yrsec')) {
            $query->where('yrsec', $request->yrsec);
        }

        // Searching
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('studentno', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->orderBy('yrsec')->paginate(10);
        $yrsecs = User::select('yrsec')->distinct()->pluck('yrsec')
        ->where('email', '!=', 'admin@gmail.com');
;

        return view('studentrec', compact('students', 'yrsecs'));
    }

    public function create()
    {
        $yrsecs = User::select('yrsec')->distinct()->pluck('yrsec');
        return view('student_create', compact('yrsecs'));
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'studentno' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'yrsec' => 'nullable|string|max:255',
            'newYrSec' => 'nullable|string|max:255',
        ]);

        // Determine final yrsec value
        $yrsec = $request->yrsec === 'add_new' ? $request->newYrSec : $request->yrsec;

        // Make sure it’s not empty
        if (empty($yrsec)) {
            return back()->withErrors(['yrsec' => 'Please select or enter a Year & Section.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'studentno' => $request->studentno,
            'email' => $request->email,
            'yrsec' => $yrsec, // Explicitly use the processed value
        ]);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }


    public function edit($id)
    {
        $student = User::findOrFail($id);
        $yrsecs = User::select('yrsec')->distinct()->pluck('yrsec');
        return view('student_edit', compact('student', 'yrsecs'));
    }

    public function update(Request $request, $id)
{
    $student = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'studentno' => 'required|string|unique:users,studentno,' . $student->id,
        'email' => 'required|email|unique:users,email,' . $student->id,
        'yrsec' => 'nullable|string',
        'newYrSec' => 'nullable|string|max:255',
    ]);

    $yrsec = $request->yrsec === 'add_new' ? $request->newYrSec : $request->yrsec;

    if (empty($yrsec)) {
        return back()->withErrors(['yrsec' => 'Please select or enter a Year & Section.'])->withInput();
    }

    $student->update([
        'name' => $request->name,
        'studentno' => $request->studentno,
        'email' => $request->email,
        'yrsec' => $yrsec,
    ]);

    return redirect()->route('students.index')->with('success', 'Student updated successfully.');
}


    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
