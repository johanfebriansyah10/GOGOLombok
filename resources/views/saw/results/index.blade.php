<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Hasil Rekomendasi Wisata (SAW)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :breadcrumbs="[
                ['label' => 'Hasil Rekomendasi', 'url' => null]
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
                                    <a href="" class="group">
                                        <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg hover:from-blue-50 hover:to-blue-100 border-gray-200">
                                            <!-- Rank Badge -->
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br {{ $loop->first ? 'from-yellow-400 to-yellow-500' : ($loop->iteration == 2 ? 'from-gray-400 to-gray-500' : ($loop->iteration == 3 ? 'from-orange-400 to-orange-500' : 'from-blue-500 to-blue-600')) }} text-white rounded-full font-bold text-lg shadow-lg">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </div>

                                            <!-- Image -->
                                            <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-gray-200">
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
                                                            📍 {{ number_format($wisata->distance ?? 0, 1) }} km
                                                        </span>
                                                        <span class="text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded">
                                                            🎟️ Rp {{ number_format($wisata->ticket_price ?? 0, 0, ',', '.') }}
                                                        </span>
                                                        <span class="text-xs bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-2 py-1 rounded">
                                                            ⭐ {{ number_format($wisata->actual_rating ?? 0, 1) }}/5
                                                        </span>
                                                        <span class="text-xs bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-2 py-1 rounded">
                                                            📚 {{ optional($wisata->category)->name ?? 'Kategori tidak tersedia' }}
                                                        </span>
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
