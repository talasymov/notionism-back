<?php

namespace App\Services\Google\Events;

use Carbon\Carbon;

class EventData
{
    public string $id;

    public string $summary;

    public Date $start;

    public Date $end;

    public User $creator;

    public ?string $location;

    public ?string $description;

    public ?string $hangoutLink;

    public array $attendees;

    public Carbon $updated;

    public function toArray($except = []): array
    {
        $data = [];

        if (!empty($this->id)) {
            $data['id'] = $this->id;
        }

        if (!empty($this->summary)) {
            $data['summary'] = $this->summary;
        }

        if (!empty($this->start)) {
            $data['start'] = $this->start->toArray();
        }

        if (!empty($this->end)) {
            $data['end'] = $this->end->toArray();
        }

        if (!empty($this->creator)) {
            $data['creator'] = $this->creator->toArray();
        }

        if (!empty($this->location)) {
            $data['location'] = $this->location;
        }

        if (!empty($this->description)) {
            $data['description'] = $this->description;
        }

        if (!empty($this->hangoutLink)) {
            $data['hangoutLink'] = $this->hangoutLink;
        }

        if (!empty($this->attendees)) {
            $data['attendees'] = array_map(fn(Attendee $attendee) => $attendee->toArray(), $this->attendees);
        }

        if (!empty($this->updated)) {
            $data['updated'] = $this->updated->toIso8601String();
        }

        return collect($data)->except($except)->toArray();
    }

    public static function fromArray(array $event): self
    {
        $eventData = new self();

        $eventData->setId($event['id']);
        $eventData->setSummary($event['summary'] ?? 'Untitled');
        $eventData->setStart(
            new Date(
                !empty($event['start']['date'])
                    ? Carbon::parse($event['start']['date'])
                    : null,
                !empty($event['start']['dateTime'])
                    ? Carbon::parse($event['start']['dateTime'])
                    : null,
                $event['start']['timeZone'] ?? null,
            )
        );
        $eventData->setEnd(
            new Date(
                !empty($event['end']['date'])
                    ? Carbon::parse($event['end']['date'])
                    : null,
                !empty($event['end']['dateTime'])
                    ? Carbon::parse($event['end']['dateTime'])
                    : null,
                $event['end']['timeZone'] ?? null,
            )
        );
        $eventData->setCreator(
            new User(
                $event['creator']['email'],
                $event['creator']['displayName'] ?? null,
                $event['creator']['self'] ?? null,
            )
        );
        $eventData->setLocation($event['location'] ?? '');
        $eventData->setDescription($event['description'] ?? '');
        $eventData->setHangoutLink($event['hangoutLink'] ?? '');
        $eventData->setAttendees(
            array_map(function ($attendee) {
                return new Attendee(
                    $attendee['email'],
                    $attendee['self'] ?? null,
                    $attendee['organizer'] ?? null,
                    $attendee['responseStatus'] ?? null,
                );
            }, $event['attendees'] ?? [])
        );
        $eventData->setUpdated(Carbon::parse($event['updated']));

        return $eventData;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary(string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return Date
     */
    public function getStart(): Date
    {
        return $this->start;
    }

    /**
     * @param Date $start
     */
    public function setStart(Date $start): void
    {
        $this->start = $start;
    }

    /**
     * @return Date
     */
    public function getEnd(): Date
    {
        return $this->end;
    }

    /**
     * @param Date $end
     */
    public function setEnd(Date $end): void
    {
        $this->end = $end;
    }

    /**
     * @return User
     */
    public function getCreator(): User
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator(User $creator): void
    {
        $this->creator = $creator;
    }

    /**
     * @return ?string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param ?string $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param ?string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return ?string
     */
    public function getHangoutLink(): ?string
    {
        return $this->hangoutLink;
    }

    /**
     * @param ?string $hangoutLink
     */
    public function setHangoutLink(?string $hangoutLink): void
    {
        $this->hangoutLink = $hangoutLink;
    }

    /**
     * @return array
     */
    public function getAttendees(): array
    {
        return $this->attendees;
    }

    /**
     * @param array $attendees
     */
    public function setAttendees(array $attendees): void
    {
        $this->attendees = $attendees;
    }

    /**
     * @return Carbon
     */
    public function getUpdated(): Carbon
    {
        return $this->updated;
    }

    /**
     * @param Carbon $updated
     */
    public function setUpdated(Carbon $updated): void
    {
        $this->updated = $updated;
    }
}
