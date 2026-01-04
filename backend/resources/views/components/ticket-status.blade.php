@props(['status', 'size', 'margin'])

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

    $sizeData = $size ?? 'text-xs';
    $marginData = $margin ?? '';
@endphp

<span class="inline-flex items-center rounded-full px-2 py-0.5 font-medium {{ $sizeData }} {{ $marginData }} {{ $statusData['class'] }}">
    {{ __('ticket.status_'.$status) }}
</span>
