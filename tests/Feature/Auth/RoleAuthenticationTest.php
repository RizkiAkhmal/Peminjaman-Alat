<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Tests\TestCase;

class RoleAuthenticationTest extends TestCase
{
    public function test_admin_is_redirected_to_admin_dashboard(): void
    {
        $user = User::factory()->admin()->make([
            'email' => 'admin@test.local',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_petugas_is_redirected_to_petugas_dashboard(): void
    {
        $user = User::factory()->petugas()->make([
            'email' => 'petugas@test.local',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('petugas.dashboard'));
    }

    public function test_peminjam_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->make([
            'email' => 'peminjam@test.local',
            'role' => UserRole::Peminjam,
        ]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertForbidden();
    }
}
