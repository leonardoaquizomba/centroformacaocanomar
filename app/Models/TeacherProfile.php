<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'specialization',
        'phone',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this> */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<CourseClass, $this> */
    public function classes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseClass::class, 'teacher_id', 'user_id');
    }
}
