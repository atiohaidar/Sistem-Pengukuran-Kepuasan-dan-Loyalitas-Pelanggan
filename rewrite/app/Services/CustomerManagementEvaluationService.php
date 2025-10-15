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

        // Readiness & Performance
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

        $performanceData = [];
        foreach ($priorityItems as $item) {
            $readinessQuestion = collect($readinessQuestions)->firstWhere('target', $item['id']);
            $score = $readinessQuestion ? ($data['readiness'][$readinessQuestion['id']] ?? 3) : 3;
            $performance = ($score / 5) * 100;
            $performanceData[] = [
                'id' => $item['id'],
                'label' => $item['label'],
                'importance' => $data['priority'][$item['id']] ?? 0,
                'performance' => $performance,
            ];
        }

        // Process Groups
        $processGroups = [
            'Strategy development' => ['name' => 'Pengembangan Strategi', 'items' => ['kepemimpinanStrategis', 'posisiKompetitif'], 'performance' => 0],
            'Value creation' => ['name' => 'Pengembangan Nilai', 'items' => ['kepuasanPelanggan', 'nilaiUmurPelanggan'], 'performance' => 0],
            'Multi-channel integration' => ['name' => 'Manajemen Hubungan Pelanggan', 'items' => ['aksesPelanggan'], 'performance' => 0],
            'Information management' => ['name' => 'Manajemen Informasi', 'items' => ['informasiPelanggan', 'solusiAplikasiPelanggan'], 'performance' => 0],
            'Performance assessment' => ['name' => 'Manajemen Kinerja', 'items' => ['prosesPelanggan', 'standarSDM', 'pelaporanKinerja', 'efisiensiBiaya'], 'performance' => 0],
        ];

        foreach ($processGroups as $key => &$group) {
            $groupItems = $group['items'];
            $totalPerf = 0;
            foreach ($groupItems as $itemId) {
                $itemPerf = collect($performanceData)->firstWhere('id', $itemId)['performance'] ?? 0;
                $totalPerf += $itemPerf;
            }
            $group['performance'] = count($groupItems) > 0 ? round($totalPerf / count($groupItems)) : 0;
        }

        // Overall Score
        $totalWeightedPerformance = collect($performanceData)->sum(function ($item) {
            return $item['performance'] * $item['importance'];
        });
        $totalWeight = collect($performanceData)->sum('importance');
        $overallScore = $totalWeight > 0 ? round($totalWeightedPerformance / $totalWeight) : 0;

        // Recommendation
        $recommendations = [
            'Strategy development' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses pengembangan strategi...",
            'Value creation' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses pengembangan nilai...",
            'Multi-channel integration' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen hubungan dengan pelanggan...",
            'Information management' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen informasi...",
            'Performance assessment' => "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen kinerja...",
        ];

        $lowestPerfGroup = collect($processGroups)->sortBy('performance')->first();
        $recommendation = $recommendations[$lowestPerfGroup ? key($processGroups) : 'Strategy development'];

        return [
            'maturityAverage' => $maturityAverage,
            'maturityInsightData' => $maturityInsightData,
            'performanceData' => $performanceData,
            'processGroupResults' => $processGroups,
            'overallScore' => $overallScore,
            'recommendation' => $recommendation,
        ];
    }
}