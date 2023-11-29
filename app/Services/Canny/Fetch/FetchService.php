<?php

namespace App\Services\Canny\Fetch;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;

class FetchService
{
    const ADMIN_USERS = [
        'vlad' => '61a69a012f70721143dab084',
        'illia' => '61bb7a651146687799a22812',
    ];

    const BOARDS = [
        'templates' => '63c292d27353c1652932edcc'
    ];

    public static function listPosts(): ?Collection
    {
        return self::fetch('posts/list');
    }

    public static function listBoards(): ?Collection
    {
        return self::fetch('boards/list');
    }

    public static function listTags(): ?Collection
    {
        return self::fetch('tags/list');
    }

    private static function fetch(string $path, array $config = []): ?Collection
    {
        $client = new Client();

        $options = [
            'query' => [
                'apiKey' => config('canny.apiKey'),
                'limit' => 1000,
                'status' => 'open,under review,planned,in progress,complete'
            ]
        ];

        if (isset($config['body'])) {
            $options[RequestOptions::JSON] = $config['body'];
        }

        $response = $client->request('POST', "https://canny.io/api/v1/" . $path, $options);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody(), true);

            return collect($data);
        }

        return null;
    }
}
