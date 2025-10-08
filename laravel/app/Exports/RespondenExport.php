<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use App\Responden;
use App\Provinsi;
use App\Bisnis;
use App\Jawaban_realibility;
use App\Jawaban_empathy;
use App\Jawaban_responsiveness;
use App\Jawaban_relevance;
use App\Jawaban_assurance;
use App\Jawaban_tangible;
use App\Jawaban_lp;
use App\Jawaban_kp;
use App\Jawaban_kritik_saran;
use App\User;
use App\Jawaban_applicability;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RespondenExport implements FromView
{
    
 
    public function view(): View
    {
        $responden = Responden::
                        leftJoin('tbl_bisnis', 'tbl_bisnis.id_bisnis', '=', 'tbl_responden.id_bisnis')
                        ->leftJoin('provinsi', 'provinsi.id', '=', 'tbl_responden.domisili')
                        ->get();

        $datas = array();
        foreach($responden as $key => $value){
            $realibility_kepentingan = Jawaban_realibility::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','kepentingan')
                                    ->first();

            $value->kepentingan_r1 = $realibility_kepentingan->r1;
            $value->kepentingan_r2 = $realibility_kepentingan->r2;
            $value->kepentingan_r3 = $realibility_kepentingan->r3;
            $value->kepentingan_r4 = $realibility_kepentingan->r4;
            $value->kepentingan_r5 = $realibility_kepentingan->r5;
            $value->kepentingan_r6 = $realibility_kepentingan->r6;
            $value->kepentingan_r7 = $realibility_kepentingan->r7;

            $realibility_persepsi = Jawaban_realibility::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','persepsi')
                                    ->first();

            $value->persepsi_r1 = $realibility_persepsi->r1;
            $value->persepsi_r2 = $realibility_persepsi->r2;
            $value->persepsi_r3 = $realibility_persepsi->r3;
            $value->persepsi_r4 = $realibility_persepsi->r4;
            $value->persepsi_r5 = $realibility_persepsi->r5;
            $value->persepsi_r6 = $realibility_persepsi->r6;
            $value->persepsi_r7 = $realibility_persepsi->r7;

            //---
            $assurance_kepentingan = Jawaban_assurance::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','kepentingan')
                                    ->first();

            $value->kepentingan_a1 = $assurance_kepentingan->a1;
            $value->kepentingan_a2 = $assurance_kepentingan->a2;
            $value->kepentingan_a3 = $assurance_kepentingan->a3;
            $value->kepentingan_a4 = $assurance_kepentingan->a4;

            $assurance_persepsi = Jawaban_assurance::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','persepsi')
                                    ->first();

            $value->persepsi_a1 = $assurance_persepsi->a1;
            $value->persepsi_a2 = $assurance_persepsi->a2;
            $value->persepsi_a3 = $assurance_persepsi->a3;
            $value->persepsi_a4 = $assurance_persepsi->a4;

            //---
            $tangible_kepentingan = Jawaban_tangible::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','kepentingan')
                                    ->first();

            $value->kepentingan_t1 = $tangible_kepentingan->t1;
            $value->kepentingan_t2 = $tangible_kepentingan->t2;
            $value->kepentingan_t3 = $tangible_kepentingan->t3;
            $value->kepentingan_t4 = $tangible_kepentingan->t4;
            $value->kepentingan_t5 = $tangible_kepentingan->t5;
            $value->kepentingan_t6 = $tangible_kepentingan->t6;

            $tangible_persepsi = Jawaban_tangible::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','persepsi')
                                    ->first();

            $value->persepsi_t1 = $tangible_persepsi->t1;
            $value->persepsi_t2 = $tangible_persepsi->t2;
            $value->persepsi_t3 = $tangible_persepsi->t3;
            $value->persepsi_t4 = $tangible_persepsi->t4;
            $value->persepsi_t5 = $tangible_persepsi->t5;
            $value->persepsi_t6 = $tangible_persepsi->t6;

            //---
            $empathy_kepentingan = Jawaban_empathy::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','kepentingan')
                                    ->first();

            $value->kepentingan_e1 = $empathy_kepentingan->e1;
            $value->kepentingan_e2 = $empathy_kepentingan->e2;
            $value->kepentingan_e3 = $empathy_kepentingan->e3;
            $value->kepentingan_e4 = $empathy_kepentingan->e4;
            $value->kepentingan_e5 = $empathy_kepentingan->e5;

            $empathy_persepsi = Jawaban_empathy::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','persepsi')
                                    ->first();

            $value->persepsi_e1 = $empathy_persepsi->e1;
            $value->persepsi_e2 = $empathy_persepsi->e2;
            $value->persepsi_e3 = $empathy_persepsi->e3;
            $value->persepsi_e4 = $empathy_persepsi->e4;
            $value->persepsi_e5 = $empathy_persepsi->e5;

            //---
            $responsiveness_kepentingan = Jawaban_responsiveness::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','kepentingan')
                                    ->first();

            $value->kepentingan_rs1 = $responsiveness_kepentingan->rs1;
            $value->kepentingan_rs2 = $responsiveness_kepentingan->rs2;

            $responsiveness_persepsi = Jawaban_responsiveness::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','persepsi')
                                    ->first();

            $value->persepsi_rs1 = $responsiveness_persepsi->rs1;
            $value->persepsi_rs2 = $responsiveness_persepsi->rs2;

            //---
            $applicability_kepentingan = Jawaban_applicability::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','kepentingan')
                                    ->first();

            $value->kepentingan_ap1 = $applicability_kepentingan->ap1;
            $value->kepentingan_ap2 = $applicability_kepentingan->ap2;

            $applicability_persepsi = Jawaban_applicability::where('id_responden','=',$value->id_responden)
                                    ->where('kategori','=','persepsi')
                                    ->first();

            $value->persepsi_ap1 = $applicability_persepsi->ap1;
            $value->persepsi_ap2 = $applicability_persepsi->ap2;

            
            
            $datas[] = $value;
        }
        $data['datas'] = $datas;

        return view('admin.responden.export', $data);
    }

}
