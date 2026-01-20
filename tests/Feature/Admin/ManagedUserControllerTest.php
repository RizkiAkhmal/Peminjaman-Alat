<?php

namespace Tests\Feature\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagedUserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        if (! in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('SQLite driver not available in this environment.');
        }

        parent::setUp();
    }

    private function admin(): User
    {
        return User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);
    }

    public function test_admin_can_view_index(): void
    {
        $admin = $this->admin();
        $petugas = User::factory()->petugas()->create(['email' => 'petugas@example.com']);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertSeeText($petugas->email);
    }

    public function test_admin_can_create_petugas(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Petugas Baru',
            'email' => 'baru@example.com',
            'role' => UserRole::Petugas->value,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'baru@example.com',
            'role' => UserRole::Petugas->value,
        ]);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = $this->admin();
        $user = User::factory()->petugas()->create([
            'name' => 'Old Name',
            'email' => 'update@example.com',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'name' => 'New Name',
            'email' => 'update@example.com',
            'role' => UserRole::Peminjam->value,
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'role' => UserRole::Peminjam->value,
        ]);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = $this->admin();
        $user = User::factory()->peminjam()->create([
            'email' => 'hapus@example.com',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_non_admin_cannot_access_management(): void
    {
        $petugas = User::factory()->petugas()->create();

        $this->actingAs($petugas)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }
}
