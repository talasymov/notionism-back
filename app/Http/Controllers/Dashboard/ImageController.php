<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreImageRequest;
use App\Models\Image;

class ImageController extends Controller
{
    public function store(StoreImageRequest $request)
    {
        $path = $request->file('image')->store('image', 'public');

        Image::create([
            'path' => $path
        ]);

        return response()->json([
            'success' => 1,
            'path' => asset($path)
        ]);
    }
}
