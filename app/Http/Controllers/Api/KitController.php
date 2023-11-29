<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Kit\KitResource;
use App\Models\Kit;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class KitController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $kits = Kit::latest()
            ->published()
            ->get();

        return KitResource::collection($kits);
    }

    public function show(Kit $kit): JsonResource
    {
        return KitResource::make($kit);
    }
}
