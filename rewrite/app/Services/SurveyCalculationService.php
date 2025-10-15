<?php

namespace App\Services;

use App\Models\PelatihanSurveyResponse;

class SurveyCalculationService
{
    /**
     * Calculate survey results based on responses
     * This implements calculations similar to the survey application methodology
     */
    public function calculateSurveyResults($responses)
    {
        // Assuming responses is an array of survey answers
        // Structure: ['importance' => [...], 'performance' => [...], 'satisfaction' => [...], 'loyalty' => [...], 'demographics' => [...]]

        $results = [
            'total_respondents' => count($responses),
            'importance_scores' => [],
            'performance_scores' => [],
            'gap_scores' => [],
            'satisfaction_score' => 0,
            'loyalty_score' => 0,
            'recommendations' => []
        ];

        if (empty($responses)) {
            return $results;
        }

        // Calculate importance and performance averages
        $importanceQuestions = ['imp1', 'imp2', 'imp3', 'imp4', 'imp5', 'imp6']; // Adjust based on actual questions
        $performanceQuestions = ['perf1', 'perf2', 'perf3', 'perf4', 'perf5', 'perf6'];

        foreach ($importanceQuestions as $q) {
            $scores = array_column($responses, $q);
            $results['importance_scores'][$q] = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
        }

        foreach ($performanceQuestions as $q) {
            $scores = array_column($responses, $q);
            $results['performance_scores'][$q] = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
        }

        // Calculate gaps (Performance - Importance, negative gap indicates problem area)
        foreach ($importanceQuestions as $index => $impQ) {
            $perfQ = $performanceQuestions[$index];
            $gap = $results['performance_scores'][$perfQ] - $results['importance_scores'][$impQ];
            $results['gap_scores'][$impQ] = $gap;
        }

        // Overall satisfaction score (average of performance scores)
        $results['satisfaction_score'] = array_sum($results['performance_scores']) / count($results['performance_scores']);

        // Loyalty score calculation (based on loyalty questions if available)
        // Assuming loyalty questions exist in responses
        $loyaltyQuestions = ['loyalty1', 'loyalty2', 'loyalty3'];
        $loyaltyScores = [];
        foreach ($loyaltyQuestions as $q) {
            if (isset($responses[0][$q])) {
                $scores = array_column($responses, $q);
                $loyaltyScores[] = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
            }
        }
        $results['loyalty_score'] = count($loyaltyScores) > 0 ? array_sum($loyaltyScores) / count($loyaltyScores) : 0;

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

        // 1. Calculate average per item for importance and performance
        $importanceAverages = [];
        $performanceAverages = [];
        $totalImportance = 0;

        foreach ($dimensions as $dim => $items) {
            foreach ($items as $item) {
                // Access nested structure: importance_answers[reliability][r1]
                $impScores = [];
                $perfScores = [];
                
                foreach ($responses as $response) {
                    if (isset($response['importance_answers'][$dim][$item])) {
                        $impScores[] = $response['importance_answers'][$dim][$item];
                    }
                    if (isset($response['performance_answers'][$dim][$item])) {
                        $perfScores[] = $response['performance_answers'][$dim][$item];
                    }
                }
                
                $importanceAverages[$item] = count($impScores) > 0 ? array_sum($impScores) / count($impScores) : 0;
                $totalImportance += $importanceAverages[$item];
                $performanceAverages[$item] = count($perfScores) > 0 ? array_sum($perfScores) / count($perfScores) : 0;
            }
        }

        $results['item_averages'] = [
            'importance' => $importanceAverages,
            'performance' => $performanceAverages
        ];

        // 2. Calculate total average per dimension
        foreach ($dimensions as $dim => $items) {
            $impSum = 0;
            $perfSum = 0;
            $count = 0;

            foreach ($items as $item) {
                if (isset($importanceAverages[$item])) {
                    $impSum += $importanceAverages[$item];
                    $count++;
                }
                if (isset($performanceAverages[$item])) {
                    $perfSum += $performanceAverages[$item];
                }
            }

            $results['dimension_averages'][$dim] = [
                'importance' => $count > 0 ? $impSum / $count : 0,
                'performance' => $count > 0 ? $perfSum / $count : 0
            ];
        }

        // 3. Calculate Weighting Factor (WF) for each item
        foreach ($importanceAverages as $item => $avg) {
            $results['weighting_factors'][$item] = $totalImportance > 0 ? $avg / $totalImportance : 0;
        }

        // 4. Calculate Weighted Score (WS) for each item
        foreach ($performanceAverages as $item => $perfAvg) {
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
            'loyalty_item_averages' => [],
            'cli_scores' => [],
            'ilp_percentage' => 0,
            'ilp_interpretation' => ''
        ];

        if (empty($responses)) {
            return $results;
        }

        $loyaltyItems = ['l1', 'l2', 'l3']; // L1: repeat purchase, L2: retention, L3: recommendation

        // 1. Calculate average per loyalty item
        foreach ($loyaltyItems as $item) {
            $scores = [];
            foreach ($responses as $response) {
                if (isset($response['loyalty_answers'][$item])) {
                    $scores[] = $response['loyalty_answers'][$item];
                }
            }
            $results['loyalty_item_averages'][$item] = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
        }

        // 2. Calculate CLI (Customer Loyalty Index) per item
        foreach ($results['loyalty_item_averages'] as $item => $avg) {
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
                // Access nested structure: importance_answers.reliability.r1 and performance_answers.reliability.r1
                if (isset($responses[0]["importance_answers"][$dim][$item]) && isset($responses[0]["performance_answers"][$dim][$item])) {
                    $impScores = array_column($responses, "importance_answers.{$dim}.{$item}");
                    $perfScores = array_column($responses, "performance_answers.{$dim}.{$item}");

                    $impAvg = count($impScores) > 0 ? array_sum($impScores) / count($impScores) : 0;
                    $perfAvg = count($perfScores) > 0 ? array_sum($perfScores) / count($perfScores) : 0;

                    $results['item_gaps'][$item] = $perfAvg - $impAvg;
                }
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
            $importanceSum = 0;
            $performanceSum = 0;
            $count = 0;

            foreach ($questions as $q) {
                $impQ = 'imp_' . $q;
                $perfQ = 'perf_' . $q;

                if (isset($responses[0][$impQ]) && isset($responses[0][$perfQ])) {
                    $importanceSum += array_sum(array_column($responses, $impQ)) / count($responses);
                    $performanceSum += array_sum(array_column($responses, $perfQ)) / count($responses);
                    $count++;
                }
            }

            if ($count > 0) {
                $servqualResults[$dimension] = [
                    'importance' => $importanceSum / $count,
                    'performance' => $performanceSum / $count,
                    'gap' => ($performanceSum / $count) - ($importanceSum / $count)
                ];
            }
        }

        return $servqualResults;
    }

    /**
     * Calculate loyalty probabilities and predictions
     */
    public function calculateLoyaltyProbabilities($responses)
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

        // Questions to analyze: K1 (satisfaction), L1, L2, L3 (loyalty)
        $questions = ['k1', 'l1', 'l2', 'l3'];

        foreach ($questions as $question) {
            if (!isset($responses[0][$question === 'k1' ? 'satisfaction_answers' : 'loyalty_answers'][$question])) {
                continue;
            }

            $scores = array_column($responses, ($question === 'k1' ? 'satisfaction_answers' : 'loyalty_answers') . ".{$question}");
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
                'loyalty_percentage' => $totalRespondents > 0 ? ($totalPredictedLoyal / $totalRespondents) * 100 : 0
            ];
        }

        return $results;
    }

    /**
     * Calculate comprehensive survey results including all methodologies
     */
    public function calculateCompleteSurveyResults($responses)
    {
        return [
            'basic_analysis' => $this->calculateSurveyResults($responses),
            'ikp_analysis' => $this->calculateIKP($responses),
            'ilp_analysis' => $this->calculateILP($responses),
            'gap_analysis' => $this->calculateGapAnalysis($responses),
            'loyalty_probabilities' => $this->calculateLoyaltyProbabilities($responses),
            'demographic_statistics' => $this->calculateDemographicStatistics($responses),
            'scale_frequency_analysis' => $this->calculateScaleFrequencyAnalysis($responses)
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
            // Importance questions
            'reliability.r1' => ['path' => ['importance_answers', 'reliability', 'r1'], 'key' => 'r1'],
            'reliability.r2' => ['path' => ['importance_answers', 'reliability', 'r2'], 'key' => 'r2'],
            'reliability.r3' => ['path' => ['importance_answers', 'reliability', 'r3'], 'key' => 'r3'],
            'reliability.r4' => ['path' => ['importance_answers', 'reliability', 'r4'], 'key' => 'r4'],
            'reliability.r5' => ['path' => ['importance_answers', 'reliability', 'r5'], 'key' => 'r5'],
            'reliability.r6' => ['path' => ['importance_answers', 'reliability', 'r6'], 'key' => 'r6'],
            'reliability.r7' => ['path' => ['importance_answers', 'reliability', 'r7'], 'key' => 'r7'],
            'assurance.a1' => ['path' => ['importance_answers', 'assurance', 'a1'], 'key' => 'a1'],
            'assurance.a2' => ['path' => ['importance_answers', 'assurance', 'a2'], 'key' => 'a2'],
            'assurance.a3' => ['path' => ['importance_answers', 'assurance', 'a3'], 'key' => 'a3'],
            'assurance.a4' => ['path' => ['importance_answers', 'assurance', 'a4'], 'key' => 'a4'],
            'tangible.t1' => ['path' => ['importance_answers', 'tangible', 't1'], 'key' => 't1'],
            'tangible.t2' => ['path' => ['importance_answers', 'tangible', 't2'], 'key' => 't2'],
            'tangible.t3' => ['path' => ['importance_answers', 'tangible', 't3'], 'key' => 't3'],
            'tangible.t4' => ['path' => ['importance_answers', 'tangible', 't4'], 'key' => 't4'],
            'tangible.t5' => ['path' => ['importance_answers', 'tangible', 't5'], 'key' => 't5'],
            'tangible.t6' => ['path' => ['importance_answers', 'tangible', 't6'], 'key' => 't6'],
            'empathy.e1' => ['path' => ['importance_answers', 'empathy', 'e1'], 'key' => 'e1'],
            'empathy.e2' => ['path' => ['importance_answers', 'empathy', 'e2'], 'key' => 'e2'],
            'empathy.e3' => ['path' => ['importance_answers', 'empathy', 'e3'], 'key' => 'e3'],
            'empathy.e4' => ['path' => ['importance_answers', 'empathy', 'e4'], 'key' => 'e4'],
            'empathy.e5' => ['path' => ['importance_answers', 'empathy', 'e5'], 'key' => 'e5'],
            'responsiveness.rs1' => ['path' => ['importance_answers', 'responsiveness', 'rs1'], 'key' => 'rs1'],
            'responsiveness.rs2' => ['path' => ['importance_answers', 'responsiveness', 'rs2'], 'key' => 'rs2'],
            'applicability.ap1' => ['path' => ['importance_answers', 'applicability', 'ap1'], 'key' => 'ap1'],
            'applicability.ap2' => ['path' => ['importance_answers', 'applicability', 'ap2'], 'key' => 'ap2'],
            // Performance questions
            'performance.reliability.r1' => ['path' => ['performance_answers', 'reliability', 'r1'], 'key' => 'r1'],
            'performance.reliability.r2' => ['path' => ['performance_answers', 'reliability', 'r2'], 'key' => 'r2'],
            'performance.reliability.r3' => ['path' => ['performance_answers', 'reliability', 'r3'], 'key' => 'r3'],
            'performance.reliability.r4' => ['path' => ['performance_answers', 'reliability', 'r4'], 'key' => 'r4'],
            'performance.reliability.r5' => ['path' => ['performance_answers', 'reliability', 'r5'], 'key' => 'r5'],
            'performance.reliability.r6' => ['path' => ['performance_answers', 'reliability', 'r6'], 'key' => 'r6'],
            'performance.reliability.r7' => ['path' => ['performance_answers', 'reliability', 'r7'], 'key' => 'r7'],
            'performance.assurance.a1' => ['path' => ['performance_answers', 'assurance', 'a1'], 'key' => 'a1'],
            'performance.assurance.a2' => ['path' => ['performance_answers', 'assurance', 'a2'], 'key' => 'a2'],
            'performance.assurance.a3' => ['path' => ['performance_answers', 'assurance', 'a3'], 'key' => 'a3'],
            'performance.assurance.a4' => ['path' => ['performance_answers', 'assurance', 'a4'], 'key' => 'a4'],
            'performance.tangible.t1' => ['path' => ['performance_answers', 'tangible', 't1'], 'key' => 't1'],
            'performance.tangible.t2' => ['path' => ['performance_answers', 'tangible', 't2'], 'key' => 't2'],
            'performance.tangible.t3' => ['path' => ['performance_answers', 'tangible', 't3'], 'key' => 't3'],
            'performance.tangible.t4' => ['path' => ['performance_answers', 'tangible', 't4'], 'key' => 't4'],
            'performance.tangible.t5' => ['path' => ['performance_answers', 'tangible', 't5'], 'key' => 't5'],
            'performance.tangible.t6' => ['path' => ['performance_answers', 'tangible', 't6'], 'key' => 't6'],
            'performance.empathy.e1' => ['path' => ['performance_answers', 'empathy', 'e1'], 'key' => 'e1'],
            'performance.empathy.e2' => ['path' => ['performance_answers', 'empathy', 'e2'], 'key' => 'e2'],
            'performance.empathy.e3' => ['path' => ['performance_answers', 'empathy', 'e3'], 'key' => 'e3'],
            'performance.empathy.e4' => ['path' => ['performance_answers', 'empathy', 'e4'], 'key' => 'e4'],
            'performance.empathy.e5' => ['path' => ['performance_answers', 'empathy', 'e5'], 'key' => 'e5'],
            'performance.responsiveness.rs1' => ['path' => ['performance_answers', 'responsiveness', 'rs1'], 'key' => 'rs1'],
            'performance.responsiveness.rs2' => ['path' => ['performance_answers', 'responsiveness', 'rs2'], 'key' => 'rs2'],
            'performance.applicability.ap1' => ['path' => ['performance_answers', 'applicability', 'ap1'], 'key' => 'ap1'],
            'performance.applicability.ap2' => ['path' => ['performance_answers', 'applicability', 'ap2'], 'key' => 'ap2'],
            // Satisfaction questions
            'satisfaction.k1' => ['path' => ['satisfaction_answers', 'k1'], 'key' => 'k1'],
            'satisfaction.k2' => ['path' => ['satisfaction_answers', 'k2'], 'key' => 'k2'],
            'satisfaction.k3' => ['path' => ['satisfaction_answers', 'k3'], 'key' => 'k3'],
            // Loyalty questions
            'loyalty.l1' => ['path' => ['loyalty_answers', 'l1'], 'key' => 'l1'],
            'loyalty.l2' => ['path' => ['loyalty_answers', 'l2'], 'key' => 'l2'],
            'loyalty.l3' => ['path' => ['loyalty_answers', 'l3'], 'key' => 'l3']
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
}