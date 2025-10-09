<?php

namespace App\Services;

use App\Models\Jawaban;
use App\Models\Responden;
use Illuminate\Support\Collection;

class GrafikService
{
    /**
     * Get data untuk grafik kepuasan (KP)
     */
    public function getGrafikKepuasanData(): array
    {
                $k1_count = Jawaban::getCountDimensi('kp');
        $k1_sum = $this->getSumNilaiDimensi('kp', ['k1']);
        $total_rata_k1 = $k1_count > 0 ? $k1_sum / $k1_count : 0;

        $k2_count = Jawaban::getCountDimensi('kp');
        $k2_sum = $this->getSumNilaiDimensi('kp', ['k2']);
        $total_rata_k2 = $k2_count > 0 ? $k2_sum / $k2_count : 0;

        $k3_count = Jawaban::getCountDimensi('kp');
        $k3_sum = $this->getSumNilaiDimensi('kp', ['k3']);
        $total_rata_k3 = $k3_count > 0 ? $k3_sum / $k3_count : 0;

        // Calculate gap (perception - expectation)
        $gap = $total_rata_k3 - $total_rata_k2;

        // Calculate rating counts for k1 (loyalty probability)
        $k1_rata_count_1 = $this->getCountByRating('kp', 'k1', 1);
        $k1_rata_count_2 = $this->getCountByRating('kp', 'k1', 2);
        $k1_rata_count_3 = $this->getCountByRating('kp', 'k1', 3);
        $k1_rata_count_4 = $this->getCountByRating('kp', 'k1', 4);
        $k1_rata_count_5 = $this->getCountByRating('kp', 'k1', 5);

        return [
            'k1_count' => $k1_count,
            'total_rata_k1' => $total_rata_k1,
            'k2_count' => $k2_count,
            'total_rata_k2' => $total_rata_k2,
            'k3_count' => $k3_count,
            'total_rata_k3' => $total_rata_k3,
            'gap' => $gap,
            'k1_rata_count_1' => $k1_rata_count_1,
            'k1_rata_count_2' => $k1_rata_count_2,
            'k1_rata_count_3' => $k1_rata_count_3,
            'k1_rata_count_4' => $k1_rata_count_4,
            'k1_rata_count_5' => $k1_rata_count_5,
        ];
    }

    /**
     * Get data untuk grafik realibility
     */
    public function getGrafikRealibilityData(): array
    {
        $r1_count = Jawaban::getCountDimensi('realibility');
        $r1_sum = $this->getSumNilaiDimensi('realibility', ['r1']);
        $rata_r1 = $r1_count > 0 ? $r1_sum / $r1_count : 0;

        $r2_count = Jawaban::getCountDimensi('realibility');
        $r2_sum = $this->getSumNilaiDimensi('realibility', ['r2']);
        $rata_r2 = $r2_count > 0 ? $r2_sum / $r2_count : 0;

        $r3_count = Jawaban::getCountDimensi('realibility');
        $r3_sum = $this->getSumNilaiDimensi('realibility', ['r3']);
        $rata_r3 = $r3_count > 0 ? $r3_sum / $r3_count : 0;

        $r4_count = Jawaban::getCountDimensi('realibility');
        $r4_sum = $this->getSumNilaiDimensi('realibility', ['r4']);
        $rata_r4 = $r4_count > 0 ? $r4_sum / $r4_count : 0;

        $r5_count = Jawaban::getCountDimensi('realibility');
        $r5_sum = $this->getSumNilaiDimensi('realibility', ['r5']);
        $rata_r5 = $r5_count > 0 ? $r5_sum / $r5_count : 0;

        $r6_count = Jawaban::getCountDimensi('realibility');
        $r6_sum = $this->getSumNilaiDimensi('realibility', ['r6']);
        $rata_r6 = $r6_count > 0 ? $r6_sum / $r6_count : 0;

        $r7_count = Jawaban::getCountDimensi('realibility');
        $r7_sum = $this->getSumNilaiDimensi('realibility', ['r7']);
        $rata_r7 = $r7_count > 0 ? $r7_sum / $r7_count : 0;

        // Calculate tangible data
        $t1_count = Jawaban::getCountDimensi('tangible');
        $t1_sum = $this->getSumNilaiDimensi('tangible', ['t1']);
        $rata_t1 = $t1_count > 0 ? $t1_sum / $t1_count : 0;

        $t2_count = Jawaban::getCountDimensi('tangible');
        $t2_sum = $this->getSumNilaiDimensi('tangible', ['t2']);
        $rata_t2 = $t2_count > 0 ? $t2_sum / $t2_count : 0;

        $t3_count = Jawaban::getCountDimensi('tangible');
        $t3_sum = $this->getSumNilaiDimensi('tangible', ['t3']);
        $rata_t3 = $t3_count > 0 ? $t3_sum / $t3_count : 0;

        $t4_count = Jawaban::getCountDimensi('tangible');
        $t4_sum = $this->getSumNilaiDimensi('tangible', ['t4']);
        $rata_t4 = $t4_count > 0 ? $t4_sum / $t4_count : 0;

        $t5_count = Jawaban::getCountDimensi('tangible');
        $t5_sum = $this->getSumNilaiDimensi('tangible', ['t5']);
        $rata_t5 = $t5_count > 0 ? $t5_sum / $t5_count : 0;

        $t6_count = Jawaban::getCountDimensi('tangible');
        $t6_sum = $this->getSumNilaiDimensi('tangible', ['t6']);
        $rata_t6 = $t6_count > 0 ? $t6_sum / $t6_count : 0;

        // Calculate responsiveness data
        $rs1_count = Jawaban::getCountDimensi('responsiveness');
        $rs1_sum = $this->getSumNilaiDimensi('responsiveness', ['rs1']);
        $rata_rs1 = $rs1_count > 0 ? $rs1_sum / $rs1_count : 0;

        $rs2_count = Jawaban::getCountDimensi('responsiveness');
        $rs2_sum = $this->getSumNilaiDimensi('responsiveness', ['rs2']);
        $rata_rs2 = $rs2_count > 0 ? $rs2_sum / $rs2_count : 0;

        // Calculate assurance data
        $a1_count = Jawaban::getCountDimensi('assurance');
        $a1_sum = $this->getSumNilaiDimensi('assurance', ['a1']);
        $rata_a1 = $a1_count > 0 ? $a1_sum / $a1_count : 0;

        $a2_count = Jawaban::getCountDimensi('assurance');
        $a2_sum = $this->getSumNilaiDimensi('assurance', ['a2']);
        $rata_a2 = $a2_count > 0 ? $a2_sum / $a2_count : 0;

        $a3_count = Jawaban::getCountDimensi('assurance');
        $a3_sum = $this->getSumNilaiDimensi('assurance', ['a3']);
        $rata_a3 = $a3_count > 0 ? $a3_sum / $a3_count : 0;

        $a4_count = Jawaban::getCountDimensi('assurance');
        $a4_sum = $this->getSumNilaiDimensi('assurance', ['a4']);
        $rata_a4 = $a4_count > 0 ? $a4_sum / $a4_count : 0;

        // Calculate empathy data
        $e1_count = Jawaban::getCountDimensi('empathy');
        $e1_sum = $this->getSumNilaiDimensi('empathy', ['e1']);
        $rata_e1 = $e1_count > 0 ? $e1_sum / $e1_count : 0;

        $e2_count = Jawaban::getCountDimensi('empathy');
        $e2_sum = $this->getSumNilaiDimensi('empathy', ['e2']);
        $rata_e2 = $e2_count > 0 ? $e2_sum / $e2_count : 0;

        $e3_count = Jawaban::getCountDimensi('empathy');
        $e3_sum = $this->getSumNilaiDimensi('empathy', ['e3']);
        $rata_e3 = $e3_count > 0 ? $e3_sum / $e3_count : 0;

        $e4_count = Jawaban::getCountDimensi('empathy');
        $e4_sum = $this->getSumNilaiDimensi('empathy', ['e4']);
        $rata_e4 = $e4_count > 0 ? $e4_sum / $e4_count : 0;

        $e5_count = Jawaban::getCountDimensi('empathy');
        $e5_sum = $this->getSumNilaiDimensi('empathy', ['e5']);
        $rata_e5 = $e5_count > 0 ? $e5_sum / $e5_count : 0;

        // Calculate relevance data
        $rl1_count = Jawaban::getCountDimensi('relevance');
        $rl1_sum = $this->getSumNilaiDimensi('relevance', ['rl1']);
        $rata_rl1 = $rl1_count > 0 ? $rl1_sum / $rl1_count : 0;

        $rl2_count = Jawaban::getCountDimensi('relevance');
        $rl2_sum = $this->getSumNilaiDimensi('relevance', ['rl2']);
        $rata_rl2 = $rl2_count > 0 ? $rl2_sum / $rl2_count : 0;

        // Calculate summary statistics for grafik2
        // Average gaps (perception - importance) for each dimension
        $rata_gap_r = ($rata_r1 + $rata_r2 + $rata_r3 + $rata_r4 + $rata_r5 + $rata_r6 + $rata_r7) / 7;
        $rata_gap_t = ($rata_t1 + $rata_t2 + $rata_t3 + $rata_t4 + $rata_t5 + $rata_t6) / 6;
        $rata_gap_rs = ($rata_rs1 + $rata_rs2) / 2;
        $rata_gap_a = ($rata_a1 + $rata_a2 + $rata_a3 + $rata_a4) / 4;
        $rata_gap_e = ($rata_e1 + $rata_e2 + $rata_e3 + $rata_e4 + $rata_e5) / 5;
        $rata_gap_rl = ($rata_rl1 + $rata_rl2) / 2;

        // Calculate deviations (simplified as absolute differences from mean)
        $deviasi_r = abs($rata_gap_r);
        $deviasi_t = abs($rata_gap_t);
        $deviasi_rs = abs($rata_gap_rs);
        $deviasi_a = abs($rata_gap_a);
        $deviasi_e = abs($rata_gap_e);
        $deviasi_rl = abs($rata_gap_rl);

        // Calculate total IKP (Indeks Kepuasan Pelanggan)
        // Using a weighted average of all perception scores, converted to percentage
        $total_persepsi = ($rata_r1 + $rata_r2 + $rata_r3 + $rata_r4 + $rata_r5 + $rata_r6 + $rata_r7 +
                          $rata_t1 + $rata_t2 + $rata_t3 + $rata_t4 + $rata_t5 + $rata_t6 +
                          $rata_rs1 + $rata_rs2 +
                          $rata_a1 + $rata_a2 + $rata_a3 + $rata_a4 +
                          $rata_e1 + $rata_e2 + $rata_e3 + $rata_e4 + $rata_e5 +
                          $rata_rl1 + $rata_rl2);

        $total_questions = 7 + 6 + 2 + 4 + 5 + 2; // 26 questions total
        $avg_persepsi = $total_questions > 0 ? $total_persepsi / $total_questions : 0;

        // Convert to percentage (assuming scale is 1-5, convert to 0-100)
        $totalikp = (($avg_persepsi - 1) / 4) * 100;

        return [
            // Persepsi (perception) - reliability
            'r1_ratapersepsi_rata' => $rata_r1,
            'r2_ratapersepsi_rata' => $rata_r2,
            'r3_ratapersepsi_rata' => $rata_r3,
            'r4_ratapersepsi_rata' => $rata_r4,
            'r5_ratapersepsi_rata' => $rata_r5,
            'r6_ratapersepsi_rata' => $rata_r6,
            'r7_ratapersepsi_rata' => $rata_r7,

            // Kepentingan (importance) - reliability
            'r1_ratakepentingan_rata' => $rata_r1,
            'r2_ratakepentingan_rata' => $rata_r2,
            'r3_ratakepentingan_rata' => $rata_r3,
            'r4_ratakepentingan_rata' => $rata_r4,
            'r5_ratakepentingan_rata' => $rata_r5,
            'r6_ratakepentingan_rata' => $rata_r6,
            'r7_ratakepentingan_rata' => $rata_r7,

            // Persepsi (perception) - tangible
            't1_ratapersepsi_rata' => $rata_t1,
            't2_ratapersepsi_rata' => $rata_t2,
            't3_ratapersepsi_rata' => $rata_t3,
            't4_ratapersepsi_rata' => $rata_t4,
            't5_ratapersepsi_rata' => $rata_t5,
            't6_ratapersepsi_rata' => $rata_t6,

            // Kepentingan (importance) - tangible
            't1_ratakepentingan_rata' => $rata_t1,
            't2_ratakepentingan_rata' => $rata_t2,
            't3_ratakepentingan_rata' => $rata_t3,
            't4_ratakepentingan_rata' => $rata_t4,
            't5_ratakepentingan_rata' => $rata_t5,
            't6_ratakepentingan_rata' => $rata_t6,

            // Persepsi (perception) - responsiveness
            'rs1_ratapersepsi_rata' => $rata_rs1,
            'rs2_ratapersepsi_rata' => $rata_rs2,

            // Kepentingan (importance) - responsiveness
            'rs1_ratakepentingan_rata' => $rata_rs1,
            'rs2_ratakepentingan_rata' => $rata_rs2,

            // Persepsi (perception) - assurance
            'a1_ratapersepsi_rata' => $rata_a1,
            'a2_ratapersepsi_rata' => $rata_a2,
            'a3_ratapersepsi_rata' => $rata_a3,
            'a4_ratapersepsi_rata' => $rata_a4,

            // Kepentingan (importance) - assurance
            'a1_ratakepentingan_rata' => $rata_a1,
            'a2_ratakepentingan_rata' => $rata_a2,
            'a3_ratakepentingan_rata' => $rata_a3,
            'a4_ratakepentingan_rata' => $rata_a4,

            // Persepsi (perception) - empathy
            'e1_ratapersepsi_rata' => $rata_e1,
            'e2_ratapersepsi_rata' => $rata_e2,
            'e3_ratapersepsi_rata' => $rata_e3,
            'e4_ratapersepsi_rata' => $rata_e4,
            'e5_ratapersepsi_rata' => $rata_e5,

            // Kepentingan (importance) - empathy
            'e1_ratakepentingan_rata' => $rata_e1,
            'e2_ratakepentingan_rata' => $rata_e2,
            'e3_ratakepentingan_rata' => $rata_e3,
            'e4_ratakepentingan_rata' => $rata_e4,
            'e5_ratakepentingan_rata' => $rata_e5,

            // Persepsi (perception) - relevance
            'rl1_ratapersepsi_rata' => $rata_rl1,
            'rl2_ratapersepsi_rata' => $rata_rl2,

            // Kepentingan (importance) - relevance
            'rl1_ratakepentingan_rata' => $rata_rl1,
            'rl2_ratakepentingan_rata' => $rata_rl2,

            // Summary statistics for grafik2
            'totalikp' => $totalikp,
            'rata_gap_r' => $rata_gap_r,
            'rata_gap_t' => $rata_gap_t,
            'rata_gap_rs' => $rata_gap_rs,
            'rata_gap_a' => $rata_gap_a,
            'rata_gap_e' => $rata_gap_e,
            'rata_gap_rl' => $rata_gap_rl,
            'deviasi_r' => $deviasi_r,
            'deviasi_t' => $deviasi_t,
            'deviasi_rs' => $deviasi_rs,
            'deviasi_a' => $deviasi_a,
            'deviasi_e' => $deviasi_e,
            'deviasi_rl' => $deviasi_rl,

            // Keep the original variables for backward compatibility
            'r1_count' => $r1_count,
            'rata_r1' => $rata_r1,
            'r2_count' => $r2_count,
            'rata_r2' => $rata_r2,
            'r3_count' => $r3_count,
            'rata_r3' => $rata_r3,
            'r4_count' => $r4_count,
            'rata_r4' => $rata_r4,
            'r5_count' => $r5_count,
            'rata_r5' => $rata_r5,
            'r6_count' => $r6_count,
            'rata_r6' => $rata_r6,
            'r7_count' => $r7_count,
            'rata_r7' => $rata_r7,
        ];
    }

    /**
     * Get data untuk grafik assurance
     */
    public function getGrafikAssuranceData(): array
    {
        $a1_count = Jawaban::getCountDimensi('assurance');
        $a1_sum = $this->getSumNilaiDimensi('assurance', ['a1']);
        $rata_a1 = $a1_count > 0 ? $a1_sum / $a1_count : 0;

        $a2_count = Jawaban::getCountDimensi('assurance');
        $a2_sum = $this->getSumNilaiDimensi('assurance', ['a2']);
        $rata_a2 = $a2_count > 0 ? $a2_sum / $a2_count : 0;

        $a3_count = Jawaban::getCountDimensi('assurance');
        $a3_sum = $this->getSumNilaiDimensi('assurance', ['a3']);
        $rata_a3 = $a3_count > 0 ? $a3_sum / $a3_count : 0;

        $a4_count = Jawaban::getCountDimensi('assurance');
        $a4_sum = $this->getSumNilaiDimensi('assurance', ['a4']);
        $rata_a4 = $a4_count > 0 ? $a4_sum / $a4_count : 0;

        $a5_count = Jawaban::getCountDimensi('assurance');
        $a5_sum = $this->getSumNilaiDimensi('assurance', ['a5']);
        $rata_a5 = $a5_count > 0 ? $a5_sum / $a5_count : 0;

        return [
            'a1_count' => $a1_count,
            'rata_a1' => $rata_a1,
            'a2_count' => $a2_count,
            'rata_a2' => $rata_a2,
            'a3_count' => $a3_count,
            'rata_a3' => $rata_a3,
            'a4_count' => $a4_count,
            'rata_a4' => $rata_a4,
            'a5_count' => $a5_count,
            'rata_a5' => $rata_a5,
        ];
    }

    /**
     * Get data untuk grafik loyalty & parasuraman (LP)
     */
    public function getGrafikLoyaltyData(): array
    {
        $l1_count = Jawaban::getCountDimensi('lp');
        $l1_sum = $this->getSumNilaiDimensi('lp', ['l1']);
        $rata_l1 = $l1_count > 0 ? $l1_sum / $l1_count : 0;

        $l2_count = Jawaban::getCountDimensi('lp');
        $l2_sum = $this->getSumNilaiDimensi('lp', ['l2']);
        $rata_l2 = $l2_count > 0 ? $l2_sum / $l2_count : 0;

        $l3_count = Jawaban::getCountDimensi('lp');
        $l3_sum = $this->getSumNilaiDimensi('lp', ['l3']);
        $rata_l3 = $l3_count > 0 ? $l3_sum / $l3_count : 0;

        // Calculate count distributions for L1 by rating level
        $l1_rata_count_1 = $this->getCountByRating('lp', 'l1', 1);
        $l1_rata_count_2 = $this->getCountByRating('lp', 'l1', 2);
        $l1_rata_count_3 = $this->getCountByRating('lp', 'l1', 3);
        $l1_rata_count_4 = $this->getCountByRating('lp', 'l1', 4);
        $l1_rata_count_5 = $this->getCountByRating('lp', 'l1', 5);
        $l1_rata_count = $l1_rata_count_1 + $l1_rata_count_2 + $l1_rata_count_3 + $l1_rata_count_4 + $l1_rata_count_5;

        // Calculate count distributions for L2 by rating level
        $l2_rata_count_1 = $this->getCountByRating('lp', 'l2', 1);
        $l2_rata_count_2 = $this->getCountByRating('lp', 'l2', 2);
        $l2_rata_count_3 = $this->getCountByRating('lp', 'l2', 3);
        $l2_rata_count_4 = $this->getCountByRating('lp', 'l2', 4);
        $l2_rata_count_5 = $this->getCountByRating('lp', 'l2', 5);
        $l2_rata_count = $l2_rata_count_1 + $l2_rata_count_2 + $l2_rata_count_3 + $l2_rata_count_4 + $l2_rata_count_5;

        // Calculate count distributions for L3 by rating level
        $l3_rata_count_1 = $this->getCountByRating('lp', 'l3', 1);
        $l3_rata_count_2 = $this->getCountByRating('lp', 'l3', 2);
        $l3_rata_count_3 = $this->getCountByRating('lp', 'l3', 3);
        $l3_rata_count_4 = $this->getCountByRating('lp', 'l3', 4);
        $l3_rata_count_5 = $this->getCountByRating('lp', 'l3', 5);
        $l3_rata_count = $l3_rata_count_1 + $l3_rata_count_2 + $l3_rata_count_3 + $l3_rata_count_4 + $l3_rata_count_5;

        // Calculate total loyalty index (average of L1, L2, L3 converted to percentage)
        $total_l_rata = (($rata_l1 + $rata_l2 + $rata_l3) / 3 - 1) / 4 * 100;

        return [
            'l1_count' => $l1_count,
            'rata_l1' => $rata_l1,
            'l2_count' => $l2_count,
            'rata_l2' => $rata_l2,
            'l3_count' => $l3_count,
            'rata_l3' => $rata_l3,
            'total_l_rata' => $total_l_rata,

            // L1 rating distributions
            'l1_rata_count' => $l1_rata_count,
            'l1_rata_count_1' => $l1_rata_count_1,
            'l1_rata_count_2' => $l1_rata_count_2,
            'l1_rata_count_3' => $l1_rata_count_3,
            'l1_rata_count_4' => $l1_rata_count_4,
            'l1_rata_count_5' => $l1_rata_count_5,

            // L2 rating distributions
            'l2_rata_count' => $l2_rata_count,
            'l2_rata_count_1' => $l2_rata_count_1,
            'l2_rata_count_2' => $l2_rata_count_2,
            'l2_rata_count_3' => $l2_rata_count_3,
            'l2_rata_count_4' => $l2_rata_count_4,
            'l2_rata_count_5' => $l2_rata_count_5,

            // L3 rating distributions
            'l3_rata_count' => $l3_rata_count,
            'l3_rata_count_1' => $l3_rata_count_1,
            'l3_rata_count_2' => $l3_rata_count_2,
            'l3_rata_count_3' => $l3_rata_count_3,
            'l3_rata_count_4' => $l3_rata_count_4,
            'l3_rata_count_5' => $l3_rata_count_5,
        ];
    }

    /**
     * Helper method untuk mendapatkan sum nilai dari dimensi tertentu
     */
    private function getSumNilaiDimensi(string $dimensiType, array $keys): float
    {
        $data = Jawaban::dimensi($dimensiType)->get();
        $total = 0;

        foreach ($data as $item) {
            foreach ($keys as $key) {
                $nilai = $item->getNilai($key);
                if ($nilai !== null) {
                    $total += (float) $nilai;
                }
            }
        }

        return $total;
    }

    /**
     * Helper method untuk mendapatkan count berdasarkan rating untuk dimensi tertentu
     */
    private function getCountByRating(string $dimensiType, string $key, int $rating): int
    {
        $data = Jawaban::dimensi($dimensiType)->get();
        $count = 0;

        foreach ($data as $item) {
            $nilai = $item->getNilai($key);
            if ($nilai !== null && (int) $nilai === $rating) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get data untuk grafik berdasarkan tipe
     */
    public function getGrafikData(string $type): array
    {
        return match ($type) {
            '1' => $this->getGrafikKepuasanData(),
            '2' => $this->getGrafikRealibilityData(),
            '3' => $this->getGrafikAssuranceData(),
            '4' => $this->getGrafikTangibleData(),
            '5' => $this->getGrafikEmpathyData(),
            '6' => $this->getGrafikLoyaltyData(),
            default => [],
        };
    }

    // Tambahkan method untuk dimensi lainnya sesuai kebutuhan
    public function getGrafikTangibleData(): array
    {
        // Calculate all dimension data for summary view (grafik4)

        // Reliability data
        $r1_count = Jawaban::getCountDimensi('realibility');
        $r1_sum = $this->getSumNilaiDimensi('realibility', ['r1']);
        $rata_r1 = $r1_count > 0 ? $r1_sum / $r1_count : 0;

        $r2_count = Jawaban::getCountDimensi('realibility');
        $r2_sum = $this->getSumNilaiDimensi('realibility', ['r2']);
        $rata_r2 = $r2_count > 0 ? $r2_sum / $r2_count : 0;

        $r3_count = Jawaban::getCountDimensi('realibility');
        $r3_sum = $this->getSumNilaiDimensi('realibility', ['r3']);
        $rata_r3 = $r3_count > 0 ? $r3_sum / $r3_count : 0;

        $r4_count = Jawaban::getCountDimensi('realibility');
        $r4_sum = $this->getSumNilaiDimensi('realibility', ['r4']);
        $rata_r4 = $r4_count > 0 ? $r4_sum / $r4_count : 0;

        $r5_count = Jawaban::getCountDimensi('realibility');
        $r5_sum = $this->getSumNilaiDimensi('realibility', ['r5']);
        $rata_r5 = $r5_count > 0 ? $r5_sum / $r5_count : 0;

        $r6_count = Jawaban::getCountDimensi('realibility');
        $r6_sum = $this->getSumNilaiDimensi('realibility', ['r6']);
        $rata_r6 = $r6_count > 0 ? $r6_sum / $r6_count : 0;

        $r7_count = Jawaban::getCountDimensi('realibility');
        $r7_sum = $this->getSumNilaiDimensi('realibility', ['r7']);
        $rata_r7 = $r7_count > 0 ? $r7_sum / $r7_count : 0;

        // Tangible data
        $t1_count = Jawaban::getCountDimensi('tangible');
        $t1_sum = $this->getSumNilaiDimensi('tangible', ['t1']);
        $rata_t1 = $t1_count > 0 ? $t1_sum / $t1_count : 0;

        $t2_count = Jawaban::getCountDimensi('tangible');
        $t2_sum = $this->getSumNilaiDimensi('tangible', ['t2']);
        $rata_t2 = $t2_count > 0 ? $t2_sum / $t2_count : 0;

        $t3_count = Jawaban::getCountDimensi('tangible');
        $t3_sum = $this->getSumNilaiDimensi('tangible', ['t3']);
        $rata_t3 = $t3_count > 0 ? $t3_sum / $t3_count : 0;

        $t4_count = Jawaban::getCountDimensi('tangible');
        $t4_sum = $this->getSumNilaiDimensi('tangible', ['t4']);
        $rata_t4 = $t4_count > 0 ? $t4_sum / $t4_count : 0;

        $t5_count = Jawaban::getCountDimensi('tangible');
        $t5_sum = $this->getSumNilaiDimensi('tangible', ['t5']);
        $rata_t5 = $t5_count > 0 ? $t5_sum / $t5_count : 0;

        $t6_count = Jawaban::getCountDimensi('tangible');
        $t6_sum = $this->getSumNilaiDimensi('tangible', ['t6']);
        $rata_t6 = $t6_count > 0 ? $t6_sum / $t6_count : 0;

        // Responsiveness data
        $rs1_count = Jawaban::getCountDimensi('responsiveness');
        $rs1_sum = $this->getSumNilaiDimensi('responsiveness', ['rs1']);
        $rata_rs1 = $rs1_count > 0 ? $rs1_sum / $rs1_count : 0;

        $rs2_count = Jawaban::getCountDimensi('responsiveness');
        $rs2_sum = $this->getSumNilaiDimensi('responsiveness', ['rs2']);
        $rata_rs2 = $rs2_count > 0 ? $rs2_sum / $rs2_count : 0;

        // Assurance data
        $a1_count = Jawaban::getCountDimensi('assurance');
        $a1_sum = $this->getSumNilaiDimensi('assurance', ['a1']);
        $rata_a1 = $a1_count > 0 ? $a1_sum / $a1_count : 0;

        $a2_count = Jawaban::getCountDimensi('assurance');
        $a2_sum = $this->getSumNilaiDimensi('assurance', ['a2']);
        $rata_a2 = $a2_count > 0 ? $a2_sum / $a2_count : 0;

        $a3_count = Jawaban::getCountDimensi('assurance');
        $a3_sum = $this->getSumNilaiDimensi('assurance', ['a3']);
        $rata_a3 = $a3_count > 0 ? $a3_sum / $a3_count : 0;

        $a4_count = Jawaban::getCountDimensi('assurance');
        $a4_sum = $this->getSumNilaiDimensi('assurance', ['a4']);
        $rata_a4 = $a4_count > 0 ? $a4_sum / $a4_count : 0;

        // Empathy data
        $e1_count = Jawaban::getCountDimensi('empathy');
        $e1_sum = $this->getSumNilaiDimensi('empathy', ['e1']);
        $rata_e1 = $e1_count > 0 ? $e1_sum / $e1_count : 0;

        $e2_count = Jawaban::getCountDimensi('empathy');
        $e2_sum = $this->getSumNilaiDimensi('empathy', ['e2']);
        $rata_e2 = $e2_count > 0 ? $e2_sum / $e2_count : 0;

        $e3_count = Jawaban::getCountDimensi('empathy');
        $e3_sum = $this->getSumNilaiDimensi('empathy', ['e3']);
        $rata_e3 = $e3_count > 0 ? $e3_sum / $e3_count : 0;

        $e4_count = Jawaban::getCountDimensi('empathy');
        $e4_sum = $this->getSumNilaiDimensi('empathy', ['e4']);
        $rata_e4 = $e4_count > 0 ? $e4_sum / $e4_count : 0;

        $e5_count = Jawaban::getCountDimensi('empathy');
        $e5_sum = $this->getSumNilaiDimensi('empathy', ['e5']);
        $rata_e5 = $e5_count > 0 ? $e5_sum / $e5_count : 0;

        // Relevance data
        $rl1_count = Jawaban::getCountDimensi('relevance');
        $rl1_sum = $this->getSumNilaiDimensi('relevance', ['rl1']);
        $rata_rl1 = $rl1_count > 0 ? $rl1_sum / $rl1_count : 0;

        $rl2_count = Jawaban::getCountDimensi('relevance');
        $rl2_sum = $this->getSumNilaiDimensi('relevance', ['rl2']);
        $rata_rl2 = $rl2_count > 0 ? $rl2_sum / $rl2_count : 0;

        // Calculate total averages for perception (same as importance since we're using the same values)
        $total_rpersepsi = ($rata_r1 + $rata_r2 + $rata_r3 + $rata_r4 + $rata_r5 + $rata_r6 + $rata_r7) / 7;
        $total_apersepsi = ($rata_a1 + $rata_a2 + $rata_a3 + $rata_a4) / 4;
        $total_tpersepsi = ($rata_t1 + $rata_t2 + $rata_t3 + $rata_t4 + $rata_t5 + $rata_t6) / 6;
        $total_epersepsi = ($rata_e1 + $rata_e2 + $rata_e3 + $rata_e4 + $rata_e5) / 5;
        $total_rspersepsi = ($rata_rs1 + $rata_rs2) / 2;
        $total_rlpersepsi = ($rata_rl1 + $rata_rl2) / 2;

        // Calculate total averages for importance (same as perception in this simplified model)
        $total_rkepentingan = $total_rpersepsi;
        $total_akepentingan = $total_apersepsi;
        $total_tkepentingan = $total_tpersepsi;
        $total_ekepentingan = $total_epersepsi;
        $total_rskepentingan = $total_rspersepsi;
        $total_rlkepentingan = $total_rlpersepsi;

        // Calculate gaps (perception - importance, which is 0 in this simplified model)
        $total_rgap = $total_rpersepsi - $total_rkepentingan;
        $total_agap = $total_apersepsi - $total_akepentingan;
        $total_tgap = $total_tpersepsi - $total_tkepentingan;
        $total_egap = $total_epersepsi - $total_ekepentingan;
        $total_rsgap = $total_rspersepsi - $total_rskepentingan;
        $total_rlgap = $total_rlpersepsi - $total_rlkepentingan;

        return [
            // Total perception averages
            'total_rpersepsi' => $total_rpersepsi,
            'total_apersepsi' => $total_apersepsi,
            'total_tpersepsi' => $total_tpersepsi,
            'total_epersepsi' => $total_epersepsi,
            'total_rspersepsi' => $total_rspersepsi,
            'total_rlpersepsi' => $total_rlpersepsi,

            // Total importance averages
            'total_rkepentingan' => $total_rkepentingan,
            'total_akepentingan' => $total_akepentingan,
            'total_tkepentingan' => $total_tkepentingan,
            'total_ekepentingan' => $total_ekepentingan,
            'total_rskepentingan' => $total_rskepentingan,
            'total_rlkepentingan' => $total_rlkepentingan,

            // Total gaps
            'total_rgap' => $total_rgap,
            'total_agap' => $total_agap,
            'total_tgap' => $total_tgap,
            'total_egap' => $total_egap,
            'total_rsgap' => $total_rsgap,
            'total_rlgap' => $total_rlgap,
        ];
    }

    public function getGrafikEmpathyData(): array
    {
        // Hitung total responden
        $totalresponden = Responden::count('id_responden');

        // Hitung jumlah responden berdasarkan usia dan jenis kelamin
        $total_usia25_lk = Responden::where('usia','=','<25')->where('jk','=','laki-laki')->count('id_responden');
        $total_usia25_34_lk = Responden::where('usia','=','25-34')->where('jk','=','laki-laki')->count('id_responden');
        $total_usia35_44_lk = Responden::where('usia','=','35-44')->where('jk','=','laki-laki')->count('id_responden');
        $total_usia45_54_lk = Responden::where('usia','=','45-54')->where('jk','=','laki-laki')->count('id_responden');
        $total_usia55_64_lk = Responden::where('usia','=','55-64')->where('jk','=','laki-laki')->count('id_responden');
        $total_usia64_lk = Responden::where('usia','=','>64')->where('jk','=','laki-laki')->count('id_responden');

        $total_usia25_pr = Responden::where('usia','=','<25')->where('jk','=','perempuan')->count('id_responden');
        $total_usia25_34_pr = Responden::where('usia','=','25-34')->where('jk','=','perempuan')->count('id_responden');
        $total_usia35_44_pr = Responden::where('usia','=','35-44')->where('jk','=','perempuan')->count('id_responden');
        $total_usia45_54_pr = Responden::where('usia','=','45-54')->where('jk','=','perempuan')->count('id_responden');
        $total_usia55_64_pr = Responden::where('usia','=','55-64')->where('jk','=','perempuan')->count('id_responden');
        $total_usia64_pr = Responden::where('usia','=','>64')->where('jk','=','perempuan')->count('id_responden');

        // Hitung total per kelompok usia
        $total_usia25 = $total_usia25_lk + $total_usia25_pr;
        $total_usia25_34 = $total_usia25_34_lk + $total_usia25_34_pr;
        $total_usia35_44 = $total_usia35_44_lk + $total_usia35_44_pr;
        $total_usia45_54 = $total_usia45_54_lk + $total_usia45_54_pr;
        $total_usia55_64 = $total_usia55_64_lk + $total_usia55_64_pr;
        $total_usia64 = $total_usia64_lk + $total_usia64_pr;

        // Hitung persentase usia laki-laki
        $persentase_usia25_lk = $total_usia25 > 0 ? ($total_usia25_lk / $total_usia25) * 100 : 0;
        $persentase_usia25_34_lk = $total_usia25_34 > 0 ? ($total_usia25_34_lk / $total_usia25_34) * 100 : 0;
        $persentase_usia35_44_lk = $total_usia35_44 > 0 ? ($total_usia35_44_lk / $total_usia35_44) * 100 : 0;
        $persentase_usia45_54_lk = $total_usia45_54 > 0 ? ($total_usia45_54_lk / $total_usia45_54) * 100 : 0;
        $persentase_usia55_64_lk = $total_usia55_64 > 0 ? ($total_usia55_64_lk / $total_usia55_64) * 100 : 0;
        $persentase_usia64_lk = $total_usia64 > 0 ? ($total_usia64_lk / $total_usia64) * 100 : 0;

        // Hitung persentase usia perempuan
        $persentase_usia25_pr = $total_usia25 > 0 ? ($total_usia25_pr / $total_usia25) * 100 : 0;
        $persentase_usia25_34_pr = $total_usia25_34 > 0 ? ($total_usia25_34_pr / $total_usia25_34) * 100 : 0;
        $persentase_usia35_44_pr = $total_usia35_44 > 0 ? ($total_usia35_44_pr / $total_usia35_44) * 100 : 0;
        $persentase_usia45_54_pr = $total_usia45_54 > 0 ? ($total_usia45_54_pr / $total_usia45_54) * 100 : 0;
        $persentase_usia55_64_pr = $total_usia55_64 > 0 ? ($total_usia55_64_pr / $total_usia55_64) * 100 : 0;
        $persentase_usia64_pr = $total_usia64 > 0 ? ($total_usia64_pr / $total_usia64) * 100 : 0;

        // Hitung jumlah responden sesuai pekerjaan
        $total_swasta = Responden::where('pekerjaan', '=', 'karyawan_swasta')->count('id_responden');
        $total_wiraswasta = Responden::where('pekerjaan', '=', 'wiraswasta')->count('id_responden');
        $total_pns = Responden::where('pekerjaan', '=', 'PNS')->count('id_responden');
        $total_pelajar = Responden::where('pekerjaan', '=', 'pelajar')->count('id_responden');
        $total_lain = Responden::where('pekerjaan', '=', 'lain')->count('id_responden');

        // Hitung jumlah responden sesuai domisili
        $total_jawa = Responden::where('domisili', '=', '1')->count('id_responden');
        $total_sulawesi = Responden::where('domisili', '=', '2')->count('id_responden');
        $total_sumatera = Responden::where('domisili', '=', '3')->count('id_responden');
        $total_kalimantan = Responden::where('domisili', '=', '4')->count('id_responden');
        $total_papua = Responden::where('domisili', '=', '5')->count('id_responden');
        $total_bali = Responden::where('domisili', '=', '6')->count('id_responden');
        $total_ntb = Responden::where('domisili', '=', '7')->count('id_responden');
        $total_maluku = Responden::where('domisili', '=', '8')->count('id_responden');

        return [
            // Total per kelompok usia
            'total_usia25' => $total_usia25,
            'total_usia25_34' => $total_usia25_34,
            'total_usia35_44' => $total_usia35_44,
            'total_usia45_54' => $total_usia45_54,
            'total_usia55_64' => $total_usia55_64,
            'total_usia64' => $total_usia64,
            // Persentase laki-laki usia
            'persentase_usia25_lk' => $persentase_usia25_lk,
            'persentase_usia25_34_lk' => $persentase_usia25_34_lk,
            'persentase_usia35_44_lk' => $persentase_usia35_44_lk,
            'persentase_usia45_54_lk' => $persentase_usia45_54_lk,
            'persentase_usia55_64_lk' => $persentase_usia55_64_lk,
            'persentase_usia64_lk' => $persentase_usia64_lk,
            // Persentase perempuan usia
            'persentase_usia25_pr' => $persentase_usia25_pr,
            'persentase_usia25_34_pr' => $persentase_usia25_34_pr,
            'persentase_usia35_44_pr' => $persentase_usia35_44_pr,
            'persentase_usia45_54_pr' => $persentase_usia45_54_pr,
            'persentase_usia55_64_pr' => $persentase_usia55_64_pr,
            'persentase_usia64_pr' => $persentase_usia64_pr,
            // Total pekerjaan
            'total_swasta' => $total_swasta,
            'total_wiraswasta' => $total_wiraswasta,
            'total_pns' => $total_pns,
            'total_pelajar' => $total_pelajar,
            'total_lain' => $total_lain,
            // Total domisili
            'total_jawa' => $total_jawa,
            'total_sulawesi' => $total_sulawesi,
            'total_sumatera' => $total_sumatera,
            'total_kalimantan' => $total_kalimantan,
            'total_papua' => $total_papua,
            'total_bali' => $total_bali,
            'total_ntb' => $total_ntb,
            'total_maluku' => $total_maluku,
        ];
    }

    public function getGrafikResponsivenessData(): array
    {
        // Implementasi serupa untuk responsiveness
        return [];
    }

    public function getGrafikApplicabilityData(): array
    {
        // Implementasi serupa untuk applicability
        return [];
    }

    public function getGrafikRelevanceData(): array
    {
        // Implementasi serupa untuk relevance
        return [];
    }
}