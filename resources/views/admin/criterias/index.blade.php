<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Kriteria & Bobot') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-[95rem] mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ $message }}
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $message }}
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6">
                <div class="flex border-b border-gray-200 dark:border-gray-700">
                    <button onclick="switchTab('criterias')" class="tab-btn active px-6 py-4 font-semibold border-b-2 border-blue-600 text-blue-600">
                        Kriteria
                    </button>
                    <button onclick="switchTab('weights')" class="tab-btn px-6 py-4 font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                        Bobot Kriteria
                    </button>
                </div>
            </div>

            <!-- Kriteria Tab -->
            <div id="criterias-tab" class="tab-content active">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Daftar Kriteria</h3>
                            <a href="{{ route('admin.criterias.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                + Tambah Kriteria
                            </a>
                        </div>

                        @if ($criterias->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                                Belum ada kriteria. <a href="{{ route('admin.criterias.create') }}" class="text-blue-600 hover:text-blue-800">Buat kriteria baru</a>
                            </p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                        <tr>
                                            <th class="px-4 py-3 font-semibold">No</th>
                                            <th class="px-4 py-3 font-semibold">Kode</th>
                                            <th class="px-4 py-3 font-semibold">Nama Kriteria</th>
                                            <th class="px-4 py-3 font-semibold">Tipe</th>
                                            <th class="px-4 py-3 font-semibold">Bobot</th>
                                            <th class="px-4 py-3 font-semibold">Deskripsi</th>
                                            <th class="px-4 py-3 font-semibold">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($criterias as $key => $criteria)
                                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-4 py-3">{{ $criterias->firstItem() + $key }}</td>
                                                <td class="px-4 py-3 font-semibold">{{ $criteria->code }}</td>
                                                <td class="px-4 py-3 font-semibold">{{ $criteria->name }}</td>
                                                <td class="px-4 py-3">
                                                    @if ($criteria->type === 'benefit')
                                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Benefit</span>
                                                    @else
                                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Cost</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if ($criteria->weight)
                                                        <span class="font-semibold text-blue-600">{{ number_format($criteria->weight->weight, 2) }}</span>
                                                    @else
                                                        <span class="text-gray-500">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ $criteria->description ? Str::limit($criteria->description, 30) : '-' }}
                                                </td>
                                                <td class="px-4 py-3 space-x-2">
                                                    <a href="{{ route('admin.criterias.edit', $criteria) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('admin.criterias.destroy', $criteria) }}" method="POST" style="display:inline;" data-confirm-delete="Kriteria '{{ $criteria->name }}' akan dihapus secara permanen" data-confirm-title="Hapus Kriteria?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $criterias->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Weights Tab -->
            <div id="weights-tab" class="tab-content hidden">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Daftar Bobot Kriteria</h3>
                            </div>
                            <a href="{{ route('admin.criterias.create-weight') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                + Tambah Bobot
                            </a>
                        </div>

                        @if ($weights->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                                Belum ada bobot. <a href="{{ route('admin.criterias.create-weight') }}" class="text-blue-600 hover:text-blue-800">Tambah bobot baru</a>
                            </p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                        <tr>
                                            <th class="px-4 py-3 font-semibold">No</th>
                                            <th class="px-4 py-3 font-semibold">Kode Kriteria</th>
                                            <th class="px-4 py-3 font-semibold">Nama Kriteria</th>
                                            <th class="px-4 py-3 font-semibold">Tipe</th>
                                            <th class="px-4 py-3 font-semibold">Bobot</th>
                                            <th class="px-4 py-3 font-semibold">Persentase</th>
                                            <th class="px-4 py-3 font-semibold">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($weights as $key => $weight)
                                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-4 py-3">{{ $weights->firstItem() + $key }}</td>
                                                <td class="px-4 py-3 font-semibold">{{ $weight->criteria->code }}</td>
                                                <td class="px-4 py-3 font-semibold">{{ $weight->criteria->name }}</td>
                                                <td class="px-4 py-3">
                                                    @if ($weight->criteria->type === 'benefit')
                                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Benefit</span>
                                                    @else
                                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Cost</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 font-semibold text-blue-600">
                                                    {{ number_format($weight->weight, 2) }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ number_format($weight->weight * 100, 2) }}%
                                                </td>
                                                <td class="px-4 py-3 space-x-2">
                                                    <a href="{{ route('admin.criterias.edit-weight', $weight) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('admin.criterias.destroy-weight', $weight) }}" method="POST" style="display:inline;" data-confirm-delete="Bobot untuk kriteria '{{ $weight->criteria->name }}' akan dihapus secara permanen" data-confirm-title="Hapus Bobot?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $weights->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('active', 'border-b-2', 'border-blue-600', 'text-blue-600');
                el.classList.add('text-gray-600', 'dark:text-gray-400');
            });

            // Show selected tab
            document.getElementById(tab + '-tab').classList.remove('hidden');
            event.target.classList.add('active', 'border-b-2', 'border-blue-600', 'text-blue-600');
            event.target.classList.remove('text-gray-600', 'dark:text-gray-400');
        }
    </script>
</x-app-layout>
