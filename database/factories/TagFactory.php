<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->jobTitle(),
            'slug' => str()->slug(fake()->unique()->jobTitle),
            'category_id' => fake()->numberBetween(1, 4),
            'notion_page_id' => fake()->password(32, 32),
            'icon' => fake()->emoji(),
        ];
    }
}
