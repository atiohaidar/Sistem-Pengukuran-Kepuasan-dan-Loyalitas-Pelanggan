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
        $produkCampaigns = \App\Models\SurveyCampaign::where('type', 'produk')->get();
        $pelatihanCampaigns = \App\Models\SurveyCampaign::where('type', 'pelatihan')->get();

        $totalProduk = 0;
        $totalPelatihan = 0;

        // Untuk setiap campaign produk, buat 20 response completed dan 5 draft
        foreach ($produkCampaigns as $campaign) {
            \App\Models\ProdukSurveyResponse::factory()->count(20)->create([
                'survey_campaign_id' => $campaign->id,
                'status' => 'completed'
            ]);
            \App\Models\ProdukSurveyResponse::factory()->count(5)->create([
                'survey_campaign_id' => $campaign->id,
                'status' => 'draft'
            ]);
            $totalProduk += 25;
        }

        // Untuk setiap campaign pelatihan, buat 20 response completed dan 5 draft
        foreach ($pelatihanCampaigns as $campaign) {
            \App\Models\PelatihanSurveyResponse::factory()->count(20)->create([
                'survey_campaign_id' => $campaign->id,
                'status' => 'completed'
            ]);
            \App\Models\PelatihanSurveyResponse::factory()->count(5)->create([
                'survey_campaign_id' => $campaign->id,
                'status' => 'draft'
            ]);
            $totalPelatihan += 25;
        }

        $this->command->info("Created $totalProduk produk responses and $totalPelatihan pelatihan responses (completed & draft) based on existing campaigns.");
    }
}
