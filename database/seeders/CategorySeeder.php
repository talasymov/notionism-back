<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::query()->insert([
            ['id' => Category::CAT_FIELD, 'name' => 'Field', 'slug' => 'field'],
            ['id' => Category::CAT_CASE, 'name' => 'Case', 'slug' => 'case'],
            ['id' => Category::CAT_BOOK, 'name' => 'Book', 'slug' => 'book'],
            ['id' => Category::CAT_LOOK, 'name' => 'Look', 'slug' => 'look'],
        ]);
    }
}
