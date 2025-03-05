<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class AdminEnrollmentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->get();
        $subjects = Subject::all();
        $enrollments = Enrollment::with(['student', 'subject'])->paginate(8);
        return view('admin.enrollments.index', compact('enrollments', 'students', 'subjects'));
    }

    public function getStudentsByCourse($course)
    {
        $students = User::where('role', 'student')
            ->where('course', $course)
            ->get(['id', 'name', 'student_id', 'year_level']);
        return response()->json($students);
    }

    public function getSubjectsByCourse($course, $yearLevel)
    {
        $subjects = Subject::where('course', $course)
            ->where('year_level', $yearLevel)
            ->get(['id', 'code', 'name', 'units']);
        return response()->json($subjects);
    }

    public function getStudent($studentId)
    {
        $student = User::where('student_id', $studentId)
            ->where('role', 'student')
            ->first(['id', 'name', 'course', 'year_level', 'student_id']);
        
        return response()->json($student);
    }

    public function getSubject($subjectCode)
    {
        $subject = Subject::where('code', $subjectCode)
            ->first(['id', 'code', 'name', 'units', 'course', 'year_level']);
        
        return response()->json($subject);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id', 
            'academic_year' => 'required|string',
            'semester' => 'required|in:1st,2nd',
        ]);

        // Check if enrollment already exists
        $existingEnrollment = Enrollment::where('user_id', $request->user_id)
            ->where('subject_id', $request->subject_id)
            ->where('academic_year', $request->academic_year)
            ->where('semester', $request->semester)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('admin.enrollments.index')
                ->with('error', 'Student is already enrolled in this subject for the selected academic year and semester.');
        }

        // Create enrollment
        try {
            Enrollment::create([
                'user_id' => $request->user_id,
                'subject_id' => $request->subject_id,
                'academic_year' => $request->academic_year,
                'semester' => $request->semester,
            ]);

            // Update the student's enrollment status to true
            User::where('id', $request->user_id)->update(['is_enrolled' => true]);

            return redirect()->route('admin.enrollments.index')
                ->with('success', 'Student enrolled successfully.');
        } catch (\Exception $e) {
            \Log::error('Enrollment error: ' . $e->getMessage());
            return redirect()->route('admin.enrollments.index')
                ->with('error', 'An error occurred while enrolling the student. Please try again.');
        }
    }

    public function destroy(Enrollment $enrollment)
    {
        $userId = $enrollment->user_id;
        
        // Delete the enrollment
        $enrollment->delete();
        
        // Update student enrollment status if they have no more enrollments
        $hasOtherEnrollments = Enrollment::where('user_id', $userId)->exists();
        if (!$hasOtherEnrollments) {
            User::where('id', $userId)->update(['is_enrolled' => false]);
        }

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment cancelled successfully');
    }

    public function searchStudents($search)
    {
        $students = User::where('role', 'student')
            ->where(function($query) use ($search) {
                $query->where('student_id', 'LIKE', "%{$search}%")
                      ->orWhere('name', 'LIKE', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'student_id', 'name', 'course', 'year_level']);
        
        return response()->json($students);
    }

    public function searchSubjects($search)
    {
        $subjects = Subject::where('code', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'code', 'name', 'units', 'course', 'year_level']);
        
        return response()->json($subjects);
    }

    public function getSubjectsByStudent($searchTerm, $studentId)
    {
        $enrollments = Enrollment::with('subject')
            ->where('user_id', $studentId)
            ->whereHas('subject', function($query) use ($searchTerm) {
                $query->where('code', 'like', "%{$searchTerm}%")
                      ->orWhere('name', 'like', "%{$searchTerm}%");
            })
            ->get();

        return response()->json($enrollments);
    }
}