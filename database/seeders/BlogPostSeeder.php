<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\BlogPostTag;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogPost::factory(10)->create();

        for ($i = 0; $i < 200; $i++) {
            try {
                BlogPostTag::factory()->create();
            } catch (QueryException $exception) {
                continue;
            }
        }
    }
}
