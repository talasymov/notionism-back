<?php

namespace App\Services\NotionExport\Blocks;

use App\Services\NotionExport\Fetch\FetchService;
use App\Services\NotionExport\Page;

class Column extends AbstractBlock
{
    public function render(): string
    {
        $page = new Page();

        $blocks = FetchService::blocks($this->id);

        foreach ($blocks['data'] as $item) {
            try {
                $page->pushBlock(Block::make($item));
            } catch (\LogicException) {
            }
        }

        return sprintf('<div class="notion-column">%s</div>', $page->render()->implode(''));
    }
}
