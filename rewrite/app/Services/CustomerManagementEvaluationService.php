<?php

namespace App\Services;

use App\Models\CustomerManagementEvaluation;

class CustomerManagementEvaluationService
{
    public function createEvaluation($companyName, $token)
    {
        return CustomerManagementEvaluation::create([
            'token' => $token,
            'company_name' => $companyName,
            'maturity_data' => [],
            'priority_data' => [],
            'readiness_data' => [],
            'completed' => false,
        ]);
    }

    public function getEvaluationByToken($token)
    {
        return CustomerManagementEvaluation::where('token', $token)->first();
    }

    public function getCompletedEvaluationByToken($token)
    {
        return CustomerManagementEvaluation::where('token', $token)->where('completed', true)->first();
    }

    public function updateMaturityData($evaluation, $maturityData)
    {
        if ($evaluation) {
            $evaluation->update(['maturity_data' => $maturityData]);
        }
    }

    public function updatePriorityData($token, $priorityData)
    {
        $evaluation = $this->getEvaluationByToken($token);
        if ($evaluation) {
            $evaluation->update(['priority_data' => $priorityData]);
        }
    }

    public function updateReadinessData($token, $readinessData)
    {
        $evaluation = $this->getEvaluationByToken($token);
        if ($evaluation) {
            $evaluation->update([
                'readiness_data' => $readinessData,
                'completed' => true
            ]);
        }
    }

    public function calculateResults($data)
    {
        // Maturity
        $maturityScores = array_values($data['maturity'] ?? []);
        $maturityAverage = count($maturityScores) > 0 ? array_sum($maturityScores) / count($maturityScores) : 0;

        $roundedAvg = round($maturityAverage);
        $insightIndex = max(0, min(4, $roundedAvg - 1));
        $maturityInsights = [
            [
                'title' => 'Pre-Perancanan Sistem pengelolaan pelanggan',
                'description' => "Organisasi menyadari pentingnya sistem manajemen pelanggan, namun belum sampai pada tahap di mana proyek mengelola pelanggan telah dirancang secara lengkap. Pada tahap ini, organisasi sebaiknya mulai mempertimbangkan implikasi penerapan sistem manajemen pelanggan terhadap struktur dan proses mereka.\n\nBeberapa strategi arah pengembangan sistem manajemen pelanggan yang dapat dilakukan untuk meningkatkan maturitas sistem manajemen pelanggan adalah dengan melakukan audit menggunakan CRM Readiness Audit Payne dan menyusun rencana membangun infrastruktur data"
            ],
            [
                'title' => 'Membangun repositori data',
                'description' => "Organisasi sudah mulai mengumpulkan dan meninjau data pelanggan. Untuk itu perlu dibangun repositori data agar dapat mendukung tugas-tugas sistem manajemen pelanggan baik secara analitis maupun operasional.\n\nLangkah untuk mengembangkan sistem manajemen pelanggan adalah dengan meningkatkan kualitas dan kelengkapan data pelanggan, mengintegrasikan sistem pengelolaan pelanggan dengan sistem operasional perusahaan, dan mengembangkan kapabilitas analitik dasar"
            ],
            [
                'title' => 'Sistem pengelolaan pelanggan berkembang secara moderat',
                'description' => "Organisasi pada tahap ini mulai mengubah pendekatan dengan mengimplementasikan segmentasi sebagai hasil dari pembangunan data warehouse, sehingga segmentasi menjadi lebih berbasis data.\n\nUntuk meningkatkan sistem manajemen pelanggan organisasi dapat meningkatkan kemampuan segmentasi pelanggan dengan berbasis value dan mengembangkan sistem pelaporan dan analitik prediktif untuk sistem manajemen pelanggan"
            ],
            [
                'title' => 'Sistem pengelolaan pelanggan berkembang dengan baik',
                'description' => "Organisasi mulai membangun data warehouse berskala perusahaan, memperluas basis pengguna dan meningkatkan jumlah pengguna, serta mulai mengembangkan tools front-office. Tugas utama pada tahap ini adalah memprioritaskan pelanggan dan menggunakan campaign management secara lebih efektif dengan memanfaatkan data warehouse sepenuhnya.\n\nLangkah yang dapat dilakukan untuk membangun sistem manajemen pelanggan yang lebih maju lagi adalah dengan mengembangkan teknik penggunaan data sains, mengintegrasikan sistem antar departemen, dan menggunakan alat visualisasi data untuk melakukan manajemen pelanggan"
            ],
            [
                'title' => 'Sistem pengelolaan pelanggan sangat maju',
                'description' => "Organisasi telah terintegrasi sepenuhnya, dengan akses data warehouse yang luas di seluruh fungsi departemen menggunakan teknik yang canggih. Tugas utama pada tahap ini adalah pengelolaan pelanggan yang lebih aktif melalui campaign management yang memungkinkan dialog berkelanjutan dengan pelanggan dan memaksimalkan potensi keuntungan sepanjang siklus hidup pelanggan."
            ]
        ];
        $maturityInsightData = $maturityInsights[$insightIndex];

        // Readiness & Persepsi
        $priorityItems = [
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

        $readinessQuestions = [
            ['id' => 'q1', 'target' => 'kepemimpinanStrategis'],
            ['id' => 'q2', 'target' => 'posisiKompetitif'],
            ['id' => 'q3', 'target' => 'kepuasanPelanggan'],
            ['id' => 'q4', 'target' => 'nilaiUmurPelanggan'],
            ['id' => 'q5', 'target' => 'efisiensiBiaya'],
            ['id' => 'q6', 'target' => 'aksesPelanggan'],
            ['id' => 'q7', 'target' => 'solusiAplikasiPelanggan'],
            ['id' => 'q8', 'target' => 'informasiPelanggan'],
            ['id' => 'q9', 'target' => 'prosesPelanggan'],
            ['id' => 'q10', 'target' => 'standarSDM'],
            ['id' => 'q11', 'target' => 'pelaporanKinerja'],
        ];

        $persepsiData = [];
        foreach ($priorityItems as $item) {
            $readinessQuestion = collect($readinessQuestions)->firstWhere('target', $item['id']);
            $score = $readinessQuestion ? ($data['readiness'][$readinessQuestion['id']] ?? 3) : 3;
            $persepsi = ($score / 5) * 100;
            $persepsiData[] = [
                'id' => $item['id'],
                'label' => $item['label'],
                'harapan' => $data['priority'][$item['id']] ?? 0,
                'persepsi' => $persepsi,
            ];
        }

        // Process Groups
        $processGroups = [
            'Strategy development' => ['name' => 'Pengembangan Strategi', 'items' => ['kepemimpinanStrategis', 'posisiKompetitif'], 'persepsi' => 0],
            'Value creation' => ['name' => 'Pengembangan Nilai', 'items' => ['kepuasanPelanggan', 'nilaiUmurPelanggan'], 'persepsi' => 0],
            'Multi-channel integration' => ['name' => 'Manajemen Hubungan Pelanggan', 'items' => ['aksesPelanggan'], 'persepsi' => 0],
            'Information management' => ['name' => 'Manajemen Informasi', 'items' => ['informasiPelanggan', 'solusiAplikasiPelanggan'], 'persepsi' => 0],
            'Persepsi assessment' => ['name' => 'Manajemen Kinerja', 'items' => ['prosesPelanggan', 'standarSDM', 'pelaporanKinerja', 'efisiensiBiaya'], 'persepsi' => 0],
        ];

        foreach ($processGroups as $key => &$group) {
            $groupItems = $group['items'];
            $totalPerf = 0;
            foreach ($groupItems as $itemId) {
                $itemPerf = collect($persepsiData)->firstWhere('id', $itemId)['persepsi'] ?? 0;
                $totalPerf += $itemPerf;
            }
            $group['persepsi'] = count($groupItems) > 0 ? round($totalPerf / count($groupItems)) : 0;
        }

        // Overall Score
        $totalWeightedPersepsi = collect($persepsiData)->sum(function ($item) {
            return $item['persepsi'] * $item['harapan'];
        });
        $totalWeight = collect($persepsiData)->sum('harapan');
        $overallScore = $totalWeight > 0 ? round($totalWeightedPersepsi / $totalWeight) : 0;

        // Debug log
        \Log::info('Customer Evaluation Debug', [
            'persepsiData' => $persepsiData,
            'totalWeightedPersepsi' => $totalWeightedPersepsi,
            'totalWeight' => $totalWeight,
            'overallScore' => $overallScore,
        ]);

        // Recommendation
        $recommendations = [
            'Strategy development' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses pengembangan strategi. Proses ini berfokus pada menyuarakan apa tujuan bisnis UMKM dan siapa pelanggan yang paling penting untuk dilayani. Dengan memperjelas tujuan jangka panjang, usaha dapat fokus dan tidak mudah terombang-ambing oleh persaingan.\n\nLangkah yang perlu diambil oleh perusahaan adalah menentukan tujuan dan visi perusahaan dalam jangka panjang, serta nilai-nilai yang akan diimplementasikan dalam keberjalanan bisnis. Dengan menyatakan tujuan yang jelas, keputusan sehari-hari dalam pengelolaan pelanggan akan lebih terarah dan sesuai. Selanjutnya, perusahaan juga harus melakukan analisis kompetitor dan mengidentifikasi posisi perusahaan di pasar untuk melihat apa keunikan perusahaan jika dibandingkan dengan kompetitor.\n\nSelain itu, penting juga menentukan kelompok pelanggan yang paling utama atau segmentasi pelanggan. Penentuan ini dilakukan karena tidak semua pelanggan bisa diperlakukan sama. Ada pelanggan yang hanya membeli sekali, ada yang rutin, ada pula yang aktif memberi rekomendasi. Strategi akan lebih efektif jika UMKM memilih kelompok mana yang akan lebih diprioritaskan. Misalnya apakah perusahaan ingin melakukan akuisisi atau retensi pelanggan.",
            'Value creation' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses pengembangan nilai. Bagi pelanggan, nilai tidak hanya datang dari produk atau jasa, tetapi dari keseluruhan pengalaman. Untuk itu, UMKM dapat menambah nilai perusahaan melalui hal-hal sederhana, seperti layanan yang ramah, respon cepat dalam menanggapi layanan atau keluhan, diskon bagi pelanggan setia, atau edukasi bermanfaat terkait produk. Penambahan nilai ini tidak hanya memenuhi kebutuhan utama pelanggan atas produk, tapi bisa juga melebihi ekspektasi atau menyadarkan pelanggan akan kebutuhan fitur tersebut. Perusahaan dapat melakukan hal ini untuk meningkatkan hubungan dengan pelanggan agar nantinya pelanggan dapat memberikan rekomendasi kepada orang lain secara mouth-to-mouth dan mengehemat biaya pemasaran.\n\nDi sisi lain, nilai yang diciptakan juga harus memberi keuntungan balik bagi usaha. Nilai itu bisa berupa peningkatan jumlah pelanggan yang datang kembali (retensi), penjualan produk tambahan (cross-selling), atau semakin banyak pelanggan baru (akusisi) melalui rekomendasi.",
            'Multi-channel integration' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen hubungan dengan pelanggan. Interaksi dengan pelanggan perlu dilakukan melalui berbagai saluran komunikasi yang konsisten dan mudah diakses. Saluran ini bisa berupa komunikasi langsung, telepon, media sosial, atau aplikasi pesan. Tidak harus menggunakan semua saluran sekaligus, yang lebih penting adalah memilih saluran yang paling sesuai dengan kebutuhan pelanggan dan memastikan setiap saluran tersebut dikelola dengan baik.\nKecepatan dan konsistensi dalam merespons pelanggan juga menjadi faktor yan penting dalam pengelolaan pelanggan. Ketika saluran komunikasi sudah ditentukan, usaha perlu menjaga agar pelanggan merasa mudah terhubung dan selalu mendapatkan jawaban yang jelas. Dengan begitu, saluran yang digunakan tidak hanya menjadi media komunikasi, tetapi juga sarana untuk membangun hubungan yang lebih kuat dengan pelanggan.",
            'Information management' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen informasi. Informasi tentang pelanggan merupakan aset penting yang harus dimilikki dan dikelola dengan baik. Untuk itu perusahaan dapat memperhatikan mengenai proses pengumpulan, penyimpanan, dan pengintegrasian informasi perusahaan agar perusahaan dapat memahami pelanggan lebih jauh. Proses ini dapat dilakukan dengan cara sederhana menggunakan dokumen digital atau aplikasi pendukung yang sesuai kemampuan usaha. Data-data yang sudah dikumpulkan dapat diolah dan di analisis menggunakan data mining, clustering, atau metode lainnya untuk mendapatkan insights dari informasi mengenai pelanggan.\nSelain pengumpulan dan pengolahan data, perusahaan juga harus mempertimbangkan komponen yang terkait dengan sistem teknologi informasi seperti, perangkat keras, perangkat lunak, dan middleware yang digunakan perusahaan untuk mengelola pelanggan. Perangkat keras terdiri atas alat fisik seperti komputer, laptop, server, keyboard. Perangkat lunak merupakan program komputer yang digunakan untuk mengelola data pelanggan. Sedangkan middleware, merupakan program antara keinginan pelanggan dan server sehingga pelanggan dan sistem dapat berinteraksi dari tempat yang berbeda.\nTerakhir, perusahaan perlu mempertimbangkan aplikasi front-office dan back-office untuk mendukung aktivitas baik langsung dengan pelanggan, maupun dengan administrasi internal dan pemasok. Informasi yang rapi akan memudahkan perusahaan untuk mengenali pola perilaku pelangganya dan melihat potensi kebutuhan dari pelanggan.",
            'Persepsi assessment' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen kinerja. Proses manajemen kinerja merupakan proses untuk memastikan bahwa strategi perusahaan terkait sistem pengelolaan pelanggan dijalankan dan memenuhi kebutuhan yang sudah ditentukan. Evaluasi kinerja dapat dilakukan dengan menetapkan indikator sederhana, seperti tingkat kepuasan pelanggan, jumlah pelanggan kembali, atau frekuensi pembelian pelanggan. Jika perusahaan sudah semakin maju, maka pengukuran kinerja dapat dilakukan dengan membangun balanced scorecard, service-profit chain, atau membangun key persepsi indicatior untuk perusahaan agar dapat melihat ketercapiannya.\n\nEvaluasi tidak harus rumit, yang penting dilakukan secara rutin dan hasilnya dicatat untuk menjadi bahan perbaikan. Dengan adanya catatan evaluasi, usaha dapat melihat perkembangan dari waktu ke waktu dan mengetahui area mana yang sudah berjalan baik serta area mana yang masih membutuhkan perhatian lebih. Hal ini membuat pengelolaan pelanggan tidak hanya bersifat reaktif, tetapi juga dapat diarahkan untuk terus berkembang."
        ];

        $processGroupPersepsis = [];
        foreach ($processGroups as $key => $group) {
            $processGroupPersepsis[] = [
                'key' => $key,
                'persepsi' => $group['persepsi']
            ];
        }

        $lowestPerfGroup = collect($processGroupPersepsis)->reduce(function ($min, $current) {
            return $current['persepsi'] < $min['persepsi'] ? $current : $min;
        }, ['key' => 'Strategy development', 'persepsi' => 100]);

        $recommendation = $recommendations[$lowestPerfGroup['key']];

        return [
            'maturityAverage' => $maturityAverage,
            'maturityInsightData' => $maturityInsightData,
            'persepsiData' => $persepsiData,
            'processGroupResults' => $processGroups,
            'overallScore' => $overallScore,
            'recommendation' => $recommendation,
            'lowestGroupKey' => $lowestPerfGroup['key'],
        ];
    }
}