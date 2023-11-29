<?php

namespace App\Services\Notion\Pages\Properties;

use App\Services\Notion\Contracts\PropertyInterface;

class Title implements PropertyInterface
{
    public function __construct(
        public string $key,
        public string $value
    ) {
    }

    public function toArray(): array
    {
        return [
            $this->key => [
                'title' => [
                    [
                        'text' => [
                            'content' => $this->value,
                        ],
                    ]
                ]
            ]
        ];
    }
}
