<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LogUserUpdated
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
    public function handle(UserUpdated $event): void
    {
        $user = $event->user;

        $changes = $user->getChanges();

        Log::info("Usuário [ID: {$user->id}, Email: {$user->email}] atualizou os dados do perfil: ".json_encode($changes), [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
