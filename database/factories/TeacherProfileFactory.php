<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeacherProfile>
 */
class TeacherProfileFactory extends Factory
{
    public function definition(): array
    {
        $specializations = [
            'Tecnologias de Informação', 'Desenvolvimento Web', 'Gestão de Empresas',
            'Língua Inglesa', 'Construção Civil', 'Artes e Design', 'Redes e Sistemas',
            'Contabilidade', 'Marketing Digital', 'Segurança Informática',
        ];

        return [
            'user_id' => User::factory(),
            'bio' => $this->faker->paragraph(3),
            'specialization' => $this->faker->randomElement($specializations),
            'phone' => '+244 9'.$this->faker->numerify('########'),
        ];
    }
}
