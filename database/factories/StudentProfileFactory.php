<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentProfile>
 */
class StudentProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bi_number' => strtoupper($this->faker->bothify('??########')),
            'date_of_birth' => $this->faker->dateTimeBetween('-45 years', '-18 years')->format('Y-m-d'),
            'address' => $this->faker->address(),
            'phone' => '+244 9'.$this->faker->numerify('########'),
            'photo_path' => null,
        ];
    }
}
