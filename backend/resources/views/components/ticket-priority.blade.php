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

<span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $priorityData['class'] }}">
    {{ __('ticket.priority_'.$priority) }}
</span>
