<?php

namespace App\Console\Commands\Services;

use App\Models\Category;
use App\Models\Tag;
use App\Services\NotionExport\Fetch\FetchService;
use Illuminate\Database\QueryException;

class SyncTagsService
{
    public function handle()
    {
        $tags = FetchService::databases(FetchService::DATABASE_TAGS, [
            'filter' => [
                'property' => 'Skip Sync',
                'checkbox' => [
                    'equals' => false
                ]
            ]
        ])['data'];

        collect($tags)
            ->each(function ($item) {
                $id = $item['properties']['ID']['formula']['string'];

                $tag = Tag::where('notion_page_id', $id)->first();

                if (empty($tag)) {
                    $tag = new Tag([
                        'name' => $item['properties']['Name']['title'][0]['plain_text'],
                        'icon' => $item['icon']['emoji'] ?? '',
                        'notion_page_id' => $id
                    ]);
                }

                $tag->category()->associate(
                    Category::firstOrCreate([
                        'name' => $item['properties']['Type']['select']['name']
                    ])
                );

                try {
                    $tag->save();
                } catch (QueryException $exception) {
                    dump($exception->getMessage());
                }
            });
    }
}
