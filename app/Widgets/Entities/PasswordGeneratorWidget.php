<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Types\Boolean;
use App\Widgets\Types\Color;
use App\Widgets\WidgetAbstract;

class PasswordGeneratorWidget extends WidgetAbstract
{
    public function component(): WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Visual', [
                    new Color('border_color', 'Stroke color', 'rgb(226, 232, 240)'),
                    new Color('text_color', 'Text color', 'rgb(25, 25, 25)'),
                    new Color('background_color', 'Background color', 'rgb(255,255,255)'),
                    new Color('password_strength_progress_bar_color', 'Password strength progress bar', 'rgb(0,168,120)'),
                    new Color('input_color', 'Color of control elements', '#00a878'),
                ]),
                new GroupComponent('Settings section', [
                    new Boolean('is_show_settings', 'Show settings', true),
                ]),
            ),
            new UXComponent()
        );
    }
}
