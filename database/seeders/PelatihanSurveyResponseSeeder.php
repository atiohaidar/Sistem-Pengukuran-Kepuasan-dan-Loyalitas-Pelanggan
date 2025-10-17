<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelatihanSurveyResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 completed survey responses
        \App\Models\PelatihanSurveyResponse::factory(50)->create([
            'status' => 'completed',
        ]);

        // Create 10 draft responses
        \App\Models\PelatihanSurveyResponse::factory(10)->create([
            'status' => 'draft',
        ]);
    }
}
