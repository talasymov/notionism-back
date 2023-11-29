<?php

namespace App\Contracts\Widgets;

use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;

interface WidgetComponent
{
    public function __construct(UIComponent $UIComponent, UXComponent $UXComponent);

    public function getConfig(): array;
}
