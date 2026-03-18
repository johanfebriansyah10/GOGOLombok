<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center">Lupa Password</h2>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input
                id="email"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>

        <!-- Back to Login -->
        <div class="text-center">
            <p class="text-gray-600">
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                    Kembali ke halaman login
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
