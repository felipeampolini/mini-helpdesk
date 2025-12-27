<?php

namespace App\Listeners;

use App\Events\UserDestroyed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LogUserDestroyed
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserDestroyed $event): void
    {
        $user = $event->user;

        Log::info("Usuário [ID: {$user->id}, Email: {$user->email}] deletou a conta", [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
