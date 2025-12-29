<?php

namespace App\Services\Ticket;

use App\Events\TicketCreated;
use App\Models\Ticket;
use Auth;

class CreateTicketService
{
    public function execute(array $data): Ticket
    {
        $ticket = Ticket::create([
            'title'       => $data['title'],
            'description' => $data['description'],
            'priority'    => $data['priority'],
            'status'      => 'open',
            'user_id'     => Auth::id(),
        ]);

        event(new TicketCreated($ticket));

        return $ticket;
    }
}
