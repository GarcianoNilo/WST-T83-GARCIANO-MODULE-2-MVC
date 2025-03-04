<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_id',
        'academic_year',
        'semester',
        'status'
    ];

    /**
     * Get the student associated with the enrollment.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the subject associated with the enrollment.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the grade associated with the enrollment.
     */
    public function grade(): HasOne
    {
        return $this->hasOne(Grade::class);
    }

    /**
     * Check if the enrollment has a grade.
     */
    public function hasGrade()
    {
        return $this->grade()->exists();
    }
}