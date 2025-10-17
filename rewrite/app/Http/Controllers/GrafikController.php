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

   
}