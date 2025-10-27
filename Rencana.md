
<p style="text-align: center;">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>

# Rencana Penambahan/Perubahan Fitur

Target penyelesaian: 25 November 2025



## Ringkasan
- Menambah role dan alur registrasi UMKM (pending / approval oleh superadmin).
- Menambah manajemen akses: Superadmin (kelola seluruh UMKM) dan Admin UMKM (kelola data UMKM sendiri).
- Merubah fitur manajemen survei kepuasan & loyalitas per UMKM (produk / pelatihan dapat ditambahkan, dashboard per produk/pelatihan, pembatasan jumlah responden, share link).
- Pada modul Manajemen Evaluasi CRM dengan fitur Asesmen Kesiapan Internal, dirubah logic nya menjadi ada link untuk survei internal umkm tersebut, dan untuk dashboard nya menjadi gabungan dari setiap survei
- Menambah fitur manajemen data transaksi + dashboard, dengan inputan bisa input manual ataupun import via excel. serta user bisa mendownload template Excel 
- Membuat dokumentasi maintance, penggunaan, dan video panduan.


## Update Fitur
1. Registrasi UMKM & alur approval
    - Tambah role `superadmin`, `umkm`.
	- Middleware untuk membatasi akses per UMKM.
	- Form pendaftaran UMKM (email, password, nama usaha, kontak, deskripsi).
	- Status: pending, approved, rejected.
	- Halaman `Menunggu ACC` untuk UMKM belum disetujui; tampilkan kontak admin.
	- Notifikasi via email saat pendaftaran diterima/ditolak. (if possible)
2. Manajemen UMKM (Admin)
    - Halaman dashboard superadmin untuk melihat daftar UMKM terdaftar, status, dan aksi (approve/reject).
    - Fitur pencarian dan filter UMKM berdasarkan status.
3. Manajemen Survei Kepuasan & Loyalitas (per UMKM)
	- Admin UMKM dapat membuat unit survei : pilih tipe (Produk / Pelatihan), beri judul & deskripsi dan bisa mengirimkan link survei ke pelanggan. Note: untuk pertanyaan survei nya tidak bisa diubah2 karena sudah fixed sesuai metodologi & perhitungan yang digunakan.
	- Untuk tiap survei: batas jumlah responden, periode aktif survei
	- Dashboard survei per produk/pelatihan
    - Pada form survei, tambah informasi tentang produk/pelatihan (nama dan deskripsi)
4. Fitur Assesment Kesiapan Internal (per UMKM)
    - Setiap UMKM dapat link survei asesmen kesiapan internal yang dapat diisi oleh staf internal UMKM tersebut.
    - Dashboard gabungan hasil asesmen dari semua staf internal UMKM, menampilkan skor kesi
5. Manajemen Data Transaksi Pelanggan (per UMKM)
    - Dashboard analisis data transaksi
    - Form input data transaksi manual (nama pelanggan, tanggal, produk/jasa, nilai transaksi).
    - Fitur impor data transaksi dari file Excel (dengan template yang disediakan).
6. Akses Superadmin dan Admin UMKM
    - Superadmin dapat mengelola semua UMKM, survei, dan data transaksi.
    - Admin UMKM hanya dapat mengelola data UMKM sendiri, survei, dan data transaksi terkait.

## Rencana Effort
- Integrasi dengan layanan email untuk notifikasi
- Mengubah database schema
- Menambah Middleware untuk role dan permission serta mengimpelementasikan pada fitur yang sudah tersedia
- Mengubah logika pada modul survei dan CRM
- Menambah fitur manajemen data transaksi
- Mengubah/Menambah Tampilan
- Pemisahan fitur bedasarkan akses superadmin dan admin umkm
- Membuat Dokumentasi Penggunaan, dan Pemeliharaan
- Membuat Video Panduan Penggunaan

## Tindakan yang Harus Dilakukan (Actionable Checklist) (Tidak Full Diimplementasikan, sebagai gambaran saja)
Berikut daftar langkah konkret yang bisa Anda (atau tim) lakukan untuk mengeksekusi rencana ini secara sistematis — dari persiapan, implementasi, hingga serah terima.

1) Persiapan & koordinasi
    - Kumpulkan sign-off requirement dari PO/owner (konfirmasi bidang data yang wajib pada registrasi UMKM, batas default transaksi, format tanggal/nominal pada template Excel).
    - Tentukan resource (siapa backend, frontend, QA, siapa kontak superadmin) dan buat board tugas (GitHub Projects / Trello).
    - Siapkan environment staging untuk development dan testing (database cadangan, storage untuk upload).

2) Desain & schema
    - Rancang ERD singkat: tabel `umkms`/`umkm_profiles`, `users` (link ke umkm), `roles`, `surveys`, `survey_questions`, `survey_responses`, `transactions`, `import_jobs`, `readiness_answers`.
    - Buat daftar migration dan sketch kolom penting (status pendaftaran, approved_by, limit_transaksi, template_version).
    - Tentukan API contract (endpoint, payload contoh) untuk import Excel dan preview.

3) Auth / Roles / Registrasi UMKM
    - Implementasi role `superadmin` dan `umkm` (migrations + seeder untuk akun awal).
    - Form registrasi UMKM: validasi server & client, simpan status `pending`.
    - Halaman `Menunggu ACC` untuk user yang belum di-approve, sertakan kontak admin.
    - Endpoint approve/reject untuk superadmin; kirim email notifikasi (queueable job).

4) Middleware & Access Control
    - Buat middleware untuk memastikan admin UMKM akses hanya data UMKM-nya.
    - Tambahkan cek ownership di controller/service layer untuk operasi CRUD.

5) Survei Kepuasan & Loyalitas (per UMKM)
    - CRUD survei (judul, deskripsi, tipe: produk/pelatihan, periode, batas responden).
    - Tetapkan pertanyaan tetap (metodologi) dan jangan izinkan perubahan struktur pertanyaan tanpa versi baru.
    - Fitur share link + tracking token untuk setiap link (opsional: batas akses link oleh IP atau maksimal submit per token).
    - Dashboard: hitung IKP/ILP/gap menggunakan service (reuse `SurveyCalculationService`), tampilkan chart dasar.

6) Asesmen Kesiapan Internal (Readiness)
    - Buat link survei internal khusus UMKM yang dapat diisi staf.
    - Kumpulkan respon multiple users dan gabungkan skor; tampilkan ringkasan di admin UMKM.

7) Manajemen Transaksi & Import Excel
    - Buat template Excel (kolom: external_id,opt customer_name, date(YYYY-MM-DD), product, amount, quantity).
    - Endpoint upload: parse file, validasi baris → simpan sebagai import job; tampilkan preview dan error per baris.
    - Proses impor lewat background job (batches), batasi ukuran batch untuk mencegah OOM/timeout.
    - Tambah fitur undo/rollback untuk import (simpan import_job_id pada baris yang diimpor).
    - Tambahkan limit configurable per UMKM (default: 10k rows) dan cek kuota sebelum commit import.

8) Integrasi Analisis Revolt (atau metode transaksi lain)
    - Definisikan metrik yang dibutuhkan dari transaksi (RFM, total nilai, frekuensi, recency).
    - Buat service untuk menghitung metrik dari tabel transaksi dan menggabungkan dengan hasil readiness.

9) Notifikasi & Logging
    - Implementasikan email via queue (pustaka mail yang sudah ada di project), template untuk notifikasi pendaftaran dan hasil impor.
    - Simpan audit log untuk aksi penting (approve UMKM, impor, hapus transaksi).

10) Frontend & UX
    - Halaman registrasi & pending; halaman admin UMKM (buat survei, import, dashboard), halaman superadmin (list UMKM, approve).
    - Validasi input dan tampilan error yang ramah pengguna.

11) Testing & QA
    - Unit test untuk service penting (perhitungan IKP/ILP, import parsing, permission checks).
    - Integration test untuk flow registrasi → approval → buat survei → submit response.
    - Manual QA checklist: upload file besar, format salah, duplicate transactions, hak akses.

12) Dokumentasi & Video
    - Buat dokumentasi singkat: instalasi/migrasi, environment variables, langkah import, template Excel.
    - Buat user guide singkat (3–5 halaman) dan 1 video walkthrough 5–10 menit.

13) Deploy & Handover
    - Siapkan migration script dan backup DB.
    - Rilis ke staging untuk acceptance testing, kemudian ke production setelah sign-off.
    - Handover: changelog, instruksi rollback, daftar credential dan kontak support.

## Prioritas awal (week-1)
- Hari 1–2: finalisasi requirement & desain DB, buat migrations scaffold.
- Hari 3–5: implementasi role & registrasi UMKM + approval flow + email notifikasi sederhana.
- Minggu berikutnya: mulai fitur survey CRUD + menampilkan hasil sederhana (re-use SurveyCalculationService).

## Checklist kecil untuk tiap fitur saat selesai
- Database migrated & seeded (contoh data).
- Endpoint teruji (manual + unit test minimal).
- UI menampilkan hasil yang konsisten dengan perhitungan backend.
- Dokumentasi singkat (README per fitur) dan contoh file Excel.

---

Tambahkan prioritas atau tugas yang Anda rasa penting, lalu saya bisa ubah checklist ini menjadi issue/PR template atau langsung buat migration & template Excel untuk memulai implementasi.

