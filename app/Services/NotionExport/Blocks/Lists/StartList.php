<?php

namespace App\Services\NotionExport\Blocks\Lists;

use App\Services\NotionExport\Blocks\AbstractBlock;

class StartList extends AbstractBlock
{
    private string $tag;

    public function __construct(BaseListItem $block)
    {
        $config = [
            'type' => 'start_list',
            'start_list' => []
        ];

        $this->tag = $block instanceof BulletedListItem ? 'ol' : 'ul';

        parent::__construct($config);
    }

    public function render(): string
    {
        return sprintf('<%s class="notion-list">', $this->tag);
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }
}
