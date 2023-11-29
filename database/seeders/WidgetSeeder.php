<?php

namespace Database\Seeders;

use App\Models\Widget;
use App\Models\WidgetCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class WidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = WidgetCategory::query()
            ->pluck('id', 'codename');

        foreach (\App\Enums\Widget::cases() as $case) {
            Widget::query()->create([
                'name' => Str::headline($case->name),
                'codename' => $case->value,
                'preview' => 'https://api.notionism.org/storage/template/6ecbd6938a2bcc74dd6696bd867f23e7.png',
                'title' => Str::headline($case->name),
                'slug' => Str::slug($case->name),
                'desc' => 'This text can be changes',
                'notion_page_id' => md5(Uuid::uuid4()),
                'status' => 'publish',
                'widget_category_id' => $categories[$case->category()->value],
            ]);
        }
    }
}
