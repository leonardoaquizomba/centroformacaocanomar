<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Notícias',          'slug' => 'noticias'],
            ['name' => 'Dicas de Carreira', 'slug' => 'dicas-carreira'],
            ['name' => 'Tecnologia',        'slug' => 'tecnologia'],
            ['name' => 'Eventos',           'slug' => 'eventos'],
        ];

        foreach ($categories as $category) {
            PostCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
