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
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user is an admin
     * 
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a student
     * 
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }
    
    /**
     * Get the subjects enrolled by this student
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'enrollments', 'user_id', 'subject_id')
                    ->withPivot('id', 'grade')
                    ->withTimestamps();
    }
}