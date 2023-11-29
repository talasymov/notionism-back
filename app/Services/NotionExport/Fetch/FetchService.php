<?php

namespace App\Services\NotionExport\Fetch;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;

class FetchService
{
    public const DATABASE_TEMPLATES = '92ee13f4920749aa99a57fe0214e4982';

    public const DATABASE_BLOG = 'f02d0fdc327f4c3fb457d5cb576f5cad';

    public const DATABASE_PROPERTIES = '65c1cb33e6254b1281e4556f6f2a99bc';

    public const DATABASE_TAGS = '837aedb86f634273827843039725df19';

    public const DATABASE_USERS = 'c0f97b876e2c4061979977634d2f3ff4';

    public static function page(string $pageId): Collection
    {
        $url = "https://api.notion.com/v1/pages/$pageId";

        return self::fetch($url, '');
    }

    public static function createPage(array $body): Collection
    {
        $url = "https://api.notion.com/v1/pages";

        return self::fetch($url, '', [
            'method' => 'POST',
            'body' => $body
        ]);
    }

    public static function updatePage(string $pageId, array $body): Collection
    {
        $url = "https://api.notion.com/v1/pages/$pageId";

        return self::fetch($url, '', [
            'method' => 'PATCH',
            'body' => $body
        ]);
    }

    public static function blocks(string $pageId, string $path = 'results', ?string $startCursor = null): Collection
    {
        $url = "https://api.notion.com/v1/blocks/$pageId/children".($startCursor ? '?start_cursor='.$startCursor : '');

        return self::fetch($url, $path);
    }

    public static function databases(string $pageId, array $filter = []): Collection
    {
        $url = "https://api.notion.com/v1/databases/$pageId/query";

        return self::fetch($url, 'results', ['method' => 'POST', 'body' => $filter]);
    }

    private static function fetch(string $url, string $path, array $config = ['method' => 'GET']): Collection
    {
        $client = new Client();

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Notion-Version' => config('notion.version'),
                'Authorization' => 'Bearer '.config('notion.token'),
            ]
        ];

        if (isset($config['body'])) {
            $options[RequestOptions::JSON] = $config['body'];
        }

        $blocks = $client->request($config['method'], $url, $options);

        $data = json_decode($blocks->getBody(), true);

        if ($blocks->getStatusCode() == 200) {
            return collect([
                'success' => true,
                'data' => empty($path) ? $data : data_get($data, $path),
            ]);
        }

        return collect([
            'success' => false,
            'data' => $data,
        ]);
    }
}
