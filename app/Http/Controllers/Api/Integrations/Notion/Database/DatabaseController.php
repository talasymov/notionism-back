<?php

namespace App\Http\Controllers\Api\Integrations\Notion\Database;

use App\Http\Controllers\Controller;
use App\Models\OAuthService;
use App\Models\OAuthToken;
use App\Services\Notion\NotionClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DatabaseController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $client = new NotionClient($request->user()->oAuthNotionToken()->first());

        return response()->json([
            'items' => $client->databases()->list()
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        $service = OAuthService::getNotion();

        $token = OAuthToken::query()
            ->where('user_id', auth()->id())
            ->where('o_auth_service_id', $service->id)
            ->first()
            ->token;

        $id = last(explode('/', parse_url($request->get('id'), PHP_URL_PATH)));

        $response = Http::withToken($token)
            ->withHeaders([
                'Notion-Version' => '2022-06-28',
            ])
            ->get('https://api.notion.com/v1/databases/'.$id)
            ->json();

        $response['properties'] = array_filter(
            $response['properties'],
            fn($key) => !in_array($key, [
                'notionism_google_calendar_id',
                'notionism_google_calendar_updated_at',
            ]),
            ARRAY_FILTER_USE_KEY
        );

        return response()->json($response);
    }
}
