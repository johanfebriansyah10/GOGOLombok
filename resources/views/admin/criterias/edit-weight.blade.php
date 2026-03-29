<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Bobot Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.criterias.update-weight', $weight) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="criteria_id" class="block text-sm font-medium mb-2">
                                Kriteria
                            </label>
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                {{ $weight->criteria->code }} - {{ $weight->criteria->name }}
                            </div>
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-medium mb-2">
                                Bobot (0.0 - 1.0) <span class="text-red-600">*</span>
                            </label>
                            <input type="number" id="weight" name="weight" required step="0.0001" min="0" max="1" value="{{ old('weight', $weight->weight) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('weight')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                Total bobot semua kriteria harus = 1.0
                            </p>
                        </div>

                        <div class="flex justify-between pt-6">
                            <a href="{{ route('admin.criterias.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                Perbarui Bobot
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
