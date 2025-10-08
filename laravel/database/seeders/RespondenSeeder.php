<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Responden;

class RespondenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Responden::create([
            'id_bisnis' => 1,
            'email' => 'responden1@example.com',
            'whatsapp' => '081234567890',
            'jk' => 'L',
            'usia' => 25,
            'pekerjaan' => 'Mahasiswa',
            'domisili' => 1,
        ]);

        Responden::create([
            'id_bisnis' => 1,
            'email' => 'responden2@example.com',
            'whatsapp' => '081234567891',
            'jk' => 'P',
            'usia' => 30,
            'pekerjaan' => 'Pegawai Swasta',
            'domisili' => 2,
        ]);

        Responden::create([
            'id_bisnis' => 2,
            'email' => 'responden3@example.com',
            'whatsapp' => '081234567892',
            'jk' => 'L',
            'usia' => 28,
            'pekerjaan' => 'Wiraswasta',
            'domisili' => 3,
        ]);
    }
}