<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="mb-4">
        <!-- Row 1: filtros principais -->
        <div class="flex flex-wrap gap-4 items-end">

            <!-- Busca por título -->
            <div class="flex flex-col flex-1 min-w-[150px]">
                <label for="search" class="text-sm font-medium mb-1">{{ __('ticket.search_ticket') }}:</label>
                <input id="search" type="text"
                    wire:model="search" wire:key="search-input-{{ $search }}"
                    placeholder="Digite um título"
                    class="border rounded px-3 py-2 w-full">
            </div>

            <!-- Filtro de dono -->
            <div class="flex flex-col flex-1 min-w-[150px]">
                <label for="owner" class="text-sm font-medium mb-1">{{ __('ticket.search_owner') }}:</label>
                <input id="owner" type="text"
                    wire:model="owner" wire:key="owner-input-{{ $owner }}"
                    placeholder="Digite um nome"
                    class="border rounded px-3 py-2 w-full">
            </div>

            <!-- Filtro de status -->
            <div class="flex flex-col flex-1 min-w-[120px]">
                <label for="filterStatus" class="text-sm font-medium mb-1">{{ __('ticket.filter_status') }}:</label>
                <select id="filterStatus" wire:model="filterStatus" wire:key="filter-status-{{ $filterStatus }}"
                    class="border rounded px-3 py-2 w-full">
                    <option value="">{{ __('ticket.status_all') }}</option>
                    <option value="open">{{ __('ticket.status_open') }}</option>
                    <option value="in_progress">{{ __('ticket.status_in_progress') }}</option>
                    <option value="closed">{{ __('ticket.status_closed') }}</option>
                </select>
            </div>

            <!-- Filtro de prioridade -->
            <div class="flex flex-col flex-1 min-w-[120px]">
                <label for="filterPriority" class="text-sm font-medium mb-1">{{ __('ticket.filter_priority') }}:</label>
                <select id="filterPriority" wire:model="filterPriority" wire:key="filter-priority-{{ $filterPriority }}"
                    class="border rounded px-3 py-2 w-full">
                    <option value="">{{ __('ticket.priority_all') }}</option>
                    <option value="low">{{ __('ticket.priority_low') }}</option>
                    <option value="medium">{{ __('ticket.priority_medium') }}</option>
                    <option value="high">{{ __('ticket.priority_high') }}</option>
                </select>
            </div>

        </div>

        <!-- Row 2: filtros de datas + botões -->
        <div class="flex flex-wrap gap-4 items-end mt-2">

            <!-- Filtro de data: De -->
            <div class="flex flex-col flex-1 min-w-[180px]">
                <label for="dateFrom" class="text-sm font-medium mb-1">{{ __('ticket.create_date_from') }}:</label>
                <input id="dateFrom" type="datetime-local"
                    wire:model="dateFrom" wire:key="date-from-{{ $dateFrom }}"
                    class="border rounded px-3 py-2 w-full">
            </div>

            <!-- Filtro de data: Até -->
            <div class="flex flex-col flex-1 min-w-[180px]">
                <label for="dateTo" class="text-sm font-medium mb-1">{{ __('ticket.create_date_to') }}:</label>
                <input id="dateTo" type="datetime-local"
                    wire:model="dateTo" wire:key="date-to-{{ $dateTo }}"
                    class="border rounded px-3 py-2 w-full">
            </div>

            <!-- Botões -->
            <div class="flex gap-2 ml-auto mt-2 sm:mt-0">
                <button type="button"
                    wire:click="clearSearch"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 whitespace-nowrap">
                    {{ __('ticket.clean_search') }}
                </button>

                <button type="button"
                    wire:click="searchTickets"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 whitespace-nowrap">
                    🔍 {{ __('ticket.search') }}
                </button>
            </div>

        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th wire:click="sortBy('id')" class="py-2 px-4 border-b text-left cursor-pointer">
                        {{ __('ticket.id') }}
                        @if($sortField === 'id') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                    </th>
                    <th wire:click="sortBy('title')" class="py-2 px-4 border-b text-left cursor-pointer">
                        {{ __('ticket.title') }}
                        @if($sortField === 'title') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                    </th>
                    <th wire:click="sortBy('status')" class="py-2 px-4 border-b text-center cursor-pointer">
                        {{ __('ticket.status') }}
                        @if($sortField === 'status') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                    </th>
                    <th wire:click="sortBy('priority')" class="py-2 px-4 border-b text-center cursor-pointer">
                        {{ __('ticket.priority') }}
                        @if($sortField === 'priority') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                    </th>
                    <th wire:click="sortBy('owner')" class="py-2 px-4 border-b text-center cursor-pointer">
                        {{ __('ticket.owner') }}
                        @if($sortField === 'owner') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                    </th>
                    <th wire:click="sortBy('created_at')" class="py-2 px-4 border-b text-center cursor-pointer">
                        {{ __('ticket.created_at') }}
                        @if($sortField === 'created_at') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                    </th>
                    <th class="py-2 px-4 border-b text-center">{{ __('ticket.actions') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tickets as $ticket)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b text-left">{{ $ticket->id }}</td>
                        <td class="py-2 px-4 border-b text-left">{{ $ticket->title }}</td>
                        <td class="py-2 px-4 border-b text-center"><x-ticket-status :status="$ticket->status" /></td>
                        <td class="py-2 px-4 border-b text-center"><x-ticket-priority :priority="$ticket->priority" /></td>
                        <td class="py-2 px-4 border-b text-left">{{ $ticket->user->name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:underline mr-2">
                                Ver
                            </a>
                            @can('update', $ticket)
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-green-500 hover:underline">
                                    Editar
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tickets->links('vendor.pagination.custom') }}
    </div>
</div>
