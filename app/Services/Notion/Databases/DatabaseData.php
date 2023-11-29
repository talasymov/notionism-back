<?php

namespace App\Services\Notion\Databases;

class DatabaseData
{
    public function __construct(
        public string|null $id = null,
        public string|null $title = null,
        public array|null $properties = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            collect($data['title'])->pluck('plain_text')->implode(' '),
            $data['properties']
        );
    }
}
