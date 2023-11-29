<?php

namespace App\Services\Forge;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;

class ForgeService
{
    public static function listCommandHistory(int $serverId, int $siteId): ?Collection
    {
        return self::fetch("servers/{$serverId}/sites/{$siteId}/commands", [
            'method' => 'GET'
        ]);
    }

    public static function executeCommand(int $serverId, int $siteId, string $command): ?Collection
    {
        return self::fetch("servers/{$serverId}/sites/{$siteId}/commands", [
            'body' => [
                'command' => $command
            ]
        ]);
    }

    private static function fetch(string $path, array $config = []): ?Collection
    {
        $client = new Client();

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('forge.API_TOKEN')
            ]
        ];

        if (isset($config['body'])) {
            $options[RequestOptions::JSON] = $config['body'];
        }

        $response = $client->request(
            data_get($config, 'method', 'POST'),
            "https://forge.laravel.com/api/v1/" . $path,
            $options
        );

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody(), true);

            return collect($data);
        }

        return null;
    }
}
