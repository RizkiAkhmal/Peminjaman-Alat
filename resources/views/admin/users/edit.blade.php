<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Ubah Pengguna
            </h2>
            <p class="text-sm text-gray-500">Memperbarui akun {{ $user->name }}.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                @include('admin.users.partials.form', [
                    'action' => route('admin.users.update', $user),
                    'method' => 'PUT',
                    'user' => $user,
                    'roles' => $roles,
                ])
            </div>
        </div>
    </div>
</x-app-layout>
