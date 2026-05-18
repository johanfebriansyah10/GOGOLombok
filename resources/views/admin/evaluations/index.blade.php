<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Halaman Evaluasi') }}
            </h2>
            <form action="{{ route('admin.evaluations.populate') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    + Tambah data evaluasi
                </button>
            </form>
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
                                                        value="{{ ((float)($row[$criteria->id] ?? 0) + 0) === 0 ? '' : ((float)($row[$criteria->id] ?? 0) + 0) }}"
                                                        class="w-full px-2 py-1 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded text-center focus:outline-none focus:ring-2 focus:ring-blue-500" disabled
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

    <script>
        function saveEvaluation(input) {
            const wisataId = input.getAttribute('data-wisata-id');
            const criteriaId = input.getAttribute('data-criteria-id');
            const value = input.value;

            if (value === '') {
                return;
            }

            fetch('{{ route("admin.evaluations.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    wisata_id: wisataId,
                    criteria_id: criteriaId,
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan indikasi visual bahwa data sudah disimpan
                    input.classList.add('border-green-500', 'bg-green-50');
                    setTimeout(() => {
                        input.classList.remove('border-green-500', 'bg-green-50');
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                input.classList.add('border-red-500', 'bg-red-50');
                setTimeout(() => {
                    input.classList.remove('border-red-500', 'bg-red-50');
                }, 1500);
            });
        }
    </script>

</x-app-layout>
