@props(['priority'])

@php
    $map = [
        'high' => [
            'class' => 'bg-red-100 text-red-800',
        ],
        'medium' => [
            'class' => 'bg-amber-200 text-amber-900',
        ],
        'low' => [
            'class' => 'bg-blue-100 text-blue-800',
        ],
    ];

    $priorityData = $map[$priority] ?? [
        'class' => 'bg-gray-100 text-gray-800',
    ];
@endphp

<div class="flex flex-col mt-2" x-data="{ selected: @entangle($attributes->wire('model')) }">
    <x-input-label :value="__('ticket.filter_priority')" />
    <x-dropdown align="left" width="48">
        <x-slot name="trigger">
            <button type="button" class="border rounded px-3 py-2 w-full text-left flex">
                <span
                    x-text="
                        selected === 'high' ? '{{ __('ticket.priority_high') }}' :
                        selected === 'medium' ? '{{ __('ticket.priority_medium') }}' :
                        selected === 'low' ? '{{ __('ticket.priority_low') }}' :
                        '{{ __('ticket.priority_'.$priority) }}'
                    "
                ></span>
                <x-heroicon-o-chevron-down class="w-4 h-4 mt-1 ml-2" />
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link href="#" @click.prevent="selected = 'high'">
                <x-ticket-priority :priority="'high'" />
            </x-dropdown-link>
            <x-dropdown-link href="#" @click.prevent="selected = 'medium'">
                <x-ticket-priority :priority="'medium'" />
            </x-dropdown-link>
            <x-dropdown-link href="#" @click.prevent="selected = 'low'">
                <x-ticket-priority :priority="'low'" />
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>
</div>

