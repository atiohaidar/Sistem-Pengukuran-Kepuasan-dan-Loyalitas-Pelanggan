<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSurveyResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 completed survey responses
        \App\Models\ProdukSurveyResponse::factory(50)->create([
            'status' => 'completed',
        ]);

        // Create 10 draft responses
        \App\Models\ProdukSurveyResponse::factory(10)->create([
            'status' => 'draft',
        ]);
    }
}
