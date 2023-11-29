<?php

namespace App\Services\NotionExport\Blocks;

use App\Services\NotionExport\Blocks\Helpers\RichTextHelper;
use App\Services\NotionExport\Contracts\RichTextInterface;

class Code extends AbstractBlock implements RichTextInterface
{
    public function render(): string
    {
        $content = RichTextHelper::handle($this->getRichText())
            ->implode('');

        return sprintf('<pre class="notion-code"><code>%s</code></pre>', $content);
    }
}
