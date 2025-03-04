<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with(['enrollment.student', 'enrollment.subject'])->get();
        return view('admin.grades.index', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'final_grade' => 'required',
            // We don't need to validate academic_year and semester since they come from the enrollment
        ]);

        // Check if grade already exists
        if (Grade::where('enrollment_id', $request->enrollment_id)->exists()) {
            return redirect()->back()->with('error', 'A grade for this enrollment already exists');
        }

        // Get remarks based on the grade
        $remarks = $this->getRemarks($request->final_grade);

        // Create the grade
        Grade::create([
            'enrollment_id' => $request->enrollment_id,
            'final_grade' => $request->final_grade,
            'remarks' => $remarks,
            // No need to store academic_year and semester as they're retrieved from the enrollment
        ]);

        return redirect()->route('admin.grades.index')->with('success', 'Grade added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return response()->json($grade->load(['enrollment.student', 'enrollment.subject']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'final_grade' => 'required',
        ]);

        // Determine remarks based on the grade
        $remarks = 'PASSED';
        if ($request->final_grade === 'INC') {
            $remarks = 'INCOMPLETE';
        } elseif ($request->final_grade === '5.00') {
            $remarks = 'FAILED';
        }

        $grade->update([
            'final_grade' => $request->final_grade,
            'remarks' => $remarks,
        ]);

        return redirect()->route('admin.grades.index')
            ->with('success', 'Grade updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('admin.grades.index')
            ->with('success', 'Grade deleted successfully');
    }

    /**
     * Get subjects for a specific student that don't have grades yet.
     */
    public function getSubjectsByStudent($searchTerm, $studentId)
    {
        $enrollments = Enrollment::with('subject')
            ->where('user_id', $studentId)
            ->whereDoesntHave('grade')  // Only subjects without grades
            ->whereHas('subject', function($query) use ($searchTerm) {
                $query->where('code', 'like', "%{$searchTerm}%")
                      ->orWhere('name', 'like', "%{$searchTerm}%");
            })
            ->get();
            
        $formattedEnrollments = $enrollments->map(function ($enrollment) {
            return [
                'enrollment_id' => $enrollment->id,
                'code' => $enrollment->subject->code,
                'name' => $enrollment->subject->name,
                'units' => $enrollment->subject->units
            ];
        });
        
        return response()->json($formattedEnrollments);
    }

    /**
     * Search enrollments based on criteria.
     */
    public function search(Request $request)
    {
        $studentId = $request->student_id;
        $subjectCode = $request->subject_code;
        $academicYear = $request->academic_year;
        $semester = $request->semester;
        
        // Find enrollments that match the criteria
        $enrollments = Enrollment::with('subject')
            ->where('user_id', $studentId)
            ->where('academic_year', $academicYear)
            ->where('semester', $semester)
            ->whereHas('subject', function($query) use ($subjectCode) {
                $query->where('code', 'like', "%{$subjectCode}%");
            })
            ->get();
        
        // Return as JSON
        return response()->json($enrollments);
    }

    /**
     * Get appropriate remarks based on the final grade.
     *
     * @param string|float $finalGrade The final grade value
     * @return string The remarks
     */
    private function getRemarks($finalGrade)
    {
        // Convert to float if it's a numeric grade
        $numericGrade = is_numeric($finalGrade) ? (float)$finalGrade : null;
        
        if ($numericGrade !== null) {
            if ($numericGrade >= 1.0 && $numericGrade <= 3.0) {
                return 'Passed';
            } elseif ($numericGrade == 5.0) {
                return 'Failed';
            }
        } else {
            // Handle non-numeric grades
            if ($finalGrade == 'INC') {
                return 'Incomplete';
            } elseif ($finalGrade == 'DRP') {
                return 'Dropped';
            }
        }
        
        // Default case if none of the above matches
        return 'Invalid Grade';
    }
}
