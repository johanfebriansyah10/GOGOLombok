<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('images/GOLombok.svg') }}" type="image/x-icon">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Login - {{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#34C759] to-[#00C8B3]">
            <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <x-application-logo1 />
                </div>

                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Admin Login</h1>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" name="password" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-[#34C759] to-[#00C8B3] text-white font-semibold py-2 px-4 rounded-lg hover:opacity-90 transition">
                        Login
                    </button>
                </form>

                <p class="mt-4 text-center text-sm text-gray-600">
                    Kembali ke <a href="{{ route('dashboard') }}" class="text-green-600 hover:text-green-800 font-medium">Dashboard</a>
                </p>
            </div>
        </div>
    </body>
</html>
