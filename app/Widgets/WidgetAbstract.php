<?php

namespace App\Widgets;

use App\Contracts\Widgets\Widget;

abstract class WidgetAbstract implements Widget
{
    public function getConfig(): array
    {
        return $this->component()->getConfig();
    }

    public function getDefaultData(): array
    {
        $ui = $this->component()->getConfig()['ui'];
        $ux = $this->component()->getConfig()['ux'];

        $types = array_merge($ui, $ux);

        return collect($types)
            ->flatten(2)
            ->pluck('default', 'key')
            ->filter()
            ->toArray();
    }

    public function getEmbedData(array $config): array
    {
        return $config;
    }
}
