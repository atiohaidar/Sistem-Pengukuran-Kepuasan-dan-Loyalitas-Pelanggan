<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PelatihanSurveyResponse;
use App\Services\SurveyCalculationService;

class GrafikController extends Controller
{
    protected $surveyService;

    public function __construct(SurveyCalculationService $surveyService)
    {
        $this->surveyService = $surveyService;
    }
   
    public function mean_gap_per_dimensi()
    {
        // Ambil responses dari database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get();

        // Gunakan SurveyCalculationService untuk menghitung rata-rata dan gap
        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
        $gapResults = $this->surveyService->calculateGapAnalysis($responses->toArray());

        // Ekstrak data dari service
        $itemAverages = $ikpResults['item_averages'] ?? [];
        $harapanAverages = $itemAverages['harapan'] ?? [];
        $persepsiAverages = $itemAverages['persepsi'] ?? [];
        $itemGaps = $gapResults['item_gaps'] ?? [];

        // Konfigurasi dimensi untuk menghindari duplikasi
        $dimensionsConfig = [
            [
                'name' => 'Reliability',
                'prefix' => 'r',
                'count' => 7,
                'icon' => 'chart-bar',
                'gradient' => 'from-blue-500 via-purple-500 to-pink-500',
                'headerGradient' => 'from-blue-500 to-purple-600',
                'titleGradient' => 'from-blue-600 to-purple-600',
                'chartId' => 'reliability-chart',
                'loadingId' => 'chart-loading',
                'questions' => [
                    'r1' => 'Kesesuaian isi post test dengan materi pelatihan yang diberikan.',
                    'r2' => 'Ketepatan waktu pelatihan sesuai dengan jadwal yang telah dijanjikan.',
                    'r3' => 'Ketepatan waktu dalam memberikan sertifikat pelatihan.',
                    'r4' => 'Ketepatan trainer dalam menjawab pertanyaan peserta.',
                    'r5' => 'Materi pelatihan mudah dimengerti.',
                    'r6' => 'Kemudahan dalam melakukan registrasi pelatihan.',
                    'r7' => 'Kemudahan dalam melakukan pembayaran pelatihan.',
                ],
            ],
            [
                'name' => 'Tangible',
                'prefix' => 't',
                'count' => 6,
                'icon' => 'building',
                'gradient' => 'from-green-500 via-teal-500 to-cyan-500',
                'headerGradient' => 'from-green-500 to-teal-600',
                'titleGradient' => 'from-green-600 to-teal-600',
                'chartId' => 'tangible-chart',
                'loadingId' => 'tangible-chart-loading',
                'questions' => [
                    't1' => 'Kesesuaian antara materi yang diiklankan dengan yang diberikan.',
                    't2' => 'Kesesuaian antara biaya yang diiklankan dengan yang dikenakan.',
                    't3' => 'Kesesuaian antara jadwal yang diiklankan dengan yang dilaksanakan.',
                    't4' => 'Kesesuaian antara tempat yang diiklankan dengan yang disediakan.',
                    't5' => 'Kesesuaian antara fasilitas yang diiklankan dengan yang disediakan.',
                    't6' => 'Kesesuaian antara sertifikat yang diiklankan dengan yang diberikan.',
                ],
            ],
            [
                'name' => 'Responsiveness',
                'prefix' => 'rs',
                'count' => 2,
                'icon' => 'clock',
                'gradient' => 'from-yellow-500 via-orange-500 to-red-500',
                'headerGradient' => 'from-yellow-500 to-orange-600',
                'titleGradient' => 'from-yellow-600 to-orange-600',
                'chartId' => 'responsiveness-chart',
                'loadingId' => 'responsiveness-chart-loading',
                'questions' => [
                    'rs1' => 'Ketepatan waktu dalam memberikan informasi pelatihan.',
                    'rs2' => 'Ketepatan waktu dalam menanggapi keluhan peserta.',
                ],
            ],
            [
                'name' => 'Assurance',
                'prefix' => 'a',
                'count' => 4,
                'icon' => 'shield-alt',
                'gradient' => 'from-purple-500 via-pink-500 to-rose-500',
                'headerGradient' => 'from-purple-500 to-pink-600',
                'titleGradient' => 'from-purple-600 to-pink-600',
                'chartId' => 'assurance-chart',
                'loadingId' => 'assurance-chart-loading',
                'questions' => [
                    'a1' => 'Kemampuan trainer dalam memberikan penjelasan yang jelas.',
                    'a2' => 'Kemampuan trainer dalam memberikan solusi atas masalah peserta.',
                    'a3' => 'Kepercayaan peserta terhadap kemampuan trainer.',
                    'a4' => 'Kepercayaan peserta terhadap keamanan data pribadi.',
                ],
            ],
            [
                'name' => 'Empathy',
                'prefix' => 'e',
                'count' => 5,
                'icon' => 'heart',
                'gradient' => 'from-red-500 via-pink-500 to-purple-500',
                'headerGradient' => 'from-red-500 to-pink-600',
                'titleGradient' => 'from-red-600 to-pink-600',
                'chartId' => 'empathy-chart',
                'loadingId' => 'empathy-chart-loading',
                'questions' => [
                    'e1' => 'Perhatian trainer terhadap kebutuhan individu peserta.',
                    'e2' => 'Kemampuan trainer dalam memahami masalah peserta.',
                    'e3' => 'Kenyamanan komunikasi dengan trainer.',
                    'e4' => 'Fleksibilitas trainer dalam menyesuaikan metode pembelajaran.',
                    'e5' => 'Perhatian terhadap keragaman latar belakang peserta.',
                ],
            ],
            [
                'name' => 'Applicability',
                'prefix' => 'ap',
                'count' => 2,
                'icon' => 'cogs',
                'gradient' => 'from-indigo-500 via-blue-500 to-cyan-500',
                'headerGradient' => 'from-indigo-500 to-blue-600',
                'titleGradient' => 'from-indigo-600 to-blue-600',
                'chartId' => 'applicability-chart',
                'loadingId' => 'applicability-chart-loading',
                'questions' => [
                    'ap1' => 'Relevansi materi pelatihan dengan pekerjaan peserta.',
                    'ap2' => 'Manfaat praktis dari materi pelatihan yang diberikan.',
                ],
            ],
        ];

        // Map data untuk setiap dimensi menggunakan loop
        $dimensions = [];
        foreach ($dimensionsConfig as $config) {
            $data = [];
            for ($i = 1; $i <= $config['count']; $i++) {
                $key = $config['prefix'] . $i;
                $data[$key . '_ratapersepsi_rata'] = $persepsiAverages[$key] ?? 0;
                $data[$key . '_ratakepentingan_rata'] = $harapanAverages[$key] ?? 0;
            }
            $dimensions[] = array_merge($config, ['data' => $data]);
        }

        return view('grafik.mean-gap-per-dimensi', compact('dimensions'));
    }

    public function profilResponden()
    {
        // Ambil data profil responden
        $responses = PelatihanSurveyResponse::completed()->get();

        // Data untuk chart batang usia berdasarkan gender
        $ageGroups = ['18-25', '26-35', '36-45', '46-55', '56+'];
        $ageData = [];
        foreach ($ageGroups as $group) {
            $ageData[] = [
                'age_group' => $group,
                'male' => $responses->filter(function ($response) use ($group) {
                    $jenisKelamin = $response->profile_data['jenis_kelamin'] ?? '';
                    $usia = $response->profile_data['usia'] ?? 0;
                    return $jenisKelamin === 'L' && $this->getAgeGroup($usia) === $group;
                })->count(),
                'female' => $responses->filter(function ($response) use ($group) {
                    $jenisKelamin = $response->profile_data['jenis_kelamin'] ?? '';
                    $usia = $response->profile_data['usia'] ?? 0;
                    return $jenisKelamin === 'P' && $this->getAgeGroup($usia) === $group;
                })->count(),
            ];
        }

        // Data untuk pie chart jenis kelamin
        $genderData = [
            ['label' => 'Laki-laki', 'value' => $responses->filter(function ($response) {
                return ($response->profile_data['jenis_kelamin'] ?? '') === 'L';
            })->count()],
            ['label' => 'Perempuan', 'value' => $responses->filter(function ($response) {
                return ($response->profile_data['jenis_kelamin'] ?? '') === 'P';
            })->count()],
        ];

        // Data untuk pie chart pekerjaan
        $occupationData = $responses->groupBy(function ($response) {
            return $response->profile_data['pekerjaan'] ?? 'Tidak Diketahui';
        })->map(function ($group) {
            return ['label' => $group->first()->profile_data['pekerjaan'] ?? 'Tidak Diketahui', 'value' => $group->count()];
        })->values()->toArray();

        // Data untuk pie chart domisili
        $domicileData = $responses->groupBy(function ($response) {
            return $response->profile_data['domisili'] ?? 'Tidak Diketahui';
        })->map(function ($group) {
            return ['label' => $group->first()->profile_data['domisili'] ?? 'Tidak Diketahui', 'value' => $group->count()];
        })->values()->toArray();

        return view('grafik.profil-responden', compact('ageData', 'genderData', 'occupationData', 'domicileData'));
    }

    private function getAgeGroup($usia)
    {
        if ($usia >= 18 && $usia <= 25) return '18-25';
        if ($usia >= 26 && $usia <= 35) return '26-35';
        if ($usia >= 36 && $usia <= 45) return '36-45';
        if ($usia >= 46 && $usia <= 55) return '46-55';
        return '56+';
    }

    public function mean_persepsi_harapan_gap_per_dimensi()
    {
        // Ambil responses dari database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get();

        // Gunakan SurveyCalculationService untuk menghitung rata-rata dan gap
        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
        $gapResults = $this->surveyService->calculateGapAnalysis($responses->toArray());

        // Ekstrak data dari service
        $itemAverages = $ikpResults['item_averages'] ?? [];
        $harapanAverages = $itemAverages['harapan'] ?? [];
        $persepsiAverages = $itemAverages['persepsi'] ?? [];
        $itemGaps = $gapResults['item_gaps'] ?? [];

        // Konfigurasi dimensi
        $dimensionsConfig = [
            [
                'name' => 'Reliability',
                'prefix' => 'r',
                'count' => 7,
                'icon' => 'chart-bar',
                'gradient' => 'from-blue-500 via-purple-500 to-pink-500',
                'headerGradient' => 'from-blue-500 to-purple-600',
                'titleGradient' => 'from-blue-600 to-purple-600',
                'chartId' => 'reliability-chart',
                'loadingId' => 'chart-loading',
            ],
            [
                'name' => 'Tangible',
                'prefix' => 't',
                'count' => 6,
                'icon' => 'building',
                'gradient' => 'from-green-500 via-teal-500 to-cyan-500',
                'headerGradient' => 'from-green-500 to-teal-600',
                'titleGradient' => 'from-green-600 to-teal-600',
                'chartId' => 'tangible-chart',
                'loadingId' => 'tangible-chart-loading',
            ],
            [
                'name' => 'Responsiveness',
                'prefix' => 'rs',
                'count' => 2,
                'icon' => 'clock',
                'gradient' => 'from-yellow-500 via-orange-500 to-red-500',
                'headerGradient' => 'from-yellow-500 to-orange-600',
                'titleGradient' => 'from-yellow-600 to-orange-600',
                'chartId' => 'responsiveness-chart',
                'loadingId' => 'responsiveness-chart-loading',
            ],
            [
                'name' => 'Assurance',
                'prefix' => 'a',
                'count' => 4,
                'icon' => 'shield-alt',
                'gradient' => 'from-purple-500 via-pink-500 to-rose-500',
                'headerGradient' => 'from-purple-500 to-pink-600',
                'titleGradient' => 'from-purple-600 to-pink-600',
                'chartId' => 'assurance-chart',
                'loadingId' => 'assurance-chart-loading',
            ],
            [
                'name' => 'Empathy',
                'prefix' => 'e',
                'count' => 5,
                'icon' => 'heart',
                'gradient' => 'from-red-500 via-pink-500 to-purple-500',
                'headerGradient' => 'from-red-500 to-pink-600',
                'titleGradient' => 'from-red-600 to-pink-600',
                'chartId' => 'empathy-chart',
                'loadingId' => 'empathy-chart-loading',
            ],
            [
                'name' => 'Applicability',
                'prefix' => 'ap',
                'count' => 2,
                'icon' => 'cogs',
                'gradient' => 'from-indigo-500 via-blue-500 to-cyan-500',
                'headerGradient' => 'from-indigo-500 to-blue-600',
                'titleGradient' => 'from-indigo-600 to-blue-600',
                'chartId' => 'applicability-chart',
                'loadingId' => 'applicability-chart-loading',
            ],
        ];

        // Hitung rata-rata per dimensi
        $dimensions = [];
        foreach ($dimensionsConfig as $config) {
            $persepsiSum = 0;
            $harapanSum = 0;
            $gapSum = 0;
            $count = $config['count'];

            for ($i = 1; $i <= $count; $i++) {
                $key = $config['prefix'] . $i;
                $persepsiSum += $persepsiAverages[$key] ?? 0;
                $harapanSum += $harapanAverages[$key] ?? 0;
                $gapSum += ($persepsiAverages[$key] ?? 0) - ($harapanAverages[$key] ?? 0);
            }

            $avgPersepsi = $count > 0 ? $persepsiSum / $count : 0;
            $avgHarapan = $count > 0 ? $harapanSum / $count : 0;
            $avgGap = $count > 0 ? $gapSum / $count : 0;

            $dimensions[] = array_merge($config, [
                'avg_persepsi' => $avgPersepsi,
                'avg_harapan' => $avgHarapan,
                'avg_gap' => $avgGap,
            ]);
        }

        return view('grafik.mean-persepsi-harapan-gap-per-dimensi', compact('dimensions'));
    }

    public function rekomendasi()
    {
        // Ambil responses dari database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get();

        // Gunakan SurveyCalculationService untuk menghitung data yang diperlukan
        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
        $gapResults = $this->surveyService->calculateGapAnalysis($responses->toArray());

        // Ekstrak data dari service
        $dimensionAverages = $ikpResults['dimension_averages'] ?? [];
        $dimensionGaps = $gapResults['dimension_gaps'] ?? [];
        $gapStatistics = $gapResults['gap_statistics'] ?? [];
        $ikpPercentage = $ikpResults['ikp_percentage'] ?? 0;
        $ikpInterpretation = $ikpResults['ikp_interpretation'] ?? '';

        // Konfigurasi dimensi
        $dimensionsConfig = [
            [
                'name' => 'Reliability',
                'prefix' => 'reliability',
                'icon' => 'chart-bar',
                'gradient' => 'from-blue-500 via-purple-500 to-pink-500',
                'headerGradient' => 'from-blue-500 to-purple-600',
                'titleGradient' => 'from-blue-600 to-purple-600',
                'chartId' => 'reliability-gap-chart',
                'loadingId' => 'reliability-gap-loading',
            ],
            [
                'name' => 'Tangible',
                'prefix' => 'tangible',
                'icon' => 'building',
                'gradient' => 'from-green-500 via-teal-500 to-cyan-500',
                'headerGradient' => 'from-green-500 to-teal-600',
                'titleGradient' => 'from-green-600 to-teal-600',
                'chartId' => 'tangible-gap-chart',
                'loadingId' => 'tangible-gap-loading',
            ],
            [
                'name' => 'Responsiveness',
                'prefix' => 'responsiveness',
                'icon' => 'clock',
                'gradient' => 'from-yellow-500 via-orange-500 to-red-500',
                'headerGradient' => 'from-yellow-500 to-orange-600',
                'titleGradient' => 'from-yellow-600 to-orange-600',
                'chartId' => 'responsiveness-gap-chart',
                'loadingId' => 'responsiveness-gap-loading',
            ],
            [
                'name' => 'Assurance',
                'prefix' => 'assurance',
                'icon' => 'shield-alt',
                'gradient' => 'from-purple-500 via-pink-500 to-rose-500',
                'headerGradient' => 'from-purple-500 to-pink-600',
                'titleGradient' => 'from-purple-600 to-pink-600',
                'chartId' => 'assurance-gap-chart',
                'loadingId' => 'assurance-gap-loading',
            ],
            [
                'name' => 'Empathy',
                'prefix' => 'empathy',
                'icon' => 'heart',
                'gradient' => 'from-red-500 via-pink-500 to-purple-500',
                'headerGradient' => 'from-red-500 to-pink-600',
                'titleGradient' => 'from-red-600 to-pink-600',
                'chartId' => 'empathy-gap-chart',
                'loadingId' => 'empathy-gap-loading',
            ],
            [
                'name' => 'Applicability',
                'prefix' => 'applicability',
                'icon' => 'cogs',
                'gradient' => 'from-indigo-500 via-blue-500 to-cyan-500',
                'headerGradient' => 'from-indigo-500 to-blue-600',
                'titleGradient' => 'from-indigo-600 to-blue-600',
                'chartId' => 'applicability-gap-chart',
                'loadingId' => 'applicability-gap-loading',
            ],
        ];

        // Siapkan data untuk chart gap per dimensi
        $gapData = [];
        foreach ($dimensionsConfig as $config) {
            $gapData[$config['prefix']] = $dimensionGaps[$config['prefix']] ?? 0;
        }

        // Siapkan data untuk chart standar deviasi (dummy data berdasarkan dimensi)
        $stdDevData = [];
        $baseStdDev = $gapStatistics['standard_deviation'] ?? 0.5;
        foreach ($dimensionsConfig as $config) {
            // Variasi standar deviasi berdasarkan dimensi
            $variation = (ord(substr($config['prefix'], 0, 1)) - ord('a')) * 0.1;
            $stdDevData[$config['prefix']] = max(0.1, $baseStdDev + $variation);
        }

        return view('grafik.rekomendasi', compact('dimensionsConfig', 'gapData', 'stdDevData', 'ikpPercentage', 'ikpInterpretation'));
    }

    public function kepuasan()
    {
        // Ambil responses dari database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get();

        // Gunakan SurveyCalculationService untuk menghitung data yang diperlukan
        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
        $gapResults = $this->surveyService->calculateGapAnalysis($responses->toArray());
        $ilpResults = $this->surveyService->calculateILP($responses->toArray());

        // Ekstrak data dari service
        $dimensionGaps = $gapResults['dimension_gaps'] ?? [];
        $ikpPercentage = $ikpResults['ikp_percentage'] ?? 0;
        $ilpPercentage = $ilpResults['ilp_percentage'] ?? 0;

        // Hitung rata-rata kepuasan untuk pertanyaan k1 dan k2
        $kepuasanK1 = [];
        $kepuasanK2 = [];

        foreach ($responses as $response) {
            if (isset($response['kepuasan_answers']['k1'])) {
                $kepuasanK1[] = $response['kepuasan_answers']['k1'];
            }
            if (isset($response['kepuasan_answers']['k2'])) {
                $kepuasanK2[] = $response['kepuasan_answers']['k2'];
            }
        }

        $avgK1 = count($kepuasanK1) > 0 ? array_sum($kepuasanK1) / count($kepuasanK1) : 0;
        $avgK2 = count($kepuasanK2) > 0 ? array_sum($kepuasanK2) / count($kepuasanK2) : 0;

        // Hitung total rata-rata K3 (layanan ideal) dan K2 (harapan)
        $total_rata_k3 = $avgK1; // K3 adalah pertanyaan kepuasan pertama (layanan ideal)
        $total_rata_k2 = $avgK2; // K2 adalah pertanyaan kepuasan kedua (harapan)
        $gap = $total_rata_k3 - $total_rata_k2; // Gap antara ideal dan harapan

        // Hitung distribusi kepuasan
        $k1_count = count($kepuasanK1);
        $k1_rata_count_1 = 0; // Tidak puas
        $k1_rata_count_2 = 0; // Kurang puas
        $k1_rata_count_3 = 0; // Cukup puas
        $k1_rata_count_4 = 0; // Puas
        $k1_rata_count_5 = 0; // Sangat puas

        foreach ($kepuasanK1 as $score) {
            if ($score >= 4.5) $k1_rata_count_5++;
            elseif ($score >= 3.5) $k1_rata_count_4++;
            elseif ($score >= 2.5) $k1_rata_count_3++;
            elseif ($score >= 1.5) $k1_rata_count_2++;
            else $k1_rata_count_1++;
        }

        $kepuasanDistribution = [
            'sangat_puas' => $k1_rata_count_5,
            'puas' => $k1_rata_count_4,
            'cukup_puas' => $k1_rata_count_3,
            'kurang_puas' => $k1_rata_count_2,
            'tidak_puas' => $k1_rata_count_1
        ];

        // Hitung potensi loyalitas
        $loyalitasScores = [];
        foreach ($responses as $response) {
            if (isset($response['loyalitas_answers'])) {
                $loyalitas = $response['loyalitas_answers'];
                $avgLoyalitas = 0;
                $count = 0;
                if (isset($loyalitas['l1'])) { $avgLoyalitas += $loyalitas['l1']; $count++; }
                if (isset($loyalitas['l2'])) { $avgLoyalitas += $loyalitas['l2']; $count++; }
                if (isset($loyalitas['l3'])) { $avgLoyalitas += $loyalitas['l3']; $count++; }
                if ($count > 0) {
                    $loyalitasScores[] = $avgLoyalitas / $count;
                }
            }
        }

        $potensiLoyal = 0;
        foreach ($loyalitasScores as $score) {
            if ($score >= 4.0) $potensiLoyal++; // Berpotensi loyal jika skor >= 4
        }

        return view('grafik.kepuasan', compact(
            'gap',
            'total_rata_k3',
            'total_rata_k2',
            'avgK1',
            'avgK2',
            'k1_count',
            'k1_rata_count_1',
            'k1_rata_count_2',
            'k1_rata_count_3',
            'k1_rata_count_4',
            'k1_rata_count_5',
            'kepuasanDistribution',
            'ikpPercentage',
            'ilpPercentage',
            'potensiLoyal',
            'responses'
        ));
    }

    public function loyalitas()
    {
        // Ambil responses dari database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get();

        // Gunakan SurveyCalculationService untuk menghitung ILP
        $ilpResults = $this->surveyService->calculateILP($responses->toArray());

        // Hitung rata-rata per pertanyaan loyalitas
        $l1Scores = [];
        $l2Scores = [];
        $l3Scores = [];

        foreach ($responses as $response) {
            if (isset($response['loyalitas_answers'])) {
                $loyalitas = $response['loyalitas_answers'];
                if (isset($loyalitas['l1'])) $l1Scores[] = $loyalitas['l1'];
                if (isset($loyalitas['l2'])) $l2Scores[] = $loyalitas['l2'];
                if (isset($loyalitas['l3'])) $l3Scores[] = $loyalitas['l3'];
            }
        }

        $avgL1 = count($l1Scores) > 0 ? array_sum($l1Scores) / count($l1Scores) : 0;
        $avgL2 = count($l2Scores) > 0 ? array_sum($l2Scores) / count($l2Scores) : 0;
        $avgL3 = count($l3Scores) > 0 ? array_sum($l3Scores) / count($l3Scores) : 0;

        // Hitung distribusi untuk setiap pertanyaan
        $l1Distribution = $this->calculateDistribution($l1Scores);
        $l2Distribution = $this->calculateDistribution($l2Scores);
        $l3Distribution = $this->calculateDistribution($l3Scores);

        // Data ILP
        $ilpPercentage = $ilpResults['ilp_percentage'] ?? 0;
        $ilpInterpretation = $ilpResults['ilp_interpretation'] ?? '';

        return view('grafik.loyalitas', compact(
            'avgL1',
            'avgL2', 
            'avgL3',
            'l1Distribution',
            'l2Distribution',
            'l3Distribution',
            'ilpPercentage',
            'ilpInterpretation',
            'responses'
        ));
    }

    private function calculateDistribution($scores)
    {
        $distribution = [
            'sangat_setuju' => 0,
            'setuju' => 0,
            'netral' => 0,
            'tidak_setuju' => 0,
            'sangat_tidak_setuju' => 0
        ];

        foreach ($scores as $score) {
            if ($score >= 4.5) $distribution['sangat_setuju']++;
            elseif ($score >= 3.5) $distribution['setuju']++;
            elseif ($score >= 2.5) $distribution['netral']++;
            elseif ($score >= 1.5) $distribution['tidak_setuju']++;
            else $distribution['sangat_tidak_setuju']++;
        }

        return $distribution;
    }

   
}