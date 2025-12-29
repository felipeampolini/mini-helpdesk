<?php

namespace App\Livewire;

use App\Events\TicketCreated;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use App\Services\Ticket\CreateTicketService;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Component;
use Validator;

class TicketCreateModal extends Component
{
    public $title = '';
    public $description = '';
    public $priority = '';

    public function createTicket(CreateTicketService $service)
    {
        try {
            $this->authorize('create', Ticket::class);
        } catch (AuthorizationException $e) {
            $this->dispatch('notify', [
                'type' => 'danger',
                'message' => 'Você não tem permissão para criar tickets.'
            ]);
            $this->dispatch('close-modal', 'new-ticket-modal');

            return;
        }

        $validated = Validator::make(
            $this->only(
                ['title', 'description', 'priority']),
                (new StoreTicketRequest())->rules()
        )->validate();

        $ticket = $service->execute($validated);

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
