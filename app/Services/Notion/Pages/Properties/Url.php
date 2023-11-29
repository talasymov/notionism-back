<?php

namespace App\Services\Notion\Pages\Properties;

use App\Services\Notion\Contracts\PropertyInterface;

class Url implements PropertyInterface
{
    /**
     * @param string $key
     * @param string|null $value
     */
    public function __construct(
        public string $key,
        public string|null $value
    ) {
    }

    public function toArray(): array
    {
        if (empty($this->value)) {
            return [];
        }

        return [
            $this->key => [
                'url' => $this->value
            ]
        ];
    }
}
