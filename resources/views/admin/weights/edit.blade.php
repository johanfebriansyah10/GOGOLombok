<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Bobot Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.weights.update', $weight) }}" method="POST" data-loading="Memperbarui bobot...">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Kriteria</label>
                            <div class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700">
                                <p class="font-semibold">{{ $weight->criteria->code }} - {{ $weight->criteria->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $weight->criteria->description }}</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="weight" class="block text-sm font-medium mb-2">Bobot (0 - 1)</label>
                            <input
                                type="number"
                                id="weight"
                                name="weight"
                                value="{{ old('weight', $weight->weight) }}"
                                step="0.0001"
                                min="0"
                                max="1"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                                placeholder="0.2"
                            >
                            <p class="text-gray-600 dark:text-gray-400 text-xs mt-2">
                                Contoh: 0.2 = 20%, 0.25 = 25%, dsb.
                            </p>
                            @error('weight')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
                            >
                                Simpan Perubahan
                            </button>
                            <a
                                href="{{ route('admin.weights.index') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded"
                            >
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
