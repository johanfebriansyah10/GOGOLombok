<nav x-data="{ open: false }" class="shadow-md border-b bg-gradient-to-br from-[#34C759] to-[#00C8B3] sticky top-0 z-50 sm:py-2 border-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-bold text-gray-800 text-lg hover:opacity-80 transition">
                    <x-application-logo1 />
                </a>
            </div>

            <!-- Desktop Navigation (Centered) -->
            <div class="hidden md:flex items-center gap-4">
                @if (Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.dashboard') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.categories.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Kategori
                </a>
                <a href="{{ route('admin.wisatas.index') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.wisatas.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Alternatif
                </a>
                <a href="{{ route('admin.criterias.index') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.criterias.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Kriteria
                </a>
                <a href="{{ route('admin.weights.index') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.weights.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Bobot Kategori
                </a>
                {{-- <a href="{{ route('admin.evaluations.index') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.evaluations.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Evaluasi
                </a> --}}
                @else
                <!-- Guest navigation -->
                <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('dashboard') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Dashboard
                </a>
                <a href="{{ route('wisata.catalog') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('wisata.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Wisata
                </a>
                <a href="{{ route('saw.recommendations.index') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('saw.recommendations.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Rekomendasi
                </a>
                <!-- <a href="{{ route('saw.results.index') }}" class="px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('saw.results.*') ? 'text-gray-100 border-b-2 border-gray-100 hover:border-blue-300': 'text-gray-100 hover:border-blue-300 hover:border-b-2 border-b-2 border-transparent' }} transition">
                    Ranking
                </a> -->
                @endif
            </div>

            <!-- Right Side: User Menu & Hamburger -->
            <div class="flex items-center gap-4">
                @if(Auth::check())
                <!-- Desktop Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-white text-green-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                        {{ __('Log Out') }}
                    </button>
                </form>
                @else
                <!-- Login Button for Guests -->
                <!-- <a href="{{ route('admin.login') }}" class="hidden md:inline-flex items-center px-4 py-2 bg-white text-green-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                    Admin Login
                </a> -->
                @endif

                <!-- Mobile Hamburger Menu -->
                <button @click="open = !open" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" :class="{'hidden': open, 'block': !open}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'block': open, 'hidden': !open}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="open" class="md:hidden border-t border-gray-200 bg-white">
            <div class="px-2 pt-2 pb-3 space-y-1">
                @if (Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.dashboard') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.categories.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Kategori
                </a>
                <a href="{{ route('admin.wisatas.index') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.wisatas.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Alternatif
                </a>
                <a href="{{ route('admin.criterias.index') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.criterias.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Kriteria
                </a>
                <a href="{{ route('admin.weights.index') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.weights.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Bobot Kategori
                </a>
                {{-- <a href="{{ route('admin.evaluations.index') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('admin.evaluations.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Evaluasi
                </a> --}}
                @elseif (Auth::check())
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('dashboard') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Home
                </a>
                <a href="{{ route('wisata.catalog') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('wisata.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Katalog
                </a>
                <a href="{{ route('saw.recommendations.index') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('saw.recommendations.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Rekomendasi
                </a>
                <!-- <a href="{{ route('saw.results.index') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('saw.results.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Ranking
                </a> -->
                @else
                <!-- Guest mobile navigation -->
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('dashboard') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Beranda
                </a>
                <a href="{{ route('wisata.catalog') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('wisata.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Wisata
                </a>
                <a href="{{ route('saw.recommendations.index') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('saw.recommendations.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Rekomendasi
                </a>
                <!-- <a href="{{ route('saw.results.index') }}" class="block px-3 py-2 rounded-md text-md font-medium {{ request()->routeIs('saw.results.*') ? 'text-gray-500 border-b-2 border-blue-300': 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} transition">
                    Ranking
                </a> -->
                @endif
            </div>

            @if(Auth::check())
            <!-- Mobile User Menu -->
            <div class="border-t border-gray-200 pt-3 pb-3">
                <div class="px-2 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 transition">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
            @else
            <!-- Mobile Login Button for Guests -->
            <div class="border-t border-gray-200 pt-3 pb-3 px-2">
                <a href="{{ route('admin.login') }}" class="block w-full bg-gradient-to-r from-[#34C759] to-[#00C8B3] text-white text-center font-semibold py-2 px-4 rounded-lg hover:opacity-90 transition">
                    Admin Login
                </a>
            </div>
            @endif
        </div>
    </div>
</nav>
