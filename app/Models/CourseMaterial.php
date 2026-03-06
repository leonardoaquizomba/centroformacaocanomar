<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $course_class_id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string $file_path
 * @property string $original_name
 * @property string|null $mime_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CourseClass $courseClass
 * @property-read \App\Models\User $uploader
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereCourseClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMaterial whereUserId($value)
 *
 * @mixin \Eloquent
 */
class CourseMaterial extends Model
{
    protected $fillable = [
        'course_class_id',
        'user_id',
        'title',
        'description',
        'file_path',
        'original_name',
        'mime_type',
    ];

    public function courseClass(): BelongsTo
    {
        return $this->belongsTo(CourseClass::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
