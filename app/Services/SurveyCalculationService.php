<?php

namespace App\Services;

use App\Models\PelatihanSurveyResponse;
use App\Models\ProdukSurveyResponse;
use App\Models\SurveyCampaign;

class SurveyCalculationService
{
    /**
     * Calculate results for a specific campaign
     */
    public function calculateCampaignResults(SurveyCampaign $campaign)
    {
        $responses = $campaign->responses;
        
        if ($responses->isEmpty()) {
            return $this->getEmptyResults();
        }
        
        return $this->calculateCompleteSurveyResults($responses->toArray());
    }

    /**
     * Get responses for calculation (with campaign filter)
     */
    public function getResponsesForCalculation(string $type, ?int $campaignId = null)
    {
        $model = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;
        
        $query = $model::query()->where('status', 'completed');
        
        if ($campaignId) {
            $query->where('survey_campaign_id', $campaignId);
        }
        
        return $query->get();
    }

    /**
     * Get empty results structure
     */
    protected function getEmptyResults(): array
    {
        return [
            'basic_analysis' => [],
            'ikp_analysis' => [],
            'ilp_analysis' => [],
            'gap_analysis' => [
                'item_gaps' => [],
                'dimension_gaps' => [],
                'gap_statistics' => [],
                'dimensions' => [],
            ],
            'loyalitas_probabilities' => [],
            'demographic_statistics' => ['total_respondents' => 0],
            'scale_frequency_analysis' => [],
            'kepuasan_pelanggan' => ['overall_mean' => 0, 'total_items' => 0],
            'harapan' => ['overall_mean' => 0, 'total_items' => 0],
            'persepsi' => ['overall_mean' => 0, 'total_items' => 0],
        ];
    }

    /**
     * Calculate survey results based on responses
     * This implements calculations similar to the survey application methodology
     */
    public function calculateSurveyResults($responses)
    {
        // Assuming responses is an array of survey answers
        // Structure: ['harapan' => [...], 'persepsi' => [...], 'kepuasan' => [...], 'loyalitas' => [...], 'demographics' => [...]]

        $results = [
            'total_respondents' => count($responses),
            'harapan_scores' => [],
            'persepsi_scores' => [],
            'gap_scores' => [],
            'kepuasan_score' => 0,
            'loyalitas_score' => 0,
            'recommendations' => []
        ];

        if (empty($responses)) {
            return $results;
        }

        // Calculate harapan and persepsi averages
        $harapanQuestions = ['imp1', 'imp2', 'imp3', 'imp4', 'imp5', 'imp6']; // Adjust based on actual questions
        $persepsiQuestions = ['perf1', 'perf2', 'perf3', 'perf4', 'perf5', 'perf6'];

        foreach ($harapanQuestions as $q) {
            $scores = array_column($responses, $q);
            $results['harapan_scores'][$q] = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
        }

        foreach ($persepsiQuestions as $q) {
            $scores = array_column($responses, $q);
            $results['persepsi_scores'][$q] = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
        }

        // Calculate gaps (Persepsi - Harapan, negative gap indicates problem area)
        foreach ($harapanQuestions as $index => $impQ) {
            $perfQ = $persepsiQuestions[$index];
            $gap = $results['persepsi_scores'][$perfQ] - $results['harapan_scores'][$impQ];
            $results['gap_scores'][$impQ] = $gap;
        }

        // Overall kepuasan score (average of persepsi scores)
        $results['kepuasan_score'] = array_sum($results['persepsi_scores']) / count($results['persepsi_scores']);

        // Loyalitas score calculation (based on loyalitas questions if available)
        // Assuming loyalitas questions exist in responses
        $loyalitasQuestions = ['loyalitas1', 'loyalitas2', 'loyalitas3'];
        $loyalitasScores = [];
        foreach ($loyalitasQuestions as $q) {
            if (isset($responses[0][$q])) {
                $scores = array_column($responses, $q);
                $loyalitasScores[] = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
            }
        }
        $results['loyalitas_score'] = count($loyalitasScores) > 0 ? array_sum($loyalitasScores) / count($loyalitasScores) : 0;

        // Generate recommendations based on gaps
        $results['recommendations'] = $this->generateRecommendations($results['gap_scores']);

        return $results;
    }

    /**
     * Calculate complete IKP (Indeks Kepuasan Pelanggan) based on the full methodology
     */
    public function calculateIKP($responses)
    {
        $results = [
            'total_respondents' => count($responses),
            'item_averages' => [],
            'dimension_averages' => [],
            'weighting_factors' => [],
            'weighted_scores' => [],
            'total_weighted_score' => 0,
            'ikp_percentage' => 0,
            'ikp_interpretation' => ''
        ];

        if (empty($responses)) {
            return $results;
        }

        // Define dimensions and their items
        $dimensions = [
            'reliability' => ['r1', 'r2', 'r3', 'r4', 'r5', 'r6', 'r7'], // 7 items
            'assurance' => ['a1', 'a2', 'a3', 'a4'], // 4 items
            'tangible' => ['t1', 't2', 't3', 't4', 't5', 't6'], // 6 items
            'empathy' => ['e1', 'e2', 'e3', 'e4', 'e5'], // 5 items
            'responsiveness' => ['rs1', 'rs2'], // 2 items
            'applicability' => ['ap1', 'ap2'] // 2 items
        ];

        // 1. Calculate average per item for harapan and persepsi
        $harapanAverages = [];
        $persepsiAverages = [];
        $totalHarapan = 0;

        foreach ($dimensions as $dim => $items) {
            foreach ($items as $item) {
                // Access nested structure: harapan_answers[reliability][r1]
                $impScores = [];
                $perfScores = [];
                
                foreach ($responses as $response) {
                    if (isset($response['harapan_answers'][$dim][$item])) {
                        $impScores[] = $response['harapan_answers'][$dim][$item];
                    }
                    if (isset($response['persepsi_answers'][$dim][$item])) {
                        $perfScores[] = $response['persepsi_answers'][$dim][$item];
                    }
                }
                
                $harapanAverages[$item] = count($impScores) > 0 ? array_sum($impScores) / count($impScores) : 0;
                $totalHarapan += $harapanAverages[$item];
                $persepsiAverages[$item] = count($perfScores) > 0 ? array_sum($perfScores) / count($perfScores) : 0;
            }
        }

        $results['item_averages'] = [
            'harapan' => $harapanAverages,
            'persepsi' => $persepsiAverages
        ];

        // 2. Calculate total average per dimension
        foreach ($dimensions as $dim => $items) {
            $impSum = 0;
            $perfSum = 0;
            $count = 0;

            foreach ($items as $item) {
                if (isset($harapanAverages[$item])) {
                    $impSum += $harapanAverages[$item];
                    $count++;
                }
                if (isset($persepsiAverages[$item])) {
                    $perfSum += $persepsiAverages[$item];
                }
            }

            $results['dimension_averages'][$dim] = [
                'harapan' => $count > 0 ? $impSum / $count : 0,
                'persepsi' => $count > 0 ? $perfSum / $count : 0
            ];
        }

        // 3. Calculate Weighting Factor (WF) for each item
        foreach ($harapanAverages as $item => $avg) {
            $results['weighting_factors'][$item] = $totalHarapan > 0 ? $avg / $totalHarapan : 0;
        }

        // 4. Calculate Weighted Score (WS) for each item
        foreach ($persepsiAverages as $item => $perfAvg) {
            $wf = $results['weighting_factors'][$item] ?? 0;
            $results['weighted_scores'][$item] = $perfAvg * $wf;
        }

        // 5. Calculate Total Weighted Score
        $results['total_weighted_score'] = array_sum($results['weighted_scores']);

        // 6. Calculate final IKP percentage
        $results['ikp_percentage'] = ($results['total_weighted_score'] / 5) * (100/100) * 100;

        // 7. Determine interpretation
        $ikp = $results['ikp_percentage'];
        if ($ikp >= 81) {
            $results['ikp_interpretation'] = 'Sangat Puas';
        } elseif ($ikp >= 66) {
            $results['ikp_interpretation'] = 'Puas';
        } elseif ($ikp >= 51) {
            $results['ikp_interpretation'] = 'Cukup Puas';
        } elseif ($ikp >= 35) {
            $results['ikp_interpretation'] = 'Kurang Puas';
        } else {
            $results['ikp_interpretation'] = 'Tidak Puas';
        }

        return $results;
    }

    /**
     * Calculate complete ILP (Indeks Loyalitas Pelanggan)
     */
    public function calculateILP($responses)
    {
        $results = [
            'total_respondents' => count($responses),
            'loyalitas_item_averages' => [],
            'cli_scores' => [],
            'ilp_percentage' => 0,
            'ilp_interpretation' => ''
        ];

        if (empty($responses)) {
            return $results;
        }

        $loyalitasItems = ['l1', 'l2', 'l3']; // L1: repeat purchase, L2: retention, L3: recommendation

        // 1. Calculate average per loyalitas item
        foreach ($loyalitasItems as $item) {
            $scores = [];
            foreach ($responses as $response) {
                if (isset($response['loyalitas_answers'][$item])) {
                    $scores[] = $response['loyalitas_answers'][$item];
                }
            }
            $results['loyalitas_item_averages'][$item] = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
        }

        // 2. Calculate CLI (Customer Loyalitas Index) per item
        foreach ($results['loyalitas_item_averages'] as $item => $avg) {
            $results['cli_scores'][$item] = ($avg / 5) * (100/100) * 100;
        }

        // 3. Calculate total ILP
        $totalCli = array_sum($results['cli_scores']);
        $results['ilp_percentage'] = count($results['cli_scores']) > 0 ? $totalCli / count($results['cli_scores']) : 0;

        // 4. Determine interpretation (same scale as IKP)
        $ilp = $results['ilp_percentage'];
        if ($ilp >= 81) {
            $results['ilp_interpretation'] = 'Sangat Loyal';
        } elseif ($ilp >= 66) {
            $results['ilp_interpretation'] = 'Loyal';
        } elseif ($ilp >= 51) {
            $results['ilp_interpretation'] = 'Cukup Loyal';
        } elseif ($ilp >= 35) {
            $results['ilp_interpretation'] = 'Kurang Loyal';
        } else {
            $results['ilp_interpretation'] = 'Tidak Loyal';
        }

        return $results;
    }

    /**
     * Calculate Gap Analysis
     */
    public function calculateGapAnalysis($responses)
    {
        $results = [
            'item_gaps' => [],
            'dimension_gaps' => [],
            'gap_statistics' => []
        ];

        if (empty($responses)) {
            return $results;
        }

        // Define dimensions
        $dimensions = [
            'reliability' => ['r1', 'r2', 'r3', 'r4', 'r5', 'r6', 'r7'],
            'assurance' => ['a1', 'a2', 'a3', 'a4'],
            'tangible' => ['t1', 't2', 't3', 't4', 't5', 't6'],
            'empathy' => ['e1', 'e2', 'e3', 'e4', 'e5'],
            'responsiveness' => ['rs1', 'rs2'],
            'applicability' => ['ap1', 'ap2']
        ];

        // Calculate item gaps
        foreach ($dimensions as $dim => $items) {
            foreach ($items as $item) {
                // Access nested structure: harapan_answers.reliability.r1 and persepsi_answers.reliability.r1
                $impScores = [];
                $perfScores = [];

                foreach ($responses as $response) {
                    if (isset($response['harapan_answers'][$dim][$item])) {
                        $impScores[] = $response['harapan_answers'][$dim][$item];
                    }
                    if (isset($response['persepsi_answers'][$dim][$item])) {
                        $perfScores[] = $response['persepsi_answers'][$dim][$item];
                    }
                }

                $impAvg = count($impScores) > 0 ? array_sum($impScores) / count($impScores) : 0;
                $perfAvg = count($perfScores) > 0 ? array_sum($perfScores) / count($perfScores) : 0;

                $results['item_gaps'][$item] = $perfAvg - $impAvg;
            }
        }

        // Calculate dimension gaps
        foreach ($dimensions as $dim => $items) {
            $gapSum = 0;
            $count = 0;

            foreach ($items as $item) {
                if (isset($results['item_gaps'][$item])) {
                    $gapSum += $results['item_gaps'][$item];
                    $count++;
                }
            }

            $results['dimension_gaps'][$dim] = $count > 0 ? $gapSum / $count : 0;
        }

        // Calculate gap statistics (standard deviation)
        $gaps = array_values($results['item_gaps']);
        if (count($gaps) > 1) {
            $mean = array_sum($gaps) / count($gaps);
            $variance = 0;
            foreach ($gaps as $gap) {
                $variance += pow($gap - $mean, 2);
            }
            $results['gap_statistics']['standard_deviation'] = sqrt($variance / (count($gaps) - 1)); // n-1 for sample
            $results['gap_statistics']['mean_gap'] = $mean;
            $results['gap_statistics']['max_gap'] = max($gaps);
            $results['gap_statistics']['min_gap'] = min($gaps);
        }

        return $results;
    }

    /**
     * Generate recommendations based on gap analysis
     */
    private function generateRecommendations($gaps)
    {
        $recommendations = [];

        foreach ($gaps as $question => $gap) {
            if ($gap < -1) {
                $recommendations[] = "Prioritas tinggi: Tingkatkan performa pada aspek {$question} karena gap yang signifikan.";
            } elseif ($gap < 0) {
                $recommendations[] = "Perhatian: Perbaiki aspek {$question} untuk memenuhi ekspektasi peserta.";
            } else {
                $recommendations[] = "Bagus: Aspek {$question} sudah memenuhi atau melebihi ekspektasi.";
            }
        }

        return $recommendations;
    }

    /**
     * Calculate SERVQUAL scores if applicable
     */
    public function calculateServqualScores($responses)
    {
        // SERVQUAL dimensions: Tangibles, Reliability, Responsiveness, Assurance, Empathy
        $dimensions = [
            'tangibles' => ['q1', 'q2'],
            'reliability' => ['q3', 'q4'],
            'responsiveness' => ['q5', 'q6'],
            'assurance' => ['q7', 'q8'],
            'empathy' => ['q9', 'q10']
        ];

        $servqualResults = [];

        foreach ($dimensions as $dimension => $questions) {
            $harapanSum = 0;
            $persepsiSum = 0;
            $count = 0;

            foreach ($questions as $q) {
                $impQ = 'imp_' . $q;
                $perfQ = 'perf_' . $q;

                if (isset($responses[0][$impQ]) && isset($responses[0][$perfQ])) {
                    $harapanSum += array_sum(array_column($responses, $impQ)) / count($responses);
                    $persepsiSum += array_sum(array_column($responses, $perfQ)) / count($responses);
                    $count++;
                }
            }

            if ($count > 0) {
                $servqualResults[$dimension] = [
                    'harapan' => $harapanSum / $count,
                    'persepsi' => $persepsiSum / $count,
                    'gap' => ($persepsiSum / $count) - ($harapanSum / $count)
                ];
            }
        }

        return $servqualResults;
    }

    /**
     * Calculate loyalitas probabilities and predictions
     */
    public function calculateLoyalitasProbabilities($responses)
    {
        $results = [
            'total_respondents' => count($responses),
            'probabilities' => [
                1 => 0.00, // Sangat tidak setuju
                2 => 0.25, // Tidak setuju
                3 => 0.50, // Netral
                4 => 0.75, // Setuju
                5 => 1.00  // Sangat setuju
            ],
            'predictions' => []
        ];

        if (empty($responses)) {
            return $results;
        }

        // Questions to analyze: K1 (kepuasan), L1, L2, L3 (loyalitas)
        $questions = ['k1', 'l1', 'l2', 'l3'];

        foreach ($questions as $question) {
            if (!isset($responses[0][$question === 'k1' ? 'kepuasan_answers' : 'loyalitas_answers'][$question])) {
                continue;
            }

            $scores = array_column($responses, ($question === 'k1' ? 'kepuasan_answers' : 'loyalitas_answers') . ".{$question}");
            $totalRespondents = count($scores);

            // Count frequency per scale
            $scaleCounts = array_count_values($scores);
            $percentages = [];
            $percentageProbabilities = [];
            $frequencyProbabilities = [];

            for ($scale = 1; $scale <= 5; $scale++) {
                $count = $scaleCounts[$scale] ?? 0;
                $percentage = $totalRespondents > 0 ? ($count / $totalRespondents) * 100 : 0;
                $percentages[$scale] = $percentage;
                $percentageProbabilities[$scale] = $percentage * $results['probabilities'][$scale];
                $frequencyProbabilities[$scale] = $count * $results['probabilities'][$scale];
            }

            $totalPredictedLoyal = array_sum($frequencyProbabilities);

            $results['predictions'][$question] = [
                'scale_counts' => $scaleCounts,
                'percentages' => $percentages,
                'percentage_probabilities' => $percentageProbabilities,
                'frequency_probabilities' => $frequencyProbabilities,
                'total_predicted_loyal' => $totalPredictedLoyal,
                'loyalitas_percentage' => $totalRespondents > 0 ? ($totalPredictedLoyal / $totalRespondents) * 100 : 0
            ];
        }

        return $results;
    }

    /**
     * Calculate comprehensive survey results including all methodologies
     */
    public function calculateCompleteSurveyResults($responses)
    {
        $basicAnalysis = $this->calculateSurveyResults($responses);
        $ikpAnalysis = $this->calculateIKP($responses);
        $ilpAnalysis = $this->calculateILP($responses);
        $gapAnalysis = $this->calculateGapAnalysis($responses);
        $loyalitasProbabilities = $this->calculateLoyalitasProbabilities($responses);
        $demographicStatistics = $this->calculateDemographicStatistics($responses);
        $scaleFrequencyAnalysis = $this->calculateScaleFrequencyAnalysis($responses);
        $dashboardMetrics = $this->calculateDashboardMetrics($responses);

        $gapAnalysis['dimensions'] = $dashboardMetrics['dimensions'];

        return [
            'basic_analysis' => $basicAnalysis,
            'ikp_analysis' => $ikpAnalysis,
            'ilp_analysis' => $ilpAnalysis,
            'gap_analysis' => $gapAnalysis,
            'loyalitas_probabilities' => $loyalitasProbabilities,
            'demographic_statistics' => $demographicStatistics,
            'scale_frequency_analysis' => $scaleFrequencyAnalysis,
            'kepuasan_pelanggan' => $dashboardMetrics['kepuasan_pelanggan'],
            'harapan' => $dashboardMetrics['harapan'],
            'persepsi' => $dashboardMetrics['persepsi'],
        ];
    }

    /**
     * Calculate demographic statistics
     */
    public function calculateDemographicStatistics($responses)
    {
        $results = [
            'total_respondents' => count($responses),
            'gender_distribution' => [],
            'age_distribution' => [],
            'occupation_distribution' => [],
            'domicile_distribution' => [],
            'cross_analysis' => []
        ];

        if (empty($responses)) {
            return $results;
        }

        // Gender distribution
        $genderCounts = [];
        foreach ($responses as $response) {
            if (isset($response['profile_data']['jenis_kelamin'])) {
                $genderCounts[] = $response['profile_data']['jenis_kelamin'];
            }
        }
        $genderCounts = array_count_values($genderCounts);
        $totalRespondents = count($responses);

        foreach (['L', 'P'] as $gender) {
            $count = $genderCounts[$gender] ?? 0;
            $results['gender_distribution'][$gender === 'L' ? 'laki-laki' : 'perempuan'] = [
                'count' => $count,
                'percentage' => $totalRespondents > 0 ? ($count / $totalRespondents) * 100 : 0
            ];
        }

        // Age distribution - convert to age groups
        $ages = [];
        foreach ($responses as $response) {
            if (isset($response['profile_data']['usia'])) {
                $ages[] = $response['profile_data']['usia'];
            }
        }
        $ageGroups = ['<25' => 0, '25-34' => 0, '35-44' => 0, '45-54' => 0, '55-64' => 0, '>64' => 0];

        foreach ($ages as $age) {
            if ($age < 25) $ageGroups['<25']++;
            elseif ($age <= 34) $ageGroups['25-34']++;
            elseif ($age <= 44) $ageGroups['35-44']++;
            elseif ($age <= 54) $ageGroups['45-54']++;
            elseif ($age <= 64) $ageGroups['55-64']++;
            else $ageGroups['>64']++;
        }

        foreach ($ageGroups as $group => $count) {
            $results['age_distribution'][$group] = [
                'count' => $count,
                'percentage' => $totalRespondents > 0 ? ($count / $totalRespondents) * 100 : 0
            ];
        }

        // Occupation distribution
        $occupations = ['Karyawan swasta', 'Wiraswasta', 'PNS', 'Pelajar/Mahasiswa', 'Lainnya'];
        $occupationCounts = [];
        foreach ($responses as $response) {
            if (isset($response['profile_data']['pekerjaan'])) {
                $occupationCounts[] = $response['profile_data']['pekerjaan'];
            }
        }
        $occupationCounts = array_count_values($occupationCounts);

        foreach ($occupations as $occupation) {
            $count = $occupationCounts[$occupation] ?? 0;
            $results['occupation_distribution'][$occupation] = [
                'count' => $count,
                'percentage' => $totalRespondents > 0 ? ($count / $totalRespondents) * 100 : 0
            ];
        }

        // Domicile distribution
        $domiciles = ['DKI Jakarta', 'Jawa Barat', 'Jawa Timur', 'Jawa Tengah', 'Banten', 'Sulawesi', 'Sumatera', 'Kalimantan', 'Papua', 'Bali', 'NTB', 'Maluku'];
        $domicileCounts = array_count_values(array_column($responses, 'profile_data.domisili'));

        foreach ($domiciles as $domicile) {
            $count = $domicileCounts[$domicile] ?? 0;
            $results['domicile_distribution'][$domicile] = [
                'count' => $count,
                'percentage' => $totalRespondents > 0 ? ($count / $totalRespondents) * 100 : 0
            ];
        }

        // Cross analysis: Age × Gender
        foreach ($ageGroups as $ageGroup => $ageCount) {
            $results['cross_analysis']['age_gender'][$ageGroup] = [];
            $ageGroupRespondents = array_filter($responses, function($r) use ($ageGroup) {
                $age = $r['profile_data']['usia'] ?? 0;
                switch ($ageGroup) {
                    case '<25': return $age < 25;
                    case '25-34': return $age >= 25 && $age <= 34;
                    case '35-44': return $age >= 35 && $age <= 44;
                    case '45-54': return $age >= 45 && $age <= 54;
                    case '55-64': return $age >= 55 && $age <= 64;
                    case '>64': return $age > 64;
                    default: return false;
                }
            });

            $ageGroupCount = count($ageGroupRespondents);

            foreach (['L', 'P'] as $genderCode) {
                $genderLabel = $genderCode === 'L' ? 'laki-laki' : 'perempuan';
                $count = count(array_filter($ageGroupRespondents, function($r) use ($genderCode) {
                    return ($r['profile_data']['jenis_kelamin'] ?? '') === $genderCode;
                }));

                $results['cross_analysis']['age_gender'][$ageGroup][$genderLabel] = [
                    'count' => $count,
                    'percentage' => $ageGroupCount > 0 ? ($count / $ageGroupCount) * 100 : 0
                ];
            }
        }

        return $results;
    }

    /**
     * Calculate scale frequency analysis for survey questions
     */
    public function calculateScaleFrequencyAnalysis($responses)
    {
        $results = [
            'total_respondents' => count($responses),
            'scale_frequencies' => []
        ];

        if (empty($responses)) {
            return $results;
        }

        // Define all survey questions with their paths
        $questionMappings = [
            // Harapan questions
            'reliability.r1' => ['path' => ['harapan_answers', 'reliability', 'r1'], 'key' => 'r1'],
            'reliability.r2' => ['path' => ['harapan_answers', 'reliability', 'r2'], 'key' => 'r2'],
            'reliability.r3' => ['path' => ['harapan_answers', 'reliability', 'r3'], 'key' => 'r3'],
            'reliability.r4' => ['path' => ['harapan_answers', 'reliability', 'r4'], 'key' => 'r4'],
            'reliability.r5' => ['path' => ['harapan_answers', 'reliability', 'r5'], 'key' => 'r5'],
            'reliability.r6' => ['path' => ['harapan_answers', 'reliability', 'r6'], 'key' => 'r6'],
            'reliability.r7' => ['path' => ['harapan_answers', 'reliability', 'r7'], 'key' => 'r7'],
            'assurance.a1' => ['path' => ['harapan_answers', 'assurance', 'a1'], 'key' => 'a1'],
            'assurance.a2' => ['path' => ['harapan_answers', 'assurance', 'a2'], 'key' => 'a2'],
            'assurance.a3' => ['path' => ['harapan_answers', 'assurance', 'a3'], 'key' => 'a3'],
            'assurance.a4' => ['path' => ['harapan_answers', 'assurance', 'a4'], 'key' => 'a4'],
            'tangible.t1' => ['path' => ['harapan_answers', 'tangible', 't1'], 'key' => 't1'],
            'tangible.t2' => ['path' => ['harapan_answers', 'tangible', 't2'], 'key' => 't2'],
            'tangible.t3' => ['path' => ['harapan_answers', 'tangible', 't3'], 'key' => 't3'],
            'tangible.t4' => ['path' => ['harapan_answers', 'tangible', 't4'], 'key' => 't4'],
            'tangible.t5' => ['path' => ['harapan_answers', 'tangible', 't5'], 'key' => 't5'],
            'tangible.t6' => ['path' => ['harapan_answers', 'tangible', 't6'], 'key' => 't6'],
            'empathy.e1' => ['path' => ['harapan_answers', 'empathy', 'e1'], 'key' => 'e1'],
            'empathy.e2' => ['path' => ['harapan_answers', 'empathy', 'e2'], 'key' => 'e2'],
            'empathy.e3' => ['path' => ['harapan_answers', 'empathy', 'e3'], 'key' => 'e3'],
            'empathy.e4' => ['path' => ['harapan_answers', 'empathy', 'e4'], 'key' => 'e4'],
            'empathy.e5' => ['path' => ['harapan_answers', 'empathy', 'e5'], 'key' => 'e5'],
            'responsiveness.rs1' => ['path' => ['harapan_answers', 'responsiveness', 'rs1'], 'key' => 'rs1'],
            'responsiveness.rs2' => ['path' => ['harapan_answers', 'responsiveness', 'rs2'], 'key' => 'rs2'],
            'applicability.ap1' => ['path' => ['harapan_answers', 'applicability', 'ap1'], 'key' => 'ap1'],
            'applicability.ap2' => ['path' => ['harapan_answers', 'applicability', 'ap2'], 'key' => 'ap2'],
            // Persepsi questions
            'persepsi.reliability.r1' => ['path' => ['persepsi_answers', 'reliability', 'r1'], 'key' => 'r1'],
            'persepsi.reliability.r2' => ['path' => ['persepsi_answers', 'reliability', 'r2'], 'key' => 'r2'],
            'persepsi.reliability.r3' => ['path' => ['persepsi_answers', 'reliability', 'r3'], 'key' => 'r3'],
            'persepsi.reliability.r4' => ['path' => ['persepsi_answers', 'reliability', 'r4'], 'key' => 'r4'],
            'persepsi.reliability.r5' => ['path' => ['persepsi_answers', 'reliability', 'r5'], 'key' => 'r5'],
            'persepsi.reliability.r6' => ['path' => ['persepsi_answers', 'reliability', 'r6'], 'key' => 'r6'],
            'persepsi.reliability.r7' => ['path' => ['persepsi_answers', 'reliability', 'r7'], 'key' => 'r7'],
            'persepsi.assurance.a1' => ['path' => ['persepsi_answers', 'assurance', 'a1'], 'key' => 'a1'],
            'persepsi.assurance.a2' => ['path' => ['persepsi_answers', 'assurance', 'a2'], 'key' => 'a2'],
            'persepsi.assurance.a3' => ['path' => ['persepsi_answers', 'assurance', 'a3'], 'key' => 'a3'],
            'persepsi.assurance.a4' => ['path' => ['persepsi_answers', 'assurance', 'a4'], 'key' => 'a4'],
            'persepsi.tangible.t1' => ['path' => ['persepsi_answers', 'tangible', 't1'], 'key' => 't1'],
            'persepsi.tangible.t2' => ['path' => ['persepsi_answers', 'tangible', 't2'], 'key' => 't2'],
            'persepsi.tangible.t3' => ['path' => ['persepsi_answers', 'tangible', 't3'], 'key' => 't3'],
            'persepsi.tangible.t4' => ['path' => ['persepsi_answers', 'tangible', 't4'], 'key' => 't4'],
            'persepsi.tangible.t5' => ['path' => ['persepsi_answers', 'tangible', 't5'], 'key' => 't5'],
            'persepsi.tangible.t6' => ['path' => ['persepsi_answers', 'tangible', 't6'], 'key' => 't6'],
            'persepsi.empathy.e1' => ['path' => ['persepsi_answers', 'empathy', 'e1'], 'key' => 'e1'],
            'persepsi.empathy.e2' => ['path' => ['persepsi_answers', 'empathy', 'e2'], 'key' => 'e2'],
            'persepsi.empathy.e3' => ['path' => ['persepsi_answers', 'empathy', 'e3'], 'key' => 'e3'],
            'persepsi.empathy.e4' => ['path' => ['persepsi_answers', 'empathy', 'e4'], 'key' => 'e4'],
            'persepsi.empathy.e5' => ['path' => ['persepsi_answers', 'empathy', 'e5'], 'key' => 'e5'],
            'persepsi.responsiveness.rs1' => ['path' => ['persepsi_answers', 'responsiveness', 'rs1'], 'key' => 'rs1'],
            'persepsi.responsiveness.rs2' => ['path' => ['persepsi_answers', 'responsiveness', 'rs2'], 'key' => 'rs2'],
            'persepsi.applicability.ap1' => ['path' => ['persepsi_answers', 'applicability', 'ap1'], 'key' => 'ap1'],
            'persepsi.applicability.ap2' => ['path' => ['persepsi_answers', 'applicability', 'ap2'], 'key' => 'ap2'],
            // Kepuasan questions
            'kepuasan.k1' => ['path' => ['kepuasan_answers', 'k1'], 'key' => 'k1'],
            'kepuasan.k2' => ['path' => ['kepuasan_answers', 'k2'], 'key' => 'k2'],
            'kepuasan.k3' => ['path' => ['kepuasan_answers', 'k3'], 'key' => 'k3'],
            // Loyalitas questions
            'loyalitas.l1' => ['path' => ['loyalitas_answers', 'l1'], 'key' => 'l1'],
            'loyalitas.l2' => ['path' => ['loyalitas_answers', 'l2'], 'key' => 'l2'],
            'loyalitas.l3' => ['path' => ['loyalitas_answers', 'l3'], 'key' => 'l3']
        ];

        foreach ($questionMappings as $questionKey => $mapping) {
            $scores = [];
            foreach ($responses as $response) {
                $value = $response;
                foreach ($mapping['path'] as $key) {
                    if (isset($value[$key])) {
                        $value = $value[$key];
                    } else {
                        $value = null;
                        break;
                    }
                }
                if ($value !== null) {
                    $scores[] = $value;
                }
            }
            
            if (empty($scores)) continue;

            $scaleCounts = array_count_values($scores);
            $results['scale_frequencies'][$mapping['key']] = [];
            for ($scale = 1; $scale <= 5; $scale++) {
                $count = $scaleCounts[$scale] ?? 0;
                $results['scale_frequencies'][$mapping['key']][$scale] = [
                    'count' => $count,
                    'percentage' => count($scores) > 0 ? ($count / count($scores)) * 100 : 0
                ];
            }
        }

        return $results;
    }

    /**
     * Calculate aggregated metrics required by the dashboard view.
     */
    protected function calculateDashboardMetrics(array $responses): array
    {
        $summary = [
            'harapan' => ['overall_mean' => 0, 'total_items' => 0],
            'persepsi' => ['overall_mean' => 0, 'total_items' => 0],
            'kepuasan_pelanggan' => ['overall_mean' => 0, 'total_items' => 0],
            'dimensions' => [],
        ];

        if (empty($responses)) {
            return $summary;
        }

        $dimensionConfigs = $this->getDimensionsConfigForGap();
        $dimensionAccumulator = [];
        foreach ($dimensionConfigs as $config) {
            $dimensionAccumulator[$config['prefix']] = [
                'name' => $config['name'],
                'harapan_total' => 0,
                'harapan_count' => 0,
                'persepsi_total' => 0,
                'persepsi_count' => 0,
            ];
        }

        $harapanTotal = 0;
        $harapanCount = 0;
        $persepsiTotal = 0;
        $persepsiCount = 0;
        $kepuasanTotal = 0;
        $kepuasanCount = 0;

        foreach ($responses as $response) {
            $harapanAnswers = $response['harapan_answers'] ?? [];
            if (!is_array($harapanAnswers)) {
                $harapanAnswers = [];
            }
            foreach ($harapanAnswers as $dimension => $items) {
                if (!is_array($items)) {
                    continue;
                }
                foreach ($items as $value) {
                    if (!is_numeric($value)) {
                        continue;
                    }
                    $harapanTotal += $value;
                    $harapanCount++;
                    if (isset($dimensionAccumulator[$dimension])) {
                        $dimensionAccumulator[$dimension]['harapan_total'] += $value;
                        $dimensionAccumulator[$dimension]['harapan_count']++;
                    }
                }
            }

            $persepsiAnswers = $response['persepsi_answers'] ?? [];
            if (!is_array($persepsiAnswers)) {
                $persepsiAnswers = [];
            }
            foreach ($persepsiAnswers as $dimension => $items) {
                if (!is_array($items)) {
                    continue;
                }
                foreach ($items as $value) {
                    if (!is_numeric($value)) {
                        continue;
                    }
                    $persepsiTotal += $value;
                    $persepsiCount++;
                    if (isset($dimensionAccumulator[$dimension])) {
                        $dimensionAccumulator[$dimension]['persepsi_total'] += $value;
                        $dimensionAccumulator[$dimension]['persepsi_count']++;
                    }
                }
            }

            $kepuasanAnswers = $response['kepuasan_answers'] ?? [];
            if (!is_array($kepuasanAnswers)) {
                $kepuasanAnswers = [];
            }
            foreach ($kepuasanAnswers as $value) {
                if (!is_numeric($value)) {
                    continue;
                }
                $kepuasanTotal += $value;
                $kepuasanCount++;
            }
        }

        $summary['harapan']['overall_mean'] = $harapanCount > 0 ? round($harapanTotal / $harapanCount, 2) : 0;
        $summary['harapan']['total_items'] = $harapanCount;

        $summary['persepsi']['overall_mean'] = $persepsiCount > 0 ? round($persepsiTotal / $persepsiCount, 2) : 0;
        $summary['persepsi']['total_items'] = $persepsiCount;

        $summary['kepuasan_pelanggan']['overall_mean'] = $kepuasanCount > 0 ? round($kepuasanTotal / $kepuasanCount, 2) : 0;
        $summary['kepuasan_pelanggan']['total_items'] = $kepuasanCount;

        foreach ($dimensionConfigs as $config) {
            $key = $config['prefix'];
            $dimensionData = $dimensionAccumulator[$key] ?? null;
            if (!$dimensionData) {
                continue;
            }

            $hasHarapan = $dimensionData['harapan_count'] > 0;
            $hasPersepsi = $dimensionData['persepsi_count'] > 0;

            if (!$hasHarapan || !$hasPersepsi) {
                continue;
            }

            $harapanMean = $hasHarapan ? $dimensionData['harapan_total'] / $dimensionData['harapan_count'] : 0;
            $persepsiMean = $hasPersepsi ? $dimensionData['persepsi_total'] / $dimensionData['persepsi_count'] : 0;

            $summary['dimensions'][] = [
                'name' => $dimensionData['name'],
                'harapan_mean' => round($harapanMean, 2),
                'persepsi_mean' => round($persepsiMean, 2),
                'gap' => round($persepsiMean - $harapanMean, 2),
            ];
        }

        return $summary;
    }

    /**
     * Get dimensions configuration for charts
     */
    public function getDimensionsConfig()
    {
        return [
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
    }

    /**
     * Get dimensions configuration for gap charts
     */
    public function getDimensionsConfigForGap()
    {
        return [
            [
                'name' => 'Reliability',
                'prefix' => 'reliability',
                'icon' => 'chart-bar',
                'gradient' => 'from-blue-500 via-purple-500 to-pink-500',
                'headerGradient' => 'from-blue-500 to-purple-600',
                'titleGradient' => 'from-blue-600 to-purple-600',
                'chartId' => 'reliability-gap-chart',
                'loadingId' => 'reliability-gap-loading',
            ],
            [
                'name' => 'Tangible',
                'prefix' => 'tangible',
                'icon' => 'building',
                'gradient' => 'from-green-500 via-teal-500 to-cyan-500',
                'headerGradient' => 'from-green-500 to-teal-600',
                'titleGradient' => 'from-green-600 to-teal-600',
                'chartId' => 'tangible-gap-chart',
                'loadingId' => 'tangible-gap-loading',
            ],
            [
                'name' => 'Responsiveness',
                'prefix' => 'responsiveness',
                'icon' => 'clock',
                'gradient' => 'from-yellow-500 via-orange-500 to-red-500',
                'headerGradient' => 'from-yellow-500 to-orange-600',
                'titleGradient' => 'from-yellow-600 to-orange-600',
                'chartId' => 'responsiveness-gap-chart',
                'loadingId' => 'responsiveness-gap-loading',
            ],
            [
                'name' => 'Assurance',
                'prefix' => 'assurance',
                'icon' => 'shield-alt',
                'gradient' => 'from-purple-500 via-pink-500 to-rose-500',
                'headerGradient' => 'from-purple-500 to-pink-600',
                'titleGradient' => 'from-purple-600 to-pink-600',
                'chartId' => 'assurance-gap-chart',
                'loadingId' => 'assurance-gap-loading',
            ],
            [
                'name' => 'Empathy',
                'prefix' => 'empathy',
                'icon' => 'heart',
                'gradient' => 'from-red-500 via-pink-500 to-purple-500',
                'headerGradient' => 'from-red-500 to-pink-600',
                'titleGradient' => 'from-red-600 to-pink-600',
                'chartId' => 'empathy-gap-chart',
                'loadingId' => 'empathy-gap-loading',
            ],
            [
                'name' => 'Applicability',
                'prefix' => 'applicability',
                'icon' => 'cogs',
                'gradient' => 'from-indigo-500 via-blue-500 to-cyan-500',
                'headerGradient' => 'from-indigo-500 to-blue-600',
                'titleGradient' => 'from-indigo-600 to-blue-600',
                'chartId' => 'applicability-gap-chart',
                'loadingId' => 'applicability-gap-loading',
            ],
        ];
    }

    /**
     * Calculate detailed kepuasan metrics
     */
    public function calculateKepuasanDetails($responses)
    {
        $results = [
            'avgK1' => 0,
            'avgK2' => 0,
            'total_rata_k3' => 0,
            'total_rata_k2' => 0,
            'gap' => 0,
            'k1_count' => 0,
            'k1_rata_count_1' => 0,
            'k1_rata_count_2' => 0,
            'k1_rata_count_3' => 0,
            'k1_rata_count_4' => 0,
            'k1_rata_count_5' => 0,
            'kepuasanDistribution' => [
                'sangat_puas' => 0,
                'puas' => 0,
                'cukup_puas' => 0,
                'kurang_puas' => 0,
                'tidak_puas' => 0
            ],
            'potensiLoyal' => 0
        ];

        if (empty($responses)) {
            return $results;
        }

        // Hitung rata-rata kepuasan untuk pertanyaan k1 dan k2
        $kepuasanK1 = [];
        $kepuasanK2 = [];

        foreach ($responses as $response) {
            if (isset($response['kepuasan_answers']['k1'])) {
                $kepuasanK1[] = $response['kepuasan_answers']['k1'];
            }
            if (isset($response['kepuasan_answers']['k2'])) {
                $kepuasanK2[] = $response['kepuasan_answers']['k2'];
            }
        }

        $results['avgK1'] = count($kepuasanK1) > 0 ? array_sum($kepuasanK1) / count($kepuasanK1) : 0;
        $results['avgK2'] = count($kepuasanK2) > 0 ? array_sum($kepuasanK2) / count($kepuasanK2) : 0;

        // Hitung total rata-rata K3 (layanan ideal) dan K2 (harapan)
        $results['total_rata_k3'] = $results['avgK1']; // K3 adalah pertanyaan kepuasan pertama (layanan ideal)
        $results['total_rata_k2'] = $results['avgK2']; // K2 adalah pertanyaan kepuasan kedua (harapan)
        $results['gap'] = $results['total_rata_k3'] - $results['total_rata_k2']; // Gap antara ideal dan harapan

        // Hitung distribusi kepuasan
        $results['k1_count'] = count($kepuasanK1);
        foreach ($kepuasanK1 as $score) {
            if ($score >= 4.5) $results['k1_rata_count_5']++;
            elseif ($score >= 3.5) $results['k1_rata_count_4']++;
            elseif ($score >= 2.5) $results['k1_rata_count_3']++;
            elseif ($score >= 1.5) $results['k1_rata_count_2']++;
            else $results['k1_rata_count_1']++;
        }

        $results['kepuasanDistribution'] = [
            'sangat_puas' => $results['k1_rata_count_5'],
            'puas' => $results['k1_rata_count_4'],
            'cukup_puas' => $results['k1_rata_count_3'],
            'kurang_puas' => $results['k1_rata_count_2'],
            'tidak_puas' => $results['k1_rata_count_1']
        ];

        // Hitung potensi loyalitas
        $loyalitasScores = [];
        foreach ($responses as $response) {
            if (isset($response['loyalitas_answers'])) {
                $loyalitas = $response['loyalitas_answers'];
                $avgLoyalitas = 0;
                $count = 0;
                if (isset($loyalitas['l1'])) { $avgLoyalitas += $loyalitas['l1']; $count++; }
                if (isset($loyalitas['l2'])) { $avgLoyalitas += $loyalitas['l2']; $count++; }
                if (isset($loyalitas['l3'])) { $avgLoyalitas += $loyalitas['l3']; $count++; }
                if ($count > 0) {
                    $loyalitasScores[] = $avgLoyalitas / $count;
                }
            }
        }

        foreach ($loyalitasScores as $score) {
            if ($score >= 4.0) $results['potensiLoyal']++; // Berpotensi loyal jika skor >= 4
        }

        return $results;
    }

    /**
     * Calculate detailed loyalitas metrics
     */
    public function calculateLoyalitasDetails($responses)
    {
        $results = [
            'avgL1' => 0,
            'avgL2' => 0,
            'avgL3' => 0,
            'l1Distribution' => [
                'sangat_setuju' => 0,
                'setuju' => 0,
                'netral' => 0,
                'tidak_setuju' => 0,
                'sangat_tidak_setuju' => 0
            ],
            'l2Distribution' => [
                'sangat_setuju' => 0,
                'setuju' => 0,
                'netral' => 0,
                'tidak_setuju' => 0,
                'sangat_tidak_setuju' => 0
            ],
            'l3Distribution' => [
                'sangat_setuju' => 0,
                'setuju' => 0,
                'netral' => 0,
                'tidak_setuju' => 0,
                'sangat_tidak_setuju' => 0
            ]
        ];

        if (empty($responses)) {
            return $results;
        }

        // Hitung rata-rata per pertanyaan loyalitas
        $l1Scores = [];
        $l2Scores = [];
        $l3Scores = [];

        foreach ($responses as $response) {
            if (isset($response['loyalitas_answers'])) {
                $loyalitas = $response['loyalitas_answers'];
                if (isset($loyalitas['l1'])) $l1Scores[] = $loyalitas['l1'];
                if (isset($loyalitas['l2'])) $l2Scores[] = $loyalitas['l2'];
                if (isset($loyalitas['l3'])) $l3Scores[] = $loyalitas['l3'];
            }
        }

        $results['avgL1'] = count($l1Scores) > 0 ? array_sum($l1Scores) / count($l1Scores) : 0;
        $results['avgL2'] = count($l2Scores) > 0 ? array_sum($l2Scores) / count($l2Scores) : 0;
        $results['avgL3'] = count($l3Scores) > 0 ? array_sum($l3Scores) / count($l3Scores) : 0;

        // Hitung distribusi untuk setiap pertanyaan
        $results['l1Distribution'] = $this->calculateDistribution($l1Scores);
        $results['l2Distribution'] = $this->calculateDistribution($l2Scores);
        $results['l3Distribution'] = $this->calculateDistribution($l3Scores);

        return $results;
    }

    /**
     * Calculate distribution for scores
     */
    private function calculateDistribution($scores)
    {
        $distribution = [
            'sangat_setuju' => 0,
            'setuju' => 0,
            'netral' => 0,
            'tidak_setuju' => 0,
            'sangat_tidak_setuju' => 0
        ];

        foreach ($scores as $score) {
            if ($score >= 4.5) $distribution['sangat_setuju']++;
            elseif ($score >= 3.5) $distribution['setuju']++;
            elseif ($score >= 2.5) $distribution['netral']++;
            elseif ($score >= 1.5) $distribution['tidak_setuju']++;
            else $distribution['sangat_tidak_setuju']++;
        }

        return $distribution;
    }
}