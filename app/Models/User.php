<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'name',
        'email',
        'password',
        'role',
        'course',
        'year_level',
        'is_enrolled'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_enrolled' => 'boolean',
        ];
    }

    /**
     * Get the subjects that the student is enrolled in
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_user')
            ->withTimestamps()
            ->withPivot('status')
            ->unique();
    }

    /**
     * Enroll the student in a subject
     */
    public function enrollInSubject(Subject $subject): array
    {
        // Check if already enrolled
        if ($this->subjects()->where('subject_id', $subject->id)->exists()) {
            return [
                'success' => false,
                'message' => "You are already enrolled in {$subject->name} ({$subject->code})"
            ];
        }

        // Check if subject has reached maximum capacity
        if ($subject->is_full) {
            return [
                'success' => false,
                'message' => "Subject {$subject->name} has reached maximum capacity"
            ];
        }
        
        $this->subjects()->attach($subject->id, ['status' => 'enrolled']);
        $this->update(['is_enrolled' => true]);

        return [
            'success' => true,
            'message' => "Successfully enrolled in {$subject->name} ({$subject->code})"
        ];
    }
    
    /**
     * Drop a subject enrollment
     */
    public function dropSubject(Subject $subject): array
    {
        // Check if enrolled in the subject
        if (!$this->subjects()->where('subject_id', $subject->id)->exists()) {
            return [
                'success' => false,
                'message' => "You are not enrolled in this subject."
            ];
        }
        
        $this->subjects()->detach($subject->id);
        
        // If no more subjects, update is_enrolled flag
        if ($this->subjects()->count() === 0) {
            $this->update(['is_enrolled' => false]);
        }
        
        return [
            'success' => true,
            'message' => "Successfully dropped {$subject->name} ({$subject->code})"
        ];
    }

    /**
     * Get student's current enrollment status
     */
    public function getEnrollmentStatus(): string
    {
        return $this->is_enrolled ? 'Enrolled' : 'Not Enrolled';
    }

    /**
     * Get all subjects a student can enroll in (not already enrolled)
     */
    public function availableSubjects(): Collection
    {
        $enrolledSubjectIds = $this->subjects()->pluck('subjects.id');
        
        return Subject::whereNotIn('id', $enrolledSubjectIds)
            ->where('is_active', true)
            ->get();
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a student
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
    
    /**
     * Get student's year level as a string (e.g., "First Year")
     */
    public function yearLevelName(): string
    {
        $yearLevels = [
            '1' => 'First Year',
            '2' => 'Second Year',
            '3' => 'Third Year',
            '4' => 'Fourth Year'
        ];
        
        return $yearLevels[$this->year_level] ?? 'Unknown';
    }
    
    /**
     * Get initials from name (for avatar)
     */
    public function getInitials(): string
    {
        $nameParts = explode(' ', $this->name);
        $initials = '';
        
        if (count($nameParts) >= 2) {
            $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[count($nameParts) - 1], 0, 1));
        } else {
            $initials = strtoupper(substr($this->name, 0, 1));
        }
        
        return $initials;
    }
    
    /**
     * Scope a query to students only
     */
    public function scopeStudents(Builder $query): Builder
    {
        return $query->where('role', 'student');
    }
    
    /**
     * Scope a query to enrolled students only
     */
    public function scopeEnrolled(Builder $query): Builder
    {
        return $query->where('is_enrolled', true);
    }
    
    /**
     * Scope a query to not enrolled students only
     */
    public function scopeNotEnrolled(Builder $query): Builder
    {
        return $query->where('is_enrolled', false);
    }
    
    /**
     * Scope a query to filter by course
     */
    public function scopeByCourse(Builder $query, string $course): Builder
    {
        return $query->where('course', $course);
    }
    
    /**
     * Scope a query to filter by year level
     */
    public function scopeByYearLevel(Builder $query, string $yearLevel): Builder
    {
        return $query->where('year_level', $yearLevel);
    }
    
    /**
     * Get the allowed courses for students
     */
    public static function getAvailableCourses(): array
    {
        return [
            'BSIT' => 'Bachelor of Science in Information Technology',
            'BSCS' => 'Bachelor of Science in Computer Science',
            'BSIS' => 'Bachelor of Science in Information Systems'
        ];
    }
}