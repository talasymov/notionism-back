<?php

namespace App\Services\Notion\Common;

use App\Services\Notion\Contracts\ClientInterface;

class ResourceAbstract
{
    public function __construct(protected ClientInterface $client)
    {
    }
}
