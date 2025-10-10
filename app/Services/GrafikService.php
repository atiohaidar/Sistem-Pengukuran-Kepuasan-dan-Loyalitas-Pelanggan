<?php

namespace App\Services;

use App\Calculators\SurveyCalculator;
use App\Models\Jawaban;
use App\Models\Responden;
use Illuminate\Support\Collection;

class GrafikService
{
    protected SurveyCalculator $calculator;

    // Configuration for all dimensions
    private const DIMENSION_CONFIG = [
        'reliability' => [
            'type' => 'realibility', // Note: keeping original typo for backward compatibility
            'keys' => ['r1', 'r2', 'r3', 'r4', 'r5', 'r6', 'r7'],
            'name' => 'Reliability'
        ],
        'tangible' => [
            'type' => 'tangible',
            'keys' => ['t1', 't2', 't3', 't4', 't5', 't6'],
            'name' => 'Tangible'
        ],
        'responsiveness' => [
            'type' => 'responsiveness',
            'keys' => ['rs1', 'rs2'],
            'name' => 'Responsiveness'
        ],
        'assurance' => [
            'type' => 'assurance',
            'keys' => ['a1', 'a2', 'a3', 'a4'],
            'name' => 'Assurance'
        ],
        'empathy' => [
            'type' => 'empathy',
            'keys' => ['e1', 'e2', 'e3', 'e4', 'e5'],
            'name' => 'Empathy'
        ],
        'relevance' => [
            'type' => 'relevance',
            'keys' => ['rl1', 'rl2'],
            'name' => 'Relevance'
        ],
        'applicability' => [
            'type' => 'applicability',
            'keys' => ['ap1', 'ap2', 'ap3'],
            'name' => 'Applicability'
        ]
    ];

    public function __construct(SurveyCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Helper method untuk mendapatkan data dimensi berdasarkan kategori (persepsi/harapan)
     */
    private function getDimensionDataByCategory(string $dimensionKey, string $category): array
    {
        if (!isset(self::DIMENSION_CONFIG[$dimensionKey])) {
            throw new \InvalidArgumentException("Dimension '{$dimensionKey}' not found in configuration");
        }

        $config = self::DIMENSION_CONFIG[$dimensionKey];
        $results = [];

        foreach ($config['keys'] as $key) {
            $count = Jawaban::getCountDimensi($config['type'], $category);
            $sum = $this->getSumNilaiDimensiByCategory($config['type'], [$key], $category);
            $average = $this->calculator->calculateAverage($sum, $count);
            $results[$key . '_count'] = $count;
            $results['rata_' . $key] = $average;
        }

        return $results;
    }

    /**
     * Get dimension data for perception (persepsi)
     */
    private function getDimensionData(string $dimensionKey): array
    {
        return $this->getDimensionDataByCategory($dimensionKey, 'persepsi');
    }

    /**
     * Get dimension data for importance (harapan)
     */
    private function getDimensionImportanceData(string $dimensionKey): array
    {
        return $this->getDimensionDataByCategory($dimensionKey, 'harapan');
    }

    /**
     * Get summary data for multiple dimensions with gap and deviation calculations
     */
    private function getMultipleDimensionsData(array $dimensionKeys): array
    {
        $results = [];

        foreach ($dimensionKeys as $key) {
            $dimensionData = $this->getDimensionData($key);
            $config = self::DIMENSION_CONFIG[$key];

            // Calculate gap and deviation for the dimension
            $keys = $config['keys'];
            $perceptionValues = [];
            $importanceValues = [];

            foreach ($keys as $keyName) {
                $perceptionValue = $dimensionData['rata_' . $keyName] ?? 0;
                $perceptionValues[] = $perceptionValue;

                // Get importance (harapan) data for this dimension
                $importanceData = $this->getDimensionImportanceData($key);
                $importanceValue = $importanceData['rata_' . $keyName] ?? $perceptionValue; // Fallback to perception if no importance data
                $importanceValues[] = $importanceValue;
            }

            $avgPerception = $this->calculator->calculateDimensionGroupAverage($perceptionValues);
            $avgImportance = $this->calculator->calculateDimensionGroupAverage($importanceValues);
            $gap = $this->calculator->calculateGap($avgPerception, $avgImportance);
            $deviation = $this->calculator->calculateDeviation($gap, $avgPerception);

            $results[$key] = array_merge($dimensionData, [
                'gap' => $gap,
                'deviation' => $deviation,
                'avg_perception' => $avgPerception,
                'avg_importance' => $avgImportance
            ]);
        }

        return $results;
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
     * Get data untuk grafik reliability (dulunya realibility)
     * Digunakan untuk view summary (index2) yang menampilkan semua dimensi
     */
    public function getGrafikRealibilityData(): array
    {
        // Use generic method for reliability data
        $data = $this->getDimensionData('reliability');

        // Get data for all dimensions for summary view (index2)
        $allDimensionsData = $this->getMultipleDimensionsData([
            'reliability', 'empathy', 'assurance', 'responsiveness', 'tangible', 'relevance', 'applicability'
        ]);

        // Calculate total IKP (Indeks Kepuasan Pelanggan)
        $totalGaps = array_column($allDimensionsData, 'gap');
        $totalikp = $this->calculator->calculateIKP($totalGaps);

        // Extract gap and deviation data for each dimension
        $dimensions = [
            'r' => 'reliability',
            'e' => 'empathy',
            'a' => 'assurance',
            'rs' => 'responsiveness',
            't' => 'tangible',
            'rl' => 'relevance'
        ];

        $gapData = [];
        $deviationData = [];

        foreach ($dimensions as $short => $full) {
            if (isset($allDimensionsData[$full])) {
                $gapData[$short] = $allDimensionsData[$full]['gap'];
                $deviationData[$short] = $allDimensionsData[$full]['deviation'];
            } else {
                $gapData[$short] = 0;
                $deviationData[$short] = 0;
            }
        }

        // Handle applicability separately (mapped to 'rl' in view)
        if (isset($allDimensionsData['applicability'])) {
            $gapData['rl'] = $allDimensionsData['applicability']['gap'];
            $deviationData['rl'] = $allDimensionsData['applicability']['deviation'];
        }

        // Add backward compatibility variables for existing views
        $dataWithCompatibility = $data;

        return array_merge($dataWithCompatibility, [
            // Summary view variables (index2)
            'totalikp' => $totalikp,
            'rata_gap_r' => $gapData['r'],
            'rata_gap_e' => $gapData['e'],
            'rata_gap_a' => $gapData['a'],
            'rata_gap_rs' => $gapData['rs'],
            'rata_gap_t' => $gapData['t'],
            'rata_gap_rl' => $gapData['rl'],
            'deviasi_r' => $deviationData['r'],
            'deviasi_e' => $deviationData['e'],
            'deviasi_a' => $deviationData['a'],
            'deviasi_rs' => $deviationData['rs'],
            'deviasi_t' => $deviationData['t'],
            'deviasi_rl' => $deviationData['rl'],
        ]);
    }

    /**
     * Get data untuk grafik assurance
     */
    public function getGrafikAssuranceData(): array
    {
        // Use generic method for assurance data
        $data = $this->getDimensionData('assurance');

        // Add backward compatibility variables for existing views
        return $data;
    }

    /**
     * Get data untuk grafik loyalty & parasuraman (LP)
     */
    public function getGrafikLoyaltyData(): array
    {
        // Calculate basic stats for L1, L2, L3
        $l1_count = Jawaban::getCountDimensi('lp');
        $l1_sum = $this->getSumNilaiDimensi('lp', ['l1']);
        $rata_l1 = $this->calculator->calculateAverage($l1_sum, $l1_count);

        $l2_count = Jawaban::getCountDimensi('lp');
        $l2_sum = $this->getSumNilaiDimensi('lp', ['l2']);
        $rata_l2 = $this->calculator->calculateAverage($l2_sum, $l2_count);

        $l3_count = Jawaban::getCountDimensi('lp');
        $l3_sum = $this->getSumNilaiDimensi('lp', ['l3']);
        $rata_l3 = $this->calculator->calculateAverage($l3_sum, $l3_count);

        // Use helper method to calculate rating distributions
        $l1_data = $this->calculateLoyaltyRatingDistribution('l1');
        $l2_data = $this->calculateLoyaltyRatingDistribution('l2');
        $l3_data = $this->calculateLoyaltyRatingDistribution('l3');

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
            'l1_rata_count' => $l1_data['total_count'],
            'l1_rata_count_1' => $l1_data['rating_counts'][0],
            'l1_rata_count_2' => $l1_data['rating_counts'][1],
            'l1_rata_count_3' => $l1_data['rating_counts'][2],
            'l1_rata_count_4' => $l1_data['rating_counts'][3],
            'l1_rata_count_5' => $l1_data['rating_counts'][4],
            'l1_probability_data' => $l1_data['probability_data'],

            // L2 rating distributions and probability data
            'l2_rata_count' => $l2_data['total_count'],
            'l2_rata_count_1' => $l2_data['rating_counts'][0],
            'l2_rata_count_2' => $l2_data['rating_counts'][1],
            'l2_rata_count_3' => $l2_data['rating_counts'][2],
            'l2_rata_count_4' => $l2_data['rating_counts'][3],
            'l2_rata_count_5' => $l2_data['rating_counts'][4],
            'l2_probability_data' => $l2_data['probability_data'],

            // L3 rating distributions and probability data
            'l3_rata_count' => $l3_data['total_count'],
            'l3_rata_count_1' => $l3_data['rating_counts'][0],
            'l3_rata_count_2' => $l3_data['rating_counts'][1],
            'l3_rata_count_3' => $l3_data['rating_counts'][2],
            'l3_rata_count_4' => $l3_data['rating_counts'][3],
            'l3_rata_count_5' => $l3_data['rating_counts'][4],
            'l3_probability_data' => $l3_data['probability_data'],
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
     * Helper method untuk menghitung rating distribution untuk loyalty data
     */
    private function calculateLoyaltyRatingDistribution(string $key): array
    {
        $count = Jawaban::getCountDimensi('lp');
        $ratingCounts = [];
        $totalCount = 0;

        for ($rating = 1; $rating <= 5; $rating++) {
            $ratingCount = $this->getCountByRating('lp', $key, $rating);
            $ratingCounts[] = $ratingCount;
            $totalCount += $ratingCount;
        }

        $probabilityData = $this->calculator->calculateLoyaltyProbability($ratingCounts, $totalCount);

        return [
            'count' => $count,
            'total_count' => $totalCount,
            'rating_counts' => $ratingCounts,
            'probability_data' => $probabilityData
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
        // Use generic method to get all dimension data
        $allDimensionsData = $this->getMultipleDimensionsData([
            'reliability', 'assurance', 'tangible', 'empathy', 'responsiveness', 'relevance'
        ]);

        // Extract perception averages for each dimension
        $dimensions = [
            'r' => 'reliability',
            'a' => 'assurance',
            't' => 'tangible',
            'e' => 'empathy',
            'rs' => 'responsiveness',
            'rl' => 'relevance'
        ];

        $perceptionData = [];
        foreach ($dimensions as $short => $full) {
            if (isset($allDimensionsData[$full])) {
                // Calculate average perception for the dimension
                $keys = self::DIMENSION_CONFIG[$full]['keys'];
                $averages = [];
                foreach ($keys as $key) {
                    $averages[] = $allDimensionsData[$full]['rata_' . $key] ?? 0;
                }
                $perceptionData[$short] = $this->calculator->calculateDimensionGroupAverage($averages);
            } else {
                $perceptionData[$short] = 0;
            }
        }

        // In this simplified model, importance = perception
        $importanceData = $perceptionData;

        // Calculate gaps (perception - importance)
        $gapData = [];
        foreach ($dimensions as $short => $full) {
            $gapData[$short] = $perceptionData[$short] - $importanceData[$short];
        }

        return [
            // Total perception averages
            'total_rpersepsi' => $perceptionData['r'],
            'total_apersepsi' => $perceptionData['a'],
            'total_tpersepsi' => $perceptionData['t'],
            'total_epersepsi' => $perceptionData['e'],
            'total_rspersepsi' => $perceptionData['rs'],
            'total_rlpersepsi' => $perceptionData['rl'],

            // Total importance averages (same as perception in this model)
            'total_rkepentingan' => $importanceData['r'],
            'total_akepentingan' => $importanceData['a'],
            'total_tkepentingan' => $importanceData['t'],
            'total_ekepentingan' => $importanceData['e'],
            'total_rskepentingan' => $importanceData['rs'],
            'total_rlkepentingan' => $importanceData['rl'],

            // Total gaps
            'total_rgap' => $gapData['r'],
            'total_agap' => $gapData['a'],
            'total_tgap' => $gapData['t'],
            'total_egap' => $gapData['e'],
            'total_rsgap' => $gapData['rs'],
            'total_rlgap' => $gapData['rl'],
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

        /**
     * Get data untuk grafik comparison of multiple dimensions (index3)
     * Shows reliability, tangible, responsiveness, assurance, empathy, and applicability data
     */
    public function getGrafikReliabilityTangibleData(): array
    {
        // Get detailed data for reliability, tangible, responsiveness, assurance, empathy, and applicability dimensions
        $reliabilityData = $this->getDimensionData('reliability');
        $tangibleData = $this->getDimensionData('tangible');
        $responsivenessData = $this->getDimensionData('responsiveness');
        $assuranceData = $this->getDimensionData('assurance');
        $empathyData = $this->getDimensionData('empathy');
        $applicabilityData = $this->getDimensionData('applicability');

        $result = [];

        // Add reliability perception and importance data
        // In this simplified model, importance = perception
        $reliabilityKeys = self::DIMENSION_CONFIG['reliability']['keys'];
        foreach ($reliabilityKeys as $key) {
            $result[$key . '_ratapersepsi_rata'] = $reliabilityData['rata_' . $key] ?? 0;
            $result[$key . '_ratakepentingan_rata'] = $reliabilityData['rata_' . $key] ?? 0; // Same as perception in simplified model
        }

        // Add tangible perception and importance data
        $tangibleKeys = self::DIMENSION_CONFIG['tangible']['keys'];
        foreach ($tangibleKeys as $key) {
            $result[$key . '_ratapersepsi_rata'] = $tangibleData['rata_' . $key] ?? 0;
            $result[$key . '_ratakepentingan_rata'] = $tangibleData['rata_' . $key] ?? 0; // Same as perception in simplified model
        }

        // Add responsiveness perception and importance data
        $responsivenessKeys = self::DIMENSION_CONFIG['responsiveness']['keys'];
        foreach ($responsivenessKeys as $key) {
            $result[$key . '_ratapersepsi_rata'] = $responsivenessData['rata_' . $key] ?? 0;
            $result[$key . '_ratakepentingan_rata'] = $responsivenessData['rata_' . $key] ?? 0; // Same as perception in simplified model
        }

        // Add assurance perception and importance data
        $assuranceKeys = self::DIMENSION_CONFIG['assurance']['keys'];
        foreach ($assuranceKeys as $key) {
            $result[$key . '_ratapersepsi_rata'] = $assuranceData['rata_' . $key] ?? 0;
            $result[$key . '_ratakepentingan_rata'] = $assuranceData['rata_' . $key] ?? 0; // Same as perception in simplified model
        }

        // Add empathy perception and importance data
        $empathyKeys = self::DIMENSION_CONFIG['empathy']['keys'];
        foreach ($empathyKeys as $key) {
            $result[$key . '_ratapersepsi_rata'] = $empathyData['rata_' . $key] ?? 0;
            $result[$key . '_ratakepentingan_rata'] = $empathyData['rata_' . $key] ?? 0; // Same as perception in simplified model
        }

        // Add applicability perception and importance data
        $applicabilityKeys = self::DIMENSION_CONFIG['applicability']['keys'];
        foreach ($applicabilityKeys as $key) {
            $result[$key . '_ratapersepsi_rata'] = $applicabilityData['rata_' . $key] ?? 0;
            $result[$key . '_ratakepentingan_rata'] = $applicabilityData['rata_' . $key] ?? 0; // Same as perception in simplified model
        }

        return $result;
    }

    /**
     * Get data untuk grafik applicability
     */
    public function getGrafikApplicabilityData(): array
    {
        // Use generic method for applicability data
        $data = $this->getDimensionData('applicability');

        // Add backward compatibility variables for existing views
        return $data;
    }

    /**
     * Get data untuk grafik relevance
     */
    public function getGrafikRelevanceData(): array
    {
        // Use generic method for relevance data
        $data = $this->getDimensionData('relevance');

        // Add backward compatibility variables for existing views
        return $data;
    }

    /**
     * Get sum nilai dimensi berdasarkan kategori (persepsi/harapan)
     */
    private function getSumNilaiDimensiByCategory(string $dimensiType, array $keys, string $category): float
    {
        $data = Jawaban::dimensi($dimensiType)->kategori($category)->get();
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
}