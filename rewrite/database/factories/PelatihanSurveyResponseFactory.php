<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PelatihanSurveyResponse>
 */
class PelatihanSurveyResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'session_token' => $this->faker->unique()->uuid(),
            'survey_type' => 'pelatihan',
            'profile_data' => [
                'email' => $this->faker->email(),
                'whatsapp' => $this->faker->phoneNumber(),
                'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
                'usia' => $this->faker->numberBetween(18, 65),
                'pekerjaan' => $this->faker->randomElement([
                    'Karyawan swasta', 'Wiraswasta', 'PNS', 'Pelajar/Mahasiswa', 'Lainnya'
                ]),
                'pekerjaan_lain' => null,
                'domisili' => $this->faker->randomElement([
                    'DKI Jakarta', 'Jawa Barat', 'Jawa Timur', 'Jawa Tengah', 'Banten'
                ]),
            ],
            'importance_answers' => $this->generateImportanceAnswers(),
            'performance_answers' => $this->generatePerformanceAnswers(),
            'satisfaction_answers' => [
                'k1' => $this->faker->numberBetween(1, 5),
                'k2' => $this->faker->numberBetween(1, 5),
                'k3' => $this->faker->numberBetween(1, 5),
            ],
            'loyalty_answers' => [
                'l1' => $this->faker->numberBetween(1, 5),
                'l2' => $this->faker->numberBetween(1, 5),
                'l3' => $this->faker->numberBetween(1, 5),
            ],
            'feedback_answers' => [
                'kritik_saran' => $this->faker->paragraph(),
                'tema_judul' => $this->faker->sentence(),
                'bentuk_pelatihan' => [
                    'online' => $this->faker->boolean(),
                    'offline' => $this->faker->boolean(),
                    'streaming' => $this->faker->boolean(),
                    'elearning' => $this->faker->boolean(),
                ],
            ],
            'status' => $this->faker->randomElement(['draft', 'completed']),
            'started_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'completed_at' => function (array $attributes) {
                return $attributes['status'] === 'completed' 
                    ? $this->faker->dateTimeBetween($attributes['started_at'], 'now')
                    : null;
            },
        ];
    }

    private function generateImportanceAnswers(): array
    {
        return [
            'reliability' => [
                'r1' => $this->faker->numberBetween(1, 5),
                'r2' => $this->faker->numberBetween(1, 5),
                'r3' => $this->faker->numberBetween(1, 5),
                'r4' => $this->faker->numberBetween(1, 5),
                'r5' => $this->faker->numberBetween(1, 5),
                'r6' => $this->faker->numberBetween(1, 5),
                'r7' => $this->faker->numberBetween(1, 5),
            ],
            'assurance' => [
                'a1' => $this->faker->numberBetween(1, 5),
                'a2' => $this->faker->numberBetween(1, 5),
                'a3' => $this->faker->numberBetween(1, 5),
                'a4' => $this->faker->numberBetween(1, 5),
            ],
            'tangible' => [
                't1' => $this->faker->numberBetween(1, 5),
                't2' => $this->faker->numberBetween(1, 5),
                't3' => $this->faker->numberBetween(1, 5),
                't4' => $this->faker->numberBetween(1, 5),
                't5' => $this->faker->numberBetween(1, 5),
                't6' => $this->faker->numberBetween(1, 5),
            ],
            'empathy' => [
                'e1' => $this->faker->numberBetween(1, 5),
                'e2' => $this->faker->numberBetween(1, 5),
                'e3' => $this->faker->numberBetween(1, 5),
                'e4' => $this->faker->numberBetween(1, 5),
                'e5' => $this->faker->numberBetween(1, 5),
            ],
            'responsiveness' => [
                'rs1' => $this->faker->numberBetween(1, 5),
                'rs2' => $this->faker->numberBetween(1, 5),
            ],
            'applicability' => [
                'ap1' => $this->faker->numberBetween(1, 5),
                'ap2' => $this->faker->numberBetween(1, 5),
            ],
        ];
    }

    private function generatePerformanceAnswers(): array
    {
        // Same structure as importance but different values
        return $this->generateImportanceAnswers();
    }
}
