<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="320" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">Woka-Task</h1>

<p align="center">A Laravel-based task & project management application — simple, extensible, and ready for production.</p>

**Project**:  
- **Nama**: Woka-Task  
- **Stack**: PHP (Laravel), MySQL/MariaDB, Node.js + Vite (frontend assets)  
- **Tujuan**: Memanage proyek, anggota proyek, tugas, kolaborator, lampiran tugas, notifikasi, dan todo.

**Fitur Utama**
- **Proyek**: Buat/kelola proyek.
- **Anggota Proyek**: Undang dan kelola anggota proyek.
- **Tugas**: CRUD tugas dengan status, prioritas, tenggat waktu.
- **Kolaborator Tugas**: Kelola kolaborator tiap tugas.
- **Lampiran Tugas**: Unggah file lampiran pada tugas.
- **Notifikasi**: Notifikasi aktivitas (model `Notification` tersedia).
- **Profil Pengguna**: Informasi profil yang dapat diperluas.
- **Todos**: Daftar tugas kecil (todo) terkait tugas atau proyek.

**Prasyarat**
- **PHP**: 8.1+ (sesuaikan dengan `composer.json`)
- **Composer**: latest stable
- **Node.js**: 16+ (atau sesuai `package.json`)
- **NPM / Yarn / PNPM**: NPM direkomendasikan
- **Database**: MySQL / MariaDB / PostgreSQL
- **OS**: Windows / Linux / macOS (instruksi contoh untuk PowerShell)

**Instalasi (Quick start — PowerShell)**
- **Clone**: `git clone <repo-url> Woka-Task`
- **Masuk folder**: `cd Woka-Task`
- **Salin env**: `Copy-Item .env.example .env`
- **Install PHP deps**: `composer install --no-interaction --prefer-dist`
- **Install JS deps**: `npm install`
- **Generate app key**: `php artisan key:generate`
- **Konfigurasi DB**: Edit file ` .env` (lihat contoh di bawah)
- **Migrate + Seed (dev)**: `php artisan migrate --seed`
  - Jika butuh reset: `php artisan migrate:fresh --seed`
- **Link storage**: `php artisan storage:link`
- **Build assets (dev)**: `npm run dev`
- **Jalankan server**: `php artisan serve`
- **Akses**: buka `http://127.0.0.1:8000`

Contoh konfigurasi `.env` (nilai minimal):


**Perintah Berguna**
- **Serve**: `php artisan serve`
- **Migrate**: `php artisan migrate`
- **Seed**: `php artisan db:seed`
- **Fresh + seed**: `php artisan migrate:fresh --seed`
- **Storage link**: `php artisan storage:link`
- **Run tests**: `php artisan test`
- **Cache config**: `php artisan config:cache`
- **Cache route**: `php artisan route:cache`
- **Build assets (production)**: `npm run build`

**Struktur Proyek (ringkasan)**
- **`app/Models`**: Model domain (User, Project, Task, dll.)
- **`app/Http/Controllers`**: Kontroler HTTP
- **`database/migrations`**: Skema DB
- **`database/seeders`**: Seeder (contoh: AdminSeeder, DatabaseSeeder)
- **`resources/js` / `resources/css`**: Assets front-end (Vite)
- **`routes/web.php`**: Rute web
- **`public/storage`**: Lampiran file (via `storage:link`)

**Testing**
- Jalankan: `php artisan test`
- Jika ada PHPUnit: `vendor/bin/phpunit` (opsional)
- Pastikan environment test DB dikonfigurasi di `.env.testing` bila perlu.

**Deployment Checklist**
- Set `APP_ENV=production` dan `APP_DEBUG=false`.
- Jalankan: `composer install --optimize-autoloader --no-dev`
- Build assets: `npm ci && npm run build`
- Jalankan migrasi produksi: `php artisan migrate --force`
- Cache: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- Pastikan direktori `storage` dan `bootstrap/cache` dapat ditulis oleh webserver.

**Keamanan & Best Practices**
- Jangan commit file `.env`.
- Periksa dan batasi ukuran unggahan file lampiran pada konfigurasi upload.
- Gunakan HTTPS / certificate untuk produksi.
- Terapkan backup rutin untuk database dan file upload.

**Contributing**
- Fork repositori dan buat branch fitur: `git checkout -b feat/namafitur`
- Buat commit terpisah dan jelas: `git commit -m "feat: tambah fitur X"`
- Buat pull request dengan deskripsi perubahan, screenshot bila perlu.
- Ikuti standar code style PHP/Laravel (PSR-12) dan jalankan test sebelum PR.

**Troubleshooting**
- Jika migrasi gagal: cek koneksi DB dan kredensial di `.env`.
- Jika asset tidak muncul: jalankan `npm run dev` atau `npm run build`.
- Permasalahan storage: jalankan `php artisan storage:link` dan pastikan permission.

**Roadmap (opsional)**
- Integrasi API publik (REST)
- Notifikasi realtime (Broadcast / WebSockets)
- Role-based access control yang lebih granular
- Mobile-friendly UI / PWA

**Lisensi**
- MIT — lihat file `LICENSE` (jika tersedia).

**Kontak**
- **Pemilik repo**: AthaAdnanReswara  
- Untuk pertanyaan/kontribusi: buka issue di repository ini.

---

Terima kasih — jika Anda mau, saya bisa:
- Menyimpan konten ini langsung ke `README.md`.
- Menambahkan badge CI, coverage, atau contoh screenshot UI.
- Membuat template `CONTRIBUTING.md`.

Mau saya langsung tulis `README.md` di repo Anda sekarang? Jika ya, konfirmasi dan saya akan menambahkan filenya.**Perintah Berguna**
- **Serve**: `php artisan serve`
- **Migrate**: `php artisan migrate`
- **Seed**: `php artisan db:seed`
- **Fresh + seed**: `php artisan migrate:fresh --seed`
- **Storage link**: `php artisan storage:link`
- **Run tests**: `php artisan test`
- **Cache config**: `php artisan config:cache`
- **Cache route**: `php artisan route:cache`
- **Build assets (production)**: `npm run build`

**Struktur Proyek (ringkasan)**
- **`app/Models`**: Model domain (User, Project, Task, dll.)
- **`app/Http/Controllers`**: Kontroler HTTP
- **`database/migrations`**: Skema DB
- **`database/seeders`**: Seeder (contoh: AdminSeeder, DatabaseSeeder)
- **`resources/js` / `resources/css`**: Assets front-end (Vite)
- **`routes/web.php`**: Rute web
- **`public/storage`**: Lampiran file (via `storage:link`)

**Testing**
- Jalankan: `php artisan test`
- Jika ada PHPUnit: `vendor/bin/phpunit` (opsional)
- Pastikan environment test DB dikonfigurasi di `.env.testing` bila perlu.

**Deployment Checklist**
- Set `APP_ENV=production` dan `APP_DEBUG=false`.
- Jalankan: `composer install --optimize-autoloader --no-dev`
- Build assets: `npm ci && npm run build`
- Jalankan migrasi produksi: `php artisan migrate --force`
- Cache: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- Pastikan direktori `storage` dan `bootstrap/cache` dapat ditulis oleh webserver.

**Keamanan & Best Practices**
- Jangan commit file `.env`.
- Periksa dan batasi ukuran unggahan file lampiran pada konfigurasi upload.
- Gunakan HTTPS / certificate untuk produksi.
- Terapkan backup rutin untuk database dan file upload.

**Contributing**
- Fork repositori dan buat branch fitur: `git checkout -b feat/namafitur`
- Buat commit terpisah dan jelas: `git commit -m "feat: tambah fitur X"`
- Buat pull request dengan deskripsi perubahan, screenshot bila perlu.
- Ikuti standar code style PHP/Laravel (PSR-12) dan jalankan test sebelum PR.

**Troubleshooting**
- Jika migrasi gagal: cek koneksi DB dan kredensial di `.env`.
- Jika asset tidak muncul: jalankan `npm run dev` atau `npm run build`.
- Permasalahan storage: jalankan `php artisan storage:link` dan pastikan permission.

**Roadmap (opsional)**
- Integrasi API publik (REST)
- Notifikasi realtime (Broadcast / WebSockets)
- Role-based access control yang lebih granular
- Mobile-friendly UI / PWA

**Lisensi**
- MIT — lihat file `LICENSE` (jika tersedia).

**Kontak**
- **Pemilik repo**: AthaAdnanReswara  
- Untuk pertanyaan/kontribusi: buka issue di repository ini.

---

Terima kasih — jika Anda mau, saya bisa:
- Menyimpan konten ini langsung ke `README.md`.
- Menambahkan badge CI, coverage, atau contoh screenshot UI.
- Membuat template `CONTRIBUTING.md`.

Mau saya langsung tulis `README.md` di repo Anda sekarang? Jika ya, konfirmasi dan saya akan menambahkan filenya.