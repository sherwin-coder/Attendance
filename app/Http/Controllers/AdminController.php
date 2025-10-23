<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Show new admin/professor creation form
    public function create()
    {
        $subjects = Subject::all();
        return view('newadmin', compact('subjects'));
    }

    // Store new admin or professor
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,professor',
            'subjects' => 'array|nullable'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // If professor, assign subjects
        if ($request->role === 'professor' && $request->has('subjects')) {
            Subject::whereIn('id', $request->subjects)->update(['professor_id' => $user->id]);
        }

        return redirect()->back()->with('success', 'New ' . ucfirst($request->role) . ' created successfully!');
    }
}
