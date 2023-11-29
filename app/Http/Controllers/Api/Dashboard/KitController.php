<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateKitRequest;
use App\Models\Kit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KitController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'kits' => Kit::latest()->get()
        ]);
    }

    public function edit(Kit $kit): JsonResponse
    {
        return response()->json([
            'kit' => $kit,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $kit = Kit::create([
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'kit' => $kit,
        ]);
    }

    public function update(UpdateKitRequest $request, Kit $kit): JsonResponse
    {
        $kit->fill([
            'status' => $request->validated('status'),
            'notion_page_id' => $request->validated('notion_page_id'),
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'kit' => $kit->save()
        ]);
    }
}
