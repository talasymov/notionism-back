<?php

namespace App\Services\Google\Events;

use Carbon\Carbon;

class Date
{
    /**
     * @param Carbon|null $date
     * @param Carbon|null $dateTime
     * @param string|null $timeZone
     */
    public function __construct(
        public Carbon|null $date,
        public Carbon|null $dateTime,
        public string|null $timeZone,
    ) {
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->date) {
            $data['date'] = $this->date->toDateString();
        }

        if ($this->dateTime) {
            $data['dateTime'] = $this->dateTime->toRfc3339String();
        }

        if ($this->timeZone) {
            $data['timeZone'] = $this->timeZone;
        }

        return $data;
    }
}
