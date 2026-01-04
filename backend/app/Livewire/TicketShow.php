<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class TicketShow extends Component
{
    use AuthorizesRequests;
    use Toastable;

    public Ticket $ticket;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->authorize('view', $ticket);
    }

    public function render()
    {
        return view('livewire.ticket-show');
    }

    public function edit(){

        try {
            $this->authorize('update', $this->ticket);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->warning(__("toast.unauthorized_ticket_edit"));
            return $this->redirectRoute('tickets.show', $this->ticket->id);
        }

        return $this->redirectRoute('tickets.edit', $this->ticket->id);

    }
}
