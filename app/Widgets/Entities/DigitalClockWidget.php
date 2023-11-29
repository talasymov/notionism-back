<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Types\Boolean;
use App\Widgets\Types\Color;
use App\Widgets\Types\Number;
use App\Widgets\WidgetAbstract;

class DigitalClockWidget extends WidgetAbstract
{
    public function component(): WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Time', [
                    new Boolean('is_show_seconds', 'Show Seconds', true),
                    new Boolean('is_show_additional_info', 'Show additional info', true),
                    new Boolean('is_full_day_name', 'Show full day name', true),
                    new Boolean('is_24_time_format', '24-h format', false),
                    // new Select('date_format', 'Day Format', 'default'),
                ]),
                new GroupComponent('Visual', [
                    new Color('bg', 'Background Color', 'rgba(255,255,255,1)'),
                    new Number('border_size', 'Border Size', 2),
                    new Color('border_color', 'Border Color', 'rgba(155,155,155,0.3)'),
                    new Color('text_color', 'Text Color', 'rgba(0,0,0,1)'),
                    new Color('active_segments_color', 'Active Segments Color', 'rgba(0,0,0,1)'),
                    new Color('disabled_segments_color', 'Disabled Segments Color', 'rgba(155,155,155,0.3)'),
                    new Number('rounded', 'Rounded', 4),
                    new Number('padding', 'Padding', 8),
                ]),
            ),
            new UXComponent()
        );
    }
}
