@props(['status'])

@php
    $map = [
        'open' => [
            'label' => 'Aberto',
            'class' => 'bg-green-100 text-green-800',
        ],
        'in_progress' => [
            'label' => 'Em andamento',
            'class' => 'bg-yellow-200 text-yellow-900',
        ],
        'closed' => [
            'label' => 'Fechado',
            'class' => 'bg-gray-100 text-gray-800',
        ],
    ];

    $statusData = $map[$status] ?? [
        'label' => ucfirst($status),
        'class' => 'bg-gray-100 text-gray-800',
    ];
@endphp

<span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $statusData['class'] }}">
    {{ $statusData['label'] }}
</span>
