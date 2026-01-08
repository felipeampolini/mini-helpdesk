<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'manager' || $user->role === 'user';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->role === 'manager' || $ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'user' || $user->role === 'manager';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        // Manager pode editar qualquer ticket
        if ($user->role === 'manager') {
            return true;
        }

        // User só pode editar os proprios tickets
        return $user->role === 'user' && $ticket->user_id === $user->id;
    }

    public function changeStatus(User $user, Ticket $ticket)
    {
        // Manager pode editar status de qualquer ticket
        if ($user->role === 'manager') {
            return true;
        }

        // User só pode editar o status dos seus proprios tickets
        return $user->role === 'user' && $ticket->user_id === $user->id;
    }

    public function changeAnyStatus(User $user, Ticket $ticket)
    {
        if ($user->role === 'user') {
            return false;
        }

        // Manager pode alterar qualquer status de qualquer ticket
        return true;
    }

    public function changePriority(User $user, Ticket $ticket)
    {
        if ($user->role === 'user') {
            return false;
        }

        // Apenas o manager pode editar a priority de qualquer ticket
        return true;
    }

    public function comment(User $user, Ticket $ticket)
    {
        // Manager pode comentar em qualquer ticket
        if ($user->role === 'manager') {
            return true;
        }

        // User só pode comentar em seus proprios tickets
        return $user->role === 'user' && $ticket->user_id === $user->id;
    }

}
