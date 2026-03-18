# 🎯 User Guide - Fitur Rekomendasi Wisata

## 🚀 Cara Akses

1. **Login ke sistem**

    - Email: `test@example.com`
    - Password: `password`

2. **Buka halaman Rekomendasi**
    - URL: `http://127.0.0.1:8000/saw/recommendations`
    - Atau dari menu navbar

## 📋 Langkah-Langkah Penggunaan

### Step 1: Isi Preferensi Anda

Di bagian "PREFERENSI WISATA" atas halaman, isi filter sesuai keinginan:

#### 💰 Budget Maksimal

-   Masukkan batas maksimal harga tiket masuk
-   Contoh: `150000` untuk budget Rp 150rb
-   Wisata dengan harga ≤ nilai ini akan ditampilkan

#### 📍 Jarak Maksimal

-   Masukkan batas jarak dari pusat kota (km)
-   Contoh: `100` untuk wisata dalam jarak ≤ 100 km
-   Wisata lebih jauh akan dikeluarkan dari hasil

#### 🏢 Jumlah Fasilitas Minimal

-   Masukkan jumlah fasilitas minimum yang diinginkan
-   Contoh: `8` untuk minimal 8 fasilitas (restoran, toilet, parkir, dll)
-   Wisata dengan fasilitas < nilai ini akan dikeluarkan

#### ⭐ Rating Minimal

-   Masukkan rating minimum yang Accept (0-5)
-   Contoh: `4.0` untuk hanya tampilkan wisata rating ≥ 4.0
-   Wisata dengan rating < nilai ini akan dikeluarkan

### Step 2: Klik "🔎 Cari Wisata"

Sistem akan memproses filter dan menampilkan hasil.

### Step 3: Lihat Hasil Rekomendasi

Tabel akan menampilkan wisata yang sesuai filter, diurutkan berdasarkan skor SAW tertinggi:

| Info            | Keterangan                                          |
| --------------- | --------------------------------------------------- |
| **Rank**        | Urutan rekomendasi (#1 = terbaik)                   |
| **Nama Wisata** | Nama dan lokasi wisata                              |
| **Harga Tiket** | Dalam Rupiah                                        |
| **Jarak**       | Dari pusat kota (km)                                |
| **Fasilitas**   | Jumlah fasilitas tersedia                           |
| **Rating**      | Penilaian pengunjung (0-5)                          |
| **Skor SAW**    | Nilai kepuasan (0-1, semakin tinggi = semakin baik) |
| **Aksi**        | Tombol "Detail" untuk info lengkap                  |

### Step 4 (Opsional): Lihat Detail Wisata

Klik tombol "Detail" untuk melihat detail perhitungan SAW untuk wisata tersebut.

---

## 💡 Tips & Trik

### Cari Budget Terjangkau

```
Budget Maksimal: 50000
(Jarak, Fasilitas, Rating: kosongkan = tidak ada batasan)

✅ Wisata budget-friendly akan tampil di atas
```

### Cari Wisata Dekat

```
Jarak Maksimal: 30
(Lainnya: kosongkan)

✅ Hanya wisata dalam jarak 30km yang ditampilkan
```

### Cari Wisata Premium (Berkualitas)

```
Fasilitas Minimal: 10
Rating Minimal: 4.5
(Lainnya: kosongkan)

✅ Hanya wisata berkualitas dengan banyak fasilitas
```

### Kombinasi Filter

```
Budget Maksimal: 200000
Jarak Maksimal: 50
Fasilitas Minimal: 8
Rating Minimal: 4.0

✅ Cari wisata yang seimbang: murah, dekat, bagus!
```

### Reset & Cari Ulang

Klik tombol "✖ Hapus Filter" untuk menghapus semua filter dan mulai dari awal.

---

## 🎯 Contoh Skenario Real

### Rencana Liburan Keluarga

```
📌 Kondisi: Punya budget terbatas, ingin dekat dari kota

Filter:
- Budget Maksimal: 200000
- Jarak Maksimal: 50
- Fasilitas Minimal: 10
- Rating Minimal: 4.0

✅ Hasil: Akan dapat wisata yang cocok untuk keluarga dengan
   harga terjangkau, dekat dari rumah, lengkap fasilitas!
```

### Petualangan Ekstrem

```
📌 Kondisi: Budget cukup, suka pendakian jauh

Filter:
- Budget Maksimal: (kosong = no limit)
- Jarak Maksimal: (kosong = no limit)
- Fasilitas Minimal: (kosong)
- Rating Minimal: 4.5

✅ Hasil: Semua wisata rating tinggi tanpa batasan jarak/budget
```

### Hemat Maksimal

```
📌 Kondisi: Budget sangat terbatas

Filter:
- Budget Maksimal: 100000
- (Yang lain kosong)

✅ Hasil: Semua wisata murah (≤Rp100rb)
```

---

## ❓ FAQ

**Q: Apa itu Skor SAW?**
A: SAW (Simple Additive Weighting) adalah metode perhitungan yang menggabungkan semua kriteria (harga, jarak, fasilitas, rating) menjadi satu skor akhir. Skor lebih tinggi = rekomendasi lebih baik.

**Q: Bagaimana cara kerjanya?**
A:

1. Sistem ambil semua wisata
2. Filter hanya wisata yang sesuai preferensi Anda
3. Normalisasi nilai dari wisata yang lolos filter
4. Hitung skor SAW untuk setiap wisata
5. Urutkan dari skor tertinggi = rekomendasi terbaik

**Q: Bisa kosongkan semua filter?**
A: Bisa! Jika semua field kosong, sistem akan tampilkan semua wisata diurutkan berdasarkan skor SAW. Tapi lebih baik isi minimal satu filter untuk hasil yang lebih relevan.

**Q: Rating yang ditampilkan dari mana?**
A: Rating adalah penilaian pengunjung wisata sebelumnya (0-5 bintang).

**Q: Bisa ubah preferensi dan cari lagi?**
A: Bisa! Tinggal ubah value filter dan klik "Cari Wisata" lagi.

**Q: Gimana kalau tidak ada wisata yang sesuai filter?**
A: Akan muncul pesan "Tidak ada hasil yang sesuai". Coba ubah filter yang lebih tidak ketat (misal: kurangi budget minimal, atau tambah rating minimal).

---

## 📊 Quick Reference - Data Wisata

Berada di sistem saat ini ada **15 wisata** dengan range:

-   **Harga Tiket**: Rp 25rb - Rp 500rb
-   **Jarak**: 8.3 km - 350 km
-   **Fasilitas**: 5 - 18 item
-   **Rating**: 4.2 - 4.9 bintang

Lihat detail setiap wisata dengan klik "Detail" di hasil ranking.

---

**Selamat menjelajahi rekomendasi wisata! 🎉**
