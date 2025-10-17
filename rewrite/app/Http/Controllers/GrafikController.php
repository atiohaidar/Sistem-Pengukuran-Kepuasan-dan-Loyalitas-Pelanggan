<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PelatihanSurveyResponse;

class GrafikController extends Controller
{
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
        // Query untuk menghitung rata-rata persepsi dan harapan per indikator
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get();

        $totals = [
            // Reliability (R1-R7)
            'r1_persepsi' => 0, 'r1_harapan' => 0, 'r1_count' => 0,
            'r2_persepsi' => 0, 'r2_harapan' => 0, 'r2_count' => 0,
            'r3_persepsi' => 0, 'r3_harapan' => 0, 'r3_count' => 0,
            'r4_persepsi' => 0, 'r4_harapan' => 0, 'r4_count' => 0,
            'r5_persepsi' => 0, 'r5_harapan' => 0, 'r5_count' => 0,
            'r6_persepsi' => 0, 'r6_harapan' => 0, 'r6_count' => 0,
            'r7_persepsi' => 0, 'r7_harapan' => 0, 'r7_count' => 0,
            // Tangible (T1-T6)
            't1_persepsi' => 0, 't1_harapan' => 0, 't1_count' => 0,
            't2_persepsi' => 0, 't2_harapan' => 0, 't2_count' => 0,
            't3_persepsi' => 0, 't3_harapan' => 0, 't3_count' => 0,
            't4_persepsi' => 0, 't4_harapan' => 0, 't4_count' => 0,
            't5_persepsi' => 0, 't5_harapan' => 0, 't5_count' => 0,
            't6_persepsi' => 0, 't6_harapan' => 0, 't6_count' => 0,
            // Responsiveness (RS1-RS2)
            'rs1_persepsi' => 0, 'rs1_harapan' => 0, 'rs1_count' => 0,
            'rs2_persepsi' => 0, 'rs2_harapan' => 0, 'rs2_count' => 0,
            // Assurance (A1-A4)
            'a1_persepsi' => 0, 'a1_harapan' => 0, 'a1_count' => 0,
            'a2_persepsi' => 0, 'a2_harapan' => 0, 'a2_count' => 0,
            'a3_persepsi' => 0, 'a3_harapan' => 0, 'a3_count' => 0,
            'a4_persepsi' => 0, 'a4_harapan' => 0, 'a4_count' => 0,
            // Empathy (E1-E5)
            'e1_persepsi' => 0, 'e1_harapan' => 0, 'e1_count' => 0,
            'e2_persepsi' => 0, 'e2_harapan' => 0, 'e2_count' => 0,
            'e3_persepsi' => 0, 'e3_harapan' => 0, 'e3_count' => 0,
            'e4_persepsi' => 0, 'e4_harapan' => 0, 'e4_count' => 0,
            'e5_persepsi' => 0, 'e5_harapan' => 0, 'e5_count' => 0,
            // Applicability (AP1-AP2)
            'ap1_persepsi' => 0, 'ap1_harapan' => 0, 'ap1_count' => 0,
            'ap2_persepsi' => 0, 'ap2_harapan' => 0, 'ap2_count' => 0,
        ];

        foreach ($responses as $response) {
            $harapan = $response->harapan_answers ?? [];
            $persepsi = $response->persepsi_answers ?? [];

            // Reliability
            for ($i = 1; $i <= 7; $i++) {
                $key = 'r' . $i;
                if (isset($harapan['reliability'][$key])) {
                    $totals[$key . '_harapan'] += $harapan['reliability'][$key];
                    $totals[$key . '_count']++;
                }
                if (isset($persepsi['reliability'][$key])) {
                    $totals[$key . '_persepsi'] += $persepsi['reliability'][$key];
                }
            }

            // Tangible
            for ($i = 1; $i <= 6; $i++) {
                $key = 't' . $i;
                if (isset($harapan['tangible'][$key])) {
                    $totals[$key . '_harapan'] += $harapan['tangible'][$key];
                    $totals[$key . '_count']++;
                }
                if (isset($persepsi['tangible'][$key])) {
                    $totals[$key . '_persepsi'] += $persepsi['tangible'][$key];
                }
            }

            // Responsiveness
            for ($i = 1; $i <= 2; $i++) {
                $key = 'rs' . $i;
                if (isset($harapan['responsiveness'][$key])) {
                    $totals[$key . '_harapan'] += $harapan['responsiveness'][$key];
                    $totals[$key . '_count']++;
                }
                if (isset($persepsi['responsiveness'][$key])) {
                    $totals[$key . '_persepsi'] += $persepsi['responsiveness'][$key];
                }
            }

            // Assurance
            for ($i = 1; $i <= 4; $i++) {
                $key = 'a' . $i;
                if (isset($harapan['assurance'][$key])) {
                    $totals[$key . '_harapan'] += $harapan['assurance'][$key];
                    $totals[$key . '_count']++;
                }
                if (isset($persepsi['assurance'][$key])) {
                    $totals[$key . '_persepsi'] += $persepsi['assurance'][$key];
                }
            }

            // Empathy
            for ($i = 1; $i <= 5; $i++) {
                $key = 'e' . $i;
                if (isset($harapan['empathy'][$key])) {
                    $totals[$key . '_harapan'] += $harapan['empathy'][$key];
                    $totals[$key . '_count']++;
                }
                if (isset($persepsi['empathy'][$key])) {
                    $totals[$key . '_persepsi'] += $persepsi['empathy'][$key];
                }
            }

            // Applicability
            for ($i = 1; $i <= 2; $i++) {
                $key = 'ap' . $i;
                if (isset($harapan['applicability'][$key])) {
                    $totals[$key . '_harapan'] += $harapan['applicability'][$key];
                    $totals[$key . '_count']++;
                }
                if (isset($persepsi['applicability'][$key])) {
                    $totals[$key . '_persepsi'] += $persepsi['applicability'][$key];
                }
            }
        }

        // Hitung rata-rata
        $averages = [];
        foreach ($totals as $key => $value) {
            if (str_ends_with($key, '_count')) {
                $base = str_replace('_count', '', $key);
                $count = $value;
                if ($count > 0) {
                    $averages[$base . '_ratakepentingan_rata'] = $totals[$base . '_harapan'] / $count;
                    $averages[$base . '_ratapersepsi_rata'] = $totals[$base . '_persepsi'] / $count;
                } else {
                    $averages[$base . '_ratakepentingan_rata'] = 0;
                    $averages[$base . '_ratapersepsi_rata'] = 0;
                }
            }
        }

        return $averages;
    }
}