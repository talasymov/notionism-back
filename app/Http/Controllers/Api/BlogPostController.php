<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogPost\BlogPostResource;
use App\Models\BlogPost;
use App\Services\NotionExport\Blocks\BaseHeading;
use Illuminate\Http\JsonResponse;

class BlogPostController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $posts = BlogPost::latest()->published()->paginate(12);

        return BlogPostResource::collection($posts);
    }

    public function show(BlogPost $blogPost): JsonResponse
    {
        $blogPost->load('user');

        $headers = [];

        $start = null;

        if ($blogPost->page_object) {
            $baseHeaders = $blogPost
                ->page_object
                ->getHeaders()
                ->values();

            $baseHeaders
                ->each(function (BaseHeading $item, $key) use (&$start, &$headers, $baseHeaders) {
                    $baseItem = [
                        'type' => $item->type(),
                        'slug' => $item->getPlainTextSlug(),
                        'text' => $item->getPlainText(),
                    ];
                    if ($item->type() === 'heading_2') {
                        if ($start) {
                            $headers[] = $start;
                        }
                        $start = $baseItem;
                        $start['children'] = [];
                        if ($key === $baseHeaders->count() - 1) {
                            $headers[] = $start;
                        }
                        return;
                    }
                    $start['children'][] = $baseItem;
                    if ($key === $baseHeaders->count() - 1) {
                        $headers[] = $start;
                    }
                });
        }

        return response()->json([
            'post' => $blogPost,
            'headers' => $headers
        ]);
    }

    public function like(BlogPost $blogPost): JsonResponse
    {
        $blogPost->increment('likes');
        return response()->json($blogPost);
    }
}
