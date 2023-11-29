<?php

namespace App\Contracts\Widgets;

interface Widget
{
    public function component(): WidgetComponent;

    public function getConfig(): array;

    public function getDefaultData(): array;

    public function getEmbedData(array $config): array;
}
