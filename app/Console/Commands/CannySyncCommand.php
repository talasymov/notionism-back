<?php

namespace App\Console\Commands;

use App\Services\Canny\CannyImportService;
use Illuminate\Console\Command;

class CannySyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canny:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync canny with notion';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        (new CannyImportService())->handle();

        return self::SUCCESS;
    }
}
