<?php

namespace App\Widgets\Types;

class Font extends TypeAbstract
{
    public function config(): array
    {
        return [
            'fonts' => [
                'default',
                'Naomi',
            ]
        ];
    }
}
