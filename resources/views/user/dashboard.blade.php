<x-app-layout>
    <!-- HERO SECTION -->
    <section class="relative min-h-[92vh] flex flex-col justify-center items-center text-white overflow-hidden" style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('images/pantai1.avif') center/cover no-repeat;">
        <div class="max-w-[700px] animate-fadeInUp opacity-0 text-center mt-28" style="animation-delay: 0.2s">
            {{-- badge --}}
            <div class="absolute -top-20 left-32 z-10">
                <span class="inline-block px-3 py-4 bg-[#34C759]/70 text-5xl font-semibold uppercase rounded-lg">Selamat Datang</span>
            </div>
            {{-- di sebelah kiri --}}
            <h1 class="text-5xl md:text-6xl font-bold mb-4 leading-tight mt-6 text-center">Jelajahi Keindahan</h1>
            <span style="font-family: 'Aladin', system-ui;" class="text-9xl ">Lombok</span>
            <p class="text-lg md:text-2xl text-white/90 mb-10 font-light">Temukan harmoni alam dan budaya di setiap sudut pulau. Sistem rekomendasi kami akan memandu anda menuju  wisata yang sesuai dengan minat Anda.</p>
            <div class="flex gap-4 justify-center flex-wrap animate-fadeInUp opacity-0 mt-6" style="animation-delay: 0.4s">
                <a href="{{ route('wisata.catalog') }}" class="px-8 py-4 bg-[#34C759] text-white rounded-lg font-semibold transition-all duration-300 hover:bg-[#2dac4c] hover:-translate-y-0.5 shadow-lg hover:shadow-xl">Jelajahi Wisata</a>
                <a href="#kategori" class="px-8 py-4 bg-transparent text-white border-2 border-white rounded-lg font-semibold transition-all duration-300 hover:bg-white hover:text-[#34C759]">Lihat Kategori</a>
            </div>
        </div>
    </section>

    <!-- ABOUT LOMBOK SECTION -->
    <section class="py-20 px-8 mx-auto max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Image -->
            <div class="relative">
                <img src="{{ 'images/rinjani.avif' }}" alt="Sejarah Lombok" class="w-full rounded-2xl shadow-2xl object-cover h-[500px]">
                <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-[#34C759]/20 rounded-full blur-3xl"></div>
            </div>

            <!-- Right Side - Content -->
            <div class="space-y-6">
                <div>
                    <span class="inline-block px-4 py-2 bg-[#34C759]/10 text-[#34C759] text-sm font-semibold rounded-full mb-4">Tentang Lombok</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6 leading-tight">Sejarah & Keindahan Lombok</h2>
                </div>

                <p class="text-lg text-gray-700 leading-relaxed">
                    Lombok adalah pulau yang kaya dengan sejarah panjang dan keindahan alam yang memukau. Terletak di nusantara, pulau ini telah menjadi rumah bagi berbagai peradaban dan budaya yang berkembang selama berabad-abad.
                </p>

                <p class="text-lg text-gray-700 leading-relaxed">
                    Dengan pegunungan yang menjulang, pantai-pantai berpasir putih, dan air terjun yang mempesona, Lombok menawarkan pengalaman wisata yang tak terlupakan. Setiap sudut pulau ini menceritakan kisah unik tentang kekayaan alam dan warisan budaya yang diwariskan dari generasi ke generasi.
                </p>

                <div class="grid grid-cols-3 gap-4 pt-4">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-3xl font-bold text-[#34C759] mb-2">4</div>
                        <p class="text-sm text-gray-600">Kabupaten</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-3xl font-bold text-[#34C759] mb-2">50+</div>
                        <p class="text-sm text-gray-600">Destinasi Wisata</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-3xl font-bold text-[#34C759] mb-2">1000+</div>
                        <p class="text-sm text-gray-600">Masjid</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CATEGORIES SECTION -->
    <section class="py-12 px-8 mx-auto" id="kategori">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-[#34C759]/10 text-[#34C759] text-sm font-semibold rounded-full mb-4">Kategori</span>
            <h2 class="text-3xl md:text-5xl font-bold text-gray-800 mb-4">Kategori Wisata</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Jelajahi berbagai jenis destinasi wisata sesuai dengan minat Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            {{-- pantai --}}
            <a href="" class="relative h-[600px] overflow-hidden rounded-md no-underline block mb-4 shadow-md">
                <img src="{{ 'images/pantai.avif' }}" alt="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-block px-3 py-1 bg-[#34C759] text-white text-xs font-semibold rounded-full uppercase tracking-wide">Pantai</span>
                </div>

                <!-- Bottom-left description -->
                <div class="absolute bottom-12 left-4 right-4 z-10">
                    <h3 class="text-2xl font-bold text-white mb-2 leading-snug"><i class="fa-solid fa-water" style="color: rgb(99, 230, 190);"></i> Pantai</h3>
                    <p class="text-white text-sm leading-relaxed line-clamp-3">Nikmati perpaduan sempurna antara hamparan pasir halus dan birunya air laut. Sebagai batas alami daratan, pantai menawarkan bentang garis alam yang unik dan menawan di sepanjang pesisir nusantara.</p>
                </div>
            </a>
            {{-- air terjun --}}
            <a href="" class="relative h-[600px] overflow-hidden rounded-md no-underline block mb-4 shadow-md">
                <img src="{{ 'images/Air Terjun.avif' }}" alt="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-block px-3 py-1 bg-[#34C759] text-white text-xs font-semibold rounded-full uppercase tracking-wide">Air Terjun</span>
                </div>

                <!-- Bottom-left description -->
                <div class="absolute bottom-12 left-4 right-4 z-10">
                    <h3 class="text-2xl font-bold text-white mb-2 leading-snug"> <i class="fa-solid fa-droplet" style="color: rgb(99, 230, 190);"></i>Air Terjun</h3>
                    <p class="text-white text-sm leading-relaxed line-clamp-3">Rasakan kesegaran aliran air yang jatuh bebas dari tebing bebatuan alami. Terbentuk dari proses alam selama ribuan tahun, air terjun merupakan mahakarya geologi yang sering ditemukan di jantung pegunungan yang asri. Tak hanya yang alami, kini keindahan gemericik air ini juga bisa ditemukan di taman-taman cantik sebagai penyejuk suasana.</p>
                </div>
            </a>
            {{-- Bukit --}}
            <a href="" class="relative h-[600px] overflow-hidden rounded-md no-underline block mb-4 shadow-md">
                <img src="{{ 'images/2.avif' }}" alt="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-block px-3 py-1 bg-[#34C759] text-white text-xs font-semibold rounded-full uppercase tracking-wide">Bukit</span>
                </div>

                <!-- Bottom-left description -->
                <div class="absolute bottom-12 left-4 right-4 z-10">
                    <h3 class="text-2xl font-bold text-white mb-2 leading-snug"><i class="fa-solid fa-mountain" style="color: rgb(99, 230, 190);"></i> Bukit</h3>
                    <p class="text-white text-sm leading-relaxed line-clamp-3">Daratan yang menonjol lebih tinggi, memberikan elevasi sempurna untuk menikmati udara segar dan pemandangan luas. Berbeda dengan gunung yang terjal, perbukitan adalah hamparan gundukan tanah hijau yang berjajar luas, menciptakan lekukan alam yang ikonik dan menenangkan jiwa.</p>
                </div>
            </a>
            {{-- Budaya --}}
            <a href="" class="relative h-[600px] overflow-hidden rounded-md no-underline block mb-4 shadow-md">
                <img src="{{ 'images/budaya.avif' }}" alt="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-block px-3 py-1 bg-[#34C759] text-white text-xs font-semibold rounded-full uppercase tracking-wide">Budaya</span>
                </div>

                <!-- Bottom-left description -->
                <div class="absolute bottom-12 left-4 right-4 z-10">
                    <h3 class="text-2xl font-bold text-white mb-2 leading-snug"><i class="fa-solid fa-timeline" style="color: rgb(99, 230, 190);"></i> Budaya</h3>
                    <p class="text-white text-sm leading-relaxed line-clamp-3">Budaya adalah warisan yang terus tumbuh dan bisa dipelajari melalui interaksi langsung. Dengan mengunjungi destinasi baru, Anda tidak hanya melihat pemandangan, tapi juga belajar menyelami cara hidup masyarakatnya yang khas dan penuh makna.</p>
                </div>
            </a>
            {{-- Taman --}}
            <a href="" class="relative h-[600px] overflow-hidden rounded-md no-underline block mb-4 shadow-md">
                <img src="{{ 'images/taman2.avif' }}" alt="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-block px-3 py-1 bg-[#34C759] text-white text-xs font-semibold rounded-full uppercase tracking-wide">Taman</span>
                </div>

                <!-- Bottom-left description -->
                <div class="absolute bottom-12 left-4 right-4 z-10">
                    <h3 class="text-2xl font-bold text-white mb-2 leading-snug"><i class="fa-solid fa-leaf" style="color: rgb(99, 230, 190);"></i> Taman</h3>
                    <p class="text-white text-sm leading-relaxed line-clamp-3">Taman adalah ruang yang dirancang untuk menawarkan kenyamanan dan keindahan alami. Dengan berbagai fasilitas dan景观, taman memberikan pengalaman yang menyenangkan bagi pengunjung dari segala usia.</p>
                </div>
            </a>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="py-20 px-8 mx-auto max-w-6xl">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-[#34C759]/10 text-[#34C759] text-sm font-semibold rounded-full mb-4">Fitur Andalan</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Kemudahan dalam Setiap Langkah</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Nikmati pengalaman wisata yang lebih baik dengan fitur-fitur yang dirancang khusus untuk Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="inline-block p-4 bg-[#34C759]/10 rounded-xl mb-6">
                    <i class="fa-solid fa-brain text-3xl text-[#34C759]"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Filter Cerdas</h3>
                <p class="text-gray-600 leading-relaxed">Sistem kami memberikan rekomendasi wisata yang dipersonalisasi berdasarkan preferensi dan kriteria Anda</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="inline-block p-4 bg-[#34C759]/10 rounded-xl mb-6">
                    <i class="fa-solid fa-compass text-3xl text-[#34C759]"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Penjelajahan Mudah</h3>
                <p class="text-gray-600 leading-relaxed">Jelajahi destinasi wisata dengan antarmuka yang intuitif dan navigasi yang user-friendly</p>
            </div>
        </div>
    </section>

    <!-- ABOUT WEBSITE SECTION -->
    <section class="py-20 px-8 mx-auto max-w-6xl bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-[#34C759]/10 text-[#34C759] text-sm font-semibold rounded-full mb-4">Tentang</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Tentang Website Ini</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Platform rekomendasi wisata Lombok yang didukung fitur filter destinasi wisata berdasarkan keinginan Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h3 class="text-2xl font-bold text-gray-800">Misi</h3>
                <p class="text-gray-700 leading-relaxed">
                    Website ini dibuat dengan tujuan memudahkan wisatawan dalam menemukan destinasi wisata terbaik di Lombok. Menggunakan sistem rekomendasi berbasis kriteria dan preferensi, untuk membantu Anda membuat keputusan perjalanan yang tepat.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    Setiap destinasi yang direkomendasikan telah dianalisis berdasarkan berbagai faktor penting seperti Harga, Jarak, fasilitas, dan Rating.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3">
                        <span class="inline-block w-2 h-2 bg-[#34C759] rounded-full"></span>
                        <span class="text-gray-700">Memberikan rekomendasi yang dipersonalisasi</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="inline-block w-2 h-2 bg-[#34C759] rounded-full"></span>
                        <span class="text-gray-700">Menyediakan informasi lengkap setiap destinasi</span>
                    </li>
                </ul>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-[#34C759]/10 rounded-lg">
                            <i class="fa-solid fa-users text-2xl text-[#34C759]"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Saya</h4>
                            <p class="text-sm text-gray-600">Mahasiswa Semester Akhir</p>
                        </div>
                    </div>
                    <p class="text-gray-700">Mahasiswa yang ingin mengimplementasikan project ini sebagai bagian dari tugas akhirnya</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-[#34C759]/10 rounded-lg">
                            <i class="fa-solid fa-rocket text-2xl text-[#34C759]"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Teknologi</h4>
                            <p class="text-sm text-gray-600">Inovasi terdepan</p>
                        </div>
                    </div>
                    <p class="text-gray-700">Menggunakan Framework modern untuk membangun website yang interaktif dan responsif</p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
