<?php

namespace App\Providers;

use App\Events\MessageSent;
use App\Events\NewCommentSent;
use App\Listeners\DisplayNewMessageToUser;
use App\Listeners\ListenNewCommentSent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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

        MessageSent::class => [
            DisplayNewMessageToUser::class,
        ], // messaging event & listerner

        NewCommentSent::class => [
            ListenNewCommentSent::class,
        ], // commenting event & listerner
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
