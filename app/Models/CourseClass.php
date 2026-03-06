<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $course_id
 * @property int|null $teacher_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property int $max_students
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Enrollment> $enrollments
 * @property-read int|null $enrollments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Grade> $grades
 * @property-read int|null $grades_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CourseMaterial> $materials
 * @property-read int|null $materials_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Schedule> $schedules
 * @property-read int|null $schedules_count
 * @property-read \App\Models\User|null $teacher
 *
 * @method static \Database\Factories\CourseClassFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereMaxStudents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseClass whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<CourseMaterial, $this> */
    public function materials(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseMaterial::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Grade, $this> */
    public function grades(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Attendance, $this> */
    public function attendances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
