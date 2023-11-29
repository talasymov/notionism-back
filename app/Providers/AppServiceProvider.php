<?php

namespace App\Providers;

use App\Services\Google\GoogleCalendarClientService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GoogleCalendarClientService::class, function () {
            return new GoogleCalendarClientService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Response::macro('jsonCache', function ($data) {
            return Response::json($data)->withHeaders([
                'Cache-Control' => 'max-age=600, public'
            ]);
        });
    }
}
