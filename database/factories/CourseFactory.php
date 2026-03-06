<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_category_id' => \App\Models\CourseCategory::factory(),
            'name' => fake()->words(3, true),
            'slug' => fake()->unique()->slug(3),
            'description' => fake()->paragraph(),
            'duration_hours' => fake()->randomElement([20, 40, 60, 80, 120]),
            'modality' => fake()->randomElement(['presencial', 'online', 'misto']),
            'level' => fake()->randomElement(['básico', 'médio', 'avançado']),
            'prerequisites' => null,
            'certification_type' => 'Certificado de Frequência',
            'price' => fake()->randomElement([10000, 15000, 25000, 35000, 50000]),
            'image' => null,
            'is_active' => true,
            'is_featured' => false,
        ];
    }
}
