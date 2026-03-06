<?php

namespace App\Models;

use App\Enums\CourseLevel;
use App\Enums\CourseModality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'course_category_id',
        'name',
        'slug',
        'description',
        'duration_hours',
        'modality',
        'level',
        'prerequisites',
        'certification_type',
        'price',
        'image',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'modality' => CourseModality::class,
            'level' => CourseLevel::class,
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<CourseCategory, $this> */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<CourseClass, $this> */
    public function classes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseClass::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Enrollment, $this> */
    public function enrollments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Certificate, $this> */
    public function certificates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
