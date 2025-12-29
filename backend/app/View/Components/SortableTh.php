<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SortableTh extends Component
{
    public string $label;
    public string $field;
    public ?string $sortField;
    public ?string $sortDirection;

    public function __construct(
        string $label,
        string $field,
        ?string $sortField = null,
        ?string $sortDirection = null
    ) {
        $this->label = $label;
        $this->field = $field;
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
    }

    public function render(): View|Closure|string
    {
        return view('components.sortable-th');
    }
}
