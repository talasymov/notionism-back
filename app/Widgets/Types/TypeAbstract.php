<?php

namespace App\Widgets\Types;

use App\Contracts\Widgets\WidgetType;

abstract class TypeAbstract implements WidgetType
{
    public function __construct(
        public string $key,
        public string $name,
        public mixed $default,
        public array $config = []
    ) {
    }

    public function getConfig(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'default' => $this->default,
            'type' => class_basename(static::class),
            'config' => $this->config(),
        ];
    }

    abstract public function config(): array;
}
