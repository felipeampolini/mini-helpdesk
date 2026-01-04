<?php

namespace App\Livewire;

use App\Events\TicketCreated;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use App\Services\Ticket\CreateTicketService;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Validator;

class TicketCreateModal extends Component
{
    use Toastable;

    public $title = '';
    public $description = '';
    public $priority = '';

    public function createTicket(CreateTicketService $service)
    {
        try {
            $this->authorize('create', Ticket::class);
        } catch (AuthorizationException $e) {
            $this->warning(__("toast.unauthorized_ticket_create"));
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

        $this->success(__("toast.ticket_created"), ["id" => $ticket->id]);

    }

    public function render()
    {
        return view('livewire.ticket-create-modal');
    }
}
