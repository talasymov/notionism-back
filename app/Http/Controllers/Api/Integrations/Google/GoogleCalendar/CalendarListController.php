<?php

namespace App\Http\Controllers\Api\Integrations\Google\GoogleCalendar;

use App\Http\Controllers\Controller;
use App\Services\Google\GoogleClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarListController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $client = new GoogleClient($request->user()->oAuthGoogleCalendarToken()->first());

        return response()->json([
            'items' => $client->calendarList()->list([
                'minAccessRole' => 'writer'
            ])
        ]);
    }
}
