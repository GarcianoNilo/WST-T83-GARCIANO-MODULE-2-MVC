<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'final_grade',
        'remarks',
        'academic_year',
        'semester',
    ];

    /**
     * Get the enrollment that owns the grade.
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Get the academic year from the enrollment.
     */
    public function getAcademicYearAttribute()
    {
        return $this->enrollment->academic_year;
    }

    /**
     * Get the semester from the enrollment.
     */
    public function getSemesterAttribute()
    {
        return $this->enrollment->semester;
    }
    
    /**
     * Set the remarks based on the final grade.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($grade) {
            // Set remarks based on grade value
            if ($grade->final_grade === 'INC') {
                $grade->remarks = 'INCOMPLETE';
            } else if (in_array($grade->final_grade, ['5.00'])) {
                $grade->remarks = 'FAILED';
            } else {
                $grade->remarks = 'PASSED';
            }
        });
    }
}
