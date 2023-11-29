<?php

namespace App\Widgets\Types;

class Icon extends TypeAbstract
{
    public function config(): array
    {
        return [
            'icons' => [
                'quote',
                'heart',
            ]
        ];
    }
}
