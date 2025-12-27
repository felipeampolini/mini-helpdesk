<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_themselves(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password123'),
        ]);

        $this->actingAs($user);

        $response = $this->delete(route('profile.destroy'), [
            'password' => $password,
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_user_cannot_delete_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password123'),
        ]);

        $this->actingAs($user);

        $response = $this->from(route('profile.edit'))->delete(route('profile.destroy'), [
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect(route('profile.edit'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }
}
