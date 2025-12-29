<div>
    <x-modal name="new-ticket-modal" focusable>
        <div class="p-6 space-y-4">

            <span class="inline-flex items-center gap-1 select-none">
                <h2 class="text-lg font-medium text-gray-900 flex">
                    {{ __('ticket.new_ticket') }}
                </h2>
            </span>

            <!-- Título -->
            <div class="flex flex-col mt-2">
                <x-input-label for="title" :value="__('ticket.title')" />
                <x-text-input
                    id="title"
                    wire:model.defer="title"
                    class="block mt-1 w-full"
                    placeholder="{{ __('ticket.title_placeholder') }}" />
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descrição -->
            <div class="flex flex-col mt-2">
                <x-input-label for="description" :value="__('ticket.description')" />
                <x-textarea
                    id="description"
                    wire:model.defer="description"
                    rows="4"
                    class="block mt-1 w-full border rounded p-2"
                    placeholder="{{ __('ticket.description_placeholder') }}"></x-textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prioridade -->
            <div class="flex flex-col mt-2">
                <x-input-label :value="__('ticket.priority')" for="priority" />

                <x-select
                    id="priority"
                    wire:model.defer="priority"
                    class="block w-full border rounded px-3 py-2 mt-1"
                >
                    <option value="">{{ __('ticket.priority_select') }}</option>
                    <option value="high">{{ __('ticket.priority_high') }}</option>
                    <option value="medium">{{ __('ticket.priority_medium') }}</option>
                    <option value="low">{{ __('ticket.priority_low') }}</option>
                </x-select>

                @error('priority')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ações -->
            <div class="flex justify-end gap-2 pt-4">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('ticket.close') }}
                </x-secondary-button>

                <x-primary-button wire:click="createTicket" >
                    <x-heroicon-o-check class="w-5 h-5 mr-2" /> {{ __('ticket.create') }}
                </x-primary-button>
            </div>

        </div>
    </x-modal>
</div>
