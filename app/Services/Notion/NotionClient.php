<?php

namespace App\Services\Notion;

use App\Models\OAuthToken;
use App\Services\Notion\Common\Client;
use App\Services\Notion\Databases\Database;
use App\Services\Notion\Pages\Page;

class NotionClient
{
    public const API_ENDPOINT = 'https://api.notion.com/v1/';

    public const API_VERSION = '2022-06-28';

    public function __construct(protected OAuthToken $token)
    {
    }

    public function databases(): Database
    {
        return new Database(new Client($this->token));
    }

    public function pages(): Page
    {
        return new Page(new Client($this->token));
    }
}
