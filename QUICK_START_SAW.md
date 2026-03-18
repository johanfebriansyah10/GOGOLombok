# 🎯 SAW System - Quick Start Guide

## ✅ Apa yang sudah diimplementasikan?

### 1️⃣ Database Tables

-   **criterias** - Menyimpan kriteria dengan code, nama, tipe (benefit/cost), deskripsi
-   **weights** - Menyimpan bobot setiap kriteria (0-1)

### 2️⃣ Models & Relationships

-   **Criteria Model** - relasi hasOne(Weight)
-   **Weight Model** - relasi belongsTo(Criteria) + helper methods
    -   `Weight::totalWeight()` - hitung total bobot
    -   `Weight::isWeightValid()` - validasi total = 1

### 3️⃣ Admin Panel - CRUD Lengkap

-   **Kriteria Management** - /admin/criterias
    -   Create, Read, Update, Delete kriteria
    -   Input: kode, nama, tipe (benefit/cost), deskripsi
-   **Bobot Management** - /admin/weights
    -   Create, Read, Update, Delete bobot
    -   Input: pilih kriteria, nilai bobot (0-1)
    -   Display: total bobot, status validasi (valid/tidak valid)

### 4️⃣ Validasi

-   Form validation menggunakan Request classes
-   Total bobot must = 1 (dengan tolerance ±0.01)
-   Setiap kriteria hanya bisa 1 bobot (unique constraint)
-   Pesan error dalam bahasa Indonesia

### 5️⃣ Sample Data (Seeded)

5 kriteria contoh sudah tersedia:

-   C1: Aksesibilitas Lokasi (benefit)
-   C2: Harga Tiket Masuk (cost)
-   C3: Fasilitas (benefit)
-   C4: Keamanan (benefit)
-   C5: Kebersihan (benefit)

---

## 🚀 Cara Menggunakan

### Login sebagai Admin

```
Email: admin@example.com
Password: password
```

### Akses Menu

1. **Kriteria**: http://localhost:8000/admin/criterias
2. **Bobot**: http://localhost:8000/admin/weights

### Workflow

1. **Buat Kriteria** (jika belum ada)

    - Berikan kode unik (C1, C2, dst)
    - Tentukan nama dan tipe (benefit/cost)
    - Tambah deskripsi (optional)

2. **Atur Bobot untuk setiap Kriteria**

    - Buka halaman Bobot
    - Click "Tambah Bobot"
    - Pilih kriteria & masukkan nilai bobot
    - Total harus = 1 (100%)

3. **Validasi Sebelum SAW**
    - Lihat status di halaman Bobot
    - Pastikan "Valid (Total = 1)" sebelum perhitungan

---

## 📂 File yang Dibuat

```
Models:
  app/Models/Criteria.php
  app/Models/Weight.php

Controllers:
  app/Http/Controllers/Admin/CriteriaController.php
  app/Http/Controllers/Admin/WeightController.php

Requests (Validation):
  app/Http/Requests/StoreCriteriaRequest.php
  app/Http/Requests/UpdateCriteriaRequest.php
  app/Http/Requests/StoreWeightRequest.php
  app/Http/Requests/UpdateWeightRequest.php

Views:
  resources/views/admin/criterias/
    - index.blade.php
    - create.blade.php
    - edit.blade.php
  resources/views/admin/weights/
    - index.blade.php
    - create.blade.php
    - edit.blade.php

Migrations:
  database/migrations/2026_03_04_000001_create_criterias_table.php
  database/migrations/2026_03_04_000002_create_weights_table.php

Seeders:
  database/seeders/CriteriaSeeder.php (updated)
  database/seeders/DatabaseSeeder.php (updated)
```

---

## 🔧 Menggunakan Helper Methods

Di aplikasi, Anda bisa gunakan:

```php
// Model
use App\Models\Criteria;
use App\Models\Weight;

// Ambil semua kriteria dengan bobotnya
$criterias = Criteria::with('weight')->get();

// Hitung total bobot
$total = Weight::totalWeight();  // Returns: float

// Validasi
$isValid = Weight::isWeightValid();  // Returns: true/false

// Loop kriteria
foreach ($criterias as $criteria) {
    echo $criteria->code;              // C1
    echo $criteria->name;              // Aksesibilitas Lokasi
    echo $criteria->type;              // benefit
    echo $criteria->weight->weight;    // 0.2
}
```

---

## 📊 Struktur Siap untuk SAW

Data sudah terorganisir untuk perhitungan SAW:

```
Kriteria
├── C1 (Benefit) - Bobot: 0.2
├── C2 (Cost)    - Bobot: 0.25
├── C3 (Benefit) - Bobot: 0.3
├── C4 (Benefit) - Bobot: 0.15
└── C5 (Benefit) - Bobot: 0.1
   Total: 1.0 ✅
```

Selanjutnya tinggal:

1. Buat tabel Alternatif (wisata/destinasi)
2. Buat tabel Evaluasi (nilai tiap alternatif untuk tiap kriteria)
3. Hitung SAW dengan formula normalisasi & weighted scoring
4. Tampilkan ranking hasil

---

## 💡 Tips

-   **Benefit vs Cost**: Tentukan dengan benar (mempengaruhi normalisasi)
-   **Bobot**: Gunakan decimal (0.2, 0.25, 0.3 dst)
-   **Total Bobot**: Harus tepat 1 atau sangat close (±0.01)
-   **Kode Unik**: Gunakan format standar (C1, C2, C3 dst)

---

## 📋 Daftar Pengecekan

-   ✅ Database tables created
-   ✅ Models & relationships defined
-   ✅ Controllers CRUD working
-   ✅ Views UI ready
-   ✅ Form validation active
-   ✅ Weight validation implemented
-   ✅ Sample data seeded
-   ✅ Routes registered
-   ✅ Admin middleware applied
-   ✅ Ready for SAW calculation

---

**Sistem sudah 100% siap! Lanjut ke tahap SAW calculation.** 🚀
