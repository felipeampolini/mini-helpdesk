<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LogTicketCreated
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
    public function handle(TicketCreated $event): void
    {
        Log::info("O usuário [ID: {$event->ticket->user->id}, Email: {$event->ticket->user->email}] criou um ticket", [
            'ticket_id' => $event->ticket->id,
            'user_id' => $event->ticket->user_id,
            'title' => $event->ticket->title,
            'priority' => $event->ticket->priority,
        ]);
    }
}
