<?php

namespace Database\Seeders;

use App\Models\WidgetCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WidgetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Enums\WidgetCategory::cases() as $case) {
            WidgetCategory::query()->create([
                'name' => Str::headline($case->name),
                'codename' => $case->value,
            ]);
        }
    }
}
