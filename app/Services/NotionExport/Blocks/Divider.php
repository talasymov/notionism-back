<?php

namespace App\Services\NotionExport\Blocks;

class Divider extends AbstractBlock
{
    public function render(): string
    {
        return '<div class="notion-divider"></div>';
    }
}
