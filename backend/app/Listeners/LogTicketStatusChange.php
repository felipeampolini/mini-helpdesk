<?php

namespace App\Listeners;

use App\Events\TicketStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LogTicketStatusChange
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
    public function handle(TicketStatusChanged $event): void
    {
        Log::info("O usuário [ID: {$event->ticket->user->id}, Email: {$event->ticket->user->email}] atualizou o status do ticket #{$event->ticket->id}", [
            'de' => $event->from,
            'para' => $event->to
        ]);
    }
}
