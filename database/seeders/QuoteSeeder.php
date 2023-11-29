<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quotes = json_decode(file_get_contents(resource_path('json/quotes.json')), 1);

        $data = [];

        foreach ($quotes as $i => $quote) {
            $data[] = [
                'id' => $i + 1,
                'quote' => $quote['text'],
                'author' => $quote['author'] ?? 'Somebody',
            ];
        }

        Quote::query()->insert($data);
    }
}
