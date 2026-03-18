<x-guest-layout>
<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center">Masukan akun</h2>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input
                id="email"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#34C759] focus:border-transparent transition-colors"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="nama@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input
                id="password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#34C759] focus:border-transparent transition-colors"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center gap-3 cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-[#34C759] focus:ring-[#34C759] cursor-pointer" name="remember">
                <span class="text-sm text-gray-600 font-medium">{{ __('Ingat saya') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-[#34C759] hover:text-[#248b3e] font-medium transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full py-3 px-4 bg-[#34C759] hover:bg-[#248b3e] text-white font-semibold rounded-lg transition-colors">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
            <p class="text-gray-600 bg-white px-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-[#34C759] hover:text-[#248b3e] font-semibold transition-colors">
                    Buat akun baru
                </a>
            </p>
            </div>
        </div>
    </form>
</div>
</x-guest-layout>
