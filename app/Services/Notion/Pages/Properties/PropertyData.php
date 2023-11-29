<?php

namespace App\Services\Notion\Pages\Properties;

use App\Services\Notion\Contracts\PropertyInterface;
use Carbon\Carbon;

class PropertyData
{
    public static function fromArray(string $key, array $data): PropertyInterface
    {
        return match ($data['type']) {
            'title', 'rich_text' => RichText::fromArray($key, $data[$data['type']]),
            'email' => new Email($key, $data['email']),
            'url' => new Url($key, $data['url']),
            'date' => new Date(
                $key,
                isset($data['date']['start']) ? Carbon::parse($data['date']['start']) : null,
                isset($data['date']['end']) ? Carbon::parse($data['date']['end']) : null
            ),
            default => throw new \LogicException('Unsupported type'),
        };
    }
}
