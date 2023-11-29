<?php

namespace App\Services\NotionExport\Blocks;

use App\Services\NotionExport\Blocks\Helpers\RichTextHelper;
use App\Services\NotionExport\Contracts\RichTextInterface;

class Paragraph extends AbstractBlock implements RichTextInterface
{
    public function render(): string
    {
        $content = RichTextHelper::handle($this->getRichText())
            ->implode('');

        return sprintf('<div class="notion-paragraph"><p>%s</p></div>', $content);
    }
}
