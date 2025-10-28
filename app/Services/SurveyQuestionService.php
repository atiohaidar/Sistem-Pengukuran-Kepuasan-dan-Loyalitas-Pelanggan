<?php

namespace App\Services;

class SurveyQuestionService
{
    /**
     * Cached questions to avoid rebuilding the array repeatedly during a request lifecycle.
     */
    protected ?array $cachedQuestions = null;

    /**
     * Retrieve the base question definition, cached per request.
     */
    protected function questions(): array
    {
        if ($this->cachedQuestions === null) {
            $this->cachedQuestions = $this->getPelatihanQuestions();
        }

        return $this->cachedQuestions;
    }

    /**
     * Get harapan questions only.
     */
    public function getHarapanQuestions(): array
    {
        return $this->questions()['harapan_answers'] ?? [];
    }

    /**
     * Get persepsi questions only.
     */
    public function getPersepsiQuestions(): array
    {
        return $this->questions()['persepsi_answers'] ?? [];
    }

    /**
     * Get kepuasan questions only.
     */
    public function getKepuasanQuestions(): array
    {
        return $this->questions()['kepuasan_answers'] ?? [];
    }

    /**
     * Get loyalitas questions only.
     */
    public function getLoyalitasQuestions(): array
    {
        return $this->questions()['loyalitas_answers'] ?? [];
    }

    /**
     * Get feedback questions only.
     */
    public function getFeedbackQuestions(): array
    {
        return $this->questions()['feedback_answers'] ?? [];
    }

    /**
     * Backward-compatible accessor used by older controllers/views.
     */
    public function getQuestions(): array
    {
        return $this->questions();
    }

    /**
     * Backward-compatible alias for loyalitas getters.
     */
    public function getLoyaltyQuestions(): array
    {
        return $this->getLoyalitasQuestions();
    }

    /**
     * Get all questions for pelatihan survey
     */
    public function getPelatihanQuestions(): array
    {
        return [
            // Harapan questions
            'harapan_answers' => [
                'reliability' => [
                    'r1' => 'Kesesuaian isi post test dengan materi pelatihan yang diberikan',
                    'r2' => 'Ketepatan waktu pelatihan sesuai dengan jadwal yang telah dijanjikan',
                    'r3' => 'Ketepatan waktu dalam memberikan sertifikat pelatihan',
                    'r4' => 'Ketepatan trainer dalam menjawab pertanyaan peserta',
                    'r5' => 'Materi pelatihan mudah dimengerti',
                    'r6' => 'Kemudahan dalam melakukan registrasi pelatihan',
                    'r7' => 'Kemudahan dalam melakukan pembayaran pelatihan',
                ],
                'assurance' => [
                    'a1' => 'Trainer/pegawai bersikap sopan',
                    'a2' => 'Trainer memiliki pengetahuan yang luas mengenai materi pelatihan',
                    'a3' => 'Trainer mampu menyampaikan materi pelatihan dengan cara yang mudah dipahami',
                    'a4' => 'Committee service selalu dapat menyelesaikan keluhan pelanggan',
                ],
                'tangible' => [
                    't1' => 'Sistem aplikasi pelatihan online yang user friendly',
                    't2' => 'Website menampilkan informasi terbaru',
                    't3' => 'Perlengkapan audio visual berfungsi dengan baik',
                    't4' => 'Koneksi internet host lancar selama pelatihan berlangsung',
                    't5' => 'Tampilan modul pelatihan menarik untuk dibaca',
                    't6' => 'Trainer berpenampilan rapi',
                ],
                'empathy' => [
                    'e1' => 'Trainer memberi perhatian kepada peserta',
                    'e2' => 'Trainer memahami kebutuhan peserta',
                    'e3' => 'Terjalin komunikasi yang baik antara trainer dengan peserta',
                    'e4' => 'Trainer berupaya membantu saat peserta mengalami kesulitan',
                    'e5' => 'Kecukupan waktu yang dialokasikan untuk pelatihan',
                ],
                'responsiveness' => [
                    'rs1' => 'Kecepatan respon contact person perusahaan dalam menanggapi peserta',
                    'rs2' => 'Kepastian informasi mengenai jadwal pelatihan',
                ],
                'applicability' => [
                    'ap1' => 'Pelatihan berkaitan langsung dengan pekerjaan saya',
                    'ap2' => 'Pelatihan yang diberikan mudah untuk diterapkan dalam pekerjaan',
                ],
            ],
            // Persepsi questions (same structure as harapan but different text)
            'persepsi_answers' => [
                'reliability' => [
                    'r1' => 'Isi post test sesuai dengan materi pelatihan yang diberikan',
                    'r2' => 'Waktu pelatihan sesuai dengan jadwal yang telah dijanjikan',
                    'r3' => 'Sertifikat pelatihan diberikan tepat waktu',
                    'r4' => 'Trainer menjawab pertanyaan peserta dengan baik',
                    'r5' => 'Materi pelatihan mudah dimengerti',
                    'r6' => 'Registrasi pelatihan mudah dilakukan',
                    'r7' => 'Pembayaran pelatihan mudah dilakukan',
                ],
                'assurance' => [
                    'a1' => 'Trainer/pegawai bersikap sopan',
                    'a2' => 'Trainer memiliki pengetahuan yang luas mengenai materi pelatihan',
                    'a3' => 'Trainer mampu menyampaikan materi pelatihan dengan cara yang mudah dipahami',
                    'a4' => 'Committee service selalu dapat menyelesaikan keluhan pelanggan',
                ],
                'tangible' => [
                    't1' => 'Sistem aplikasi pelatihan online yang user friendly',
                    't2' => 'Website menampilkan informasi terbaru',
                    't3' => 'Perlengkapan audio visual berfungsi dengan baik',
                    't4' => 'Koneksi internet host lancar selama pelatihan berlangsung',
                    't5' => 'Tampilan modul pelatihan menarik untuk dibaca',
                    't6' => 'Trainer berpenampilan rapi',
                ],
                'empathy' => [
                    'e1' => 'Trainer memberikan perhatian kepada peserta',
                    'e2' => 'Trainer memahami kebutuhan peserta',
                    'e3' => 'Terjalin komunikasi yang baik antara trainer dengan peserta',
                    'e4' => 'Trainer berupaya membantu saat peserta mengalami kesulitan.',
                    'e5' => 'Waktu yang dialokasikan untuk pelatihan cukup',
                ],
                'responsiveness' => [
                    'rs1' => 'Contact person Perusahaan cepat memberikan respon dalam menanggapi peserta',
                    'rs2' => 'Informasi Jadwal pelatihan diberikan dengan tepat',
                ],
                'applicability' => [
                    'ap1' => 'Materi pelatihan mudah diterapkan dalam pekerjaan sehari-hari',
                    'ap2' => 'Materi pelatihan dapat meningkatkan produktivitas kerja',
                ],
            ],
            // Kepuasan questions
            'kepuasan_answers' => [
                'k1' => 'Secara keseluruhan, saya merasa puas pada layanan pelatihan ini.',
                'k2' => 'Menurut saya, kinerja layanan pelatihan ini telah sesuai dengan harapan saya.',
                'k3' => 'Menurut saya, layanan pelatihan ini telah sesuai dengan layanan pelatihan yang ideal.',
            ],
            // Loyalitas questions
            'loyalitas_answers' => [
                'l1' => 'Saya akan mengulangi menggunakan jasa pelatihan ini.',
                'l2' => 'Saya akan tetap memilih jasa pelatihan ini meskipun tersedia alternatif pelatihan lain.',
                'l3' => 'Saya akan merekomendasikan pelatihan ini kepada orang lain.',
            ],
            // Feedback questions
            'feedback_answers' => [
                'kritik_saran' => 'Silahkan berikan kritik dan saran terkait layanan pelatihan berdasarkan apa yang Anda alami.',
                'tema_judul' => 'Tema dan judul pelatihan yang Anda inginkan.',
                'bentuk_pelatihan' => 'Bentuk pelatihan yang Anda inginkan.',
            ],
        ];
    }

    /**
     * Get all questions for customer management evaluation
     */
    public function getCustomerEvaluationQuestions(): array
    {
        return [
            'maturity' => [
                'visi' => 'Visi',
                'strategi' => 'Strategi',
                'pengalamanKonsumen' => 'Pengalaman Konsumen',
                'kolaborasiOrganisasi' => 'Kolaborasi Organisasi',
                'proses' => 'Proses',
                'informasi' => 'Informasi',
                'teknologi' => 'Teknologi',
                'matriks' => 'Matriks',
            ],
            'priority' => [
                'kepemimpinanStrategis' => 'Kepemimpinan Strategis',
                'posisiKompetitif' => 'Posisi Kompetitif',
                'kepuasanPelanggan' => 'Kepuasan pelanggan',
                'nilaiUmurPelanggan' => 'Nilai umur pelanggan',
                'efisiensiBiaya' => 'Efisiensi Biaya',
                'aksesPelanggan' => 'Akses pelanggan',
                'solusiAplikasiPelanggan' => 'Solusi dan aplikasi pelanggan',
                'informasiPelanggan' => 'Informasi Pelanggan',
                'prosesPelanggan' => 'Proses Pelanggan',
                'standarSDM' => 'Standar SDM',
                'pelaporanKinerja' => 'Pelaporan Kinerja',
            ],
            'readiness' => [
                'q1' => 'Apakah organisasi saya menunjukkan kepemimpinan dalam proses menjalankan SPP?',
                'q2' => 'Bagaimana posisi perusahaan saya jika dibandingkan dengan perusahaan lainnya?',
                'q3' => 'Seberapa puas pelanggan saya terhadap produk dan layanan yang ditawarkan?',
                'q4' => 'Berapa nilai jangka panjang pelanggan saya?',
                'q5' => 'Apakah saya sudah menggunakan biaya melayani pelanggan secara efisien?',
                'q6' => 'Seberapa efektif dan terintegrasi saluran akses yang digunakan pelanggan untuk berhubungan dengan organisasi saya?',
                'q7' => 'Seberapa efektif solusi dan aplikasi yang memungkinkan pelanggan mendapatkan produk/layanan saya?',
                'q8' => 'Bagaimana saya mengelola informasi pelanggan yang digunakan dan dihasilkan dari setiap titik kontak pelanggan?',
                'q9' => 'Apakah organisasi saya memiliki proses pelanggan yang sesuai untuk memberikan produk/layanan secara berkualitas?',
                'q10' => 'Apakah saya memiliki sumber daya manusia yang kompeten dan termotivasi untuk memberikan produk/layanan kepada pelanggan?',
                'q11' => 'Apakah organisasi saya memiliki sistem pelaporan kinerja SPP yang sesuai untuk mengukur dampak terhadap hasil bisnis?',
            ]
        ];
    }

    /**
     * Get maturity questions with full details
     */
    public function getMaturityQuestions(): array
    {
        return [
            'visi' => [
                'label' => 'Visi',
                'description' => 'Arah masa depan bisnis berfokus pada pelanggan',
                'options' => [
                    1 => 'Tidak memiliki visi terkait pelanggan',
                    2 => 'Mulai memiliki inisiatif terkait pelanggan namun belum terintegrasi ke visi',
                    3 => 'Visi berorientasi pelanggan mulai diterapkan di masing-masing fungsi',
                    4 => 'Visi berorientasi pelanggan diadopsi di seluruh unit bisnis internal',
                    5 => 'Visi berorientasi pelanggan diadopsi di unit bisnis internal dan eksternal',
                ]
            ],
            'strategi' => [
                'label' => 'Strategi',
                'description' => 'Pendekatan strategis untuk manajemen pelanggan',
                'options' => [
                    1 => 'Tidak ada strategi SPP',
                    2 => 'Proyek SPP dimulai tanpa koordinasi dan belum terarah',
                    3 => 'Ada kesadaran strategis SPP tapi masih antar departemen',
                    4 => 'SPP dikelola terpusat dengan dukungan antar fungsi',
                    5 => 'SPP dikembangkan bersama mitra untuk manfaat bersama',
                ]
            ],
            'pengalamanKonsumen' => [
                'label' => 'Pengalaman Konsumen',
                'description' => 'Memberikan pengalaman kepada pelanggan yang konsisten',
                'options' => [
                    1 => 'Tidak ada konsep dan didesain dengan sendiri',
                    2 => 'Tidak ada konsep dan didesain dengan sendiri',
                    3 => 'Fokus pada pengalaman konsumen namun hanya di fungsi tertentu',
                    4 => 'Fokus pada pengalaman konsumen mulai lintas unit',
                    5 => 'Pengalaman pelanggan dikelola bersama internal dan eksternal',
                ]
            ],
            'kolaborasiOrganisasi' => [
                'label' => 'Kolaborasi Organisasi',
                'description' => 'Kolaborasi lintas fungsi untuk fokus pelanggan',
                'options' => [
                    1 => 'Setiap departemen bekerja sendiri dan tidak berfokus pada pelanggan',
                    2 => 'Ada inisiatif untuk berfokus pada pelanggan tapi terkendala SILO',
                    3 => 'Budaya organisasi mulai bergeser mendukung kolaborasi',
                    4 => 'Struktur organisasi dirancang berdasarkan segmen pelanggan',
                    5 => 'Pihak internal dan eksternal bekerja sama dengan tujuan yang sama',
                ]
            ],
            'proses' => [
                'label' => 'Proses',
                'description' => 'Proses bisnis yang mendukung pelanggan',
                'options' => [
                    1 => 'Proses belum dirancang untuk kepuasan pelanggan (efisiensi internal)',
                    2 => 'Proses sudah diperbaiki oleh tiap departemen namun belum menyatu',
                    3 => 'Proses sudah memperhatikan efisiensi dan nilai di level departemen',
                    4 => 'Proses berorientasi pelanggan mulai diintegrasikan lintas fungsi',
                    5 => 'Proses terintegrasi dari awal hingga akhir melibatkan pelanggan & mitra',
                ]
            ],
            'informasi' => [
                'label' => 'Informasi',
                'description' => 'Penggunaan data pelanggan',
                'options' => [
                    1 => 'Data tersebar, tidak konsisten, dan tidak digunakan',
                    2 => 'Data digunakan secara lokal di tim, tidak dibagikan',
                    3 => 'Ada pemanfaatan data dalam unit, mulai terlihat insight',
                    4 => 'Insight dibagikan ke seluruh organisasi',
                    5 => 'Data dan insight digunakan oleh mitra dan pihak luar',
                ]
            ],
            'teknologi' => [
                'label' => 'Teknologi',
                'description' => 'Pemanfaatan teknologi untuk pelanggan',
                'options' => [
                    1 => 'Teknologi SPP sangat terbatas dan tidak mendukung aktivitas bisnis',
                    2 => 'Alat SPP hanya digunakan untuk aktivitas dasar dan tidak terintegrasi',
                    3 => 'Teknologi SPP mulai kuat namun hanya di departemen tertentu',
                    4 => 'Teknologi SPP digunakan lintas departemen dan terintegrasi',
                    5 => 'Teknologi SPP terintegrasi dengan mitra & pelanggan secara digital',
                ]
            ],
            'matriks' => [
                'label' => 'Matriks',
                'description' => 'Pengukuran kinerja terkait pelanggan',
                'options' => [
                    1 => 'Tidak ada metode pengukuran hanya fokus ke operasional internal',
                    2 => 'Matriks hanya untuk efisiensi departemen, bukan untuk pelanggan',
                    3 => 'Matriks fokus pada produktivitas, bukan kepuasan pelanggan',
                    4 => 'Matriks mencakup aspek pelanggan dan organisasi secara seimbang',
                    5 => 'Semua pihak memiliki matriks yang selaras untuk jangka panjang',
                ]
            ],
        ];
    }

    /**
     * Get priority items with descriptions
     */
    public function getPriorityItems(): array
    {
        return [
            'kepemimpinanStrategis' => ['label' => 'Kepemimpinan Strategis', 'description' => 'Tingkat komitmen dan keterlibatan manajemen puncak.'],
            'posisiKompetitif' => ['label' => 'Posisi Kompetitif', 'description' => 'Posisi perusahaan jika dibandingkan dengan perusahaan lainnya.'],
            'kepuasanPelanggan' => ['label' => 'Kepuasan pelanggan', 'description' => 'Kemampuan organisasi dalam memahami, mengukur, dan meningkatkan kepuasan pelanggan.'],
            'nilaiUmurPelanggan' => ['label' => 'Nilai umur pelanggan', 'description' => 'Kemampuan organisasi dalam memahami nilai jangka panjang pelanggan.'],
            'efisiensiBiaya' => ['label' => 'Efisiensi Biaya', 'description' => 'Penggunaan biaya dalam melayani pelanggan secara efisien.'],
            'aksesPelanggan' => ['label' => 'Akses pelanggan', 'description' => 'Efektivitas dan integrasi kanal yang digunakan pelanggan.'],
            'solusiAplikasiPelanggan' => ['label' => 'Solusi dan aplikasi pelanggan', 'description' => 'Evaluasi terhadap solusi dan aplikasi yang digunakan pelanggan.'],
            'informasiPelanggan' => ['label' => 'Informasi Pelanggan', 'description' => 'Kualitas, integritas, dan penggunaan informasi pelanggan.'],
            'prosesPelanggan' => ['label' => 'Proses Pelanggan', 'description' => 'Efisiensi dan efektivitas proses internal yang mendukung pelanggan.'],
            'standarSDM' => ['label' => 'Standar SDM', 'description' => 'Standar kompetensi dan motivasi karyawan dalam memberikan layanan.'],
            'pelaporanKinerja' => ['label' => 'Pelaporan Kinerja', 'description' => 'Ketersediaan sistem pengukuran kinerja SPP secara menyeluruh.'],
        ];
    }

    /**
     * Get readiness questions with full details
     */
    public function getReadinessQuestions(): array
    {
        return [
            'q1' => [
                'label' => 'Apakah organisasi saya menunjukkan kepemimpinan dalam proses menjalankan SPP?',
                'options' => [
                    1 => 'Sangat Tidak Setuju',
                    2 => 'Tidak Setuju',
                    3 => 'Netral',
                    4 => 'Setuju',
                    5 => 'Sangat Setuju',
                ]
            ],
            'q2' => [
                'label' => 'Bagaimana posisi perusahaan saya jika dibandingkan dengan perusahaan lainnya?',
                'options' => [
                    1 => 'Jauh Lebih Buruk',
                    2 => 'Lebih Buruk',
                    3 => 'Setara',
                    4 => 'Lebih Baik',
                    5 => 'Jauh Lebih Baik',
                ]
            ],
            'q3' => [
                'label' => 'Seberapa puas pelanggan saya terhadap produk dan layanan yang ditawarkan?',
                'options' => [
                    1 => 'Sangat Tidak Puas',
                    2 => 'Tidak Puas',
                    3 => 'Netral',
                    4 => 'Puas',
                    5 => 'Sangat Puas',
                ]
            ],
            'q4' => [
                'label' => 'Berapa nilai jangka panjang pelanggan saya?',
                'options' => [
                    1 => 'Sangat Rendah',
                    2 => 'Rendah',
                    3 => 'Sedang',
                    4 => 'Tinggi',
                    5 => 'Sangat Tinggi',
                ]
            ],
            'q5' => [
                'label' => 'Apakah saya sudah menggunakan biaya melayani pelanggan secara efisien?',
                'options' => [
                    1 => 'Sangat Tidak Efisien',
                    2 => 'Tidak Efisien',
                    3 => 'Netral',
                    4 => 'Efisien',
                    5 => 'Sangat Efisien',
                ]
            ],
            'q6' => [
                'label' => 'Seberapa efektif dan terintegrasi saluran akses yang digunakan pelanggan untuk berhubungan dengan organisasi saya?',
                'options' => [
                    1 => 'Sangat Tidak Efektif',
                    2 => 'Tidak Efektif',
                    3 => 'Netral',
                    4 => 'Efektif',
                    5 => 'Sangat Efektif',
                ]
            ],
            'q7' => [
                'label' => 'Seberapa efektif solusi dan aplikasi yang memungkinkan pelanggan mendapatkan produk/layanan saya?',
                'options' => [
                    1 => 'Sangat Tidak Efektif',
                    2 => 'Tidak Efektif',
                    3 => 'Netral',
                    4 => 'Efektif',
                    5 => 'Sangat Efektif',
                ]
            ],
            'q8' => [
                'label' => 'Bagaimana saya mengelola informasi pelanggan yang digunakan dan dihasilkan dari setiap titik kontak pelanggan?',
                'options' => [
                    1 => 'Sangat Buruk',
                    2 => 'Buruk',
                    3 => 'Cukup',
                    4 => 'Baik',
                    5 => 'Sangat Baik',
                ]
            ],
            'q9' => [
                'label' => 'Apakah organisasi saya memiliki proses pelanggan yang sesuai untuk memberikan produk/layanan secara berkualitas?',
                'options' => [
                    1 => 'Tidak ada',
                    2 => 'Tidak Sesuai',
                    3 => 'Cukup',
                    4 => 'Sesuai',
                    5 => 'Sangat Sesuai',
                ]
            ],
            'q10' => [
                'label' => 'Apakah saya memiliki sumber daya manusia yang kompeten dan termotivasi untuk memberikan produk/layanan kepada pelanggan?',
                'options' => [
                    1 => 'Tidak Pernah',
                    2 => 'Jarang',
                    3 => 'Kadang-kadang',
                    4 => 'Sebagian Besar',
                    5 => 'Selalu',
                ]
            ],
            'q11' => [
                'label' => 'Apakah organisasi saya memiliki sistem pelaporan kinerja SPP yang sesuai untuk mengukur dampak terhadap hasil bisnis?',
                'options' => [
                    1 => 'Tidak ada',
                    2 => 'Tidak Sesuai',
                    3 => 'Cukup',
                    4 => 'Sesuai',
                    5 => 'Sangat Sesuai',
                ]
            ],
        ];
    }
}