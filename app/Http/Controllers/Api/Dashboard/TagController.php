<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'tags' => Tag::with('category')->latest()->get()
        ]);
    }

    public function edit(Tag $tag)
    {
        return response()->json([
            'tag' => $tag,
            'tags' => Tag::get(),
            'categories' => Category::get()
        ]);
    }

    public function store(): JsonResponse
    {
        $tag = Tag::create([
            'name' => 'New tag',
            'slug' => 'new-tag',
            'category_id' => 1,
            'icon' => '',
        ]);

        return response()->json([
            'tag' => $tag
        ]);
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->fill($request->validated());

        if ($tag->isClean('slug')) {
            $tag->slug = str($tag->name)->slug();
        }

        $tag->save();

        return response()->json([
            'tag' => $tag
        ]);
    }

    public function destroy(Tag $tag): JsonResponse
    {
        return response()->json([
            'status' => $tag->delete()
        ]);
    }
}
