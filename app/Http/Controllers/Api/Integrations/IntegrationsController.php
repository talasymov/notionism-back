<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use App\Models\OAuthService;
use App\Models\OAuthToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IntegrationsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $services = OAuthService::query()
            ->select('id', 'name', 'codename')
            ->with([
                'tokens' => fn($q) => $q
                    ->select('id', 'o_auth_service_id', 'created_at')
                    ->where('user_id', $request->user()->id)
            ])
            ->get();

        return response()->json([
            'services' => $services
        ]);
    }

    public function destroy(string $codename): JsonResponse
    {
        $service = OAuthService::query()->where('codename', $codename)->first();

        return response()->json([
            'status' => OAuthToken::query()
                ->where('o_auth_service_id', $service->id)
                ->where('user_id', auth()->id())
                ->delete()
        ]);
    }
}
