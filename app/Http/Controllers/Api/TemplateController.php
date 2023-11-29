<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Template\TemplateResource;
use App\Models\Tag;
use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class TemplateController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $templates = Template::latest()
            ->published()
            ->when(request()->has('user'), function ($q) {
                $q->where('user_id', request()->get('user'));
            })
            ->when(request()->has('tag'), function ($q) {
                $tag = Tag::where('slug', request()->get('tag'))->first();

                $q->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tags.id', $tag->id);
                });
            });

        return TemplateResource::collection($templates->paginate(9));
    }

    public function show(Template $template): JsonResponse
    {
        $template->publishing_at = Carbon::parse($template->created_at)->format('d M Y');
        $template->load(['tags', 'user']);
        return response()->json($template);
    }

    public function like(Template $template): JsonResponse
    {
        $template->increment('likes');
        return response()->json($template);
    }

    public function dislike(Template $template): JsonResponse
    {
        $template->decrement('likes');
        return response()->json($template);
    }
}
