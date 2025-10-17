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
    public function testCalculateAverages()
    {
        return $this->calculateAverages();
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

        // Map data untuk Reliability (R1-R7)
        $reliabilityData = [];
        for ($i = 1; $i <= 7; $i++) {
            $key = 'r' . $i;
            $reliabilityData[$key . '_ratapersepsi_rata'] = $persepsiAverages[$key] ?? 0;
            $reliabilityData[$key . '_ratakepentingan_rata'] = $harapanAverages[$key] ?? 0;
        }

        // Map data untuk Tangible (T1-T6)
        $tangibleData = [];
        for ($i = 1; $i <= 6; $i++) {
            $key = 't' . $i;
            $tangibleData[$key . '_ratapersepsi_rata'] = $persepsiAverages[$key] ?? 0;
            $tangibleData[$key . '_ratakepentingan_rata'] = $harapanAverages[$key] ?? 0;
        }

        // Map data untuk Responsiveness (RS1-RS2)
        $responsivenessData = [];
        for ($i = 1; $i <= 2; $i++) {
            $key = 'rs' . $i;
            $responsivenessData[$key . '_ratapersepsi_rata'] = $persepsiAverages[$key] ?? 0;
            $responsivenessData[$key . '_ratakepentingan_rata'] = $harapanAverages[$key] ?? 0;
        }

        // Map data untuk Assurance (A1-A4)
        $assuranceData = [];
        for ($i = 1; $i <= 4; $i++) {
            $key = 'a' . $i;
            $assuranceData[$key . '_ratapersepsi_rata'] = $persepsiAverages[$key] ?? 0;
            $assuranceData[$key . '_ratakepentingan_rata'] = $harapanAverages[$key] ?? 0;
        }

        // Map data untuk Empathy (E1-E5)
        $empathyData = [];
        for ($i = 1; $i <= 5; $i++) {
            $key = 'e' . $i;
            $empathyData[$key . '_ratapersepsi_rata'] = $persepsiAverages[$key] ?? 0;
            $empathyData[$key . '_ratakepentingan_rata'] = $harapanAverages[$key] ?? 0;
        }

        // Map data untuk Applicability (AP1-AP2)
        $applicabilityData = [];
        for ($i = 1; $i <= 2; $i++) {
            $key = 'ap' . $i;
            $applicabilityData[$key . '_ratapersepsi_rata'] = $persepsiAverages[$key] ?? 0;
            $applicabilityData[$key . '_ratakepentingan_rata'] = $harapanAverages[$key] ?? 0;
        }

        // Soal untuk Reliability
        $reliabilityQuestions = [
            'r1' => 'Kesesuaian isi post test dengan materi pelatihan yang diberikan.',
            'r2' => 'Ketepatan waktu pelatihan sesuai dengan jadwal yang telah dijanjikan.',
            'r3' => 'Ketepatan waktu dalam memberikan sertifikat pelatihan.',
            'r4' => 'Ketepatan trainer dalam menjawab pertanyaan peserta.',
            'r5' => 'Materi pelatihan mudah dimengerti.',
            'r6' => 'Kemudahan dalam melakukan registrasi pelatihan.',
            'r7' => 'Kemudahan dalam melakukan pembayaran pelatihan.',
        ];

        // Soal untuk Tangible
        $tangibleQuestions = [
            't1' => 'Kesesuaian antara materi yang diiklankan dengan yang diberikan.',
            't2' => 'Kesesuaian antara biaya yang diiklankan dengan yang dikenakan.',
            't3' => 'Kesesuaian antara jadwal yang diiklankan dengan yang dilaksanakan.',
            't4' => 'Kesesuaian antara tempat yang diiklankan dengan yang disediakan.',
            't5' => 'Kesesuaian antara fasilitas yang diiklankan dengan yang disediakan.',
            't6' => 'Kesesuaian antara sertifikat yang diiklankan dengan yang diberikan.',
        ];

        // Soal untuk Responsiveness
        $responsivenessQuestions = [
            'rs1' => 'Ketepatan waktu dalam memberikan informasi pelatihan.',
            'rs2' => 'Ketepatan waktu dalam menanggapi keluhan peserta.',
        ];

        // Soal untuk Assurance
        $assuranceQuestions = [
            'a1' => 'Kemampuan trainer dalam memberikan penjelasan yang jelas.',
            'a2' => 'Kemampuan trainer dalam memberikan solusi atas masalah peserta.',
            'a3' => 'Kepercayaan peserta terhadap kemampuan trainer.',
            'a4' => 'Kepercayaan peserta terhadap keamanan data pribadi.',
        ];

        // Soal untuk Empathy
        $empathyQuestions = [
            'e1' => 'Perhatian trainer terhadap kebutuhan individu peserta.',
            'e2' => 'Kemampuan trainer dalam memahami masalah peserta.',
            'e3' => 'Kenyamanan komunikasi dengan trainer.',
            'e4' => 'Fleksibilitas trainer dalam menyesuaikan metode pembelajaran.',
            'e5' => 'Perhatian terhadap keragaman latar belakang peserta.',
        ];

        // Soal untuk Applicability
        $applicabilityQuestions = [
            'ap1' => 'Relevansi materi pelatihan dengan pekerjaan peserta.',
            'ap2' => 'Manfaat praktis dari materi pelatihan yang diberikan.',
        ];

        return view('grafik.mean-gap-per-dimensi', compact(
            'reliabilityData', 'reliabilityQuestions',
            'tangibleData', 'tangibleQuestions',
            'responsivenessData', 'responsivenessQuestions',
            'assuranceData', 'assuranceQuestions',
            'empathyData', 'empathyQuestions',
            'applicabilityData', 'applicabilityQuestions'
        ));
    }

    private function calculateAverages()
    {
        // Ambil responses dari database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get();

        // Gunakan SurveyCalculationService untuk menghitung rata-rata
        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());

        // Ekstrak item averages dan map ke format yang diharapkan view
        $itemAverages = $ikpResults['item_averages'] ?? [];
        $harapanAverages = $itemAverages['harapan'] ?? [];
        $persepsiAverages = $itemAverages['persepsi'] ?? [];

        // Map ke format lama untuk kompatibilitas view
        $averages = [];
        foreach ($harapanAverages as $item => $harapanAvg) {
            $averages[$item . '_ratakepentingan_rata'] = $harapanAvg;
        }
        foreach ($persepsiAverages as $item => $persepsiAvg) {
            $averages[$item . '_ratapersepsi_rata'] = $persepsiAvg;
        }

        return $averages;
    }
}