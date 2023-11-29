<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Models\Tag;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Dashboard/Templates/Index', [
            'templates' => Template::latest()->get()
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
     * @param \App\Http\Requests\StoreTemplateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTemplateRequest $request)
    {
        $template = Template::create([
            'title' => 'New template',
            'desc' => '',
            'ver' => null,
            'dbs' => 0,
            'props' => 0,
            'pages' => 0,
            'slug' => 'new-template',
            'preview' => '',
            'content' => [
                'html' => '',
                'builder' => [['component' => 'main', 'children' => []]]
            ],
            'price' => 0,
            'link' => '',
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('dashboard.templates.edit', $template->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Template $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Template $template
     * @return Response
     */
    public function edit(Template $template)
    {
        $template->load('tags');

        return Inertia::render('Dashboard/Templates/Edit', [
            'template' => $template,
            'tags' => Tag::get(),
            'builder_items' => $template->content['builder'] ?? [['component' => 'main', 'children' => []]]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTemplateRequest $request
     * @param \App\Models\Template $template
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTemplateRequest $request, Template $template)
    {
        $template->fill([
            'title' => $request->validated('title'),
            'desc' => $request->validated('desc'),
            'ver' => $request->validated('ver'),
            'dbs' => $request->validated('dbs'),
            'pages' => $request->validated('pages'),
            'props' => $request->validated('props'),
            'slug' => $request->validated('slug'),
            'price' => $request->validated('price'),
            'link' => $request->validated('link'),
            'user_id' => $request->user()->id,
            'content' => [
                'html' => $request->validated('html'),
                'builder' => $request->validated('builder'),
            ],
        ]);

        if ($template->isClean('slug')) {
            $template->slug = str($template->title)->slug();
        }

        if ($request->hasFile('preview_file')){
            $template->preview = asset($request->file('preview_file')->store('preview', 'public'));
        }

        $template->tags()->sync(collect($request->post('tags'))->pluck('id'));

        $template->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Template $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //
    }
}
