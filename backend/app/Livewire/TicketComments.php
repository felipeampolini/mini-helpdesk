<?php

namespace App\Livewire;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Ticket;
use App\Services\Comment\CreateCommentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Validator;

class TicketComments extends Component
{
    use AuthorizesRequests;
    use Toastable;

    public Ticket $ticket;
    public bool $showHeader;
    public bool $allowComment;
    public string $comment = '';

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function addComment(CreateCommentService $service)
    {
        $this->authorize('comment', $this->ticket);

        // validação via FormRequest
        $validated = Validator::make(
            ['comment' => $this->comment],
            (new StoreCommentRequest())->rules()
        )->validate();

        $service->execute($this->ticket, $validated['comment']);

        $this->comment = '';

        $this->success(__('toast.comment_created'));
    }

    public function render()
    {
        return view('livewire.ticket-comments', [
            'comments' => $this->ticket
                ->comments()
                ->with('user')
                ->orderBy('created_at')
                ->get(),
        ]);
    }

}
