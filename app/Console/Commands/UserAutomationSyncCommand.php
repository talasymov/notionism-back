<?php

namespace App\Console\Commands;

use App\Models\UserAutomation;
use App\Services\Automation\NotionGoogleCalendarTwoWaySync\NotionGoogleCalendarTwoWaySyncService;
use Illuminate\Console\Command;

class UserAutomationSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_automation:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run user automation';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $item = UserAutomation::query()->with([
            'user' => fn($q) => $q->with(['oAuthGoogleCalendarToken', 'oAuthNotionToken'])
        ])
            ->readyForSync()
            ->first();

        if (empty($item)) {
            return self::SUCCESS;
        }

        (new NotionGoogleCalendarTwoWaySyncService($item))->handle();

        return self::SUCCESS;
    }
}
