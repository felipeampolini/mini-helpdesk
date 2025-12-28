@props(['priority'])

@php
    $map = [
        'high' => [
            'label' => 'Alta',
            'class' => 'bg-red-100 text-red-800',
        ],
        'medium' => [
            'label' => 'Média',
            'class' => 'bg-amber-200 text-amber-900',
        ],
        'low' => [
            'label' => 'Baixa',
            'class' => 'bg-blue-100 text-blue-800',
        ],
    ];

    $priorityData = $map[$priority] ?? [
        'label' => ucfirst($priority),
        'class' => 'bg-gray-100 text-gray-800',
    ];
@endphp

<span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $priorityData['class'] }}">
    {{ $priorityData['label'] }}
</span>
