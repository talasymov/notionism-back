<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Widget>
 */
class WidgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'desc' => fake()->name(),
            'preview' => fake()->imageUrl(),
            'subscribers_only' => fake()->boolean(),
            'widget_category_id' => random_int(1, 7),
        ];
    }
}
