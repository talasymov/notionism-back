<?php

namespace App\Services\Google\Calendar;

use App\Services\Google\Contracts\ClientInterface;

class CalendarList
{
    public function __construct(public ClientInterface $client)
    {
    }

    public function list(array $data = []): array
    {
        $query = $data ? '?' . http_build_query($data) : '';

        $response = $this->client->get('calendar/v3/users/me/calendarList' . $query);

        return $response->json('items');
    }
}
