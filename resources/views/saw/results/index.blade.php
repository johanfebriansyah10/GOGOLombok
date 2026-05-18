<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ranking wisata') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :breadcrumbs="[
                ['label' => 'Ranking wisata', 'url' => null]
            ]" />

            @if (session('message'))
                <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    <strong>Info:</strong> {{ session('message') }}
                </div>
            @elseif (isset($message))
                <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    <strong>Info:</strong> {{ $message }}
                </div>
            @endif

            @if (isset($error))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Error:</strong> {{ $error }}
                </div>
            @elseif (!isset($message))

            <!-- Filter Section -->
            <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 border border-blue-200 dark:border-gray-600 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <label for="category" class="font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                            🏷️ Filter Kategori:
                        </label>
                        <form method="GET" action="{{ route('saw.results.index') }}" class="flex flex-col md:flex-row md:items-center gap-3 flex-1">
                            <select name="category" id="category" class="flex-1 md:flex-none px-8 py-2 border-2 border-blue-300  rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="flex gap-2">
                                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md font-medium">
                                    🔍 Filter
                                </button>
                                @if ($selectedCategory)
                                    <a href="{{ route('saw.results.index') }}" class="px-6 py-2 bg-gray-400 dark:bg-gray-600 text-white rounded-lg hover:bg-gray-500 dark:hover:bg-gray-700 transition-all shadow-md font-medium">
                                        ✕ Hapus filter
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Ranking Cards -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">🏆 Ranking Rekomendasi Wisata</h3>
                    </div>

                    @if ($ranking->isEmpty())
                        <div class="text-center py-16">
                            <div class="text-5xl mb-4">😔</div>
                            <p class="text-gray-600 dark:text-gray-400 text-lg font-medium">
                                @if ($selectedCategory)
                                    Tidak ada wisata dalam kategori yang dipilih
                                @else
                                    Belum ada data evaluasi untuk perhitungan SAW
                                @endif
                            </p>
                        </div>
                    @else
                    <!-- Card List -->
                    <div class="space-y-6">
                        @foreach ($ranking as $item)
                            @php
                                $wisata = \App\Models\Wisata::find($item['wisata_id']);
                                $facilityIcons = [
                                    'toilet' => '🚽',
                                    'musholla' => '🕌',
                                    'parkir' => '🅿️',
                                    'spot_foto' => '📸',
                                    'restoran' => '🍽️',
                                    'wifi' => '📶',
                                    'guide' => '🧑‍🏫'
                                ];
                            @endphp
                            <a href="{{ route('wisata.show', $wisata->id) }}" class="group block">
                                <div class="relative overflow-hidden rounded-xl border-2 border-transparent hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 hover:shadow-xl">
                                    <!-- Gradient Accent Bar -->
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $loop->first ? 'from-yellow-400 via-yellow-300 to-yellow-200' : ($loop->iteration == 2 ? 'from-gray-400 via-gray-300 to-gray-200' : ($loop->iteration == 3 ? 'from-orange-400 via-orange-300 to-orange-200' : 'from-blue-400 via-blue-300 to-blue-200')) }}"></div>

                                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6 p-6">
                                        <!-- Rank Badge -->
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br {{ $loop->first ? 'from-yellow-400 to-yellow-500' : ($loop->iteration == 2 ? 'from-gray-400 to-gray-500' : ($loop->iteration == 3 ? 'from-orange-400 to-orange-500' : 'from-blue-500 to-blue-600')) }} text-white rounded-full font-bold text-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                {{ $loop->iteration }}
                                            </span>
                                        </div>

                                        <!-- Image -->
                                        <div class="flex-shrink-0 w-full md:w-40 h-32 md:h-40 rounded-xl overflow-hidden bg-gray-200 dark:bg-gray-600 shadow-md">
                                            @if ($wisata && $wisata->image_url)
                                                <img src="{{ $wisata->image_url }}" alt="{{ $item['wisata_name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-5xl">🏞️</div>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1 min-w-0 w-full">
                                            <!-- Title & Location -->
                                            <h3 class="font-bold text-gray-900 dark:text-gray-100 text-xl md:text-2xl group-hover:text-blue-600 dark:group-hover:text-blue-400 transition mb-3">
                                                {{ $item['wisata_name'] }}
                                            </h3>
                                            @if ($wisata)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                    📍 {{ $wisata->location ?? 'Lokasi tidak tersedia' }}
                                                </p>
                                            @endif

                                            <!-- Key Info Row 1 -->
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                                @if ($wisata)
                                                    <!-- Distance -->
                                                    <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">JARAK</p>
                                                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ number_format($wisata->distance ?? 0, 1) }} <span class="text-xs font-normal">km</span></p>
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">HARGA TIKET</p>
                                                        <p class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate">Rp {{ number_format($wisata->ticket_price ?? 0, 0, ',', '.') }}</p>
                                                    </div>

                                                    <!-- Rating -->
                                                    <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">RATING</p>
                                                        <div class="flex items-center gap-1 mt-1">
                                                            <span class="text-xl font-bold text-yellow-500">⭐</span>
                                                            <span class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($wisata->actual_rating ?? 0, 1) }}/5</span>
                                                        </div>
                                                    </div>

                                                    <!-- Reviewer Count -->
                                                    <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">REVIEWER</p>
                                                        <div class="flex items-center gap-1 mt-1">
                                                            <span class="text-lg">👥</span>
                                                            <span class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($wisata->review_count ?? 0, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Facilities -->
                                            @if ($wisata && $wisata->facilities && count($wisata->facilities) > 0)
                                                <div>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold mb-2">FASILITAS ({{ count($wisata->facilities) }})</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach ($wisata->facilities as $facility)
                                                            <span class="inline-flex items-center gap-1 bg-gradient-to-r from-emerald-100 to-teal-100 dark:from-emerald-900 dark:to-teal-900 text-emerald-800 dark:text-emerald-200 px-3 py-1 rounded-full text-xs font-semibold shadow-sm hover:shadow-md transition">
                                                                {{ $facilityIcons[$facility] ?? '✓' }}
                                                                <span>{{ ucfirst(str_replace('_', ' ', $facility)) }}</span>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-xs text-gray-500 dark:text-gray-500 italic">Tidak ada informasi fasilitas</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
