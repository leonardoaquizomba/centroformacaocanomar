<?php

namespace App\Models;

use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
