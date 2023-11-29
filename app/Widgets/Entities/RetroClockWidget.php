<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Types\Boolean;
use App\Widgets\Types\Color;
use App\Widgets\Types\Font;
use App\Widgets\Types\Number;
use App\Widgets\Types\Select;
use App\Widgets\WidgetAbstract;

class RetroClockWidget extends WidgetAbstract
{
    public function component(): WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Main', [
                    new Color('bg_color', 'Background Color', '#f56565'),
                    new Number('tiles_rounded', 'Rounded', 0),
                    new Number('border_size', 'Border Size', 0),
                    new Color('border_color', 'Border Color', 'red'),
                    new Boolean('show_seconds', 'Show Seconds', true),
                ]),
                new GroupComponent('Font', [
                    new Font('font', 'Font', 'default'),
                    new Color('font_color', 'Font Color', '#ffffff'),
                    new Number('font_size', 'Font Size', 50),
                ]),
                new GroupComponent('Divider', [
                    new Boolean('divider_display', 'Display', true),
                    new Color('divider_color', 'Color', '#ffffff'),
                    new Number('divider_size', 'Size', 2),
                ]),
                new GroupComponent('Format', [
                    new Boolean('time_format_display', 'Time Format Display', true),
                    new Select('time_format', 'Time Format', 24, [
                        'items' => [
                            ['id' => 12, 'name' => '12'],
                            ['id' => 24, 'name' => '24'],
                        ]
                    ]),
                    new Boolean('weekday_display', 'Weekday Display', true),
                    new Select('weekday_format', 'Weekday Format', 'short', [
                        'items' => [
                            ['id' => 'short', 'name' => 'short'],
                            ['id' => 'full', 'name' => 'full']
                        ]
                    ]),
                ]),
            ),
            new UXComponent()
        );
    }
}
