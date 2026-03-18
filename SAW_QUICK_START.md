# 🚀 SAW System - Quick Start Guide

## ✅ Apa yang Sudah Siap?

Semua fitur SAW sudah terimplementasi 100%:

### ✔️ Input Data

-   **Admin** bisa input nilai evaluasi untuk setiap wisata × kriteria
-   Interface matrix (spreadsheet-style)
-   Auto-save saat diketik
-   Bulk import CSV

### ✔️ Perhitungan

-   **Normalisasi** otomatis (benefit & cost)
-   **Weighted Scoring** menggunakan bobot
-   **Ranking** berdasarkan skor Vi

### ✔️ Tampilan Hasil

-   **Public ranking** - semua orang bisa lihat
-   **Detail breakdown** - lihat rumus perhitungan setiap wisata
-   **Visual comparison** - progress bars & percentages

---

## 📖 Cara Menggunakan

### 1️⃣ **Admin: Masukkan Data Evaluasi**

**URL**: `http://localhost:8000/admin/evaluations`

**Langkah:**

1. Login sebagai admin
2. Klik "Admin" → "Evaluations" (jika sudah ada di menu)
3. Lihat matrix: **Wisata × Kriteria**
4. **Klik cell** dan masukkan nilai
5. Nilai **otomatis tersimpan** (ada feedback hijau)

**Contoh Nilai:**

```
Harga Tiket (C1 - Cost):  25000-50000 (lebih rendah lebih baik)
Jarak (C2 - Cost):        10-35 km (lebih dekat lebih baik)
Fasilitas (C3 - Benefit): 70-90 (lebih tinggi lebih baik)
Rating (C4 - Benefit):    4.0-4.8 (lebih tinggi lebih baik)
```

**Atau Import CSV:**

1. Click "📥 Import CSV"
2. Format file:
    ```
    Nama Wisata,Kode Kriteria,Nilai
    Pantai Kuta,C1,50000
    Pantai Kuta,C2,25
    ...
    ```
3. Upload file

---

### 2️⃣ **User: Lihat Ranking**

**URL**: `http://localhost:8000/saw/results`

**Apa yang ditampilkan:**

-   ✅ Daftar kriteria & bobot
-   ✅ **Ranking 1-5** wisata berdasarkan skor SAW
-   ✅ Skor Vi dan persentase
-   ✅ Tombol "Detail" untuk setiap wisata

**Contoh Ranking:**

```
Rank | Nama Wisata      | Score   | %
-----|------------------|---------|------
 1   | Gunung Bromo     | 0.9508  | 95.08%
 2   | Air Terjun       | 0.8926  | 89.26%
 3   | Candi            | 0.8234  | 82.34%
 4   | Pantai Seminyak  | 0.7812  | 78.12%
 5   | Pantai Kuta      | 0.7234  | 72.34%
```

---

### 3️⃣ **User: Lihat Detail Perhitungan**

**URL**: `http://localhost:8000/saw/results/{wisataId}` (klik "Detail")

**Apa yang ditampilkan:**

-   🖼️ Foto wisata
-   📋 Rincian perhitungan SAW
-   📊 Tabel: Kriteria | Nilai Normalisasi | Bobot | Hasil Kali
-   🏆 Perbandingan ranking dengan wisata lain

**Rumus yang ditampilkan:**

```
Vi = Σ (rij × wj)

Contoh untuk Gunung Bromo:
C1: 1.0000 × 0.262 = 0.262000
C2: 1.0000 × 0.245 = 0.245000
C3: 0.8333 × 0.267 = 0.222511
C4: 0.9792 × 0.226 = 0.221078
                    ---------
    Total (Vi) = 0.950589 ✓
```

---

## 🗄️ Data yang Sudah Ada

### Kriteria (4):

| Kode | Nama        | Tipe    | Bobot |
| ---- | ----------- | ------- | ----- |
| C1   | Harga Tiket | Cost    | 0.262 |
| C2   | Jarak       | Cost    | 0.245 |
| C3   | Fasilitas   | Benefit | 0.267 |
| C4   | Rating      | Benefit | 0.226 |

**Total: 1.0000 ✓ Valid**

### Wisata (5):

1. Pantai Kuta
2. Pantai Seminyak
3. Gunung Bromo
4. Candi
5. Air Terjun

### Evaluasi (20):

Sudah ada contoh data untuk semua kombinasi wisata × kriteria

---

## 🔄 Alur Lengkap

```
┌─────────────────────────────────────────────┐
│  ADMIN INPUT EVALUASI                       │
│  /admin/evaluations (matrix form)           │
└────────────────┬────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────┐
│  SAW CALCULATION (OTOMATIS)                 │
│  SAWCalculator Service                      │
│  - Build matrix                             │
│  - Normalize (benefit/cost)                 │
│  - Weighted scoring (Vi = Σ rij × wj)      │
│  - Ranking                                  │
└────────────────┬────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────┐
│  USER LIHAT HASIL                           │
│  /saw/results (public ranking)              │
│  /saw/results/{id} (detail calculation)     │
└─────────────────────────────────────────────┘
```

---

## 🎯 Akses Menu

### Untuk Admin:

**Di halaman admin dashboard**, seharusnya ada menu untuk:

-   ✓ Kriteria
-   ✓ Bobot
-   ✓ **Evaluasi** (Matrix Penilaian)

Jika belum ada di sidebar, akses langsung:

-   Evaluasi: `http://localhost:8000/admin/evaluations`

### Untuk User/Public:

**Menu SAW:**

-   Ranking: `http://localhost:8000/saw/results`
-   Detail: `http://localhost:8000/saw/results/1` (dst)

---

## 📝 Contoh Kasus

### Scenario: Menambah Data Baru

1. **Admin input evaluasi wisata baru:**

    - Pergi ke `/admin/evaluations`
    - Cari baris wisata di matrix
    - Isi nilai untuk setiap kriteria
    - Otomatis tersimpan ✓

2. **System menghitung otomatis:**

    - Normalisasi nilai (cost: min/value, benefit: value/max)
    - Kalikan dengan bobot masing-masing
    - Jumlahkan → Vi

3. **User lihat ranking:**
    - Wisata baru langsung muncul di ranking
    - Posisi berdasarkan skor Vi tertinggi

---

## 🔍 Verificasi Data

### Cek Kriteria & Bobot:

```sql
SELECT c.code, c.name, c.type, w.weight
FROM criterias c
LEFT JOIN weights w ON c.id = w.criteria_id
ORDER BY c.code;
```

### Cek Evaluasi:

```sql
SELECT w.name, c.code, e.value
FROM evaluations e
JOIN wisatas w ON e.wisata_id = w.id
JOIN criterias c ON e.criteria_id = c.id
LIMIT 10;
```

### Cek Total Bobot:

```sql
SELECT SUM(weight) as total FROM weights;
```

---

## 🆘 Troubleshooting

### "Tidak ada data evaluasi untuk perhitungan SAW"

-   **Solusi**: Masukkan nilai di `/admin/evaluations`

### "Total bobot tidak valid"

-   **Solusi**: Cek `/admin/weights` pastikan total = 1.0

### "Application Error" di ranking page

-   **Solusi**:
    -   Pastikan ada minimal 1 wisata di database
    -   Pastikan ada evaluasi untuk semua wisata × kriteria
    -   Cek `/admin/evaluations` matrix

---

## 💡 Tips

1. **Konsistensi Data**: Pastikan setiap wisata punya nilai untuk semua kriteria
2. **Bobot**: Total bobot harus = 1.0 (sudah valid, jangan diubah jika tidak perlu)
3. **Unit Nilai**: Gunakan unit yang konsisten (harga dalam rupiah, jarak dalam km, rating 1-5)
4. **Normalisasi Otomatis**: Sistem otomatis menangani benefit vs cost

---

## 📊 Rumus SAW

**Decision Matrix (xij):**

```
      C1      C2      C3      C4
A1  50000    25      85     4.5
A2  30000    15      80     4.2
...
```

**Normalisasi (rij):**

-   Benefit: rij = xij / max(xj)
-   Cost: rij = min(xj) / xij

**Preference (Vi):**

```
Vi = Σ(rij × wj)  untuk j = 1,2,...,m
```

**Ranking:**
Alternatif dengan Vi terbesar = best recommendation

---

## 🎉 Selesai!

Sistem SAW sudah 100% siap digunakan untuk memberikan rekomendasi wisata!

**Status**: ✅ PRODUCTION READY

---

**Untuk pertanyaan lebih lanjut**, lihat file dokumentasi lengkap:

-   `SAW_COMPLETE_GUIDE.md` - Dokumentasi lengkap
-   `SAW_SYSTEM_DOCUMENTATION.md` - Dokumentasi kriteria & bobot
