<?php

namespace Tests\Feature;

use App\Livewire\TicketCreateModal;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_ticket_index_page(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('tickets.index'));

        $response->assertStatus(200);
        $response->assertSee(__('nav.tickets'));
    }

    public function test_tickets_are_listed_for_logged_user(): void
    {
        $user = User::factory()->create();

        Ticket::factory()->count(2)->create([
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('tickets.index'));

        $response->assertStatus(200);
        $response->assertSeeText(Ticket::first()->title);
    }

    public function test_user_can_create_ticket(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(TicketCreateModal::class)
            ->set('title', 'Meu primeiro ticket')
            ->set('description', 'Descrição do problema')
            ->set('priority', 'high')
            ->call('createTicket')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('tickets', [
            'title' => 'Meu primeiro ticket',
            'user_id' => $user->id,
            'status' => 'open',
        ]);
    }

    public function test_user_without_permission_cannot_create_ticket(): void
    {
        $user = User::factory()->create();

        // Exemplo: se sua policy depende de role
        // $user->removeRole('support');

        Livewire::actingAs($user)
            ->test(TicketCreateModal::class)
            ->set('title', 'Ticket inválido')
            ->call('createTicket');

        $this->assertDatabaseCount('tickets', 0);
    }

    public function test_user_cannot_see_tickets_from_other_users()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $ticketFromUserB = Ticket::factory()->create([
            'user_id' => $userB->id,
            'title' => 'Ticket do usuário B',
        ]);

        $response = $this
            ->actingAs($userA)
            ->get(route('tickets.index'));

        $response->assertStatus(200);

        $response->assertDontSee('Ticket do usuário B');
    }

    public function test_user_sees_only_own_tickets()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $ownTicket = Ticket::factory()->create([
            'user_id' => $userA->id,
            'title' => 'Meu ticket',
        ]);

        Ticket::factory()->create([
            'user_id' => $userB->id,
            'title' => 'Ticket de outro usuário',
        ]);

        $response = $this
            ->actingAs($userA)
            ->get(route('tickets.index'));

        $response->assertStatus(200);

        $response->assertSee('Meu ticket');
        $response->assertDontSee('Ticket de outro usuário');
    }

    public function test_manager_can_see_all_tickets()
    {
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);
        $comum = User::factory()->create();


        $ticket = Ticket::factory()->create([
            'user_id' => $comum->id,
            'title' => 'Ticket global',
        ]);

        $response = $this
            ->actingAs($manager)
            ->get(route('tickets.index'));

        $response->assertStatus(200);
        $response->assertSee('Ticket global');
    }

}
