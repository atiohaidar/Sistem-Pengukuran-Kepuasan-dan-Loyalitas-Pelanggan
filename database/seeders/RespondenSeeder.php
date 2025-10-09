<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Responden;
use Illuminate\Support\Facades\DB;

class RespondenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first bisnis and provinsi for reference
        $bisnis = DB::table('tbl_bisnis')->first();
        $provinsi = DB::table('tbl_provinsi')->first();

        if (!$bisnis || !$provinsi) {
            $this->command->info('Bisnis or Provinsi data not found. Skipping responden creation.');
            return;
        }

        // Create sample respondents
        $sampleRespondens = [
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'andi.susanto@email.com',
                'whatsapp' => '081234567890',
                'jk' => 'L',
                'usia' => 25,
                'pekerjaan' => 'Mahasiswa',
                'domisili' => 1,
            ],
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'sari.wulandari@email.com',
                'whatsapp' => '081234567891',
                'jk' => 'P',
                'usia' => 30,
                'pekerjaan' => 'Pegawai Swasta',
                'domisili' => 2,
            ],
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'budi.pratama@email.com',
                'whatsapp' => '081234567892',
                'jk' => 'L',
                'usia' => 28,
                'pekerjaan' => 'Wiraswasta',
                'domisili' => 3,
            ],
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'maya.sari@email.com',
                'whatsapp' => '081345678901',
                'jk' => 'P',
                'usia' => 22,
                'pekerjaan' => 'Pelajar',
                'domisili' => $provinsi->id,
            ],
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'agus.wibowo@email.com',
                'whatsapp' => '081456789012',
                'jk' => 'L',
                'usia' => 48,
                'pekerjaan' => 'Lainnya',
                'pekerjaan_lain' => 'Pengusaha Retail',
                'domisili' => $provinsi->id,
            ],
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'rini.setiawan@email.com',
                'whatsapp' => '081567890123',
                'jk' => 'P',
                'usia' => 38,
                'pekerjaan' => 'Pegawai Swasta',
                'domisili' => $provinsi->id,
            ],
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'dwi.kurniawan@email.com',
                'whatsapp' => '081678901234',
                'jk' => 'L',
                'usia' => 58,
                'pekerjaan' => 'Wiraswasta',
                'domisili' => $provinsi->id,
            ],
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'lisa.nurhaliza@email.com',
                'whatsapp' => '081789012345',
                'jk' => 'P',
                'usia' => 20,
                'pekerjaan' => 'Pelajar',
                'domisili' => $provinsi->id,
            ],
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'eko.susilo@email.com',
                'whatsapp' => '081890123456',
                'jk' => 'L',
                'usia' => 52,
                'pekerjaan' => 'PNS',
                'domisili' => $provinsi->id,
            ],
            [
                'id_bisnis' => $bisnis->id_bisnis,
                'email' => 'nina.amalia@email.com',
                'whatsapp' => '081901234567',
                'jk' => 'P',
                'usia' => 32,
                'pekerjaan' => 'Lainnya',
                'pekerjaan_lain' => 'Freelance Designer',
                'domisili' => $provinsi->id,
            ],
        ];

        $created = 0;
        foreach ($sampleRespondens as $responden) {
            // Check if email already exists
            $exists = DB::table('tbl_responden')
                ->where('email', $responden['email'])
                ->exists();

            if (!$exists) {
                DB::table('tbl_responden')->insert(array_merge($responden, [
                    'created_at' => now(),
                    'updated_at' => now()
                ]));
                $created++;
            }
        }

        $this->command->info("Sample responden data created: {$created} records");
    }
}