# Setup Fondasi Database - 03 Maret 2026

## ✅ Completed Tasks

### 1. Tabel Kategori (Categories)

**File:** [database/migrations/2026_03_03_000001_create_categories_table.php](database/migrations/2026_03_03_000001_create_categories_table.php)

Struktur tabel:

-   `id` (Primary Key)
-   `name` (unique)
-   `description` (nullable)
-   `created_at`, `updated_at`

### 2. Tabel Wisata

**File:** [database/migrations/2026_03_03_000002_create_wisatas_table.php](database/migrations/2026_03_03_000002_create_wisatas_table.php)

Struktur tabel:

-   `id` (Primary Key)
-   `category_id` (Foreign Key → categories)
-   `name`
-   `description` (nullable)
-   `location` (nullable)
-   `address` (nullable)
-   `latitude`, `longitude` (untuk maps)
-   `rating`
-   `image` (nullable)
-   `created_at`, `updated_at`

**Relasi:** `onDelete('cascade')` - Ketika kategori dihapus, semua wisata akan ikut terhapus

### 3. Models dengan Relasi

#### Category Model

**File:** [app/Models/Category.php](app/Models/Category.php)

```php
// One-to-Many Relationship
public function wisatas()
{
    return $this->hasMany(Wisata::class);
}
```

#### Wisata Model

**File:** [app/Models/Wisata.php](app/Models/Wisata.php)

```php
// Belongs-to Relationship
public function category()
{
    return $this->belongsTo(Category::class);
}
```

### 4. Data Seeding

**File:** [database/seeders/CategorySeeder.php](database/seeders/CategorySeeder.php)

Data yang sudah ada di database:

```
### Pantai (2 wisatas)
  • Pantai Kuta - Bali
  • Pantai Seminyak - Bali
- Gunung (1 wisatas)
  • Gunung Bromo - Jawa Timur
- Budaya (1 wisatas)
  • Candi Borobudur - Jawa Tengah
- Air Terjun (1 wisatas)
  • Air Terjun Tegenungan - Bali
```

### 5. Testing - Semua Test Passed ✅

**File:** [tests/Feature/WisataTest.php](tests/Feature/WisataTest.php)

Tests yang berhasil:

-   ✅ category can be created and retrieved
-   ✅ wisata belongs to category
-   ✅ category has many wisatas
-   ✅ wisatas deleted when category deleted (cascade)
-   ✅ seeded data exists

**Result:** 5 passed (14 assertions) - 6.91s

## Database Status

```
Total Categories: 4
Total Wisatas: 5
Relasi: ✅ Working perfectly
Cascade Delete: ✅ Verified
```

## Siap untuk CRUD Besok

Fondasi sudah solid:

-   ✅ Database migrations sudah berjalan
-   ✅ Models dengan relations sudah siap
-   ✅ Test coverage untuk relasi sudah ada
-   ✅ Sample data sudah tersedia

### Next Steps (Untuk CRUD):

1. **Controllers** - CategoryController, WisataController
2. **Views** - Form input, list, detail, edit
3. **Routes** - RESTful routes di routes/web.php
4. **Form Validation** - FormRequests untuk Category & Wisata
5. **CRUD Operations**:
    - Create - Tambah kategori dan wisata baru
    - Read - Lihat semua kategori/wisata dan detail
    - Update - Edit kategori dan wisata
    - Delete - Hapus kategori dan wisata

---

**Status:** Database Foundation Ready
**Last Updated:** 03 Maret 2026
