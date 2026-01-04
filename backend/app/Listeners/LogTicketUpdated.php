<?php

namespace App\Listeners;

use App\Events\TicketUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LogTicketUpdated
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
    public function handle(TicketUpdated $event): void
    {
        Log::info("O usuário [ID: {$event->ticket->user->id}, Email: {$event->ticket->user->email}] atualizou um ticket", [
            'ticket_id' => $event->ticket->id,
            'title' => $event->ticket->title,
            'status' => $event->ticket->status,
            'priority' => $event->ticket->priority,
        ]);
    }
}
