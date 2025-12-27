<?php

namespace App\Listeners;

use App\Events\UserPasswordChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogUserPasswordChanged
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
    public function handle(UserPasswordChanged $event): void
    {
        $user = $event->user;

        Log::info("Usuário [ID: {$user->id}, Email: {$user->email}] atualizou a senha via formulário de atualização de senha", [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
