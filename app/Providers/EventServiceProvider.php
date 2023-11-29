<?php

namespace App\Providers;

use App\Events\ContentChanged;
use App\Listeners\RunNuxtGenerate;
use App\Models\BlogPost;
use App\Models\Template;
use App\Models\User;
use App\Observers\BlogPostObserver;
use App\Observers\TemplateObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ContentChanged::class => [
            RunNuxtGenerate::class
        ],
        SocialiteWasCalled::class => [
            'SocialiteProviders\\Notion\\NotionExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Template::observe(TemplateObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
