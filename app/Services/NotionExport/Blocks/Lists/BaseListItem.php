<?php

namespace App\Services\NotionExport\Blocks\Lists;

use App\Services\NotionExport\Blocks\AbstractBlock;
use App\Services\NotionExport\Blocks\Helpers\RichTextHelper;
use App\Services\NotionExport\Contracts\RichTextInterface;

abstract class BaseListItem extends AbstractBlock implements RichTextInterface
{
    public function render(): string
    {
        $content = RichTextHelper::handle($this->getRichText())
            ->implode('');

        return sprintf('<li>%s</li>', $content);
    }
}
