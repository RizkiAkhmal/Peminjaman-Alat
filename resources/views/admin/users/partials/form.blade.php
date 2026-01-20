@props([
    'action',
    'method' => 'POST',
    'user' => null,
    'roles' => [],
])

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if (!in_array(strtoupper($method), ['POST', 'GET']))
        @method($method)
    @endif

    <div>
        <x-input-label for="name" value="Nama Lengkap" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $user?->name)" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $user?->email)" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="role" value="Peran" />
        <select id="role" name="role"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @foreach ($roles as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $user?->role?->value) === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password" value="Password {{ $user ? '(opsional)' : '' }}" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :required="!$user" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password_confirmation" value="Konfirmasi Password" />
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full"
                      :required="!$user" />
    </div>

    <div class="flex justify-end space-x-3">
        <x-secondary-button type="button" onclick="window.history.back()">Batal</x-secondary-button>
        <x-primary-button>Simpan</x-primary-button>
    </div>
</form>
