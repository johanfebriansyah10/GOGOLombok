# 📊 SAW (Simple Additive Weighting) System - Dokumentasi

## ✅ Status Implementasi

Sistem kriteria dan bobot untuk metode SAW telah berhasil diimplementasikan dengan fitur lengkap:

### Tabel Database

-   ✅ **criterias** - Menyimpan data kriteria dengan kode, nama, tipe (benefit/cost), dan deskripsi
-   ✅ **weights** - Menyimpan bobot untuk setiap kriteria dengan validasi unique dan foreign key

### Models & Relationships

-   ✅ **Criteria Model** - Dengan relasi `hasOne(Weight)`
-   ✅ **Weight Model** - Dengan relasi `belongsTo(Criteria)` dan helper methods
    -   `totalWeight()` - Menghitung total bobot semua kriteria
    -   `isWeightValid()` - Validasi bahwa total bobot = 1

### Admin Panel

-   ✅ **Manajemen Kriteria** - CRUD lengkap (Create, Read, Update, Delete)
-   ✅ **Manajemen Bobot** - CRUD lengkap dengan validasi
-   ✅ **Validasi Total Bobot** - Menampilkan status validasi dan alert
-   ✅ **Routes** - Registered di routes/web.php dengan middleware admin

## 📁 File Structure

```
app/
├── Models/
│   ├── Criteria.php          (Model kriteria dengan relasi weight)
│   └── Weight.php            (Model bobot dengan helper methods)
├── Http/
│   ├── Controllers/Admin/
│   │   ├── CriteriaController.php (CRUD kriteria)
│   │   └── WeightController.php   (CRUD bobot)
│   └── Requests/
│       ├── StoreCriteriaRequest.php
│       ├── UpdateCriteriaRequest.php
│       ├── StoreWeightRequest.php
│       └── UpdateWeightRequest.php
database/
├── migrations/
│   ├── 2026_03_04_000001_create_criterias_table.php
│   └── 2026_03_04_000002_create_weights_table.php
└── seeders/
    ├── CriteriaSeeder.php    (Contoh data kriteria)
    └── DatabaseSeeder.php    (Registered CriteriaSeeder)
resources/views/admin/
├── criterias/
│   ├── index.blade.php       (List kriteria)
│   ├── create.blade.php      (Form buat kriteria)
│   └── edit.blade.php        (Form edit kriteria)
└── weights/
    ├── index.blade.php       (List bobot + status validasi)
    ├── create.blade.php      (Form buat bobot)
    └── edit.blade.php        (Form edit bobot)
```

## 🚀 Cara Menggunakan

### 1. Akses Admin Panel

-   URL: `http://localhost:8000/admin/criterias` (Manajemen Kriteria)
-   URL: `http://localhost:8000/admin/weights` (Manajemen Bobot)
-   _Hanya admin yang bisa akses (middleware authenticated + role:admin)_

### 2. Membuat Kriteria

1. Klik "Tambah Kriteria"
2. Isi form:
    - **Kode** - C1, C2, C3, dst (unik, max 10 karakter)
    - **Nama** - Nama kriteria (contoh: "Aksesibilitas Lokasi")
    - **Tipe** - Pilih:
        - **Benefit** = Semakin tinggi nilai semakin baik
        - **Cost** = Semakin rendah nilai semakin baik
    - **Deskripsi** - Penjelasan kriteria (opsional)
3. Klik "Simpan Kriteria"

### 3. Mengatur Bobot

1. Pastikan sudah membuat minimal 1 kriteria
2. Klik "Tambah Bobot" di halaman manajemen bobot
3. Isi form:
    - **Pilih Kriteria** - Pilih kriteria yang akan diberi bobot
    - **Bobot** - Masukkan nilai 0-1 (contoh: 0.2 = 20%)
4. Klik "Simpan Bobot"

### 4. Validasi Bobot

-   Di halaman "Manajemen Bobot Kriteria" akan ditampilkan:
    -   **Total Bobot** - Jumlah semua bobot
    -   **Status Validasi**:
        -   ✅ **Valid** - Jika total = 1 (100%)
        -   ❌ **Tidak Valid** - Jika total ≠ 1
-   _Sistem menggunakan tolerance ±0.01 untuk floating point precision_

## 📝 Contoh Data (dari Seeder)

Jalankan perintah untuk populate contoh data:

```bash
php artisan db:seed --class=CriteriaSeeder
```

Atau:

```bash
php artisan db:seed (untuk seed semua, termasuk CriteriaSeeder)
```

Contoh kriteria yang akan dibuat:

-   C1 - Aksesibilitas Lokasi (Benefit)
-   C2 - Harga Tiket Masuk (Cost)
-   C3 - Fasilitas (Benefit)
-   C4 - Keamanan (Benefit)
-   C5 - Kebersihan (Benefit)

## 🔧 Database Schema

### Tabel `criterias`

```sql
CREATE TABLE criterias (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULLABLE,
    type ENUM('benefit', 'cost') DEFAULT 'benefit',
    timestamps
);
```

### Tabel `weights`

```sql
CREATE TABLE weights (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    criteria_id BIGINT UNSIGNED NOT NULL,
    weight DECIMAL(5,4) NOT NULL,
    timestamps,
    UNIQUE(criteria_id),
    FOREIGN KEY(criteria_id) REFERENCES criterias(id) ON DELETE CASCADE
);
```

## 💡 Fitur Validasi

### Request Validation (Form Validation)

-   Kode kriteria harus unik dan max 10 karakter
-   Nama kriteria required dan max 255 karakter
-   Tipe harus 'benefit' atau 'cost'
-   Bobot harus numeric 0-1
-   Setiap kriteria hanya bisa punya 1 bobot (unique constraint)

### Weight Validation

-   `Weight::isWeightValid()` - Mengecek total = 1
-   `Weight::totalWeight()` - Menghitung total semua bobot
-   Tolerance: ±0.01 untuk floating point errors

## 🧮 Siap untuk SAW Calculation

Struktur ini sudah siap untuk implementasi SAW:

### Data yang tersedia untuk SAW:

```php
// Ambil semua kriteria dengan bobotnya
$criterias = Criteria::with('weight')->get();

// Untuk setiap kriteria:
$criteria->code;              // C1, C2, dst
$criteria->name;              // Nama kriteria
$criteria->type;              // 'benefit' atau 'cost'
$criteria->weight->weight;    // Bobot (0-1)

// Validasi sebelum kalkulasi
if (Weight::isWeightValid()) {
    // Lakukan kalkulasi SAW
}
```

### Proses SAW yang akan dilakukan:

1. **Normalisasi Matrix** - Menggunakan tipe benefit/cost
2. **Weighted Scoring** - Kalikan nilai normalisasi dengan bobot
3. **Final Scoring** - Jumlahkan weighted scores
4. **Ranking** - Urutkan alternatif berdasarkan score

## 🔄 Relasi & Methods

### Criteria Methods

```php
$criteria = Criteria::find(1);
$criteria->weight;              // Weight object (or null)
```

### Weight Methods

```php
Weight::totalWeight();           // Hitung total semua bobot
Weight::isWeightValid();         // Cek valid = 1
Weight::sum('weight');           // Alternatif perhitungan
```

## 📋 Checklist Implementasi

-   ✅ Tabel kriteria
-   ✅ Tabel bobot
-   ✅ Model Criteria & Weight
-   ✅ Admin dapat CRUD kriteria
-   ✅ Admin dapat CRUD bobot
-   ✅ Validasi form (Request classes)
-   ✅ Validasi total bobot = 1
-   ✅ Status display di halaman bobot
-   ✅ Database relationships (hasOne, belongsTo)
-   ✅ Helper methods untuk kalkulasi
-   ✅ Contoh seeder
-   ✅ Routes registered dengan middleware
-   ✅ Views dengan Tailwind CSS
-   ✅ Message flash untuk user feedback
-   ✅ Pagination di halaman list
-   ✅ Struktur siap untuk SAW calculation

## 🎯 Next Step (untuk SAW Calculation)

Siap untuk membuat:

1. **Alternative Model** - Tabel alternatif (wisata/destinasi)
2. **Evaluation Model** - Tabel nilai evaluasi (alternatif × kriteria)
3. **SAW Calculator Service** - Class untuk mengitung SAW
4. **Results View** - Tampil ranking hasil SAW

---

_Sistem telah terimplementasi dengan sempurna dan siap untuk tahap perhitungan SAW!_
