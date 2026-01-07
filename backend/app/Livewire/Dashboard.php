<?php

namespace App\Livewire;

use App\Models\Ticket;
use Carbon\Carbon;
use DB;
use Livewire\Component;

class Dashboard extends Component
{
    public string $periodBarPriorityChart = 'day'; // day | month
    public string $periodBarStatusChart = 'day'; // day | month
    public array $barPriorityChartData = [];
    public array $barStatusChartData = [];

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

    public function loadBarPriorityChartData()
    {
        $user = auth()->user();

        $periodExpression = match ($this->periodBarPriorityChart) {
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

        $this->barPriorityChartData = $this->normalizeBarPriorityChartData($rows);
    }

    public function loadBarStatusChartData()
    {
        $user = auth()->user();

        $periodExpression = match ($this->periodBarStatusChart) {
            'month' => "DATE_TRUNC('month', created_at)",
            default => "DATE(created_at)",
        };

        $query = Ticket::query()
            ->selectRaw("$periodExpression as period, status, count(*) as total");

        if ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        $rows = $query
            ->groupByRaw("$periodExpression, status")
            ->orderByRaw($periodExpression)
            ->get();

        $this->barStatusChartData = $this->normalizeBarStatusChartData($rows);
    }

    protected function refreshCharts()
    {
        $this->loadBarPriorityChartData();
        $this->loadBarStatusChartData();
        $this->dispatch('barPriorityChart-updated', barPriorityChartData: $this->barPriorityChartData);
        $this->dispatch('barStatusChart-updated', barStatusChartData: $this->barStatusChartData);
    }

    public function mount()
    {
        $this->refreshCharts();
    }

    public function updatedPeriodBarPriorityChart()
    {
        $this->refreshCharts();
    }

    public function updatedPeriodBarStatusChart()
    {
        $this->refreshCharts();
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

    private function normalizeBarPriorityChartData($rows)
    {
        $labels = [];
        $high = [];
        $medium = [];
        $low = [];

        $grouped = $rows->groupBy(fn ($row) => $row->period);

        foreach ($grouped as $periodBarPriorityChart => $items) {

            $date = Carbon::parse($periodBarPriorityChart);

            $labels[] = match ($this->periodBarPriorityChart) {
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

    private function normalizeBarStatusChartData($rows)
    {
        $labels = [];
        $open = [];
        $closed = [];

        $grouped = $rows->groupBy(fn ($row) => $row->period);

        foreach ($grouped as $periodBarStatusChart => $items) {
            $date = Carbon::parse($periodBarStatusChart);

            $labels[] = match ($this->periodBarStatusChart) {
                'month' => $date->format('M/Y'),
                default => $date->format('d/m/Y'),
            };

            $open[] = $items->firstWhere('status', 'open')->total ?? 0;
            $closed[] = $items->firstWhere('status', 'closed')->total ?? 0;
        }

        return [
            'labels' => $labels,
            'open' => $open,
            'closed' => $closed,
        ];
    }
}

