<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Bobot Kriteria') }}
            </h2>
            <a href="{{ route('admin.weights.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                + Tambah Bobot
            </a>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($weights->isEmpty())
                        <p class="text-gray-500 text-center py-8">
                            Belum ada bobot. <a href="{{ route('admin.weights.create') }}" class="text-blue-600 hover:text-blue-800">Tambah bobot baru</a>
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
                                                {{ number_format($weight->weight, 4) }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ number_format($weight->weight * 100, 2) }}%
                                            </td>
                                            <td class="px-4 py-3 space-x-2">
                                                <a href="{{ route('admin.weights.edit', $weight) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.weights.destroy', $weight) }}" method="POST" style="display:inline;" data-confirm-delete="Bobot untuk kriteria '{{ $weight->criteria->name }}' akan dihapus secara permanen" data-confirm-title="Hapus Bobot?">
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
</x-app-layout>
