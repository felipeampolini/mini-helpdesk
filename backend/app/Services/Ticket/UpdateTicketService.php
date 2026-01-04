<?php

namespace App\Services\Ticket;

use App\Events\TicketUpdated;
use App\Models\Ticket;

class UpdateTicketService
{
    public function execute(Ticket $ticket, array $data): Ticket
    {
        $ticket->update($data);

        event(new TicketUpdated($ticket));

        return $ticket;
    }
}
