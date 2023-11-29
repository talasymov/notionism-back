<?php

namespace App\Enums;

enum Widget: string
{
    case Pomodoro = 'pomodoro';

    case Weather = 'weather';

    case Calendar = 'calendar';

    case AnalogClock = 'analog_clock';

    case RetroClock = 'retro_clock';

    case Countdown = 'countdown';

    case Quotes = 'quotes';

    case WaterTracker = 'water_tracker';

    case LifeProgressBar = 'life_progress_bar';

    case PasswordGenerator = 'password_generator';

    case DigitalClock = 'digital_clock';

    public function category(): WidgetCategory
    {
        return match ($this) {
            self::Pomodoro, self::Countdown => WidgetCategory::Countdown,
            self::AnalogClock, self::RetroClock, self::DigitalClock => WidgetCategory::Clock,
            self::Weather => WidgetCategory::Weather,
            self::Calendar => WidgetCategory::Calendar,
            self::Quotes => WidgetCategory::Quote,
            self::WaterTracker => WidgetCategory::Tracker,
            self::LifeProgressBar => WidgetCategory::Progress,
            self::PasswordGenerator => WidgetCategory::Generator,
        };
    }
}
