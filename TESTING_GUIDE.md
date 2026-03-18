# 🧪 Testing Guide - Sistem Rekomendasi Wisata SAW

## 🚀 Setup untuk Testing

### 1. Pastikan Server Berjalan

```bash
# Jika belum:
cd /c/laragon/www/PZN/gorogon/my-skripsi
php artisan serve --host=127.0.0.1 --port=8000
```

### 2. Login User Test

-   **Email**: `test@example.com`
-   **Password**: `password`

### 3. Akses Halaman Rekomendasi

-   URL: `http://127.0.0.1:8000/saw/recommendations`

---

## ✅ Test Cases

### TC-001: Form Filter Tampil Dengan Benar

**Expected**: Halaman menampilkan form dengan 4 input fields

-   ✅ Input Budget Maksimal dengan placeholder "Contoh: 200000"
-   ✅ Input Jarak Maksimal dengan placeholder "Contoh: 100"
-   ✅ Input Fasilitas Minimal dengan placeholder "Contoh: 5"
-   ✅ Input Rating Minimal dengan placeholder "Contoh: 4.0"
-   ✅ Button "🔎 Cari Wisata"
-   ✅ Button "✖ Hapus Filter" (hidden jika belum filter)

**Cara Test**:

1. Buka `/saw/recommendations`
2. Lihat apakah form sudah tampil dengan benar
3. ✅ **PASS** jika semua elemen terlihat

---

### TC-002: Filter Budget Maksimal

**Expected**: Hanya wisata dengan harga tiket ≤ budget yang ditampilkan

**Data Wisata untuk Test**:

-   Rp 25rb (Taman Bunga Bogor)
-   Rp 50rb (Pantai Pasir Putih)
-   Rp 100rb (Rumah Tepi Sungai Heritage)
-   Rp 500rb (Pulau Seribu Paradise)

**Cara Test**:

1. Input `Budget Maksimal: 100000`
2. Klik "Cari Wisata"
3. ✅ **PASS** jika hanya wisata dengan harga ≤ Rp100rb tampil (minimal 3 wisata)
4. ✅ **FAIL** jika ada wisata Rp 150rb+ di hasil

---

### TC-003: Filter Jarak Maksimal

**Expected**: Hanya wisata dengan jarak ≤ max_distance yang tampilkan

**Data Wisata untuk Test**:

-   8.3 km (Kebun Binatang Metropolitan)
-   12 km (Rumah Tepi Sungai Heritage)
-   15.5 km (Taman Hiburan Jaya)
-   45.2 km (Pantai Pasir Putih)
-   250+ km (Gunung Bromo, Toba, dll)

**Cara Test**:

1. Input `Jarak Maksimal: 30`
2. Klik "Cari Wisata"
3. ✅ **PASS** jika semua wisata < 30 km tampil
4. ✅ **FAIL** jika ada wisata > 30 km di hasil

---

### TC-004: Filter Fasilitas Minimal

**Expected**: Hanya wisata dengan facilities_count ≥ min_facilities

**Data Wisata untuk Test**:

-   5 fasilitas (Rumah Tepi Sungai Heritage)
-   6 fasilitas (Gunung Bromo)
-   7 fasilitas (Taman Bunga Bogor, Kawah Ijen)
-   12 fasilitas (Taman Hiburan Jaya)
-   15 fasilitas (Kebun Binatang Metropolitan)
-   18 fasilitas (Danau Toba Resort)

**Cara Test**:

1. Input `Fasilitas Minimal: 10`
2. Klik "Cari Wisata"
3. ✅ **PASS** jika hanya wisata dengan ≥10 fasilitas tampil (3-4 wisata)
4. ✅ **FAIL** jika ada wisata dengan < 10 fasilitas

---

### TC-005: Filter Rating Minimal

**Expected**: Hanya wisata dengan actual_rating ≥ min_rating

**Data Wisata untuk Test**:

-   4.2 rating (Rumah Tepi Sungai Heritage)
-   4.3 rating (Taman Bunga Bogor)
-   4.4 rating (Taman Nasional Ujung Kulon)
-   4.5 rating (Taman Hiburan Jaya)
-   4.7-4.9 rating (Pantai Pasir Putih, Bromo, Pulau Seribu, dll)

**Cara Test**:

1. Input `Rating Minimal: 4.7`
2. Klik "Cari Wisata"
3. ✅ **PASS** jika hanya wisata dengan rating ≥4.7 tampil (3-4 wisata)
4. ✅ **FAIL** jika ada wisata dengan rating < 4.7

---

### TC-006: Kombinasi Semua Filter

**Expected**: Semua filter bekerja sama dan hanya wisata yang lolos semua filter ditampilkan

**Cara Test**:

```
Input:
- Budget Maksimal: 200000
- Jarak Maksimal: 50
- Fasilitas Minimal: 8
- Rating Minimal: 4.5
```

**Wisata yang Harusnya Lolos**:

1. Pantai Pasir Putih: Rp50rb, 45.2km, 8 fasilitas, 4.7 rating ✅
2. Kebun Binatang: Rp175rb, 8.3km, 15 fasilitas, 4.6 rating ✅
3. Taman Hiburan Jaya: Rp150rb, 15.5km, 12 fasilitas, 4.5 rating ✅

**Cara Test**:

1. Isi semua 4 filter dengan value di atas
2. Klik "Cari Wisata"
3. ✅ **PASS** jika result hanya menampilkan 3-4 wisata yang lolos semua filter
4. ✅ **FAIL** jika ada wisata yang tidak memenuhi salah satu kriteria

---

### TC-007: Filter Tidak Ada Hasil

**Expected**: Pesan "Tidak ada hasil yang sesuai" ketika kombinasi filter terlalu ketat

**Cara Test**:

```
Input:
- Budget Maksimal: 20000 (sangat murah)
- Jarak Maksimal: 5 (sangat dekat)
- Fasilitas Minimal: 15 (banyak)
- Rating Minimal: 4.8 (tinggi)
```

1. Klik "Cari Wisata"
2. ✅ **PASS** jika muncul pesan kuning "Tidak ada hasil yang sesuai"
3. ✅ **FAIL** jika tetap menampilkan wisata atau error

---

### TC-008: Hapus Filter (Reset)

**Expected**: Kembali ke state awal form kosong

**Cara Test**:

1. Isi semua filter (misal semua dengan value 1)
2. Klik "Cari Wisata" (hasil tampil)
3. Klik "✖ Hapus Filter"
4. ✅ **PASS** jika kembali ke halaman dengan form kosong (state awal)
5. ✅ **FAIL** jika masih menampilkan hasil atau form tidak kosong

---

### TC-009: SAW Score Muncul di Tabel

**Expected**: Kolom "Skor SAW" menampilkan nilai antara 0-1

**Cara Test**:

1. Isi filter apapun (atau kosong)
2. Klik "Cari Wisata"
3. ✅ **PASS** jika tabel tampil dengan kolom "Skor SAW" berisi angka 0.xxxx
4. ✅ **FAIL** jika kolom tidak ada atau tidak ada nilai

---

### TC-010: Ranking Urutan Dari Skor Tertinggi

**Expected**: Wisata diurutkan dari skor SAW tertinggi ke terendah

**Cara Test**:

1. Isi filter (contoh: kosong = tampil semua wisata)
2. Klik "Cari Wisata"
3. Lihat kolom "Skor SAW" dari rank #1 hingga #N
4. ✅ **PASS** jika nilai skor menurun dari bawah ke atas (Rank 1 terbesar)
5. ✅ **FAIL** jika ranking tidak sesuai urutan skor

---

### TC-011: Tombol "Detail" Berfungsi

**Expected**: Klik tombol "Detail" pada wisata membuka detail page

**Cara Test**:

1. Tampilkan hasil rekomendasi
2. Klik tombol "Detail" pada salah satu wisata
3. ✅ **PASS** jika terbuka halaman `/saw/results/{wisata_id}` dengan detail
4. ✅ **FAIL** jika error atau halaman tidak terbuka

---

### TC-012: Statistik Summary Tampil

**Expected**: Menampilkan 5 statistik di bawah tabel

**Expected Stats**:

-   Total Wisata
-   Skor Tertinggi
-   Skor Terendah
-   Rata-rata Skor
-   Badge "Top Recommendation"

**Cara Test**:

1. Tampilkan hasil rekomendasi dengan minimal 3 wisata
2. Scroll ke bawah tabel
3. ✅ **PASS** jika 5 statistik box tampil dengan value
4. ✅ **FAIL** jika statistik tidak muncul atau value salah

---

### TC-013: Dark Mode Support

**Expected**: Form dan hasil tampil dengan benar di dark mode

**Cara Test**:

1. Switch VS Code ke dark mode (atau OS dark mode)
2. Refresh halaman rekomendasi
3. ✅ **PASS** jika semua elemen terlihat jelas (contrast OK)
4. ✅ **FAIL** jika ada elemen yang tidak terlihat atau kontras jelek

---

### TC-014: Responsive Design (Mobile)

**Expected**: Layout responsive di device kecil

**Cara Test**:

1. Buka DevTools (F12)
2. Set screen iPhone 12 (390x844)
3. ✅ **PASS** jika form dan tabel responsive, no horizontal scroll
4. ✅ **FAIL** jika ada overflow horizontal atau layout berantakan

---

### TC-015: URL Parameters Work

**Expected**: Filter bisa di-pass via URL params

**Test 1 - Budget Filter**:

```
URL: /saw/recommendations?max_budget=100000
✅ PASS jika form sudah pre-filled dengan value 100000
```

**Test 2 - Kombinasi**:

```
URL: /saw/recommendations?max_budget=150000&max_distance=50&min_facilities=8&min_rating=4.5
✅ PASS jika semua filter sudah pre-filled
```

---

## 📊 Test Report Template

| TC     | Nama Test          | Status  | Notes |
| ------ | ------------------ | ------- | ----- |
| TC-001 | Form Filter Tampil | ✅ PASS | -     |
| TC-002 | Filter Budget      | ✅ PASS | -     |
| TC-003 | Filter Jarak       | ✅ PASS | -     |
| TC-004 | Filter Fasilitas   | ✅ PASS | -     |
| TC-005 | Filter Rating      | ✅ PASS | -     |
| TC-006 | Kombinasi Filter   | ✅ PASS | -     |
| TC-007 | Tidak Ada Hasil    | ✅ PASS | -     |
| TC-008 | Hapus Filter       | ✅ PASS | -     |
| TC-009 | SAW Score Tampil   | ✅ PASS | -     |
| TC-010 | Ranking Order      | ✅ PASS | -     |
| TC-011 | Tombol Detail      | ✅ PASS | -     |
| TC-012 | Statistik Summary  | ✅ PASS | -     |
| TC-013 | Dark Mode          | ✅ PASS | -     |
| TC-014 | Responsive Mobile  | ✅ PASS | -     |
| TC-015 | URL Parameters     | ✅ PASS | -     |

---

## 🐛 Bug Report (jika ada)

Jika menemukan issue, silakan dokumentasikan:

```
Bug Title: [Deskripsi singkat]
Severity: Critical/High/Medium/Low
Steps to Reproduce:
1. ...
2. ...
3. ...

Expected Result: ...
Actual Result: ...
```

---

**Selamat Testing! 🎉**
