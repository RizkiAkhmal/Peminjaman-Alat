<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManagedUserStoreRequest;
use App\Http\Requests\Admin\ManagedUserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ManagedUserController extends Controller
{
    public function index(): View
    {
        $managedRoles = [UserRole::Petugas, UserRole::Peminjam];

        $users = User::query()
            ->whereIn('role', array_map(fn (UserRole $role) => $role->value, $managedRoles))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'managedRoles' => $managedRoles,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => $this->roleOptions(),
        ]);
    }

    public function store(ManagedUserStoreRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->string('name')->trim(),
            'email' => Str::lower($request->string('email')),
            'password' => Hash::make($request->string('password')),
            'role' => $request->enum('role', UserRole::class),
        ]);

        return Redirect::route('admin.users.index')
            ->with('status', "{$user->name} berhasil ditambahkan sebagai {$user->role->label()}.");
    }

    public function edit(User $user): View
    {
        $this->ensureManageable($user);

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $this->roleOptions(),
        ]);
    }

    public function update(ManagedUserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->ensureManageable($user);

        $user->fill([
            'name' => $request->string('name')->trim(),
            'email' => Str::lower($request->string('email')),
            'role' => $request->enum('role', UserRole::class),
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->string('password'));
        }

        $user->save();

        return Redirect::route('admin.users.index')
            ->with('status', "{$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->ensureManageable($user);

        $name = $user->name;
        $user->delete();

        return Redirect::route('admin.users.index')
            ->with('status', "{$name} berhasil dihapus.");
    }

    /**
     * @return array<string, string>
     */
    private function roleOptions(): array
    {
        return [
            UserRole::Petugas->value => UserRole::Petugas->label(),
            UserRole::Peminjam->value => UserRole::Peminjam->label(),
        ];
    }

    private function ensureManageable(User $user): void
    {
        abort_unless(
            in_array($user->role, [UserRole::Petugas, UserRole::Peminjam], true),
            404,
        );
    }
}
