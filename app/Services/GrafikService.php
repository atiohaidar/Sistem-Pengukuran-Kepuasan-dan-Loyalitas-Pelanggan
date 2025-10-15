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
     * Get dimension data for perception (persepsi)
     */
    private function getDimensionData(string $dimensionKey): array
    {
        return $this->getDimensionDataByCategoryUltraOptimized($dimensionKey, 'persepsi');
    }

    /**
     * Get dimension data for importance (harapan)
     */
    private function getDimensionImportanceData(string $dimensionKey): array
    {
        return $this->getDimensionDataByCategoryUltraOptimized($dimensionKey, 'harapan');
    }

    /**
     * Ultra-optimized method menggunakan raw SQL untuk menghindari memory issues
     * Menggunakan JSON_EXTRACT dan aggregation di database level
     */
    private function getDimensionDataByCategoryUltraOptimized(string $dimensionKey, string $category): array
    {
        if (!isset(self::DIMENSION_CONFIG[$dimensionKey])) {
            throw new \InvalidArgumentException("Dimension '{$dimensionKey}' not found in configuration");
        }

        $config = self::DIMENSION_CONFIG[$dimensionKey];
        $results = [];

        // Build dynamic SQL untuk extract semua keys sekaligus
        $jsonExtracts = [];

        foreach ($config['keys'] as $key) {
            $jsonExtracts[] = "AVG(CAST(JSON_EXTRACT(nilai, '$." . $key . "') AS DECIMAL(10,2))) as avg_{$key}";
            $jsonExtracts[] = "COUNT(CASE WHEN JSON_EXTRACT(nilai, '$." . $key . "') IS NOT NULL THEN 1 END) as count_{$key}";
        }

        $sql = "
            SELECT " . implode(', ', $jsonExtracts) . "
            FROM tbl_jawaban
            WHERE dimensi_type = ? AND kategori = ?
        ";

        $aggregatedData = \DB::select($sql, [$config['type'], $category]);

        if (empty($aggregatedData)) {
            // Return empty results
            foreach ($config['keys'] as $key) {
                $results[$key . '_count'] = 0;
                $results['rata_' . $key] = 0.0;
            }
            return $results;
        }

        $data = $aggregatedData[0];

        foreach ($config['keys'] as $key) {
            $results[$key . '_count'] = (int) $data->{'count_' . $key};
            $results['rata_' . $key] = (float) $data->{'avg_' . $key};
        }

        return $results;
    }

    /**
     * Get summary data for multiple dimensions with gap and deviation calculations
     * Ultra-optimized version using single query for all dimensions and categories
     */
    private function getMultipleDimensionsData(array $dimensionKeys): array
    {
        $results = [];

        // Single query untuk mengambil semua data dimensi dan kategori sekaligus
        $allData = collect();

        foreach ($dimensionKeys as $dimKey) {
            if (!isset(self::DIMENSION_CONFIG[$dimKey])) {
                continue;
            }

            $config = self::DIMENSION_CONFIG[$dimKey];

            // Get both perception and importance data
            $perceptionData = Jawaban::dimensi($config['type'])->kategori('persepsi')->get();
            $importanceData = Jawaban::dimensi($config['type'])->kategori('harapan')->get();

            $allData = $allData->merge($perceptionData->map(function($item) use ($dimKey, $config) {
                $item->dimension_key = $dimKey;
                $item->category = 'persepsi';
                $item->dimension_config = $config;
                return $item;
            }));

            $allData = $allData->merge($importanceData->map(function($item) use ($dimKey, $config) {
                $item->dimension_key = $dimKey;
                $item->category = 'harapan';
                $item->dimension_config = $config;
                return $item;
            }));
        }

        // Process all data in memory
        foreach ($dimensionKeys as $dimKey) {
            if (!isset(self::DIMENSION_CONFIG[$dimKey])) {
                continue;
            }

            $config = self::DIMENSION_CONFIG[$dimKey];
            $dimData = $allData->where('dimension_key', $dimKey);

            $perceptionData = $dimData->where('category', 'persepsi');
            $importanceData = $dimData->where('category', 'harapan');

            $dimensionData = [];
            $perceptionValues = [];
            $importanceValues = [];

            foreach ($config['keys'] as $key) {
                // Calculate perception averages
                $sum = 0;
                $count = 0;
                foreach ($perceptionData as $item) {
                    $nilai = $item->getNilai($key);
                    if ($nilai !== null) {
                        $sum += (float) $nilai;
                        $count++;
                    }
                }
                $perceptionAvg = $count > 0 ? $this->calculator->calculateAverage($sum, $count) : 0;
                $dimensionData['rata_' . $key] = $perceptionAvg;
                $dimensionData[$key . '_count'] = $count;
                $perceptionValues[] = $perceptionAvg;

                // Calculate importance averages
                $sum = 0;
                $count = 0;
                foreach ($importanceData as $item) {
                    $nilai = $item->getNilai($key);
                    if ($nilai !== null) {
                        $sum += (float) $nilai;
                        $count++;
                    }
                }
                $importanceAvg = $count > 0 ? $this->calculator->calculateAverage($sum, $count) : $perceptionAvg; // Fallback to perception
                $importanceValues[] = $importanceAvg;
            }

            $avgPerception = $this->calculator->calculateDimensionGroupAverage($perceptionValues);
            $avgImportance = $this->calculator->calculateDimensionGroupAverage($importanceValues);
            $gap = $this->calculator->calculateGap($avgPerception, $avgImportance);
            $deviation = $this->calculator->calculateDeviation($gap, $avgPerception);

            $results[$dimKey] = array_merge($dimensionData, [
                'gap' => $gap,
                'deviation' => $deviation,
                'avg_perception' => $avgPerception,
                'avg_importance' => $avgImportance
            ]);
        }

        return $results;
    }
    /**
     * Optimized version of getGrafikKepuasanData using single query
     */
    public function getGrafikKepuasanData(): array
    {
        // Single query untuk mengambil semua data KP sekaligus
        $kpData = Jawaban::dimensi('kp')->get();

        // Hitung untuk k1, k2, k3 dalam satu pass
        $k1_sum = $k2_sum = $k3_sum = 0;
        $k1_count = $k2_count = $k3_count = 0;

        // Hitung rating distribution untuk k1
        $rating_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        foreach ($kpData as $item) {
            // K1 calculations
            $k1_val = $item->getNilai('k1');
            if ($k1_val !== null) {
                $k1_sum += (float) $k1_val;
                $k1_count++;
                $rating = (int) $k1_val;
                if (isset($rating_counts[$rating])) {
                    $rating_counts[$rating]++;
                }
            }

            // K2 calculations
            $k2_val = $item->getNilai('k2');
            if ($k2_val !== null) {
                $k2_sum += (float) $k2_val;
                $k2_count++;
            }

            // K3 calculations
            $k3_val = $item->getNilai('k3');
            if ($k3_val !== null) {
                $k3_sum += (float) $k3_val;
                $k3_count++;
            }
        }

        $total_rata_k1 = $k1_count > 0 ? $this->calculator->calculateAverage($k1_sum, $k1_count) : 0;
        $total_rata_k2 = $k2_count > 0 ? $this->calculator->calculateAverage($k2_sum, $k2_count) : 0;
        $total_rata_k3 = $k3_count > 0 ? $this->calculator->calculateAverage($k3_sum, $k3_count) : 0;

        $gap = $this->calculator->calculateGap($total_rata_k3, $total_rata_k2);

        // Calculate loyalty probability
        $loyaltyData = $this->calculator->calculateLoyaltyProbability(
            array_values($rating_counts),
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
            'k1_rata_count_1' => $rating_counts[1],
            'k1_rata_count_2' => $rating_counts[2],
            'k1_rata_count_3' => $rating_counts[3],
            'k1_rata_count_4' => $rating_counts[4],
            'k1_rata_count_5' => $rating_counts[5],
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
    /**
     * Optimized version of getGrafikLoyaltyData using single query
     */
    public function getGrafikLoyaltyData(): array
    {
        // Single query untuk mengambil semua data LP sekaligus
        $lpData = Jawaban::dimensi('lp')->get();

        // Hitung untuk l1, l2, l3 dalam satu pass
        $l1_sum = $l2_sum = $l3_sum = 0;
        $l1_count = $l2_count = $l3_count = 0;

        // Hitung rating distributions untuk l1, l2, l3
        $l1_ratings = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        $l2_ratings = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        $l3_ratings = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        foreach ($lpData as $item) {
            // L1 calculations
            $l1_val = $item->getNilai('l1');
            if ($l1_val !== null) {
                $l1_sum += (float) $l1_val;
                $l1_count++;
                $rating = (int) $l1_val;
                if (isset($l1_ratings[$rating])) {
                    $l1_ratings[$rating]++;
                }
            }

            // L2 calculations
            $l2_val = $item->getNilai('l2');
            if ($l2_val !== null) {
                $l2_sum += (float) $l2_val;
                $l2_count++;
                $rating = (int) $l2_val;
                if (isset($l2_ratings[$rating])) {
                    $l2_ratings[$rating]++;
                }
            }

            // L3 calculations
            $l3_val = $item->getNilai('l3');
            if ($l3_val !== null) {
                $l3_sum += (float) $l3_val;
                $l3_count++;
                $rating = (int) $l3_val;
                if (isset($l3_ratings[$rating])) {
                    $l3_ratings[$rating]++;
                }
            }
        }

        $rata_l1 = $l1_count > 0 ? $this->calculator->calculateAverage($l1_sum, $l1_count) : 0;
        $rata_l2 = $l2_count > 0 ? $this->calculator->calculateAverage($l2_sum, $l2_count) : 0;
        $rata_l3 = $l3_count > 0 ? $this->calculator->calculateAverage($l3_sum, $l3_count) : 0;

        // Calculate loyalty probabilities
        $l1_probability = $this->calculator->calculateLoyaltyProbability(array_values($l1_ratings), $l1_count);
        $l2_probability = $this->calculator->calculateLoyaltyProbability(array_values($l2_ratings), $l2_count);
        $l3_probability = $this->calculator->calculateLoyaltyProbability(array_values($l3_ratings), $l3_count);

        // Calculate total loyalty index
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
            'l1_rata_count' => $l1_count,
            'l1_rata_count_1' => $l1_ratings[1],
            'l1_rata_count_2' => $l1_ratings[2],
            'l1_rata_count_3' => $l1_ratings[3],
            'l1_rata_count_4' => $l1_ratings[4],
            'l1_rata_count_5' => $l1_ratings[5],
            'l1_probability_data' => $l1_probability, // Full array instead of just total_probability
            'l1_percentages' => $l1_probability['percentages'],

            // L2 rating distributions and probability data
            'l2_rata_count' => $l2_count,
            'l2_rata_count_1' => $l2_ratings[1],
            'l2_rata_count_2' => $l2_ratings[2],
            'l2_rata_count_3' => $l2_ratings[3],
            'l2_rata_count_4' => $l2_ratings[4],
            'l2_rata_count_5' => $l2_ratings[5],
            'l2_probability_data' => $l2_probability, // Full array instead of just total_probability
            'l2_percentages' => $l2_probability['percentages'],

            // L3 rating distributions and probability data
            'l3_rata_count' => $l3_count,
            'l3_rata_count_1' => $l3_ratings[1],
            'l3_rata_count_2' => $l3_ratings[2],
            'l3_rata_count_3' => $l3_ratings[3],
            'l3_rata_count_4' => $l3_ratings[4],
            'l3_rata_count_5' => $l3_ratings[5],
            'l3_probability_data' => $l3_probability, // Full array instead of just total_probability
            'l3_percentages' => $l3_probability['percentages'],
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
        // Single query untuk mengambil semua data responden sekaligus
        $respondents = Responden::select('usia', 'jk', 'pekerjaan', 'domisili')->get();

        // Initialize counters
        $usia_gender_counts = [
            '<25' => ['L' => 0, 'P' => 0],
            '25-34' => ['L' => 0, 'P' => 0],
            '35-44' => ['L' => 0, 'P' => 0],
            '45-54' => ['L' => 0, 'P' => 0],
            '55-64' => ['L' => 0, 'P' => 0],
            '>64' => ['L' => 0, 'P' => 0],
        ];

        $pekerjaan_counts = [
            'Pegawai Swasta' => 0,
            'Wiraswasta' => 0,
            'PNS' => 0,
            'Pelajar' => 0,
            'Lainnya' => 0,
        ];

        $domisili_counts = [
            1 => 0, // Jawa
            2 => 0, // Sulawesi
            3 => 0, // Sumatera
            4 => 0, // Kalimantan
            5 => 0, // Papua
            6 => 0, // Bali
            7 => 0, // NTB
            8 => 0, // Maluku
        ];

        // Process all respondents in single pass
        foreach ($respondents as $respondent) {
            $usia = (int) $respondent->usia;
            $jk = $respondent->jk;
            $pekerjaan = $respondent->pekerjaan;
            $domisili = $respondent->domisili;

            // Categorize by age and gender
            if ($usia < 25) {
                $age_group = '<25';
            } elseif ($usia <= 34) {
                $age_group = '25-34';
            } elseif ($usia <= 44) {
                $age_group = '35-44';
            } elseif ($usia <= 54) {
                $age_group = '45-54';
            } elseif ($usia <= 64) {
                $age_group = '55-64';
            } else {
                $age_group = '>64';
            }

            if (isset($usia_gender_counts[$age_group][$jk])) {
                $usia_gender_counts[$age_group][$jk]++;
            }

            // Count by pekerjaan
            if (isset($pekerjaan_counts[$pekerjaan])) {
                $pekerjaan_counts[$pekerjaan]++;
            }

            // Count by domisili
            if (isset($domisili_counts[$domisili])) {
                $domisili_counts[$domisili]++;
            }
        }

        // Calculate totals and percentages
        $totalresponden = $respondents->count();

        // Age group totals
        $total_usia25 = $usia_gender_counts['<25']['L'] + $usia_gender_counts['<25']['P'];
        $total_usia25_34 = $usia_gender_counts['25-34']['L'] + $usia_gender_counts['25-34']['P'];
        $total_usia35_44 = $usia_gender_counts['35-44']['L'] + $usia_gender_counts['35-44']['P'];
        $total_usia45_54 = $usia_gender_counts['45-54']['L'] + $usia_gender_counts['45-54']['P'];
        $total_usia55_64 = $usia_gender_counts['55-64']['L'] + $usia_gender_counts['55-64']['P'];
        $total_usia64 = $usia_gender_counts['>64']['L'] + $usia_gender_counts['>64']['P'];

        // Age group gender breakdowns
        $total_usia25_lk = $usia_gender_counts['<25']['L'];
        $total_usia25_pr = $usia_gender_counts['<25']['P'];
        $total_usia25_34_lk = $usia_gender_counts['25-34']['L'];
        $total_usia25_34_pr = $usia_gender_counts['25-34']['P'];
        $total_usia35_44_lk = $usia_gender_counts['35-44']['L'];
        $total_usia35_44_pr = $usia_gender_counts['35-44']['P'];
        $total_usia45_54_lk = $usia_gender_counts['45-54']['L'];
        $total_usia45_54_pr = $usia_gender_counts['45-54']['P'];
        $total_usia55_64_lk = $usia_gender_counts['55-64']['L'];
        $total_usia55_64_pr = $usia_gender_counts['55-64']['P'];
        $total_usia64_lk = $usia_gender_counts['>64']['L'];
        $total_usia64_pr = $usia_gender_counts['>64']['P'];

        // Calculate percentages
        $persentase_usia25_lk = $this->calculator->calculatePercentage($total_usia25_lk, $total_usia25);
        $persentase_usia25_34_lk = $this->calculator->calculatePercentage($total_usia25_34_lk, $total_usia25_34);
        $persentase_usia35_44_lk = $this->calculator->calculatePercentage($total_usia35_44_lk, $total_usia35_44);
        $persentase_usia45_54_lk = $this->calculator->calculatePercentage($total_usia45_54_lk, $total_usia45_54);
        $persentase_usia55_64_lk = $this->calculator->calculatePercentage($total_usia55_64_lk, $total_usia55_64);
        $persentase_usia64_lk = $this->calculator->calculatePercentage($total_usia64_lk, $total_usia64);

        $persentase_usia25_pr = $this->calculator->calculatePercentage($total_usia25_pr, $total_usia25);
        $persentase_usia25_34_pr = $this->calculator->calculatePercentage($total_usia25_34_pr, $total_usia25_34);
        $persentase_usia35_44_pr = $this->calculator->calculatePercentage($total_usia35_44_pr, $total_usia35_44);
        $persentase_usia45_54_pr = $this->calculator->calculatePercentage($total_usia45_54_pr, $total_usia45_54);
        $persentase_usia55_64_pr = $this->calculator->calculatePercentage($total_usia55_64_pr, $total_usia55_64);
        $persentase_usia64_pr = $this->calculator->calculatePercentage($total_usia64_pr, $total_usia64);

        // Job counts
        $total_swasta = $pekerjaan_counts['Pegawai Swasta'];
        $total_wiraswasta = $pekerjaan_counts['Wiraswasta'];
        $total_pns = $pekerjaan_counts['PNS'];
        $total_pelajar = $pekerjaan_counts['Pelajar'];
        $total_lain = $pekerjaan_counts['Lainnya'];

        // Location counts
        $total_jawa = $domisili_counts[1];
        $total_sulawesi = $domisili_counts[2];
        $total_sumatera = $domisili_counts[3];
        $total_kalimantan = $domisili_counts[4];
        $total_papua = $domisili_counts[5];
        $total_bali = $domisili_counts[6];
        $total_ntb = $domisili_counts[7];
        $total_maluku = $domisili_counts[8];

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
     * Ultra-optimized version using single query for all dimensions
     */
    public function getGrafikReliabilityTangibleData(): array
    {
        // Define all dimensions we need
        $dimensions = [
            'reliability' => ['type' => 'realibility', 'keys' => ['r1', 'r2', 'r3', 'r4', 'r5', 'r6', 'r7']],
            'tangible' => ['type' => 'tangible', 'keys' => ['t1', 't2', 't3', 't4', 't5', 't6']],
            'responsiveness' => ['type' => 'responsiveness', 'keys' => ['rs1', 'rs2']],
            'assurance' => ['type' => 'assurance', 'keys' => ['a1', 'a2', 'a3', 'a4']],
            'empathy' => ['type' => 'empathy', 'keys' => ['e1', 'e2', 'e3', 'e4', 'e5']],
            'applicability' => ['type' => 'applicability', 'keys' => ['ap1', 'ap2', 'ap3']]
        ];

        $result = [];

        // Single query untuk mengambil semua data dimensi sekaligus
        $allData = collect();

        foreach ($dimensions as $dimName => $config) {
            $data = Jawaban::dimensi($config['type'])->get();
            $allData = $allData->merge($data->map(function($item) use ($dimName, $config) {
                $item->dimension_name = $dimName;
                $item->dimension_config = $config;
                return $item;
            }));
        }

        // Process all data in memory
        $dimensionResults = [];

        foreach ($dimensions as $dimName => $config) {
            $dimensionResults[$dimName] = [];
            $dimData = $allData->where('dimension_name', $dimName);

            foreach ($config['keys'] as $key) {
                $sum = 0;
                $count = 0;

                foreach ($dimData as $item) {
                    $nilai = $item->getNilai($key);
                    if ($nilai !== null) {
                        $sum += (float) $nilai;
                        $count++;
                    }
                }

                $average = $count > 0 ? $this->calculator->calculateAverage($sum, $count) : 0;
                $dimensionResults[$dimName][$key] = $average;
            }
        }

        // Build result array with backward compatibility
        foreach ($dimensions as $dimName => $config) {
            foreach ($config['keys'] as $key) {
                $result[$key . '_ratapersepsi_rata'] = $dimensionResults[$dimName][$key];
                $result[$key . '_ratakepentingan_rata'] = $dimensionResults[$dimName][$key]; // Same as perception in simplified model
            }
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
}