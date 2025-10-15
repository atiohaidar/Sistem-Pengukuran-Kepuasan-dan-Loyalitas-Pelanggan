<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PelatihanSurveyResponse;

class SurveyResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 sample survey responses
        PelatihanSurveyResponse::factory()->count(50)->create([
            'status' => 'completed'
        ]);

        // Create some draft responses
        PelatihanSurveyResponse::factory()->count(10)->create([
            'status' => 'draft'
        ]);

        $this->command->info('Created 60 survey responses (50 completed, 10 draft)');
    }
}
