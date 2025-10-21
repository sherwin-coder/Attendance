<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('addsubj', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:subjects,code',
            'name' => 'required',
            'schedule' => 'required',
        ]);

        Subject::create($request->all());

        return redirect()->route('subjects.index')->with('success', 'Subject added successfully!');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully!');

    }
}
