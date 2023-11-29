<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => fake()->jobTitle(),
            'slug' => str(fake()->unique()->jobTitle())->slug(),
            'desc' => fake()->jobTitle(),
            'likes' => fake()->randomNumber(1),
            'user_id' => 1,
            'preview' => fake()->imageUrl(),
            'notion_page_id' => fake()->url(),
            'status' => 'publish'
        ];
    }
}
