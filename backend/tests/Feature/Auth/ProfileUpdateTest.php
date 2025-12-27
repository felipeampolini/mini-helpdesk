<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('profile.edit'));
        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
    }

    public function test_user_can_update_name_and_email(): void
    {
        $user = User::factory()->create([
            'email' => 'old@example.com',
            'name' => 'Old Name',
        ]);

        $this->actingAs($user);

        $response = $this->patch(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        // Verifica se o email foi resetado para verificação
        $this->assertNull($user->fresh()->email_verified_at);
    }
}
