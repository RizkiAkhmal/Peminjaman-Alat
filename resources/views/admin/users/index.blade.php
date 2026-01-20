<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Kelola Pengguna
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Buat, ubah, atau hapus akun Petugas dan Peminjam.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                + Tambah Pengguna
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-600 dark:text-gray-300">Nama</th>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-600 dark:text-gray-300">Email</th>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-600 dark:text-gray-300">Peran</th>
                                    <th class="px-3 py-2 text-right font-semibold text-gray-600 dark:text-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-3 py-3">
                                            <div class="font-medium">{{ $user->name }}</div>
                                        </td>
                                        <td class="px-3 py-3 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                                        <td class="px-3 py-3">
                                            <span class="inline-flex items-center rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200 px-3 py-1 text-xs font-semibold">
                                                {{ $user->role->label() }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 text-right space-x-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="text-indigo-600 hover:underline">Ubah</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:underline"
                                                        onclick="return confirm('Hapus {{ $user->name }}?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-6 text-center text-gray-500">
                                            Belum ada pengguna untuk dikelola.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
