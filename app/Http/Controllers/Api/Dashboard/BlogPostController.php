<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'posts' => BlogPost::latest()->get()
        ]);
    }

    public function edit(BlogPost $blogPost): JsonResponse
    {
        return response()->json([
            'post' => $blogPost,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $post = BlogPost::create([
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'post' => $post,
        ]);
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost): JsonResponse
    {
        $blogPost->fill([
            'status' => $request->validated('status'),
            'user_id' => $request->user()->id,
            'notion_page_id' => $request->validated('notion_page_id'),
        ]);

        return response()->json([
            'post' => $blogPost->save()
        ]);
    }

    public function destroy(BlogPost $blogPost): JsonResponse
    {
        return response()->json([
            'status' => $blogPost->delete()
        ]);
    }
}
