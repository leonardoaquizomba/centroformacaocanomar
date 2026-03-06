<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $techCategory = \App\Models\CourseCategory::where('slug', 'tecnologia')->first();
        $managementCategory = \App\Models\CourseCategory::where('slug', 'gestao')->first();

        $courses = [
            [
                'course_category_id' => $techCategory?->id ?? 1,
                'name' => 'Informática Básica',
                'slug' => 'informatica-basica',
                'description' => 'Introdução ao uso de computadores, sistemas operativos e aplicações de escritório.',
                'duration_hours' => 40,
                'modality' => 'presencial',
                'level' => 'básico',
                'price' => 15000,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'course_category_id' => $techCategory?->id ?? 1,
                'name' => 'Desenvolvimento Web',
                'slug' => 'desenvolvimento-web',
                'description' => 'Aprenda HTML, CSS e JavaScript para criar websites modernos e responsivos.',
                'duration_hours' => 120,
                'modality' => 'presencial',
                'level' => 'médio',
                'price' => 35000,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'course_category_id' => $managementCategory?->id ?? 2,
                'name' => 'Gestão de Empresas',
                'slug' => 'gestao-empresas',
                'description' => 'Fundamentos de administração, liderança e gestão estratégica de organizações.',
                'duration_hours' => 80,
                'modality' => 'presencial',
                'level' => 'médio',
                'price' => 25000,
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($courses as $course) {
            \App\Models\Course::firstOrCreate(['slug' => $course['slug']], $course);
        }
    }
}
