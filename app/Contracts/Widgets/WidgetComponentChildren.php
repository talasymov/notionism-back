<?php

namespace App\Contracts\Widgets;

interface WidgetComponentChildren
{
    public function __construct(WidgetGroup ...$groups);
}
