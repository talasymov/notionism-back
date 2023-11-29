<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Types\Boolean;
use App\Widgets\Types\Color;
use App\Widgets\Types\DatePicker;
use App\Widgets\Types\Number;
use App\Widgets\WidgetAbstract;

class CountdownWidget extends WidgetAbstract
{
    public function component(): WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Common', [
                    new DatePicker('deadline', 'Deadline', now()->addMonths(6)->toDateTimeString()),
                    new Color('bg_color', 'Background', '#ffffff'),
                    new Number('bg_padding', 'Padding', 4),
                    new Number('bg_rounded', 'Rounded', 0),
                    new Color('bg_border_color', 'Border Color', '#f2f2f2'),
                    new Number('bg_border_size', 'Border Size', 2),
                ]),
                new GroupComponent('Components', [
                    new Boolean('show_days', 'Days', true),
                    new Boolean('show_hours', 'Hours', true),
                    new Boolean('show_minutes', 'Minutes', true),
                    new Boolean('show_seconds', 'Seconds', true),
                ]),
                new GroupComponent('Sizes', [
                    new Number('size_days', 'Days', 25),
                    new Number('size_label_days', 'Days Label', 14),
                    new Number('size_hours', 'Hours', 25),
                    new Number('size_label_hours', 'Hours Label', 14),
                    new Number('size_minutes', 'Minutes', 25),
                    new Number('size_label_minutes', 'Minutes Label', 14),
                    new Number('size_seconds', 'Seconds', 25),
                    new Number('size_label_seconds', 'Seconds Label', 14),
                ]),
                new GroupComponent('Colors', [
                    new Color('color_days', 'Days', '#000000'),
                    new Color('color_label_days', 'Days Label', '#000000'),
                    new Color('color_hours', 'Hours', '#000000'),
                    new Color('color_label_hours', 'Hours Label', '#000000'),
                    new Color('color_minutes', 'Minutes', '#000000'),
                    new Color('color_label_minutes', 'Minutes Label', '#000000'),
                    new Color('color_seconds', 'Seconds', '#000000'),
                    new Color('color_label_seconds', 'Seconds Label', '#000000'),
                ]),
            ),
            new UXComponent(),
        );
    }
}
