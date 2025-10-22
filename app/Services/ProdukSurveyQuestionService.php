<?php

namespace App\Services;

class ProdukSurveyQuestionService
{
    /**
     * Get all questions for produk survey
     * Questions are adapted to describe products/layanan (originally copied from pelatihan)
     * Structure is designed to be easily updated later
     */
    public function getProdukQuestions(): array
    {
        return [
            // Harapan questions
            'harapan_answers' => [
                'reliability' => [
                    'r1' => 'Kesesuaian informasi yang diberikan dengan produk yang ditawarkan',
                    'r2' => 'Ketepatan waktu pengiriman sesuai dengan estimasi yang dijanjikan',
                    'r3' => 'Ketepatan waktu dalam pengiriman produk',
                    'r4' => 'Ketepatan penyedia dalam menjawab pertanyaan pelanggan',
                    'r5' => 'Informasi produk mudah dimengerti',
                    'r6' => 'Kemudahan dalam proses pemesanan produk',
                    'r7' => 'Kemudahan dalam melakukan pembayaran',
                ],
                'assurance' => [
                    'a1' => 'Staf/penyedia bersikap sopan',
                    'a2' => 'Penyedia memiliki pengetahuan yang memadai tentang produk',
                    'a3' => 'Penyedia mampu menjelaskan produk dengan jelas',
                    'a4' => 'Layanan pelanggan selalu dapat menyelesaikan keluhan pelanggan',
                ],
                'tangible' => [
                    't1' => 'Platform/website pemesanan produk yang user friendly',
                    't2' => 'Halaman produk menampilkan informasi yang akurat',
                    't3' => 'Kondisi fisik produk sesuai ekspektasi',
                    't4' => 'Proses transaksi dan pemesanan berjalan lancar',
                    't5' => 'Deskripsi produk menarik dan informatif',
                    't6' => 'Produk dikemas rapi',
                ],
                'empathy' => [
                    'e1' => 'Penyedia memberi perhatian kepada pelanggan',
                    'e2' => 'Penyedia memahami kebutuhan pelanggan',
                    'e3' => 'Terjalin komunikasi yang baik antara penyedia dengan pelanggan',
                    'e4' => 'Penyedia berupaya membantu saat pelanggan mengalami masalah',
                    'e5' => 'Ketersediaan dukungan selama proses pembelian',
                ],
                'responsiveness' => [
                    'rs1' => 'Kecepatan respon layanan pelanggan dalam menanggapi pelanggan',
                    'rs2' => 'Kepastian informasi mengenai status pesanan/pengiriman',
                ],
                'applicability' => [
                    'ap1' => 'Produk berkaitan langsung dengan kebutuhan saya',
                    'ap2' => 'Produk mudah digunakan atau diterapkan',
                ],
            ],
            // Persepsi questions (same structure as harapan but different text)
            'persepsi_answers' => [
                'reliability' => [
                    'r1' => 'Informasi produk sesuai dengan yang ditawarkan',
                    'r2' => 'Pengiriman produk sesuai dengan estimasi yang dijanjikan',
                    'r3' => 'Produk diterima tepat waktu',
                    'r4' => 'Penyedia menjawab pertanyaan pelanggan dengan baik',
                    'r5' => 'Informasi produk mudah dimengerti',
                    'r6' => 'Proses pemesanan produk mudah dilakukan',
                    'r7' => 'Proses pembayaran mudah dilakukan',
                ],
                'assurance' => [
                    'a1' => 'Staf/penyedia bersikap sopan',
                    'a2' => 'Penyedia memiliki pengetahuan yang memadai tentang produk',
                    'a3' => 'Penyedia mampu menjelaskan produk dengan jelas',
                    'a4' => 'Layanan pelanggan selalu dapat menyelesaikan keluhan pelanggan',
                ],
                'tangible' => [
                    't1' => 'Platform/website pemesanan produk yang user friendly',
                    't2' => 'Halaman produk menampilkan informasi yang akurat',
                    't3' => 'Kondisi fisik produk sesuai ekspektasi',
                    't4' => 'Proses transaksi dan pemesanan berjalan lancar',
                    't5' => 'Deskripsi produk menarik dan informatif',
                    't6' => 'Produk dikemas rapi',
                ],
                'empathy' => [
                    'e1' => 'Penyedia memberikan perhatian kepada pelanggan',
                    'e2' => 'Penyedia memahami kebutuhan pelanggan',
                    'e3' => 'Terjalin komunikasi yang baik antara penyedia dengan pelanggan',
                    'e4' => 'Penyedia berupaya membantu saat pelanggan mengalami masalah.',
                    'e5' => 'Ketersediaan dukungan selama proses pembelian',
                ],
                'responsiveness' => [
                    'rs1' => 'Layanan pelanggan cepat memberikan respon dalam menanggapi pelanggan',
                    'rs2' => 'Informasi mengenai status pesanan/pengiriman diberikan dengan tepat',
                ],
                'applicability' => [
                    'ap1' => 'Produk mudah diterapkan dalam kebutuhan sehari-hari',
                    'ap2' => 'Produk dapat meningkatkan kenyamanan atau produktivitas kerja',
                ],
            ],
            // Kepuasan questions
            'kepuasan_answers' => [
                'k1' => 'Secara keseluruhan, saya merasa puas dengan produk/layanan ini.',
                'k2' => 'Menurut saya, kinerja produk/layanan ini telah sesuai dengan harapan saya.',
                'k3' => 'Menurut saya, produk/layanan ini telah sesuai dengan produk/layanan yang ideal.',
            ],
            // Loyalitas questions
            'loyalitas_answers' => [
                'l1' => 'Saya akan membeli/menggunakan produk ini lagi.',
                'l2' => 'Saya akan tetap memilih produk ini meskipun tersedia alternatif lain.',
                'l3' => 'Saya akan merekomendasikan produk ini kepada orang lain.',
            ],
            // Feedback questions
            'feedback_answers' => [
                'kritik_saran' => 'Silahkan berikan kritik dan saran terkait produk/layanan berdasarkan apa yang Anda alami.',
                'tema_judul' => 'Fitur atau kategori produk yang Anda inginkan.',
                'bentuk_pelatihan' => 'Bentuk produk/layanan yang Anda inginkan.',
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
