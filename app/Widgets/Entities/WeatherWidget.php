<?php

namespace App\Widgets\Entities;

use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Types\Boolean;
use App\Widgets\Types\Color;
use App\Widgets\Types\Location;
use App\Widgets\Types\Select;
use App\Widgets\WidgetAbstract;

class WeatherWidget extends WidgetAbstract
{

    public function component(): WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Weather Settings', [
                    new Location('location', 'Location', ['latitude' => 0, 'longitude' => 0, 'city' => 'default']),
                    new Select('windspeed_unit', 'Wind speed unit', '', [
                        'items' => [
                            ['name' => 'km/h', 'id' => ''],
                            ['name' => 'Mph', 'id' => 'mph'],
                            ['name' => 'm/s', 'id' => 'ms'],
                            ['name' => 'Knots', 'id' => 'kn'],
                        ]
                    ]),
                    new Select('temperature_unit', 'Temperature unit', '', [
                        'items' => [
                            ['name' => 'Celsius °C', 'id' => ''],
                            ['name' => 'Fahrenheit °F', 'id' => 'fahrenheit'],
                        ]
                    ]),
                ]),
                new GroupComponent('Visual Settings', [
                    new Boolean('is_icons_flat', 'Flat-color icons', false),
                    new Boolean('is_mini_variant', 'Compact widget variant', false),
                    new Color('background_color', 'Background color', 'rgba(255,255,255,1)'),
                    new Color('font_color', 'Font color', 'rgba(0,0,0,1)'),
                    new Color('border_color', 'Border color', 'rgba(155,155,155,0.25)'),
                    new Color('icon_color', 'Icon color', 'rgba(255,255,255,0.25)'),
                ])
            ),
            new UXComponent(),
        );
    }
}
