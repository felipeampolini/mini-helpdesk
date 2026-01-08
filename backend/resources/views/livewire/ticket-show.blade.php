<div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
            <div class="flex items-center gap-2">
                <x-ticket-status :status="$ticket->status" :size="'text-s'" />
                <x-ticket-priority :priority="$ticket->priority" :size="'text-s'" />
            </div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $ticket->title }}</h1>
        </div>

        <div class="flex md:justify-end mt-2 md:mt-0 gap-2">
            @can('changeStatus', $ticket)
                @if ($ticket->status === 'open')
                    <x-success-button
                        wire:click="startTicket"
                        wire:loading.attr="disabled"
                    >
                        <x-heroicon-o-play class="w-5 h-5 mr-2" />
                        {{ __('ticket.start_ticket') }}
                    </x-success-button>
                @endif

                @if ($ticket->status === 'in_progress')
                    <x-danger-button
                        wire:click="closeTicket"
                        wire:loading.attr="disabled"
                    >
                        <x-heroicon-o-check class="w-5 h-5 mr-2" />
                        {{ __('ticket.close_ticket') }}
                    </x-danger-button>
                @endif

                @if ($ticket->status === 'closed')
                    <x-warning-button
                        wire:click="reopenTicket"
                        wire:loading.attr="disabled"
                    >
                        <x-heroicon-o-arrow-path class="w-5 h-5 mr-2" />
                        {{ __('ticket.reopen_ticket') }}
                    </x-warning-button>
                @endif
            @endcan
            <x-secondary-button wire:click="edit" wire:loading.attr="disabled">
                <x-heroicon-o-pencil class="w-5 h-5 mr-2" />
                {{ __('ticket.edit') }}
            </x-secondary-button>
        </div>
    </div>

    <!-- Ticket Info -->
    <div class="bg-white shadow rounded p-6 space-y-4">
        <h2 class="text-lg font-semibold mb-4">{{ __('ticket.description') }}</h2>
        <p class="text-gray-700"> {{ $ticket->description }}</p>
    </div>

    <div class="bg-white shadow rounded p-6 flex flex-row">
        <p class="text-gray-700 text-sm mr-4"><strong>{{ __('ticket.created_by') }}:</strong> {{ $ticket->user->name }}</p>
        <p class="text-gray-500 text-sm mr-4"><strong>{{ __('ticket.created_at') }}:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
        @if ($ticket->created_at <  $ticket->updated_at)
            <p class="text-gray-500 text-sm"><strong>{{ __('ticket.updated_at') }}:</strong> {{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
        @endif
    </div>

    <div class="bg-white shadow rounded p-6">
        <livewire:ticket-comments :ticket="$ticket" :showHeader="true" :allowComment="true" />
    </div>

</div>
