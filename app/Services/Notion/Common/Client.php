<?php

namespace App\Services\Notion\Common;

use App\Models\OAuthToken;
use App\Services\Notion\Contracts\ClientInterface;
use App\Services\Notion\NotionClient;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client implements ClientInterface
{
    public function __construct(protected OAuthToken $token)
    {
    }

    public function post(string $url, array $data): Response
    {
        return $this->getRequest()
            ->post(NotionClient::API_ENDPOINT . $url, $data);
    }

    public function get(string $url): Response
    {
        return $this->getRequest()
            ->get(NotionClient::API_ENDPOINT . $url);
    }

    public function patch(string $url, $data = []): Response
    {
        return $this->getRequest()
            ->patch(NotionClient::API_ENDPOINT . $url, $data);
    }

    public function put(string $url, $data = []): Response
    {
        return $this->getRequest()
            ->put(NotionClient::API_ENDPOINT . $url, $data);
    }

    public function getRequest(): PendingRequest
    {
        return Http::withToken($this->token->token)
            ->withHeaders([
                'Notion-Version' => NotionClient::API_VERSION
            ]);
    }
}
