<?php

namespace Database\Seeders;

use App\Models\Automation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AutomationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Enums\Automation::cases() as $case) {
            Automation::query()->create([
                'name' => Str::headline($case->name),
                'codename' => $case->value,
                'preview' => 'https://api.notionism.org/storage/template/6ecbd6938a2bcc74dd6696bd867f23e7.png',
                'desc' => 'This text can be changes',
            ]);
        }
    }
}
