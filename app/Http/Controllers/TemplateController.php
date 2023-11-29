<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Template;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use Inertia\Inertia;
use Inertia\Response;

class TemplateController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Templates/Index', [
            'templates' => Template::latest()->paginate(9),
            'categories' => Category::get(),
            'tags' => Tag::with('category')->withCount('templates')->get()->groupBy('category.id'),
        ]);
    }

    public function show(Template $template): Response
    {
        $template->publishing_at = Carbon::parse($template->created_at)->format('d M Y');

        $template->load('tags');

        return Inertia::render('Templates/Show', [
            'template' => $template,
            'tags' => $template->tags
        ]);
    }

    public function like(Template $template)
    {
        $executed = RateLimiter::attempt(
            sprintf('like-%s-%s', $template->slug, request()->ip()),
            1,
            function () {
            }
        );

        if (!$executed){
            $template->increment('likes');
        }

        return back();
    }
}
