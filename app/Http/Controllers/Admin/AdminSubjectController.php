<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::paginate(8);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:subjects'],
            'name' => ['required', 'string', 'max:255'],
            'units' => ['required', 'integer', 'min:1', 'max:6'],
            'course' => ['required', 'string', 'max:20'],
            'year_level' => ['required', 'string', 'in:1,2,3,4'],
        ]);

        $data = $request->all();
        $data['semester'] = '1st';

        Subject::create($data);
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject added successfully');
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code,'.$subject->id],
            'name' => ['required', 'string', 'max:255'],
            'units' => ['required', 'integer', 'min:1', 'max:6'],
            'course' => ['required', 'string', 'max:20'],
            'year_level' => ['required', 'string', 'in:1,2,3,4'],
        ]);

        $subject->update($request->all());
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully');
    }
}