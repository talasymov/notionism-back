<?php

namespace App\Services\NotionExport\Blocks;

use App\Services\NotionExport\Blocks\Helpers\RichTextHelper;
use App\Services\NotionExport\Contracts\RichTextInterface;
use App\Services\NotionExport\Fetch\FetchService;
use App\Services\NotionExport\Page;

abstract class BaseHeading extends AbstractBlock implements RichTextInterface
{
    protected int $headingType = 1;

    public function render(): string
    {
        $content = RichTextHelper::handle(collect($this->getRichText()))
            ->implode('');

        $header = sprintf(
            '<h%d id="%s" class="notion-heading">%s</h%d>',
            $this->headingType,
            $this->getPlainTextSlug(),
            $content,
            $this->headingType
        );

        if ($this->hasChildren) {
            $page = new Page();

            $blocks = FetchService::blocks($this->id);

            foreach ($blocks['data'] as $item) {
                try {
                    $page->pushBlock(Block::make($item));
                } catch (\LogicException) {
                }
            }

            return sprintf(
                '
<div class="notion-heading-toggle">
<details>
  <summary>%s</summary>
  <div>%s</div>
</details>
</div>
',
                $header,
                $page->render()->implode('')
            );
        }

        return $header;
    }
}
