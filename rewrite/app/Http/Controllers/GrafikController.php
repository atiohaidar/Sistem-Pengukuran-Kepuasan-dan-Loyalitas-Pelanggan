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
    public function index3()
    {
        // Ambil data rata-rata persepsi, harapan, dan gap per indikator dari database
        $data = $this->calculateAverages();

        return view('grafik.index3', compact('data'));
    }

    public function mean_gap_per_dimensi()
    {
        // Ambil data rata-rata persepsi, harapan, dan gap untuk dimensi Reliability
        $data = $this->calculateAverages();

        // Filter hanya untuk Reliability (R1-R7)
        $reliabilityData = [
            'r1_ratapersepsi_rata' => $data['r1_ratapersepsi_rata'] ?? 0,
            'r1_ratakepentingan_rata' => $data['r1_ratakepentingan_rata'] ?? 0,
            'r2_ratapersepsi_rata' => $data['r2_ratapersepsi_rata'] ?? 0,
            'r2_ratakepentingan_rata' => $data['r2_ratakepentingan_rata'] ?? 0,
            'r3_ratapersepsi_rata' => $data['r3_ratapersepsi_rata'] ?? 0,
            'r3_ratakepentingan_rata' => $data['r3_ratakepentingan_rata'] ?? 0,
            'r4_ratapersepsi_rata' => $data['r4_ratapersepsi_rata'] ?? 0,
            'r4_ratakepentingan_rata' => $data['r4_ratakepentingan_rata'] ?? 0,
            'r5_ratapersepsi_rata' => $data['r5_ratapersepsi_rata'] ?? 0,
            'r5_ratakepentingan_rata' => $data['r5_ratakepentingan_rata'] ?? 0,
            'r6_ratapersepsi_rata' => $data['r6_ratapersepsi_rata'] ?? 0,
            'r6_ratakepentingan_rata' => $data['r6_ratakepentingan_rata'] ?? 0,
            'r7_ratapersepsi_rata' => $data['r7_ratapersepsi_rata'] ?? 0,
            'r7_ratakepentingan_rata' => $data['r7_ratakepentingan_rata'] ?? 0,
        ];

        // Filter untuk Tangible (T1-T6)
        $tangibleData = [
            't1_ratapersepsi_rata' => $data['t1_ratapersepsi_rata'] ?? 0,
            't1_ratakepentingan_rata' => $data['t1_ratakepentingan_rata'] ?? 0,
            't2_ratapersepsi_rata' => $data['t2_ratapersepsi_rata'] ?? 0,
            't2_ratakepentingan_rata' => $data['t2_ratakepentingan_rata'] ?? 0,
            't3_ratapersepsi_rata' => $data['t3_ratapersepsi_rata'] ?? 0,
            't3_ratakepentingan_rata' => $data['t3_ratakepentingan_rata'] ?? 0,
            't4_ratapersepsi_rata' => $data['t4_ratapersepsi_rata'] ?? 0,
            't4_ratakepentingan_rata' => $data['t4_ratakepentingan_rata'] ?? 0,
            't5_ratapersepsi_rata' => $data['t5_ratapersepsi_rata'] ?? 0,
            't5_ratakepentingan_rata' => $data['t5_ratakepentingan_rata'] ?? 0,
            't6_ratapersepsi_rata' => $data['t6_ratapersepsi_rata'] ?? 0,
            't6_ratakepentingan_rata' => $data['t6_ratakepentingan_rata'] ?? 0,
        ];

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

        return view('grafik.mean-gap-per-dimensi', compact('reliabilityData', 'reliabilityQuestions', 'tangibleData', 'tangibleQuestions'));
    }

    private function calculateAverages()
    {
        // Query untuk mengambil responses
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get();

        // Gunakan SurveyCalculationService untuk menghitung IKP dan mendapatkan item averages
        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());

        $itemAverages = $ikpResults['item_averages'] ?? ['harapan' => [], 'persepsi' => []];

        // Mapping hasil dari service ke format yang diharapkan view
        $averages = [];

        // Reliability (R1-R7)
        for ($i = 1; $i <= 7; $i++) {
            $key = 'r' . $i;
            $averages[$key . '_ratakepentingan_rata'] = $itemAverages['harapan'][$key] ?? 0;
            $averages[$key . '_ratapersepsi_rata'] = $itemAverages['persepsi'][$key] ?? 0;
        }

        // Tangible (T1-T6)
        for ($i = 1; $i <= 6; $i++) {
            $key = 't' . $i;
            $averages[$key . '_ratakepentingan_rata'] = $itemAverages['harapan'][$key] ?? 0;
            $averages[$key . '_ratapersepsi_rata'] = $itemAverages['persepsi'][$key] ?? 0;
        }

        // Responsiveness (RS1-RS2)
        for ($i = 1; $i <= 2; $i++) {
            $key = 'rs' . $i;
            $averages[$key . '_ratakepentingan_rata'] = $itemAverages['harapan'][$key] ?? 0;
            $averages[$key . '_ratapersepsi_rata'] = $itemAverages['persepsi'][$key] ?? 0;
        }

        // Assurance (A1-A4)
        for ($i = 1; $i <= 4; $i++) {
            $key = 'a' . $i;
            $averages[$key . '_ratakepentingan_rata'] = $itemAverages['harapan'][$key] ?? 0;
            $averages[$key . '_ratapersepsi_rata'] = $itemAverages['persepsi'][$key] ?? 0;
        }

        // Empathy (E1-E5)
        for ($i = 1; $i <= 5; $i++) {
            $key = 'e' . $i;
            $averages[$key . '_ratakepentingan_rata'] = $itemAverages['harapan'][$key] ?? 0;
            $averages[$key . '_ratapersepsi_rata'] = $itemAverages['persepsi'][$key] ?? 0;
        }

        // Applicability (AP1-AP2)
        for ($i = 1; $i <= 2; $i++) {
            $key = 'ap' . $i;
            $averages[$key . '_ratakepentingan_rata'] = $itemAverages['harapan'][$key] ?? 0;
            $averages[$key . '_ratapersepsi_rata'] = $itemAverages['persepsi'][$key] ?? 0;
        }

        return $averages;
    }
}