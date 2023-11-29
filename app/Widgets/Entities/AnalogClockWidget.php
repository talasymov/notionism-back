<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Presets\ConfigPresets;
use App\Widgets\Types\Boolean;
use App\Widgets\Types\Color;
use App\Widgets\Types\Font;
use App\Widgets\Types\Number;
use App\Widgets\Types\Select;
use App\Widgets\WidgetAbstract;

class AnalogClockWidget extends WidgetAbstract
{
    public function component(): WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Main', [
                    new Color('bg_color', 'Background Color', '#ffffff'),
                    new Number('border_size', 'Border Size', 2),
                    new Color('border_color', 'Border Color', 'red'),
                    new Select('shadow', 'Shadow', 0, ConfigPresets::SHADOW),
                ]),
                new GroupComponent('Date', [
                    new Boolean('date_display', 'Display', true),
                    new Color('date_color', 'Color', 'grey'),
                    new Font('date_font', 'Font', 'default'),
                    new Number('date_size', 'Font Size', 10),
                ]),
                new GroupComponent('Hours', [
                    new Boolean('hours_display', 'Display', true),
                    new Color('hours_color', 'Color', 'grey'),
                    new Font('hours_font', 'Font', 'default'),
                    new Number('hours_size', 'Font Size', 15),
                ]),
                new GroupComponent('Dashes', [
                    new Boolean('dashes_display', 'Display', true),
                    new Color('dashes_color', 'Color', 'grey'),
                    new Number('dashes_padding', 'Padding', 0),
                ]),
                new GroupComponent('Arrows', [
                    new Color('hours_arrow_color', 'Hours Color', 'lightgrey'),
                    new Boolean('minutes_display', 'Minutes Display', true),
                    new Color('minutes_arrow_color', 'Minutes Color', 'grey'),
                    new Boolean('seconds_display', 'Seconds Display', true),
                    new Color('seconds_arrow_color', 'Seconds Color', 'red'),
                ]),
                new GroupComponent('Center Circle', [
                    new Number('center_circle_size', 'Size', 3),
                    new Color('center_circle_color', 'Color', 'white'),
                ]),
            ),
            new UXComponent()
        );
    }
}
