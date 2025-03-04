<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $fillable = [
        'code',
        'name',
        'units',
        'course',
        'year_level',
        'semester'
    ];

    /**
     * The attributes that should have unique values.
     */
    protected $unique = ['code'];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subject_user')
            ->withTimestamps()
            ->withPivot('status');
    }
} 