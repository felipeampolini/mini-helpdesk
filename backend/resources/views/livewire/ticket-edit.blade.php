<div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="flex flex-col self-start">
                <x-input-label :value="__('ticket.filter_status')" />
                @can('changeStatus', $ticket)
                    <x-edit-ticket-status wire:model.defer="status" :status="$ticket->status" :size="'text-s'" />
                @else
                    <x-ticket-status :status="$ticket->status" :size="'text-s'" />
                @endcan
            </div>
            <div class="flex flex-col self-start">
                <x-input-label :value="__('ticket.filter_priority')" />
                @can('changePriority', $ticket)
                    <x-edit-ticket-priority wire:model.defer="priority" :priority="$ticket->priority" :size="'text-s'" />
                @else
                    <x-ticket-priority :priority="$ticket->priority" :size="'text-s'" />
                @endcan
            </div>
            <div class="flex flex-col self-start">
                <x-input-label :value="__('ticket.title')" />
                <x-text-input
                    id="title"
                    wire:model.defer="title"
                    class="block w-full md:w-96"
                    placeholder="{{ __('ticket.title_placeholder') }}"
                    value="{{ $ticket->title }}" />
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex md:justify-end mt-2 md:mt-0">
            <x-primary-button wire:click="save" wire:loading.attr="disabled">
                <x-heroicon-o-check class="w-5 h-5 mr-2" />
                {{ __('ticket.save') }}
            </x-primary-button>
        </div>
    </div>

    <!-- Ticket Info -->
    <div class="bg-white shadow rounded p-6 space-y-4">
        <strong>{{ __('ticket.description') }}</strong>
        <x-textarea
            id="description"
            wire:model.defer="description"
            rows="4"
            class="block mt-1 w-full border rounded p-2"
            placeholder="{{ __('ticket.description_placeholder') }}">{{ $ticket->description }}</x-textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="bg-white shadow rounded p-6 flex flex-row">
        <p class="text-gray-700 text-sm mr-4"><strong>{{ __('ticket.created_by') }}:</strong> {{ $ticket->user->name }}</p>
        <p class="text-gray-500 text-sm mr-4"><strong>{{ __('ticket.created_at') }}:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
        @if ($ticket->created_at <  $ticket->updated_at)
            <p class="text-gray-500 text-sm"><strong>{{ __('ticket.updated_at') }}:</strong> {{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
        @endif
    </div>

    {{-- <div class="bg-white shadow rounded p-6">
        <h2 class="text-lg font-semibold mb-4">Comentários</h2>
        <p class="text-gray-500">Aqui virá o componente de comentários Livewire.</p>
    </div> --}}

</div>
