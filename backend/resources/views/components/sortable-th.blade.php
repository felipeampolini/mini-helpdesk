<span class="inline-flex items-center gap-1 select-none">
    {{ $label }}

    @if ($sortField === $field)
        @if ($sortDirection === 'asc')
            <x-heroicon-o-chevron-up class="w-4 h-4 ml-2" />
        @else
            <x-heroicon-o-chevron-down class="w-4 h-4 ml-2" />
        @endif
    @else
        <x-heroicon-o-chevron-up-down class="w-4 h-4 opacity-50 ml-2" />
    @endif
</span>
