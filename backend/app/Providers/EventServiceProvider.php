<?php

namespace App\Providers;

use App\Events\UserPasswordChanged;
use App\Listeners\LogUserPasswordChanged;
use App\Listeners\LogUserPasswordReset;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\LogUserRegistered;
use Illuminate\Auth\Events\Registered;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            LogUserRegistered::class,
        ],
        UserPasswordChanged::class => [
            LogUserPasswordChanged::class,
        ],
        PasswordReset::class => [
            LogUserPasswordReset::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
