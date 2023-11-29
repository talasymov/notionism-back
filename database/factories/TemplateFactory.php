<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->jobTitle(),
            'slug' => str(fake()->unique()->jobTitle())->slug(),
            'desc' => fake()->jobTitle(),
            'ver' => null,
            'dbs' => fake()->randomNumber(1),
            'props' => fake()->randomNumber(2),
            'pages' => fake()->randomNumber(1),
            'preview' => fake()->imageUrl(),
            'price' => fake()->randomNumber(2),
            'link' => fake()->url(),
            'notion_page_id' => fake()->password(32, 32),
            'user_id' => 1,
            'status' => 'publish'
        ];
    }
}
