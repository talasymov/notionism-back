<?php

namespace App\Widgets\Types;

class Color extends TypeAbstract
{
    public function config(): array
    {
        return [
            'groups' => [
                [
                    'group' => 'brown',
                    'colors' => [
                        '#111',
                        '#222',
                        '#333',
                    ],
                ],
            ],
        ];
    }
}
