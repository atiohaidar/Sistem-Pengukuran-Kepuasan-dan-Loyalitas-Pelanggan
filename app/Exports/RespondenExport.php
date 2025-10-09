<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use App\Models\Responden;
use App\Models\Provinsi;
use App\Models\Bisnis;
use App\Models\Jawaban;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RespondenExport implements FromView
{

    /**
     * Helper method to get jawaban data by dimensi and kategori
     */
    private function getJawabanData($id_responden, $dimensi_type, $kategori = null)
    {
        $query = Jawaban::where('id_responden', $id_responden)
                       ->where('dimensi_type', $dimensi_type);

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $jawaban = $query->first();

        return $jawaban ? $jawaban->nilai : [];
    }


    public function view(): View
    {
        $responden = Responden::
                        leftJoin('tbl_bisnis', 'tbl_bisnis.id_bisnis', '=', 'tbl_responden.id_bisnis')
                        ->leftJoin('provinsi', 'provinsi.id', '=', 'tbl_responden.domisili')
                        ->get();

        $datas = array();
        foreach($responden as $key => $value){
            // Get realibility data
            $realibility_kepentingan = $this->getJawabanData($value->id_responden, 'realibility', 'kepentingan');
            $value->kepentingan_r1 = $realibility_kepentingan['r1'] ?? null;
            $value->kepentingan_r2 = $realibility_kepentingan['r2'] ?? null;
            $value->kepentingan_r3 = $realibility_kepentingan['r3'] ?? null;
            $value->kepentingan_r4 = $realibility_kepentingan['r4'] ?? null;
            $value->kepentingan_r5 = $realibility_kepentingan['r5'] ?? null;
            $value->kepentingan_r6 = $realibility_kepentingan['r6'] ?? null;
            $value->kepentingan_r7 = $realibility_kepentingan['r7'] ?? null;

            $realibility_persepsi = $this->getJawabanData($value->id_responden, 'realibility', 'persepsi');
            $value->persepsi_r1 = $realibility_persepsi['r1'] ?? null;
            $value->persepsi_r2 = $realibility_persepsi['r2'] ?? null;
            $value->persepsi_r3 = $realibility_persepsi['r3'] ?? null;
            $value->persepsi_r4 = $realibility_persepsi['r4'] ?? null;
            $value->persepsi_r5 = $realibility_persepsi['r5'] ?? null;
            $value->persepsi_r6 = $realibility_persepsi['r6'] ?? null;
            $value->persepsi_r7 = $realibility_persepsi['r7'] ?? null;

            // Get assurance data
            $assurance_kepentingan = $this->getJawabanData($value->id_responden, 'assurance', 'kepentingan');
            $value->kepentingan_a1 = $assurance_kepentingan['a1'] ?? null;
            $value->kepentingan_a2 = $assurance_kepentingan['a2'] ?? null;
            $value->kepentingan_a3 = $assurance_kepentingan['a3'] ?? null;
            $value->kepentingan_a4 = $assurance_kepentingan['a4'] ?? null;

            $assurance_persepsi = $this->getJawabanData($value->id_responden, 'assurance', 'persepsi');
            $value->persepsi_a1 = $assurance_persepsi['a1'] ?? null;
            $value->persepsi_a2 = $assurance_persepsi['a2'] ?? null;
            $value->persepsi_a3 = $assurance_persepsi['a3'] ?? null;
            $value->persepsi_a4 = $assurance_persepsi['a4'] ?? null;

            //---
            $tangible_kepentingan = $this->getJawabanData($value->id_responden, 'tangible', 'kepentingan');            $value->kepentingan_t1 = $tangible_kepentingan->t1;
            $value->kepentingan_t2 = $tangible_kepentingan->t2;
            $value->kepentingan_t3 = $tangible_kepentingan->t3;
            $value->kepentingan_t4 = $tangible_kepentingan->t4;
            $value->kepentingan_t5 = $tangible_kepentingan->t5;
            $value->kepentingan_t6 = $tangible_kepentingan->t6;

            $tangible_persepsi = $this->getJawabanData($value->id_responden, 'tangible', 'persepsi');            $value->persepsi_t1 = $tangible_persepsi->t1;
            $value->persepsi_t2 = $tangible_persepsi->t2;
            $value->persepsi_t3 = $tangible_persepsi->t3;
            $value->persepsi_t4 = $tangible_persepsi->t4;
            $value->persepsi_t5 = $tangible_persepsi->t5;
            $value->persepsi_t6 = $tangible_persepsi->t6;

            //---
            $empathy_kepentingan = $this->getJawabanData($value->id_responden, 'empathy', 'kepentingan');            $value->kepentingan_e1 = $empathy_kepentingan->e1;
            $value->kepentingan_e2 = $empathy_kepentingan->e2;
            $value->kepentingan_e3 = $empathy_kepentingan->e3;
            $value->kepentingan_e4 = $empathy_kepentingan->e4;
            $value->kepentingan_e5 = $empathy_kepentingan->e5;

            $empathy_persepsi = $this->getJawabanData($value->id_responden, 'empathy', 'persepsi')->first();

            $value->persepsi_e1 = $empathy_persepsi->e1;
            $value->persepsi_e2 = $empathy_persepsi->e2;
            $value->persepsi_e3 = $empathy_persepsi->e3;
            $value->persepsi_e4 = $empathy_persepsi->e4;
            $value->persepsi_e5 = $empathy_persepsi->e5;

            //---
            $responsiveness_kepentingan = $this->getJawabanData($value->id_responden, 'responsiveness', 'kepentingan')->first();

            $value->kepentingan_rs1 = $responsiveness_kepentingan->rs1;
            $value->kepentingan_rs2 = $responsiveness_kepentingan->rs2;

            $responsiveness_persepsi = $this->getJawabanData($value->id_responden, 'responsiveness', 'persepsi')->first();

            $value->persepsi_rs1 = $responsiveness_persepsi->rs1;
            $value->persepsi_rs2 = $responsiveness_persepsi->rs2;

            //---
            $applicability_kepentingan = $this->getJawabanData($value->id_responden, 'applicability', 'kepentingan')->first();

            $value->kepentingan_ap1 = $applicability_kepentingan->ap1;
            $value->kepentingan_ap2 = $applicability_kepentingan->ap2;

            $applicability_persepsi = $this->getJawabanData($value->id_responden, 'applicability', 'persepsi')->first();

            $value->persepsi_ap1 = $applicability_persepsi->ap1;
            $value->persepsi_ap2 = $applicability_persepsi->ap2;

            
            
            $datas[] = $value;
        }
        $data['datas'] = $datas;

        return view('admin.responden.export', $data);
    }

}
