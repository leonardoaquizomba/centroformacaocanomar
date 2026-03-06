<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Tecnologia', 'slug' => 'tecnologia', 'description' => 'Cursos de tecnologia e informática.'],
            ['name' => 'Gestão', 'slug' => 'gestao', 'description' => 'Cursos de gestão e administração.'],
            ['name' => 'Saúde', 'slug' => 'saude', 'description' => 'Cursos na área da saúde.'],
            ['name' => 'Línguas', 'slug' => 'linguas', 'description' => 'Cursos de idiomas e comunicação.'],
            ['name' => 'Construção Civil', 'slug' => 'construcao-civil', 'description' => 'Cursos de construção e engenharia.'],
            ['name' => 'Artes e Design', 'slug' => 'artes-design', 'description' => 'Cursos de design gráfico e artes visuais.'],
        ];

        foreach ($categories as $category) {
            \App\Models\CourseCategory::firstOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, ['is_active' => true])
            );
        }
    }
}
