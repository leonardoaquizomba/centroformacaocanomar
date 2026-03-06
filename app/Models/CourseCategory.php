<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $courses
 * @property-read int|null $courses_count
 *
 * @method static \Database\Factories\CourseCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseCategory whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CourseCategory extends Model
{
    /** @use HasFactory<\Database\Factories\CourseCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Course, $this> */
    public function courses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Course::class);
    }
}
