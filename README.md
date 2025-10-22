# Platform Survei & Assessment UMKM

Platform digital terintegrasi yang menyediakan dua layanan utama untuk mendukung pengembangan UMKM di Indonesia.

## 🎯 Fitur Utama

### 1. Survei Kepuasan Pelatihan
**Target Audience**: Peserta pelatihan individu
**Purpose**: Mengukur kepuasan dan loyalitas peserta terhadap program pelatihan

**Fitur**:
- ✅ Multi-step survey wizard (Profile → Harapan → Persepsi → Kepuasan → Loyalitas → Feedback)
- ✅ Kalkulasi IKP (Indeks Kepuasan Pelanggan) & ILP (Indeks Loyalitas Pelanggan)
- ✅ Gap analysis antara harapan vs persepsi
- ✅ Dashboard analitik dengan grafik SERVQUAL
- ✅ Rekomendasi improvement berdasarkan hasil analisis
- ✅ Statistik demografi responden

**Metodologi**: SERVQUAL dengan 6 dimensi (Reliability, Assurance, Tangible, Empathy, Responsiveness, Applicability)

### 2. Evaluasi Manajemen Pelanggan
**Target Audience**: Perusahaan UMKM
**Purpose**: Mengukur kesiapan organisasi untuk implementasi sistem CRM

**Fitur**:
- ✅ Maturity assessment (8 pertanyaan)
- ✅ Priority analysis (11 item strategis)
- ✅ Readiness audit (11 pertanyaan)
- ✅ Kalkulasi maturity level (1-5) dengan insights spesifik
- ✅ Rekomendasi implementasi CRM berdasarkan process groups
- ✅ Dashboard hasil assessment dengan visualisasi

**Metodologi**: CRM Readiness Assessment dengan 5 process groups (Strategy, Value Creation, Multi-channel Integration, Information Management, Performance Assessment)

## 🏗️ Arsitektur Project

### Tech Stack
- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL
- **Charts**: Chart.js integration

### Database Schema
- `pelatihan_survey_responses`: Menyimpan data survei pelatihan
- `customer_management_evaluations`: Menyimpan data evaluasi perusahaan
- `users`: Admin management

### Service Layer
- `SurveyCalculationService`: Logic kalkulasi IKP/ILP dan analisis SERVQUAL
- `CustomerManagementEvaluationService`: Logic kalkulasi maturity dan readiness CRM

## 🚀 Instalasi & Setup

1. Clone repository
```bash
git clone https://github.com/atiohaidar/Sistem-Pengukuran-Kepuasan-dan-Loyalitas-Pelanggan.git
cd Sistem-Pengukuran-Kepuasan-dan-Loyalitas-Pelanggan
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Setup database
```bash
php artisan migrate
php artisan db:seed
```

5. Build assets
```bash
npm run build
```

6. Run server
```bash
php artisan serve
```

## 📊 Dashboard Admin

Akses dashboard admin untuk:
- Melihat hasil survei pelatihan (tabel & grafik)
- Mengelola data evaluasi perusahaan
- Export data responden
- Monitoring statistik keseluruhan

## 🎨 UI/UX Features

- Responsive design dengan Tailwind CSS
- Gradient themes untuk membedakan kedua layanan
- Smooth animations dan transitions
- Mobile-first approach
- Accessibility-friendly

## 📈 Metrik & Analytics

### Survei Pelatihan
- IKP (Indeks Kepuasan Pelanggan): 0-100%
- ILP (Indeks Loyalitas Pelanggan): 0-100%
- Gap Analysis per dimensi SERVQUAL
- Distribusi demografi responden

### Evaluasi Manajemen Pelanggan
- Maturity Level: 1-5 (dengan insights spesifik)
- Readiness Score: 0-100% per process group
- Priority weighting analysis
- CRM implementation recommendations

## 🔒 Security & Privacy

- Session-based authentication untuk admin
- Token-based tracking untuk responden
- Data encryption untuk sensitive information
- GDPR-compliant data handling

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Support

Untuk pertanyaan atau dukungan teknis, silakan buat issue di repository ini atau hubungi tim development.

---

**Catatan**: Platform ini terdiri dari dua layanan terpisah yang tidak saling terkait secara teknis, namun disatukan dalam satu codebase untuk kemudahan maintenance dan deployment.