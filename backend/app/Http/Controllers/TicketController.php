<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Ticket::class);

        return view('tickets.index');
    }

    /**
     * A criação de tickets agora é feita via modal com Livewire,
     * então não é necessário abrir uma tela separada.
     */
    public function create()
    {
        // regra de policy para esconder/mostrar botao dentro do blade
        return redirect()->route('tickets.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // regra no livewire TicketCreateModal::createTicket
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $this->authorize('view', $ticket);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $this->authorize('update', $ticket);

        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // regra no livewire TicketEdit::save
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Nao implementado
    }
}
