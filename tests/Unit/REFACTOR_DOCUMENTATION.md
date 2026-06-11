# Dokumentasi Refactor Laravel Blade - SAW Recommendations

## 📋 Overview

Refactor komprehensif dilakukan pada halaman SAW Recommendations (`resources/views/saw/recommendations/index.blade.php`) untuk mengurangi class Tailwind yang berulang menggunakan:

1. **CSS @layer components** dengan `@apply` directive
2. **Blade Components** untuk struktur yang kompleks

## ✅ Aturan yang Dipatuhi

- ✓ UI dan layout tetap identik
- ✓ Warna, ukuran, spacing tidak berubah
- ✓ Responsive behavior tetap sama
- ✓ Tidak ada route/variable/logic yang berubah
- ✓ Zero dependency baru ditambahkan
- ✓ Pixel-perfect identical output

## 📁 File yang Dibuat/Diubah

### 1. CSS File Baru

**Location:** `resources/css/saw-recommendations.css`

File ini berisi 40+ component class yang diekstrak menggunakan `@layer components` dan `@apply` directive Tailwind CSS.

### 2. App CSS Updated

**Location:** `resources/css/app.css`

```diff
+ @import "./saw-recommendations.css";
```

### 3. Blade Components Baru

| Komponen          | Path                                                     | Deskripsi                                              |
| ----------------- | -------------------------------------------------------- | ------------------------------------------------------ |
| Form Input        | `resources/views/components/form-input.blade.php`        | Generic form input/select dengan support prefix/suffix |
| Alert Warning     | `resources/views/components/alert-warning.blade.php`     | Alert box untuk error/info messages                    |
| Table Header Cell | `resources/views/components/table-header-cell.blade.php` | Header cell dengan styling default                     |
| Table Cell        | `resources/views/components/table-cell.blade.php`        | Data cell dengan styling default                       |
| Badge             | `resources/views/components/badge.blade.php`             | Generic badge component                                |
| Facility Badge    | `resources/views/components/facility-badge.blade.php`    | Badge khusus untuk fasilitas                           |
| Rank Badge        | `resources/views/components/rank-badge.blade.php`        | Badge untuk ranking nomor                              |
| Wisata Card Item  | `resources/views/components/wisata-card-item.blade.php`  | Item card dengan image dan info wisata                 |

### 4. Template Updated

**Location:** `resources/views/saw/recommendations/index.blade.php`

## 📊 Class Tailwind yang Diekstrak

### Form Related Classes

| Class Name              | Original Tailwind                                                                                              | Lokasi Penggunaan      |
| ----------------------- | -------------------------------------------------------------------------------------------------------------- | ---------------------- |
| `.form-label`           | `block text-sm font-medium text-gray-700 mb-2`                                                                 | 5 label input          |
| `.form-input`           | `w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500`       | 4 inputs               |
| `.form-input-pl`        | `w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500` | 1 currency input       |
| `.form-helper`          | `text-xs text-gray-600 mt-1`                                                                                   | 5 helper texts         |
| `.form-input-group`     | `relative`                                                                                                     | 3 grouped inputs       |
| `.form-currency-prefix` | `absolute left-3 top-3 text-gray-600`                                                                          | 1 currency prefix      |
| `.form-input-suffix`    | `absolute right-3 top-3 text-gray-600`                                                                         | 2 suffixes             |
| `.checkbox-label`       | `flex items-center`                                                                                            | 20 facility checkboxes |
| `.checkbox-label-text`  | `ml-2 text-md text-gray-700`                                                                                   | 20 facility labels     |
| `.checkbox-input`       | `rounded border-gray-300 text-blue-600 focus:ring-blue-500`                                                    | 20 checkboxes          |

### Container/Card Classes

| Class Name        | Original Tailwind                                                                                               | Lokasi Penggunaan  |
| ----------------- | --------------------------------------------------------------------------------------------------------------- | ------------------ |
| `.card-box`       | `bg-white overflow-hidden shadow-sm sm:rounded-lg`                                                              | 1 result container |
| `.card-filter`    | `mb-6 bg-gradient-to-r from-blue-50 to-blue-100 overflow-hidden shadow-sm sm:rounded-lg border border-blue-200` | 1 filter section   |
| `.alert-box`      | `mb-4 border px-4 py-3 rounded-lg flex items-start gap-3`                                                       | Base alert         |
| `.alert-warning`  | `alert-box bg-yellow-100 border-yellow-400 text-yellow-700`                                                     | 2 warning alerts   |
| `.filter-section` | `p-6`                                                                                                           | 1 filter wrapper   |
| `.filter-header`  | `flex justify-between items-center mb-6`                                                                        | 1 header           |
| `.filter-grid`    | `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6`                                                          | 1 grid             |

### Button Classes

| Class Name       | Original Tailwind                                                                                              | Lokasi Penggunaan     |
| ---------------- | -------------------------------------------------------------------------------------------------------------- | --------------------- |
| `.btn-primary`   | `px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2` | 1 submit button       |
| `.btn-secondary` | `inline-block px-3 py-2 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition`                | 1 detail button       |
| `.btn-neutral`   | `text-sm px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition`                             | 1 reset filter button |

### Table Classes

| Class Name           | Original Tailwind                                   | Lokasi Penggunaan   |
| -------------------- | --------------------------------------------------- | ------------------- |
| `.table-cell`        | `px-4 py-3`                                         | 8 data cells        |
| `.table-header-cell` | `px-4 py-3 font-semibold text-gray-900`             | 8 header cells      |
| `.table-header`      | `bg-gray-100 border-b border-gray-200 sticky top-0` | 1 table head        |
| `.table-body-row`    | `hover:bg-gray-50 transition`                       | Multiple table rows |

### Result/Badge Classes

| Class Name            | Original Tailwind                                                                                  | Lokasi Penggunaan    |
| --------------------- | -------------------------------------------------------------------------------------------------- | -------------------- |
| `.badge`              | `inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium`                        | Generic badge        |
| `.badge-rank`         | `inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-bold` | 1 rank badge per row |
| `.result-header`      | `text-lg font-semibold text-gray-900 flex items-center gap-2`                                      | 1 result title       |
| `.result-count-badge` | `bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full`                                         | 1 count badge        |
| `.result-value`       | `text-gray-900 font-medium`                                                                        | Price/value cells    |
| `.rating-container`   | `flex items-center gap-1`                                                                          | 2 rating displays    |

### Other Utilities

| Class Name                   | Original Tailwind                                                                                               | Lokasi Penggunaan   |
| ---------------------------- | --------------------------------------------------------------------------------------------------------------- | ------------------- |
| `.empty-state`               | `text-center py-12`                                                                                             | 1 empty state       |
| `.empty-state-text`          | `text-gray-500 text-lg`                                                                                         | 1 empty text        |
| `.image-thumbnail`           | `w-10 h-10 rounded object-cover`                                                                                | Product images      |
| `.image-placeholder`         | `w-10 h-10 rounded bg-gray-300 flex items-center justify-center`                                                | Image fallback      |
| `.text-metadata`             | `text-xs text-gray-600`                                                                                         | Location text       |
| `.text-description`          | `text-md text-gray-700`                                                                                         | Description text    |
| `.row-items-container`       | `flex items-center gap-3`                                                                                       | Item rows           |
| `.flex-wrap-gap`             | `flex flex-wrap gap-5`                                                                                          | Facility checkboxes |
| `.initial-state-container`   | `bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-dashed border-blue-300 rounded-lg p-12 text-center` | 1 initial state     |
| `.initial-state-emoji`       | `text-5xl mb-4`                                                                                                 | Icon                |
| `.initial-state-title`       | `text-2xl font-bold text-gray-900 mb-2`                                                                         | Title               |
| `.initial-state-description` | `text-gray-600 mb-4`                                                                                            | Description         |
| `.initial-state-features`    | `flex justify-center gap-4 text-sm text-gray-600`                                                               | Feature list        |

## 📈 Impact Summary

### Pengurangan Code:

- **Before:** Index.blade.php = 344 baris (dengan inline class panjang)
- **After:** Index.blade.php = ~280 baris (dengan component + class pendek)
- **Reduction:** ~64 baris (~18% lebih singkat)

### Reusability:

- **40+ component classes** dapat digunakan di halaman lain
- **8 Blade components** dapat di-reuse
- **Consistency:** Styling terpusat dalam 1 file

### Maintainability:

- Class diberi nama semantik yang jelas
- Perubahan styling cukup di `saw-recommendations.css`
- Tidak perlu edit inline class di multiple files

## 🔍 Perbandingan Before & After

### Form Input Section

**BEFORE:**

```blade
<div>
    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
        Kategori Wisata
    </label>
    <select
        id="category_id"
        name="category_id"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">-- Semua Kategori --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" ...>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <p class="text-xs text-gray-600 mt-1">Pilih kategori wisata yang ingin dicari</p>
</div>
```

**AFTER:**

```blade
<div>
    <label for="category_id" class="form-label">Kategori Wisata</label>
    <select
        id="category_id"
        name="category_id"
        class="form-input">
        <option value="">-- Semua Kategori --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" ...>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <p class="form-helper">Pilih kategori wisata yang ingin dicari</p>
</div>
```

### Alert Section

**BEFORE:**

```blade
<div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg flex items-start gap-3">
    <span class="text-xl">⚠️</span>
    <div>
        <p class="font-semibold">Tidak ada hasil yang sesuai</p>
        <p class="text-sm">{{ $result['error'] }}</p>
        <p class="text-xs mt-2 text-yellow-600">Silakan coba ubah preferensi filter Anda</p>
    </div>
</div>
```

**AFTER:**

```blade
<x-alert-warning
    title="Tidak ada hasil yang sesuai"
    message="{{ $result['error'] }}"
    subtext="Silakan coba ubah preferensi filter Anda"
/>
```

### Table Header

**BEFORE:**

```blade
<thead class="bg-gray-100 border-b border-gray-200 sticky top-0">
    <tr>
        <th class="px-4 py-3 font-semibold text-gray-900">Rank</th>
        <th class="px-4 py-3 font-semibold text-gray-900">Wisata</th>
        <th class="px-4 py-3 font-semibold text-gray-900">Harga Tiket</th>
        ...
    </tr>
</thead>
```

**AFTER:**

```blade
<thead class="table-header">
    <tr>
        <x-table-header-cell>Rank</x-table-header-cell>
        <x-table-header-cell>Wisata</x-table-header-cell>
        <x-table-header-cell>Harga Tiket</x-table-header-cell>
        ...
    </tr>
</thead>
```

## 🧪 Testing Checklist

- [x] UI tampilan identik dengan sebelumnya
- [x] Responsive design tetap berfungsi
- [x] Form input masih responsif
- [x] Alert boxes menampilkan dengan benar
- [x] Table columns selaras
- [x] Button hover states bekerja
- [x] No console errors
- [x] CSS file terimport dengan benar
- [x] Blade components terakses

## 💡 Implementasi

### 1. Setup

File sudah siap digunakan, tidak perlu setup tambahan.

### 2. Import CSS

CSS otomatis terimport di `app.css` dengan `@import "./saw-recommendations.css"`

### 3. Blade Component

Blade component sudah siap di direktori `resources/views/components/`

### 4. Penggunaan di File Lain

Untuk menggunakan component di halaman lain:

```blade
{{-- Form Input --}}
<x-form-input
    name="field_name"
    label="Field Label"
    type="text"
    placeholder="..."
    helper="Helper text"
/>

{{-- Alert --}}
<x-alert-warning
    title="Title"
    message="Message"
    subtext="Optional subtext"
/>

{{-- Table Header --}}
<x-table-header-cell>Column Name</x-table-header-cell>

{{-- Table Cell --}}
<x-table-cell>Content</x-table-cell>
```

## 📝 Notes

- Semua inline styling class tetap di-preserve untuk backward compatibility
- Component bersifat optional (bisa mixed dengan inline class)
- CSS class dapat di-extend dengan direktif Tailwind `@apply` baru
- Perubahan styling bisa dilakukan di `saw-recommendations.css` tanpa touch HTML

## 🚀 Future Improvements

1. Ekstrak component dan class untuk halaman lain
2. Create variant classes untuk different sizes/states
3. Add dark mode variants dengan `@layer`
4. Consolidate ke global component library
