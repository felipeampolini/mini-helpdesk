<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogUserPasswordReset
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
    public function handle(PasswordReset $event): void
    {
        $user = $event->user;
        Log::info("Usuário [ID: {$user->id}, Email: {$user->email}] atualizou a senha via link de recuperação de senha", [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
