<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jawaban_realibility;
use App\Models\Jawaban_assurance;
use App\Models\Jawaban_tangible;
use App\Models\Jawaban_empathy;
use App\Models\Jawaban_responsiveness;
use App\Models\Jawaban_applicability;
use App\Models\Jawaban_lp;

class JawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for respondent 1
        Jawaban_realibility::create([
            'id_responden' => 1,
            'r1' => 4,
            'r2' => 5,
            'r3' => 4,
            'r4' => 3,
            'r5' => 4,
            'r6' => 5,
            'r7' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_assurance::create([
            'id_responden' => 1,
            'a1' => 4,
            'a2' => 5,
            'a3' => 4,
            'a4' => 3,
            'a5' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_tangible::create([
            'id_responden' => 1,
            't1' => 4,
            't2' => 5,
            't3' => 4,
            't4' => 3,
            't5' => 4,
            't6' => 5,
            'kategori' => 'persepsi'
        ]);

        Jawaban_empathy::create([
            'id_responden' => 1,
            'e1' => 4,
            'e2' => 5,
            'e3' => 4,
            'e4' => 3,
            'e5' => 4,
            'e6' => 5,
            'kategori' => 'persepsi'
        ]);

        Jawaban_responsiveness::create([
            'id_responden' => 1,
            'rs1' => 4,
            'rs2' => 5,
            'rs3' => 4,
            'rs4' => 3,
            'rs5' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_applicability::create([
            'id_responden' => 1,
            'ap1' => 4,
            'ap2' => 5,
            'kategori' => 'persepsi'
        ]);

        Jawaban_lp::create([
            'id_responden' => 1,
            'l1' => 4,
            'l2' => 5,
            'l3' => 4,
            'kategori' => 'persepsi'
        ]);

        // Sample data for respondent 2
        Jawaban_realibility::create([
            'id_responden' => 2,
            'r1' => 3,
            'r2' => 4,
            'r3' => 3,
            'r4' => 4,
            'r5' => 3,
            'r6' => 4,
            'r7' => 3,
            'kategori' => 'persepsi'
        ]);

        Jawaban_assurance::create([
            'id_responden' => 2,
            'a1' => 3,
            'a2' => 4,
            'a3' => 3,
            'a4' => 4,
            'a5' => 3,
            'kategori' => 'persepsi'
        ]);

        Jawaban_tangible::create([
            'id_responden' => 2,
            't1' => 3,
            't2' => 4,
            't3' => 3,
            't4' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_empathy::create([
            'id_responden' => 2,
            'e1' => 3,
            'e2' => 4,
            'e3' => 3,
            'e4' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_responsiveness::create([
            'id_responden' => 2,
            'rs1' => 3,
            'rs2' => 4,
            'rs3' => 3,
            'kategori' => 'persepsi'
        ]);

        Jawaban_applicability::create([
            'id_responden' => 2,
            'ap1' => 3,
            'ap2' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_lp::create([
            'id_responden' => 2,
            'l1' => 3,
            'l2' => 4,
            'l3' => 3,
            'kategori' => 'persepsi'
        ]);

        // Sample data for respondent 3
        Jawaban_realibility::create([
            'id_responden' => 3,
            'r1' => 5,
            'r2' => 4,
            'r3' => 5,
            'r4' => 4,
            'r5' => 5,
            'r6' => 4,
            'r7' => 5,
            'kategori' => 'persepsi'
        ]);

        Jawaban_assurance::create([
            'id_responden' => 3,
            'a1' => 5,
            'a2' => 4,
            'a3' => 5,
            'a4' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_tangible::create([
            'id_responden' => 3,
            't1' => 5,
            't2' => 4,
            't3' => 5,
            't4' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_empathy::create([
            'id_responden' => 3,
            'e1' => 5,
            'e2' => 4,
            'e3' => 5,
            'e4' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_responsiveness::create([
            'id_responden' => 3,
            'rs1' => 5,
            'rs2' => 4,
            'rs3' => 5,
            'kategori' => 'persepsi'
        ]);

        Jawaban_applicability::create([
            'id_responden' => 3,
            'ap1' => 5,
            'ap2' => 4,
            'kategori' => 'persepsi'
        ]);

        Jawaban_lp::create([
            'id_responden' => 3,
            'l1' => 5,
            'l2' => 4,
            'l3' => 5,
            'kategori' => 'persepsi'
        ]);
    }
}
