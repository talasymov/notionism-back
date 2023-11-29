<?php

namespace App\Services\Notion\Pages\Properties;

use App\Services\Notion\Contracts\PropertyInterface;

class Email implements PropertyInterface
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
        return [
            $this->key => [
                'email' => $this->value
            ]
        ];
    }

    public function fromArray(string $key, string $value): self
    {
        return new self($key, $value);
    }
}
