<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Verify Email</h2>
        <p class="text-gray-600 mt-2">Thank you for signing up! Please verify your email address.</p>
    </div>

    <div class="p-4 mb-6 bg-blue-50 border border-blue-200 rounded-lg text-blue-800 text-sm">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg font-medium text-sm text-green-800">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="space-y-6">
        @csrf

        <div>
            <x-primary-button class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </div>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="w-full py-3 px-4 border border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition-colors text-center">
            {{ __('Log Out') }}
        </button>
    </form>
</x-guest-layout>
