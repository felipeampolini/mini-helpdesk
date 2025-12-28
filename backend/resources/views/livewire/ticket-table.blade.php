<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <div class="mb-4">
        <!-- Row 1: filtros principais -->
        <div class="flex flex-wrap gap-4 items-end">

            <!-- Busca por título -->
            <div class="flex flex-col flex-1 min-w-[150px]">
                <label for="search" class="text-sm font-medium mb-1">Buscar tickets:</label>
                <input id="search" type="text"
                    wire:model="search" wire:key="search-input-{{ $search }}"
                    placeholder="Digite um título"
                    class="border rounded px-3 py-2 w-full">
            </div>

            <!-- Filtro de status -->
            <div class="flex flex-col flex-1 min-w-[120px]">
                <label for="filterStatus" class="text-sm font-medium mb-1">Status:</label>
                <select id="filterStatus" wire:model="filterStatus" wire:key="filter-status-{{ $filterStatus }}"
                    class="border rounded px-3 py-2 w-full">
                    <option value="">Todos os status</option>
                    <option value="open">Aberto</option>
                    <option value="in_progress">Em andamento</option>
                    <option value="closed">Fechado</option>
                </select>
            </div>

            <!-- Filtro de prioridade -->
            <div class="flex flex-col flex-1 min-w-[120px]">
                <label for="filterPriority" class="text-sm font-medium mb-1">Prioridade:</label>
                <select id="filterPriority" wire:model="filterPriority" wire:key="filter-priority-{{ $filterPriority }}"
                    class="border rounded px-3 py-2 w-full">
                    <option value="">Todas as prioridades</option>
                    <option value="low">Baixa</option>
                    <option value="medium">Média</option>
                    <option value="high">Alta</option>
                </select>
            </div>

            <!-- Filtro de dono -->
            <div class="flex flex-col flex-1 min-w-[150px]">
                <label for="owner" class="text-sm font-medium mb-1">Dono:</label>
                <input id="owner" type="text"
                    wire:model="owner" wire:key="owner-input-{{ $owner }}"
                    placeholder="Digite um título"
                    class="border rounded px-3 py-2 w-full">
            </div>

        </div>

        <!-- Row 2: filtros de datas + botões -->
        <div class="flex flex-wrap gap-4 items-end mt-2">

            <!-- Filtro de data: De -->
            <div class="flex flex-col flex-1 min-w-[180px]">
                <label for="dateFrom" class="text-sm font-medium mb-1">Criado de:</label>
                <input id="dateFrom" type="datetime-local"
                    wire:model="dateFrom" wire:key="date-from-{{ $dateFrom }}"
                    class="border rounded px-3 py-2 w-full">
            </div>

            <!-- Filtro de data: Até -->
            <div class="flex flex-col flex-1 min-w-[180px]">
                <label for="dateTo" class="text-sm font-medium mb-1">Criado até:</label>
                <input id="dateTo" type="datetime-local"
                    wire:model="dateTo" wire:key="date-to-{{ $dateTo }}"
                    class="border rounded px-3 py-2 w-full">
            </div>

            <!-- Botões -->
            <div class="flex gap-2 ml-auto items-end h-full mt-5">
                <button type="button"
                        wire:click="clearSearch"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    Limpar
                </button>

                <button type="button"
                        wire:click="searchTickets"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    🔍 Buscar
                </button>
            </div>

        </div>
    </div>

    <table class="w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th wire:click="sortBy('title')" class="py-2 px-4 border-b text-left cursor-pointer">
                    Título
                    @if($sortField === 'title') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                </th>
                <th wire:click="sortBy('status')" class="py-2 px-4 border-b text-center cursor-pointer">
                    Status
                    @if($sortField === 'status') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                </th>
                <th wire:click="sortBy('priority')" class="py-2 px-4 border-b text-center cursor-pointer">
                    Prioridade
                    @if($sortField === 'priority') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                </th>
                <th wire:click="sortBy('owner')" class="py-2 px-4 border-b text-center cursor-pointer">
                    Dono
                    @if($sortField === 'owner') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                </th>
                <th wire:click="sortBy('created_at')" class="py-2 px-4 border-b text-center cursor-pointer">
                    Criado em
                    @if($sortField === 'created_at') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif
                </th>
                <th class="py-2 px-4 border-b text-center">Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border-b text-left">
                        {{ $ticket->title }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        <x-ticket-status :status="$ticket->status" />
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        <x-ticket-priority :priority="$ticket->priority" />
                    </td>
                    <td class="py-2 px-4 border-b text-left">
                        {{ $ticket->user->name }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </td>
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

    <div class="mt-4">
        {{ $tickets->links('vendor.pagination.custom') }}
    </div>
</div>
