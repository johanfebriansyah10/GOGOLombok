<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.criterias.update', $criteria) }}" method="POST" data-loading="Memperbarui kriteria...">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="code" class="block text-sm font-medium mb-2">Kode Kriteria</label>
                            <input
                                type="text"
                                id="code"
                                name="code"
                                value="{{ old('code', $criteria->code) }}"
                                placeholder="C1, C2, dst"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                                maxlength="10"
                            >
                            @error('code')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium mb-2">Nama Kriteria</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $criteria->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                            @error('name')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="type" class="block text-sm font-medium mb-2">Tipe Kriteria</label>
                            <select
                                id="type"
                                name="type"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                                <option value="">Pilih Tipe</option>
                                <option value="benefit" {{ old('type', $criteria->type) === 'benefit' ? 'selected' : '' }}>Benefit (Semakin Tinggi Semakin Baik)</option>
                                <option value="cost" {{ old('type', $criteria->type) === 'cost' ? 'selected' : '' }}>Cost (Semakin Rendah Semakin Baik)</option>
                            </select>
                            @error('type')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium mb-2">Deskripsi</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >{{ old('description', $criteria->description) }}</textarea>
                            @error('description')
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
                                href="{{ route('admin.criterias.index') }}"
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
