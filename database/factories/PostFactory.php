<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_category_id' => \App\Models\PostCategory::factory(),
            'user_id' => \App\Models\User::factory(),
            'title' => fake()->sentence(4),
            'slug' => fake()->unique()->slug(4),
            'excerpt' => fake()->sentence(15),
            'body' => fake()->paragraphs(3, true),
            'image' => null,
            'is_published' => true,
            'published_at' => now(),
        ];
    }
}
