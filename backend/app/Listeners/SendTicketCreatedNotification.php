<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Notifications\TicketCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketCreatedNotification
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
        $event->ticket->user->notify(new TicketCreatedNotification($event->ticket));
    }
}
