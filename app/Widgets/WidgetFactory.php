<?php

namespace App\Widgets;

use App\Contracts\Widgets\Widget;
use App\Enums\Widget as WidgetEnum;
use App\Widgets\Entities\AnalogClockWidget;
use App\Widgets\Entities\CalendarWidget;
use App\Widgets\Entities\CountdownWidget;
use App\Widgets\Entities\DigitalClockWidget;
use App\Widgets\Entities\LifeProgressBarWidget;
use App\Widgets\Entities\PasswordGeneratorWidget;
use App\Widgets\Entities\PomodoroWidget;
use App\Widgets\Entities\QuotesWidget;
use App\Widgets\Entities\RetroClockWidget;
use App\Widgets\Entities\WaterTrackerWidget;
use App\Widgets\Entities\WeatherWidget;

class WidgetFactory
{
    public static function fromEnum(WidgetEnum $widget): Widget
    {
        return match ($widget) {
            WidgetEnum::Pomodoro => new PomodoroWidget(),
            WidgetEnum::Quotes => new QuotesWidget(),
            WidgetEnum::AnalogClock => new AnalogClockWidget(),
            WidgetEnum::Weather => new WeatherWidget(),
            WidgetEnum::Calendar => new CalendarWidget(),
            WidgetEnum::RetroClock => new RetroClockWidget(),
            WidgetEnum::Countdown => new CountdownWidget(),
            WidgetEnum::WaterTracker => new WaterTrackerWidget(),
            WidgetEnum::LifeProgressBar => new LifeProgressBarWidget(),
            WidgetEnum::DigitalClock => new DigitalClockWidget(),
            WidgetEnum::PasswordGenerator => new PasswordGeneratorWidget(),
        };
    }
}
