<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DimensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dimensi = [
            'Reliability',
            'Assurance',
            'Empathy',
            'Responsiveness',
            'Relevance',
            'Tangible',
            'Kepercayaan Pelanggan',
            'Loyalty',
            'Kritik dan Saran',
            'Applicability'
        ];

        foreach ($dimensi as $nama) {
            \App\Models\Pertanyaan_kat::create(['nama_dimensi' => $nama]);
        }
    }
}
