<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    /** @use HasFactory<\Database\Factories\CourseClassFactory> */
    use HasFactory;

    protected $fillable = [
        'course_id',
        'teacher_id',
        'name',
        'start_date',
        'end_date',
        'max_students',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Course, $this> */
    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this> */
    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Schedule, $this> */
    public function schedules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Enrollment, $this> */
    public function enrollments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
