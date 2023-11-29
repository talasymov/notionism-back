<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        $tags = Tag::with('category')
            ->withCount(['templates' => fn($query) => $query->published()])
            ->whereHas('templates', fn($query) => $query->published())
            ->get()
            ->groupBy('category_id');

        return response()->json($tags);
    }

    public function show(Tag $tag): JsonResponse
    {
        return response()->json($tag);
    }
}
