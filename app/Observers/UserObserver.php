<?php

namespace App\Observers;

use App\Models\User;
use App\Services\NotionExport\Fetch\FetchService as NotionFetchService;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public $afterCommit = true;

    public function created(User $user): void
    {
        if (!app()->environment('production')) {
            return;
        }

        try {
            NotionFetchService::createPage([
                'parent' => [
                    'type' => 'database_id',
                    'database_id' => NotionFetchService::DATABASE_USERS
                ],
                'properties' => [
                    'Name' => [
                        'title' => [
                            [
                                'text' => [
                                    'content' => $user->name,
                                ],
                            ],
                        ],
                    ],
                    'Email' => [
                        'email' => $user->email,
                    ],
                    'Source' => [
                        'select' => [
                            'name' => 'Website',
                        ],
                    ],
                ],
            ]);
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());
        }
    }
}
