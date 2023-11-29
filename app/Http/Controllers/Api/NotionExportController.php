<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Kit;
use App\Models\Template;
use App\Models\Widget;
use App\Services\NotionExport\NotionExportService;
use Illuminate\Http\JsonResponse;

class NotionExportController extends Controller
{
    public function exportTemplate(NotionExportService $service, Template $template): JsonResponse
    {
        $service->setTemplate($template);
        $service->setPageId(request()->post('notion_page_id'));

        return response()->json($service->exportTemplate());
    }

    public function exportKit(NotionExportService $service, Kit $kit): JsonResponse
    {
        $service->setKit($kit);
        $service->setPageId(request()->post('notion_page_id'));

        return response()->json($service->exportKit());
    }

    public function exportBlogPost(NotionExportService $service, BlogPost $blogPost): JsonResponse
    {
        $service->setBlogPost($blogPost);
        $service->setPageId(request()->post('notion_page_id'));

        return response()->json($service->exportBlogPost());
    }

    public function exportWidget(NotionExportService $service, Widget $widget): JsonResponse
    {
        $service->setWidget($widget);
        $service->setPageId(request()->post('notion_page_id'));

        return response()->json($service->exportWidget());
    }
}
