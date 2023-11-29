<?php

namespace App\Http\Controllers\Api\Integrations\Google\GoogleCalendar;

use App\Http\Controllers\Controller;
use App\Services\Google\GoogleCalendarClientService;
use Google\Service\Calendar;
use Illuminate\Http\JsonResponse;

class EventsController extends Controller
{
    public function list(GoogleCalendarClientService $clientService): JsonResponse
    {
        $calendarList = new Calendar($clientService->client);

        $items = $calendarList
            ->events
            ->listEvents(request()->get('id'), [])
            ->getItems();

        return response()->json([
            'items' => $items
        ]);
    }
}
