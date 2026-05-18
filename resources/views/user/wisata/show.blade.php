<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                {{ $wisata->name }}
            </h2>
            <a href="{{ route('wisata.catalog') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                ← Kembali ke Halaman Wisata
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :breadcrumbs="[
                ['label' => 'Daftar Wisata', 'url' => route('wisata.catalog')],
                ['label' => $wisata->name, 'url' => null]
            ]" />

            <!-- Main Content -->
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Side: Image & Info -->
                <div class="lg:col-span-2">
                    <!-- Image Gallery -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-6">
                        <div class="relative bg-gray-200 overflow-hidden" style="aspect-ratio: 16/9;">
                            @if ($wisata->image_url)
                                <img
                                    id="mainImage"
                                    src="{{ $wisata->image_url }}"
                                    alt="{{ $wisata->name }}"
                                    class="w-full h-full object-cover"
                                />
                            @else
                                <div class="flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700">
                                    <div class="text-center">
                                        <div class="text-8xl mb-4">🏞️</div>
                                        <p class="text-gray-700">Tidak ada foto</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 mb-6">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $wisata->name }}</h2>

                        <!-- Rating & Category -->
                        <div class="flex flex-wrap gap-3 mb-6">
                            <div class="inline-flex items-center gap-2 bg-yellow-100 dark:bg-yellow-900 px-4 py-2 rounded-full">
                                <span class="text-2xl">⭐</span>
                                <div>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ number_format($wisata->actual_rating ?? 0, 1) }}/5</p>
                                </div>
                            </div>

                            @if ($wisata->category)
                                <div class="inline-flex items-center gap-2 bg-blue-100 dark:bg-blue-900 px-4 py-2 rounded-full">
                                    <p class="font-semibold text-blue-900 dark:text-blue-100">{{ $wisata->category->name }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Location -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                Lokasi
                            </h3>
                            <p class="text-gray-700 text-lg mb-2"><strong>{{ $wisata->location }}</strong></p>
                            <p class="text-gray-600 text-sm">{{ $wisata->address }}</p>
                            @if ($wisata->latitude && $wisata->longitude)
                                <!-- Map Section -->
                                <div class="mt-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">Peta Lokasi</h4>
                                    <div id="map" style="height: 300px; width: 100%;" class="rounded-lg border border-gray-300"></div>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                                📝 Deskripsi
                            </h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $wisata->description }}</p>
                        </div>

                        <!-- Key Info Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- Distance -->
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <span class="text-2xl">🚀</span>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold">Jarak dari Pusat Kota</p>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($wisata->distance, 1) }}<span class="text-sm ml-1">km</span></p>
                                </div>
                                {{-- note --}}
                                <p class="my-4">Note:</p>
                                <p class="text-md text-center bg-blue-500/80 text-white p-1 rounded mb-2">Dari Titik Nol Kilometer Mataram</p>
                            </div>

                            <!-- Ticket Price -->
                            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <span class="text-2xl">🎟️</span>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold">Harga Tiket</p>
                                    <p class="text-xl font-bold text-green-600 dark:text-green-400">Rp <span class="text-sm">{{ number_format($wisata->ticket_price, 0, '', '.') }}</span></p>
                                </div>
                                {{-- note --}}
                                <p class="my-4">Note:</p>
                                <p class="text-md text-center bg-green-500/80 text-white p-1 rounded">Sudah Termasuk Parkir</p>
                            </div>

                            <!-- Facilities -->
                            <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <span class="text-2xl">🏢</span>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold inline">Fasilitas</p>
                                    <p class="text-2xl font-bold text-purple-600 inline">{{ $wisata->facilities_count ?? 0 }}</p>
                                </div>
                                @if ($wisata->facilities && count($wisata->facilities) > 0)
                                    <ul class="mt-2 text-sm text-gray-600 flex flex-wrap gap-2">
                                        @foreach ($wisata->facilities as $facility)
                                            <li class="inline p-2 bg-purple-500/80 text-white rounded-xl">{{ $facility }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-500">Tidak ada fasilitas</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Wisatas -->
            @if ($related->isNotEmpty())
                <div class="mt-12 bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">🌟 Wisata Sejenis</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($related as $item)
                            <a href="{{ route('wisata.show', $item->id) }}" class="group">
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 overflow-hidden rounded-lg hover:shadow-lg transition-all">
                                    <!-- Thumbnail -->
                                    <div class="relative overflow-hidden bg-gray-200 dark:bg-gray-700 h-40">
                                        @if ($item->image_url)
                                            <img
                                                src="{{ $item->image_url }}"
                                                alt="{{ $item->name }}"
                                                class="w-full h-full object-cover transition-transform"
                                            />
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                🏞️
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Info -->
                                    <div class="p-4">
                                        <h3 class="font-bold text-sm text-gray-900 dark:text-gray-100 line-clamp-2">
                                            {{ $item->name }}
                                        </h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">⭐ {{ number_format($item->actual_rating ?? 0, 1) }}/5</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">📍 {{ number_format($item->distance, 1) }} km</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Link disalin ke clipboard!');
            });
        }
    </script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        @if($wisata->latitude && $wisata->longitude)
            // Initialize map
            var map = L.map('map').setView([{{ $wisata->latitude }}, {{ $wisata->longitude }}], 15);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add marker
            L.marker([{{ $wisata->latitude }}, {{ $wisata->longitude }}]).addTo(map)
                .bindPopup('<b>{{ addslashes($wisata->name) }}</b><br>{{ addslashes($wisata->location) }}')
                .openPopup();
        @endif
    </script>
</x-app-layout>
