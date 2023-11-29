<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Requests\UpdateTemplateRequest;
use App\Models\Tag;
use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TemplateController extends \App\Http\Controllers\Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'templates' => Template::latest()->get()
        ]);
    }

    public function edit(Template $template): JsonResponse
    {
        $template->load('tags');

        return response()->json([
            'template' => $template,
            'tags' => Tag::get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $template = Template::create([
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'template' => $template,
        ]);
    }

    public function update(UpdateTemplateRequest $request, Template $template): JsonResponse
    {
        $template->fill([
            'status' => $request->validated('status'),
            'notion_page_id' => $request->validated('notion_page_id'),
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'template' => $template->save()
        ]);
    }

    public function destroy(Template $template): JsonResponse
    {
        return response()->json([
            'status' => $template->delete()
        ]);
    }

    public function uploadPreview(Request $request, Template $template): JsonResponse
    {
        if ($request->hasFile('preview_file')) {
            $template->preview = asset('storage/'.$request->file('preview_file')->store('preview', 'public'));
        }

        return response()->json([
            'status' => true,
            'updated' => $template->save()
        ]);
    }
}
