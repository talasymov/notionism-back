<?php

namespace App\Services\NotionExport\Blocks;

use App\Services\NotionExport\Blocks\Helpers\RichTextHelper;
use App\Services\NotionExport\Contracts\IconInterface;
use App\Services\NotionExport\Contracts\RichTextInterface;

class Callout extends AbstractBlock implements RichTextInterface, IconInterface
{
    protected array $icon;

    public function render(): string
    {
        $content = RichTextHelper::handle($this->richText)
            ->implode('');

        return sprintf(
            '<div class="notion-callout"><div>%s</div><div>%s</div></div>',
            $this->getIcon()['emoji'],
            $content
        );
    }
}
