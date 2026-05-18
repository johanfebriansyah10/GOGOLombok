# Analisis Bug Algoritma Bayesian Weighted Rating

## Data Dummy yang Digunakan

```
Wisata 1 (ID 74):
- Harga Tiket: 15.000
- Jarak: 25.5 km
- Fasilitas: 3
- Rating: 4.0
- Jumlah Review: 100 ⬅️ BERBEDA

Wisata 2 (ID 75):
- Harga Tiket: 15.000
- Jarak: 25.5 km
- Fasilitas: 3
- Rating: 4.0
- Jumlah Review: 198 ⬅️ BERBEDA
```

## Hasil Rekomendasi Saat Ini (SALAH)

```
Wisata 1 (Contoh 1) - Score: 0.2816 ✗ Ranked #33
Wisata 2 (Contoh) - Score: 0.2791 ✗ Ranked #35

❌ WISATA 1 DIREKOMENDASIKAN LEBIH TINGGI
   (Padahal Wisata 2 memiliki lebih banyak review = lebih kredibel)
```

## Root Cause Analysis

### Masalah 1: Evaluation Table Tidak Konsisten

**Status**: ✓ Teridentifikasi

Evaluations di database tidak menggunakan `actual_rating` dan `review_count` dari tabel Wisata:

```
Wisata 74:
- C1 (Harga): 15000 ✓ (dari ticket_price)
- C2 (Jarak): 25.5 ✓ (dari distance)
- C3 (Fasilitas): 3 ✓ (dari facilities_count)
- C4 (Rating): 4 ✗ (hardcoded di evaluation, bukan dari actual_rating/review_count)

Wisata 75: (sama persis)
- C1: 15000
- C2: 25.5
- C3: 3
- C4: 4
```

**Dampak**: Evaluation value untuk C4 tidak membedakan antara kedua wisata, semua bernilai 4.

---

### Masalah 2: Bayesian Formula Tidak Bekerja Optimal

**Status**: ⚠️ Teridentifikasi tetapi masih problema

**Lokasi Kode**: [SAWCalculator.php](app/Services/SAWCalculator.php#L96-L106)

**Rumus Saat Ini**:

```php
$value = ($v / ($v + $m)) * $R + ($m / ($v + $m)) * $C;

Dimana:
- v = review_count
- R = actual_rating wisata
- m = 50 (minimum ratings threshold - konstanta)
- C = global average rating dari semua wisata
```

**Perhitungan untuk Data Dummy**:

Global Average Rating (C) = 4.40 (dari semua 35 wisata di DB)

**Wisata 1** (v=100, R=4):

```
value_C4 = (100 / (100 + 50)) * 4 + (50 / (100 + 50)) * 4.40
         = (100/150) * 4 + (50/150) * 4.40
         = 0.6667 * 4 + 0.3333 * 4.40
         = 2.667 + 1.467
         = 4.134
```

**Wisata 2** (v=198, R=4):

```
value_C4 = (198 / (198 + 50)) * 4 + (50 / (198 + 50)) * 4.40
         = (198/248) * 4 + (50/248) * 4.40
         = 0.8065 * 4 + 0.2016 * 4.40
         = 3.226 + 0.887
         = 4.113
```

**Hasil**: Wisata 1 = **4.134** > Wisata 2 = **4.113**

### ❌ MASALAH: Wisata dengan review LEBIH SEDIKIT dapat score LEBIH TINGGI!

---

### Penyebab Masalah 2

Ketika **R < C** (actual_rating < global_average) dan review_count berbeda:

**Wisata 1** (100 review):

- Bobot ke R (rating asli): 66.67%
- Bobot ke C (global avg): **33.33%** ← PULL KE GLOBAL AVERAGE YANG LEBIH TINGGI

**Wisata 2** (198 review):

- Bobot ke R (rating asli): 80.65%
- Bobot ke C (global avg): **20.16%** ← PULL KE GLOBAL AVERAGE YANG LEBIH RENDAH

Karena global average (4.40) > actual rating (4.0):

- Wisata dengan review SEDIKIT di-pull UP lebih banyak = score LEBIH TINGGI ✗
- Wisata dengan review BANYAK di-pull UP lebih sedikit = score LEBIH RENDAH ✗

---

### Masalah 3: Normalized Value Memperkuat Bug

**Status**: ✓ Teridentifikasi

Setelah Bayesian formula, nilai di-normalize menggunakan max/min dari semua wisata:

```
Normalized Value = Value / Max Value

Wisata 1: 0.8655 (=4.134 / 4.779 max)
Wisata 2: 0.8544 (=4.113 / 4.779 max)
```

Normalized Wisata 1 masih tetap > Wisata 2, jadi bug propagates ke score akhir.

---

## Kesimpulan Root Cause

### Primary Issue (Masalah Utama):

**Bayesian Rating Formula tidak cocok untuk use case ini ketika kedua wisata memiliki rating sama tetapi review_count berbeda.**

Formula ini dirancang untuk:

- Mengatasi extreme/outlier ratings dengan pull ke global average
- Menambah confidence ketika ada banyak reviews

Tapi hasilnya:

- ✓ Benar: Rating ekstrem (misal 1.0) akan di-pull up ke global average
- ✗ SALAH: Rating normal (misal 4.0) dengan review sedikit akan di-pull up ketika global average lebih tinggi, padahal review sedikit = KURANG kredibel

---

## Rekomendasi Perbaikan

Ada **3 opsi** yang bisa diimplementasikan:

### Opsi 1: Review Count Sebagai Faktor Pembobot (RECOMMENDED ✓)

Ubah rumus Bayesian untuk memberikan penalty ketika review_count rendah:

```php
// Bayesian rating dengan confidence penalty
$confidence = min($v / $m, 1.0); // 0-1 scale
$value = $R * $confidence + $C * (1 - $confidence);
```

Hasil untuk data dummy:

```
Wisata 1 (100 reviews):
- confidence = min(100/50, 1.0) = 1.0
- value = 4 * 1.0 + 4.40 * 0.0 = 4.0 ✓

Wisata 2 (198 reviews):
- confidence = min(198/50, 1.0) = 1.0
- value = 4 * 1.0 + 4.40 * 0.0 = 4.0 ✓

❌ Masih sama... karena keduanya di atas threshold
```

### Opsi 2: Tambah Review Count Sebagai Kriteria Terpisah (BEST ✓✓)

Jika ingin review_count mempengaruhi score secara signifikan:

```
Tambahkan kriteria baru:
- C5: Jumlah Reviews (benefit)
- Weight: 0.10 (dari rebalancing weight lain)
```

Ini lebih transparent dan dapat dikontrol user.

### Opsi 3: Fix Data di Evaluation Table

Gunakan `actual_rating` dan `review_count` secara konsisten di setiap langkah, bukan hardcoded di evaluation.

---

## Summary Perbaikan yang Dibutuhkan

**Priority 1 (CRITICAL)**:

- [ ] Ubah Bayesian formula agar wisata dengan review_count lebih tinggi dapat score lebih tinggi (atau minimal sama)
- [ ] Alternative: Tambahkan C5 (Review Count) sebagai kriteria terpisah

**Priority 2 (IMPORTANT)**:

- [ ] Ensure evaluation table di-populate dari actual_rating dan review_count, bukan hardcoded
- [ ] Add validation bahwa Bayesian formula menghasilkan expected output

**Priority 3 (NICE-TO-HAVE)**:

- [ ] Buat test case untuk verifikasi bahwa wisata dengan review lebih banyak selalu dapat score ≥ wisata dengan review lebih sedikit (jika rating sama)
