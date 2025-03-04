<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\AdminEnrollmentController;
use App\Http\Controllers\Admin\AdminGradeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\EnrolledSubjectsController;
use App\Http\Controllers\Student\StudentGradesController;

Route::get('/', function () {
    return view('auth/login');
})->name('home');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
    Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])->name('students.destroy');
    Route::resource('subjects', AdminSubjectController::class)->except(['show']);
    
    // Enrollment routes
    Route::resource('enrollments', AdminEnrollmentController::class)->except(['create', 'edit', 'update'])->names([
        'index' => 'enrollments.index',
        'store' => 'enrollments.store',
        'destroy' => 'enrollments.destroy',
    ]);
    
    // Ajax routes for dynamic dropdowns
    Route::get('get-students-by-course/{course}', [AdminEnrollmentController::class, 'getStudentsByCourse']);
    Route::get('get-subjects-by-course/{course}/{yearLevel}', [AdminEnrollmentController::class, 'getSubjectsByCourse']);
    
    Route::get('get-student/{studentId}', [AdminEnrollmentController::class, 'getStudent']);
    Route::get('get-subject/{subjectCode}', [AdminEnrollmentController::class, 'getSubject']);

    // Grades routes
    Route::resource('grades', AdminGradeController::class)->except(['create', 'edit']);

    // Search routes
    Route::get('search-students/{searchTerm}', [AdminEnrollmentController::class, 'searchStudents']);
    Route::get('search-subjects/{searchTerm}', [AdminEnrollmentController::class, 'searchSubjects']);
    Route::get('search-subjects/{searchTerm}/{studentId}', [AdminGradeController::class, 'getSubjectsByStudent']);
    Route::get('/enrollments/search', [AdminEnrollmentController::class, 'search'])->name('enrollments.search');
    Route::get('/admin/search-subjects-by-course/{term}/{course}', 'AdminController@searchSubjectsByCourse');
});

// Student Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/grades', [StudentGradesController::class, 'index'])->name('grades');
    
    Route::get('/enrolled-subjects', [EnrolledSubjectsController::class, 'index'])->name('enrolledSubjects');
});

// Common Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
