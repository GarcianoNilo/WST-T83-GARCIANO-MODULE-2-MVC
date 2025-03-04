<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     */
    public function index()
    {
        // Count total students (role = student)
        $totalStudents = User::where('role', 'student')->count();
        
        // Count total subjects
        $totalSubjects = Subject::count();
        
        // Count enrolled students
        $enrolledStudents = User::where('role', 'student')
                                ->where('is_enrolled', true)
                                ->count();
        
        // Calculate average GWA (with precision of 2 decimal places)
        $averageGwa = Grade::whereIn('final_grade', ['1.00', '1.25', '1.50', '1.75', '2.00', '2.25', '2.50', '2.75', '3.00', '5.00'])
                         ->avg(DB::raw('CAST(final_grade AS DECIMAL(10,2))'));
        
        $averageGwa = $averageGwa ? number_format($averageGwa, 2) : 'N/A';
        
        // Get students with their GWA for the table
        $topStudents = User::where('role', 'student')
            ->select('users.id', 'users.name', 'users.email', 'users.student_id', 'users.course')
            ->addSelect(DB::raw('
                (SELECT COALESCE(ROUND(AVG(CAST(g.final_grade AS DECIMAL(10,2))), 2), 0)
                FROM grades g
                JOIN enrollments e ON g.enrollment_id = e.id
                WHERE e.user_id = users.id
                AND g.final_grade NOT IN ("INC", "DRP")
                ) as gwa
            '))
            ->orderBy(DB::raw('CAST(gwa AS DECIMAL(10,2))'))
            ->limit(10)
            ->get();
        
        // Get enrollment data by month for the current year
        $currentYear = Carbon::now()->year;
        $monthlyEnrollments = [];
        $enrollmentByMonth = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create($currentYear, $month, 1)->format('M');
            $enrollmentByMonth[] = $monthName;
            
            $count = Enrollment::whereYear('created_at', $currentYear)
                               ->whereMonth('created_at', $month)
                               ->count();
            
            $monthlyEnrollments[] = $count;
        }
        
        return view('admin.dashboard', compact(
            'totalStudents',
            'totalSubjects',
            'enrolledStudents',
            'averageGwa',
            'topStudents',
            'monthlyEnrollments',
            'enrollmentByMonth'
        ));
    }
}