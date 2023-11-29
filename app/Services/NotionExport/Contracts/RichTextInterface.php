<?php

namespace App\Services\NotionExport\Contracts;

use Illuminate\Support\Collection;

interface RichTextInterface
{
    public function getRichText(): Collection;
}
