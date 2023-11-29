<?php

namespace App\Contracts\Widgets;

use Illuminate\Support\Collection;

interface WidgetGroup
{
    public function __construct(string $name, array $types, array $config = []);

    public function getTypes(): Collection;

    public function getConfig(): array;
}
