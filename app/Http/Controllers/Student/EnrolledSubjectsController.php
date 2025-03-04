<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EnrolledSubjectsController extends Controller
{
    /**
     * Display the student's enrolled subjects.
     */
    public function index(Request $request)
    {
        $student = Auth::user();
        
        // Get available academic years and semesters from the database
        $academicYears = Enrollment::where('user_id', $student->id)
            ->distinct()
            ->pluck('academic_year')
            ->toArray();
            
        // Default to the latest academic year if none selected
        $selectedYear = $request->input('academic_year', end($academicYears) ?: Carbon::now()->year . '-' . (Carbon::now()->year + 1));
        
        // Get selected semester or default to current semester
        $currentMonth = Carbon::now()->month;
        $defaultSemester = ($currentMonth >= 2 && $currentMonth <= 7) ? '2nd' : '1st';
        $selectedSemester = $request->input('semester', $defaultSemester);
        
        // Get all enrolled subjects for the selected academic year and semester
        $enrollments = Enrollment::with(['subject'])
            ->where('user_id', $student->id)
            ->where('academic_year', $selectedYear)
            ->where('semester', $selectedSemester)
            ->orderBy('created_at')
            ->get();
            
        // Calculate total enrolled units
        $totalUnits = $enrollments->sum(function($enrollment) {
            return $enrollment->subject->units;
        });
        
        // Get instructor information (in a real app, this would come from your database)
        // For demonstration purposes, I'm using sample instructor data
        $instructors = [
            'IT 1313' => 'K.J. Caseres',
            'IT 1312' => 'S. Aribe Jr.',
            'GE 109A' => 'J. Rulloda',
            'IT 1311A' => 'M.I. Mukara',
            'IS 106B' => 'C. Deocares',
            'IT 139A' => 'C.L. Navidad',
            'GE EL 102' => 'M. Manlangit',
            'IT 138C' => 'J. Abella',
            'IT 1310' => 'M.D. Dacer',
        ];
        
        return view('students.enrolledSubjects', compact(
            'student', 
            'enrollments', 
            'academicYears',
            'selectedYear',
            'selectedSemester',
            'totalUnits',
            'instructors'
        ));
    }
}