<?php

namespace App\Widgets\Types;

class Boolean extends TypeAbstract
{
    public function config(): array
    {
        return [
            'values' => [true, false]
        ];
    }
}
