<?php

namespace App\Http\Controllers\Api\Integrations\Automation;

use App\Models\Automation;
use App\Models\UserAutomation;
use App\Services\Automation\NotionGoogleCalendarTwoWaySync\MappingConfig;
use App\Services\Automation\NotionGoogleCalendarTwoWaySync\NotionGoogleCalendarTwoWaySyncService;
use App\Services\Automation\NotionGoogleCalendarTwoWaySync\SyncConfig;

class UserAutomationService
{

    public function getAutomationService(?UserAutomation $userAutomation)
    {
        $class = match (request('type')) {
            \App\Enums\Automation::GoogleCalendar->value => NotionGoogleCalendarTwoWaySyncService::class,
        };

        return new $class($userAutomation ?? $this->getUserAutomationInstance());
    }

    public function getUserAutomationInstance(): UserAutomation
    {
        $userAutomation = new UserAutomation();

        $config = (new SyncConfig())
            ->setNotionDatabaseIdFromUrl(request('config.database_url'))
            ->setCalendarName(request('config.calendar_name'))
            ->setMapping(new MappingConfig(request('config.mapping.events')));

        $userAutomation->name = request('name') ?? 'Untitled';
        $userAutomation->config = $config;
        $userAutomation->user_id = auth()->id();
        $userAutomation->created_at = now();
        $userAutomation->automation_id = Automation::where('codename', request('type'))->first()->id;

        return $userAutomation;
    }
}
