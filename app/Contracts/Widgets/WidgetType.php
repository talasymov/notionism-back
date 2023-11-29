<?php

namespace App\Contracts\Widgets;

interface WidgetType
{
    public function __construct(string $key, string $name, mixed $default, array $config = []);

    public function getConfig(): array;
}
