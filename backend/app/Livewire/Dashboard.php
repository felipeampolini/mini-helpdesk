<?php

namespace App\Livewire;

use App\Models\Ticket;
use DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = Ticket::query()
            ->select('status', 'priority', DB::raw('count(*) as total'))
            ->groupBy('status', 'priority')
            ->get()
            ->groupBy('status');

        return view('livewire.dashboard', ['stats' => $stats]);
    }
}

