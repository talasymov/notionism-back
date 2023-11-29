<?php

namespace App\Widgets\Components;

class WidgetComponent implements \App\Contracts\Widgets\WidgetComponent
{
    public function __construct(
        public UIComponent $UIComponent,
        public UXComponent $UXComponent
    ) {
    }

    public function getConfig(): array
    {
        return [
            'ui' => $this->UIComponent->getConfig(),
            'ux' => $this->UXComponent->getConfig(),
        ];
    }
}
