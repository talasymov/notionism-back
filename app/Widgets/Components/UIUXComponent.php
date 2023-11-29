<?php

namespace App\Widgets\Components;

use App\Contracts\Widgets\WidgetComponentChildren;
use App\Contracts\Widgets\WidgetGroup;
use Illuminate\Support\Collection;

class UIUXComponent implements WidgetComponentChildren
{
    private Collection $groups;

    public function __construct(WidgetGroup ...$groups)
    {
        $this->groups = collect($groups);
    }

    public function getConfig(): array
    {
        return $this->groups
            ->map(
                fn(WidgetGroup $group) => $group->getConfig()
            )
            ->toArray();
    }
}
