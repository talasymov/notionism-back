<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWidgetCategoryRequest;
use App\Http\Requests\UpdateWidgetCategoryRequest;
use App\Models\WidgetCategory;

class WidgetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreWidgetCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWidgetCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WidgetCategory  $widgetCategory
     * @return \Illuminate\Http\Response
     */
    public function show(WidgetCategory $widgetCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WidgetCategory  $widgetCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(WidgetCategory $widgetCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWidgetCategoryRequest  $request
     * @param  \App\Models\WidgetCategory  $widgetCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWidgetCategoryRequest $request, WidgetCategory $widgetCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WidgetCategory  $widgetCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(WidgetCategory $widgetCategory)
    {
        //
    }
}
