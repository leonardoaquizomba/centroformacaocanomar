<?php

namespace App\Models;

use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $enrollment_id
 * @property DocumentType $type
 * @property string $file_path
 * @property string $original_name
 * @property string $mime_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Enrollment $enrollment
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument whereEnrollmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentDocument whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class EnrollmentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'type',
        'file_path',
        'original_name',
        'mime_type',
    ];

    protected function casts(): array
    {
        return [
            'type' => DocumentType::class,
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Enrollment, $this> */
    public function enrollment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
