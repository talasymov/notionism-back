<?php

namespace App\Widgets\Entities;

use App\Models\Quote;
use App\Widgets\Components\GroupComponent;
use App\Widgets\Components\UIComponent;
use App\Widgets\Components\UXComponent;
use App\Widgets\Components\WidgetComponent;
use App\Widgets\Types\Color;
use App\Widgets\Types\Font;
use App\Widgets\Types\NotionDatabase;
use App\Widgets\Types\Number;
use App\Widgets\Types\Select;
use App\Widgets\WidgetAbstract;

class QuotesWidget extends WidgetAbstract
{
    public function component(): \App\Contracts\Widgets\WidgetComponent
    {
        return new WidgetComponent(
            new UIComponent(
                new GroupComponent('Main', [
                    new Color('bg', 'Background Color', 'white'),
                    new Number('border_size', 'Border Size', 4),
                    new Color('border_color', 'Border Color', 'rgba(155,155,155,0.5)'),
                    new Number('rounded', 'Rounded', 0),
                    new Number('padding', 'Padding', 8),
                    new Select('update_frequency', 'Update Frequency', 'hourly', [
                        'items' => [
                            ['name' => 'Hourly', 'id' => 'hourly'],
                            ['name' => '6 Hours', 'id' => '6_hours'],
                            ['name' => 'Daily', 'id' => 'Daily'],
                        ]
                    ]),
                    new NotionDatabase('notion_database', 'Notion Database', null),
                ]),
                new GroupComponent('Quote', [
                    new Color('quote_color', 'Quote Color', 'black'),
                    new Font('quote_font', 'Quote Font', 'sans-serif'),
                    new Number('quote_font_size', 'Quote Font Size', 19),
                ]),
                new GroupComponent('Author', [
                    new Color('author_color', 'Author Color', 'rgba(155,155,155,0.5)'),
                    new Font('author_font', 'Author Font', 'sans-serif'),
                    new Number('author_font_size', 'Author Font Size', 16),
                ]),
            ),
            new UXComponent()
        );
    }


    public function getEmbedData(array $config): array
    {
        $randomQuote = Quote::query()
            ->select('quote', 'author')
            ->find(random_int(1, 500));

//        $client = new NotionClient(auth()->user()->oAuthNotionToken()->first());
//
//        $props = $client->pages()->findAll($config['notion_database'])[0]?->getPropertiesByKey();
//
//        $randomQuote = [
//            'quote' => $props['Quote']->value ?? 'Quote not found',
//            'author' => $props['Author']->value ?? 'Author not found',
//        ];

        return [
            'quote' => $randomQuote
        ];
    }
}
