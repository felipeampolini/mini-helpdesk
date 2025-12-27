<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tickets
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Título</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Prioridade</th>
                            <th class="py-2 px-4 border-b">Criado em</th>
                            <th class="py-2 px-4 border-b">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b">{{ $ticket->title }}</td>
                                <td class="py-2 px-4 border-b capitalize">{{ $ticket->status }}</td>
                                <td class="py-2 px-4 border-b capitalize">{{ $ticket->priority }}</td>
                                <td class="py-2 px-4 border-b">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:underline mr-2">Ver</a>
                                    @can('update', $ticket)
                                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-green-500 hover:underline">Editar</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $tickets->links() }} {{-- Paginação --}}
            </div>
        </div>
    </div>
</x-app-layout>
