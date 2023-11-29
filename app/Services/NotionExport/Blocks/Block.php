<?php

namespace App\Services\NotionExport\Blocks;

use App\Services\NotionExport\Blocks\Headings\Heading1;
use App\Services\NotionExport\Blocks\Headings\Heading2;
use App\Services\NotionExport\Blocks\Headings\Heading3;
use App\Services\NotionExport\Blocks\Lists\BulletedListItem;
use App\Services\NotionExport\Blocks\Lists\NumberedListItem;
use App\Services\NotionExport\Contracts\BlockInterface;

class Block
{
    const ASSOCIATE = [
        'paragraph' => Paragraph::class,
        'heading_1' => Heading1::class,
        'heading_2' => Heading2::class,
        'heading_3' => Heading3::class,
        'numbered_list_item' => NumberedListItem::class,
        'bulleted_list_item' => BulletedListItem::class,
        'image' => Image::class,
        'video' => Video::class,
        'callout' => Callout::class,
        'table_of_contents' => TableOfContents::class,
        'code' => Code::class,
        'divider' => Divider::class,
        'child_database' => ChildDatabase::class,
        'column_list' => ColumnList::class,
        'column' => Column::class,
        'quote' => Quote::class,
    ];

    public static function make(array $config): BlockInterface
    {
        if (!key_exists($config['type'], self::ASSOCIATE)) {
            throw new \LogicException($config['type'] . ' type not associated');
        }

        return new (self::ASSOCIATE[$config['type']])($config);
    }
}
