<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Analisis Transparansi Perhitungan SAW') }}
            </h2>
            <a href="{{ route('saw.results.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :breadcrumbs="[
                ['label' => '📊 Analisis SAW', 'url' => null]
            ]" />

            <!-- Legend & Information -->
            <div class="mb-6 bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-500 p-4 rounded">
                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">ℹ️ Transparansi SAW Calculation</h3>
                <p class="text-blue-800 dark:text-blue-200 text-sm">
                    Halaman ini menampilkan semua langkah perhitungan SAW (Simple Additive Weighting) secara detail dan transparan.
                </p>
            </div>

            @if (isset($error))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Error:</strong> {{ $error }}
                </div>
            @else
                <!-- STEP 1: Matriks Keputusan -->
                <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-500 text-white font-bold text-sm">1️⃣</div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Matriks Keputusan (Decision Matrix)</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            Nilai asli dari evaluasi setiap wisata terhadap setiap kriteria
                        </p>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold">Wisata</th>
                                        @foreach ($criterias as $criteria)
                                            <th class="px-4 py-3 text-center font-semibold">
                                                {{ $criteria->code }}<br>
                                                <span class="text-xs font-normal">({{ $criteria->type === 'benefit' ? '↑ Benefit' : '↓ Cost' }})</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($decisionMatrix as $row)
                                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $row['wisata_name'] }}
                                            </td>
                                            @foreach ($criterias as $criteria)
                                                @php
                                                    $value = $row['values'][$criteria->id]['value'] ?? 0;
                                                @endphp
                                                <td class="px-4 py-3 text-center">
                                                    <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-900 dark:text-gray-100">
                                                        {{ number_format($value, 2) }}
                                                    </span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ count($criterias) + 1 }}" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                                Belum ada data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Hasil Normalisasi -->
                <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white font-bold text-sm">2️⃣</div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Hasil Normalisasi (rij)</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            Nilai dinormalisasi menggunakan: <br>
                            <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs">Benefit: rij = xij / max(xij) | Cost: rij = min(xij) / xij</code>
                        </p>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold">Wisata</th>
                                        @foreach ($criterias as $criteria)
                                            <th class="px-4 py-3 text-center font-semibold">
                                                {{ $criteria->code }}<br>
                                                <span class="text-xs font-normal">({{ $criteria->type === 'benefit' ? 'Benefit' : 'Cost' }})</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($normalizedMatrix as $row)
                                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $row['wisata_name'] }}
                                            </td>
                                            @foreach ($criterias as $criteria)
                                                @php
                                                    $normalized = $row['normalized_values'][$criteria->id] ?? null;
                                                    if ($normalized) {
                                                        $value = $normalized['original_value'];
                                                        $maxVal = $normalized['max_value'];
                                                        $minVal = $normalized['min_value'];
                                                        $normalizedVal = $normalized['normalized_value'];
                                                    }
                                                @endphp
                                                <td class="px-4 py-3 text-center">
                                                    <div class="text-xs mb-1">
                                                        @if ($criteria->type === 'benefit')
                                                            {{ number_format($value, 2) }} / {{ number_format($maxVal, 2) }}
                                                        @else
                                                            {{ number_format($minVal, 2) }} / {{ number_format($value, 2) }}
                                                        @endif
                                                    </div>
                                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-blue-100 px-2 py-1 rounded font-semibold">
                                                        {{ number_format($normalizedVal, 4) }}
                                                    </span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ count($criterias) + 1 }}" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                                Belum ada data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Max/Min Reference -->
                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded">
                            <p class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Referensi Max/Min per Kriteria:</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach ($criterias as $criteria)
                                    @php
                                        $maxVal = 0;
                                        $minVal = PHP_INT_MAX;
                                        foreach ($normalizedMatrix as $row) {
                                            $normalized = $row['normalized_values'][$criteria->id] ?? null;
                                            if ($normalized) {
                                                $maxVal = max($maxVal, $normalized['max_value']);
                                                $minVal = min($minVal, $normalized['min_value']);
                                            }
                                        }
                                    @endphp
                                    <div class="bg-white dark:bg-gray-800 p-2 rounded text-sm">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $criteria->code }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">Max: {{ number_format($maxVal, 2) }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">Min: {{ number_format($minVal, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Perhitungan Nilai Preferensi -->
                <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-purple-500 text-white font-bold text-sm">3️⃣</div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Perhitungan Nilai Preferensi (Vi = Σ rij × wj)</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            Nilai preferensi dihitung dengan mengalikan nilai normalisasi (rij) dengan bobot kriteria (wj)
                        </p>

                        <div class="space-y-6">
                            @forelse ($normalizedMatrix as $row)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">{{ $row['wisata_name'] }}</h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        @php
                                            $scoreRecord = $scores->firstWhere('wisata_id', $row['wisata_id']);
                                            $totalVi = 0;
                                        @endphp
                                        @foreach ($criterias as $criteria)
                                            @php
                                                $normalized = $row['normalized_values'][$criteria->id] ?? null;
                                                $weight = $criteria->weight->weight ?? 0;
                                                $weighted = ($normalized ? $normalized['normalized_value'] : 0) * $weight;
                                                $totalVi += $weighted;
                                            @endphp
                                            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $criteria->code }} - {{ $criteria->name }}</p>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1 space-y-1">
                                                    <p>rij = {{ number_format($normalized ? $normalized['normalized_value'] : 0, 4) }}</p>
                                                    <p>wj = {{ number_format($weight, 4) }}</p>
                                                    <p class="font-semibold text-blue-600 dark:text-blue-400">
                                                        rij × wj = {{ number_format($weighted, 6) }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-gray-700 dark:to-gray-600 p-4 rounded-lg border-l-4 border-green-500">
                                        <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold mb-1">SKOR AKHIR (Vi)</p>
                                        <p class="text-3xl font-bold text-green-600">{{ number_format($totalVi, 4) }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                            = Σ (rij × wj) = {{ implode(' + ', array_map(function($c) use ($row, $scores) {
                                                $normalized = $row['normalized_values'][$c->id] ?? null;
                                                $weight = $c->weight->weight ?? 0;
                                                $weighted = ($normalized ? $normalized['normalized_value'] : 0) * $weight;
                                                return number_format($weighted, 6);
                                            }, $criterias->all())) }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 dark:text-gray-400">Belum ada data</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- STEP 4: Ranking Akhir -->
                <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-500 text-white font-bold text-sm">4️⃣</div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Ranking Akhir</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            Wisata diurutkan berdasarkan nilai Vi (skor preferensi) dari tertinggi ke terendah
                        </p>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <tr>
                                        <th class="px-4 py-3 text-center font-semibold">Rank</th>
                                        <th class="px-4 py-3 text-left font-semibold">Nama Wisata</th>
                                        <th class="px-4 py-3 text-center font-semibold">Nilai Preferensi (Vi)</th>
                                        <th class="px-4 py-3 text-center font-semibold">Persentase</th>
                                        <th class="px-4 py-3 text-center font-semibold">Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ranking as $item)
                                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 {{ $loop->first ? 'bg-yellow-50 dark:bg-yellow-900' : '' }}">
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-{{ $loop->first ? 'yellow-500' : 'gray-400' }} text-white rounded-full font-bold text-sm">
                                                    {{ $item['rank'] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $item['wisata_name'] }}
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-blue-100 px-3 py-1 rounded font-bold">
                                                    {{ number_format($item['score'], 4) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                {{ number_format($item['score'] * 100, 2) }}%
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $item['score'] * 100 }}%"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                                Belum ada data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Summary Statistics -->
                <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">📊 Ringkasan Statistik</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Total Wisata</p>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $ranking->count() }}</p>
                            </div>
                            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                                <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Total Kriteria</p>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $criterias->count() }}</p>
                            </div>
                            <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                                <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Skor Tertinggi</p>
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($ranking->first()['score'] ?? 0, 4) }}</p>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                                <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Skor Terendah</p>
                                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ number_format($ranking->last()['score'] ?? 0, 4) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>
</x-app-layout>
