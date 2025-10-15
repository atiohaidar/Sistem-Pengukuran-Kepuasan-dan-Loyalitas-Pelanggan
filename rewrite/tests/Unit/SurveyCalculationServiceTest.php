<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\SurveyCalculationService;
use App\Models\PelatihanSurveyResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyCalculationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SurveyCalculationService();
    }

    public function testCalculateSurveyResultsWithEmptyResponses()
    {
        $responses = [];
        $results = $this->service->calculateSurveyResults($responses);

        $this->assertEquals(0, $results['total_respondents']);
        $this->assertEmpty($results['importance_scores']);
        $this->assertEmpty($results['performance_scores']);
        $this->assertEmpty($results['gap_scores']);
        $this->assertEquals(0, $results['satisfaction_score']);
        $this->assertEquals(0, $results['loyalty_score']);
        $this->assertEmpty($results['recommendations']);
    }

    public function testCalculateSurveyResultsWithSampleData()
    {
        $responses = [
            [
                'imp1' => 4, 'imp2' => 5, 'imp3' => 3, 'imp4' => 4, 'imp5' => 5, 'imp6' => 4,
                'perf1' => 3, 'perf2' => 4, 'perf3' => 2, 'perf4' => 3, 'perf5' => 4, 'perf6' => 3,
                'loyalty1' => 4, 'loyalty2' => 5, 'loyalty3' => 4
            ],
            [
                'imp1' => 5, 'imp2' => 4, 'imp3' => 4, 'imp4' => 5, 'imp5' => 4, 'imp6' => 5,
                'perf1' => 4, 'perf2' => 3, 'perf3' => 3, 'perf4' => 4, 'perf5' => 3, 'perf6' => 4,
                'loyalty1' => 5, 'loyalty2' => 4, 'loyalty3' => 5
            ]
        ];

        $results = $this->service->calculateSurveyResults($responses);

        $this->assertEquals(2, $results['total_respondents']);
        $this->assertCount(6, $results['importance_scores']);
        $this->assertCount(6, $results['performance_scores']);
        $this->assertCount(6, $results['gap_scores']);

        // Check specific calculations
        $this->assertEquals(4.5, $results['importance_scores']['imp1']); // (4+5)/2
        $this->assertEquals(3.5, $results['performance_scores']['perf1']); // (3+4)/2
        $this->assertEquals(-1.0, $results['gap_scores']['imp1']); // 3.5 - 4.5

        // Satisfaction score is average of performance scores
        $expectedSatisfaction = (3.5 + 3.5 + 2.5 + 3.5 + 3.5 + 3.5) / 6; // Calculate manually
        $this->assertEquals($expectedSatisfaction, $results['satisfaction_score']);

        // Loyalty score
        $expectedLoyalty = (4.5 + 4.5 + 4.5) / 3; // (4+5)/2, (5+4)/2, (4+5)/2 averaged
        $this->assertEquals($expectedLoyalty, $results['loyalty_score']);

        $this->assertNotEmpty($results['recommendations']);
    }

    public function testGenerateRecommendations()
    {
        $gaps = [
            'imp1' => -2.0, // High priority
            'imp2' => -0.5, // Attention
            'imp3' => 0.5   // Good
        ];

        $service = new SurveyCalculationService();
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('generateRecommendations');
        $method->setAccessible(true);

        $recommendations = $method->invoke($service, $gaps);

        $this->assertCount(3, $recommendations);
        $this->assertTrue(strpos($recommendations[0], 'Prioritas tinggi') !== false);
        $this->assertTrue(strpos($recommendations[1], 'Perhatian') !== false);
        $this->assertTrue(strpos($recommendations[2], 'Bagus') !== false);
    }

    public function testCalculateIKP()
    {
        $responses = [
            [
                'importance_answers' => [
                    'reliability' => ['r1' => 4, 'r2' => 5],
                    'assurance' => ['a1' => 4],
                    'tangible' => ['t1' => 3],
                    'empathy' => ['e1' => 4],
                    'responsiveness' => ['rs1' => 4],
                    'applicability' => ['ap1' => 4]
                ],
                'performance_answers' => [
                    'reliability' => ['r1' => 3, 'r2' => 4],
                    'assurance' => ['a1' => 3],
                    'tangible' => ['t1' => 2],
                    'empathy' => ['e1' => 3],
                    'responsiveness' => ['rs1' => 3],
                    'applicability' => ['ap1' => 3]
                ]
            ],
            [
                'importance_answers' => [
                    'reliability' => ['r1' => 5, 'r2' => 4],
                    'assurance' => ['a1' => 5],
                    'tangible' => ['t1' => 4],
                    'empathy' => ['e1' => 5],
                    'responsiveness' => ['rs1' => 5],
                    'applicability' => ['ap1' => 5]
                ],
                'performance_answers' => [
                    'reliability' => ['r1' => 4, 'r2' => 3],
                    'assurance' => ['a1' => 4],
                    'tangible' => ['t1' => 3],
                    'empathy' => ['e1' => 4],
                    'responsiveness' => ['rs1' => 4],
                    'applicability' => ['ap1' => 4]
                ]
            ]
        ];

        $results = $this->service->calculateIKP($responses);

        $this->assertEquals(2, $results['total_respondents']);
        $this->assertArrayHasKey('item_averages', $results);
        $this->assertArrayHasKey('dimension_averages', $results);
        $this->assertArrayHasKey('weighting_factors', $results);
        $this->assertArrayHasKey('weighted_scores', $results);
        $this->assertArrayHasKey('total_weighted_score', $results);
        $this->assertArrayHasKey('ikp_percentage', $results);
        $this->assertArrayHasKey('ikp_interpretation', $results);

        $this->assertGreaterThan(0, $results['ikp_percentage']);
        $this->assertLessThanOrEqual(100, $results['ikp_percentage']);
    }

    public function testCalculateILP()
    {
        $responses = [
            ['loyalty_answers' => ['l1' => 4, 'l2' => 5, 'l3' => 4]],
            ['loyalty_answers' => ['l1' => 5, 'l2' => 4, 'l3' => 5]]
        ];

        $results = $this->service->calculateILP($responses);

        $this->assertEquals(2, $results['total_respondents']);
        $this->assertArrayHasKey('loyalty_item_averages', $results);
        $this->assertArrayHasKey('cli_scores', $results);
        $this->assertArrayHasKey('ilp_percentage', $results);
        $this->assertArrayHasKey('ilp_interpretation', $results);

        $this->assertGreaterThan(0, $results['ilp_percentage']);
        $this->assertLessThanOrEqual(100, $results['ilp_percentage']);
    }

    public function testCalculateGapAnalysis()
    {
        $responses = [
            [
                'importance_answers' => ['reliability' => ['r1' => 4, 'r2' => 5]],
                'performance_answers' => ['reliability' => ['r1' => 3, 'r2' => 4]]
            ],
            [
                'importance_answers' => ['reliability' => ['r1' => 5, 'r2' => 4]],
                'performance_answers' => ['reliability' => ['r1' => 4, 'r2' => 3]]
            ]
        ];

        $results = $this->service->calculateGapAnalysis($responses);

        $this->assertArrayHasKey('item_gaps', $results);
        $this->assertArrayHasKey('dimension_gaps', $results);
        $this->assertArrayHasKey('gap_statistics', $results);

        $this->assertCount(2, $results['item_gaps']); // r1 and r2
    }

    public function testCalculateLoyaltyProbabilities()
    {
        $responses = [
            ['satisfaction_answers' => ['k1' => 4], 'loyalty_answers' => ['l1' => 5, 'l2' => 4, 'l3' => 5]],
            ['satisfaction_answers' => ['k1' => 5], 'loyalty_answers' => ['l1' => 4, 'l2' => 5, 'l3' => 4]],
            ['satisfaction_answers' => ['k1' => 3], 'loyalty_answers' => ['l1' => 3, 'l2' => 3, 'l3' => 3]]
        ];

        $results = $this->service->calculateLoyaltyProbabilities($responses);

        $this->assertEquals(3, $results['total_respondents']);
        $this->assertArrayHasKey('probabilities', $results);
        $this->assertArrayHasKey('predictions', $results);

        $this->assertEquals(0.00, $results['probabilities'][1]);
        $this->assertEquals(1.00, $results['probabilities'][5]);

        $this->assertArrayHasKey('k1', $results['predictions']);
        $this->assertArrayHasKey('l1', $results['predictions']);
        $this->assertArrayHasKey('l2', $results['predictions']);
        $this->assertArrayHasKey('l3', $results['predictions']);
    }

    public function testCalculateCompleteSurveyResults()
    {
        $responses = [
            [
                'imp_r1' => 4, 'imp_r2' => 5, 'imp_a1' => 4,
                'perf_r1' => 3, 'perf_r2' => 4, 'perf_a1' => 3,
                'k1' => 4, 'l1' => 4, 'l2' => 5, 'l3' => 4,
                'jk' => 'laki-laki', 'usia' => '25-34', 'pekerjaan' => 'karyawan_swasta', 'domisili' => '1'
            ]
        ];

        $results = $this->service->calculateCompleteSurveyResults($responses);

        $this->assertArrayHasKey('basic_analysis', $results);
        $this->assertArrayHasKey('ikp_analysis', $results);
        $this->assertArrayHasKey('ilp_analysis', $results);
        $this->assertArrayHasKey('gap_analysis', $results);
        $this->assertArrayHasKey('loyalty_probabilities', $results);
        $this->assertArrayHasKey('demographic_statistics', $results);
        $this->assertArrayHasKey('scale_frequency_analysis', $results);
    }

    public function testCalculateDemographicStatistics()
    {
        $responses = [
            ['profile_data' => ['jenis_kelamin' => 'L', 'usia' => 25, 'pekerjaan' => 'Karyawan swasta', 'domisili' => 'DKI Jakarta']],
            ['profile_data' => ['jenis_kelamin' => 'P', 'usia' => 35, 'pekerjaan' => 'Wiraswasta', 'domisili' => 'Jawa Barat']],
            ['profile_data' => ['jenis_kelamin' => 'L', 'usia' => 28, 'pekerjaan' => 'PNS', 'domisili' => 'DKI Jakarta']]
        ];

        $results = $this->service->calculateDemographicStatistics($responses);

        $this->assertEquals(3, $results['total_respondents']);
        $this->assertArrayHasKey('gender_distribution', $results);
        $this->assertArrayHasKey('age_distribution', $results);
        $this->assertArrayHasKey('occupation_distribution', $results);
        $this->assertArrayHasKey('domicile_distribution', $results);
        $this->assertArrayHasKey('cross_analysis', $results);

        // Check gender distribution
        $this->assertEquals(2, $results['gender_distribution']['laki-laki']['count']);
        $this->assertEquals(1, $results['gender_distribution']['perempuan']['count']);
        $this->assertEquals(66.67, round($results['gender_distribution']['laki-laki']['percentage'], 2));
    }

    public function testCalculateScaleFrequencyAnalysis()
    {
        $responses = [
            ['satisfaction_answers' => ['k1' => 4], 'loyalty_answers' => ['l1' => 5]],
            ['satisfaction_answers' => ['k1' => 5], 'loyalty_answers' => ['l1' => 4]],
            ['satisfaction_answers' => ['k1' => 3], 'loyalty_answers' => ['l1' => 3]]
        ];

        $results = $this->service->calculateScaleFrequencyAnalysis($responses);

        $this->assertEquals(3, $results['total_respondents']);
        $this->assertArrayHasKey('scale_frequencies', $results);

        // Check K1 frequencies
        $this->assertArrayHasKey('k1', $results['scale_frequencies']);
        $this->assertEquals(1, $results['scale_frequencies']['k1'][3]['count']); // 1 person chose scale 3
        $this->assertEquals(1, $results['scale_frequencies']['k1'][4]['count']); // 1 person chose scale 4
        $this->assertEquals(1, $results['scale_frequencies']['k1'][5]['count']); // 1 person chose scale 5
    }

    // Database Integration Tests
    public function testCalculateIKPWithDatabaseData()
    {
        // Create test data in database
        PelatihanSurveyResponse::factory()->count(3)->create([
            'status' => 'completed'
        ]);

        // Get data from database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get()->toArray();

        // Calculate IKP
        $results = $this->service->calculateIKP($responses);

        // Assertions
        $this->assertEquals(3, $results['total_respondents']);
        $this->assertArrayHasKey('item_averages', $results);
        $this->assertArrayHasKey('dimension_averages', $results);
        $this->assertArrayHasKey('weighting_factors', $results);
        $this->assertArrayHasKey('weighted_scores', $results);
        $this->assertArrayHasKey('total_weighted_score', $results);
        $this->assertArrayHasKey('ikp_percentage', $results);
        $this->assertArrayHasKey('ikp_interpretation', $results);

        // Check that IKP percentage is calculated correctly
        $this->assertGreaterThanOrEqual(0, $results['ikp_percentage']);
        $this->assertLessThanOrEqual(100, $results['ikp_percentage']);

        // Check interpretation
        $this->assertContains($results['ikp_interpretation'], [
            'Sangat Puas', 'Puas', 'Cukup Puas', 'Kurang Puas', 'Tidak Puas'
        ]);
    }

    public function testCalculateILPWithDatabaseData()
    {
        // Create test data in database
        PelatihanSurveyResponse::factory()->count(5)->create([
            'status' => 'completed'
        ]);

        // Get data from database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get()->toArray();

        // Calculate ILP
        $results = $this->service->calculateILP($responses);

        // Assertions
        $this->assertEquals(5, $results['total_respondents']);
        $this->assertArrayHasKey('loyalty_item_averages', $results);
        $this->assertArrayHasKey('cli_scores', $results);
        $this->assertArrayHasKey('ilp_percentage', $results);
        $this->assertArrayHasKey('ilp_interpretation', $results);

        // Check that ILP percentage is calculated correctly
        $this->assertGreaterThanOrEqual(0, $results['ilp_percentage']);
        $this->assertLessThanOrEqual(100, $results['ilp_percentage']);

        // Check interpretation
        $this->assertContains($results['ilp_interpretation'], [
            'Sangat Loyal', 'Loyal', 'Cukup Loyal', 'Kurang Loyal', 'Tidak Loyal'
        ]);
    }

    public function testCalculateDemographicStatisticsWithDatabaseData()
    {
        // Create test data with specific demographics
        PelatihanSurveyResponse::factory()->count(10)->create([
            'status' => 'completed',
            'profile_data' => [
                'jenis_kelamin' => 'L',
                'usia' => 30,
                'pekerjaan' => 'Karyawan swasta',
                'domisili' => 'DKI Jakarta'
            ]
        ]);

        PelatihanSurveyResponse::factory()->count(5)->create([
            'status' => 'completed',
            'profile_data' => [
                'jenis_kelamin' => 'P',
                'usia' => 25,
                'pekerjaan' => 'Pelajar/Mahasiswa',
                'domisili' => 'Jawa Barat'
            ]
        ]);

        // Get data from database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get()->toArray();

        // Calculate demographic statistics
        $results = $this->service->calculateDemographicStatistics($responses);

        // Assertions
        $this->assertEquals(15, $results['total_respondents']);
        $this->assertArrayHasKey('gender_distribution', $results);
        $this->assertArrayHasKey('age_distribution', $results);
        $this->assertArrayHasKey('occupation_distribution', $results);
        $this->assertArrayHasKey('domicile_distribution', $results);

        // Check gender distribution
        $this->assertArrayHasKey('laki-laki', $results['gender_distribution']);
        $this->assertArrayHasKey('perempuan', $results['gender_distribution']);
        $this->assertEquals(10, $results['gender_distribution']['laki-laki']['count']);
        $this->assertEquals(5, $results['gender_distribution']['perempuan']['count']);

        // Check percentages
        $this->assertEquals(66.67, round($results['gender_distribution']['laki-laki']['percentage'], 2));
        $this->assertEquals(33.33, round($results['gender_distribution']['perempuan']['percentage'], 2));
    }

    public function testCalculateCompleteSurveyResultsWithDatabaseData()
    {
        // Create test data in database
        PelatihanSurveyResponse::factory()->count(8)->create([
            'status' => 'completed'
        ]);

        // Get data from database
        $responses = PelatihanSurveyResponse::where('status', 'completed')->get()->toArray();

        // Calculate complete survey results
        $results = $this->service->calculateCompleteSurveyResults($responses);

        // Assertions
        $this->assertEquals(8, $results['basic_analysis']['total_respondents']);
        $this->assertArrayHasKey('ikp_analysis', $results);
        $this->assertArrayHasKey('ilp_analysis', $results);
        $this->assertArrayHasKey('gap_analysis', $results);
        $this->assertArrayHasKey('loyalty_probabilities', $results);
        $this->assertArrayHasKey('demographic_statistics', $results);
        $this->assertArrayHasKey('scale_frequency_analysis', $results);

        // Check that all analyses have correct structure
        $this->assertArrayHasKey('ikp_percentage', $results['ikp_analysis']);
        $this->assertArrayHasKey('ilp_percentage', $results['ilp_analysis']);
        $this->assertArrayHasKey('item_gaps', $results['gap_analysis']);
        $this->assertArrayHasKey('gender_distribution', $results['demographic_statistics']);
        $this->assertArrayHasKey('scale_frequencies', $results['scale_frequency_analysis']);
    }

    public function testServiceHandlesEmptyDatabaseResults()
    {
        // Ensure no data in database
        PelatihanSurveyResponse::query()->delete();

        // Get data from database (should be empty)
        $responses = PelatihanSurveyResponse::all()->toArray();

        // Test all methods with empty data
        $ikpResults = $this->service->calculateIKP($responses);
        $ilpResults = $this->service->calculateILP($responses);
        $demoResults = $this->service->calculateDemographicStatistics($responses);
        $completeResults = $this->service->calculateCompleteSurveyResults($responses);

        // All should return empty/default results
        $this->assertEquals(0, $ikpResults['total_respondents']);
        $this->assertEquals(0, $ilpResults['total_respondents']);
        $this->assertEquals(0, $demoResults['total_respondents']);
        $this->assertEquals(0, $completeResults['basic_analysis']['total_respondents']);
    }
}