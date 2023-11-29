<?php

namespace App\Services\Google\Common;

use App\Models\OAuthToken;
use App\Services\Google\Contracts\ClientInterface;
use App\Services\Google\GoogleClient;
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
        $response = $this->getRequest()
            ->post(GoogleClient::API_ENDPOINT . $url, $data);

        if ($response->unauthorized()) {
            $this->tryAuthorize();
            return $this->post(GoogleClient::API_ENDPOINT . $url, $data);
        }

        return $response;
    }

    public function get(string $url): Response
    {
        $response = $this->getRequest()
            ->get(GoogleClient::API_ENDPOINT . $url);

        if ($response->unauthorized()) {
            $this->tryAuthorize();
            return $this->get($url);
        }

        return $response;
    }

    public function patch(string $url, $data = []): Response
    {
        $response = $this->getRequest()
            ->patch(GoogleClient::API_ENDPOINT . $url, $data);

        if ($response->unauthorized()) {
            $this->tryAuthorize();
            return $this->patch(GoogleClient::API_ENDPOINT . $url, $data);
        }

        return $response;
    }

    public function delete(string $url): Response
    {
        $response = $this->getRequest()
            ->delete(GoogleClient::API_ENDPOINT . $url);

        if ($response->unauthorized()) {
            $this->tryAuthorize();
            return $this->delete(GoogleClient::API_ENDPOINT . $url);
        }

        return $response;
    }

    public function put(string $url, $data = []): Response
    {
        $response = $this->getRequest()
            ->put(GoogleClient::API_ENDPOINT . $url, $data);

        if ($response->unauthorized()) {
            $this->tryAuthorize();
            return $this->put(GoogleClient::API_ENDPOINT . $url, $data);
        }

        return $response;
    }

    public function getRequest(): PendingRequest
    {
        return Http::withToken($this->token->token);
    }

    private function tryAuthorize(): void
    {
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => $this->token->refresh_token,
            'grant_type' => 'refresh_token'
        ]);

        $this->token->token = $response->json('access_token');

        $this->token->save();
    }
}
