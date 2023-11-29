<?php

namespace Database\Factories;

use App\Models\Kit;
use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KitTemplate>
 */
class KitTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'template_id' => Template::query()->inRandomOrder()->value('id'),
            'kit_id' => Kit::query()->inRandomOrder()->value('id'),
        ];
    }
}
