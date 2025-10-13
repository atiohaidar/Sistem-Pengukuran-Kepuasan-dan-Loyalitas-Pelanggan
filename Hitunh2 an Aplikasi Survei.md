# Sistem Pengukuran Kepuasan dan Loyalitas Pelanggan

Sistem survei untuk mengukur kepuasan dan loyalitas pelanggan terhadap layanan pelatihan menggunakan metode ServQual (Service Quality) dan Customer Loyalty Index.

---

## 🎯 Tentang Sistem

### Deskripsi
Sistem berbasis web ini dirancang untuk membantu **lembaga pelatihan** mengukur tingkat kepuasan dan loyalitas pelanggan/peserta terhadap layanan pelatihan yang diberikan. Sistem menggunakan pendekatan ilmiah dengan metode ServQual (Service Quality) dan Customer Loyalty Index (CLI) yang telah terbukti efektif dalam mengukur kualitas layanan.

### Konteks Bisnis
**Target Pengguna:**
- 🎓 **Lembaga Pelatihan** - Fokus utama sistem
- ☕ Coffee Shop (pengembangan mendatang)
- 👗 Usaha Fashion (pengembangan mendatang)
- 🌾 Usaha Agro Bisnis (pengembangan mendatang)

**Tujuan Bisnis:**
1. **Mengukur Kepuasan Pelanggan** - Mengevaluasi persepsi pelanggan terhadap layanan yang diberikan
2. **Mengidentifikasi Gap Layanan** - Menemukan kesenjangan antara harapan dan kenyataan
3. **Meningkatkan Loyalitas** - Memahami faktor-faktor yang mempengaruhi loyalitas pelanggan
4. **Pengambilan Keputusan** - Memberikan data terukur untuk perbaikan layanan
5. **Competitive Advantage** - Meningkatkan daya saing melalui perbaikan berkelanjutan

### Fitur Utama
- ✅ Survei online yang mudah diakses oleh responden
- ✅ Perhitungan otomatis Indeks Kepuasan Pelanggan (IKP)
- ✅ Perhitungan otomatis Indeks Loyalitas Pelanggan (ILP)
- ✅ Analisis Gap per dimensi dan per item
- ✅ Analisis standar deviasi untuk konsistensi layanan
- ✅ Segmentasi demografis (usia, jenis kelamin, pekerjaan, domisili)
- ✅ Prediksi pelanggan loyal berbasis probabilitas
- ✅ Visualisasi data dengan berbagai jenis grafik interaktif
- ✅ Dashboard admin untuk monitoring hasil survei
- ✅ Export data untuk analisis lanjutan

### Dimensi Pengukuran (ServQual + 1)
Sistem menggunakan 6 dimensi kualitas layanan:

1. **Reliability (Keandalan)** - 7 item
   - Kemampuan memberikan layanan yang dijanjikan
   - Ketepatan waktu dan akurasi

2. **Assurance (Jaminan)** - 4 item
   - Pengetahuan dan kesopanan karyawan
   - Kemampuan memberikan kepercayaan dan keyakinan

3. **Tangible (Bukti Fisik)** - 6 item
   - Fasilitas fisik, peralatan, dan materi komunikasi
   - Penampilan karyawan

4. **Empathy (Empati)** - 5 item
   - Perhatian individual kepada pelanggan
   - Pemahaman kebutuhan pelanggan

5. **Responsiveness (Daya Tanggap)** - 2 item
   - Kesediaan membantu pelanggan
   - Kecepatan dalam memberikan layanan

6. **Applicability (Aplikabilitas)** - 2 item ⭐ **Khusus Pelatihan**
   - Relevansi materi pelatihan dengan kebutuhan
   - Kemampuan menerapkan hasil pelatihan

> **Catatan:** Dimensi **Applicability** merupakan dimensi tambahan yang spesifik untuk konteks **lembaga pelatihan**, mengukur sejauh mana materi pelatihan dapat diaplikasikan dalam praktik nyata.

---

## Dokumentasi Perhitungan Matematis

Dokumen ini berisi penjelasan lengkap mengenai semua perhitungan matematis yang digunakan dalam sistem, termasuk formula, kegunaan, dan implementasinya.

---

## ✅ Status Dokumentasi

Dokumentasi ini mencakup **SEMUA** perhitungan matematis yang ada di sistem:

### Perhitungan di Controller (GrafikController.php)
- ✅ Rata-rata per item (26 item ServQual + 3 kepuasan + 3 loyalitas)
- ✅ Total rata-rata per dimensi (6 dimensi)
- ✅ Weighting Factor (WF) untuk semua item
- ✅ Weighted Score (WS) untuk semua item
- ✅ Indeks Kepuasan Pelanggan (IKP)
- ✅ Customer Loyalty Index (CLI) per item loyalitas
- ✅ Indeks Loyalitas Pelanggan (ILP)
- ✅ Gap per item (26 item ServQual)
- ✅ Gap per dimensi (6 dimensi)
- ✅ Gap kepuasan (K2 vs K3)
- ✅ Standar deviasi gap per dimensi (6 dimensi)
- ✅ Frekuensi dan persentase jenis kelamin
- ✅ Frekuensi dan persentase usia (6 kelompok)
- ✅ Frekuensi dan persentase pekerjaan (5 kategori)
- ✅ Frekuensi dan persentase domisili (8 wilayah)
- ✅ Persentase silang (usia × jenis kelamin)
- ✅ Frekuensi skala jawaban (K1, L1, L2, L3)

### Perhitungan di View (Blade Template)
- ✅ Probabilitas loyalitas untuk K1 (kepuasan)
- ✅ Probabilitas loyalitas untuk L1 (repeat purchase)
- ✅ Probabilitas loyalitas untuk L2 (retention)
- ✅ Probabilitas loyalitas untuk L3 (recommendation)
- ✅ Prediksi jumlah pelanggan loyal (4 perhitungan)
- ✅ Format angka untuk visualisasi

### Visualisasi
- ✅ 6 halaman grafik dengan berbagai jenis chart
- ✅ Tabel interpretasi hasil
- ✅ Gauge charts untuk IKP dan ILP

**Total: 100+ perhitungan matematis terdokumentasi lengkap!**

---

## 📌 Penjelasan Angka-Angka dalam Formula

Dokumen ini telah dilengkapi dengan penjelasan detail mengenai asal-usul semua angka/konstanta yang muncul dalam formula:

| Angka | Arti | Penjelasan Detail |
|-------|------|-------------------|
| **5** | Skala Likert Maksimum | Nilai tertinggi pada skala 1-5, digunakan sebagai pembagi untuk normalisasi |
| **100/100** | Faktor Konversi Skala | Sama dengan 1, memberikan fleksibilitas penyesuaian skala di masa depan |
| **× 100** | Konversi ke Persentase | Mengubah nilai desimal (0.84) menjadi persentase (84%) |
| **3** | Jumlah Aspek Loyalitas | Total item yang diukur (L1: repeat purchase, L2: retention, L3: recommendation) |
| **n-1** | Degrees of Freedom | Koreksi untuk standar deviasi sampel agar estimasi tidak bias |
| **0.00** | Probabilitas Skala 1 | 0% kemungkinan loyal (sangat tidak setuju) |
| **0.25** | Probabilitas Skala 2 | 25% kemungkinan loyal (tidak setuju) |
| **0.50** | Probabilitas Skala 3 | 50% kemungkinan loyal (netral) |
| **0.75** | Probabilitas Skala 4 | 75% kemungkinan loyal (setuju) |
| **1.00** | Probabilitas Skala 5 | 100% kemungkinan loyal (sangat setuju) |
| **7, 4, 6, 5, 2** | Jumlah Item per Dimensi | Reliability=7, Assurance=4, Tangible=6, Empathy=5, Responsiveness=2, Applicability=2 |

💡 **Catatan**: Setiap formula yang mengandung angka konstanta telah diberi penjelasan lengkap di bagian terkait dengan contoh perhitungan nyata.

---

## Daftar Isi
1. [Survei dan Pertanyaan](#survei-dan-pertanyaan)
2. [Perhitungan Indeks Kepuasan Pelanggan (IKP)](#perhitungan-indeks-kepuasan-pelanggan-ikp)
3. [Perhitungan Indeks Loyalitas Pelanggan (ILP)](#perhitungan-indeks-loyalitas-pelanggan-ilp)
4. [Perhitungan Gap Analysis](#perhitungan-gap-analysis)
5. [Perhitungan Weighted Score](#perhitungan-weighted-score)
6. [Perhitungan Standar Deviasi](#perhitungan-standar-deviasi)
7. [Perhitungan Statistik Demografis](#perhitungan-statistik-demografis)
8. [Perhitungan di View (Grafik)](#perhitungan-di-view-grafik)
9. [Perhitungan Probabilitas Loyalitas Pelanggan](#perhitungan-probabilitas-loyalitas-pelanggan)
10. [Perhitungan di View Lainnya](#perhitungan-di-view-lainnya)
11. [Ringkasan Formula Utama](#ringkasan-formula-utama)

---

## Survei dan Pertanyaan

Sistem ini menggunakan kuesioner yang terdiri dari beberapa bagian:

### Bagian I: Data Diri Responden
- Jenis Kelamin
- Usia
- Pekerjaan
- Domisili

### Bagian II: Penilaian Tingkat Kepentingan/Harapan
Mengukur seberapa penting atribut layanan bagi pelanggan (skala 1-5: Sangat tidak penting - Sangat penting)

**Dimensi Reliability (7 pertanyaan):**
- R1: Kesesuaian isi post test dengan materi pelatihan
- R2: Ketepatan waktu pelatihan sesuai jadwal
- R3: Ketepatan waktu pemberian sertifikat
- R4: Ketepatan trainer menjawab pertanyaan
- R5: Materi pelatihan mudah dimengerti
- R6: Kemudahan registrasi pelatihan
- R7: Kemudahan pembayaran pelatihan

**Dimensi Assurance (4 pertanyaan):**
- A1: Trainer bersikap sopan
- A2: Trainer memiliki pengetahuan luas
- A3: Trainer menyampaikan materi dengan mudah dipahami
- A4: Committee service menyelesaikan keluhan

**Dimensi Tangible (6 pertanyaan):**
- T1: Sistem aplikasi user friendly
- T2: Website menampilkan informasi terbaru
- T3: Perlengkapan audio visual berfungsi baik
- T4: Koneksi internet lancar
- T5: Tampilan modul menarik
- T6: Trainer berpenampilan rapi

**Dimensi Empathy (5 pertanyaan):**
- E1: Trainer memberi perhatian kepada peserta
- E2: Trainer memahami kebutuhan peserta
- E3: Komunikasi baik antara trainer dan peserta
- E4: Trainer membantu saat peserta kesulitan
- E5: Kecukupan waktu pelatihan

**Dimensi Responsiveness (2 pertanyaan):**
- RS1: Kecepatan respon contact person
- RS2: Kepastian informasi jadwal pelatihan

**Dimensi Applicability (2 pertanyaan):**
- AP1: Pelatihan berkaitan dengan pekerjaan
- AP2: Pelatihan mudah diterapkan dalam pekerjaan

### Bagian III: Penilaian Tingkat Persepsi/Kinerja
Mengukur penilaian pelanggan terhadap kinerja aktual layanan (skala 1-5: Sangat tidak setuju - Sangat setuju)
*Menggunakan pertanyaan yang sama dengan Bagian II*

### Bagian IV: Kepuasan Responden
- K1: Secara keseluruhan merasa puas
- K2: Kinerja sesuai dengan harapan
- K3: Layanan sesuai dengan yang ideal

### Bagian V: Loyalitas Responden
- L1: Akan mengulangi menggunakan jasa pelatihan
- L2: Tetap memilih meskipun ada alternatif lain
- L3: Akan merekomendasikan kepada orang lain

---

## Perhitungan Indeks Kepuasan Pelanggan (IKP)

### Lokasi: `GrafikController.php` - Method `grafik1()` dan `grafik2()`

### 1. Perhitungan Rata-rata Per Item

**Formula:**
```
Rata-rata = Total Nilai / Jumlah Responden
```

**Implementasi:**
```php
// Contoh untuk item R1 (Reliability pertanyaan 1)
$r1_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')
    ->where('kategori','=','persepsi')
    ->sum('r1');
    
$r1_ratapersepsi_count = DB::table('tbl_jawaban_realibility')
    ->where('kategori','=','persepsi')
    ->count('r1');
    
$r1_ratapersepsi_rata = $r1_ratapersepsi_sum / $r1_ratapersepsi_count;
```

**Kegunaan:**
- Menghitung nilai rata-rata penilaian pelanggan untuk setiap item pertanyaan
- Digunakan untuk kedua kategori: persepsi (kinerja aktual) dan kepentingan (harapan)

---

### 2. Perhitungan Total Rata-rata Per Dimensi

**Formula:**
```
Total Rata-rata Dimensi = (Σ Rata-rata Item) / Jumlah Item
```

**Implementasi:**
```php
// Untuk dimensi Reliability (7 item)
$total_rpersepsi = (
    $r1_ratapersepsi_rata + 
    $r2_ratapersepsi_rata + 
    $r3_ratapersepsi_rata + 
    $r4_ratapersepsi_rata + 
    $r5_ratapersepsi_rata + 
    $r6_ratapersepsi_rata + 
    $r7_ratapersepsi_rata
) / 7;
```

**Kegunaan:**
- Menghitung rata-rata keseluruhan untuk setiap dimensi kualitas layanan
- Memudahkan perbandingan antar dimensi

---

### 3. Perhitungan Total Harapan Keseluruhan

**Formula:**
```
Total Harapan = Σ(Total Kepentingan per Dimensi)
```

**Implementasi:**
```php
$totalharapan = $total_rkepentingan + 
                $total_akepentingan + 
                $total_tkepentingan + 
                $total_ekepentingan + 
                $total_rskepentingan + 
                $total_rlkepentingan;
```

**Kegunaan:**
- Menghitung total nilai harapan dari semua dimensi
- Digunakan sebagai pembagi untuk menghitung bobot (Weighting Factor)

---

### 4. Perhitungan Weighting Factor (WF)

**Formula:**
```
WF = Rata-rata Kepentingan Item / Total Harapan
```

**Implementasi:**
```php
// Contoh untuk item R1
$wf_r1 = $r1_ratakepentingan_rata / $totalharapan;
```

**Kegunaan:**
- Menghitung bobot kepentingan relatif setiap item terhadap keseluruhan
- Item yang dianggap lebih penting akan memiliki WF lebih besar
- Jumlah semua WF = 1

---

### 5. Perhitungan Weighted Score (WS)

**Formula:**
```
WS = Rata-rata Persepsi Item × WF Item
```

**Implementasi:**
```php
// Contoh untuk item R1
$ws_r1 = $r1_ratapersepsi_rata * $wf_r1;
```

**Kegunaan:**
- Menghitung skor tertimbang yang memperhitungkan tingkat kepentingan
- Item yang lebih penting akan memberikan kontribusi lebih besar terhadap IKP

---

### 6. Perhitungan Total Weighted Score

**Formula:**
```
Total WS = Σ(WS semua item)
```

**Implementasi:**
```php
$totalws = $ws_r1 + $ws_r2 + $ws_r3 + $ws_r4 + $ws_r5 + $ws_r6 + $ws_r7 +
           $ws_a1 + $ws_a2 + $ws_a3 + $ws_a4 +
           $ws_t1 + $ws_t2 + $ws_t3 + $ws_t4 + $ws_t5 + $ws_t6 +
           $ws_e1 + $ws_e2 + $ws_e3 + $ws_e4 + $ws_e5 +
           $ws_rs1 + $ws_rs2 +
           $ws_rl1 + $ws_rl2;
```

**Kegunaan:**
- Menjumlahkan semua skor tertimbang dari seluruh item
- Menghasilkan nilai mentah untuk IKP

---

### 7. Perhitungan Indeks Kepuasan Pelanggan (IKP) Final

**Formula:**
```
IKP = (Total WS / Skala Maksimum) × (Bobot Skala) × 100%
IKP = (Total WS / 5) × (100/100) × 100%
```

**Implementasi:**
```php
$totalikp = ($totalws / 5) * (100/100) * 100;
```

**Kegunaan:**
- Mengkonversi total weighted score menjadi persentase
- Skala 5 adalah nilai maksimum pada skala Likert yang digunakan
- Menghasilkan nilai IKP dalam rentang 0-100%

**Penjelasan Detail Angka dalam Formula:**

**1. Angka "5" (Pembagi) - Dari mana?**
```
Angka 5 = Nilai maksimum skala Likert yang digunakan dalam survei
```
- Sistem menggunakan skala Likert 1-5:
  - 1 = Sangat tidak setuju/penting
  - 2 = Tidak setuju/penting
  - 3 = Netral
  - 4 = Setuju/penting
  - 5 = Sangat setuju/penting ← **Ini adalah nilai maksimum**
- Membagi dengan 5 untuk normalisasi ke rentang 0-1
- **Contoh**: Jika Total WS = 4.2, maka 4.2/5 = 0.84 (84% dari maksimum)

**2. Angka "100/100" (Bobot Skala) - Dari mana?**
```
100/100 = 1 (Faktor konversi skala)
```
- Ini adalah bobot untuk konversi skala
- Dalam sistem ini nilainya 1 (100/100 = 1)
- Pada beberapa sistem, bisa menggunakan bobot berbeda (misal: 80/100 jika ingin standar lebih ketat)
- Di sistem ini: **100/100 = 1**, jadi tidak mengubah nilai

**3. Angka "100" (Pengali) - Dari mana?**
```
× 100 = Konversi ke bentuk persentase (%)
```
- Mengubah angka desimal menjadi persentase
- **Contoh**: 0.84 × 100 = 84%

**Rangkaian Perhitungan Lengkap:**
```
Jika Total WS = 4.2
Maka: IKP = (4.2 / 5) × (100/100) × 100
          = 0.84 × 1 × 100
          = 84%

Interpretasi: Pelanggan SANGAT PUAS (81-100%)
```

**Interpretasi IKP:**
- 0% - 34%: Tidak puas
- 35% - 50%: Kurang puas
- 51% - 65%: Cukup puas
- 66% - 80%: Puas
- 81% - 100%: Sangat puas

---

## Perhitungan Indeks Loyalitas Pelanggan (ILP)

### Lokasi: `GrafikController.php` - Method `grafik2()` dan `grafik6()`

### 1. Perhitungan Rata-rata Per Item Loyalitas

**Formula:**
```
Rata-rata Item = Total Nilai / Jumlah Responden
```

**Implementasi:**
```php
// Contoh untuk L1
$l1_rata_sum = DB::table('tbl_jawaban_lp')->sum('l1');
$l1_rata_count = DB::table('tbl_jawaban_lp')->count('l1');
$l1_rata_rata = $l1_rata_sum / $l1_rata_count;
```

**Kegunaan:**
- Menghitung rata-rata jawaban untuk setiap pertanyaan loyalitas
- Ada 3 item loyalitas (L1, L2, L3)

---

### 2. Perhitungan Customer Loyalty Index (CLI) Per Item

**Formula:**
```
CLI Item = (Rata-rata Item / Skala Maksimum) × (Bobot) × 100%
CLI Item = (Rata-rata Item / 5) × (100/100) × 100
```

**Implementasi:**
```php
// Untuk L1
$cli_l1 = $l1_rata_rata / 5 * (100/100) * 100;

// Untuk L2
$cli_l2 = $l2_rata_rata / 5 * (100/100) * 100;

// Untuk L3
$cli_l3 = $l3_rata_rata / 5 * (100/100) * 100;
```

**Penjelasan Detail Angka dalam Formula CLI:**

**Angka-angka dalam formula CLI sama dengan IKP:**
- **5** = Nilai maksimum skala Likert (1-5)
- **100/100** = Faktor konversi skala = 1
- **× 100** = Konversi ke persentase

**Contoh Perhitungan:**
```
Jika rata-rata jawaban L1 = 4.1
Maka: CLI L1 = (4.1 / 5) × (100/100) × 100
             = 0.82 × 1 × 100
             = 82%

Interpretasi: 82% pelanggan SANGAT LOYAL akan repeat purchase
```

**Kegunaan:**
- Mengkonversi rata-rata item menjadi persentase
- Mengukur tingkat loyalitas untuk setiap aspek (repeat purchase, retention, recommendation)

---

### 3. Perhitungan Total Indeks Loyalitas Pelanggan (ILP)

**Formula:**
```
Total ILP = (Σ CLI Item) / Jumlah Item
```

**Implementasi:**
```php
$total_l = $cli_l1 + $cli_l2 + $cli_l3;
$total_l_rata = $total_l / 3;
```

**Penjelasan Detail Angka dalam Formula ILP:**

**Angka "3" (Pembagi) - Dari mana?**
```
Angka 3 = Jumlah aspek loyalitas yang diukur
```
- L1 = Repeat Purchase (Niat membeli lagi)
- L2 = Retention (Tidak berpindah ke kompetitor)
- L3 = Recommendation (Word-of-mouth)
- **Total = 3 aspek** ← Ini yang membagi

**Contoh Perhitungan:**
```
Jika:
- CLI L1 = 82%
- CLI L2 = 78%
- CLI L3 = 85%

Maka:
Total L = 82 + 78 + 85 = 245
ILP = 245 / 3 = 81.67%

Interpretasi: Pelanggan SANGAT LOYAL (81-100%)
```

**Kegunaan:**
- Menghitung rata-rata loyalitas dari ketiga aspek
- Menghasilkan nilai ILP dalam rentang 0-100%
- Nilai lebih tinggi menunjukkan loyalitas yang lebih baik

---

## Perhitungan Gap Analysis

### Lokasi: `GrafikController.php` - Method `grafik1()`, `grafik2()`, dan `grafik4()`

### 1. Perhitungan Gap Per Item

**Formula:**
```
Gap = Rata-rata Persepsi - Rata-rata Kepentingan
```

**Implementasi:**
```php
// Contoh untuk item R1
$gap_r1 = $r1_ratapersepsi_rata - $r1_ratakepentingan_rata;
```

**Kegunaan:**
- Mengukur kesenjangan antara harapan dan kenyataan
- Gap negatif: kinerja di bawah harapan (perlu perbaikan)
- Gap positif: kinerja melebihi harapan
- Gap mendekati 0: kinerja sesuai harapan

---

### 2. Perhitungan Rata-rata Gap Per Dimensi

**Formula:**
```
Rata-rata Gap Dimensi = Σ(Gap Item) / Jumlah Item
```

**Implementasi:**
```php
// Untuk dimensi Reliability (7 item)
$rata_gap_r = ($gap_r1 + $gap_r2 + $gap_r3 + $gap_r4 + 
               $gap_r5 + $gap_r6 + $gap_r7) / 7;
```

**Kegunaan:**
- Mengidentifikasi dimensi mana yang memiliki gap terbesar
- Membantu prioritas perbaikan layanan
- Visualisasi gap antar dimensi

---

### 3. Perhitungan Gap untuk Kepuasan (K2 dan K3)

**Formula:**
```
Gap Kepuasan = K3 - K2

Dimana:
- K2: Kinerja sesuai dengan harapan
- K3: Layanan sesuai dengan yang ideal
```

**Implementasi:**
```php
// Rata-rata K2
$k2_count = DB::table('tbl_jawaban_kp')->count('k2');
$k2_sum = DB::table('tbl_jawaban_kp')->sum('k2');
$total_rata_k2 = $k2_sum / $k2_count;

// Rata-rata K3
$k3_count = DB::table('tbl_jawaban_kp')->count('k3');
$k3_sum = DB::table('tbl_jawaban_kp')->sum('k3');
$total_rata_k3 = $k3_sum / $k3_count;

// Gap
$gap = $total_rata_k3 - $total_rata_k2;
```

**Kegunaan:**
- Mengukur kesenjangan antara layanan ideal dan kenyataan
- Membantu memahami seberapa jauh layanan dari kondisi ideal

---

## Perhitungan Standar Deviasi

### Lokasi: `GrafikController.php` - Method `grafik2()`

### Formula Standar Deviasi

**Formula:**
```
Deviasi = √[Σ(Gap Item - Rata-rata Gap)² / (n-1)]

Dimana:
- n = jumlah item dalam dimensi
- Gap Item = gap untuk setiap item
- Rata-rata Gap = rata-rata gap untuk dimensi tersebut
```

**Penjelasan Detail Angka "n-1" - Dari mana?**

**Angka "n" - Dari mana?**
```
n = Jumlah item dalam dimensi yang sedang dihitung
```
- Reliability: n = 7 (R1 sampai R7)
- Assurance: n = 4 (A1 sampai A4)
- Tangible: n = 6 (T1 sampai T6)
- Empathy: n = 5 (E1 sampai E5)
- Responsiveness: n = 2 (RS1 dan RS2)
- Applicability: n = 2 (AP1 dan AP2)

**Mengapa "n-1" bukan "n"?**
```
n-1 = Derajat kebebasan (degrees of freedom) dalam statistik
```
- Rumus **n-1** digunakan untuk **standar deviasi sampel** (sample standard deviation)
- Rumus **n** digunakan untuk **standar deviasi populasi** (population standard deviation)
- Karena data survei adalah **sampel** dari populasi pelanggan yang lebih besar, maka menggunakan **n-1**
- **n-1** memberikan estimasi yang tidak bias (unbiased) untuk standar deviasi populasi

**Contoh Perhitungan untuk Reliability (7 item):**
```
n = 7 item (R1, R2, R3, R4, R5, R6, R7)
Pembagi = n - 1 = 7 - 1 = 6

Jika:
- Gap R1 = -0.5
- Gap R2 = -0.3
- Gap R3 = -0.4
- Gap R4 = -0.6
- Gap R5 = -0.2
- Gap R6 = -0.5
- Gap R7 = -0.4

Rata-rata Gap = (-0.5 + -0.3 + -0.4 + -0.6 + -0.2 + -0.5 + -0.4) / 7 = -0.414

Deviasi = √[((-0.5-(-0.414))² + (-0.3-(-0.414))² + ... + (-0.4-(-0.414))²) / 6]
        = √[Jumlah kuadrat deviasi / 6]
        = √[0.1266 / 6]
        = √0.0211
        = 0.145

Interpretasi: Gap antar item cukup konsisten (deviasi rendah)
```

**Contoh untuk dimensi lain:**
- **Assurance (4 item)**: Pembagi = 4-1 = **3**
- **Tangible (6 item)**: Pembagi = 6-1 = **5**
- **Empathy (5 item)**: Pembagi = 5-1 = **4**
- **Responsiveness (2 item)**: Pembagi = 2-1 = **1**
- **Applicability (2 item)**: Pembagi = 2-1 = **1**

**Implementasi:**
```php
// Untuk dimensi Reliability (7 item)
$rata_gap_r = ($gap_r1 + $gap_r2 + $gap_r3 + $gap_r4 + 
               $gap_r5 + $gap_r6 + $gap_r7) / 7;

$deviasi_r = sqrt(
    (pow($gap_r1 - $rata_gap_r, 2) + 
     pow($gap_r2 - $rata_gap_r, 2) + 
     pow($gap_r3 - $rata_gap_r, 2) + 
     pow($gap_r4 - $rata_gap_r, 2) + 
     pow($gap_r5 - $rata_gap_r, 2) + 
     pow($gap_r6 - $rata_gap_r, 2) + 
     pow($gap_r7 - $rata_gap_r, 2)) / 6
);

// Untuk dimensi Assurance (4 item)
$rata_gap_a = ($gap_a1 + $gap_a2 + $gap_a3 + $gap_a4) / 4;

$deviasi_a = sqrt(
    (pow($gap_a1 - $rata_gap_a, 2) + 
     pow($gap_a2 - $rata_gap_a, 2) + 
     pow($gap_a3 - $rata_gap_a, 2) + 
     pow($gap_a4 - $rata_gap_a, 2)) / 3
);

// Untuk dimensi Tangible (6 item)
$rata_gap_t = ($gap_t1 + $gap_t2 + $gap_t3 + $gap_t4 + 
               $gap_t5 + $gap_t6) / 6;

$deviasi_t = sqrt(
    (pow($gap_t1 - $rata_gap_t, 2) + 
     pow($gap_t2 - $rata_gap_t, 2) + 
     pow($gap_t3 - $rata_gap_t, 2) + 
     pow($gap_t4 - $rata_gap_t, 2) + 
     pow($gap_t5 - $rata_gap_t, 2) + 
     pow($gap_t6 - $rata_gap_t, 2)) / 5
);

// Untuk dimensi Empathy (5 item)
$rata_gap_e = ($gap_e1 + $gap_e2 + $gap_e3 + $gap_e4 + $gap_e5) / 5;

$deviasi_e = sqrt(
    (pow($gap_e1 - $rata_gap_e, 2) + 
     pow($gap_e2 - $rata_gap_e, 2) + 
     pow($gap_e3 - $rata_gap_e, 2) + 
     pow($gap_e4 - $rata_gap_e, 2) + 
     pow($gap_e5 - $rata_gap_e, 2)) / 4
);

// Untuk dimensi Responsiveness (2 item)
$rata_gap_rs = ($gap_rs1 + $gap_rs2) / 2;

$deviasi_rs = sqrt(
    (pow($gap_rs1 - $rata_gap_rs, 2) + 
     pow($gap_rs2 - $rata_gap_rs, 2)) / 1
);

// Untuk dimensi Applicability (2 item)
$rata_gap_rl = ($gap_rl1 + $gap_rl2) / 2;

$deviasi_rl = sqrt(
    (pow($gap_rl1 - $rata_gap_rl, 2) + 
     pow($gap_rl2 - $rata_gap_rl, 2)) / 1
);
```

**Kegunaan:**
- Mengukur konsistensi gap dalam setiap dimensi
- Deviasi rendah: gap antar item dalam dimensi relatif konsisten
- Deviasi tinggi: gap antar item dalam dimensi sangat bervariasi
- Membantu identifikasi dimensi yang perlu perhatian lebih

---

## Perhitungan Statistik Demografis

### Lokasi: `GrafikController.php` - Method `grafik5()`

### 1. Perhitungan Total Responden

**Formula:**
```
Total Responden = COUNT(id_responden)
```

**Implementasi:**
```php
$totalresponden = Responden::count('id_responden');
```

**Kegunaan:**
- Menghitung jumlah total responden yang mengisi survei
- Digunakan sebagai pembagi untuk perhitungan persentase

---

### 2. Perhitungan Frekuensi dan Persentase Jenis Kelamin

**Formula:**
```
Persentase = (Frekuensi / Total Responden) × 100%
```

**Implementasi:**
```php
// Hitung frekuensi laki-laki
$total_lk = Responden::where('jk','=','laki-laki')
    ->count('id_responden');

// Hitung frekuensi perempuan
$total_pr = Responden::where('jk','=','perempuan')
    ->count('id_responden');

// Hitung persentase laki-laki
if($total_lk !== 0){
    $persentase_lk = $total_lk / $totalresponden * 100;
}else{
    $persentase_lk = 0;
}

// Hitung persentase perempuan
if($total_pr !== 0){
    $persentase_pr = $total_pr / $totalresponden * 100;
}else{
    $persentase_pr = 0;
}
```

**Kegunaan:**
- Menampilkan distribusi gender responden
- Memahami komposisi demografis pelanggan

---

### 3. Perhitungan Frekuensi dan Persentase Usia

**Formula:**
```
Persentase Usia = (Jumlah Responden Usia / Total Responden) × 100%
```

**Implementasi:**
```php
// Frekuensi per kelompok usia
$total_usia25 = Responden::where('usia','=','<25')
    ->count('id_responden');
$total_usia25_34 = Responden::where('usia','=','25-34')
    ->count('id_responden');
$total_usia35_44 = Responden::where('usia','=','35-44')
    ->count('id_responden');
$total_usia45_54 = Responden::where('usia','=','45-54')
    ->count('id_responden');
$total_usia55_64 = Responden::where('usia','=','55-64')
    ->count('id_responden');
$total_usia64 = Responden::where('usia','=','>64')
    ->count('id_responden');

// Persentase (dengan pengecekan untuk menghindari pembagian dengan 0)
if($total_usia25 !== 0){
    $persentase_usia25 = ($total_usia25 / $totalresponden) * 100;
}else{
    $persentase_usia25 = 0;
}

// ... dan seterusnya untuk kelompok usia lainnya
```

**Kegunaan:**
- Menampilkan distribusi usia responden
- Membantu segmentasi pelanggan berdasarkan usia

---

### 4. Perhitungan Frekuensi dan Persentase Pekerjaan

**Formula:**
```
Persentase Pekerjaan = (Jumlah Responden Pekerjaan / Total Responden) × 100%
```

**Implementasi:**
```php
// Frekuensi per jenis pekerjaan
$total_swasta = Responden::where('pekerjaan','=','karyawan_swasta')
    ->count('id_responden');
$total_wiraswasta = Responden::where('pekerjaan','=','wiraswasta')
    ->count('id_responden');
$total_pns = Responden::where('pekerjaan','=','PNS')
    ->count('id_responden');
$total_pelajar = Responden::where('pekerjaan','=','pelajar')
    ->count('id_responden');
$total_lain = Responden::where('pekerjaan','=','lain')
    ->count('id_responden');

// Persentase dengan pengecekan
if($total_swasta !== 0){
    $persentase_swasta = ($total_swasta / $totalresponden) * 100;
}else{
    $persentase_swasta = 0;
}

// ... dan seterusnya untuk jenis pekerjaan lainnya
```

**Kegunaan:**
- Menampilkan distribusi pekerjaan responden
- Memahami profil profesional pelanggan

---

### 5. Perhitungan Frekuensi dan Persentase Domisili

**Formula:**
```
Persentase Domisili = (Jumlah Responden Domisili / Total Responden) × 100%
```

**Implementasi:**
```php
// Frekuensi per wilayah domisili
$total_jawa = Responden::where('domisili','=','1')
    ->count('id_responden');
$total_sulawesi = Responden::where('domisili','=','2')
    ->count('id_responden');
$total_sumatera = Responden::where('domisili','=','3')
    ->count('id_responden');
$total_kalimantan = Responden::where('domisili','=','4')
    ->count('id_responden');
$total_papua = Responden::where('domisili','=','5')
    ->count('id_responden');
$total_bali = Responden::where('domisili','=','6')
    ->count('id_responden');
$total_ntb = Responden::where('domisili','=','7')
    ->count('id_responden');
$total_maluku = Responden::where('domisili','=','8')
    ->count('id_responden');

// Persentase dengan pengecekan
if($total_jawa !== 0){
    $persentase_jawa = ($total_jawa / $totalresponden) * 100;
}else{
    $persentase_jawa = 0;
}

// ... dan seterusnya untuk wilayah lainnya
```

**Kegunaan:**
- Menampilkan distribusi geografis responden
- Memahami jangkauan layanan pelatihan

---

### 6. Perhitungan Persentase Silang (Usia × Jenis Kelamin)

**Formula:**
```
Persentase = (Jumlah Responden dengan Kriteria Spesifik / Total Responden Kelompok) × 100%
```

**Implementasi:**
```php
// Contoh: Laki-laki usia <25 tahun
$total_usia25_lk = Responden::where('usia','=','<25')
    ->where('jk','=','laki-laki')
    ->count('id_responden');

// Persentase dari total usia <25 tahun
if($total_usia25_lk !== 0){
    $persentase_usia25_lk = ($total_usia25_lk / $total_usia25) * 100;
}else{
    $persentase_usia25_lk = 0;
}

// Contoh: Perempuan usia <25 tahun
$total_usia25_pr = Responden::where('usia','=','<25')
    ->where('jk','=','perempuan')
    ->count('id_responden');

if($total_usia25_pr !== 0){
    $persentase_usia25_pr = ($total_usia25_pr / $total_usia25) * 100;
}else{
    $persentase_usia25_pr = 0;
}

// ... dan seterusnya untuk kombinasi usia dan jenis kelamin lainnya
```

**Kegunaan:**
- Analisis lebih detail tentang komposisi demografis
- Memahami distribusi gender dalam setiap kelompok usia
- Membantu dalam targeting dan segmentasi pelanggan

---

### 7. Perhitungan Frekuensi Skala Jawaban

**Formula:**
```
Frekuensi Skala n = COUNT(nilai_jawaban WHERE nilai = n)
```

**Implementasi:**
```php
// Contoh untuk pertanyaan K1 (Kepuasan)
$k1_rata_count_1 = DB::table('tbl_jawaban_kp')
    ->where('k1','=','1')
    ->count('k1');
$k1_rata_count_2 = DB::table('tbl_jawaban_kp')
    ->where('k1','=','2')
    ->count('k1');
$k1_rata_count_3 = DB::table('tbl_jawaban_kp')
    ->where('k1','=','3')
    ->count('k1');
$k1_rata_count_4 = DB::table('tbl_jawaban_kp')
    ->where('k1','=','4')
    ->count('k1');
$k1_rata_count_5 = DB::table('tbl_jawaban_kp')
    ->where('k1','=','5')
    ->count('k1');

// Sama untuk item loyalitas L1, L2, L3
$l1_rata_count_1 = DB::table('tbl_jawaban_lp')
    ->where('l1','=','1')
    ->count('l1');
// ... dan seterusnya
```

**Kegunaan:**
- Menampilkan distribusi jawaban untuk setiap skala Likert (1-5)
- Memvisualisasikan pola jawaban responden
- Memahami sebaran kepuasan dan loyalitas pelanggan

---

## Perhitungan di View (Grafik)

### Lokasi: `index2.blade.php`

### 1. Format Angka untuk Visualisasi

**Implementasi:**
```php
// Format untuk tampilan chart (2 desimal)
{{ number_format($totalikp, 2) }}

// Format untuk tampilan gauge (bulat)
{{ number_format($totalikp, 0) }}

// Format untuk gap analysis (3 desimal)
{{ number_format($rata_gap_r, 3) }}
{{ number_format($rata_gap_e, 3) }}
{{ number_format($rata_gap_a, 3) }}
{{ number_format($rata_gap_rs, 3) }}
{{ number_format($rata_gap_t, 3) }}
{{ number_format($rata_gap_rl, 3) }}

// Format untuk standar deviasi (2 desimal)
{{ number_format($deviasi_r, 2) }}
{{ number_format($deviasi_e, 2) }}
{{ number_format($deviasi_a, 2) }}
{{ number_format($deviasi_rs, 2) }}
{{ number_format($deviasi_t, 2) }}
{{ number_format($deviasi_rl, 2) }}
```

**Kegunaan:**
- Memformat angka untuk tampilan yang lebih rapi
- Konsistensi dalam jumlah desimal yang ditampilkan
- Memudahkan pembacaan data oleh pengguna

---

## Perhitungan Probabilitas Loyalitas Pelanggan

### Lokasi: `index1.blade.php` dan `index6.blade.php`

Perhitungan ini digunakan untuk memprediksi jumlah pelanggan yang berpotensi loyal berdasarkan jawaban survei kepuasan dan loyalitas.

### 1. Definisi Nilai Probabilitas

**Formula:**
```
Probabilitas berdasarkan skala Likert:
- Skala 1 (Sangat tidak setuju) = 0.00
- Skala 2 (Tidak setuju)        = 0.25
- Skala 3 (Netral)               = 0.50
- Skala 4 (Setuju)               = 0.75
- Skala 5 (Sangat setuju)        = 1.00
```

**Implementasi:**
```php
$probabilitas_1 = 0.00;
$probabilitas_2 = 0.25;
$probabilitas_3 = 0.50;
$probabilitas_4 = 0.75;
$probabilitas_5 = 1.00;
```

**Penjelasan Detail Angka Probabilitas - Dari mana?**

**Mengapa menggunakan 0.00, 0.25, 0.50, 0.75, 1.00?**

1. **Rentang Probabilitas 0.00 - 1.00:**
   ```
   0.00 = 0% kemungkinan (pasti tidak terjadi)
   1.00 = 100% kemungkinan (pasti terjadi)
   ```
   - Ini adalah standar statistik untuk menyatakan probabilitas
   - Lebih mudah untuk perhitungan matematis dibanding persentase

2. **Pembagian Sama Rata (0.25):**
   ```
   Interval = (1.00 - 0.00) / (5 - 1) = 1.00 / 4 = 0.25
   
   Skala Likert 5 poin dibagi menjadi 4 interval:
   - Skala 1 → 0.00 (baseline/nilai minimum)
   - Skala 2 → 0.00 + 0.25 = 0.25 (naik 1 tingkat)
   - Skala 3 → 0.25 + 0.25 = 0.50 (naik 2 tingkat)
   - Skala 4 → 0.50 + 0.25 = 0.75 (naik 3 tingkat)
   - Skala 5 → 0.75 + 0.25 = 1.00 (naik 4 tingkat/maksimum)
   ```

3. **Interpretasi Bisnis:**
   ```
   0.00 (Skala 1) = Pelanggan sangat tidak puas → 0% kemungkinan loyal
   0.25 (Skala 2) = Pelanggan tidak puas → 25% kemungkinan loyal
   0.50 (Skala 3) = Pelanggan netral → 50% kemungkinan loyal
   0.75 (Skala 4) = Pelanggan puas → 75% kemungkinan loyal
   1.00 (Skala 5) = Pelanggan sangat puas → 100% kemungkinan loyal
   ```

**Contoh Perhitungan:**
```
Jika 100 responden menjawab:
- 5 orang pilih Skala 1 (sangat tidak setuju)
- 10 orang pilih Skala 2 (tidak setuju)
- 20 orang pilih Skala 3 (netral)
- 35 orang pilih Skala 4 (setuju)
- 30 orang pilih Skala 5 (sangat setuju)

Probabilitas Total = (5×0.00 + 10×0.25 + 20×0.50 + 35×0.75 + 30×1.00) / 100
                   = (0 + 2.5 + 10 + 26.25 + 30) / 100
                   = 68.75 / 100
                   = 0.6875

Interpretasi: 68.75% kemungkinan pelanggan akan loyal
```

**Kegunaan:**
- Memberikan bobot probabilitas untuk setiap tingkat persetujuan
- Nilai 0.00 berarti tidak ada kemungkinan loyal
- Nilai 1.00 berarti pasti loyal
- Nilai di antaranya menunjukkan tingkat kemungkinan
- Memudahkan prediksi jumlah pelanggan loyal dari total responden

---

### 2. Perhitungan Persentase Per Skala Jawaban (Kepuasan K1)

**Lokasi:** `index1.blade.php` - Pertanyaan K1: "Secara keseluruhan, saya merasa puas"

**Formula:**
```
Persentase Skala n = (Jumlah Jawaban Skala n / Total Responden) × 100%
```

**Implementasi:**
```php
// Hitung persentase untuk setiap skala
$persentase_1 = ($k1_rata_count_1 / $k1_count) * 100;
$persentase_2 = ($k1_rata_count_2 / $k1_count) * 100;
$persentase_3 = ($k1_rata_count_3 / $k1_count) * 100;
$persentase_4 = ($k1_rata_count_4 / $k1_count) * 100;
$persentase_5 = ($k1_rata_count_5 / $k1_count) * 100;
```

**Kegunaan:**
- Mengetahui distribusi persentase jawaban responden
- Memahami proporsi kepuasan pelanggan

---

### 3. Perhitungan Persentase × Probabilitas

**Formula:**
```
Persentase Probabilitas = Persentase Skala × Probabilitas Skala
```

**Implementasi:**
```php
$persentase_propabilitas_1 = $persentase_1 * $probabilitas_1;
$persentase_propabilitas_2 = $persentase_2 * $probabilitas_2;
$persentase_propabilitas_3 = $persentase_3 * $probabilitas_3;
$persentase_propabilitas_4 = $persentase_4 * $probabilitas_4;
$persentase_propabilitas_5 = $persentase_5 * $probabilitas_5;
```

**Kegunaan:**
- Menimbang persentase dengan probabilitas loyalitas
- Menghasilkan nilai tertimbang untuk setiap skala

---

### 4. Perhitungan Frekuensi × Probabilitas

**Formula:**
```
Frekuensi Probabilitas = Jumlah Responden Skala × Probabilitas Skala
```

**Implementasi:**
```php
$frekuensi_probabilitas_1 = $k1_rata_count_1 * $probabilitas_1;
$frekuensi_probabilitas_2 = $k1_rata_count_2 * $probabilitas_2;
$frekuensi_probabilitas_3 = $k1_rata_count_3 * $probabilitas_3;
$frekuensi_probabilitas_4 = $k1_rata_count_4 * $probabilitas_4;
$frekuensi_probabilitas_5 = $k1_rata_count_5 * $probabilitas_5;
```

**Kegunaan:**
- Menghitung jumlah responden tertimbang dengan probabilitas
- Mengkonversi frekuensi menjadi nilai prediksi loyalitas

---

### 5. Perhitungan Total Pelanggan Berpotensi Loyal (Kepuasan)

**Formula:**
```
Total = Σ(Frekuensi Probabilitas)
```

**Implementasi:**
```php
$total = $frekuensi_probabilitas_1 + 
         $frekuensi_probabilitas_2 + 
         $frekuensi_probabilitas_3 + 
         $frekuensi_probabilitas_4 + 
         $frekuensi_probabilitas_5;
```

**Kegunaan:**
- Memprediksi jumlah pelanggan yang berpotensi menjadi loyal
- Memberikan estimasi numerik dari tingkat kepuasan
- Output: "Dari X orang, maka jumlah pelanggan yang berpotensi untuk menjadi loyal adalah sebanyak Y orang"

---

### 6. Perhitungan Probabilitas Loyalitas L1 (Repeat Purchase)

**Lokasi:** `index6.blade.php` - Pertanyaan L1: "Saya akan mengulangi menggunakan jasa pelatihan"

**A. Persentase Per Skala:**
```php
$persentasel1_1 = ($l1_rata_count_1 / $l1_rata_count) * 100;
$persentasel1_2 = ($l1_rata_count_2 / $l1_rata_count) * 100;
$persentasel1_3 = ($l1_rata_count_3 / $l1_rata_count) * 100;
$persentasel1_4 = ($l1_rata_count_4 / $l1_rata_count) * 100;
$persentasel1_5 = ($l1_rata_count_5 / $l1_rata_count) * 100;
```

**B. Persentase × Probabilitas:**
```php
$persentase_probabilitas_l1_1 = $persentasel1_1 * $probabilitas_1;
$persentase_probabilitas_l1_2 = $persentasel1_2 * $probabilitas_2;
$persentase_probabilitas_l1_3 = $persentasel1_3 * $probabilitas_3;
$persentase_probabilitas_l1_4 = $persentasel1_4 * $probabilitas_4;
$persentase_probabilitas_l1_5 = $persentasel1_5 * $probabilitas_5;
```

**C. Jumlah × Probabilitas:**
```php
$jumlah_probabilitas_l1_1 = $l1_rata_count_1 * $probabilitas_1;
$jumlah_probabilitas_l1_2 = $l1_rata_count_2 * $probabilitas_2;
$jumlah_probabilitas_l1_3 = $l1_rata_count_3 * $probabilitas_3;
$jumlah_probabilitas_l1_4 = $l1_rata_count_4 * $probabilitas_4;
$jumlah_probabilitas_l1_5 = $l1_rata_count_5 * $probabilitas_5;
```

**D. Total Prediksi:**
```php
$total_jml_pro_l1 = $jumlah_probabilitas_l1_1 + 
                    $jumlah_probabilitas_l1_2 + 
                    $jumlah_probabilitas_l1_3 + 
                    $jumlah_probabilitas_l1_4 + 
                    $jumlah_probabilitas_l1_5;
```

**Kegunaan:**
- Memprediksi jumlah pelanggan yang akan menggunakan layanan lagi
- Output: "Dari X orang, maka jumlah pelanggan yang diprediksikan akan mengonsumsi pelatihan ini lagi adalah sebanyak Y orang"

---

### 7. Perhitungan Probabilitas Loyalitas L2 (Retention)

**Lokasi:** `index6.blade.php` - Pertanyaan L2: "Saya akan tetap memilih jasa pelatihan ini meskipun tersedia alternatif lain"

**A. Persentase Per Skala:**
```php
$persentasel2_1 = ($l2_rata_count_1 / $l2_rata_count) * 100;
$persentasel2_2 = ($l2_rata_count_2 / $l2_rata_count) * 100;
$persentasel2_3 = ($l2_rata_count_3 / $l2_rata_count) * 100;
$persentasel2_4 = ($l2_rata_count_4 / $l2_rata_count) * 100;
$persentasel2_5 = ($l2_rata_count_5 / $l2_rata_count) * 100;
```

**B. Persentase × Probabilitas:**
```php
$persentase_probabilitas_l2_1 = $persentasel2_1 * $probabilitas_1;
$persentase_probabilitas_l2_2 = $persentasel2_2 * $probabilitas_2;
$persentase_probabilitas_l2_3 = $persentasel2_3 * $probabilitas_3;
$persentase_probabilitas_l2_4 = $persentasel2_4 * $probabilitas_4;
$persentase_probabilitas_l2_5 = $persentasel2_5 * $probabilitas_5;
```

**C. Jumlah × Probabilitas:**
```php
$jumlah_probabilitas_l2_1 = $l2_rata_count_1 * $probabilitas_1;
$jumlah_probabilitas_l2_2 = $l2_rata_count_2 * $probabilitas_2;
$jumlah_probabilitas_l2_3 = $l2_rata_count_3 * $probabilitas_3;
$jumlah_probabilitas_l2_4 = $l2_rata_count_4 * $probabilitas_4;
$jumlah_probabilitas_l2_5 = $l2_rata_count_5 * $probabilitas_5;
```

**D. Total Prediksi:**
```php
$total_jml_pro_l2 = $jumlah_probabilitas_l2_1 + 
                    $jumlah_probabilitas_l2_2 + 
                    $jumlah_probabilitas_l2_3 + 
                    $jumlah_probabilitas_l2_4 + 
                    $jumlah_probabilitas_l2_5;
```

**Kegunaan:**
- Memprediksi jumlah pelanggan yang tidak akan berpindah ke kompetitor
- Output: "Dari X orang, maka jumlah pelanggan yang diprediksikan tidak akan berpindah ke pesaing adalah sebanyak Y orang"

---

### 8. Perhitungan Probabilitas Loyalitas L3 (Recommendation)

**Lokasi:** `index6.blade.php` - Pertanyaan L3: "Saya akan merekomendasikan pelatihan ini kepada orang lain"

**A. Persentase Per Skala:**
```php
$persentasel3_1 = ($l3_rata_count_1 / $l3_rata_count) * 100;
$persentasel3_2 = ($l3_rata_count_2 / $l3_rata_count) * 100;
$persentasel3_3 = ($l3_rata_count_3 / $l3_rata_count) * 100;
$persentasel3_4 = ($l3_rata_count_4 / $l3_rata_count) * 100;
$persentasel3_5 = ($l3_rata_count_5 / $l3_rata_count) * 100;
```

**B. Persentase × Probabilitas:**
```php
$persentase_probabilitas_l3_1 = $persentasel3_1 * $probabilitas_1;
$persentase_probabilitas_l3_2 = $persentasel3_2 * $probabilitas_2;
$persentase_probabilitas_l3_3 = $persentasel3_3 * $probabilitas_3;
$persentase_probabilitas_l3_4 = $persentasel3_4 * $probabilitas_4;
$persentase_probabilitas_l3_5 = $persentasel3_5 * $probabilitas_5;
```

**C. Jumlah × Probabilitas:**
```php
$jumlah_probabilitas_l3_1 = $l3_rata_count_1 * $probabilitas_1;
$jumlah_probabilitas_l3_2 = $l3_rata_count_2 * $probabilitas_2;
$jumlah_probabilitas_l3_3 = $l3_rata_count_3 * $probabilitas_3;
$jumlah_probabilitas_l3_4 = $l3_rata_count_4 * $probabilitas_4;
$jumlah_probabilitas_l3_5 = $l3_rata_count_5 * $probabilitas_5;
```

**D. Total Prediksi:**
```php
$total_jml_pro_l3 = $jumlah_probabilitas_l3_1 + 
                    $jumlah_probabilitas_l3_2 + 
                    $jumlah_probabilitas_l3_3 + 
                    $jumlah_probabilitas_l3_4 + 
                    $jumlah_probabilitas_l3_5;
```

**Kegunaan:**
- Memprediksi jumlah pelanggan yang akan merekomendasikan layanan
- Output: "Dari X orang, maka jumlah pelanggan yang diprediksikan akan merekomendasikan pelatihan ini kepada orang lain adalah sebanyak Y orang"

---

### 9. Interpretasi Prediksi Loyalitas

**Interpretasi Indeks Loyalitas Pelanggan (ILP):**
- 0% - 25%: Tidak loyal
- 25.01% - 50%: Kurang loyal
- 50.01% - 70%: Cukup loyal
- 70.01% - 90%: Loyal
- 90.01% - 100%: Sangat loyal

**Tiga Aspek Loyalitas yang Diukur:**

1. **Repeat Purchase (L1)**: 
   - Mengukur niat untuk menggunakan layanan kembali
   - Indikator: kesediaan untuk kembali menggunakan jasa pelatihan

2. **Retention (L2)**: 
   - Mengukur resistensi terhadap perpindahan ke kompetitor
   - Indikator: tetap memilih meskipun ada alternatif lain

3. **Recommendation (L3)**: 
   - Mengukur kemauan untuk merekomendasikan kepada orang lain
   - Indikator: word-of-mouth positif dan referral

---

## Perhitungan di View Lainnya

### Lokasi: `index3.blade.php` - Visualisasi Per Indikator

File ini menampilkan perbandingan persepsi, harapan, dan gap untuk setiap item pertanyaan dalam bentuk:
- Chart kolom untuk setiap dimensi
- Tabel dengan nilai rata-rata persepsi, harapan, dan gap per item
- Tidak ada perhitungan baru, hanya visualisasi data yang sudah dihitung di controller

**Dimensi yang Ditampilkan:**
- Reliability (R1-R7)
- Assurance (A1-A4)
- Tangible (T1-T6)
- Empathy (E1-E5)
- Responsiveness (RS1-RS2)
- Applicability (AP1-AP2)

---

### Lokasi: `index4.blade.php` - Visualisasi Per Dimensi

File ini menampilkan rata-rata untuk setiap dimensi secara keseluruhan:
- Chart kolom membandingkan 6 dimensi
- Tabel dengan nilai rata-rata persepsi, harapan, dan gap per dimensi
- Data diambil dari controller (grafik4)

---

### Lokasi: `index5.blade.php` - Visualisasi Profil Responden

File ini menampilkan statistik demografis dalam bentuk chart:
- **Chart 1**: Jenis kelamin berdasarkan usia (column chart)
- **Chart 2**: Distribusi usia responden (pie chart)
- **Chart 3**: Distribusi pekerjaan responden (pie chart)
- **Chart 4**: Distribusi domisili responden (pie chart)

Tidak ada perhitungan baru, hanya visualisasi data demografis yang sudah dihitung di controller (grafik5).

---

## Ringkasan Formula Utama

### 1. Indeks Kepuasan Pelanggan (IKP)
```
IKP = (Σ(WS) / 5) × 100%

Dimana:
- WS = Rata-rata Persepsi × WF
- WF = Rata-rata Kepentingan / Total Harapan
- Total Harapan = Σ(Total Kepentingan per Dimensi)
```

### 2. Indeks Loyalitas Pelanggan (ILP)
```
ILP = [(Σ CLI) / 3]

Dimana:
- CLI = (Rata-rata Item / 5) × 100%
```

### 3. Gap Analysis
```
Gap = Rata-rata Persepsi - Rata-rata Kepentingan
```

### 4. Standar Deviasi Gap
```
Deviasi = √[Σ(Gap Item - Rata-rata Gap)² / (n-1)]
```

### 5. Persentase Demografis
```
Persentase = (Frekuensi / Total Responden) × 100%
```

### 6. Prediksi Loyalitas Pelanggan (Probabilitas)
```
Total Prediksi = Σ(Frekuensi Skala n × Probabilitas n)

Dimana:
- Probabilitas berdasarkan skala Likert:
  Skala 1 = 0.00
  Skala 2 = 0.25
  Skala 3 = 0.50
  Skala 4 = 0.75
  Skala 5 = 1.00

Digunakan untuk:
- K1: Prediksi pelanggan berpotensi loyal
- L1: Prediksi repeat purchase
- L2: Prediksi retention (tidak berpindah)
- L3: Prediksi recommendation
```

---

## Catatan Penting

1. **Pengecekan Pembagian Nol:**
   - Semua perhitungan persentase demografis memiliki pengecekan untuk menghindari division by zero
   - Jika nilai pembagi = 0, maka hasil ditetapkan = 0

2. **Skala Likert:**
   - Semua pertanyaan menggunakan skala 1-5
   - 1 = Sangat tidak setuju/penting
   - 5 = Sangat setuju/penting

3. **Metode ServQual:**
   - Mengukur kualitas layanan dengan membandingkan harapan dan persepsi
   - Gap negatif menunjukkan area yang perlu diperbaiki

4. **Weighted Score:**
   - Memberikan bobot sesuai tingkat kepentingan
   - Item yang lebih penting memiliki pengaruh lebih besar terhadap IKP

5. **Perhitungan Probabilitas:**
   - Menggunakan skala probabilitas 0.00 - 1.00
   - Metode ini memprediksi jumlah pelanggan loyal berdasarkan tingkat persetujuan
   - Semakin tinggi skala jawaban, semakin tinggi probabilitas loyalitas
   - Perhitungan dilakukan di view (blade template) untuk keperluan visualisasi

6. **Lokasi Perhitungan:**
   - **Controller** (`GrafikController.php`): Perhitungan utama IKP, ILP, Gap, Deviasi, Demografis
   - **View** (`index1.blade.php`, `index6.blade.php`): Perhitungan probabilitas loyalitas
   - View lainnya hanya untuk visualisasi data yang sudah dihitung di controller

7. **Database Tables:**
   - `tbl_jawaban_realibility`: Jawaban dimensi Reliability
   - `tbl_jawaban_assurance`: Jawaban dimensi Assurance
   - `tbl_jawaban_tangible`: Jawaban dimensi Tangible
   - `tbl_jawaban_empathy`: Jawaban dimensi Empathy
   - `tbl_jawaban_responsiveness`: Jawaban dimensi Responsiveness
   - `tbl_jawaban_applicability`: Jawaban dimensi Applicability
   - `tbl_jawaban_kp`: Jawaban kepuasan pelanggan (K1, K2, K3)
   - `tbl_jawaban_lp`: Jawaban loyalitas pelanggan (L1, L2, L3)
   - `tbl_responden`: Data demografis responden

---

## Visualisasi Data

Sistem ini menghasilkan berbagai visualisasi dalam 6 halaman grafik:

### 1. `index1.blade.php` - Indikator Kepuasan
- **Bar Chart**: Gap antara layanan ideal dan harapan (K2 vs K3)
- **Column Chart**: Distribusi jawaban K1 (kepuasan keseluruhan)
- **Perhitungan Probabilitas**: Prediksi pelanggan berpotensi loyal

### 2. `index2.blade.php` - Indeks Kepuasan Pelanggan (IKP)
- **Gauge Chart**: Menampilkan IKP dalam bentuk persentase dengan indikator warna
- **Bar Chart**: Rata-rata gap per dimensi
- **Column Chart**: Standar deviasi per dimensi
- Tabel interpretasi IKP (Tidak puas - Sangat puas)

### 3. `index3.blade.php` - Visualisasi Per Indikator
- **6 Column Charts**: Satu untuk setiap dimensi ServQual
  - Reliability (7 item)
  - Assurance (4 item)
  - Tangible (6 item)
  - Empathy (5 item)
  - Responsiveness (2 item)
  - Applicability (2 item)
- **Tabel Detail**: Nilai persepsi, harapan, dan gap untuk setiap item

### 4. `index4.blade.php` - Visualisasi Per Dimensi
- **Column Chart**: Perbandingan rata-rata persepsi, harapan, dan gap untuk 6 dimensi
- **Tabel Ringkasan**: Nilai per dimensi secara keseluruhan

### 5. `index5.blade.php` - Profil Responden
- **Column Chart**: Jenis kelamin berdasarkan kelompok usia
- **3 Pie Charts**: 
  - Distribusi usia responden
  - Distribusi pekerjaan responden
  - Distribusi domisili responden

### 6. `index6.blade.php` - Indikator Loyalitas
- **3 Column Charts**: Distribusi jawaban untuk L1, L2, L3
- **Gauge Chart**: Indeks Loyalitas Pelanggan (ILP) dengan indikator warna
- **Perhitungan Probabilitas**: 
  - Prediksi repeat purchase (L1)
  - Prediksi retention (L2)
  - Prediksi recommendation (L3)
- Tabel interpretasi ILP (Tidak loyal - Sangat loyal)

### Library dan Teknologi
- **Highcharts**: Library JavaScript untuk semua chart dan visualisasi
- **Bootstrap**: Framework CSS untuk layout responsif
- **Blade Template**: Laravel templating engine
- **PHP**: Perhitungan backend dan passing data ke view

---

## Contoh Interpretasi Hasil

### Contoh 1: Interpretasi IKP

**Hasil:**
- IKP = 78.50%

**Interpretasi:**
- Berdasarkan tabel interpretasi (66% - 80% = Puas)
- Pelanggan **PUAS** dengan layanan pelatihan
- Kinerja sudah baik, namun masih ada ruang untuk peningkatan menuju "Sangat Puas" (>81%)

### Contoh 2: Interpretasi Gap Analysis

**Hasil:**
- Gap Reliability: -0.45
- Gap Assurance: -0.20
- Gap Tangible: -0.35

**Interpretasi:**
- Gap negatif = kinerja di bawah harapan
- **Reliability** memiliki gap terbesar → prioritas utama perbaikan
- Fokus perbaikan: ketepatan waktu, kemudahan registrasi, keakuratan materi

### Contoh 3: Interpretasi Standar Deviasi

**Hasil:**
- Deviasi Reliability: 0.62
- Deviasi Empathy: 0.28

**Interpretasi:**
- Reliability memiliki deviasi tinggi → gap antar item sangat bervariasi
- Empathy memiliki deviasi rendah → gap antar item relatif konsisten
- Perlu analisis lebih detail untuk item Reliability yang memiliki gap ekstrem

### Contoh 4: Interpretasi Prediksi Loyalitas

**Hasil:**
- Total responden: 100 orang
- Prediksi loyal (K1): 73 orang
- Prediksi repeat purchase (L1): 68 orang
- Prediksi retention (L2): 65 orang
- Prediksi recommendation (L3): 71 orang

**Interpretasi:**
- 73% pelanggan berpotensi menjadi loyal
- 68% akan menggunakan layanan lagi
- 65% tidak akan berpindah ke kompetitor
- 71% akan merekomendasikan kepada orang lain
- **Rekomendasi**: Tingkatkan retention rate dengan program loyalitas

### Contoh 5: Interpretasi ILP

**Hasil:**
- CLI L1 = 85.60%
- CLI L2 = 78.40%
- CLI L3 = 88.20%
- ILP = 84.07%

**Interpretasi:**
- Berdasarkan tabel interpretasi (81% - 100% = Sangat loyal)
- Pelanggan **SANGAT LOYAL**
- Recommendation (L3) paling tinggi → word-of-mouth sangat baik
- Retention (L2) paling rendah → perlu strategi untuk mencegah churn

---

## Rekomendasi Aksi Berdasarkan Hasil

### Jika IKP Rendah (<65%)
1. Identifikasi dimensi dengan gap terbesar
2. Fokus perbaikan pada item dengan gap negatif tertinggi
3. Lakukan survey follow-up untuk memahami akar masalah
4. Buat action plan dengan target perbaikan terukur

### Jika ILP Rendah (<70%)
1. Implementasi program loyalitas
2. Tingkatkan engagement dengan pelanggan existing
3. Berikan insentif untuk repeat purchase
4. Dorong referral dengan reward program

### Jika Gap Besar pada Dimensi Tertentu
1. **Reliability**: Perbaiki sistem, prosedur, dan ketepatan waktu
2. **Assurance**: Training untuk trainer dan staff
3. **Tangible**: Upgrade fasilitas dan teknologi
4. **Empathy**: Tingkatkan komunikasi dan personalisasi layanan
5. **Responsiveness**: Percepat respon time dan update informasi
6. **Applicability**: Sesuaikan kurikulum dengan kebutuhan pasar

### Jika Standar Deviasi Tinggi
1. Investigasi item dengan gap ekstrem (sangat positif atau negatif)
2. Standardisasi kualitas layanan antar item
3. Identifikasi best practices dari item dengan performa baik
4. Terapkan improvement pada item dengan performa buruk

---

## Metode dan Referensi

### Metode ServQual (Service Quality)
- Dikembangkan oleh Parasuraman, Zeithaml, dan Berry (1988)
- Mengukur kualitas layanan melalui 5 dimensi utama + 1 tambahan:
  - Reliability (Keandalan)
  - Assurance (Jaminan)
  - Tangibles (Bukti Fisik)
  - Empathy (Empati)
  - Responsiveness (Daya Tanggap)
  - Applicability (Aplikabilitas) - tambahan untuk konteks pelatihan
- Membandingkan ekspektasi (harapan) vs persepsi (kenyataan)
- Gap = Persepsi - Ekspektasi

### Customer Loyalty Index (CLI)
- Mengukur loyalitas melalui 3 aspek:
  - Repeat Purchase Intention (Niat membeli ulang)
  - Retention (Resistensi terhadap kompetitor)
  - Recommendation/Referral (Word-of-mouth)
- Nilai CLI 70%+ menunjukkan loyalitas yang baik

### Weighted Score Method
- Memberikan bobot berbeda untuk setiap item berdasarkan tingkat kepentingan
- Item yang dianggap lebih penting memiliki pengaruh lebih besar terhadap indeks keseluruhan
- Mencerminkan prioritas pelanggan secara akurat

### Probability-Based Loyalty Prediction
- Menggunakan skala probabilitas 0.00 - 1.00 berdasarkan tingkat persetujuan
- Metode prediktif untuk estimasi jumlah pelanggan loyal
- Membantu perencanaan strategi retention dan marketing

---

## 📖 Panduan Memahami Angka dalam Dokumentasi

Dokumentasi ini telah dilengkapi dengan **penjelasan detail untuk setiap angka** yang muncul dalam formula. Berikut lokasi penjelasan lengkap:

### Penjelasan Angka Konstanta

| Angka | Lokasi Penjelasan | Bagian |
|-------|------------------|---------|
| **5** (pembagi normalisasi) | Bagian 2.7 - IKP Final | "Penjelasan Detail Angka dalam Formula" |
| **100/100** (faktor konversi) | Bagian 2.7 - IKP Final | "Penjelasan Detail Angka dalam Formula" |
| **× 100** (konversi persentase) | Bagian 2.7 - IKP Final | "Penjelasan Detail Angka dalam Formula" |
| **3** (jumlah aspek loyalitas) | Bagian 3.3 - ILP Final | "Penjelasan Detail Angka dalam Formula" |
| **n-1** (degrees of freedom) | Bagian 5 - Standar Deviasi | "Penjelasan Detail Angka n-1" |
| **0.00, 0.25, 0.50, 0.75, 1.00** (probabilitas) | Bagian 9.1 - Definisi Probabilitas | "Penjelasan Detail Angka Probabilitas" |
| **7, 4, 6, 5, 2, 2** (jumlah item per dimensi) | Bagian 5 - Standar Deviasi | "Penjelasan Detail Angka n-1" |

### Struktur Penjelasan

Setiap penjelasan angka mengandung:
1. **Asal-usul angka**: Dari mana angka tersebut berasal
2. **Alasan penggunaan**: Mengapa menggunakan angka tersebut
3. **Contoh perhitungan**: Demonstrasi dengan angka nyata
4. **Interpretasi hasil**: Apa arti hasil perhitungan

### Contoh Penjelasan

**Contoh untuk angka "5":**
- ✅ Dijelaskan: "5 = Nilai maksimum skala Likert"
- ✅ Alasan: "Digunakan untuk normalisasi ke rentang 0-1"
- ✅ Contoh: "Jika Total WS = 4.2, maka 4.2/5 = 0.84 (84% dari maksimum)"
- ✅ Interpretasi: "Membagi dengan 5 mengonversi skor mentah menjadi persentase pencapaian"

**Contoh untuk angka "n-1":**
- ✅ Dijelaskan: "n-1 = Derajat kebebasan (degrees of freedom)"
- ✅ Alasan: "Untuk standar deviasi sampel agar estimasi tidak bias"
- ✅ Contoh: "Reliability (7 item): Pembagi = 7-1 = 6"
- ✅ Interpretasi: "Memberikan estimasi yang lebih akurat untuk populasi"

### Filosofi Dokumentasi

> **"Tidak ada angka yang muncul tanpa penjelasan"**

Setiap angka dalam formula memiliki alasan matematis dan bisnis yang jelas. Dokumentasi ini dirancang agar:
- 📊 **Transparan**: Semua angka dijelaskan dengan detail
- 🎯 **Praktis**: Disertai contoh perhitungan nyata
- 🧠 **Mudah dipahami**: Penjelasan dalam Bahasa Indonesia yang sederhana
- ✅ **Lengkap**: Tidak ada yang terlewat

---

## 💼 Manfaat Bisnis

### Untuk Lembaga Pelatihan
1. **Peningkatan Kualitas Layanan**
   - Identifikasi area yang perlu diperbaiki berdasarkan data objektif
   - Prioritas perbaikan berdasarkan tingkat kepentingan pelanggan

2. **Retensi Pelanggan**
   - Prediksi pelanggan yang berpotensi loyal
   - Strategi retensi yang lebih tertarget

3. **Word-of-Mouth Marketing**
   - Mengukur kemungkinan pelanggan merekomendasikan kepada orang lain
   - Meningkatkan referral melalui peningkatan kepuasan

4. **Competitive Advantage**
   - Benchmark kualitas layanan secara berkala
   - Diferensiasi dari kompetitor melalui service excellence

5. **Data-Driven Decision Making**
   - Keputusan berbasis data, bukan asumsi
   - ROI yang lebih baik dari investasi perbaikan layanan

### Metrik Kesuksesan
- **IKP ≥ 84%** → Pelanggan sangat puas
- **ILP ≥ 70%** → Loyalitas pelanggan baik
- **Gap ≥ 0** → Layanan melebihi ekspektasi
- **Deviasi rendah** → Konsistensi layanan tinggi

---

## 🚀 Cara Penggunaan Sistem

### Untuk Responden (Pelanggan)
1. Akses link survei yang diberikan oleh lembaga pelatihan
2. Pilih jenis bisnis: **Lembaga Pelatihan**
3. Isi data demografis (email, WhatsApp, usia, pekerjaan, domisili)
4. Jawab pertanyaan ServQual (26 item):
   - Bagian I: Penilaian kinerja aktual (Persepsi)
   - Bagian II: Penilaian tingkat kepentingan (Harapan)
5. Jawab pertanyaan kepuasan (3 item)
6. Jawab pertanyaan loyalitas (3 item)
7. Isi kritik dan saran (opsional)
8. Survei selesai!

### Untuk Admin Lembaga Pelatihan
1. Login ke dashboard admin
2. Monitoring jumlah responden yang telah mengisi survei
3. Lihat hasil perhitungan otomatis:
   - Indeks Kepuasan Pelanggan (IKP)
   - Indeks Loyalitas Pelanggan (ILP)
   - Gap Analysis per dimensi
   - Analisis demografis
4. Visualisasi data dalam 6 jenis grafik interaktif
5. Export data untuk analisis lebih lanjut
6. Buat action plan berdasarkan hasil survei

---

## 🔒 Keamanan & Privasi

- Data responden disimpan secara aman dalam database MySQL
- Email dan WhatsApp digunakan sebagai identifier unik
- Data demografis untuk keperluan segmentasi analisis
- Tidak ada data sensitif yang dikumpulkan
- Admin dapat mengakses data agregat dan individual

---

## 📈 Roadmap Pengembangan

### Versi Saat Ini (v1.0)
- ✅ Fokus pada **Lembaga Pelatihan**
- ✅ 6 dimensi ServQual (termasuk Applicability)
- ✅ 32 pertanyaan total
- ✅ 6 halaman visualisasi

### Pengembangan Mendatang (v2.0)
- 🔄 Support untuk **Coffee Shop**
- 🔄 Support untuk **Usaha Fashion**
- 🔄 Support untuk **Usaha Agro Bisnis**
- 🔄 Customizable questionnaire per jenis bisnis
- 🔄 Benchmark antar periode
- 🔄 Alert system untuk IKP/ILP rendah
- 🔄 Mobile app untuk responden
- 🔄 API untuk integrasi dengan sistem lain

---

## 🛠️ Teknologi yang Digunakan

### Backend
- **Framework**: Laravel 7.x (PHP 7.4+)
- **Database**: MySQL 5.7+
- **ORM**: Eloquent
- **Authentication**: Laravel Auth

### Frontend
- **Template**: AdminLTE 3
- **CSS Framework**: Bootstrap 4
- **JavaScript**: jQuery
- **Charts**: Highcharts

### Libraries & Packages
- **stevebauman/location** - IP Geolocation
- **barryvdh/laravel-dompdf** - PDF Export
- **maatwebsite/excel** - Excel Export
- **intervention/image** - Image Processing

### Deployment
- **Web Server**: Apache/Nginx
- **PHP Version**: 7.4+
- **Composer**: Dependency management
- **NPM**: Frontend assets management

---

## 📊 Metodologi

### ServQual (Service Quality)
Metode ServQual dikembangkan oleh Parasuraman, Zeithaml, dan Berry untuk mengukur kualitas layanan dengan membandingkan:
- **Ekspektasi (E)**: Harapan pelanggan terhadap layanan ideal
- **Persepsi (P)**: Pengalaman aktual pelanggan terhadap layanan

**Gap = P - E**
- Gap negatif → Layanan di bawah ekspektasi (perlu perbaikan)
- Gap positif → Layanan melebihi ekspektasi (keunggulan kompetitif)
- Gap nol → Layanan sesuai ekspektasi

### Customer Loyalty Index (CLI)
CLI mengukur loyalitas melalui 3 aspek perilaku:
1. **Repeat Purchase** - Niat membeli/menggunakan layanan lagi
2. **Retention** - Resistensi terhadap kompetitor
3. **Referral** - Kesediaan merekomendasikan kepada orang lain

### Weighted Score Method
Memberikan bobot berbeda untuk setiap item berdasarkan tingkat kepentingan pelanggan, sehingga:
- Item yang dianggap sangat penting memiliki pengaruh lebih besar terhadap IKP
- Mencerminkan prioritas pelanggan secara akurat
- Menghasilkan indeks yang lebih representatif

---

## 📞 Kontributor

Sistem ini dikembangkan untuk mengukur kepuasan dan loyalitas pelanggan layanan pelatihan menggunakan metode ServQual dan Customer Loyalty Index.

### Lisensi
Sistem ini dikembangkan untuk keperluan penelitian dan implementasi praktis dalam mengukur kualitas layanan lembaga pelatihan.

---

## 📝 Catatan Akhir

Dokumentasi ini bersifat **living document** dan akan terus diperbarui seiring dengan pengembangan sistem. Semua perhitungan matematis telah dijelaskan secara detail dengan contoh nyata untuk memudahkan pemahaman dan implementasi.

**Terakhir diperbarui:** Oktober 2025