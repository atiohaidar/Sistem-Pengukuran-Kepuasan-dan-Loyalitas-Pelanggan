<?php

namespace App\Services;

class ProdukSurveyQuestionService
{
    /**
     * Get all questions for produk survey
     * For now, questions are copied from pelatihan as per requirements
     * Structure is designed to be easily updated later
     */
    public function getProdukQuestions(): array
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
     * Get dimensions configuration for questions
     * This structure makes it easy to update questions later
     */
    public function getDimensionsConfig(): array
    {
        return [
            'reliability' => [
                'label' => 'Reliability',
                'description' => 'Keandalan dalam memberikan layanan',
                'items' => ['r1', 'r2', 'r3', 'r4', 'r5', 'r6', 'r7'],
            ],
            'assurance' => [
                'label' => 'Assurance',
                'description' => 'Jaminan dan kepercayaan',
                'items' => ['a1', 'a2', 'a3', 'a4'],
            ],
            'tangible' => [
                'label' => 'Tangible',
                'description' => 'Bukti fisik dan tampilan',
                'items' => ['t1', 't2', 't3', 't4', 't5', 't6'],
            ],
            'empathy' => [
                'label' => 'Empathy',
                'description' => 'Empati dan perhatian',
                'items' => ['e1', 'e2', 'e3', 'e4', 'e5'],
            ],
            'responsiveness' => [
                'label' => 'Responsiveness',
                'description' => 'Daya tanggap',
                'items' => ['rs1', 'rs2'],
            ],
            'applicability' => [
                'label' => 'Applicability',
                'description' => 'Kemudahan penerapan',
                'items' => ['ap1', 'ap2'],
            ],
        ];
    }
}
