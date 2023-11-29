<?php

namespace App\Services\NotionExport\Contracts;

interface BlockInterface
{
    public function render(): string;
}
