<?php

namespace App\Widgets\Components;

use App\Contracts\Widgets\WidgetGroup;
use App\Contracts\Widgets\WidgetType;
use Illuminate\Support\Collection;

class GroupComponent implements WidgetGroup
{
    public function __construct(public string $name, public array $types, public array $config = [])
    {
    }

    public function getTypes(): Collection
    {
        return collect($this->types);
    }

    public function getConfig(): array
    {
        return [
            'name' => $this->name,
            'types' => $this->getTypes()->map(fn(WidgetType $type) => $type->getConfig()),
            'config' => $this->config,
        ];
    }
}
