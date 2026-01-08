<?php

namespace App\Listeners;

use App\Events\TicketStatusChanged;
use App\Notifications\TicketStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendTicketStatusNotification
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
        $event->ticket->user->notify(new TicketStatusNotification($event));
    }
}
