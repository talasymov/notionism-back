<?php

namespace App\Services\Notion\Pages\Properties;

use App\Services\Notion\Contracts\PropertyInterface;
use Carbon\Carbon;

class Date implements PropertyInterface
{
    /**
     * @param string $key
     * @param Carbon|null $start
     * @param Carbon|null $end
     */
    public function __construct(
        public string $key,
        public Carbon|null $start = null,
        public Carbon|null $end = null
    ) {
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->start) {
            $data['start'] = $this->start->toIso8601String();
        }

        if ($this->end) {
            $data['end'] = $this->end->toIso8601String();
        }

        return [
            $this->key => [
                'date' => $data
            ]
        ];
    }
}
