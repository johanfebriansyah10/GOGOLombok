<x-guest-layout>
<div>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center">Registrasi Akun</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama lengkap')" class="block text-sm font-medium text-gray-800 mb-2" />
            <x-text-input
                id="name"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#34C759] focus:border-transparent transition-colors"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                placeholder="Masukkan Nama Lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
        </div>

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
                autocomplete="new-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            <p class="text-xs text-gray-500 mt-2">Harus 8 karakter dan memiliki kombinasi huruf besar, kecil, dan angka</p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input
                id="password_confirmation"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#34C759] focus:border-transparent transition-colors"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
        </div>


        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full py-3 px-4 mt-4 bg-[#34C759] hover:bg-[#248b3e] text-white font-semibold rounded-lg transition-colors">
                {{ __('Registrasi') }}
            </x-primary-button>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <div class="flex items-center gap-4 my-6">
            <div class="flex-1 border-t border-gray-300"></div>
            <p class="text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#34C759] hover:text-[#248b3e] font-semibold transition-colors">
                Login
                </a>
            </p>
            <div class="flex-1 border-t border-gray-300"></div>
            </div>
        </div>
    </form>
</div>
</x-guest-layout>
