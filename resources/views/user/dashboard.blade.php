<x-app-layout>
    <!-- HERO SECTION -->
    <section class="hero-container" style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('images/pantai1.avif') center/cover no-repeat;">
        <div class="hero-content" style="animation-delay: 0.2s">
            <div class="hero-badge">
                <span class="hero-badge-text">Selamat Datang</span>
            </div>
            <h1 class="hero-title">Jelajahi Keindahan</h1>
            <span style="font-family: 'Aladin', system-ui;" class="hero-subtitle">Lombok</span>
            <p class="hero-description">Temukan harmoni alam dan budaya di setiap sudut pulau. Sistem rekomendasi kami akan memandu anda menuju  wisata yang sesuai dengan minat Anda.</p>
            <div class="hero-buttons" style="animation-delay: 0.4s">
                <a href="{{ route('wisata.catalog') }}" class="hero-btn-primary">Jelajahi Wisata</a>
                <a href="#kategori" class="hero-btn-secondary">Lihat Kategori</a>
            </div>
        </div>
    </section>

    <!-- ABOUT LOMBOK SECTION -->
    <section class="py-20 px-8 mx-auto max-w-6xl">
        <div class="about-grid">
            <!-- Left Side - Image -->
            <div class="about-image">
                <img src="{{ 'images/rinjani.avif' }}" alt="Sejarah Lombok" class="about-image-img">
                <div class="about-image-accent"></div>
            </div>

            <!-- Right Side - Content -->
            <div class="about-content">
                <div>
                    <span class="section-badge">Tentang Lombok</span>
                    <h2 class="section-title">Sejarah & Keindahan Lombok</h2>
                </div>

                <p class="text-lg text-gray-700 leading-relaxed">
                    Lombok adalah pulau yang kaya dengan sejarah panjang dan keindahan alam yang memukau. Terletak di nusantara, pulau ini telah menjadi rumah bagi berbagai peradaban dan budaya yang berkembang selama berabad-abad.
                </p>

                <p class="text-lg text-gray-700 leading-relaxed">
                    Dengan pegunungan yang menjulang, pantai-pantai berpasir putih, dan air terjun yang mempesona, Lombok menawarkan pengalaman wisata yang tak terlupakan. Setiap sudut pulau ini menceritakan kisah unik tentang kekayaan alam dan warisan budaya yang diwariskan dari generasi ke generasi.
                </p>

                <div class="about-stats">
                    <x-stat-box number="4" label="Kabupaten" />
                    <x-stat-box number="50+" label="Destinasi Wisata" />
                    <x-stat-box number="1000+" label="Masjid" />
                </div>
            </div>
        </div>
    </section>

    <!-- CATEGORIES SECTION -->
    <section class="py-12 px-8 mx-auto" id="kategori">
        <x-section-header badge="Kategori" title="Kategori Wisata" subtitle="Jelajahi berbagai jenis destinasi wisata sesuai dengan minat Anda" />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <x-category-card
                image="images/pantai.avif"
                category="Pantai"
                icon="fa-water"
                description="Nikmati perpaduan sempurna antara hamparan pasir halus dan birunya air laut. Sebagai batas alami daratan, pantai menawarkan bentang garis alam yang unik dan menawan di sepanjang pesisir nusantara."
            />
            <x-category-card
                image="images/Air Terjun.avif"
                category="Air Terjun"
                icon="fa-droplet"
                description="Rasakan kesegaran aliran air yang jatuh bebas dari tebing bebatuan alami. Terbentuk dari proses alam selama ribuan tahun, air terjun merupakan mahakarya geologi yang sering ditemukan di jantung pegunungan yang asri. Tak hanya yang alami, kini keindahan gemericik air ini juga bisa ditemukan di taman-taman cantik sebagai penyejuk suasana."
            />
            <x-category-card
                image="images/2.avif"
                category="Bukit"
                icon="fa-mountain"
                description="Daratan yang menonjol lebih tinggi, memberikan elevasi sempurna untuk menikmati udara segar dan pemandangan luas. Berbeda dengan gunung yang terjal, perbukitan adalah hamparan gundukan tanah hijau yang berjajar luas, menciptakan lekukan alam yang ikonik dan menenangkan jiwa."
            />
            <x-category-card
                image="images/budaya.avif"
                category="Budaya"
                icon="fa-timeline"
                description="Budaya adalah warisan yang terus tumbuh dan bisa dipelajari melalui interaksi langsung. Dengan mengunjungi destinasi baru, Anda tidak hanya melihat pemandangan, tapi juga belajar menyelami cara hidup masyarakatnya yang khas dan penuh makna."
            />
            <x-category-card
                image="images/taman2.avif"
                category="Taman"
                icon="fa-leaf"
                description="Taman adalah ruang yang dirancang untuk menawarkan kenyamanan dan keindahan alami. Dengan berbagai fasilitas dan景观, taman memberikan pengalaman yang menyenangkan bagi pengunjung dari segala usia."
            />
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="py-20 px-8 mx-auto max-w-6xl">
        <x-section-header badge="Fitur Andalan" title="Kemudahan dalam Setiap Langkah" subtitle="Nikmati pengalaman wisata yang lebih baik dengan fitur-fitur yang dirancang khusus untuk Anda" />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            <x-feature-card
                icon="fa-brain"
                title="Filter Cerdas"
                description="Sistem kami memberikan rekomendasi wisata yang dipersonalisasi berdasarkan preferensi dan kriteria Anda"
            />
            <x-feature-card
                icon="fa-compass"
                title="Penjelajahan Mudah"
                description="Jelajahi destinasi wisata dengan antarmuka yang intuitif dan navigasi yang user-friendly"
            />
        </div>
    </section>

    <!-- ABOUT WEBSITE SECTION -->
    <section class="about-website-container">
        <x-section-header badge="Tentang" title="Tentang Website Ini" subtitle="Platform rekomendasi wisata Lombok yang didukung fitur filter destinasi wisata berdasarkan keinginan Anda" />

        <div class="about-website-grid">
            <div class="about-website-content">
                <h3 class="about-website-heading">Misi</h3>
                <p class="text-gray-700 leading-relaxed">
                    Website ini dibuat dengan tujuan memudahkan wisatawan dalam menemukan destinasi wisata terbaik di Lombok. Menggunakan sistem rekomendasi berbasis kriteria dan preferensi, untuk membantu Anda membuat keputusan perjalanan yang tepat.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    Setiap destinasi yang direkomendasikan telah dianalisis berdasarkan berbagai faktor penting seperti Harga, Jarak, fasilitas, dan Rating.
                </p>
                <ul class="about-website-list">
                    <li class="about-website-list-item">
                        <span class="about-website-list-dot"></span>
                        <span class="about-website-list-text">Memberikan rekomendasi yang dipersonalisasi</span>
                    </li>
                    <li class="about-website-list-item">
                        <span class="about-website-list-dot"></span>
                        <span class="about-website-list-text">Menyediakan informasi lengkap setiap destinasi</span>
                    </li>
                </ul>
            </div>

            <div class="about-website-boxes">
                <x-info-box
                    icon="fa-users"
                    title="Saya"
                    subtitle="Mahasiswa Semester Akhir"
                    description="Mahasiswa yang ingin mengimplementasikan project ini sebagai bagian dari tugas akhirnya"
                />
                <x-info-box
                    icon="fa-rocket"
                    title="Teknologi"
                    subtitle="Inovasi terdepan"
                    description="Menggunakan Framework modern untuk membangun website yang interaktif dan responsif"
                />
            </div>
        </div>
    </section>
</x-app-layout>
