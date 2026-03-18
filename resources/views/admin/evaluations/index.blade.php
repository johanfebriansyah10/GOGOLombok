<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Matrix Penilaian Wisata') }}
            </h2>
            <button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded" onclick="showImportForm()">
                📥 Import CSV
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-[95rem] mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
                <div class="alert-success hidden">{{ $message }}</div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert-error hidden">{{ $message }}</div>
            @endif

            <!-- Kriteria Info -->
            <div class="mb-6 bg-blue-50 dark:bg-gray-700 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-blue-700 dark:text-blue-300 text-sm">
                    <strong>Instruksi:</strong> Masukkan nilai numerik untuk setiap kombinasi wisata-kriteria. Klik sel untuk mengedit nilai.
                </p>
            </div>

            <!-- Matrix Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($wisatas->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                            Belum ada data wisata. Silakan buat wisata terlebih dahulu.
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-3 text-left font-semibold">
                                            Wisata
                                        </th>
                                        @foreach ($criterias as $criteria)
                                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-3 text-center font-semibold">
                                                <div class="font-bold text-blue-600 dark:text-blue-400">{{ $criteria->code }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400">{{ $criteria->name }}</div>
                                                <div class="text-xs {{ $criteria->type === 'benefit' ? 'text-green-600' : 'text-red-600' }} mt-1">
                                                    {{ $criteria->type === 'benefit' ? '↑ Benefit' : '↓ Cost' }}
                                                </div>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matrix as $row)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-3 font-semibold bg-gray-50 dark:bg-gray-700">
                                                {{ $row['wisata_name'] }}
                                            </td>
                                            @foreach ($criterias as $criteria)
                                                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center">
                                                    <input
                                                        type="number"
                                                        step="0.01"
                                                        value="{{ $row[$criteria->id] ?? '' }}"
                                                        class="w-full px-2 py-1 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded text-center focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        data-wisata-id="{{ $row['wisata_id'] }}"
                                                        data-criteria-id="{{ $criteria->id }}"
                                                        onchange="saveEvaluation(this)"
                                                        placeholder="-"
                                                    >
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 bg-green-50 dark:bg-gray-700 border-l-4 border-green-500 p-4 rounded">
                            <p class="text-green-700 dark:text-green-300 text-sm">
                                ✓ Setiap perubahan nilai akan otomatis disimpan
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Import Evaluasi</h3>

            <form action="{{ route('admin.evaluations.import') }}" method="POST" enctype="multipart/form-data" data-loading="Mengimport data...">
                @csrf

                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium mb-2">Pilih File CSV</label>
                    <input
                        type="file"
                        id="file"
                        name="file"
                        accept=".csv,.txt"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"
                        required
                    >
                    <p class="text-gray-600 dark:text-gray-400 text-xs mt-2">
                        Format: Nama Wisata, Kode Kriteria, Nilai
                    </p>
                </div>

                <div class="flex gap-4">
                    <button
                        type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded"
                    >
                        Upload
                    </button>
                    <button
                        type="button"
                        onclick="hideImportForm()"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 rounded"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showImportForm() {
            document.getElementById('importModal').classList.remove('hidden');
        }

        function hideImportForm() {
            document.getElementById('importModal').classList.add('hidden');
        }

        function saveEvaluation(element) {
            const wisataId = element.dataset.wisataId;
            const criteriaId = element.dataset.criteriaId;
            const value = element.value;

            if (!value) return;

            fetch('{{ route("admin.evaluations.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    wisata_id: wisataId,
                    criteria_id: criteriaId,
                    value: parseFloat(value),
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    element.classList.remove('border-red-500');
                    element.classList.add('border-green-500');
                    setTimeout(() => element.classList.remove('border-green-500'), 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                element.classList.add('border-red-500');
            });
        }
    </script>
</x-app-layout>
