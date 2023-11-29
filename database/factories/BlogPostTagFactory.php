<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostTagFactory extends Factory
{
    public function definition()
    {
        return [
            'blog_post_id' => BlogPost::query()->inRandomOrder()->value('id'),
            'tag_id' => Tag::query()->inRandomOrder()->value('id'),
        ];
    }
}
