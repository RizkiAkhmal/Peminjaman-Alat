<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $title ?? __('Dashboard') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Peran aktif: {{ $roleLabel ?? auth()->user()?->role->label() }}
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-3">
                    <p>{{ $message ?? __("You're logged in!") }}</p>
                    @isset($tips)
                        <ul class="list-disc ms-6 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                            @foreach ($tips as $tip)
                                <li>{{ $tip }}</li>
                            @endforeach
                        </ul>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
