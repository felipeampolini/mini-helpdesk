<?php

namespace App\Livewire;

use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Services\Ticket\UpdateTicketService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Validator;

class TicketEdit extends Component
{
    use AuthorizesRequests;
    use Toastable;

    public Ticket $ticket;

    public string $title;
    public string $description;
    public string $status;
    public string $priority;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;

        $this->title = $ticket->title;
        $this->description = $ticket->description;
        $this->status = $ticket->status;
        $this->priority = $ticket->priority;

        $this->authorize('update', $ticket);
    }

    public function render()
    {
        return view('livewire.ticket-edit');
    }

    public function save(UpdateTicketService $service)
    {

        try {
            $this->authorize('update', $this->ticket);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->warning(__("toast.unauthorized_ticket_edit"));
            return $this->redirectRoute('tickets.show', $this->ticket->id);
        }

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => auth()->user()->can('changeStatus', $this->ticket) ? $this->status : $this->ticket->status,
            'priority' => auth()->user()->can('changePriority', $this->ticket) ? $this->priority : $this->ticket->priority,
        ];

        // Validação usando UpdateTicketRequest
        $validated = Validator::make(
            $this->ticket->toArray(),
            (new UpdateTicketRequest())->rules()
        )->validate();

        // Apenas atualiza status e prioridade se o usuário tiver permissão
        if (! auth()->user()->can('changeStatus', $this->ticket)) {
            unset($validated['status']);
        }

        if (! auth()->user()->can('changePriority', $this->ticket)) {
            unset($validated['priority']);
        }

        $this->ticket->update($validated);

        $service->execute($this->ticket, $data);

        $this->success(__("toast.ticket_updated"), ["id" => $this->ticket->id]);

        return $this->redirectRoute('tickets.show', $this->ticket->id);
    }
}
