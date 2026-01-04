<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:text-blue-800">{{ __('ticket.tickets') }}</a> > {{ __('ticket.ticket') }} #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:ticket-show :ticket="$ticket" />
        </div>
    </div>
</x-app-layout>
