<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\WidgetAbstract;

class WaterTrackerWidget extends WidgetAbstract
{
    public function component(): WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(),
            new UXComponent(),
        );
    }
}
