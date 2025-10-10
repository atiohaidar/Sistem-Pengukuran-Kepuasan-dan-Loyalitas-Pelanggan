<?php

namespace App\Calculators;

use InvalidArgumentException;

/**
 * Calculator class untuk semua perhitungan matematis terkait survei kepuasan pelanggan
 *
 * Class ini memisahkan business logic kalkulasi dari data retrieval dan presentation,
 * sehingga lebih mudah di-test dan di-maintain.
 */
class SurveyCalculator
{
    /**
     * Menghitung rata-rata dengan validasi
     *
     * @param float $sum Total nilai
     * @param int $count Jumlah data
     * @return float Rata-rata atau 0 jika count = 0
     */
    public function calculateAverage(float $sum, int $count): float
    {
        if ($count < 0) {
            throw new InvalidArgumentException('Count cannot be negative');
        }

        return $count > 0 ? $sum / $count : 0.0;
    }

    /**
     * Menghitung gap antara persepsi dan harapan
     *
     * @param float $perception Nilai persepsi
     * @param float $expectation Nilai harapan
     * @return float Gap (persepsi - harapan)
     */
    public function calculateGap(float $perception, float $expectation): float
    {
        return $perception - $expectation;
    }

    /**
     * Menghitung total index loyalitas berdasarkan formula Parasuraman
     *
     * Formula: ((average - 1) / 4) * 100
     * Dimana average adalah rata-rata dari L1, L2, L3
     *
     * @param float $l1 Nilai L1
     * @param float $l2 Nilai L2
     * @param float $l3 Nilai L3
     * @return float Total index loyalitas dalam persen
     */
    public function calculateLoyaltyIndex(float $l1, float $l2, float $l3): float
    {
        $average = ($l1 + $l2 + $l3) / 3;
        return (($average - 1) / 4) * 100;
    }

    /**
     * Menghitung probabilitas loyalitas berdasarkan rating distribution
     *
     * Menggunakan formula:
     * - Probabilitas: [0.00, 0.25, 0.50, 0.75, 1.00] untuk rating 1-5
     * - Total = Σ(frekuensi_rating * probabilitas_rating)
     *
     * @param array $ratingCounts Array jumlah responden per rating [count1, count2, count3, count4, count5]
     * @param int $totalCount Total responden
     * @return array Array dengan percentages, weighted_sums, frequency_weighteds, dan total_probability
     */
    public function calculateLoyaltyProbability(array $ratingCounts, int $totalCount): array
    {
        if (count($ratingCounts) !== 5) {
            throw new InvalidArgumentException('Rating counts must contain exactly 5 elements');
        }

        $probabilities = [0.00, 0.25, 0.50, 0.75, 1.00];
        $percentages = [];
        $weightedSums = [];
        $frequencyWeighteds = [];

        foreach ($ratingCounts as $index => $count) {
            $percentage = $totalCount > 0 ? ($count / $totalCount) * 100 : 0;
            $weightedSum = $percentage * $probabilities[$index];
            $frequencyWeighted = $count * $probabilities[$index];

            $percentages[] = $percentage;
            $weightedSums[] = $weightedSum;
            $frequencyWeighteds[] = $frequencyWeighted;
        }

        return [
            'percentages' => $percentages,
            'weighted_sums' => $weightedSums,
            'frequency_weighteds' => $frequencyWeighteds,
            'total_probability' => array_sum($frequencyWeighteds)
        ];
    }

    /**
     * Menghitung distribusi rating untuk dimensi tertentu
     *
     * @param array $data Array data rating
     * @param string $key Key untuk rating (mis: 'l1', 'k1')
     * @return array Array dengan count per rating [1=>count, 2=>count, ...]
     */
    public function calculateRatingDistribution(array $data, string $key): array
    {
        $distribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        foreach ($data as $item) {
            if (isset($item[$key]) && is_numeric($item[$key])) {
                $rating = (int) $item[$key];
                if (isset($distribution[$rating])) {
                    $distribution[$rating]++;
                }
            }
        }

        return $distribution;
    }

    /**
     * Menghitung statistik dasar (count, sum, average) untuk multiple keys
     *
     * @param array $data Array data dengan nilai JSON
     * @param array $keys Array keys yang akan dihitung (mis: ['r1', 'r2'])
     * @return array Array dengan struktur ['key' => ['count' => int, 'sum' => float, 'average' => float]]
     */
    public function calculateMultipleStats(array $data, array $keys): array
    {
        $results = [];

        foreach ($keys as $key) {
            $count = 0;
            $sum = 0.0;

            foreach ($data as $item) {
                if (isset($item[$key]) && is_numeric($item[$key])) {
                    $value = (float) $item[$key];
                    $sum += $value;
                    $count++;
                }
            }

            $results[$key] = [
                'count' => $count,
                'sum' => $sum,
                'average' => $this->calculateAverage($sum, $count)
            ];
        }

        return $results;
    }

    /**
     * Menghitung deviasi untuk gap analysis
     *
     * @param float $gap Nilai gap
     * @param float $average Rata-rata dimensi
     * @return float Deviasi
     */
    public function calculateDeviation(float $gap, float $average): float
    {
        // Formula deviasi bisa bervariasi, disesuaikan dengan kebutuhan bisnis
        return abs($gap) / max($average, 1); // Contoh: deviasi relatif
    }

    /**
     * Menghitung rata-rata untuk dimensi tertentu
     *
     * @param float $sum Total nilai dimensi
     * @param int $count Jumlah data dimensi
     * @return float Rata-rata dimensi
     */
    public function calculateDimensionAverage(float $sum, int $count): float
    {
        return $this->calculateAverage($sum, $count);
    }

    /**
     * Menghitung rata-rata gap dari beberapa nilai gap
     *
     * @param array $gaps Array nilai gap
     * @return float Rata-rata gap
     */
    public function calculateGapAverage(array $gaps): float
    {
        if (empty($gaps)) {
            return 0.0;
        }

        $sum = array_sum($gaps);
        $count = count($gaps);

        return $this->calculateAverage($sum, $count);
    }

    /**
     * Menghitung total Indeks Kepuasan Pelanggan (IKP)
     *
     * Formula: ((average_persepsi - 1) / 4) * 100
     * Dimana average_persepsi adalah rata-rata dari semua nilai persepsi
     *
     * @param array $perceptionValues Array nilai persepsi dari semua dimensi
     * @return float Total IKP dalam persen
     */
    public function calculateTotalIKP(array $perceptionValues): float
    {
        if (empty($perceptionValues)) {
            return 0.0;
        }

        $totalSum = array_sum($perceptionValues);
        $totalCount = count($perceptionValues);
        $averagePersepsi = $this->calculateAverage($totalSum, $totalCount);

        // Convert to percentage (assuming scale is 1-5, convert to 0-100)
        return (($averagePersepsi - 1) / 4) * 100;
    }

    /**
     * Menghitung rata-rata dari beberapa nilai dimensi
     *
     * @param array $values Array nilai-nilai dimensi
     * @return float Rata-rata dari nilai-nilai dimensi
     */
    public function calculateDimensionGroupAverage(array $values): float
    {
        if (empty($values)) {
            return 0.0;
        }

        $sum = array_sum($values);
        $count = count($values);

        return $this->calculateAverage($sum, $count);
    }

    /**
     * Menghitung persentase dari bagian terhadap total
     *
     * @param float $part Bagian yang ingin dihitung persentasenya
     * @param float $total Total keseluruhan
     * @return float Persentase dalam desimal (0-100)
     */
    public function calculatePercentage(float $part, float $total): float
    {
        if ($total <= 0) {
            return 0.0;
        }

        return ($part / $total) * 100;
    }
}