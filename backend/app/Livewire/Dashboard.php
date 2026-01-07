<?php

namespace App\Livewire;

use App\Models\Ticket;
use Carbon\Carbon;
use DB;
use Livewire\Component;

class Dashboard extends Component
{
    public string $period = 'day'; // day | month
    public array $chartData = [];

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

    public function loadChartData()
    {
        $user = auth()->user();

        $periodExpression = match ($this->period) {
            'month' => "DATE_TRUNC('month', created_at)",
            default => "DATE(created_at)",
        };

        $query = Ticket::query()
            ->selectRaw("$periodExpression as period, priority, count(*) as total");

        if ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        $rows = $query
            ->groupByRaw("$periodExpression, priority")
            ->orderByRaw($periodExpression)
            ->get();

        $this->chartData = $this->normalizeChartData($rows);
    }

    protected function refreshChart()
    {
        $this->loadChartData();
        $this->dispatch('chart-updated', chartData: $this->chartData);
    }

    public function mount()
    {
        $this->refreshChart();
    }

    public function updatedPeriod()
    {
        $this->refreshChart();
    }

    private function normalizeStats($stats)
    {
        $statuses = ['open', 'in_progress', 'closed'];

        foreach ($statuses as $status) {
            if (! isset($stats[$status])) {
                $stats[$status] = collect();
            }
        }

        return $stats;
    }

    private function normalizeChartData($rows)
    {
        $labels = [];
        $high = [];
        $medium = [];
        $low = [];

        $grouped = $rows->groupBy(fn ($row) => $row->period);

        foreach ($grouped as $period => $items) {

            $date = Carbon::parse($period);

            $labels[] = match ($this->period) {
                'month' => $date->format('m/Y'),
                default => $date->format('d/m/Y'),
            };

            $high[] = $items->firstWhere('priority', 'high')->total ?? 0;
            $medium[] = $items->firstWhere('priority', 'medium')->total ?? 0;
            $low[] = $items->firstWhere('priority', 'low')->total ?? 0;
        }

        return [
            'labels' => $labels,
            'high' => $high,
            'medium' => $medium,
            'low' => $low,
        ];
    }
}

