<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminStudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->get();
        return view('admin.students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'string', 'max:20', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'course' => ['required', 'string', 'max:20'],
            'year_level' => ['required', 'string', 'in:1,2,3,4'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $data = $request->all();
        $data['role'] = 'student';
        $data['is_enrolled'] = false;

        User::create($data);
        return redirect()->route('admin.students.index')
            ->with('success', 'Student added successfully');
    }

    public function update(Request $request, User $student)
    {
        $request->validate([
            'student_id' => ['required', 'string', 'max:20', 'unique:users,student_id,'.$student->id],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$student->id],
            'course' => ['required', 'string', 'max:20'],
            'year_level' => ['required', 'string', 'in:1,2,3,4'],
        ]);

        $student->update($request->all());
        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully');
    }

    public function destroy(User $student)
    {
        if ($student->is_enrolled) {
            return back()->with('error', 'Cannot delete enrolled student');
        }
        
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully');
    }
} 