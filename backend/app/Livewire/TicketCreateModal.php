<?php

namespace App\Livewire;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use Livewire\Component;
use Validator;

class TicketCreateModal extends Component
{
    public $title = '';
    public $description = '';
    public $priority = '';

    public function createTicket()
    {
        $this->authorize('create', Ticket::class);

        $validated = Validator::make(
            $this->only(
                ['title', 'description', 'priority']),
                (new StoreTicketRequest())->rules()
        )->validate();

        $validated['status'] = 'open';

        $ticket = auth()->user()->tickets()->create($validated);

        $this->reset(['title', 'description', 'priority']);
        $this->dispatch('close-modal', 'new-ticket-modal');
        $this->dispatch('ticketCreated');

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Ticket criado! <a href='".route('tickets.show', $ticket)."' class='underline cursor-pointer'>Ir para o ticket</a>"
        ]);

    }

    public function render()
    {
        return view('livewire.ticket-create-modal');
    }
}
