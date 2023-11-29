<?php

namespace App\Services\Google;

use App\Models\OAuthToken;
use App\Services\Google\Calendar\Calendar;
use App\Services\Google\Calendar\CalendarList;
use App\Services\Google\Common\Client;

class GoogleClient
{
    public const API_ENDPOINT = 'https://www.googleapis.com/';

    public function __construct(protected OAuthToken $token)
    {
    }

    public function calendar(string $id): Calendar
    {
        return new Calendar(new Client($this->token), $id);
    }

    public function calendarList(): CalendarList
    {
        return new CalendarList(new Client($this->token));
    }
}
