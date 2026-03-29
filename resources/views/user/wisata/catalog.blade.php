<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Katalog Wisata') }}
            </h2>
            <div class="flex gap-2">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari wisata..."
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                />
                <select id="categoryFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :breadcrumbs="[
                ['label' => 'Wisata', 'url' => null]
            ]" />

            <!-- Info Box -->
            <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 border-l-4 border-blue-500 p-6 rounded-lg">
                <div class="flex items-start gap-4">
                    <div class="pt-1">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Jelajahi Wisata Terbaik</h3>
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">Temukan berbagai destinasi wisata menarik dengan foto, rating, dan informasi lengkap</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Klik salah satu wisata untuk melihat detail lengkap dan analisis SAW</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            {{-- <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Total Wisata</p>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $wisatas->count() }}</p>
                </div>
                <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg border border-green-200 dark:border-green-800">
                    <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Kategori</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $categories->count() }}</p>
                </div>
                <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg border border-purple-200 dark:border-purple-800">
                    <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Rating Rata-rata</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($wisatas->avg('actual_rating') ?? 0, 1) }}</p>
                </div>
                <div class="bg-orange-50 dark:bg-orange-900 p-4 rounded-lg border border-orange-200 dark:border-orange-800">
                    <p class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Harga Rata-rata</p>
                    <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">Rp {{ number_format($wisatas->avg('ticket_price') ?? 0, 0, '', '.') }}</p>
                </div>
            </div> --}}

            <!-- Wisata Grid -->
            <div id="wisataContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($wisatas as $wisata)
                    <a href="{{ route('wisata.show', $wisata->id) }}" class="group transform transition-all duration-500 hover:z-10" style="animation: fadeInUp 0.5s ease-out; animation-fill-mode: both;" data-category="{{ $wisata->category_id ?? '' }}">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl hover:shadow-2xl transition-all duration-500 h-full flex flex-col transform group-hover:scale-105 group-hover:-translate-y-2">
                            <!-- Image Container with Overlay -->
                            <div class="relative overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 h-64 flex-shrink-0">
                                @if ($wisata->image_url)
                                    <img
                                        src="{{ $wisata->image_url }}"
                                        alt="{{ $wisata->name }}"
                                        class="w-full h-full object-cover group-hover:scale-125 transition-transform duration-700 ease-out"
                                    />
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700">
                                        <div class="text-center">
                                            <p class="text-gray-700 dark:text-gray-300 text-sm">Tidak ada foto</p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Gradient Overlay (Hover Effect) -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                <!-- Rating Badge -->
                                <div class="absolute top-3 right-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-yellow-900 px-4 py-2 rounded-full text-sm font-bold shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                    {{ number_format($wisata->actual_rating ?? 0, 1) }}/5.0
                                </div>

                                <!-- Category Badge -->
                                @if ($wisata->category)
                                    <div class="absolute top-3 left-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg uppercase tracking-wider">
                                        {{ $wisata->category->name }}
                                    </div>
                                @endif

                                <!-- View Count Badge (Bottom Right, on hover) -->
                                <div class="absolute bottom-3 right-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-gray-900 dark:text-white px-3 py-1 rounded-full text-xs font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Detail
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-grow">
                                <!-- Name -->
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2 line-clamp-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition duration-300">
                                    {{ $wisata->name }}
                                </h3>

                                <!-- Location -->
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <p class="line-clamp-2">{{ $wisata->location }}</p>
                                </div>

                                <!-- Info Grid (Enhanced) -->
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <!-- Distance -->
                                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 p-3 rounded-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase tracking-wider">Jarak</p>
                                        <p class="text-gray-900 dark:text-gray-100 font-bold mt-1">{{ number_format($wisata->distance, 1) }} <span class="text-xs">km</span></p>
                                    </div>

                                    <!-- Price -->
                                    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 p-3 rounded-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase tracking-wider">Tiket</p>
                                        <p class="text-gray-900 dark:text-gray-100 font-bold mt-1">
                                            <span class="text-xs">Rp</span> {{ number_format($wisata->ticket_price / 1000, 0) }} <span class="text-xs">rb</span>
                                        </p>
                                    </div>

                                    <!-- Facilities -->
                                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 p-3 rounded-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase tracking-wider">Fasilitas</p>
                                        <p class="text-gray-900 dark:text-gray-100 font-bold mt-1">{{ $wisata->facilities_count ?? 0 }}</p>
                                    </div>

                                    <!-- Overall Score -->
                                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 p-3 rounded-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase tracking-wider">Skor</p>
                                        <p class="text-gray-900 dark:text-gray-100 font-bold mt-1">{{ number_format($wisata->actual_rating ?? 0, 1) }}/5</p>
                                    </div>
                                </div>

                                <!-- Description Preview with Animation -->
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4 flex-grow">
                                    {{ $wisata->description }}
                                </p>

                                <!-- CTA Button with Enhancement -->
                                <div class="flex gap-2 mt-auto">
                                    <button class="flex-1 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold py-2.5 px-4 rounded-lg transition-all duration-300 transform group-hover:shadow-lg text-sm uppercase tracking-wider">
                                        👁️ Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full flex items-center justify-center py-24">
                        <div class="text-center">
                            <div class="text-7xl mb-4">🔍</div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Tidak ada wisata ditemukan</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Coba ubah filter atau kategori Anda</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        // Add keyframe animation dynamically
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);

        // Search dan Filter functionality
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const wisataCards = document.querySelectorAll('#wisataContainer a');

        function filterWisatas() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;

            wisataCards.forEach((card, index) => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const category = card.dataset.category || '';

                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = !selectedCategory || category === selectedCategory;

                const shouldShow = matchesSearch && matchesCategory;
                card.style.display = shouldShow ? 'block' : 'none';

                // Re-trigger animation on filter
                if (shouldShow) {
                    card.style.animation = 'none';
                    setTimeout(() => {
                        card.style.animation = `fadeInUp 0.5s ease-out ${index * 0.05}s forwards`;
                    }, 10);
                }
            });
        }

        searchInput?.addEventListener('keyup', filterWisatas);
        categoryFilter?.addEventListener('change', filterWisatas);
    </script>
</x-app-layout>
