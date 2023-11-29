<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kit>
 */
class KitFactory extends Factory
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
            'subheader' => fake()->jobTitle(),
            'desc' => fake()->jobTitle(),
            'slug' => str(fake()->unique()->jobTitle())->slug(),
            'preview' => fake()->imageUrl(),
            'responsive_images' => [
                [
                    'path' => fake()->imageUrl(),
                    'device' => 'desktop',
                ],
                [
                    'path' => fake()->imageUrl(),
                    'device' => 'mobile',
                ],
            ],
            'price' => fake()->randomNumber(2),
            'prev_price' => fake()->randomNumber(2),
            'link' => fake()->url(),
            'notion_page_id' => fake()->password(32, 32),
            'user_id' => 1,
            'status' => 'publish'
        ];
    }
}
