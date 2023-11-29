<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Dashboard/Tags/Index', [
            'tags' => Tag::with('category')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create([
            'name' => 'New tag',
            'slug' => 'new-tag',
            'category_id' => 1,
            'icon' => '',
        ]);

        return redirect()->route('dashboard.tags.edit', $tag->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return Response
     */
    public function edit(Tag $tag)
    {
        return Inertia::render('Dashboard/Tags/Edit', [
            'tag' => $tag,
            'tags' => Tag::get(),
            'categories' => Category::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTagRequest $request
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->fill($request->validated());

        if ($tag->isClean('slug')) {
            $tag->slug = str($tag->name)->slug();
        }

        $tag->save();

        return Redirect::route('dashboard.tags.edit', $tag->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
