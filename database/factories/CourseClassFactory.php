<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseClass>
 */
class CourseClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => \App\Models\Course::factory(),
            'teacher_id' => null,
            'name' => 'Turma '.fake()->bothify('??##'),
            'start_date' => now()->addMonth(),
            'end_date' => now()->addMonths(3),
            'max_students' => 20,
            'is_active' => true,
        ];
    }
}
