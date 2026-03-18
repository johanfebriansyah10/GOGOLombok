<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Bobot Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.weights.store') }}" method="POST" data-loading="Membuat bobot...">
                        @csrf

                        <div class="mb-6">
                            <label for="criteria_id" class="block text-sm font-medium mb-2">Pilih Kriteria</label>
                            <select
                                id="criteria_id"
                                name="criteria_id"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                                <option value="">-- Pilih Kriteria --</option>
                                @foreach ($criterias as $criteria)
                                    <option value="{{ $criteria->id }}" {{ old('criteria_id') == $criteria->id ? 'selected' : '' }}>
                                        {{ $criteria->code }} - {{ $criteria->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('criteria_id')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <input
                                type="number"
                                id="weight"
                                name="weight"
                                value="{{ old('weight') }}"
                                step="0.0001"
                                min="0"
                                max="1"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                                placeholder="0.2"
                            >
                            @error('weight')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
                            >
                                Simpan Bobot
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
