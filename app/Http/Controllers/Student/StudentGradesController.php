<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentGradesController extends Controller
{
    /**
     * Display the student's grades.
     */
    public function index(Request $request)
    {
        $student = Auth::user();
        
        // Get all academic years and semesters the student has grades for
        $academicYears = Grade::join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->where('enrollments.user_id', $student->id)
            ->distinct()
            ->pluck('enrollments.academic_year')
            ->toArray();
            
        // Default to the latest academic year if none selected
        $selectedYear = $request->input('academic_year', end($academicYears) ?: Carbon::now()->year . '-' . (Carbon::now()->year + 1));
        
        // Get all semesters for the selected academic year
        $semesters = Grade::join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->where('enrollments.user_id', $student->id)
            ->where('enrollments.academic_year', $selectedYear)
            ->distinct()
            ->pluck('enrollments.semester')
            ->toArray();
            
        // Default to the first semester if none selected
        $selectedSemester = $request->input('semester', reset($semesters) ?: '1st');
        
        // Get all grades for the selected academic year and semester
        $grades = Grade::join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->join('subjects', 'enrollments.subject_id', '=', 'subjects.id')
            ->where('enrollments.user_id', $student->id)
            ->where('enrollments.academic_year', $selectedYear)
            ->where('enrollments.semester', $selectedSemester)
            ->select(
                'grades.*',
                'subjects.code',
                'subjects.name',
                'subjects.units',
                'enrollments.created_at as enrollment_date'
            )
            ->orderBy('subjects.code')
            ->get();
        
        // Get currently enrolled subjects that don't have grades yet
        $pendingGrades = Enrollment::with('subject')
            ->where('user_id', $student->id)
            ->where('academic_year', $selectedYear)
            ->where('semester', $selectedSemester)
            ->whereDoesntHave('grade')
            ->get();
            
        // Calculate statistics
        $totalSubjects = $grades->count() + $pendingGrades->count();
        $totalUnits = $grades->sum('units') + $pendingGrades->sum(function($enrollment) {
            return $enrollment->subject->units;
        });
        
        $passedCount = $grades->filter(function($grade) {
            return in_array($grade->final_grade, ['1.00', '1.25', '1.50', '1.75', '2.00', '2.25', '2.50', '2.75', '3.00']);
        })->count();
        
        $failedCount = $grades->filter(function($grade) {
            return $grade->final_grade == '5.00';
        })->count();
        
        $incompleteCount = $grades->filter(function($grade) {
            return $grade->final_grade == 'INC';
        })->count();
        
        $droppedCount = $grades->filter(function($grade) {
            return $grade->final_grade == 'DRP';
        })->count();
        
        // Calculate GWA (Grade Weighted Average)
        $totalWeightedGrade = 0;
        $totalGradedUnits = 0;
        
        foreach ($grades as $grade) {
            if (in_array($grade->final_grade, ['1.00', '1.25', '1.50', '1.75', '2.00', '2.25', '2.50', '2.75', '3.00', '5.00'])) {
                $totalWeightedGrade += (float)$grade->final_grade * $grade->units;
                $totalGradedUnits += $grade->units;
            }
        }
        
        $gwa = $totalGradedUnits > 0 ? round($totalWeightedGrade / $totalGradedUnits, 2) : 'N/A';
        
        // Group grades by value for chart
        $gradeDistribution = [
            'Excellent (1.00-1.50)' => $grades->filter(function($grade) {
                return in_array($grade->final_grade, ['1.00', '1.25', '1.50']);
            })->count(),
            'Very Good (1.75-2.25)' => $grades->filter(function($grade) {
                return in_array($grade->final_grade, ['1.75', '2.00', '2.25']);
            })->count(),
            'Good (2.50-3.00)' => $grades->filter(function($grade) {
                return in_array($grade->final_grade, ['2.50', '2.75', '3.00']);
            })->count(),
            'Failed (5.00)' => $failedCount,
            'Others' => $incompleteCount + $droppedCount
        ];
        
        // Get cumulative GWA across all semesters
        $cumulativeGrades = Grade::join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->join('subjects', 'enrollments.subject_id', '=', 'subjects.id')
            ->where('enrollments.user_id', $student->id)
            ->whereIn('grades.final_grade', ['1.00', '1.25', '1.50', '1.75', '2.00', '2.25', '2.50', '2.75', '3.00', '5.00'])
            ->select(
                'grades.final_grade',
                'subjects.units'
            )
            ->get();
            
        $totalCumulativeWeightedGrade = 0;
        $totalCumulativeUnits = 0;
        
        foreach ($cumulativeGrades as $grade) {
            $totalCumulativeWeightedGrade += (float)$grade->final_grade * $grade->units;
            $totalCumulativeUnits += $grade->units;
        }
        
        $cumulativeGwa = $totalCumulativeUnits > 0 ? round($totalCumulativeWeightedGrade / $totalCumulativeUnits, 2) : 'N/A';
        
        return view('students.grades', compact(
            'student',
            'grades',
            'pendingGrades',
            'academicYears',
            'semesters',
            'selectedYear',
            'selectedSemester',
            'totalSubjects',
            'totalUnits',
            'passedCount',
            'failedCount',
            'incompleteCount',
            'droppedCount',
            'gwa',
            'cumulativeGwa',
            'gradeDistribution'
        ));
    }
}