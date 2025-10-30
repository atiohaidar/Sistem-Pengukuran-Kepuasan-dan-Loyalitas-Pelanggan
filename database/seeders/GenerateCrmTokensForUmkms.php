<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UmkmProfile;
use Illuminate\Support\Str;

class GenerateCrmTokensForUmkms extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $umkms = UmkmProfile::whereNull('crm_token')->get();

        foreach ($umkms as $umkm) {
            $umkm->update([
                'crm_token' => Str::uuid()->toString()
            ]);
        }

        $this->command->info("Generated CRM tokens for {$umkms->count()} UMKM profiles");
    }
}
