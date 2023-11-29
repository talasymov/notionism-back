<?php

namespace App\Services\Automation\NotionGoogleCalendarTwoWaySync;

use App\Exceptions\GoogleCalendarFailedCreateEvent;
use App\Exceptions\GoogleCalendarFailedDeleteEvent;
use App\Exceptions\GoogleCalendarFailedFindAllEvents;
use App\Exceptions\GoogleCalendarFailedUpdateEvent;
use App\Exceptions\NotionFailedCreatePage;
use App\Exceptions\NotionFailedDeletePage;
use App\Exceptions\NotionFailedFindAll;
use App\Exceptions\NotionFailedUpdatePage;
use App\Models\AutomationNotionGoogleCalendarPair;
use App\Models\UserAutomation;
use App\Services\Google\Events\Attendee;
use App\Services\Google\Events\EventData;
use App\Services\Google\GoogleClient;
use App\Services\Notion\Enums\PageParentEnum;
use App\Services\Notion\NotionClient;
use App\Services\Notion\Pages\PageData;
use App\Services\Notion\Pages\ParentPageData;
use App\Services\Notion\Pages\Properties\Date;
use App\Services\Notion\Pages\Properties\Email;
use App\Services\Notion\Pages\Properties\RichText;
use App\Services\Notion\Pages\Properties\Title;
use App\Services\Notion\Pages\Properties\Url;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class NotionGoogleCalendarTwoWaySyncService
{
    /**
     * @var EventData[]
     */
    private array $events;

    /**
     * @var PageData[]
     */
    private array $pages;

    private NotionClient $notion;

    private GoogleClient $google;

    private Collection $pairs;

    private bool $testMode = false;

    private array $logs = [];

    /**
     * @param UserAutomation $userAutomation
     */
    public function __construct(public UserAutomation $userAutomation)
    {
        if (empty($this->userAutomation->user->oAuthNotionToken) || empty($this->userAutomation->user->oAuthGoogleCalendarToken)) {
            throw new \LogicException('Tokens not exits');
        }

        $this->notion = new NotionClient($this->userAutomation->user->oAuthNotionToken);
        $this->google = new GoogleClient($this->userAutomation->user->oAuthGoogleCalendarToken);
    }

    /**
     * @throws GoogleCalendarFailedCreateEvent
     * @throws NotionFailedFindAll
     * @throws GoogleCalendarFailedUpdateEvent
     * @throws GoogleCalendarFailedDeleteEvent
     * @throws GoogleCalendarFailedFindAllEvents
     * @throws NotionFailedUpdatePage
     * @throws NotionFailedCreatePage
     * @throws NotionFailedDeletePage
     */
    public function handle(): void
    {
        $updatedAt = now();

        $this->pages = $this
            ->notion
            ->pages()
            ->findAll($this->userAutomation->config->getNotionDatabaseId(), [
                'page_size' => $this->testMode ? 1 : 100
            ]);

        $this->pages = collect($this->pages)->keyBy('id')->toArray();

        $this->events = $this
            ->google
            ->calendar($this->userAutomation->config->getCalendarName())
            ->events()
            ->findAll([
                'timeMin' => $this->userAutomation->created_at->startOfDay()->toRfc3339String()
            ]);

        $this->events = collect($this->events)->keyBy('id')->toArray();

        $this->pairs = AutomationNotionGoogleCalendarPair::query()
            ->select('page_id', 'event_id')
            ->where('user_automation_id', $this->userAutomation->id)
            ->get();

        $this->pairs
            ->each(function ($item) {
                $page = $this->pages[$item->page_id] ?? null;
                $event = $this->events[$item->event_id] ?? null;

                if (empty($page) && empty($event)) {
                    return $item->delete();
                } elseif (!empty($page) && !empty($event)) {
                    $this->updatePair($page, $event);
                } elseif (empty($page)) {
                    $this->deleteItem($event, $item);
                } elseif (empty($event)) {
                    $this->deleteItem($page, $item);
                }
            });

        $existsEventsInDb = $this->pairs->pluck('event_id')->toArray();
        $existsPagesInDb = $this->pairs->pluck('page_id')->toArray();

        $newEvents = array_filter(
            $this->events,
            fn(EventData $eventData) => !in_array($eventData->id, $existsEventsInDb)
        );

        $this->addNewEventsToNotion($newEvents);

        $newPages = array_filter(
            $this->pages,
            fn(PageData $pageData) => !in_array($pageData->id, $existsPagesInDb)
        );

        $this->addNewEventsToGoogle($newPages);

        $this->log('total pages: ' . count($this->pages));
        $this->log('total events: ' . count($this->events));

        if ($this->testMode) {
            return;
        }

        $this->userAutomation->update([
            'updated_at' => $updatedAt
        ]);
    }

    /**
     * @throws NotionFailedCreatePage
     */
    public function addNewEventsToNotion(array $events): void
    {
        if (empty($events)) {
            return;
        }

        foreach ($events as $event) {
            DB::beginTransaction();

            $pageData = new PageData();

            $pageData->setParent(
                new ParentPageData(PageParentEnum::Database, $this->userAutomation->config->getNotionDatabaseId())
            );

            $pageData->setProperties($this->mapEventProperties($event));

            $page = $this->notion->pages()->create($pageData);

            $this->saveToDatabase($page, $event);

            DB::commit();
        }

        $this->log('added to notion: ' . count($events));
    }

    /**
     * @throws GoogleCalendarFailedCreateEvent
     */
    public function addNewEventsToGoogle($pages): void
    {
        if (empty($pages)) {
            return;
        }

        foreach ($pages as $pageData) {
            DB::beginTransaction();

            $eventData = $this->google->calendar($this->userAutomation->config->getCalendarName())
                ->events()
                ->create($this->pageToEvent($pageData));

            $this->saveToDatabase($pageData, $eventData);

            DB::commit();
        }

        $this->log('added to google: ' . count($pages));
    }

    /**
     * @throws NotionFailedUpdatePage
     * @throws GoogleCalendarFailedUpdateEvent
     */
    public function updatePair(PageData $pageData, EventData $eventData): void
    {
        if (
            $pageData->getLastEditedTime() <= $this->userAutomation->updated_at &&
            $eventData->getUpdated() <= $this->userAutomation->updated_at
        ) {
            return;
        }

        if ($eventData->getUpdated() > $pageData->getLastEditedTime()) {
            $this->log('update page ' . $pageData->getId());
            $pageData->properties = $this->mapEventProperties($eventData);
            $this->notion->pages()->update($pageData);
        } else {
            $this->log('update event ' . $eventData->getSummary());
            $this->google->calendar($this->userAutomation->config->getCalendarName())
                ->events()->update($this->pageToEvent($pageData, $eventData));
        }
    }

    /**
     * @throws GoogleCalendarFailedDeleteEvent
     * @throws NotionFailedDeletePage
     */
    public function deleteItem(EventData|PageData $data, AutomationNotionGoogleCalendarPair $item): void
    {
        if ($data instanceof EventData) {
            $this->log('delete event ' . $data->getSummary());
            $this->google->calendar($this->userAutomation->config->getCalendarName())->events()->delete($data);
        } else {
            $this->log('delete page ' . $data->getId());
            $this->notion->pages()->delete($data);
        }
        $item->delete();
    }

    protected function mapEventProperties(EventData $event): array
    {
        $properties = [];

        foreach ($this->userAutomation->config->getMapping()->events as $notionProp => $googleProp) {
            $property = match ($googleProp) {
                'summary' => new Title($notionProp, $event->summary ?? 'Empty summary'),
                'date' => new Date(
                    $notionProp,
                    $event->start->dateTime ?? $event->start->date,
                    $event->end->dateTime ?? $event->end->date
                ),
                'creator' => new Email($notionProp, $event->creator->email),
                'location' => new Url($notionProp, $event->location),
                'description' => new RichText($notionProp, $event->description),
                'hangoutLink' => new Url($notionProp, $event->hangoutLink),
                'attendees' => new RichText(
                    $notionProp,
                    collect($event->attendees)
                        ->pluck('email')
                        ->implode(',')
                ),
                default => null
            };

            if (empty($property)) {
                continue;
            }

            $properties[] = $property;
        }

        return $properties;
    }

    protected function pageToEvent(PageData $pageData, ?EventData $eventData = null): EventData
    {
        $event = $eventData ?? new EventData();

        $properties = $pageData->getPropertiesByKey();

        foreach ($this->userAutomation->config->getMapping()->events as $notionProp => $googleProp) {
            switch ($googleProp) {
                case 'summary':
                    $event->setSummary($properties[$notionProp]->value);
                    break;
                case 'date':
                    $start = $properties[$notionProp]->start;
                    $end = $properties[$notionProp]->end;

                    $bothDate = $start->format('H:i:s') === '00:00:00' && $end->format('H:i:s') === '00:00:00';

                    if (!empty($start)) {
                        $event->setStart(
                            new \App\Services\Google\Events\Date(
                                $bothDate ? $start : null,
                                !$bothDate ? $start : null,
                                null
                            )
                        );
                    }

                    if (!empty($end)) {
                        $event->setEnd(
                            new \App\Services\Google\Events\Date(
                                $bothDate ? $end : null,
                                !$bothDate ? $end : null,
                                null
                            )
                        );
                    }
                    break;
                case 'location':
                    $event->setLocation($properties[$notionProp]->value);
                    break;
                case 'description':
                    $event->setDescription($properties[$notionProp]->value);
                    break;
                case 'creator':
                    $event->setCreator(
                        new \App\Services\Google\Events\User(
                            $properties[$notionProp]->value ?? $this->userAutomation->user->email,
                            null,
                            null
                        )
                    );
                    break;
                case 'hangoutLink':
                    $event->setHangoutLink($properties[$notionProp]->value);
                    break;
                case 'attendees':
                    $attendees = array_map('trim', array_filter(explode(',', $properties[$notionProp]->value)));
                    $event->setAttendees(array_map(fn($email) => new Attendee($email), $attendees));
                    break;
                default:
                    throw new \LogicException('Prop not available');
            };
        }

        return $event;
    }

    private function saveToDatabase(PageData $pageData, EventData $eventData): void
    {
        if ($this->testMode) {
            return;
        }

        AutomationNotionGoogleCalendarPair::query()
            ->updateOrCreate([
                'user_automation_id' => $this->userAutomation->id,
                'page_id' => $pageData->id,
                'event_id' => $eventData->id,
            ]);
    }

    public function enableTestMode(): void
    {
        $this->testMode = true;
    }

    private function log($message): void
    {
        $this->logs[] = $message;
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }
}
