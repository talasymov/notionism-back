<?php

namespace App\Console\Commands;

use App\Console\Commands\Services\SyncTagsService;
use Illuminate\Console\Command;

class SyncTagsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync tags from notion';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(SyncTagsService $service)
    {
        $service->handle();

        return self::SUCCESS;
    }
}
