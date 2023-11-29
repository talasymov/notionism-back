<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWidgetRequest;
use App\Http\Requests\UpdateWidgetRequest;
use App\Models\Widget;
use Illuminate\Http\JsonResponse;

class WidgetController extends Controller
{
    public function index()
    {
        return response()->json([
            'widgets' => Widget::all()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreWidgetRequest $request)
    {
    }

    public function show(Widget $widget)
    {
        //
    }

    public function edit(Widget $widget): JsonResponse
    {
        return response()->json([
            'widget' => $widget,
        ]);
    }

    public function update(UpdateWidgetRequest $request, Widget $widget)
    {
        $widget->fill([
            'status' => $request->validated('status'),
            'notion_page_id' => $request->validated('notion_page_id'),
        ]);

        return response()->json([
            'widget' => $widget->save()
        ]);
    }

    public function destroy(Widget $widget)
    {
        //
    }
}
