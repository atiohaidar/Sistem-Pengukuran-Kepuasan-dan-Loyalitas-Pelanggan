# Sistem Pengukuran Kepuasan dan Loyalitas Pelanggan

## Deskripsi

Aplikasi web ini dibangun menggunakan framework Laravel untuk membantu mengukur tingkat kepuasan dan loyalitas pelanggan melalui survei online. Aplikasi ini memungkinkan admin untuk membuat pertanyaan survei, mengumpulkan respons dari pelanggan, dan menganalisis hasilnya untuk meningkatkan kualitas layanan.

## Fitur Utama

- **Manajemen Pertanyaan**: Buat dan kelola pertanyaan survei berdasarkan dimensi tertentu.
- **Pengumpulan Data Responden**: Kumpulkan data demografis dan respons survei dari pelanggan.
- **Analisis Hasil**: Lihat grafik dan laporan hasil survei secara real-time.
- **Export Laporan**: Ekspor hasil survei ke format PDF atau Excel.
- **Dashboard Admin**: Interface untuk mengelola survei dan melihat statistik.
- **Evaluasi Sistem Pengelolaan Pelanggan (SPP)**: Multi-step wizard publik, kalkulasi otomatis menggunakan service layer, dan dashboard hasil yang mereplikasi aplikasi referensi React.

## Persyaratan Sistem

Sebelum menginstall aplikasi ini, pastikan sistem Anda memenuhi persyaratan berikut:

- **PHP**: Versi 8.2 atau lebih tinggi
- **Composer**: Untuk manajemen dependensi PHP
- **Database**: SQLite (default), MySQL, atau PostgreSQL
- **Node.js**: Versi 16+ (untuk build frontend, opsional)
- **Web Server**: Apache atau Nginx (untuk production)

## Cara Instalasi

Ikuti langkah-langkah berikut untuk menginstall aplikasi ini di lingkungan lokal:

### 1. Clone Repositori

```bash
git clone https://github.com/atiohaidar/Sistem-Pengukuran-Kepuasan-dan-Loyalitas-Pelanggan.git
cd Sistem-Pengukuran-Kepuasan-dan-Loyalitas-Pelanggan
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Setup Environment

Salin file environment example dan sesuaikan konfigurasi:

```bash
cp .env.example .env
```

Edit file `.env` untuk mengatur database dan pengaturan lainnya.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Setup Database

Jalankan migrasi dan seeding untuk membuat tabel dan data awal:

```bash
php artisan migrate --seed
```

### 6. Jalankan Aplikasi

Untuk development:

```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

Untuk production, gunakan web server seperti Apache atau Nginx.

## Cara Penggunaan

1. **Login sebagai Admin**: Gunakan kredensial default atau yang telah dibuat.
2. **Buat Survei**: Tambahkan dimensi dan pertanyaan baru.
3. **Bagikan Link Survei**: Berikan link survei kepada pelanggan.
4. **Lihat Hasil**: Akses dashboard untuk melihat grafik dan laporan.
5. **Export Data**: Unduh laporan dalam format PDF atau Excel.

### Alur Evaluasi SPP

1. Akses halaman publik `GET /evaluasi-spp` untuk memulai asesmen.
2. Isi tiga tahap wizard: maturitas (8 pertanyaan), prioritas kepentingan (11 item, total 100), dan readiness audit (11 pertanyaan).
3. Setelah submit, sistem menyimpan hasil ke tabel `spp_evaluations`, menghitung skor melalui `App\Services\SppEvaluationResultService`, dan mengarahkan ke `GET /evaluasi-spp/hasil/{token}`.
4. Dashboard hasil menampilkan tabel, insight, grafik Importance-Performance, process group score, dan rekomendasi spesifik.
5. Admin dapat memonitor seluruh submission melalui menu **Evaluasi SPP** di dashboard.

> Seluruh kalkulasi (skor maturitas, process group, overall score, rekomendasi, serta plotting IPA chart) kini dipusatkan di service `App\Services\SppEvaluationResultService` agar mudah diuji dan dipakai ulang.

## Troubleshooting

Berikut adalah masalah umum dan solusinya:

### Error: "could not find driver (Connection: sqlite)"

**Penyebab**: Ekstensi PHP untuk database tidak terinstall.

**Solusi**:
- Untuk SQLite: `sudo apt install php8.2-sqlite3`
- Untuk MySQL: `sudo apt install php8.2-mysql`
- Untuk PostgreSQL: `sudo apt install php8.2-pgsql`

Restart web server setelah install ekstensi.

### Error: "PHP version not supported"

**Penyebab**: Versi PHP kurang dari 8.2.

**Solusi**: Upgrade PHP ke versi 8.2 atau lebih tinggi. Lihat panduan upgrade di dokumentasi.

### Error: "Class not found" atau "Autoload error"

**Penyebab**: Dependensi belum terinstall.

**Solusi**:
```bash
composer install
composer dump-autoload
```

### Error: "Permission denied" pada storage atau logs

**Penyebab**: Permission folder tidak benar.

**Solusi**:
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Database Connection Failed

**Penyebab**: Konfigurasi database di `.env` salah.

**Solusi**: Periksa pengaturan DB_HOST, DB_PORT, DB_DATABASE, dll. Pastikan database server berjalan.

### Jika Masih Ada Masalah

- Jalankan `php artisan config:clear` dan `php artisan cache:clear`
- Periksa log error di `storage/logs/laravel.log`
- Pastikan semua ekstensi PHP terinstall: `php -m`

## Lisensi Dependensi

Aplikasi ini menggunakan berbagai dependensi open source dengan lisensi sebagai berikut:

- **Laravel Framework**: MIT License
- **barryvdh/laravel-dompdf**: MIT License (untuk generate PDF)
- **maatwebsite/excel**: MIT License (untuk export Excel)
- **stevebauman/location**: MIT License (untuk deteksi lokasi)
- **laravel/tinker**: MIT License
- **laravel/ui**: MIT License
- **fakerphp/faker**: MIT License (untuk testing)
- **laravel/pint**: MIT License (untuk code style)
- **laravel/sail**: MIT License (untuk Docker)
- **mockery/mockery**: BSD License (untuk testing)
- **nunomaduro/collision**: MIT License
- **phpunit/phpunit**: BSD License (untuk testing)
- **spatie/laravel-ignition**: MIT License (untuk error handling)


## Kontribusi

Kami menerima kontribusi dari komunitas. Silakan buat issue atau pull request di repositori GitHub.

## Dukungan

Jika Anda mengalami masalah, buat issue di [GitHub Issues](https://github.com/atiohaidar/Sistem-Pengukuran-Kepuasan-dan-Loyalitas-Pelanggan/issues) atau hubungi maintainer.

---

