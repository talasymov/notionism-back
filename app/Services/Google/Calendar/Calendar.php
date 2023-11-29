<?php

namespace App\Services\Google\Calendar;

use App\Services\Google\Contracts\ClientInterface;

class Calendar
{
    public function __construct(public ClientInterface $client, public string $id)
    {
    }

    public function events(): Events
    {
        return new Events($this);
    }
}
