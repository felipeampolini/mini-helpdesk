<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class TicketTable extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $search = '';
    public $filterStatus = '';
    public $filterPriority = '';
    public $filterOwner = '';
    public $owner = '';

    public $dateFrom = '';
    public $dateTo = '';

    public function clearSearch()
    {
        $this->sortField = 'created_at';
        $this->sortDirection = 'desc';
        $this->search = '';
        $this->filterStatus = '';
        $this->filterPriority = '';
        $this->owner = '';

        $this->dateFrom = '';
        $this->dateTo = '';

        $this->resetPage();
    }

    public function render()
    {
        $this->authorize('viewAny', Ticket::class);

        $conditions = [];

        // Filtrar tickets do usuário se não for manager
        if(auth()->user()->role === 'user') {
            $conditions[] = fn($query) => $query->where('user_id', auth()->id());
        }

        // Busca por título
        if($this->search) {
            $conditions[] = fn($query) => $query->where('title', 'ilike', "%{$this->search}%");
        }

        // Filtro de status
        if($this->filterStatus) {
            $conditions[] = fn($query) => $query->where('status', $this->filterStatus);
        }

        // Filtro de prioridade
        if($this->filterPriority) {
            $conditions[] = fn($query) => $query->where('priority', $this->filterPriority);
        }

        // Filtro de dono
        if($this->owner) {
            $conditions[] = fn($query) => $query->whereHas('user', fn($q) =>
                $q->where('name', 'ilike', "%{$this->owner}%")
            );
        }

        // Filtro de datas
        if($this->dateFrom) {
            $conditions[] = fn($query) => $query->where('created_at', '>=', Carbon::parse($this->dateFrom));
        }
        if($this->dateTo) {
            $conditions[] = fn($query) => $query->where('created_at', '<=', Carbon::parse($this->dateTo));
        }

        // Ordenação especial
        if($this->sortField === 'priority') {
            $conditions[] = fn($query) => $query->orderByRaw("
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                END {$this->sortDirection}
            ");
        }elseif($this->sortField === 'status') {
            $conditions[] = fn($query) => $query->orderByRaw("
                CASE status
                    WHEN 'open' THEN 1
                    WHEN 'in_progress' THEN 2
                    WHEN 'closed' THEN 3
                END {$this->sortDirection}
            ");
        }else{
            $conditions[] = fn($query) => $query->orderBy($this->sortField, $this->sortDirection);
        }

        $tickets = Ticket::query()
            ->tap(function($query) use ($conditions) {
                foreach ($conditions as $condition) {
                    $condition($query);
                }
            })
            ->paginate(10);

        return view('livewire.ticket-table', ['tickets' => $tickets]);
    }

    public function sortBy(string $field)
    {
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }else{
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function searchTickets()
    {
        $this->resetPage();
    }

    public function updatedOwnerSearch($value)
    {
        $this->ownerSuggestions = User::where('name', 'like', "%{$value}%")
            ->limit(5)
            ->get()
            ->toArray();
    }
}
