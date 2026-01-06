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
</div>
