<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Widget\WidgetResource;
use App\Models\Tag;
use App\Models\Widget;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class WidgetController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $isAdmin = auth()->user()?->isAdmin();

        $widgets = Widget::latest()
            ->when(!$isAdmin, fn($q) => $q->published())
            ->when(request()->has('user'), function ($q) {
                $q->where('user_id', request()->get('user'));
            })
            ->when(request()->has('tag'), function ($q) {
                $tag = Tag::where('slug', request()->get('tag'))->first();

                $q->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tags.id', $tag->id);
                });
            });

        return WidgetResource::collection($widgets->paginate(request('take', 21)));
    }

    public function show(Widget $widget): JsonResponse
    {
        $widget->publishing_at = Carbon::parse($widget->created_at)->format('d M Y');
        $widget->load(['tags']);
        return response()->json($widget);
    }
}
