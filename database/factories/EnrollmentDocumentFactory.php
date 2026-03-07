<?php

namespace Database\Factories;

use App\Enums\DocumentType;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnrollmentDocument>
 */
class EnrollmentDocumentFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->word().'.pdf';

        return [
            'enrollment_id' => Enrollment::factory(),
            'type' => DocumentType::Outro,
            'file_path' => 'documents/'.$name,
            'original_name' => $name,
            'mime_type' => 'application/pdf',
        ];
    }
}
