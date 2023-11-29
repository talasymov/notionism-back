<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Types\Boolean;
use App\Widgets\Types\Color;
use App\Widgets\Types\PureColor;
use App\Widgets\WidgetAbstract;

class CalendarWidget extends WidgetAbstract
{
    public function component(): WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Visual', [
                    new Boolean('is_dark','Dark theme', false),
                    new Boolean('today_button','Today button', false),
                    new Boolean('borderless','Borderless', false),
                    new Boolean('current_date','Current date', false),
                    new PureColor('theme_color','Theme color', 'blue'),
                    new Color('button_color','Button color', '#2563eb'),
                    new Color('border_color','Border color', 'rgba(155,155,155,0.25)'),
                ]),
            ),
            new UXComponent(),
        );
    }
}
