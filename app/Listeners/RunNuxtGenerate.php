<?php

namespace App\Listeners;

use App\Events\ContentChanged;

class RunNuxtGenerate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ContentChanged $event
     * @return void
     */
    public function handle(ContentChanged $event): void
    {
//        ForgeService::executeCommand(620629, 1848565, 'npm run generate');
    }
}
