<?php

namespace App\Services;

use App\Calculators\SurveyCalculator;
use App\Models\Jawaban;
use App\Models\Responden;
use Illuminate\Support\Collection;

class GrafikService
{
    protected SurveyCalculator $calculator;

    public function __construct(SurveyCalculator $calculator)
    {
        $this->calculator = $calculator;
    }
    public function getGrafikKepuasanData(): array
    {
            $k1_count = Jawaban::getCountDimensi('kp');
        $k1_sum = $this->getSumNilaiDimensi('kp', ['k1']);
        $total_rata_k1 = $this->calculator->calculateAverage($k1_sum, $k1_count);

        $k2_count = Jawaban::getCountDimensi('kp');
        $k2_sum = $this->getSumNilaiDimensi('kp', ['k2']);
        $total_rata_k2 = $this->calculator->calculateAverage($k2_sum, $k2_count);

        $k3_count = Jawaban::getCountDimensi('kp');
        $k3_sum = $this->getSumNilaiDimensi('kp', ['k3']);
        $total_rata_k3 = $this->calculator->calculateAverage($k3_sum, $k3_count);

        // Calculate gap using calculator
        $gap = $this->calculator->calculateGap($total_rata_k3, $total_rata_k2);

        // Calculate rating counts for k1 (loyalty probability)
        $k1_rata_count_1 = $this->getCountByRating('kp', 'k1', 1);
        $k1_rata_count_2 = $this->getCountByRating('kp', 'k1', 2);
        $k1_rata_count_3 = $this->getCountByRating('kp', 'k1', 3);
        $k1_rata_count_4 = $this->getCountByRating('kp', 'k1', 4);
        $k1_rata_count_5 = $this->getCountByRating('kp', 'k1', 5);

        // Calculate loyalty probability using calculator
        $loyaltyData = $this->calculator->calculateLoyaltyProbability(
            [$k1_rata_count_1, $k1_rata_count_2, $k1_rata_count_3, $k1_rata_count_4, $k1_rata_count_5],
            $k1_count
        );

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
            // Add loyalty probability data
            'loyalty_probability' => $loyaltyData['total_probability'],
            'loyalty_percentages' => $loyaltyData['percentages'],
            'loyalty_weighted_sums' => $loyaltyData['weighted_sums'],
            'loyalty_frequency_weighteds' => $loyaltyData['frequency_weighteds'],
        ];
    }

    /**
     * Get data untuk grafik realibility
     */
    public function getGrafikRealibilityData(): array
    {
        // Calculate reliability data using calculator
        $r1_count = Jawaban::getCountDimensi('realibility');
        $r1_sum = $this->getSumNilaiDimensi('realibility', ['r1']);
        $rata_r1 = $this->calculator->calculateDimensionAverage($r1_sum, $r1_count);

        $r2_count = Jawaban::getCountDimensi('realibility');
        $r2_sum = $this->getSumNilaiDimensi('realibility', ['r2']);
        $rata_r2 = $this->calculator->calculateDimensionAverage($r2_sum, $r2_count);

        $r3_count = Jawaban::getCountDimensi('realibility');
        $r3_sum = $this->getSumNilaiDimensi('realibility', ['r3']);
        $rata_r3 = $this->calculator->calculateDimensionAverage($r3_sum, $r3_count);

        $r4_count = Jawaban::getCountDimensi('realibility');
        $r4_sum = $this->getSumNilaiDimensi('realibility', ['r4']);
        $rata_r4 = $this->calculator->calculateDimensionAverage($r4_sum, $r4_count);

        $r5_count = Jawaban::getCountDimensi('realibility');
        $r5_sum = $this->getSumNilaiDimensi('realibility', ['r5']);
        $rata_r5 = $this->calculator->calculateDimensionAverage($r5_sum, $r5_count);

        $r6_count = Jawaban::getCountDimensi('realibility');
        $r6_sum = $this->getSumNilaiDimensi('realibility', ['r6']);
        $rata_r6 = $this->calculator->calculateDimensionAverage($r6_sum, $r6_count);

        $r7_count = Jawaban::getCountDimensi('realibility');
        $r7_sum = $this->getSumNilaiDimensi('realibility', ['r7']);
        $rata_r7 = $this->calculator->calculateDimensionAverage($r7_sum, $r7_count);

        // Calculate tangible data using calculator
        $t1_count = Jawaban::getCountDimensi('tangible');
        $t1_sum = $this->getSumNilaiDimensi('tangible', ['t1']);
        $rata_t1 = $this->calculator->calculateDimensionAverage($t1_sum, $t1_count);

        $t2_count = Jawaban::getCountDimensi('tangible');
        $t2_sum = $this->getSumNilaiDimensi('tangible', ['t2']);
        $rata_t2 = $this->calculator->calculateDimensionAverage($t2_sum, $t2_count);

        $t3_count = Jawaban::getCountDimensi('tangible');
        $t3_sum = $this->getSumNilaiDimensi('tangible', ['t3']);
        $rata_t3 = $this->calculator->calculateDimensionAverage($t3_sum, $t3_count);

        $t4_count = Jawaban::getCountDimensi('tangible');
        $t4_sum = $this->getSumNilaiDimensi('tangible', ['t4']);
        $rata_t4 = $this->calculator->calculateDimensionAverage($t4_sum, $t4_count);

        $t5_count = Jawaban::getCountDimensi('tangible');
        $t5_sum = $this->getSumNilaiDimensi('tangible', ['t5']);
        $rata_t5 = $this->calculator->calculateDimensionAverage($t5_sum, $t5_count);

        $t6_count = Jawaban::getCountDimensi('tangible');
        $t6_sum = $this->getSumNilaiDimensi('tangible', ['t6']);
        $rata_t6 = $this->calculator->calculateDimensionAverage($t6_sum, $t6_count);

        // Calculate responsiveness data using calculator
        $rs1_count = Jawaban::getCountDimensi('responsiveness');
        $rs1_sum = $this->getSumNilaiDimensi('responsiveness', ['rs1']);
        $rata_rs1 = $this->calculator->calculateDimensionAverage($rs1_sum, $rs1_count);

        $rs2_count = Jawaban::getCountDimensi('responsiveness');
        $rs2_sum = $this->getSumNilaiDimensi('responsiveness', ['rs2']);
        $rata_rs2 = $this->calculator->calculateDimensionAverage($rs2_sum, $rs2_count);

        // Calculate assurance data using calculator
        $a1_count = Jawaban::getCountDimensi('assurance');
        $a1_sum = $this->getSumNilaiDimensi('assurance', ['a1']);
        $rata_a1 = $this->calculator->calculateDimensionAverage($a1_sum, $a1_count);

        $a2_count = Jawaban::getCountDimensi('assurance');
        $a2_sum = $this->getSumNilaiDimensi('assurance', ['a2']);
        $rata_a2 = $this->calculator->calculateDimensionAverage($a2_sum, $a2_count);

        $a3_count = Jawaban::getCountDimensi('assurance');
        $a3_sum = $this->getSumNilaiDimensi('assurance', ['a3']);
        $rata_a3 = $this->calculator->calculateDimensionAverage($a3_sum, $a3_count);

        $a4_count = Jawaban::getCountDimensi('assurance');
        $a4_sum = $this->getSumNilaiDimensi('assurance', ['a4']);
        $rata_a4 = $this->calculator->calculateDimensionAverage($a4_sum, $a4_count);

        // Calculate empathy data using calculator
        $e1_count = Jawaban::getCountDimensi('empathy');
        $e1_sum = $this->getSumNilaiDimensi('empathy', ['e1']);
        $rata_e1 = $this->calculator->calculateDimensionAverage($e1_sum, $e1_count);

        $e2_count = Jawaban::getCountDimensi('empathy');
        $e2_sum = $this->getSumNilaiDimensi('empathy', ['e2']);
        $rata_e2 = $this->calculator->calculateDimensionAverage($e2_sum, $e2_count);

        $e3_count = Jawaban::getCountDimensi('empathy');
        $e3_sum = $this->getSumNilaiDimensi('empathy', ['e3']);
        $rata_e3 = $this->calculator->calculateDimensionAverage($e3_sum, $e3_count);

        $e4_count = Jawaban::getCountDimensi('empathy');
        $e4_sum = $this->getSumNilaiDimensi('empathy', ['e4']);
        $rata_e4 = $this->calculator->calculateDimensionAverage($e4_sum, $e4_count);

        $e5_count = Jawaban::getCountDimensi('empathy');
        $e5_sum = $this->getSumNilaiDimensi('empathy', ['e5']);
        $rata_e5 = $this->calculator->calculateDimensionAverage($e5_sum, $e5_count);

        // Calculate relevance data using calculator
        $rl1_count = Jawaban::getCountDimensi('relevance');
        $rl1_sum = $this->getSumNilaiDimensi('relevance', ['rl1']);
        $rata_rl1 = $this->calculator->calculateDimensionAverage($rl1_sum, $rl1_count);

        $rl2_count = Jawaban::getCountDimensi('relevance');
        $rl2_sum = $this->getSumNilaiDimensi('relevance', ['rl2']);
        $rata_rl2 = $this->calculator->calculateDimensionAverage($rl2_sum, $rl2_count);

        // Calculate summary statistics for grafik2 using calculator
        // Average gaps (perception - importance) for each dimension
        $rata_gap_r = $this->calculator->calculateGapAverage([$rata_r1, $rata_r2, $rata_r3, $rata_r4, $rata_r5, $rata_r6, $rata_r7]);
        $rata_gap_t = $this->calculator->calculateGapAverage([$rata_t1, $rata_t2, $rata_t3, $rata_t4, $rata_t5, $rata_t6]);
        $rata_gap_rs = $this->calculator->calculateGapAverage([$rata_rs1, $rata_rs2]);
        $rata_gap_a = $this->calculator->calculateGapAverage([$rata_a1, $rata_a2, $rata_a3, $rata_a4]);
        $rata_gap_e = $this->calculator->calculateGapAverage([$rata_e1, $rata_e2, $rata_e3, $rata_e4, $rata_e5]);
        $rata_gap_rl = $this->calculator->calculateGapAverage([$rata_rl1, $rata_rl2]);

        // Calculate deviations using calculator
        $deviasi_r = $this->calculator->calculateDeviation($rata_gap_r, $rata_gap_r);
        $deviasi_t = $this->calculator->calculateDeviation($rata_gap_t, $rata_gap_t);
        $deviasi_rs = $this->calculator->calculateDeviation($rata_gap_rs, $rata_gap_rs);
        $deviasi_a = $this->calculator->calculateDeviation($rata_gap_a, $rata_gap_a);
        $deviasi_e = $this->calculator->calculateDeviation($rata_gap_e, $rata_gap_e);
        $deviasi_rl = $this->calculator->calculateDeviation($rata_gap_rl, $rata_gap_rl);

        // Calculate total IKP using calculator
        $all_perception_values = [
            $rata_r1, $rata_r2, $rata_r3, $rata_r4, $rata_r5, $rata_r6, $rata_r7,
            $rata_t1, $rata_t2, $rata_t3, $rata_t4, $rata_t5, $rata_t6,
            $rata_rs1, $rata_rs2,
            $rata_a1, $rata_a2, $rata_a3, $rata_a4,
            $rata_e1, $rata_e2, $rata_e3, $rata_e4, $rata_e5,
            $rata_rl1, $rata_rl2
        ];
        $totalikp = $this->calculator->calculateTotalIKP($all_perception_values);

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
        $rata_a1 = $this->calculator->calculateDimensionAverage($a1_sum, $a1_count);

        $a2_count = Jawaban::getCountDimensi('assurance');
        $a2_sum = $this->getSumNilaiDimensi('assurance', ['a2']);
        $rata_a2 = $this->calculator->calculateDimensionAverage($a2_sum, $a2_count);

        $a3_count = Jawaban::getCountDimensi('assurance');
        $a3_sum = $this->getSumNilaiDimensi('assurance', ['a3']);
        $rata_a3 = $this->calculator->calculateDimensionAverage($a3_sum, $a3_count);

        $a4_count = Jawaban::getCountDimensi('assurance');
        $a4_sum = $this->getSumNilaiDimensi('assurance', ['a4']);
        $rata_a4 = $this->calculator->calculateDimensionAverage($a4_sum, $a4_count);

        $a5_count = Jawaban::getCountDimensi('assurance');
        $a5_sum = $this->getSumNilaiDimensi('assurance', ['a5']);
        $rata_a5 = $this->calculator->calculateDimensionAverage($a5_sum, $a5_count);

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
        $rata_l1 = $this->calculator->calculateAverage($l1_sum, $l1_count);

        $l2_count = Jawaban::getCountDimensi('lp');
        $l2_sum = $this->getSumNilaiDimensi('lp', ['l2']);
        $rata_l2 = $this->calculator->calculateAverage($l2_sum, $l2_count);

        $l3_count = Jawaban::getCountDimensi('lp');
        $l3_sum = $this->getSumNilaiDimensi('lp', ['l3']);
        $rata_l3 = $this->calculator->calculateAverage($l3_sum, $l3_count);

        // Calculate rating counts for L1
        $l1_rata_count_1 = $this->getCountByRating('lp', 'l1', 1);
        $l1_rata_count_2 = $this->getCountByRating('lp', 'l1', 2);
        $l1_rata_count_3 = $this->getCountByRating('lp', 'l1', 3);
        $l1_rata_count_4 = $this->getCountByRating('lp', 'l1', 4);
        $l1_rata_count_5 = $this->getCountByRating('lp', 'l1', 5);
        $l1_rata_count = $l1_rata_count_1 + $l1_rata_count_2 + $l1_rata_count_3 + $l1_rata_count_4 + $l1_rata_count_5;

        // Calculate rating counts for L2
        $l2_rata_count_1 = $this->getCountByRating('lp', 'l2', 1);
        $l2_rata_count_2 = $this->getCountByRating('lp', 'l2', 2);
        $l2_rata_count_3 = $this->getCountByRating('lp', 'l2', 3);
        $l2_rata_count_4 = $this->getCountByRating('lp', 'l2', 4);
        $l2_rata_count_5 = $this->getCountByRating('lp', 'l2', 5);
        $l2_rata_count = $l2_rata_count_1 + $l2_rata_count_2 + $l2_rata_count_3 + $l2_rata_count_4 + $l2_rata_count_5;

        // Calculate rating counts for L3
        $l3_rata_count_1 = $this->getCountByRating('lp', 'l3', 1);
        $l3_rata_count_2 = $this->getCountByRating('lp', 'l3', 2);
        $l3_rata_count_3 = $this->getCountByRating('lp', 'l3', 3);
        $l3_rata_count_4 = $this->getCountByRating('lp', 'l3', 4);
        $l3_rata_count_5 = $this->getCountByRating('lp', 'l3', 5);
        $l3_rata_count = $l3_rata_count_1 + $l3_rata_count_2 + $l3_rata_count_3 + $l3_rata_count_4 + $l3_rata_count_5;

        // Calculate loyalty probability for L1 using calculator
        $l1_rating_counts = [$l1_rata_count_1, $l1_rata_count_2, $l1_rata_count_3, $l1_rata_count_4, $l1_rata_count_5];
        $l1_probability_data = $this->calculator->calculateLoyaltyProbability($l1_rating_counts, $l1_rata_count);

        // Calculate loyalty probability for L2 using calculator
        $l2_rating_counts = [$l2_rata_count_1, $l2_rata_count_2, $l2_rata_count_3, $l2_rata_count_4, $l2_rata_count_5];
        $l2_probability_data = $this->calculator->calculateLoyaltyProbability($l2_rating_counts, $l2_rata_count);

        // Calculate loyalty probability for L3 using calculator
        $l3_rating_counts = [$l3_rata_count_1, $l3_rata_count_2, $l3_rata_count_3, $l3_rata_count_4, $l3_rata_count_5];
        $l3_probability_data = $this->calculator->calculateLoyaltyProbability($l3_rating_counts, $l3_rata_count);

        // Calculate total loyalty index using calculator
        $total_l_rata = $this->calculator->calculateLoyaltyIndex($rata_l1, $rata_l2, $rata_l3);

        return [
            'l1_count' => $l1_count,
            'rata_l1' => $rata_l1,
            'l2_count' => $l2_count,
            'rata_l2' => $rata_l2,
            'l3_count' => $l3_count,
            'rata_l3' => $rata_l3,
            'total_l_rata' => $total_l_rata,

            // L1 rating distributions and probability data
            'l1_rata_count' => $l1_rata_count,
            'l1_rata_count_1' => $l1_rata_count_1,
            'l1_rata_count_2' => $l1_rata_count_2,
            'l1_rata_count_3' => $l1_rata_count_3,
            'l1_rata_count_4' => $l1_rata_count_4,
            'l1_rata_count_5' => $l1_rata_count_5,
            'l1_probability_data' => $l1_probability_data,

            // L2 rating distributions and probability data
            'l2_rata_count' => $l2_rata_count,
            'l2_rata_count_1' => $l2_rata_count_1,
            'l2_rata_count_2' => $l2_rata_count_2,
            'l2_rata_count_3' => $l2_rata_count_3,
            'l2_rata_count_4' => $l2_rata_count_4,
            'l2_rata_count_5' => $l2_rata_count_5,
            'l2_probability_data' => $l2_probability_data,

            // L3 rating distributions and probability data
            'l3_rata_count' => $l3_rata_count,
            'l3_rata_count_1' => $l3_rata_count_1,
            'l3_rata_count_2' => $l3_rata_count_2,
            'l3_rata_count_3' => $l3_rata_count_3,
            'l3_rata_count_4' => $l3_rata_count_4,
            'l3_rata_count_5' => $l3_rata_count_5,
            'l3_probability_data' => $l3_probability_data,
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
     * Helper method untuk menghitung statistik dimensi (count, sum, average)
     */
    private function calculateDimensionStats(string $dimensiType, array $keys): array
    {
        $count = Jawaban::getCountDimensi($dimensiType);
        $sum = $this->getSumNilaiDimensi($dimensiType, $keys);
        $average = $this->calculator->calculateDimensionAverage($sum, $count);

        return [
            'count' => $count,
            'sum' => $sum,
            'average' => $average
        ];
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

        // Reliability data using calculator
        $r1_stats = $this->calculateDimensionStats('realibility', ['r1']);
        $rata_r1 = $r1_stats['average'];

        $r2_stats = $this->calculateDimensionStats('realibility', ['r2']);
        $rata_r2 = $r2_stats['average'];

        $r3_stats = $this->calculateDimensionStats('realibility', ['r3']);
        $rata_r3 = $r3_stats['average'];

        $r4_stats = $this->calculateDimensionStats('realibility', ['r4']);
        $rata_r4 = $r4_stats['average'];

        $r5_stats = $this->calculateDimensionStats('realibility', ['r5']);
        $rata_r5 = $r5_stats['average'];

        $r6_stats = $this->calculateDimensionStats('realibility', ['r6']);
        $rata_r6 = $r6_stats['average'];

        $r7_stats = $this->calculateDimensionStats('realibility', ['r7']);
        $rata_r7 = $r7_stats['average'];

        // Tangible data using calculator
        $t1_stats = $this->calculateDimensionStats('tangible', ['t1']);
        $rata_t1 = $t1_stats['average'];

        $t2_stats = $this->calculateDimensionStats('tangible', ['t2']);
        $rata_t2 = $t2_stats['average'];

        $t3_stats = $this->calculateDimensionStats('tangible', ['t3']);
        $rata_t3 = $t3_stats['average'];

        $t4_stats = $this->calculateDimensionStats('tangible', ['t4']);
        $rata_t4 = $t4_stats['average'];

        $t5_stats = $this->calculateDimensionStats('tangible', ['t5']);
        $rata_t5 = $t5_stats['average'];

        $t6_stats = $this->calculateDimensionStats('tangible', ['t6']);
        $rata_t6 = $t6_stats['average'];

        // Responsiveness data using calculator
        $rs1_stats = $this->calculateDimensionStats('responsiveness', ['rs1']);
        $rata_rs1 = $rs1_stats['average'];

        $rs2_stats = $this->calculateDimensionStats('responsiveness', ['rs2']);
        $rata_rs2 = $rs2_stats['average'];

        // Assurance data using calculator
        $a1_stats = $this->calculateDimensionStats('assurance', ['a1']);
        $rata_a1 = $a1_stats['average'];

        $a2_stats = $this->calculateDimensionStats('assurance', ['a2']);
        $rata_a2 = $a2_stats['average'];

        $a3_stats = $this->calculateDimensionStats('assurance', ['a3']);
        $rata_a3 = $a3_stats['average'];

        $a4_stats = $this->calculateDimensionStats('assurance', ['a4']);
        $rata_a4 = $a4_stats['average'];

        // Empathy data using calculator
        $e1_stats = $this->calculateDimensionStats('empathy', ['e1']);
        $rata_e1 = $e1_stats['average'];

        $e2_stats = $this->calculateDimensionStats('empathy', ['e2']);
        $rata_e2 = $e2_stats['average'];

        $e3_stats = $this->calculateDimensionStats('empathy', ['e3']);
        $rata_e3 = $e3_stats['average'];

        $e4_stats = $this->calculateDimensionStats('empathy', ['e4']);
        $rata_e4 = $e4_stats['average'];

        $e5_stats = $this->calculateDimensionStats('empathy', ['e5']);
        $rata_e5 = $e5_stats['average'];

        // Relevance data using calculator
        $rl1_stats = $this->calculateDimensionStats('relevance', ['rl1']);
        $rata_rl1 = $rl1_stats['average'];

        $rl2_stats = $this->calculateDimensionStats('relevance', ['rl2']);
        $rata_rl2 = $rl2_stats['average'];

        // Calculate total averages for perception (same as importance since we're using the same values)
        $total_rpersepsi = $this->calculator->calculateDimensionGroupAverage([$rata_r1, $rata_r2, $rata_r3, $rata_r4, $rata_r5, $rata_r6, $rata_r7]);
        $total_apersepsi = $this->calculator->calculateDimensionGroupAverage([$rata_a1, $rata_a2, $rata_a3, $rata_a4]);
        $total_tpersepsi = $this->calculator->calculateDimensionGroupAverage([$rata_t1, $rata_t2, $rata_t3, $rata_t4, $rata_t5, $rata_t6]);
        $total_epersepsi = $this->calculator->calculateDimensionGroupAverage([$rata_e1, $rata_e2, $rata_e3, $rata_e4, $rata_e5]);
        $total_rspersepsi = $this->calculator->calculateDimensionGroupAverage([$rata_rs1, $rata_rs2]);
        $total_rlpersepsi = $this->calculator->calculateDimensionGroupAverage([$rata_rl1, $rata_rl2]);

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
        // Usia <25
        $total_usia25_lk = Responden::whereRaw('CAST(usia AS INTEGER) < 25')->where('jk','=','L')->count('id_responden');
        $total_usia25_pr = Responden::whereRaw('CAST(usia AS INTEGER) < 25')->where('jk','=','P')->count('id_responden');

        // Usia 25-34
        $total_usia25_34_lk = Responden::whereRaw('CAST(usia AS INTEGER) BETWEEN 25 AND 34')->where('jk','=','L')->count('id_responden');
        $total_usia25_34_pr = Responden::whereRaw('CAST(usia AS INTEGER) BETWEEN 25 AND 34')->where('jk','=','P')->count('id_responden');

        // Usia 35-44
        $total_usia35_44_lk = Responden::whereRaw('CAST(usia AS INTEGER) BETWEEN 35 AND 44')->where('jk','=','L')->count('id_responden');
        $total_usia35_44_pr = Responden::whereRaw('CAST(usia AS INTEGER) BETWEEN 35 AND 44')->where('jk','=','P')->count('id_responden');

        // Usia 45-54
        $total_usia45_54_lk = Responden::whereRaw('CAST(usia AS INTEGER) BETWEEN 45 AND 54')->where('jk','=','L')->count('id_responden');
        $total_usia45_54_pr = Responden::whereRaw('CAST(usia AS INTEGER) BETWEEN 45 AND 54')->where('jk','=','P')->count('id_responden');

        // Usia 55-64
        $total_usia55_64_lk = Responden::whereRaw('CAST(usia AS INTEGER) BETWEEN 55 AND 64')->where('jk','=','L')->count('id_responden');
        $total_usia55_64_pr = Responden::whereRaw('CAST(usia AS INTEGER) BETWEEN 55 AND 64')->where('jk','=','P')->count('id_responden');

        // Usia >64
        $total_usia64_lk = Responden::whereRaw('CAST(usia AS INTEGER) > 64')->where('jk','=','L')->count('id_responden');
        $total_usia64_pr = Responden::whereRaw('CAST(usia AS INTEGER) > 64')->where('jk','=','P')->count('id_responden');

        // Hitung total per kelompok usia
        $total_usia25 = $total_usia25_lk + $total_usia25_pr;
        $total_usia25_34 = $total_usia25_34_lk + $total_usia25_34_pr;
        $total_usia35_44 = $total_usia35_44_lk + $total_usia35_44_pr;
        $total_usia45_54 = $total_usia45_54_lk + $total_usia45_54_pr;
        $total_usia55_64 = $total_usia55_64_lk + $total_usia55_64_pr;
        $total_usia64 = $total_usia64_lk + $total_usia64_pr;

        // Hitung persentase usia laki-laki
        $persentase_usia25_lk = $this->calculator->calculatePercentage($total_usia25_lk, $total_usia25);
        $persentase_usia25_34_lk = $this->calculator->calculatePercentage($total_usia25_34_lk, $total_usia25_34);
        $persentase_usia35_44_lk = $this->calculator->calculatePercentage($total_usia35_44_lk, $total_usia35_44);
        $persentase_usia45_54_lk = $this->calculator->calculatePercentage($total_usia45_54_lk, $total_usia45_54);
        $persentase_usia55_64_lk = $this->calculator->calculatePercentage($total_usia55_64_lk, $total_usia55_64);
        $persentase_usia64_lk = $this->calculator->calculatePercentage($total_usia64_lk, $total_usia64);

        // Hitung persentase usia perempuan
        $persentase_usia25_pr = $this->calculator->calculatePercentage($total_usia25_pr, $total_usia25);
        $persentase_usia25_34_pr = $this->calculator->calculatePercentage($total_usia25_34_pr, $total_usia25_34);
        $persentase_usia35_44_pr = $this->calculator->calculatePercentage($total_usia35_44_pr, $total_usia35_44);
        $persentase_usia45_54_pr = $this->calculator->calculatePercentage($total_usia45_54_pr, $total_usia45_54);
        $persentase_usia55_64_pr = $this->calculator->calculatePercentage($total_usia55_64_pr, $total_usia55_64);
        $persentase_usia64_pr = $this->calculator->calculatePercentage($total_usia64_pr, $total_usia64);

        // Hitung jumlah responden sesuai pekerjaan
        $total_swasta = Responden::where('pekerjaan', '=', 'Pegawai Swasta')->count('id_responden');
        $total_wiraswasta = Responden::where('pekerjaan', '=', 'Wiraswasta')->count('id_responden');
        $total_pns = Responden::where('pekerjaan', '=', 'PNS')->count('id_responden');
        $total_pelajar = Responden::where('pekerjaan', '=', 'Pelajar')->count('id_responden');
        $total_lain = Responden::where('pekerjaan', '=', 'Lainnya')->count('id_responden');

        // Hitung jumlah responden sesuai domisili (provinsi)
        $total_jawa = Responden::where('domisili', '=', 1)->count('id_responden');
        $total_sulawesi = Responden::where('domisili', '=', 2)->count('id_responden');
        $total_sumatera = Responden::where('domisili', '=', 3)->count('id_responden');
        $total_kalimantan = Responden::where('domisili', '=', 4)->count('id_responden');
        $total_papua = Responden::where('domisili', '=', 5)->count('id_responden');
        $total_bali = Responden::where('domisili', '=', 6)->count('id_responden');
        $total_ntb = Responden::where('domisili', '=', 7)->count('id_responden');
        $total_maluku = Responden::where('domisili', '=', 8)->count('id_responden');

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
        // Responsiveness data using calculator
        $rs1_stats = $this->calculateDimensionStats('responsiveness', ['rs1']);
        $rata_rs1 = $rs1_stats['average'];

        $rs2_stats = $this->calculateDimensionStats('responsiveness', ['rs2']);
        $rata_rs2 = $rs2_stats['average'];

        $rs3_stats = $this->calculateDimensionStats('responsiveness', ['rs3']);
        $rata_rs3 = $rs3_stats['average'];

        return [
            'rs1_count' => $rs1_stats['count'],
            'rata_rs1' => $rata_rs1,
            'rs2_count' => $rs2_stats['count'],
            'rata_rs2' => $rata_rs2,
            'rs3_count' => $rs3_stats['count'],
            'rata_rs3' => $rata_rs3,
        ];
    }

    public function getGrafikApplicabilityData(): array
    {
        // Applicability data using calculator
        $ap1_stats = $this->calculateDimensionStats('applicability', ['ap1']);
        $rata_ap1 = $ap1_stats['average'];

        $ap2_stats = $this->calculateDimensionStats('applicability', ['ap2']);
        $rata_ap2 = $ap2_stats['average'];

        $ap3_stats = $this->calculateDimensionStats('applicability', ['ap3']);
        $rata_ap3 = $ap3_stats['average'];

        return [
            'ap1_count' => $ap1_stats['count'],
            'rata_ap1' => $rata_ap1,
            'ap2_count' => $ap2_stats['count'],
            'rata_ap2' => $rata_ap2,
            'ap3_count' => $ap3_stats['count'],
            'rata_ap3' => $rata_ap3,
        ];
    }

    public function getGrafikRelevanceData(): array
    {
        // Relevance data using calculator
        $rl1_stats = $this->calculateDimensionStats('relevance', ['rl1']);
        $rata_rl1 = $rl1_stats['average'];

        $rl2_stats = $this->calculateDimensionStats('relevance', ['rl2']);
        $rata_rl2 = $rl2_stats['average'];

        $rl3_stats = $this->calculateDimensionStats('relevance', ['rl3']);
        $rata_rl3 = $rl3_stats['average'];

        return [
            'rl1_count' => $rl1_stats['count'],
            'rata_rl1' => $rata_rl1,
            'rl2_count' => $rl2_stats['count'],
            'rata_rl2' => $rata_rl2,
            'rl3_count' => $rl3_stats['count'],
            'rata_rl3' => $rata_rl3,
        ];
    }
}