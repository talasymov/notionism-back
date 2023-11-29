<?php

namespace App\Services\Notion\Pages;

use Illuminate\Support\Collection;

class PageDataCollection
{
    /**
     * @param Collection<PageData> $pages
     */
    public function __construct(public Collection $pages)
    {
    }
}
