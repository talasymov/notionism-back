<?php

namespace App\Services\Notion\Pages;

use App\Services\Notion\Enums\PageParentEnum;

class ParentPageData
{
    public function __construct(
        public PageParentEnum $type,
        public string|null $id,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            PageParentEnum::from($data['type']),
            $data[$data['type']]
        );
    }

    public function toArray(): array
    {
        if ($this->type === PageParentEnum::Workspace) {
            return [
                $this->type->value => true
            ];
        }

        return [
            $this->type->value => $this->id
        ];
    }
}
