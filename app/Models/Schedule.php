<?php

namespace App\Models;

use App\Enums\DayOfWeek;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'course_class_id',
        'day_of_week',
        'start_time',
        'end_time',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'day_of_week' => DayOfWeek::class,
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<CourseClass, $this> */
    public function courseClass(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CourseClass::class);
    }
}
