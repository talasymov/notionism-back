<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TemplateTag>
 */
class TemplateTagFactory extends Factory
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
            'tag_id' => Tag::query()->inRandomOrder()->value('id'),
        ];
    }
}
