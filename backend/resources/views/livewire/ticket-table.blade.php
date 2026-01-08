<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="mb-4 flex items-center gap-2">
        @can('create', App\Models\Ticket::class)
            <x-success-button x-data x-on:click="$dispatch('open-modal', 'new-ticket-modal')">
                <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                {{ __('ticket.new_ticket') }}
            </x-success-button>
        @endcan
        <x-secondary-button x-data x-on:click="$dispatch('open-modal', 'filters-modal')" >
            <x-heroicon-o-funnel class="w-5 h-5 mr-2" />
            {{ __('ticket.filters') }}
            @if ($this->activeFiltersCount > 0)
                ({{ $this->activeFiltersCount }})
            @endif
        </x-secondary-button>
        <x-danger-button wire:click="clearSearch">
            <x-heroicon-o-trash class="w-5 h-5 mr-2" />
            {{ __('ticket.clean_search') }}
        </x-danger-button>
    </div>

    <div class="relative">
        <div
            wire:loading.delay
            wire:target="search, owner, filterStatus, filterPriority, dateFrom, dateTo, sortBy, clearSearch, page"
            class="absolute inset-0 z-20 flex items-center justify-center bg-gray-900/30"
        >
            <div class="flex flex-col items-center justify-center gap-3
                        bg-white/90 backdrop-blur
                        px-6 py-4 rounded-lg shadow-lg
                        text-center max-w-max mx-auto my-auto mt-4">
                <x-heroicon-o-arrow-path class="w-6 h-6 animate-spin text-gray-700" />
                <span class="text-sm font-medium text-gray-700">
                    {{ __('ticket.loading') }}
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th wire:click="sortBy('id')" class="py-2 px-4 border-b text-left cursor-pointer">
                            <x-sortable-th
                                label="{{ __('ticket.id') }}"
                                field="id"
                                :sortField="$sortField"
                                :sortDirection="$sortDirection"
                            />
                        </th>
                        <th wire:click="sortBy('title')" class="py-2 px-4 border-b text-left cursor-pointer">
                            <x-sortable-th
                                label="{{ __('ticket.title') }}"
                                field="title"
                                :sortField="$sortField"
                                :sortDirection="$sortDirection"
                            />
                        </th>
                        <th wire:click="sortBy('status')" class="py-2 px-4 border-b text-center cursor-pointer">
                            <x-sortable-th
                                label="{{ __('ticket.status') }}"
                                field="status"
                                :sortField="$sortField"
                                :sortDirection="$sortDirection"
                            />
                        </th>
                        <th wire:click="sortBy('priority')" class="py-2 px-4 border-b text-center cursor-pointer">
                            <x-sortable-th
                                label="{{ __('ticket.priority') }}"
                                field="priority"
                                :sortField="$sortField"
                                :sortDirection="$sortDirection"
                            />
                        </th>
                        <th wire:click="sortBy('owner')" class="py-2 px-4 border-b text-center cursor-pointer">
                            <x-sortable-th
                                label="{{ __('ticket.owner') }}"
                                field="owner"
                                :sortField="$sortField"
                                :sortDirection="$sortDirection"
                            />
                        </th>
                        <th wire:click="sortBy('created_at')" class="py-2 px-4 border-b text-center cursor-pointer">
                            <x-sortable-th
                                label="{{ __('ticket.created_at') }}"
                                field="created_at"
                                :sortField="$sortField"
                                :sortDirection="$sortDirection"
                            />
                        </th>
                        <th class="py-2 px-4 border-b text-center">{{ __('ticket.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-gray-100" wire:key="item-{{ $ticket->id }}">
                            <td class="py-2 px-4 border-b text-left">{{ $ticket->id }}</td>
                            <td class="py-2 px-4 border-b text-left">{{ $ticket->title }}</td>
                            <td class="py-2 px-4 border-b text-center"><x-ticket-status :status="$ticket->status" /></td>
                            <td class="py-2 px-4 border-b text-center"><x-ticket-priority :priority="$ticket->priority" /></td>
                            <td class="py-2 px-4 border-b text-left">{{ $ticket->user->name }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <span class="flex flex-row justify-center">
                                    <a title="{{ __('ticket.access_ticket') }}" href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:text-blue-800 mr-2">
                                        <x-heroicon-s-eye class="w-5 h-5" />
                                    </a>
                                    @can('update', $ticket)
                                    <a title="{{ __('ticket.edit') }}" href="{{ route('tickets.edit', $ticket->id) }}" class="text-blue-500 hover:text-blue-800 mr-2">
                                        <x-heroicon-s-pencil class="w-5 h-5" />
                                    </a>
                                    @endcan
                                    @can('changeStatus', $ticket)
                                        @if ($ticket->status === 'open')
                                            <a title="{{ __('ticket.start_ticket') }}" wire:click="startTicket({{ $ticket->id }})" class="text-green-500 hover:text-green-800 mr-2">
                                                <x-heroicon-s-play class="w-5 h-5" />
                                            </a>
                                        @endif

                                        @if ($ticket->status === 'in_progress')
                                            <a title="{{ __('ticket.close_ticket') }}" wire:click="closeTicket({{ $ticket->id }})" class="text-red-500 hover:text-red-800 mr-2">
                                                <x-heroicon-s-lock-closed class="w-5 h-5" />
                                            </a>
                                        @endif

                                        @if ($ticket->status === 'closed')
                                            <a title="{{ __('ticket.reopen_ticket') }}" wire:click="reopenTicket({{ $ticket->id }})" class="text-amber-500 hover:text-amber-800 mr-2">
                                                <x-heroicon-s-arrow-path class="w-5 h-5" />
                                            </a>
                                        @endif
                                    @endcan
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $tickets->links('vendor.pagination.custom') }}
    </div>

    <livewire:ticket-create-modal />

    <x-modal name="filters-modal" focusable>
        <div class="p-6 space-y-4">

            <span class="inline-flex items-center gap-1 select-none">
                <x-heroicon-o-funnel class="w-5 h-5 mr-2" />
                <h2 class="text-lg font-medium text-gray-900 flex">
                    {{ __('ticket.filters') }}
                </h2>
            </span>

            <!-- Busca por título -->
            <div class="flex flex-col mt-2">
                <x-input-label for="search" :value="__('ticket.search_ticket')" />
                <x-text-input
                    id="search"
                    wire:model="search"
                    class="block mt-1 w-full"
                    :placeholder="__('ticket.search_ticket_placeholder')" />
            </div>

            <!-- Dono -->
            <div class="flex flex-col mt-2">
                <x-input-label for="owner" :value="__('ticket.search_owner')" />
                <x-text-input
                    id="owner"
                    wire:model="owner"
                    class="block mt-1 w-full"
                    :placeholder="__('ticket.search_owner_placeholder')" />
            </div>

            <!-- Status -->
            <div class="flex flex-col mt-2" x-data="{ selected: @entangle('filterStatus') }">
                <x-input-label :value="__('ticket.filter_status')" />

                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button type="button" class="border rounded px-3 py-2 w-full text-left">
                            <span
                                x-text="
                                    selected === 'open' ? '{{ __('ticket.status_open') }}' :
                                    selected === 'in_progress' ? '{{ __('ticket.status_in_progress') }}' :
                                    selected === 'closed' ? '{{ __('ticket.status_closed') }}' :
                                    '{{ __('ticket.status_all') }}'
                                "
                            ></span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="#" @click.prevent="selected = ''">
                            <x-ticket-status :status="'all'" />
                        </x-dropdown-link>
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

            <!-- Prioridade -->
            <div class="flex flex-col mt-2" x-data="{ selected: @entangle('filterPriority') }">
                <x-input-label :value="__('ticket.filter_priority')" />

                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button type="button" class="border rounded px-3 py-2 w-full text-left">
                            <span
                                x-text="
                                    selected === 'high' ? '{{ __('ticket.priority_high') }}' :
                                    selected === 'medium' ? '{{ __('ticket.priority_medium') }}' :
                                    selected === 'low' ? '{{ __('ticket.priority_low') }}' :
                                    '{{ __('ticket.priority_all') }}'
                                "
                            ></span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="#" @click.prevent="selected = ''">
                            <x-ticket-priority :priority="'all'" />
                        </x-dropdown-link>
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

            <!-- Datas -->
            <div class="flex flex-col mt-2">
                <x-input-label for="dateFrom" :value="__('ticket.create_date_from')" />
                <x-text-input
                    id="dateFrom"
                    type="datetime-local"
                    wire:model="dateFrom"
                    class="block w-full" />
            </div>

            <div class="flex flex-col mt-2">
                <x-input-label for="dateTo" :value="__('ticket.create_date_to')" />
                <x-text-input
                    id="dateTo"
                    type="datetime-local"
                    wire:model="dateTo"
                    class="block w-full" />
            </div>

            <!-- Ações -->
            <div class="flex justify-end gap-2 pt-4">
                <x-secondary-button
                    x-on:click="$dispatch('close')"
                >
                    {{ __('ticket.close') }}
                </x-secondary-button>

                <x-primary-button
                    wire:click="searchTickets"
                    x-on:click="$dispatch('close')"
                >
                    <x-heroicon-o-magnifying-glass class="w-5 h-5 mr-2" /> {{ __('ticket.search') }}
                </x-primary-button>
            </div>

        </div>
    </x-modal>

</div>
