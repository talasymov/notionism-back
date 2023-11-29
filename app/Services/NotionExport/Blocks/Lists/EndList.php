<?php

namespace App\Services\NotionExport\Blocks\Lists;

use App\Services\NotionExport\Blocks\AbstractBlock;

class EndList extends AbstractBlock
{
    private string $tag;

    public function __construct(BaseListItem $block)
    {
        $config = [
            'type' => 'end_list',
            'end_list' => []
        ];

        $this->tag = $block instanceof BulletedListItem ? 'ol' : 'ul';

        parent::__construct($config);
    }

    public function render(): string
    {
        return sprintf('</%s>', $this->tag);
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }
}
