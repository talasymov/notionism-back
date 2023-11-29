<?php

namespace App\Services\Google\Events;

use App\Services\Google\Common\ResourceAbstract;
use Illuminate\Http\Client\Response;

class Event extends ResourceAbstract
{
//    public function create(string $calendarId, PageData $pageData): Calendar\Event
//    {
//        $calendar = new Calendar($this->client);
//
//        $event = new Calendar\Event();
//        $event->setSummary($pageData->properties['Name']->value);
//
//        $start = new EventDateTime();
//
//        if (!empty($pageData->properties['Date']->start)) {
//            $start->setDate($pageData->properties['Date']->start->toDateString());
//        }
//
//        $event->setStart($start);
//
//        $end = new EventDateTime();
//
//        if (!empty($pageData->properties['Date']->end)) {
//            $end->setDate($pageData->properties['Date']->end->toDateString());
//        }
//
//        $event->setEnd($end);
//
//        return $calendar->events->insert($calendarId, $event);
//    }
    public function create(EventData $eventData)
    {
        $this->client->post('ola', $eventData->toArray());
    }

    public function update(EventData $pageData): Response
    {
        return $this->client->post('events', $pageData->toArray());
    }

    public function delete(EventData $pageData): Response
    {
        return $this->client->post('events', $pageData->toArray());
    }
}
