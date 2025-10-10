<?php

namespace Tests\Unit;

use App\Calculators\SurveyCalculator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SurveyCalculatorTest extends TestCase
{
    private SurveyCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new SurveyCalculator();
    }

    public function testCalculateAverage()
    {
        // Test normal case
        $result = $this->calculator->calculateAverage(15.0, 5);
        $this->assertEquals(3.0, $result);

        // Test zero count
        $result = $this->calculator->calculateAverage(10.0, 0);
        $this->assertEquals(0.0, $result);

        // Test negative count throws exception
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->calculateAverage(10.0, -1);
    }

    public function testCalculateGap()
    {
        $result = $this->calculator->calculateGap(4.5, 3.2);
        $this->assertEqualsWithDelta(1.3, $result, 0.0001);

        $result = $this->calculator->calculateGap(3.2, 4.5);
        $this->assertEqualsWithDelta(-1.3, $result, 0.0001);
    }

    public function testCalculateLoyaltyIndex()
    {
        // Test dengan nilai yang diketahui
        $result = $this->calculator->calculateLoyaltyIndex(3.0, 4.0, 5.0);
        $average = (3.0 + 4.0 + 5.0) / 3; // 4.0
        $expected = (($average - 1) / 4) * 100; // ((4.0 - 1) / 4) * 100 = 75.0
        $this->assertEquals(75.0, $result);
    }

    public function testCalculateLoyaltyProbability()
    {
        $ratingCounts = [10, 20, 30, 25, 15]; // Total = 100
        $totalCount = 100;

        $result = $this->calculator->calculateLoyaltyProbability($ratingCounts, $totalCount);

        // Check percentages
        $this->assertEquals([10.0, 20.0, 30.0, 25.0, 15.0], $result['percentages']);

        // Check weighted sums (percentage * probability)
        $expectedWeighted = [10.0 * 0.00, 20.0 * 0.25, 30.0 * 0.50, 25.0 * 0.75, 15.0 * 1.00];
        $this->assertEquals($expectedWeighted, $result['weighted_sums']);

        // Check frequency weighteds (count * probability)
        $expectedFrequency = [10 * 0.00, 20 * 0.25, 30 * 0.50, 25 * 0.75, 15 * 1.00];
        $this->assertEquals($expectedFrequency, $result['frequency_weighteds']);

        // Check total probability (sum of frequency weighteds)
        $this->assertEquals(10*0 + 20*0.25 + 30*0.5 + 25*0.75 + 15*1.0, $result['total_probability']);
    }

    public function testCalculateLoyaltyProbabilityInvalidInput()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->calculateLoyaltyProbability([1, 2, 3], 10); // Only 3 elements instead of 5
    }

    public function testCalculateRatingDistribution()
    {
        $data = [
            ['k1' => 3],
            ['k1' => 1],
            ['k1' => 3],
            ['k1' => 5],
            ['k1' => 2],
        ];

        $result = $this->calculator->calculateRatingDistribution($data, 'k1');

        $expected = [1 => 1, 2 => 1, 3 => 2, 4 => 0, 5 => 1];
        $this->assertEquals($expected, $result);
    }

    public function testCalculateMultipleStats()
    {
        $data = [
            ['r1' => 4.0, 'r2' => 3.0],
            ['r1' => 2.0, 'r2' => 5.0],
            ['r1' => 4.0, 'r2' => 3.0],
        ];

        $result = $this->calculator->calculateMultipleStats($data, ['r1', 'r2']);

        // r1: sum = 4+2+4 = 10, count = 3, avg = 10/3 ≈ 3.333
        $this->assertEquals(3, $result['r1']['count']);
        $this->assertEquals(10.0, $result['r1']['sum']);
        $this->assertEquals(10.0 / 3, $result['r1']['average']);

        // r2: sum = 3+5+3 = 11, count = 3, avg = 11/3 ≈ 3.667
        $this->assertEquals(3, $result['r2']['count']);
        $this->assertEquals(11.0, $result['r2']['sum']);
        $this->assertEquals(11.0 / 3, $result['r2']['average']);
    }

    public function testCalculateDeviation()
    {
        $result = $this->calculator->calculateDeviation(1.5, 4.0);
        $this->assertEquals(0.375, $result); // |1.5| / 4.0 = 0.375
    }
}