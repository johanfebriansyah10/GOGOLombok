<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('images/GOLombok.png') }}" type="image/x-icon">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="py-16 px-28 min-h-screen grid grid-cols-1 lg:grid-cols-2 bg-white">
            <!-- Left Side - Branding & Info -->
            <div class="hidden lg:flex flex-col justify-center text-center p-12 bg-gradient-to-br from-[#34C759] to-[#00C8B3] text-white rounded-s-md">
                <div class="">
                    <h1 class="text-4xl font-bold mb-6">Selamat Datang di</h1>
                    <div class="flex justify-center mb-6 bg-white rounded-full w-52 h-20 items-center mx-auto">
                        <x-application-logo/>
                    </div>
                    <p class="text-blue-100 text-lg leading-relaxed">
                        Daftar untuk mengakses fitur yang lebih lengkap.
                    </p>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="flex flex-col justify-center items-center px-6 py-12 sm:px-12 lg:px-16 rounded-e-md border border-[#34C759]">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
