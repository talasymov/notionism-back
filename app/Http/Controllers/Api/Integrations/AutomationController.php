<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Api\Integrations\Automation\UserAutomationService;
use App\Http\Controllers\Controller;
use App\Models\UserAutomation;
use Illuminate\Http\JsonResponse;

class AutomationController extends Controller
{
    public function test(UserAutomationService $service): JsonResponse
    {
        try {
            $item = UserAutomation::query()->with([
                'user' => fn($q) => $q->with(['oAuthGoogleCalendarToken', 'oAuthNotionToken'])
            ])
                ->where('user_id', auth()->id())
                ->latest()
                ->first();

            $automationService = $service->getAutomationService($item);
            $automationService->handle();

            return response()->json([
                'status' => true,
                'logs' => $automationService->getLogs()
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unhandled error, please try again or contact us',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(UserAutomationService $service): JsonResponse
    {
        try {
            $userAutomation = $service->getUserAutomationInstance();

            return response()->json([
                'status' => $userAutomation->save()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unhandled error, please try again or contact us',
                'error' => $e->getMessage()
            ]);
        }
    }
}
