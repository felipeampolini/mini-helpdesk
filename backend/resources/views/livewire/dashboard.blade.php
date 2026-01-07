<div> <!-- wire:poll.30s -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-card
            title="{{ __('dashboard.open') }}"
            :value="$stats['open']->sum('total')"
            class="bg-green-100 text-green-800"
        >
            <ul class="mt-3 text-sm space-y-1">
                <li><x-badge class="bg-red-100 text-red-800">{{ __('dashboard.priority_high') }}: {{ $stats['open']->firstWhere('priority', 'high')->total ?? 0 }}</x-badge></li>
                <li><x-badge class="bg-amber-200 text-amber-900">{{ __('dashboard.priority_medium') }}: {{ $stats['open']->firstWhere('priority', 'medium')->total ?? 0 }}</x-badge></li>
                <li><x-badge class="bg-blue-100 text-blue-800">{{ __('dashboard.priority_low') }}: {{ $stats['open']->firstWhere('priority', 'low')->total ?? 0 }}</x-badge></li>
            </ul>
        </x-card>

        <x-card
            title="{{ __('dashboard.in_progress') }}"
            :value="$stats['in_progress']->sum('total')"
            class="bg-yellow-100 text-yellow-800"
        >
            <ul class="mt-3 text-sm space-y-1">
                <li><x-badge class="bg-red-100 text-red-800">{{ __('dashboard.priority_high') }}: {{ $stats['in_progress']->firstWhere('priority', 'high')->total ?? 0 }}</x-badge></li>
                <li><x-badge class="bg-amber-200 text-amber-900">{{ __('dashboard.priority_medium') }}: {{ $stats['in_progress']->firstWhere('priority', 'medium')->total ?? 0 }}</x-badge></li>
                <li><x-badge class="bg-blue-100 text-blue-800">{{ __('dashboard.priority_low') }}: {{ $stats['in_progress']->firstWhere('priority', 'low')->total ?? 0 }}</x-badge></li>
            </ul>
        </x-card>

        <x-card
            title="{{ __('dashboard.closed') }}"
            :value="$stats['closed']->sum('total')"
            class="bg-gray-50 text-gray-600"
        >
            <ul class="mt-3 text-sm space-y-1">
                <li><x-badge class="bg-red-100 text-red-800">{{ __('dashboard.priority_high') }}: {{ $stats['closed']->firstWhere('priority', 'high')->total ?? 0 }}</x-badge></li>
                <li><x-badge class="bg-amber-200 text-amber-900">{{ __('dashboard.priority_medium') }}: {{ $stats['closed']->firstWhere('priority', 'medium')->total ?? 0 }}</x-badge></li>
                <li><x-badge class="bg-blue-100 text-blue-800">{{ __('dashboard.priority_low') }}: {{ $stats['closed']->firstWhere('priority', 'low')->total ?? 0 }}</x-badge></li>
            </ul>
        </x-card>

    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-lg shadow mt-6">
            <div class="text-sm text-gray-500">
                {{ __('dashboard.tickets_created_by') }}:
                <button wire:click="$set('period', 'day')" class="ml-2 btn px-2 py-1 rounded-full {{ $period == 'day' ? 'bg-white shadow-sm' : 'bg-gray-100 shadow-md' }}">{{ __('dashboard.days') }}</button>
                <button wire:click="$set('period', 'month')" class="btn px-2 py-1 rounded-full {{ $period == 'month' ? 'bg-white shadow-sm' : 'bg-gray-100 shadow-md' }}">{{ __('dashboard.months') }}</button>
            </div>
            <div wire:ignore class="relative w-full mt-1">
                <canvas id="ticketsChart"></canvas>
            </div>
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                let ticketsChart;

                function bootChart(data) {

                    const el = document.getElementById('ticketsChart');
                    if (!el) return;

                    if (ticketsChart) {
                        ticketsChart.destroy();
                    }

                    ticketsChart = new Chart(el, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: '{{ __("dashboard.priority_high") }}',
                                    data: data.high,
                                    backgroundColor: 'rgba(254, 226, 226, 0.9)', // red-100
                                    borderColor: 'rgb(153, 27, 27)', // red-800
                                    borderWidth: 1,
                                },
                                {
                                    label: '{{ __("dashboard.priority_medium") }}',
                                    data: data.medium,
                                    backgroundColor: 'rgba(253, 230, 138, 0.9)', // amber-200
                                    borderColor: 'rgb(120, 53, 15)', // amber-900
                                    borderWidth: 1,
                                },
                                {
                                    label: '{{ __("dashboard.priority_low") }}',
                                    data: data.low,
                                    backgroundColor: 'rgba(219, 234, 254, 0.9)', // blue-100
                                    borderColor: 'rgb(30, 64, 175)', // blue-800
                                    borderWidth: 1,
                                },
                            ]
                        },
                        options : {
                            scales: {
                                x: {
                                    stacked: true,
                                },
                                y: {
                                    stacked: true
                                }
                            }
                        }
                    });
                }

                document.addEventListener('livewire:init', () => {
                    Livewire.on('chart-updated', (payload) => {
                        bootChart(payload.chartData);
                    });
                });

            </script>
        @endpush
    </div>
</div>
