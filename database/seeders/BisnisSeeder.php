<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bisnis;

class BisnisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bisnis = [
            [
                'nama_bisnis' => 'PT. Teknologi Maju',
                'keterangan' => 'Perusahaan teknologi yang berfokus pada pengembangan software dan aplikasi mobile.'
            ],
            [
                'nama_bisnis' => 'CV. Kreatif Design',
                'keterangan' => 'Studio desain grafis dan branding yang melayani berbagai jenis bisnis.'
            ],
            [
                'nama_bisnis' => 'UD. Retail Sukses',
                'keterangan' => 'Toko retail yang menjual berbagai produk elektronik dan gadget.'
            ]
        ];

        foreach ($bisnis as $data) {
            Bisnis::create($data);
        }
    }
}