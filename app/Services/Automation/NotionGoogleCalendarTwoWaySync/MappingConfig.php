<?php

namespace App\Services\Automation\NotionGoogleCalendarTwoWaySync;

class MappingConfig
{
    /**
     * @param array $events
     * @param array $attendees
     */
    public function __construct(
        public array $events,
        public array $attendees = [],
    ) {
        $this->events = array_filter($this->events, fn($value) => $value !== 'None');
    }
}
