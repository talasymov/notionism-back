<?php

namespace App\Services\Notion\Enums;

enum PageParentEnum: string
{
    case Database = 'database_id';
    case Page = 'page_id';
    case Workspace = 'workspace';
}
