@props(['status'])

@php
    $map = [
        'open' => [
            'class' => 'bg-green-100 text-green-800',
        ],
        'in_progress' => [
            'class' => 'bg-yellow-200 text-yellow-900',
        ],
        'closed' => [
            'class' => 'bg-gray-100 text-gray-800',
        ],
    ];

    $statusData = $map[$status] ?? [
        'class' => 'bg-gray-100 text-gray-800',
    ];
@endphp

<div class="flex flex-col mt-2" x-data="{ selected: @entangle($attributes->wire('model')) }">
    <x-input-label :value="__('ticket.filter_status')" />
    <x-dropdown align="left" width="48">
        <x-slot name="trigger">
            <button type="button" class="border rounded px-3 py-2 w-full text-left flex">
                <span
                    x-text="
                        selected === 'open' ? '{{ __('ticket.status_open') }}' :
                        selected === 'in_progress' ? '{{ __('ticket.status_in_progress') }}' :
                        selected === 'closed' ? '{{ __('ticket.status_closed') }}' :
                        '{{ __('ticket.status_'.$status) }}'
                    "
                ></span>
                <x-heroicon-o-chevron-down class="w-4 h-4 mt-1 ml-2" />
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link href="#" @click.prevent="selected = 'open'">
                <x-ticket-status :status="'open'" />
            </x-dropdown-link>
            <x-dropdown-link href="#" @click.prevent="selected = 'in_progress'">
                <x-ticket-status :status="'in_progress'" />
            </x-dropdown-link>
            <x-dropdown-link href="#" @click.prevent="selected = 'closed'">
                <x-ticket-status :status="'closed'" />
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>
</div>

