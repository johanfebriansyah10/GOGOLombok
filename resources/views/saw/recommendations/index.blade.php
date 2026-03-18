<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rekomendasi Wisata SAW') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('saw.results.analysis') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded flex items-center gap-2 text-sm">
                    📊 Analisis Transparan
                </a>
                <a href="{{ route('saw.results.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded flex items-center gap-2 text-sm">
                    📈 Ranking SAW
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :breadcrumbs="[
                ['label' => 'Rekomendasi SAW', 'url' => null]
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
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Cari wisata dengan harga tiket ≤ nilai ini</p>
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
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Cari wisata dalam jarak ≤ nilai ini dari pusat kota</p>
                            </div>

                            <!-- Fasilitas Minimal -->
                            <div>
                                <label for="min_facilities" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jumlah Fasilitas Minimal
                                </label>
                                <div>
                                    <input
                                        type="number"
                                        id="min_facilities"
                                        name="min_facilities"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Contoh: 5"
                                        value="{{ $filters['min_facilities'] ?? '' }}"
                                        step="1"
                                        min="0"
                                    />
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Minimal restoran, toilet, parkir, dll</p>
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

            <!-- Kriteria & Bobot Summary -->
            {{-- <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">📊 Kriteria & Bobot Perhitungan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($criterias as $criteria)
                            <div class="bg-gradient-to-br {{ $criteria->type === 'benefit' ? 'from-green-50 to-green-100' : 'from-red-50 to-red-100' }} dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg border {{ $criteria->type === 'benefit' ? 'border-green-300' : 'border-red-300' }}">
                                <p class="text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase">{{ $criteria->code }}</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $criteria->weight->weight ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-700 dark:text-gray-300 font-medium mb-2">{{ $criteria->name }}</p>
                                <div class="flex gap-1">
                                    <span class="inline-block text-xs px-2 py-1 rounded font-semibold {{ $criteria->type === 'benefit' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                        {{ $criteria->type === 'benefit' ? '✓ Benefit' : '↓ Cost' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div> --}}

            <!-- Results Section -->
            @if ($hasFilters || (isset($result) && isset($result['error'])))
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
                                @if ($hasFilters)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                        Sistem telah memfilter wisata berdasarkan preferensi Anda, kemudian menghitung skor SAW untuk rangkuman hasil
                                    </p>
                                @endif
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
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Skor SAW</th>
                                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100 text-center">Aksi</th>
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
                                                        <span class="text-gray-900 dark:text-gray-100">{{ $wisata->distance ?? 0 }} km</span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $wisata->facilities_count >= 10 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : ($wisata->facilities_count >= 5 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                                            🏢 {{ $wisata->facilities_count }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-1">
                                                            <span class="text-yellow-400">⭐</span>
                                                            <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $wisata->actual_rating ?? 0 }}/5</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex flex-col">
                                                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                                                {{ number_format($item['score'], 4) }}
                                                            </span>
                                                            <span class="text-xs text-gray-600 dark:text-gray-400">
                                                                @php
                                                                    $percentage = $item['score'] * 100;
                                                                @endphp
                                                                {{ number_format($percentage, 1) }}%
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <a href="{{ route('saw.results.detail', $item['wisata_id']) }}" class="inline-block px-3 py-2 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition">
                                                            Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Statistics Summary -->
                                <div class="mt-6 grid grid-cols-2 md:grid-cols-5 gap-4">
                                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg">
                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Total Wisata</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $result['ranking']->count() }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg">
                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Skor Tertinggi</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($result['ranking']->first()['score'] ?? 0, 4) }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg">
                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Skor Terendah</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($result['ranking']->last()['score'] ?? 0, 4) }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg">
                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Rata-rata Skor</p>
                                        @php
                                            $avgScore = $result['ranking']->avg('score');
                                        @endphp
                                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($avgScore, 4) }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-pink-50 to-pink-100 dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg">
                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Rekomendasi Top</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">🏆 #1</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <!-- Initial State - No Filter Applied -->
                {{-- <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 border-2 border-dashed border-blue-300 dark:border-gray-600 rounded-lg p-12 text-center">
                    <div class="text-5xl mb-4">🎯</div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Mulai Cari Wisata Impian Anda</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Isi preferensi di atas dan klik "Cari Wisata" untuk mendapatkan rekomendasi yang dipersonalisasi
                    </p>
                    <div class="flex justify-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                        <div>✅ Filter berdasarkan budget</div>
                        <div>📍 Sesuaikan jarak</div>
                        <div>🏢 Tentukan fasilitas</div>
                        <div>⭐ Pilih rating minimal</div>
                    </div>
                </div> --}}
            @endif
        </div>
    </div>
</x-app-layout>
