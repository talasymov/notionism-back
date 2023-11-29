<?php

namespace Database\Seeders;

use App\Models\OAuthService;
use Illuminate\Database\Seeder;

class OAuthServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OAuthService::query()->create(['name' => 'Google Auth', 'codename' => 'google-auth']);
        OAuthService::query()->create(['name' => 'Google Calendar', 'codename' => 'google-calendar']);
        OAuthService::query()->create(['name' => 'Notion', 'codename' => 'notion']);
    }
}
