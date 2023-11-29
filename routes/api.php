<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Dashboard\UserWidgetController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Integrations\AutomationController;
use App\Http\Controllers\Api\Integrations\Google\GoogleCalendar\CalendarListController;
use App\Http\Controllers\Api\Integrations\Google\GoogleCalendar\EventsController;
use App\Http\Controllers\Api\Integrations\IntegrationsController;
use App\Http\Controllers\Api\Integrations\Notion\Database\DatabaseController;
use App\Http\Controllers\Api\NotionExportController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WidgetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('categories', CategoryController::class);

Route::prefix('tags')
    ->controller(\App\Http\Controllers\Api\TagController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('{tag:slug}', 'show');
    });

Route::prefix('templates')
    ->controller(\App\Http\Controllers\Api\TemplateController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('{template:slug}', 'show');
        Route::put('{template:slug}/like', 'like');
        Route::put('{template:slug}/dislike', 'dislike');
    });

Route::prefix('kits')
    ->controller(\App\Http\Controllers\Api\KitController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('{kit:slug}', 'show');
    });

Route::prefix('blog')
    ->controller(\App\Http\Controllers\Api\BlogPostController::class)
    ->group(function () {
        Route::get('posts', 'index');
        Route::get('{blogPost:slug}', 'show');
        Route::put('{blogPost:slug}/like', 'like');
    });

Route::prefix('widgets')
    ->controller(WidgetController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('{widget:slug}', 'show');
    });

Route::prefix('user')->group(function () {
    Route::get('{user}', [UserController::class, 'show']);
});

Route::post('login', [AuthController::class, 'login']);

Route::get('csrf', [AuthController::class, 'csrf']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);

    Route::prefix('notion-export')
        ->controller(NotionExportController::class)
        ->middleware('admin')
        ->group(function () {
            Route::post('template/{template:id}', 'exportTemplate');
            Route::post('blog-post/{blogPost:id}', 'exportBlogPost');
            Route::post('widget/{widget:id}', 'exportWidget');
            Route::post('kit/{kit:id}', 'exportKit');
        });

    Route::prefix('dashboard')
        ->group(function () {
            Route::resource('tags', \App\Http\Controllers\Api\Dashboard\TagController::class)
                ->middleware('admin');
            Route::resource('templates', \App\Http\Controllers\Api\Dashboard\TemplateController::class)
                ->middleware('admin');
            Route::resource('kits', \App\Http\Controllers\Api\Dashboard\KitController::class)
                ->middleware('admin');
            Route::resource('blog-posts', \App\Http\Controllers\Api\Dashboard\BlogPostController::class)
                ->middleware('admin');
            Route::resource('widgets', \App\Http\Controllers\Api\Dashboard\WidgetController::class)
                ->middleware('admin');
            Route::post(
                'templates/{template}/upload-preview',
                [\App\Http\Controllers\Api\Dashboard\TemplateController::class, 'uploadPreview']
            )
                ->middleware('admin');

            Route::resource('user-widgets', UserWidgetController::class, [
                'except' => ['show']
            ]);
        });

    Route::prefix('integrations')
        ->group(function () {
            Route::resource('manager', IntegrationsController::class);

            Route::prefix('google/calendar')
                ->group(function () {
                    Route::prefix('calendar-list')
                        ->controller(CalendarListController::class)
                        ->group(function () {
                            Route::get('list', 'list');
                        });

                    Route::prefix('events')
                        ->controller(EventsController::class)
                        ->group(function () {
                            Route::get('list', 'list');
                        });
                });

            Route::prefix('notion')
                ->group(function () {
                    Route::prefix('database')
                        ->controller(DatabaseController::class)
                        ->group(function () {
                            Route::get('view', 'show');
                            Route::get('list', 'list');
                        });
                });

            Route::prefix('automation')
                ->controller(AutomationController::class)
                ->group(function () {
                    Route::post('test', 'test');
                    Route::post('', 'store');
                });
        });
});

Route::get('dashboard/user-widgets/{user_widget}', [UserWidgetController::class, 'showEmbed']);

Route::get('dashboard/stat', [DashboardController::class, 'stat']);
