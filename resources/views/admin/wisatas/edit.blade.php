<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Alternatif') }}
            </h2>

            <a
            href="{{ route('admin.wisatas.index') }}"
            class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded"
            >
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.wisatas.update', $wisata) }}" method="POST" enctype="multipart/form-data" data-loading="Memperbarui wisata...">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="category_id" class="block text-sm font-medium mb-2">Kategori</label>
                            <select
                                id="category_id"
                                name="category_id"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $wisata->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium mb-2">Nama Wisata</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $wisata->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                            @error('name')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium mb-2">Deskripsi</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >{{ old('description', $wisata->description) }}</textarea>
                            @error('description')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <div>
                                <label for="location" class="block text-sm font-medium mb-2">Lokasi (Nama)</label>
                                <input
                                    type="text"
                                    id="location"
                                    name="location"
                                    value="{{ old('location', $wisata->location) }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                                @error('location')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="address" class="block text-sm font-medium mb-2">Alamat Lengkap</label>
                            <textarea
                                id="address"
                                name="address"
                                rows="2"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >{{ old('address', $wisata->address) }}</textarea>
                            @error('address')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="latitude" class="block text-sm font-medium mb-2">Latitude</label>
                                <input
                                    type="number"
                                    id="latitude"
                                    name="latitude"
                                    step="0.00000001"
                                    value="{{ old('latitude', $wisata->latitude) }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                @error('latitude')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="longitude" class="block text-sm font-medium mb-2">Longitude</label>
                                <input
                                    type="number"
                                    id="longitude"
                                    name="longitude"
                                    step="0.00000001"
                                    value="{{ old('longitude', $wisata->longitude) }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                @error('longitude')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Filter Related Fields -->
                        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                            <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-4">📊 Data untuk Filter & SAW</h3>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="ticket_price" class="block text-sm font-medium mb-2">💰 Harga Tiket Masuk (Rp)</label>
                                    <input
                                        type="number"
                                        id="ticket_price"
                                        name="ticket_price"
                                        step="1000"
                                        min="0"
                                        value="{{ old('ticket_price', intval($wisata->ticket_price)) }}"
                                        placeholder="Contoh: 150000"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    >
                                    @error('ticket_price')
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="distance" class="block text-sm font-medium mb-2">📍 Jarak dari Pusat Kota (km)</label>
                                    <input
                                        type="number"
                                        id="distance"
                                        name="distance"
                                        step="0.1"
                                        min="0"
                                        value="{{ old('distance', (float)$wisata->distance + 0) }}"
                                        placeholder="Contoh: 25.5"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    >
                                    @error('distance')
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="facilities_count" class="block text-sm font-medium mb-2">🏢 Jumlah Fasilitas</label>
                                    <input
                                        type="number"
                                        id="facilities_count"
                                        name="facilities_count"
                                        step="1"
                                        min="0"
                                        value="{{ old('facilities_count', intval($wisata->facilities_count)) }}"
                                        placeholder="Contoh: 12 (restoran, toilet, parkir, dll)"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    >
                                    @error('facilities_count')
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="actual_rating" class="block text-sm font-medium mb-2">⭐ Rating Pengunjung (0-5)</label>
                                    <input
                                        type="number"
                                        id="actual_rating"
                                        name="actual_rating"
                                        step="0.1"
                                        min="0"
                                        max="5"
                                        value="{{ old('actual_rating', $wisata->actual_rating) }}"
                                        placeholder="Contoh: 4.5"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    >
                                    @error('actual_rating')
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="review_count" class="block text-sm font-medium mb-2">👥 Jumlah Reviewer</label>
                                    <input
                                        type="number"
                                        id="review_count"
                                        name="review_count"
                                        step="1"
                                        min="0"
                                        value="{{ old('review_count', intval($wisata->review_count ?? 0)) }}"
                                        placeholder="Contoh: 1000"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    >
                                    @error('review_count')
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-2 mt-2">
                                <label class="block text-sm font-medium mb-2">🏢 Fasilitas Tersedia</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @php
                                        $facilityOptions = ['Toilet', 'Musholla / Masjid', 'Parkir', 'Spot Foto', 'Kuliner', 'WiFi', 'Pemandu Wisata', 'Tempat Sampah', 'Bangku Tempat Duduk', 'Gazebo', 'Cafe', 'Kios Suvenir', 'ATM', 'Tempat Bermain Anak', 'Penginapan', 'Pusat Informasi Wisata', 'Outbound', 'Klinik', 'Penyewaan Alat Snorkeling', 'Area Camping', 'Kolam Renang'];
                                        $facilityLabels = [
                                            'Toilet' => 'Toilet',
                                            'Musholla / Masjid' => 'Musholla / Masjid',
                                            'Parkir' => 'Parkir',
                                            'Spot Foto' => 'Spot Foto',
                                            'Kuliner' => 'Kuliner',
                                            'WiFi' => 'WiFi',
                                            'Pemandu Wisata' => 'Pemandu Wisata',
                                            'Tempat Sampah' => 'Tempat Sampah',
                                            'Bangku Tempat Duduk' => 'Bangku Tempat Duduk',
                                            'Gazebo' => 'Gazebo',
                                            'Cafe' => 'Cafe',
                                            'Kios Suvenir' => 'Kios Suvenir',
                                            'ATM' => 'ATM',
                                            'Tempat Bermain Anak' => 'Tempat Bermain Anak',
                                            'Penginapan' => 'Penginapan',
                                            'Pusat Informasi Wisata' => 'Pusat Informasi Wisata',
                                            'Outbound' => 'Outbound',
                                            'Klinik' => 'Klinik',
                                            'Penyewaan Alat Snorkeling' => 'Penyewaan Alat Snorkeling',
                                            'Area Camping' => 'Area Camping',
                                            'Kolam Renang' => 'Kolam Renang',
                                        ];
                                        $selectedFacilities = old('facilities', $wisata->facilities ?? []);
                                    @endphp
                                    @foreach($facilityOptions as $facility)
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            name="facilities[]"
                                            value="{{ $facility }}"
                                            {{ in_array($facility, $selectedFacilities) ? 'checked' : '' }}
                                            class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-700"
                                        >
                                        <span class="ml-2 text-sm">{{ $facilityLabels[$facility] }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('facilities')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium mb-2">Foto Wisata</label>
                            @if ($wisata->image_url)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Foto Saat Ini:</p>
                                    <img src="{{ $wisata->image_url }}" alt="{{ $wisata->name }}" class="w-40 h-40 object-cover rounded">
                                </div>
                            @endif
                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept=".jpg,.jpeg,.png,.gif,.bmp,.webp,.avif,image/*"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <p class="text-gray-500 text-xs mt-2">Maksimal ukuran gambar 2MB. Format yang didukung: JPG, JPEG, PNG, GIF, BMP, WebP, AVIF. Biarkan kosong jika tidak ingin mengubah foto.</p>
                            @error('image')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-4 justify-center mb-4">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
                            >
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
