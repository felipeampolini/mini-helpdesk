<?php

namespace App\Livewire;

use App\Models\Ticket;
use DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $query = Ticket::query();

        if (auth()->user()->role === 'user') {
            $query->where('user_id', auth()->id());
        }

        $stats = $query
            ->select('status', 'priority', DB::raw('count(*) as total'))
            ->groupBy('status', 'priority')
            ->get()
            ->groupBy('status');

        return view('livewire.dashboard', [
            'stats' => $this->normalizeStats($stats),
        ]);
    }

    protected function normalizeStats($stats)
    {
        $statuses = ['open', 'in_progress', 'closed'];

        foreach ($statuses as $status) {
            if (! isset($stats[$status])) {
                $stats[$status] = collect();
            }
        }

        return $stats;
    }
}

