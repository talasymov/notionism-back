<?php

namespace Tests\Feature;

use Illuminate\Support\Collection;
use Tests\TestCase;

class NotionGoogleCalendarTwoWaySyncTest extends TestCase
{
    /**
     * @param Collection $events
     * @param Collection $pages
     * @return void
     * @dataProvider data
     */
    public function test_new_events_to_notion(Collection $events, Collection $pages): void
    {
        $actual = $events
            ->pluck('id')
            ->diff($pages->pluck('google-id'))
            ->values()
            ->toArray();

        $this->assertEquals(['3-event-id'], $actual);
    }

    /**
     * @param Collection $events
     * @param Collection $pages
     * @return void
     * @dataProvider data
     */
    public function test_update_events_in_notion(Collection $events, Collection $pages): void
    {
        $syncAt = now()->subMinutes(15);

        $actual = $events
            ->filter(fn($event) => $event['updated'] > $syncAt)
            ->pluck('id')
            ->values()
            ->toArray();

        $this->assertEquals(['3-event-id'], $actual);
    }

    /**
     * @param Collection $events
     * @param Collection $pages
     * @return void
     * @dataProvider data
     */
    public function test_delete_events_in_notion(Collection $events, Collection $pages): void
    {
        $actual = $pages
            ->pluck('google-id')
            ->filter()
            ->diff($events->pluck('id'))
            ->values()
            ->toArray();

        $this->assertEquals(['3-event-id'], $actual);
    }

    /**
     * @param Collection $events
     * @param Collection $pages
     * @return void
     * @dataProvider data
     */
    public function test_update_events_in_google(Collection $events, Collection $pages): void
    {
        $syncAt = now()->subMinutes(15);

        $actual = $pages
            ->filter(fn($page) => $page['last_edited_time'] > $syncAt)
            ->pluck('id')
            ->values()
            ->toArray();

        $this->assertEquals(['3-event-id'], $actual);
    }

    /**
     * @param Collection $events
     * @param Collection $pages
     * @return void
     * @dataProvider data
     */
    public function test_delete_events_in_google(Collection $events, Collection $pages): void
    {
        $actual = $pages
            ->where('archived', true)
            ->pluck('google-id')
            ->filter()
            ->values()
            ->toArray();

        $this->assertEquals(['3-event-id'], $actual);
    }

    public function data(): Collection
    {
        return collect([
            [
                collect([
                    [
                        'id' => '1-event-id',
                        'summary' => 'Notionism 1',
                        'updated' => now()->subMinutes(2),
                    ],
                    [
                        'id' => '2-event-id',
                        'summary' => 'Notionism 2',
                        'updated' => now()->subHour(),
                    ],
                    [
                        'id' => '3-event-id',
                        'summary' => 'Notionism 3',
                        'updated' => now()->subMinutes(20),
                    ],
                    [
                        'id' => '4-event-id',
                        'summary' => 'Notionism 4',
                        'updated' => now()->subMinutes(20),
                    ],
                ]),
                collect([
                    [
                        'id' => '1-page-id',
                        'google-id' => '1-event-id',
                        'recurring' => false,
                        'summary' => 'Notionism 1',
                        'archived' => false,
                        'last_edited_time' => now()->subMinutes(20),
                    ],
                    [
                        'id' => '2-page-id',
                        'google-id' => '2-event-id',
                        'recurring' => false,
                        'summary' => 'Notionism 2',
                        'archived' => false,
                        'last_edited_time' => now()->subMinutes(5),
                    ],
                    [
                        'id' => '4-page-id',
                        'google-id' => '4-event-id',
                        'recurring' => true,
                        'summary' => 'Notionism 4',
                        'archived' => true,
                        'last_edited_time' => now()->subMinutes(20),
                    ],
                    [
                        'id' => '5-page-id',
                        'google-id' => '5-event-id',
                        'recurring' => false,
                        'summary' => 'Notionism 5',
                        'archived' => true,
                        'last_edited_time' => now()->subMinutes(20),
                    ],
                    [
                        'id' => '6-page-id',
                        'google-id' => '',
                        'recurring' => false,
                        'summary' => 'Notionism 6',
                        'archived' => true,
                        'last_edited_time' => now()->subMinutes(20),
                    ],
                ]),
            ],
        ]);
    }
}
