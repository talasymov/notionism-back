<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Types\Color;
use App\Widgets\Types\Number;
use App\Widgets\WidgetAbstract;

class PomodoroWidget extends WidgetAbstract
{
    public function component(): \App\Widgets\Components\WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Main', [
                    new Number('total_time', 'Total time (min)', 25),
                    new Number('stroke_width', 'Stroke Width', 1),
                    new Color('stroke_color', 'Stroke Color', '#f56565'),
                    new Color('time_color', 'Time Color', '#f56565'),
                    new Color('buttons_color', 'Buttons Color', '#f56565'),
                ]),
            ),
            new UXComponent()
        );
    }
}
