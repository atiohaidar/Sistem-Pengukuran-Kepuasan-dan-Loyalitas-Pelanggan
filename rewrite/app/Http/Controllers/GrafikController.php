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
        $dimensionsConfig = $this->surveyService->getDimensionsConfig();

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
        $dimensionsConfig = $this->surveyService->getDimensionsConfig();

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
        $dimensionsConfig = $this->surveyService->getDimensionsConfigForGap();

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
        $kepuasanDetails = $this->surveyService->calculateKepuasanDetails($responses->toArray());

        // Ekstrak data dari service
        $dimensionGaps = $gapResults['dimension_gaps'] ?? [];
        $ikpPercentage = $ikpResults['ikp_percentage'] ?? 0;
        $ilpPercentage = $ilpResults['ilp_percentage'] ?? 0;

        return view('grafik.kepuasan', compact(
            'ikpPercentage',
            'ilpPercentage',
            'responses'
        ) + $kepuasanDetails);
    }

    public function loyalitas()
    {
        // Ambil responses dari database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get();

        // Gunakan SurveyCalculationService untuk menghitung ILP
        $ilpResults = $this->surveyService->calculateILP($responses->toArray());
        $loyalitasDetails = $this->surveyService->calculateLoyalitasDetails($responses->toArray());

        // Data ILP
        $ilpPercentage = $ilpResults['ilp_percentage'] ?? 0;
        $ilpInterpretation = $ilpResults['ilp_interpretation'] ?? '';

        return view('grafik.loyalitas', compact(
            'ilpPercentage',
            'ilpInterpretation',
            'responses'
        ) + $loyalitasDetails);
    }

   
}