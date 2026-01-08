<?php

namespace App\Livewire;

use App\Actions\TicketStatusAction;
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

    public function startTicket(TicketStatusAction $action)
    {
        try {
            $action->execute($this->ticket, 'in_progress');

            $this->success(__('toast.ticket_started'));
        } catch (AuthorizationException) {
            $this->warning(__('toast.unauthorized_start_ticket'));
        } catch (InvalidArgumentException) {
            $this->warning(__('toast.invalid_ticket_status_transition'));
        }
    }

    public function closeTicket(TicketStatusAction $action)
    {
        try {
            $action->execute($this->ticket, 'closed');

            $this->success(__('toast.ticket_closed'));
        } catch (AuthorizationException) {
            $this->warning(__('toast.unauthorized_close_ticket'));
        } catch (InvalidArgumentException) {
            $this->warning(__('toast.invalid_ticket_status_transition'));
        }
    }

    public function reopenTicket(TicketStatusAction $action)
    {
        try {
            $action->execute($this->ticket, 'open');

            $this->success(__('toast.ticket_reopened'));
        } catch (AuthorizationException) {
            $this->warning(__('toast.unauthorized_reopen_ticket'));
        } catch (InvalidArgumentException) {
            $this->warning(__('toast.invalid_ticket_status_transition'));
        }
    }
}
