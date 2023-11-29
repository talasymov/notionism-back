<?php

namespace App\Services\NotionExport\Blocks;

use App\Services\NotionExport\Blocks\Helpers\RichTextHelper;
use App\Services\NotionExport\Page;

class TableOfContents extends AbstractBlock
{
    public function render(): string
    {
        $content = Page::getInstance()->getHeaders()->map(function (BaseHeading $header) {
            $content = RichTextHelper::handle($header->getRichText())->implode('');
            return sprintf(
                '<a class="notion-heading %s" href="#%s">%s</a>',
                $header->type(),
                $header->getPlainTextSlug(),
                $content
            );
        })->implode('');

        return sprintf('<div class="notion-table-of-contents">%s</div>', $content);
    }
}
