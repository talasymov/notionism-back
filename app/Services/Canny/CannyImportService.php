<?php

namespace App\Services\Canny;

use App\Console\Commands\Services\SyncTagsService;
use App\Services\Canny\Fetch\FetchService as CannyFetchService;
use App\Services\NotionExport\Fetch\FetchService as NotionFetchService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CannyImportService
{
    public function handle(): void
    {
        $cannyTags = collect(CannyFetchService::listTags()['tags'])
            ->keyBy(fn($item) => trim(data_get($item, 'name')));

        $notionTags = $this->getNotionTags();

        $newCannyTags = $cannyTags->diffKeys($notionTags);

        if ($newCannyTags->isNotEmpty()) {
            $newCannyTags
                ->each(function ($tag) {
                    NotionFetchService::createPage([
                        'parent' => [
                            'type' => 'database_id',
                            'database_id' => NotionFetchService::DATABASE_TAGS
                        ],
                        'properties' => [
                            'Name' => [
                                'title' => [
                                    [
                                        'text' => [
                                            'content' => $tag['name']
                                        ]
                                    ]
                                ]
                            ],
                            'Type' => [
                                'select' => [
                                    'name' => 'Field'
                                ]
                            ]
                        ]
                    ]);
                });

            (new SyncTagsService())->handle();

            $notionTags = $this->getNotionTags();
        }

        $posts = collect(CannyFetchService::listPosts()['posts'])
            ->keyBy(fn($item) => trim(data_get($item, 'title')));

        $templates = collect(
            NotionFetchService::databases(NotionFetchService::DATABASE_TEMPLATES, [
                'filter' => [
                    'timestamp' => 'created_time',
                    'created_time' => [
                        'after' => '2022-01-01'
                    ]
                ],
                'page_size' => 1000
            ])['data']
        )
            ->keyBy(fn($item) => trim(data_get($item, 'properties.Name.title.0.plain_text')));

        /*
         * Update exists templates
         */
        $posts
            ->intersectByKeys($templates)
            ->each(
                fn($item, $key) => $this->updatePage($key, $item, $templates, $notionTags)
            );

        /*
         * Import new templates from canny
         */
        $posts
            ->diffKeys($templates)
            ->each(fn($item, $key) => NotionFetchService::createPage([
                'parent' => [
                    'type' => 'database_id',
                    'database_id' => NotionFetchService::DATABASE_TEMPLATES
                ],
                'properties' => [
                    'Name' => [
                        'title' => [
                            [
                                'text' => [
                                    'content' => $item['title']
                                ]
                            ]
                        ]
                    ],
                    'Score' => [
                        'number' => $item['score']
                    ],
                    'Stage' => [
                        'status' => [
                            'name' => ucfirst($item['status'])
                        ]
                    ],
                    'Tags' => [
                        'relation' => array_map(
                            fn($tag) => ['id' => $notionTags[$tag['name']]['id']],
                            $item['tags']
                        )
                    ]
                ]
            ]));
    }

    private function updatePage($key, $item, $templates, $notionTags): void
    {
        NotionFetchService::updatePage(
            $templates[$key]['id'],
            [
                'properties' => [
                    'Score' => [
                        'number' => $item['score']
                    ],
                    'Stage' => [
                        'status' => [
                            'name' => ucfirst($item['status'])
                        ]
                    ],
                    'Tags' => [
                        'relation' => array_merge(
                            array_map(fn($tag) => ['id' => $notionTags[$tag['name']]['id']], $item['tags']),
                            $templates[$key]['properties']['Tags']['relation']
                        )
                    ]
                ]
            ]
        );

        $publicPageId = NotionFetchService::page(
            $templates[$key]['id']
        )['data']['properties']['Public page']['relation'][0]['id'] ?? null;

        if (!empty($publicPageId)) {
            NotionFetchService::updatePage(
                $publicPageId,
                [
                    'properties' => [
                        'Feedback' => [
                            'url' => str_replace('/admin/board', '', $item['url'])
                        ]
                    ]
                ]
            );
        }
    }

    private function getNotionTags(): Collection
    {
        return Cache::remember('notion-tags', $this->getTtl(), function () {
            return collect(
                NotionFetchService::databases(NotionFetchService::DATABASE_TAGS, [
                    'filter' => [
                        'property' => 'Skip Sync',
                        'checkbox' => [
                            'equals' => false
                        ]
                    ],
                    'page_size' => 1000
                ])['data']
            );
        })
            ->keyBy(fn($item) => trim(data_get($item, 'properties.Name.title.0.plain_text')));
    }

    private function getTtl(): int
    {
        return app()->environment() === 'local' ? 600 : 1;
    }
}
