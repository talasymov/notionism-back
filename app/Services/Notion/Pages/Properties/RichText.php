<?php

namespace App\Services\Notion\Pages\Properties;

use App\Services\Notion\Contracts\PropertyInterface;

class RichText implements PropertyInterface
{
    /**
     * @param string $key
     * @param ?string $value
     */
    public function __construct(
        public string $key,
        public ?string $value
    ) {
    }

    public function toArray(): array
    {
        return [
            $this->key => [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => $this->value,
                            'link' => null
                        ],
                        'annotations' => [
                            'bold' => false,
                            'italic' => false,
                            'strikethrough' => false,
                            'underline' => false,
                            'code' => false,
                            'color' => 'default',
                        ],
                        'plain_text' => $this->value,
                        'href' => null
                    ]
                ]
            ]
        ];
    }

    public static function fromArray(string $key, array $value): self
    {
        return new self($key, collect($value)->pluck('text.content')->implode(' '));
    }
}
