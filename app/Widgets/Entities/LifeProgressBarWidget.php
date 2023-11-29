<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Types\Boolean;
use App\Widgets\Types\Color;
use App\Widgets\Types\DatePicker;
use App\Widgets\Types\Font;
use App\Widgets\Types\Number;
use App\Widgets\Types\Select;
use App\Widgets\WidgetAbstract;

class LifeProgressBarWidget extends WidgetAbstract
{
    public function component(): WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Common', [
                    new Color('bg_color', 'Background', '#ffffff'),
                    new Number('bg_padding', 'Padding', 4),
                    new Number('bg_rounded', 'Rounded', 0),
                    new Color('bg_border_color', 'Border Color', '#f2f2f2'),
                    new Number('bg_border_size', 'Border Size', 2),
                ]),
                new GroupComponent('Life', [
                    new DatePicker('birthday', 'Date of Birth', '1970-01-01'),
                    new Number('life_expectancy', 'Life expectancy', 70)
                ]),
                new GroupComponent('Components', [
                    new Boolean('life_bar', 'Life', true),
                    new Boolean('year_bar', 'Year', true),
                    new Boolean('quarter_bar', 'Quarter', true),
                    new Boolean('month_bar', 'Month', true),
                    new Boolean('week_bar', 'Week', true),
                    new Boolean('day_bar', 'Day', true),
                ]),
                new GroupComponent('Progress Bar', [
                    new Number('bar_height', 'Height', 22),
                    new Number('bar_width', 'Width', 100),
                    new Number('bar_rounded', 'Rounded', 0),
                    new Number('bar_border_size', 'Border Size', 0),
                    new Color('bar_border_color', 'Border Color', '#333333'),
                    new Color('bar_color', 'Filled Color', '#f56565'),
                    new Color('bar_bg_color', 'Background Color', '#f7fafc'),
                ]),
                new GroupComponent('Font', [
                    new Font('font_family', 'Family', 'default'),
                    new Number('font_size', 'Size', 14),
                    new Color('font_color', 'Color', '#4a5568'),
                    new Select('bar_label_position', 'Position', 'right', [
                        'items' => [
                            ['id' => 'none', 'name' => 'None'],
                            ['id' => 'left', 'name' => 'Left'],
                            ['id' => 'center', 'name' => 'Center'],
                            ['id' => 'right', 'name' => 'Right'],
                        ]
                    ]),
                    new Select('bar_label_format', 'Format', 'percent', [
                        'items' => [
                            ['id' => 'none', 'name' => 'None'],
                            ['id' => 'minimal', 'name' => 'Minimal'],
                            ['id' => 'percent', 'name' => 'Percent'],
                        ]
                    ]),
                ]),
            ),
            new UXComponent(),
        );
    }
}
