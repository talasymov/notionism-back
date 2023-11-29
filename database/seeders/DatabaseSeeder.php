<?php

namespace Database\Seeders;

use App\Models\Kit;
use App\Models\KitTemplate;
use App\Models\Tag;
use App\Models\Template;
use App\Models\TemplateTag;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            WidgetCategorySeeder::class,
        ]);

        if (app()->environment() === 'local') {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('testtest'),
            ]);

            Tag::factory(10)->create();
            Template::factory(100)->create();
            Kit::factory(10)->create();

            for ($i = 0; $i < 200; $i++) {
                try {
                    TemplateTag::factory()->create();
                } catch (QueryException $exception) {
                    continue;
                }
            }

            for ($i = 0; $i < 100; $i++) {
                try {
                    KitTemplate::factory()->create();
                } catch (QueryException $exception) {
                    continue;
                }
            }

            $this->call([
                BlogPostSeeder::class,
                QuoteSeeder::class,
                WidgetSeeder::class,
                OAuthServiceSeeder::class,
                AutomationSeeder::class,
            ]);
        }
    }
}
