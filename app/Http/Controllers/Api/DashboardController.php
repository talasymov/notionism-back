<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserWidget;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stat(): JsonResponse
    {
        $days = now()->diffInDays('2023-06-28');

        return response()->json([
            'visitors' => 1997 + $days * 35,
            'users' => User::query()->count(),
            'templates_downloaded' => 324,
            'team' => 3,
            'widgets_created' => UserWidget::query()->count()
        ]);
    }
}
