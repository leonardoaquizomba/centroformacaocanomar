<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $bio
 * @property string|null $specialization
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CourseClass> $classes
 * @property-read int|null $classes_count
 * @property-read \App\Models\User $user
 *
 * @method static \Database\Factories\TeacherProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherProfile whereUserId($value)
 *
 * @mixin \Eloquent
 */
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
