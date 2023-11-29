<?php

namespace App\Services\Google\Common;

class ResourceAbstract
{
    public function __construct(protected \Google\Client $client)
    {
    }
}
