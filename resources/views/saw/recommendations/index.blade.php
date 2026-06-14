<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Rekomendasi Wisata') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :breadcrumbs="[['label' => 'Rekomendasi', 'url' => null]]" />
            <!-- Filter Form Section -->
            <div class="card-filter">
                <div class="filter-section">
                    <div class="filter-header">
                        <h3 class="text-lg font-semibold text-gray-900">Isi Preferensi Wisata Anda</h3>
                        @if ($hasFilters)
                            <a href="{{ route('saw.recommendations.index') }}" class="btn-neutral"> Hapus Filter</a>
                        @endif
                    </div>

                    <form method="GET" action="{{ route('saw.recommendations.index') }}" class="space-y-6">
                        <input type="hidden" name="user_lat" id="user_lat" value="{{ $filters['user_lat'] ?? '' }}">
                        <input type="hidden" name="user_lng" id="user_lng" value="{{ $filters['user_lng'] ?? '' }}">
                        <input type="hidden" name="user_regency" id="user_regency" value="{{ $filters['user_regency'] ?? '' }}">
                        <input type="hidden" name="location_source" id="location_source" value="{{ $filters['location_source'] ?? '' }}">
                        <div class="filter-grid">
                            <!-- Kategori Wisata -->
                            <div>
                                <label for="category_id" class="form-label">Kategori Wisata</label>
                                <select
                                    id="category_id"
                                    name="category_id"
                                    class="form-input">
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="form-helper">Pilih kategori wisata yang ingin dicari</p>
                            </div>

                            <!-- Budget Maksimal -->
                            <div>
                                <label for="max_budget" class="form-label">Harga Tiket</label>
                                <div class="form-input-group">
                                    <span class="form-currency-prefix">Rp</span>
                                    <input
                                        type="number"
                                        id="max_budget"
                                        name="max_budget"
                                        class="form-input-pl"
                                        placeholder="Contoh: 200000"
                                        value="{{ $filters['max_budget'] ?? '' }}"
                                        step="5000"
                                        min="0"
                                    />
                                </div>
                                <p class="form-helper">Cari wisata dengan harga tiket lebih murah dari nilai di atas</p>
                            </div>
                            <!-- Jarak Maksimal -->
                            <div>
                                <label for="max_distance" class="form-label">
                                    Jarak Maksimal
                                </label>
                                <div class="form-input-group">
                                    <input
                                        type="number"
                                        id="max_distance"
                                        name="max_distance"
                                        class="form-input"
                                        placeholder="Contoh: 100"
                                        value="{{ $filters['max_distance'] ?? '' }}"
                                        step="2"
                                        min="0"
                                    />
                                    <span class="form-input-suffix">km</span>
                                </div>
                                <p class="form-helper">Cari wisata dalam jarak kurang dari nilai di #1atas dari pusat kota</p>
                            </div>
                            <!-- Rating Minimal -->
                            <div>
                                <label for="min_rating" class="form-label">
                                    Rating Minimal
                                </label>
                                <div class="flex items-center gap-2">
                                    <input
                                        type="number"
                                        id="min_rating"
                                        name="min_rating"
                                        class="form-input"
                                        placeholder="Contoh: 4.0"
                                        value="{{ $filters['min_rating'] ?? '' }}"
                                        step="0.1"
                                        min="0"
                                        max="5"
                                    />
                                    <span class="text-gray-600">/5</span>
                                </div>
                                <p class="form-helper">Minimum rating dari pengunjung</p>
                            </div>
                        </div>
                            <!-- Fasilitas -->
                            <div>
                                <label class="text-sm font-medium text-gray-700">
                                    Fasilitas Wajib
                                </label>
                                <div class="flex-wrap-gap">
                                    @php
                                        $facilityOptions = ['Toilet', 'Musholla / Masjid', 'Parkir', 'Spot Foto', 'Kuliner', 'WiFi', 'Guide', 'Tempat Sampah', 'Bangku Tempat Duduk', 'Gazebo', 'Cafe', 'Kios Suvenir', 'ATM', 'Tempat Bermain Anak', 'Penginapan', 'Pusat Informasi Wisata', 'Outbound', 'Klinik', 'Penyewaan Alat Snorkeling', 'Area Camping', 'Kolam Renang'];
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
                                            'Kolam Renang' => 'Kolam Renang',
                                        ];
                                    @endphp
                                    @foreach($facilityOptions as $facility)
                                    <label class="checkbox-label">
                                        <input
                                            type="checkbox"
                                            name="facilities[]"
                                            value="{{ $facility }}"
                                            {{ in_array($facility, $filters['facilities'] ?? []) ? 'checked' : '' }}
                                            class="checkbox-input"
                                        >
                                        <span class="checkbox-label-text">{{ $facilityLabels[$facility] }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                        <!-- Location Section -->
                        <div class="mt-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <label class="form-label mb-3">📍 Lokasi Anda</label>
                            <p class="text-xs text-gray-500 mb-4">Gunakan GPS untuk lokasi akurat, atau pilih wilayah secara manual jika GPS tidak tersedia.</p>

                            <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-end">
                                <!-- GPS Button -->
                                <div class="flex-1">
                                    <label class="text-xs font-medium text-gray-600 mb-1 block">Deteksi Otomatis</label>
                                    <button
                                        type="button"
                                        id="use-location"
                                        class="btn-outline w-full"
                                    >
                                        📌 Gunakan Posisi Saya
                                    </button>
                                </div>

                                <div class="flex items-center justify-center text-xs text-gray-400 font-medium">
                                    atau
                                </div>

                                <!-- Manual Region Dropdown -->
                                <div class="flex-1">
                                    <label for="selected_region" class="text-xs font-medium text-gray-600 mb-1 block">Pilih Wilayah Manual</label>
                                    <select
                                        id="selected_region"
                                        name="selected_region"
                                        class="form-input w-full"
                                    >
                                        <option value="">-- Pilih Wilayah --</option>
                                        @php
                                            $regionCenters = \App\Http\Controllers\RecommendationController::getRegionCenters();
                                        @endphp
                                        @foreach($regionCenters as $regionName => $coords)
                                            <option
                                                value="{{ $regionName }}"
                                                data-lat="{{ $coords['lat'] }}"
                                                data-lng="{{ $coords['lng'] }}"
                                                {{ ($filters['selected_region'] ?? '') === $regionName ? 'selected' : '' }}
                                            >
                                                {{ $regionName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-3 justify-end pt-4">
                            <button
                                type="submit"
                                class="btn-primary"
                            >
                                Cari Wisata
                            </button>
                        </div>

                        <div class="mt-6 z-1">
                            <div class="text-sm font-semibold text-gray-700 mb-2">Peta Lokasi Anda</div>
                            <div id="userLocationMap" class="w-full h-72 rounded-xl border border-gray-200 bg-gray-50 overflow-hidden">
                                <div id="mapPlaceholder" class="flex items-center justify-center h-full text-gray-500">Tekan "Gunakan Posisi Saya" untuk melihat lokasi Anda</div>
                            </div>
                            @php
                                $locationSourceLabels = [
                                    'gps' => 'GPS Browser',
                                    'ip' => 'IP Geolocation',
                                    'manual' => 'Pilihan Manual',
                                ];
                                $locationSourceLabel = $locationSourceLabels[$filters['location_source'] ?? ''] ?? 'Belum diketahui';
                            @endphp
                            <div id="locationStatus" class="mt-3 text-sm text-gray-600">
                                @if (isset($filters['user_lat'], $filters['user_lng']))
                                    Lokasi tersimpan:
                                    <span class="font-semibold text-gray-900">{{ $filters['user_regency'] ?? 'Kabupaten belum terdeteksi' }}</span>
                                    <span class="mx-1">•</span>
                                    {{ $locationSourceLabel }}
                                    <span class="mx-1">•</span>
                                    {{ number_format((float) $filters['user_lat'], 6) }}, {{ number_format((float) $filters['user_lng'], 6) }}
                                @else
                                    Sistem akan meminta izin GPS browser saat Anda mencari rekomendasi.
                                @endif
                            </div>
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
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                    <span>📋 Hasil Rekomendasi</span>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                                        {{ $result['ranking']->count() }} wisata
                                    </span>
                                </h3>
                            </div>

                            @if ($result['ranking']->isEmpty())
                                <div class="text-center py-12">
                                    <p class="text-gray-500 text-lg">
                                        😔 Tidak ada wisata yang sesuai dengan preferensi Anda
                                    </p>
                                </div>
                            @else
                                <!-- Top 3 Recommendations -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    @foreach ($result['ranking']->take(3) as $item)
                                        @php
                                            $wisata = \App\Models\Wisata::find($item['wisata_id']);
                                        @endphp
                                        <div class="p-4 bg-white rounded-lg shadow hover:shadow-md">
                                            <div class="flex items-center gap-3">
                                                @if ($wisata && $wisata->image)
                                                    <img src="{{ $wisata->image_url }}" alt="{{ $item['wisata_name'] }}" class="w-20 h-20 rounded object-cover">
                                                @else
                                                    <div class="w-20 h-20 rounded bg-gray-200 flex items-center justify-center">📷</div>
                                                @endif
                                                <div>
                                                    <h4 class="font-semibold">{{ $item['wisata_name'] }}</h4>
                                                    <p class="text-xs text-gray-600">{{ $wisata->location ?? '' }}</p>
                                                    <p class="text-sm mt-1">Rp {{ number_format($wisata->ticket_price ?? 0, 0, ',', '.') }} • {{ number_format($item['distance'] ?? $wisata->distance ?? 0, 1) }} km • ⭐ {{ number_format($wisata->actual_rating ?? 0,1) }}</p>
                                                </div>
                                            </div>
                                            <div class="mt-3 flex justify-end">
                                                <a href="{{ route('wisata.show', $wisata->id) }}?ref=rekomendasi" class="px-3 py-2 bg-blue-500 text-white rounded text-sm">Detail</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mb-4">
                                    <button id="toggle-full-list" class="btn-secondary">Lihat daftar lainnya</button>
                                </div>

                                <!-- Ranking Table -->
                                <div id="fullResults" class="overflow-x-auto hidden">
                                    <table class="w-full text-sm text-left">
                                        <thead class="bg-gray-100 border-b border-gray-200 sticky top-0">
                                            <tr>
                                                <th class="px-4 py-3 font-semibold text-gray-900">Rank</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900">Wisata</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900">Harga Tiket</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900">Jarak</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900">Fasilitas</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900">Rating</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900">Reviews</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach ($result['ranking'] as $item)
                                                @php
                                                    $wisata = \App\Models\Wisata::find($item['wisata_id']);
                                                @endphp
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-4 py-3">
                                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-bold">
                                                            {{ $item['rank'] }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-3">
                                                            @if ($wisata && $wisata->image)
                                                                <img src="{{ $wisata->image_url }}" alt="{{ $item['wisata_name'] }}" class="w-10 h-10 rounded object-cover">
                                                            @else
                                                                <div class="w-10 h-10 rounded bg-gray-300 flex items-center justify-center">
                                                                    <span class="text-gray-600">📷</span>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <p class="font-medium text-gray-900">{{ $item['wisata_name'] }}</p>
                                                                @if ($wisata)
                                                                    <p class="text-xs text-gray-600">{{ $wisata->location }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="text-gray-900 font-medium">
                                                            Rp {{ number_format($wisata->ticket_price ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="text-gray-900">{{ number_format($item['distance'] ?? $wisata->distance ?? 0, 1) }} km</span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $wisata->facilities_count >= 10 ? 'bg-green-100 text-green-800' : ($wisata->facilities_count >= 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                            🏢 {{ intval($wisata->facilities_count ?? 0) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-1">
                                                            <span class="text-yellow-400">⭐</span>
                                                            <span class="text-gray-900 font-medium">{{ number_format($wisata->actual_rating ?? 0, 1) }}/5</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-1">
                                                            <span class="text-blue-600">👥</span>
                                                            <span class="text-gray-900 font-medium">{{ intval($wisata->review_count ?? 0) }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <a href="{{ route('wisata.show', $wisata->id) }}?ref=rekomendasi" class="inline-block px-3 py-2 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition">
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
                            <!-- Criteria Weights Info -->
            <div class="mb-8 bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/30 dark:to-blue-900/30 border-2 border-indigo-200 dark:border-indigo-700 overflow-hidden shadow-md sm:rounded-xl">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">📊 Bobot Kriteria Perangkingan</h3>
                        <span class="text-xs bg-indigo-500 text-white px-3 py-1 rounded-full font-semibold">Total = 100%</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($criterias as $criteria)
                            @php
                                $weight = $criteria->weight ? floatval($criteria->weight->weight) * 100 : 0;
                                $colors = [
                                    'C1' => ['bg' => 'from-red-500 to-red-600', 'light' => 'from-red-100 to-red-50', 'text' => 'text-red-700', 'darkText' => 'dark:text-red-300', 'icon' => '💵'],
                                    'C2' => ['bg' => 'from-blue-500 to-blue-600', 'light' => 'from-blue-100 to-blue-50', 'text' => 'text-blue-700', 'darkText' => 'dark:text-blue-300', 'icon' => '🗺️'],
                                    'C3' => ['bg' => 'from-green-500 to-green-600', 'light' => 'from-green-100 to-green-50', 'text' => 'text-green-700', 'darkText' => 'dark:text-green-300', 'icon' => '🏛️'],
                                    'C4' => ['bg' => 'from-yellow-500 to-yellow-600', 'light' => 'from-yellow-100 to-yellow-50', 'text' => 'text-yellow-700', 'darkText' => 'dark:text-yellow-300', 'icon' => '⭐'],
                                ];
                                $color = $colors[$criteria->code] ?? ['bg' => 'from-gray-500 to-gray-600', 'light' => 'from-gray-100 to-gray-50', 'text' => 'text-gray-700', 'darkText' => 'dark:text-gray-300', 'icon' => '📌'];
                            @endphp
                            <div class="bg-gradient-to-br {{ $color['light'] }} dark:from-gray-700 dark:to-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl">{{ $color['icon'] }}</span>
                                        <span class="text-sm font-bold text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-600 px-2 py-1 rounded">{{ $criteria->code }}</span>
                                    </div>
                                    <span class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br {{ $color['bg'] }} text-white rounded-full font-bold text-lg shadow">
                                        {{ number_format($weight, 0) }}%
                                    </span>
                                </div>
                                <p class="text-sm font-semibold {{ $color['text'] }} dark:text-gray-300">{{ $criteria->name }}</p>
                                <div class="mt-3 w-full bg-gray-300 dark:bg-gray-600 rounded-full h-2 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r {{ $color['bg'] }} rounded-full transition-all" style="width: {{ $weight }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-300">
                        <p class="font-semibold mb-2">💡 Keterangan:</p>
                        <ul class="space-y-1 text-xs md:text-sm">
                            <li>• Perangkingan wisata dipengaruhi oleh bobot kriteria yang telah ditentukan di atas</li>
                        </ul>
                    </div>
                </div>
            </div>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-dashed border-blue-300 rounded-lg p-12 text-center">
                    <div class="text-5xl mb-4">🎯</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Mulai Cari Wisata Tujuan Anda</h3>
                    <p class="text-gray-600 mb-4">
                        Isi preferensi di atas dan klik "Cari Wisata" untuk mendapatkan rekomendasi sesuai kebutuhan anda
                    </p>
                    <div class="flex justify-center gap-4 text-sm text-gray-600">
                        <div>✅ Filter berdasarkan budget</div>
                        <div>📍 Sesuaikan jarak</div>
                        <div>🏢 Pilih fasilitas</div>
                        <div>⭐ Pilih rating minimal</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function(){
            const useBtn = document.getElementById('use-location');
            const latInput = document.getElementById('user_lat');
            const lngInput = document.getElementById('user_lng');
            const regencyInput = document.getElementById('user_regency');
            const sourceInput = document.getElementById('location_source');
            const regionSelect = document.getElementById('selected_region');
            const form = document.querySelector('form[action="{{ route('saw.recommendations.index') }}"]');
            const submitBtn = form?.querySelector('button[type="submit"]');
            const mapContainer = document.getElementById('userLocationMap');
            const placeholder = document.getElementById('mapPlaceholder');
            const locationStatus = document.getElementById('locationStatus');
            const defaultUseBtnText = useBtn?.textContent || 'Gunakan Posisi Saya';
            const defaultSubmitBtnText = submitBtn?.textContent || 'Cari Wisata';
            const sourceLabels = {
                gps: 'GPS Browser',
                ip: 'IP Geolocation',
                manual: 'Pilihan Manual'
            };
            const supportedRegencies = [
                {name: 'Lombok Barat', aliases: ['lombok barat', 'kabupaten lombok barat']},
                {name: 'Lombok Tengah', aliases: ['lombok tengah', 'kabupaten lombok tengah']},
                {name: 'Lombok Timur', aliases: ['lombok timur', 'kabupaten lombok timur']},
                {name: 'Lombok Utara', aliases: ['lombok utara', 'kabupaten lombok utara']},
            ];
            let leafletMap;
            let userMarker;
            let isResolvingLocation = false;

            function hasValidCoordinates(lat, lng) {
                return Number.isFinite(lat)
                    && Number.isFinite(lng)
                    && lat >= -90
                    && lat <= 90
                    && lng >= -180
                    && lng <= 180;
            }

            function escapeHtml(value) {
                return String(value ?? '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function normalizeRegencyFromCandidates(candidates) {
                const text = candidates
                    .filter(Boolean)
                    .map(function(candidate) {
                        return String(candidate).toLowerCase();
                    })
                    .join(' ');

                const match = supportedRegencies.find(function(regency) {
                    return regency.aliases.some(function(alias) {
                        return text.includes(alias);
                    });
                });

                return match ? match.name : '';
            }

            function showMapMessage(message) {
                if (!mapContainer) return;

                mapContainer.innerHTML = '<div class="flex items-center justify-center h-full px-4 text-center text-gray-500">' + escapeHtml(message) + '</div>';
            }

            function updateLocationStatus(lat, lng, source, regency) {
                if (!locationStatus) return;

                const detectedRegency = regency || 'Kabupaten belum terdeteksi';
                const sourceLabel = sourceLabels[source] || 'Belum diketahui';

                locationStatus.innerHTML = 'Lokasi tersimpan: '
                    + '<span class="font-semibold text-gray-900">' + escapeHtml(detectedRegency) + '</span>'
                    + '<span class="mx-1">•</span>'
                    + escapeHtml(sourceLabel)
                    + '<span class="mx-1">•</span>'
                    + escapeHtml(Number(lat).toFixed(6))
                    + ', '
                    + escapeHtml(Number(lng).toFixed(6));
            }

            function setLocationInputs(location) {
                if (!latInput || !lngInput) return;

                latInput.value = location.lat;
                lngInput.value = location.lng;

                if (regencyInput) {
                    regencyInput.value = location.regency || '';
                }

                if (sourceInput) {
                    sourceInput.value = location.source || '';
                }
            }

            function setLoadingState(isLoading) {
                if (useBtn) {
                    useBtn.disabled = isLoading;
                    useBtn.textContent = isLoading ? 'Mencari posisi...' : defaultUseBtnText;
                }

                if (submitBtn) {
                    submitBtn.disabled = isLoading;
                    submitBtn.textContent = isLoading ? 'Mencari posisi...' : defaultSubmitBtnText;
                }
            }

            function initMap(lat, lng, popupText) {
                if (!mapContainer || !hasValidCoordinates(lat, lng)) return;

                if (typeof L === 'undefined') {
                    showMapMessage('Peta gagal dimuat. Periksa koneksi internet lalu muat ulang halaman.');
                    return;
                }

                if (!leafletMap) {
                    mapContainer.innerHTML = '<div id="leafletMap" style="height: 100%; min-height: 18rem; width: 100%;"></div>';
                    leafletMap = L.map('leafletMap');
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(leafletMap);
                }

                const center = [lat, lng];
                leafletMap.setView(center, 13);

                if (userMarker) {
                    userMarker.setLatLng(center);
                    userMarker.setPopupContent(popupText || 'Lokasi Anda saat ini');
                } else {
                    userMarker = L.marker(center).addTo(leafletMap).bindPopup(popupText || 'Lokasi Anda saat ini').openPopup();
                }

                window.setTimeout(function() {
                    leafletMap.invalidateSize();
                }, 100);
            }

            function syncMapFromInputs() {
                const lat = parseFloat(latInput?.value);
                const lng = parseFloat(lngInput?.value);

                if (hasValidCoordinates(lat, lng)) {
                    if (placeholder) placeholder.remove();
                    const source = sourceInput?.value || '';
                    const regency = regencyInput?.value || '';
                    const popupText = source === 'manual'
                        ? 'Pusat wilayah: ' + regency
                        : 'Lokasi Anda saat ini';
                    initMap(lat, lng, popupText);
                    updateLocationStatus(lat, lng, source, regency);
                    return true;
                }

                return false;
            }

            function getGpsLocation() {
                return new Promise(function(resolve, reject) {
                    if (!navigator.geolocation) {
                        reject(new Error('Geolocation tidak didukung'));
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = parseFloat(position.coords.latitude);
                        const lng = parseFloat(position.coords.longitude);

                        if (!hasValidCoordinates(lat, lng)) {
                            reject(new Error('Koordinat GPS tidak valid'));
                            return;
                        }

                        resolve({lat: lat, lng: lng, source: 'gps', regency: ''});
                    }, reject, {
                        timeout: 10000,
                        enableHighAccuracy: true,
                        maximumAge: 0
                    });
                });
            }

            async function getIpLocation() {
                const response = await fetch('https://ipapi.co/json/');

                if (!response.ok) {
                    throw new Error('Gagal mengambil lokasi dari IP');
                }

                const data = await response.json();
                const lat = parseFloat(data.latitude);
                const lng = parseFloat(data.longitude);

                if (!hasValidCoordinates(lat, lng)) {
                    throw new Error('Koordinat IP tidak valid');
                }

                return {
                    lat: lat,
                    lng: lng,
                    source: 'ip',
                    regency: normalizeRegencyFromCandidates([data.city, data.region, data.region_code])
                };
            }

            async function reverseGeocodeRegency(lat, lng) {
                const params = new URLSearchParams({
                    format: 'jsonv2',
                    lat: lat,
                    lon: lng,
                    zoom: '10',
                    addressdetails: '1',
                    'accept-language': 'id'
                });
                const response = await fetch('https://nominatim.openstreetmap.org/reverse?' + params.toString(), {
                    headers: {
                        Accept: 'application/json'
                    }
                });

                if (!response.ok) {
                    return '';
                }

                const data = await response.json();
                const address = data.address || {};

                return normalizeRegencyFromCandidates([
                    address.county,
                    address.city,
                    address.municipality,
                    address.state_district,
                    address.region,
                    data.display_name
                ]);
            }

            async function resolveUserLocation() {
                let location;

                try {
                    location = await getGpsLocation();
                } catch (gpsError) {
                    location = await getIpLocation();
                }

                try {
                    location.regency = await reverseGeocodeRegency(location.lat, location.lng) || location.regency;
                } catch (reverseError) {
                    location.regency = location.regency || '';
                }

                return location;
            }

            async function resolveLocationAndSubmit() {
                if (!form || isResolvingLocation) return;

                isResolvingLocation = true;
                setLoadingState(true);

                try {
                    const location = await resolveUserLocation();
                    setLocationInputs(location);
                    // GPS/IP succeeded — clear manual region dropdown so it doesn't override
                    if (regionSelect) {
                        regionSelect.value = '';
                    }
                    initMap(location.lat, location.lng, 'Lokasi Anda saat ini');
                    updateLocationStatus(location.lat, location.lng, location.source, location.regency);
                    form.submit();
                } catch (error) {
                    alert('Gagal mendapatkan lokasi otomatis. Silakan pilih wilayah secara manual dari dropdown.');
                    setLoadingState(false);
                    isResolvingLocation = false;
                }
            }

            // Handle manual region dropdown change
            if (regionSelect) {
                regionSelect.addEventListener('change', function() {
                    const selected = regionSelect.options[regionSelect.selectedIndex];
                    if (!selected || !selected.value) {
                        return;
                    }

                    const lat = parseFloat(selected.dataset.lat);
                    const lng = parseFloat(selected.dataset.lng);
                    const regionName = selected.value;

                    if (!hasValidCoordinates(lat, lng)) return;

                    // Set hidden inputs for manual location
                    setLocationInputs({
                        lat: lat,
                        lng: lng,
                        regency: regionName,
                        source: 'manual'
                    });

                    // Show map at region center
                    if (placeholder) placeholder.remove();
                    initMap(lat, lng, 'Pusat wilayah: ' + regionName);
                    updateLocationStatus(lat, lng, 'manual', regionName);
                });
            }

            syncMapFromInputs();

            if (useBtn) {
                useBtn.addEventListener('click', function(){
                    resolveLocationAndSubmit();
                });
            }

            if (form) {
                form.addEventListener('submit', function(event) {
                    const lat = parseFloat(latInput?.value);
                    const lng = parseFloat(lngInput?.value);

                    // If we already have valid coordinates (from GPS, IP, or manual dropdown), submit normally
                    if (hasValidCoordinates(lat, lng)) {
                        return;
                    }

                    // No coordinates at all — try auto-detect before submitting
                    event.preventDefault();
                    resolveLocationAndSubmit();
                });
            }

            const toggleBtn = document.getElementById('toggle-full-list');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(){
                    const full = document.getElementById('fullResults');
                    if (!full) return;

                    if (full.classList.contains('hidden')) {
                        full.classList.remove('hidden');
                        toggleBtn.textContent = 'Sembunyikan daftar lainnya';
                        full.scrollIntoView({behavior: 'smooth'});
                    } else {
                        full.classList.add('hidden');
                        toggleBtn.textContent = 'Lihat daftar lainnya';
                    }
                });
            }
        })();
    </script>
</x-app-layout>
