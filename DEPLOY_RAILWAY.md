# Deploy ke Railway

Project ini paling cocok dideploy ke Railway dengan:

- 1 `App Service` untuk Laravel
- 1 `MySQL Service` untuk database
- 1 `Volume` untuk menyimpan upload gambar wisata secara persisten

Alasan utamanya: aplikasi ini menyimpan gambar wisata ke `storage/app/public`, jadi platform yang hanya memberi disk sementara akan membuat gambar hilang setelah redeploy bila tidak memakai object storage tambahan.

## 1. Persiapan GitHub

Pastikan branch yang ingin dipublish sudah ter-push ke GitHub.

## 2. Buat project di Railway

1. Buka Railway lalu buat project baru.
2. Pilih `Deploy from GitHub repo`.
3. Pilih repository aplikasi ini.
4. Setelah service app dibuat, tambahkan service `MySQL`.

Referensi resmi:

- Railway Laravel guide: https://docs.railway.com/guides/laravel
- Railway MySQL guide: https://docs.railway.com/guides/mysql
- Railway variables: https://docs.railway.com/variables

## 3. Konfigurasi App Service

Di service Laravel Anda, atur:

- `Custom Build Command`: `npm run build`
- `Pre-Deploy Command`: `chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh`

Catatan: Railway mendeteksi aplikasi Laravel secara otomatis dan menjalankannya dengan `php-fpm` + Caddy.

## 4. Tambahkan environment variables

Di tab `Variables`, Anda bisa pakai isi file [.env.production.example](/c:/laragon/www/PZN/gorogon/my-skripsi/.env.production.example:1) sebagai template.

Yang wajib dicek sebelum deploy:

- Ganti `APP_KEY` dengan hasil dari `php artisan key:generate --show`
- Ganti `APP_URL` setelah Railway memberi domain publik

Rekomendasi untuk project ini:

- `QUEUE_CONNECTION=sync`
  Karena saat ini app tidak membutuhkan queue worker aktif.
- `LOG_CHANNEL=stderr`
  Agar log tampil di dashboard Railway.

## 5. Tambahkan volume untuk upload gambar

Tambahkan `Volume` ke App Service dan mount ke:

- `/app/storage/app/public`

Ini adalah mount path yang saya sarankan berdasarkan struktur Laravel project ini, supaya file upload pada disk `public` tetap ada setelah redeploy.

## 6. Jalankan migrasi dan publish

Script [railway/init-app.sh](/c:/laragon/www/PZN/gorogon/my-skripsi/railway/init-app.sh:1) akan otomatis menjalankan:

- `php artisan migrate --force`
- `php artisan storage:link`
- `php artisan config:cache`
- `php artisan route:cache`
- `php artisan view:cache`

## 7. Buka akses publik

Setelah deploy sukses:

1. Buka `Settings` service app.
2. Masuk ke bagian `Networking`.
3. Klik `Generate Domain`.

Railway menyebutkan service hasil deploy GitHub belum otomatis publik sampai domain digenerate.

## 8. Setelah domain aktif

Ubah `APP_URL` menjadi domain Railway Anda, lalu redeploy.

Contoh:

```env
APP_URL=https://nama-app-anda.up.railway.app
```

## 9. Kalau nanti ingin custom domain

Setelah domain Railway aktif, Anda bisa menambahkan domain sendiri dari menu `Networking`.

## Kenapa saya merekomendasikan Railway, bukan Laravel Cloud, untuk repo ini

Laravel Cloud sangat nyaman untuk deploy Laravel, tetapi dokumentasi environment-nya menjelaskan bahwa `php artisan storage:link` tidak persisten dan file storage persisten disarankan memakai object storage. Karena app Anda sekarang memakai local public storage untuk upload gambar, Railway + Volume lebih langsung dipakai tanpa refactor fitur upload dulu.

Referensi resmi Laravel Cloud:

- https://cloud.laravel.com/docs/environments
- https://marketing.cloud.laravel.com/
