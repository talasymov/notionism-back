<?php

use App\Http\Controllers\Api\LoginSocialiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->controller(LoginSocialiteController::class)
    ->group(function () {
        Route::get('google-auth/redirect', 'redirectGoogle');
        Route::get('google-auth/callback', 'callbackGoogle');

        Route::get('google-calendar/redirect', 'redirectGoogleCalendar');
        Route::get('google-calendar/callback', 'callbackGoogleCalendar');

        Route::get('notion/redirect', 'redirectNotion');
        Route::get('notion/callback', 'callbackNotion');
    });

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

require __DIR__.'/auth.php';
