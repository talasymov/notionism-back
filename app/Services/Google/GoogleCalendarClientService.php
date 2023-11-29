<?php

namespace App\Services\Google;

use App\Models\OAuthService;
use App\Models\OAuthToken;
use Google\Client;

class GoogleCalendarClientService
{
    public Client $client;

    public function __construct()
    {
        $service = OAuthService::getGoogleCalendar();

        $token = OAuthToken::query()
            ->where('user_id', auth()->id())
            ->where('o_auth_service_id', $service->id)
            ->first()
            ->token;

        $this->client = new Client();
        $this->client->setAccessToken($token);
    }
}
