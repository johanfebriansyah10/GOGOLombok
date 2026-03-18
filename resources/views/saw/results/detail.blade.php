<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Perhitungan SAW') }}
            </h2>
            <a href="{{ route('saw.results.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Wisata Card -->
            <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Image -->
                        @if ($wisata->image_url)
                            <div class="md:col-span-1">
                                <img src="{{ $wisata->image_url }}" alt="{{ $wisata->name }}" class="w-full h-64 object-cover rounded-lg">
                            </div>
                        @endif

                        <!-- Info -->
                        <div class="md:col-span-2">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $wisata->name }}</h3>

                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300">{{ $wisata->description }}</p>
                            </div>

                            <!-- Score Card -->
                            <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg">
                                <p class="text-gray-600 dark:text-gray-300 text-sm font-semibold mb-2">SKOR SAW (Vi)</p>
                                <p class="text-5xl font-bold text-green-600">{{ number_format($scoreDetail['score'], 4) }}</p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                                    {{ number_format($scoreDetail['score'] * 100, 2) }}% - Ranking #{{ $scoreDetail['rank'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calculation Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                        Rincian Perhitungan: Vi = Σ (rij × wj)
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Kriteria</th>
                                    <th class="px-4 py-3 text-center font-semibold">Nilai Normalisasi (rij)</th>
                                    <th class="px-4 py-3 text-center font-semibold">Bobot (wj)</th>
                                    <th class="px-4 py-3 text-center font-semibold">rij × wj</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalWeighted = 0; @endphp
                                @foreach ($scoreDetail['score_details'] as $detail)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 font-semibold">
                                            {{ $detail['criteria_code'] }} - {{ $detail['criteria_name'] }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-blue-100 px-2 py-1 rounded">
                                                {{ number_format($detail['normalized'], 4) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="font-semibold">{{ number_format($detail['weight'], 4) }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center font-bold text-green-600">
                                            {{ number_format($detail['weighted'], 6) }}
                                        </td>
                                    </tr>
                                    @php $totalWeighted += $detail['weighted']; @endphp
                                @endforeach
                                <tr class="bg-gray-100 dark:bg-gray-700 font-bold">
                                    <td colspan="3" class="px-4 py-3 text-right">Total (Vi) =</td>
                                    <td class="px-4 py-3 text-center text-green-600">
                                        {{ number_format($totalWeighted, 4) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Ranking Comparison -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Perbandingan Ranking</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Rank</th>
                                    <th class="px-4 py-3 text-left font-semibold">Nama Wisata</th>
                                    <th class="px-4 py-3 text-right font-semibold">Skor Vi</th>
                                    <th class="px-4 py-3 font-semibold">Grafik</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ranking as $item)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 {{ $item['wisata_id'] == $wisata->id ? 'bg-green-50 dark:bg-gray-700' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center justify-center w-6 h-6 {{ $item['wisata_id'] == $wisata->id ? 'bg-green-500' : 'bg-gray-300' }} text-white text-xs rounded-full font-bold">
                                                {{ $loop->iteration }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-semibold {{ $item['wisata_id'] == $wisata->id ? 'text-green-600' : '' }}">
                                            {{ $item['wisata_name'] }}
                                        </td>
                                        <td class="px-4 py-3 text-right font-bold">
                                            {{ number_format($item['score'], 4) }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $item['score'] * 100 }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
