<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentDashboardController extends Controller
{
    /**
     * Show the student dashboard with personalized data.
     */
    public function index()
    {
        $student = Auth::user();
        $currentAcademicYear = Carbon::now()->year - 1 . '-' . (Carbon::now()->year);
        
        // Get the current semester based on month (1st: Aug-Jan, 2nd: Feb-Jul)
        $currentMonth = Carbon::now()->month;
        $currentSemester = ($currentMonth >= 2 && $currentMonth <= 7) ? '2nd' : '1st';
        
        // Get enrolled subjects for current semester
        $currentEnrollments = Enrollment::with('subject')
            ->where('user_id', $student->id)
            ->where('academic_year', $currentAcademicYear)
            ->where('semester', $currentSemester)
            ->get();
        
        // Calculate GWA
        $grades = Grade::join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->where('enrollments.user_id', $student->id)
            ->whereIn('grades.final_grade', ['1.00', '1.25', '1.50', '1.75', '2.00', '2.25', '2.50', '2.75', '3.00', '5.00'])
            ->select('grades.final_grade')
            ->get();
            
        $totalUnits = 0;
        $weightedGradeSum = 0;
        
        foreach($grades as $grade) {
            // For this example, assuming each subject is 3 units
            // In a real application, you'd fetch the actual units for each subject
            $units = 3;
            $totalUnits += $units;
            $weightedGradeSum += (float)$grade->final_grade * $units;
        }
        
        $gwa = $totalUnits > 0 ? round($weightedGradeSum / $totalUnits, 2) : 0;
        
        // Get grades distribution for chart
        $gradeDistribution = [
            '1.00' => 0,
            '1.25' => 0, 
            '1.50' => 0,
            '1.75' => 0,
            '2.00' => 0,
            '2.25' => 0,
            '2.50' => 0,
            '2.75' => 0,
            '3.00' => 0,
            '5.00' => 0,
            'INC' => 0,
            'DRP' => 0
        ];
        
        $allGrades = Grade::join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->where('enrollments.user_id', $student->id)
            ->select('grades.final_grade')
            ->get();
            
        foreach ($allGrades as $grade) {
            if (isset($gradeDistribution[$grade->final_grade])) {
                $gradeDistribution[$grade->final_grade]++;
            }
        }
        
        // Count total units enrolled
        $totalEnrolledUnits = $currentEnrollments->sum(function($enrollment) {
            return $enrollment->subject->units;
        });
        
        // Recent activities (enrollments and grades)
        $recentActivities = collect();
        
        $recentEnrollments = Enrollment::with('subject')
            ->where('user_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function($enrollment) {
                return [
                    'type' => 'enrollment',
                    'subject' => $enrollment->subject->name,
                    'date' => $enrollment->created_at,
                    'details' => 'You enrolled in ' . $enrollment->subject->code . ' for ' . $enrollment->academic_year . ' (' . $enrollment->semester . ' semester)'
                ];
            });
            
        $recentGrades = Grade::join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->join('subjects', 'enrollments.subject_id', '=', 'subjects.id')
            ->where('enrollments.user_id', $student->id)
            ->orderBy('grades.created_at', 'desc')
            ->select('grades.*', 'subjects.name as subject_name', 'subjects.code as subject_code')
            ->limit(3)
            ->get()
            ->map(function($grade) {
                return [
                    'type' => 'grade',
                    'subject' => $grade->subject_name,
                    'date' => $grade->created_at,
                    'details' => 'You received a grade of ' . $grade->final_grade . ' in ' . $grade->subject_code
                ];
            });
            
        $recentActivities = $recentEnrollments->merge($recentGrades)->sortByDesc('date')->take(5);
        
        return view('students.dashboard', compact(
            'student',
            'currentEnrollments',
            'gwa',
            'totalEnrolledUnits',
            'gradeDistribution', 
            'recentActivities',
            'currentAcademicYear',
            'currentSemester'
        ));
    }
}