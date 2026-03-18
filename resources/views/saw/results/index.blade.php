<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Hasil Rekomendasi Wisata (SAW)') }}
            </h2>
            <a href="{{ route('saw.results.analysis') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded flex items-center gap-2">
                📊 Analisis Transparan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :breadcrumbs="[
                ['label' => '📈 Hasil Rekomendasi', 'url' => null]
            ]" />

            @if (isset($error))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Error:</strong> {{ $error }}
                </div>
            @else
                <!-- Kriteria & Bobot Summary -->
                <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Kriteria & Bobot</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach ($criterias as $criteria)
                                <div class="bg-gradient-to-br {{ $criteria->type === 'benefit' ? 'from-green-50 to-green-100' : 'from-red-50 to-red-100' }} dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">{{ $criteria->code }}</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $criteria->weight->weight ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $criteria->name }}</p>
                                    <span class="inline-block text-xs mt-2 px-2 py-1 rounded {{ $criteria->type === 'benefit' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                        {{ $criteria->type === 'benefit' ? 'Benefit' : 'Cost' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="mb-6 bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-500 p-4 rounded">
                    <p class="text-blue-800 dark:text-blue-200 text-sm">
                        <strong>💡 Tip:</strong> Klik tombol "Analisis Transparan" di atas untuk melihat seluruh proses perhitungan SAW secara detail (Matriks Keputusan, Normalisasi, Perhitungan Preferensi, dan Ranking).
                    </p>
                </div>

                <!-- Ranking Table -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">🏆 Ranking Rekomendasi Wisata</h3>

                        @if ($ranking->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                                Belum ada data evaluasi untuk perhitungan SAW
                            </p>
                        @else
                            <!-- Card View for Better Visual -->
                            <div class="space-y-3">
                                @foreach ($ranking as $item)
                                    @php
                                        $wisata = \App\Models\Wisata::find($item['wisata_id']);
                                    @endphp
                                    <a href="{{ route('saw.results.detail', $item['wisata_id']) }}" class="group">
                                        <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-lg hover:from-blue-50 hover:to-blue-100 dark:hover:from-gray-600 dark:hover:to-gray-700 border border-gray-200 dark:border-gray-700 transition-all">
                                            <!-- Rank Badge -->
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br {{ $loop->first ? 'from-yellow-400 to-yellow-500' : ($loop->iteration == 2 ? 'from-gray-400 to-gray-500' : ($loop->iteration == 3 ? 'from-orange-400 to-orange-500' : 'from-blue-500 to-blue-600')) }} text-white rounded-full font-bold text-lg shadow-lg">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </div>

                                            <!-- Image -->
                                            <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-gray-200 dark:bg-gray-600">
                                                @if ($wisata && $wisata->image_url)
                                                    <img src="{{ $wisata->image_url }}" alt="{{ $item['wisata_name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-2xl">🏞️</div>
                                                @endif
                                            </div>

                                            <!-- Info -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-base group-hover:text-blue-600 dark:group-hover:text-blue-400 transition truncate">
                                                    {{ $item['wisata_name'] }}
                                                </h3>
                                                <div class="flex flex-wrap gap-2 mt-2">
                                                    @if ($wisata)
                                                        <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">
                                                            📍 {{ number_format($wisata->distance, 1) }} km
                                                        </span>
                                                        <span class="text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded">
                                                            🎟️ Rp {{ number_format($wisata->ticket_price, 0, '', '.') }}
                                                        </span>
                                                        <span class="text-xs bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-2 py-1 rounded">
                                                            ⭐ {{ number_format($wisata->actual_rating ?? 0, 1) }}/5
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Score -->
                                            <div class="flex-shrink-0 text-right">
                                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                                    {{ number_format($item['score'], 4) }}
                                                </div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 font-semibold">
                                                    {{ number_format($item['score'] * 100, 1) }}%
                                                </div>
                                                <div class="w-32 bg-gray-200 dark:bg-gray-600 rounded-full h-2 mt-2">
                                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $item['score'] * 100 }}%"></div>
                                                </div>
                                            </div>

                                            <!-- Arrow -->
                                            <div class="flex-shrink-0 text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                                →
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
