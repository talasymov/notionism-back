<?php

namespace App\Services\Google\Calendar;

use App\Exceptions\GoogleCalendarFailedCreateEvent;
use App\Exceptions\GoogleCalendarFailedDeleteEvent;
use App\Exceptions\GoogleCalendarFailedFindAllEvents;
use App\Exceptions\GoogleCalendarFailedUpdateEvent;
use App\Services\Google\Events\EventData;
use Illuminate\Http\Client\Response;

class Events
{
    public function __construct(protected Calendar $calendar)
    {
    }

    /**
     * @throws GoogleCalendarFailedCreateEvent
     */
    public function create(EventData $eventData): EventData
    {
        $response = $this->calendar->client->post(
            'calendar/v3/calendars/' . $this->calendar->id . '/events',
            $eventData->toArray()
        );

        if ($response->failed()) {
            throw new GoogleCalendarFailedCreateEvent($response->body());
        }

        return EventData::fromArray($response->json());
    }

    public function update(EventData $eventData): EventData
    {
        $response = $this->calendar->client->patch(
            'calendar/v3/calendars/' . $this->calendar->id . '/events/' . $eventData->id,
            $eventData->toArray(['id', 'updated'])
        );

        if ($response->failed()) {
            throw new GoogleCalendarFailedUpdateEvent($response->body());
        }

        return EventData::fromArray($response->json());
    }

    public function delete(EventData $eventData): Response
    {
        $response = $this->calendar->client->delete(
            'calendar/v3/calendars/' . $this->calendar->id . '/events/' . $eventData->id
        );

        if ($response->failed()) {
            throw new GoogleCalendarFailedDeleteEvent($response->body());
        }

        return $response;
    }

    /**
     * @return EventData[]
     * @throws GoogleCalendarFailedFindAllEvents
     */
    public function findAll(array $data = []): array
    {
        $query = $data ? '?' . http_build_query($data) : '';

        $response = $this->calendar->client->get('calendar/v3/calendars/' . $this->calendar->id . '/events' . $query);

        if ($response->failed()) {
            throw new GoogleCalendarFailedFindAllEvents();
        }

        return array_map(fn($event) => EventData::fromArray($event), $response->json('items'));
    }
}
