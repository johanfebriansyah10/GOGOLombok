<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Welcome to User Dashboard</h3>
                    <p class="mb-2">You are logged in as: <strong>{{ Auth::user()->name }}</strong></p>
                    <p class="mb-4">Role: <span class="bg-green-100 text-green-800 px-2 py-1 rounded">{{ Auth::user()->role }}</span></p>
                    <p class="text-gray-600 dark:text-gray-400">
                        This is your personal user dashboard.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
