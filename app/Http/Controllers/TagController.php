<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Inertia\Inertia;

class TagController
{
    public function show(Tag $tag)
    {
        return Inertia::render('Templates/Index', [
            'templates' => $tag->templates()->latest()->paginate(9),
            'categories' => Category::get(),
            'tags' => Tag::with('category')->withCount('templates')->get()->groupBy('category.id'),
            'tag' => $tag,
        ]);
    }
}
