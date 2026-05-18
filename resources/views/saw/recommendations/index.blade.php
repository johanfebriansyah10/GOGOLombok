<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rekomendasi Wisata') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :breadcrumbs="[
                ['label' => 'Rekomendasi', 'url' => null]
            ]" />

            <!-- Filter Form Section -->
            <div class="mb-6 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-700 overflow-hidden shadow-sm sm:rounded-lg border border-blue-200 dark:border-gray-600">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Isi Preferensi Wisata Anda
                        </h3>
                        @if ($hasFilters)
                            <a href="{{ route('saw.recommendations.index') }}" class="text-sm px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                Hapus Filter
                            </a>
                        @endif
                    </div>

                    <form method="GET" action="{{ route('saw.recommendations.index') }}" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Kategori Wisata -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Kategori Wisata
                                </label>
                                <select
                                    id="category_id"
                                    name="category_id"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                >
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Pilih kategori wisata yang ingin dicari</p>
                            </div>

                            <!-- Budget Maksimal -->
                            <div>
                                <label for="max_budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Budget Maksimal
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-600 dark:text-gray-400">Rp</span>
                                    <input
                                        type="number"
                                        id="max_budget"
                                        name="max_budget"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Contoh: 200000"
                                        value="{{ $filters['max_budget'] ?? '' }}"
                                        step="10000"
                                        min="0"
                                    />
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Cari wisata dengan harga tiket lebih murah dari nilai di atas</p>
                            </div>

                            <!-- Jarak Maksimal -->
                            <div>
                                <label for="max_distance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jarak Maksimal
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        id="max_distance"
                                        name="max_distance"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Contoh: 100"
                                        value="{{ $filters['max_distance'] ?? '' }}"
                                        step="5"
                                        min="0"
                                    />
                                    <span class="absolute right-3 top-3 text-gray-600 dark:text-gray-400">km</span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Cari wisata dalam jarak kurang dari nilai di #1atas dari pusat kota</p>
                            </div>


                            <!-- Rating Minimal -->
                            <div>
                                <label for="min_rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Rating Minimal
                                </label>
                                <div class="flex items-center gap-2">
                                    <input
                                        type="number"
                                        id="min_rating"
                                        name="min_rating"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Contoh: 4.0"
                                        value="{{ $filters['min_rating'] ?? '' }}"
                                        step="0.1"
                                        min="0"
                                        max="5"
                                    />
                                    <span class="text-gray-600 dark:text-gray-400">/5</span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Minimum rating dari pengunjung</p>
                            </div>
                        </div>
                            <!-- Fasilitas -->
                            <div>
                                <label class="text-sm font-medium text-gray-700">
                                    Fasilitas Wajib
                                </label>
                                <div class="flex flex-wrap gap-5 mt-3">
                                    @php
                                        $facilityOptions = ['Toilet', 'Musholla / Masjid', 'Parkir', 'Spot Foto', 'Kuliner', 'WiFi', 'Guide', 'Tempat Sampah', 'Bangku Tempat Duduk', 'Gazebo', 'Cafe', 'Kios Suvenir', 'ATM', 'Tempat Bermain Anak', 'Penginapan', 'Pusat Informasi Wisata', 'Outbound', 'Klinik', 'Penyewaan Alat Snorkeling', 'Area Camping'];
                                        $facilityLabels = [
                                            'Toilet' => 'Toilet',
                                            'Musholla / Masjid' => 'Musholla / Masjid',
                                            'Parkir' => 'Parkir',
                                            'Spot Foto' => 'Spot Foto',
                                            'Kuliner' => 'Kuliner',
                                            'WiFi' => 'WiFi',
                                            'Guide' => 'Pemandu Wisata',
                                            'Tempat Sampah' => 'Tempat Sampah',
                                            'Bangku Tempat Duduk' => 'Bangku Tempat Duduk',
                                            'Gazebo' => 'Gazebo',
                                            'Cafe' => 'Cafe',
                                            'Kios Suvenir' => 'Kios Suvenir',
                                            'ATM' => 'ATM',
                                            'Tempat Bermain Anak' => 'Tempat Bermain Anak',
                                            'Penginapan' => 'Penginapan',
                                            'Pusat Informasi Wisata' => 'Pusat Informasi Wisata',
                                            'Outbound' => 'Outbound',
                                            'Klinik' => 'Klinik',
                                            'Penyewaan Alat Snorkeling' => 'Penyewaan Alat Snorkeling',
                                            'Area Camping' => 'Area Camping',
                                        ];
                                    @endphp
                                    @foreach($facilityOptions as $facility)
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            name="facilities[]"
                                            value="{{ $facility }}"
                                            {{ in_array($facility, $filters['facilities'] ?? []) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        >
                                        <span class="ml-2 text-md text-gray-700">{{ $facilityLabels[$facility] }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                        <!-- Submit Button -->
                        <div class="flex gap-3 justify-end pt-4">
                            <button
                                type="submit"
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2"
                            >
                                Cari Wisata
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Results Section -->
            @if ($hasFilters || (isset($result) && (isset($result['error']) || isset($result['message']))))
                @if (isset($result['error']))
                    <!-- Error Message -->
                    <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg flex items-start gap-3">
                        <span class="text-xl">⚠️</span>
                        <div>
                            <p class="font-semibold">Tidak ada hasil yang sesuai</p>
                            <p class="text-sm">{{ $result['error'] }}</p>
                            <p class="text-xs mt-2 text-yellow-600">Silakan coba ubah preferensi filter Anda</p>
                        </div>
                    </div>
                @elseif (isset($result['message']))
                    <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg flex items-start gap-3">
                        <span class="text-xl">⚠️</span>
                        <div>
                            <p class="font-semibold">Informasi</p>
                            <p class="text-sm">{{ $result['message'] }}</p>
                        </div>
                    </div>
                @else
                    <!-- Success Results -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    <span>📋 Hasil Rekomendasi</span>
                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs px-3 py-1 rounded-full">
                                        {{ $result['ranking']->count() }} wisata
                                    </span>
                                </h3>
                            </div>

                            @if ($result['ranking']->isEmpty())
                                <div class="text-center py-12">
                                    <p class="text-gray-500 dark:text-gray-400 text-lg">
                                        😔 Tidak ada wisata yang sesuai dengan preferensi Anda
                                    </p>
                                </div>
                            @else
                                <!-- Ranking Table -->
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left">
                                        <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 sticky top-0">
                                            <tr>
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Rank</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Wisata</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Harga Tiket</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Jarak</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Fasilitas</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Rating</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Reviews</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($result['ranking'] as $item)
                                                @php
                                                    $wisata = \App\Models\Wisata::find($item['wisata_id']);
                                                @endphp
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                    <td class="px-4 py-3">
                                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold">
                                                            {{ $item['rank'] }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-3">
                                                            @if ($wisata && $wisata->image)
                                                                <img src="{{ $wisata->image_url }}" alt="{{ $item['wisata_name'] }}" class="w-10 h-10 rounded object-cover">
                                                            @else
                                                                <div class="w-10 h-10 rounded bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                                    <span class="text-gray-600 dark:text-gray-400">📷</span>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $item['wisata_name'] }}</p>
                                                                @if ($wisata)
                                                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $wisata->location }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="text-gray-900 dark:text-gray-100 font-medium">
                                                            Rp {{ number_format($wisata->ticket_price ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="text-gray-900 dark:text-gray-100">{{ number_format($wisata->distance ?? 0, 1) }} km</span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $wisata->facilities_count >= 10 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : ($wisata->facilities_count >= 5 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                                            🏢 {{ intval($wisata->facilities_count ?? 0) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-1">
                                                            <span class="text-yellow-400">⭐</span>
                                                            <span class="text-gray-900 dark:text-gray-100 font-medium">{{ number_format($wisata->actual_rating ?? 0, 1) }}/5</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-1">
                                                            <span class="text-blue-600 dark:text-blue-400">👥</span>
                                                            <span class="text-gray-900 dark:text-gray-100 font-medium">{{ intval($wisata->review_count ?? 0) }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <a href="{{ route('wisata.show', $wisata->id) }}" class="inline-block px-3 py-2 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition">
                                                            Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <!-- Initial State - No Filter Applied -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 border-2 border-dashed border-blue-300 dark:border-gray-600 rounded-lg p-12 text-center">
                    <div class="text-5xl mb-4">🎯</div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Mulai Cari Wisata Tujuan Anda</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Isi preferensi di atas dan klik "Cari Wisata" untuk mendapatkan rekomendasi sesuai kebutuhan anda
                    </p>
                    <div class="flex justify-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                        <div>✅ Filter berdasarkan budget</div>
                        <div>📍 Sesuaikan jarak</div>
                        <div>🏢 Pilih fasilitas</div>
                        <div>⭐ Pilih rating minimal</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
