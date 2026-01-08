<?php

namespace App\Actions;

use App\Models\Ticket;
use Gate;
use InvalidArgumentException;

class TicketStatusAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(Ticket $ticket, string $toStatus): void
    {
        Gate::authorize('changeStatus', $ticket);

        if(!$this->canTransition($ticket->status, $toStatus)){
            throw new InvalidArgumentException();
        }

        $ticket->update([
            'status' => $toStatus,
        ]);
    }

    private function canTransition(string $from, string $to): bool
    {
        $transitions = [
            'open' => [
                'in_progress',
                'closed',
            ],
            'in_progress' => [
                'closed',
            ],
            'closed' => [
                'open',
            ],
        ];

        return in_array($to, $transitions[$from] ?? [], true);
    }

}
