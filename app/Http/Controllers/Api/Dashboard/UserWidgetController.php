<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserWidgetRequest;
use App\Http\Requests\UpdateUserWidgetRequest;
use App\Models\UserWidget;
use App\Models\Widget;
use App\Widgets\WidgetFactory;
use Illuminate\Http\JsonResponse;

class UserWidgetController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(UserWidget::class, 'user_widget');
    }

    public function index()
    {
        return [
            'widgets' => UserWidget::query()
                ->select('uuid', 'widget_id', 'name')
                ->with([
                    'widget' => fn($q) => $q->select('id', 'name', 'desc', 'preview')
                ])
                ->where('user_id', auth()->id())
                ->get()
        ];
    }

    public function create()
    {
        //
    }

    public function store(StoreUserWidgetRequest $request)
    {
        $widget = Widget::query()
            ->where('codename', $request->post('widget_codename'))
            ->first();

        $config = $request->post('config') ?? WidgetFactory::fromEnum(
            \App\Enums\Widget::from($widget->codename)
        )->getDefaultData();

        return UserWidget::query()->create([
            'user_id' => $request->user()->id,
            'widget_id' => $widget->id,
            'name' => $widget->name,
            'config' => $config,
        ]);
    }

    public function showEmbed(UserWidget $userWidget): JsonResponse
    {
        $userWidget->load('widget');

        $embedData = WidgetFactory::fromEnum(\App\Enums\Widget::from($userWidget->widget->codename))
            ->getEmbedData($userWidget->config);

        $userWidget->timestamps = false;

        $userWidget->update([
            'viewed_at' => now()
        ]);

        return response()->json([
            'codename' => $userWidget->widget->codename,
            'config' => $userWidget->config,
            'data' => $embedData,
        ]);
    }

    public function edit(UserWidget $userWidget): JsonResponse
    {
        $userWidget->load('widget');

        $embedData = WidgetFactory::fromEnum(\App\Enums\Widget::from($userWidget->widget->codename))
            ->getEmbedData($userWidget->config);

        return response()->json([
            'widget_id' => $userWidget->widget_id,
            'name' => $userWidget->name,
            'codename' => $userWidget->widget->codename,
            'config' => $userWidget->config,
            'widget_data' => $embedData,
            'data' => WidgetFactory::fromEnum(\App\Enums\Widget::from($userWidget->widget->codename))->getConfig(),
        ]);
    }

    public function update(UpdateUserWidgetRequest $request, UserWidget $userWidget)
    {
        $userWidget->update([
            'name' => $request->post('name'),
            'config' => $request->post('config')
        ]);
    }

    public function destroy(UserWidget $userWidget): JsonResponse
    {
        return response()->json([
            'status' => $userWidget->delete()
        ]);
    }
}
