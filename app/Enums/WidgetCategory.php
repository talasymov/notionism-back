<?php

namespace App\Enums;

enum WidgetCategory: string
{
    case Weather = 'weather';
    case Calendar = 'calendar';
    case Clock = 'clock';
    case Countdown = 'countdown';
    case Quote = 'quote';
    case Tracker = 'tracker';
    case Progress = 'progress';

    case Generator = 'generator';
}
