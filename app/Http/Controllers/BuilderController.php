<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Template;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BuilderController
{
    public function uploadImage()
    {
        $path = request()->file('image')->store('image', 'public');

        Image::create([
            'path' => $path
        ]);

        return response()->json([
            'success' => 1,
            'path' => asset($path)
        ]);
    }

    public function updateBuilder(Request $request, Template $template)
    {
        $success = $template->fill([
            'content' => [
                'html' => $request->post('html'),
                'builder' => $request->post('builder'),
            ],
        ])->save();

        return response()->json([
            'success' => $success
        ]);
    }
}
