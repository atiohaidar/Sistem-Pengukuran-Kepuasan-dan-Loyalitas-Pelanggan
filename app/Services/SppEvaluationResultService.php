<?php

namespace App\Services;

use App\SppEvaluation;
use Illuminate\Support\Str;

class SppEvaluationResultService
{
    private const MATURITY_QUESTIONS = [
        'visi' => 'Visi',
        'strategi' => 'Strategi',
        'pengalamanKonsumen' => 'Pengalaman Konsumen',
        'kolaborasiOrganisasi' => 'Kolaborasi Organisasi',
        'proses' => 'Proses',
        'informasi' => 'Informasi',
        'teknologi' => 'Teknologi',
        'matriks' => 'Matriks',
    ];

    private const MATURITY_INSIGHTS = [
        1 => [
            'title' => 'Pre-Perancanan Sistem pengelolaan pelanggan',
            'description' => "Organisasi menyadari pentingnya sistem manajemen pelanggan, namun belum sampai pada tahap di mana proyek mengelola pelanggan telah dirancang secara lengkap. Pada tahap ini, organisasi sebaiknya mulai mempertimbangkan implikasi penerapan sistem manajemen pelanggan terhadap struktur dan proses mereka.\n\nBeberapa strategi arah pengembangan sistem manajemen pelanggan yang dapat dilakukan untuk meningkatkan maturitas sistem manajemen pelanggan adalah dengan melakukan audit menggunakan CRM Readiness Audit Payne dan menyusun rencana membangun infrastruktur data",
        ],
        2 => [
            'title' => 'Membangun repositori data',
            'description' => "Organisasi sudah mulai mengumpulkan dan meninjau data pelanggan. Untuk itu perlu dibangun repositori data agar dapat mendukung tugas-tugas sistem manajemen pelanggan baik secara analitis maupun operasional.\n\nLangkah untuk mengembangkan sistem manajemen pelanggan adalah dengan meningkatkan kualitas dan kelengkapan data pelanggan, mengintegrasikan sistem pengelolaan pelanggan dengan sistem operasional perusahaan, dan mengembangkan kapabilitas analitik dasar",
        ],
        3 => [
            'title' => 'Sistem pengelolaan pelanggan berkembang secara moderat',
            'description' => "Organisasi pada tahap ini mulai mengubah pendekatan dengan mengimplementasikan segmentasi sebagai hasil dari pembangunan data warehouse, sehingga segmentasi menjadi lebih berbasis data.\n\nUntuk meningkatkan sistem manajemen pelanggan organisasi dapat meningkatkan kemampuan segmentasi pelanggan dengan berbasis value dan mengembangkan sistem pelaporan dan analitik prediktif untuk sistem manajemen pelanggan",
        ],
        4 => [
            'title' => 'Sistem pengelolaan pelanggan berkembang dengan baik',
            'description' => "Organisasi mulai membangun data warehouse berskala perusahaan, memperluas basis pengguna dan meningkatkan jumlah pengguna, serta mulai mengembangkan tools front-office. Tugas utama pada tahap ini adalah memprioritaskan pelanggan dan menggunakan campaign management secara lebih efektif dengan memanfaatkan data warehouse sepenuhnya.\n\nLangkah yang dapat dilakukan untuk membangun sistem manajemen pelanggan yang lebih maju lagi adalah dengan mengembangkan teknik penggunaan data sains, mengintegrasikan sistem antar departemen, dan menggunakan alat visualisasi data untuk melakukan manajemen pelanggan",
        ],
        5 => [
            'title' => 'Sistem pengelolaan pelanggan sangat maju',
            'description' => "Organisasi telah terintegrasi sepenuhnya, dengan akses data warehouse yang luas di seluruh fungsi departemen menggunakan teknik yang canggih. Tugas utama pada tahap ini adalah pengelolaan pelanggan yang lebih aktif melalui campaign management yang memungkinkan dialog berkelanjutan dengan pelanggan dan memaksimalkan potensi keuntungan sepanjang siklus hidup pelanggan.",
        ],
    ];

    private const PRIORITY_ITEMS = [
        ['id' => 'kepemimpinanStrategis', 'label' => 'Kepemimpinan Strategis'],
        ['id' => 'posisiKompetitif', 'label' => 'Posisi Kompetitif'],
        ['id' => 'kepuasanPelanggan', 'label' => 'Kepuasan pelanggan'],
        ['id' => 'nilaiUmurPelanggan', 'label' => 'Nilai umur pelanggan'],
        ['id' => 'efisiensiBiaya', 'label' => 'Efisiensi Biaya'],
        ['id' => 'aksesPelanggan', 'label' => 'Akses pelanggan'],
        ['id' => 'solusiAplikasiPelanggan', 'label' => 'Solusi dan aplikasi pelanggan'],
        ['id' => 'informasiPelanggan', 'label' => 'Informasi Pelanggan'],
        ['id' => 'prosesPelanggan', 'label' => 'Proses Pelanggan'],
        ['id' => 'standarSDM', 'label' => 'Standar SDM'],
        ['id' => 'pelaporanKinerja', 'label' => 'Pelaporan Kinerja'],
    ];

    private const PROCESS_GROUPS = [
        'Strategy development' => ['name' => 'Pengembangan Strategi', 'items' => ['kepemimpinanStrategis', 'posisiKompetitif']],
        'Value creation' => ['name' => 'Pengembangan Nilai', 'items' => ['kepuasanPelanggan', 'nilaiUmurPelanggan']],
        'Multi-channel integration' => ['name' => 'Manajemen Hubungan Pelanggan', 'items' => ['aksesPelanggan']],
        'Information management' => ['name' => 'Manajemen Informasi', 'items' => ['informasiPelanggan', 'solusiAplikasiPelanggan']],
        'Performance assessment' => ['name' => 'Manajemen Kinerja', 'items' => ['prosesPelanggan', 'standarSDM', 'pelaporanKinerja', 'efisiensiBiaya']],
    ];

    private const RECOMMENDATIONS = [
        'Strategy development' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses pengembangan strategi. Proses ini berfokus pada menyuarakan apa tujuan bisnis UMKM dan siapa pelanggan yang paling penting untuk dilayani. Dengan memperjelas tujuan jangka panjang, usaha dapat fokus dan tidak mudah terombang-ambing oleh persaingan.\n\nLangkah yang perlu diambil oleh perusahaan adalah menentukan tujuan dan visi perusahaan dalam jangka panjang, serta nilai-nilai yang akan diimplementasikan dalam keberjalanan bisnis. Dengan menyatakan tujuan yang jelas, keputusan sehari-hari dalam pengelolaan pelanggan akan lebih terarah dan sesuai. Selanjutnya, perusahaan juga harus melakukan analisis kompetitor dan mengidentifikasi posisi perusahaan di pasar untuk melihat apa keunikan perusahaan jika dibandingkan dengan kompetitor.\n\nSelain itu, penting juga menentukan kelompok pelanggan yang paling utama atau segmentasi pelanggan. Penentuan ini dilakukan karena tidak semua pelanggan bisa diperlakukan sama. Ada pelanggan yang hanya membeli sekali, ada yang rutin, ada pula yang aktif memberi rekomendasi. Strategi akan lebih efektif jika UMKM memilih kelompok mana yang akan lebih diprioritaskan. Misalnya apakah perusahaan ingin melakukan akuisisi atau retensi pelanggan.",
        'Value creation' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses pengembangan nilai. Bagi pelanggan, nilai tidak hanya datang dari produk atau jasa, tetapi dari keseluruhan pengalaman. Untuk itu, UMKM dapat menambah nilai perusahaan melalui hal-hal sederhana, seperti layanan yang ramah, respon cepat dalam menanggapi layanan atau keluhan, diskon bagi pelanggan setia, atau edukasi bermanfaat terkait produk. Penambahan nilai ini tidak hanya memenuhi kebutuhan utama pelanggan atas produk, tapi bisa juga melebihi ekspektasi atau menyadarkan pelanggan akan kebutuhan fitur tersebut. Perusahaan dapat melakukan hal ini untuk meningkatkan hubungan dengan pelanggan agar nantinya pelanggan dapat memberikan rekomendasi kepada orang lain secara mouth-to-mouth dan mengehemat biaya pemasaran.\n\nDi sisi lain, nilai yang diciptakan juga harus memberi keuntungan balik bagi usaha. Nilai itu bisa berupa peningkatan jumlah pelanggan yang datang kembali (retensi), penjualan produk tambahan (cross-selling), atau semakin banyak pelanggan baru (akusisi) melalui rekomendasi.",
        'Multi-channel integration' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen hubungan dengan pelanggan. Interaksi dengan pelanggan perlu dilakukan melalui berbagai saluran komunikasi yang konsisten dan mudah diakses. Saluran ini bisa berupa komunikasi langsung, telepon, media sosial, atau aplikasi pesan. Tidak harus menggunakan semua saluran sekaligus, yang lebih penting adalah memilih saluran yang paling sesuai dengan kebutuhan pelanggan dan memastikan setiap saluran tersebut dikelola dengan baik.\nKecepatan dan konsistensi dalam merespons pelanggan juga menjadi faktor yan penting dalam pengelolaan pelanggan. Ketika saluran komunikasi sudah ditentukan, usaha perlu menjaga agar pelanggan merasa mudah terhubung dan selalu mendapatkan jawaban yang jelas. Dengan begitu, saluran yang digunakan tidak hanya menjadi media komunikasi, tetapi juga sarana untuk membangun hubungan yang lebih kuat dengan pelanggan.",
        'Information management' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen informasi. Informasi tentang pelanggan merupakan aset penting yang harus dimilikki dan dikelola dengan baik. Untuk itu perusahaan dapat memperhatikan mengenai proses pengumpulan, penyimpanan, dan pengintegrasian informasi perusahaan agar perusahaan dapat memahami pelanggan lebih jauh. Proses ini dapat dilakukan dengan cara sederhana menggunakan dokumen digital atau aplikasi pendukung yang sesuai kemampuan usaha. Data-data yang sudah dikumpulkan dapat diolah dan di analisis menggunakan data mining, clustering, atau metode lainnya untuk mendapatkan insights dari informasi mengenai pelanggan.\nSelain pengumpulan dan pengolahan data, perusahaan juga harus mempertimbangkan komponen yang terkait dengan sistem teknologi informasi seperti, perangkat keras, perangkat lunak, dan middleware yang digunakan perusahaan untuk mengelola pelanggan. Perangkat keras terdiri atas alat fisik seperti komputer, laptop, server, keyboard. Perangkat lunak merupakan program komputer yang digunakan untuk mengelola data pelanggan. Sedangkan middleware, merupakan program antara keinginan pelanggan dan server sehingga pelanggan dan sistem dapat berinteraksi dari tempat yang berbeda.\nTerakhir, perusahaan perlu mempertimbangkan aplikasi front-office dan back-office untuk mendukung aktivitas baik langsung dengan pelanggan, maupun dengan administrasi internal dan pemasok. Informasi yang rapi akan memudahkan perusahaan untuk mengenali pola perilaku pelangganya dan melihat potensi kebutuhan dari pelanggan.",
        'Performance assessment' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen kinerja. Proses manajemen kinerja merupakan proses untuk memastikan bahwa strategi perusahaan terkait sistem pengelolaan pelanggan dijalankan dan memenuhi kebutuhan yang sudah ditentukan. Evaluasi kinerja dapat dilakukan dengan menetapkan indikator sederhana, seperti tingkat kepuasan pelanggan, jumlah pelanggan kembali, atau frekuensi pembelian pelanggan. Jika perusahaan sudah semakin maju, maka pengukuran kinerja dapat dilakukan dengan membangun balanced scorecard, service-profit chain, atau membangun key performance indicatior untuk perusahaan agar dapat melihat ketercapiannya.\n\nEvaluasi tidak harus rumit, yang penting dilakukan secara rutin dan hasilnya dicatat untuk menjadi bahan perbaikan. Dengan adanya catatan evaluasi, usaha dapat melihat perkembangan dari waktu ke waktu dan mengetahui area mana yang sudah berjalan baik serta area mana yang masih membutuhkan perhatian lebih. Hal ini membuat pengelolaan pelanggan tidak hanya bersifat reaktif, tetapi juga dapat diarahkan untuk terus berkembang.",
    ];

    private const IPA_CONFIG = [
        'width' => 450,
        'height' => 300,
        'padding' => 40,
        'xMax' => 25,
        'yMax' => 100,
        'xMid' => 12.5,
        'yMid' => 70,
    ];

    private const IPA_SINGLE_LABEL_OFFSET = 4;
    private const IPA_BASE_OFFSET = 6;
    private const IPA_SPREAD = 16;

    private const IPA_COLOR_PALETTE = [
        '#0c4a6e',
        '#1e3c72',
        '#2a5298',
        '#0ea5e9',
        '#075985',
        '#1d4ed8',
    ];

    public function buildResultData(SppEvaluation $evaluation): array
    {
        $maturityQuestions = $this->buildMaturityQuestions($evaluation);
        $maturityAverage = (float) $evaluation->maturity_score;
        $roundedAverage = (int) max(1, min(5, round($maturityAverage)));
        $maturityInsight = self::MATURITY_INSIGHTS[$roundedAverage];

        $priorityValues = $this->extractPriorityValues($evaluation);
        $performanceData = $this->buildPerformanceData($evaluation, $priorityValues);
        $processGroups = $this->buildProcessGroups($performanceData);

        $overallScore = $this->calculateOverallScore($performanceData);
        $recommendationText = $this->buildRecommendation($processGroups);

        $ipaPoints = $this->buildIpaPoints($performanceData);

        return [
            'companyName' => $evaluation->company_name,
            'sessionToken' => $evaluation->session_token,
            'companyInitial' => strtoupper(substr($evaluation->company_name, 0, 1)),
            'maturityQuestions' => $maturityQuestions,
            'maturityAverage' => $maturityAverage,
            'roundedAverage' => $roundedAverage,
            'maturityInsight' => $maturityInsight,
            'performanceData' => $performanceData,
            'processGroups' => $processGroups,
            'overallScore' => $overallScore,
            'recommendationText' => $recommendationText,
            'ipaChart' => [
                'config' => self::IPA_CONFIG,
                'points' => $ipaPoints,
            ],
        ];
    }

    private function buildMaturityQuestions(SppEvaluation $evaluation): array
    {
        $values = [
            'visi' => $evaluation->maturity_visi,
            'strategi' => $evaluation->maturity_strategi,
            'pengalamanKonsumen' => $evaluation->maturity_pengalaman_konsumen,
            'kolaborasiOrganisasi' => $evaluation->maturity_kolaborasi_organisasi,
            'proses' => $evaluation->maturity_proses,
            'informasi' => $evaluation->maturity_informasi,
            'teknologi' => $evaluation->maturity_teknologi,
            'matriks' => $evaluation->maturity_matriks,
        ];

        $questions = [];
        foreach (self::MATURITY_QUESTIONS as $key => $label) {
            $questions[$key] = [
                'label' => $label,
                'value' => $values[$key] ?? null,
            ];
        }

        return $questions;
    }

    private function extractPriorityValues(SppEvaluation $evaluation): array
    {
        return [
            'kepemimpinanStrategis' => (int) $evaluation->priority_kepemimpinan_strategis,
            'posisiKompetitif' => (int) $evaluation->priority_posisi_kompetitif,
            'kepuasanPelanggan' => (int) $evaluation->priority_kepuasan_pelanggan,
            'nilaiUmurPelanggan' => (int) $evaluation->priority_nilai_umur_pelanggan,
            'efisiensiBiaya' => (int) $evaluation->priority_efisiensi_biaya,
            'aksesPelanggan' => (int) $evaluation->priority_akses_pelanggan,
            'solusiAplikasiPelanggan' => (int) $evaluation->priority_solusi_aplikasi_pelanggan,
            'informasiPelanggan' => (int) $evaluation->priority_informasi_pelanggan,
            'prosesPelanggan' => (int) $evaluation->priority_proses_pelanggan,
            'standarSDM' => (int) $evaluation->priority_standar_sdm,
            'pelaporanKinerja' => (int) $evaluation->priority_pelaporan_kinerja,
        ];
    }

    private function buildPerformanceData(SppEvaluation $evaluation, array $priorityValues): array
    {
        $readinessScores = [
            'kepemimpinanStrategis' => $evaluation->readiness_q1,
            'posisiKompetitif' => $evaluation->readiness_q2,
            'kepuasanPelanggan' => $evaluation->readiness_q3,
            'nilaiUmurPelanggan' => $evaluation->readiness_q4,
            'efisiensiBiaya' => $evaluation->readiness_q5,
            'aksesPelanggan' => $evaluation->readiness_q6,
            'solusiAplikasiPelanggan' => $evaluation->readiness_q7,
            'informasiPelanggan' => $evaluation->readiness_q8,
            'prosesPelanggan' => $evaluation->readiness_q9,
            'standarSDM' => $evaluation->readiness_q10,
            'pelaporanKinerja' => $evaluation->readiness_q11,
        ];

        $performanceData = [];
        foreach (self::PRIORITY_ITEMS as $item) {
            $importance = $priorityValues[$item['id']] ?? 0;
            $readinessScore = $readinessScores[$item['id']] ?? 3;
            $performance = ($readinessScore / 5) * 100;

            $performanceData[] = [
                'id' => $item['id'],
                'label' => $item['label'],
                'short_label' => Str::of($item['label'])->explode(' ')->first(),
                'importance' => $importance,
                'performance' => round($performance, 2),
            ];
        }

        return $performanceData;
    }

    private function buildProcessGroups(array $performanceData): array
    {
        $indexedPerformance = [];
        foreach ($performanceData as $entry) {
            $indexedPerformance[$entry['id']] = $entry['performance'];
        }

        $groups = [];
        foreach (self::PROCESS_GROUPS as $key => $group) {
            $total = 0;
            $count = 0;
            foreach ($group['items'] as $itemId) {
                if (array_key_exists($itemId, $indexedPerformance)) {
                    $total += $indexedPerformance[$itemId];
                    $count++;
                }
            }

            $groups[$key] = [
                'key' => $key,
                'name' => $group['name'],
                'performance' => $count > 0 ? round($total / $count) : 0,
            ];
        }

        return $groups;
    }

    private function calculateOverallScore(array $performanceData): int
    {
        $totalWeightedPerformance = 0;
        $totalImportance = 0;

        foreach ($performanceData as $item) {
            $totalWeightedPerformance += $item['performance'] * $item['importance'];
            $totalImportance += $item['importance'];
        }

        if ($totalImportance === 0) {
            return 0;
        }

        return (int) round($totalWeightedPerformance / $totalImportance);
    }

    private function buildRecommendation(array $processGroups): string
    {
        if (empty($processGroups)) {
            return 'Secara umum, pertahankan kinerja yang sudah baik dan terus lakukan perbaikan berkelanjutan.';
        }

        $lowest = null;
        foreach ($processGroups as $group) {
            if ($lowest === null || $group['performance'] < $lowest['performance']) {
                $lowest = $group;
            }
        }

        if ($lowest && array_key_exists($lowest['key'], self::RECOMMENDATIONS)) {
            return self::RECOMMENDATIONS[$lowest['key']];
        }

        return 'Secara umum, pertahankan kinerja yang sudah baik dan terus lakukan perbaikan berkelanjutan.';
    }

    private function buildIpaPoints(array $performanceData): array
    {
        $config = self::IPA_CONFIG;
        $buckets = [];

        foreach ($performanceData as $item) {
            $key = ($item['importance'] ?? 0) . '-' . ($item['performance'] ?? 0);
            $buckets[$key][] = $item;
        }

        $points = [];
        foreach ($buckets as $bucketKey => $items) {
            $count = count($items);

            if ($count === 1) {
                $points[] = $this->buildIpaPointPayload($items[0], self::IPA_SINGLE_LABEL_OFFSET, $bucketKey);
                continue;
            }

            $initialOffset = -((($count - 1) * self::IPA_SPREAD) / 2);
            foreach ($items as $index => $item) {
                $labelOffset = self::IPA_BASE_OFFSET + $initialOffset + ($index * self::IPA_SPREAD);
                $points[] = $this->buildIpaPointPayload($item, $labelOffset, $bucketKey . '-' . $index);
            }
        }

        return $points;
    }

    private function buildIpaPointPayload(array $item, float $labelOffset, string $seed): array
    {
        $config = self::IPA_CONFIG;
        $importance = min($item['importance'], $config['xMax']);
        $performance = min($item['performance'], $config['yMax']);

        $colorIndex = crc32($seed) % count(self::IPA_COLOR_PALETTE);

        return [
            'label' => $item['label'],
            'short_label' => $item['short_label'],
            'importance' => $importance,
            'performance' => $performance,
            'label_y_offset' => $labelOffset,
            'color' => self::IPA_COLOR_PALETTE[$colorIndex],
        ];
    }
}
