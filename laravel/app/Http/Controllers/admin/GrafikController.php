<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Charts;

class GrafikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grafik1()
    {
        //k2=======================----------------------===========
        $k2_count = DB::table('tbl_jawaban_kp')->count('k2');
        $k2_sum = DB::table('tbl_jawaban_kp')->sum('k2');
        // rata-rata k2
        $total_rata_k2 = $k2_sum/$k2_count;
        //=======================----------------------===========

        //k3=======================----------------------===========
        $k3_count = DB::table('tbl_jawaban_kp')->count('k3');
        $k3_sum = DB::table('tbl_jawaban_kp')->sum('k3');
        // rata-rata k3
        $total_rata_k3 = $k3_sum/$k3_count;
        //=======================----------------------===========

        //gap
        $gap = $total_rata_k3-$total_rata_k2;

        //=======================----------------------===========
        //=======================----------------------===========

        //k1=======================----------------------===========
        $k1_count = DB::table('tbl_jawaban_kp')->count('k1');
        $k1_sum = DB::table('tbl_jawaban_kp')->sum('k1');
        //skala
        $k1_rata_count_1 = DB::table('tbl_jawaban_kp')->where('k1','=','1')->count('k1');
        $k1_rata_count_2 = DB::table('tbl_jawaban_kp')->where('k1','=','2')->count('k1');
        $k1_rata_count_3 = DB::table('tbl_jawaban_kp')->where('k1','=','3')->count('k1');
        $k1_rata_count_4 = DB::table('tbl_jawaban_kp')->where('k1','=','4')->count('k1');
        $k1_rata_count_5 = DB::table('tbl_jawaban_kp')->where('k1','=','5')->count('k1');
        
        return view('grafik.index1',[   'total_rata_k2' => $total_rata_k2,
                                        'total_rata_k3' => $total_rata_k3,
                                        'gap' => $gap,

                                        'k1_count' => $k1_count,
                                        'k1_sum' => $k1_sum,
                                        'k1_rata_count_1' => $k1_rata_count_1,
                                        'k1_rata_count_2' => $k1_rata_count_2,
                                        'k1_rata_count_3' => $k1_rata_count_3,
                                        'k1_rata_count_4' => $k1_rata_count_4,
                                        'k1_rata_count_5' => $k1_rata_count_5,
                                    ]);
    }
    public function grafik6()
    {
        //---------------------------------------------- ILP
        $l1_rata_sum = DB::table('tbl_jawaban_lp')->sum('l1');
        $l1_rata_count = DB::table('tbl_jawaban_lp')->count('l1');
        $l1_rata_rata =  $l1_rata_sum / $l1_rata_count;
        $cli_l1 = $l1_rata_rata/5*(100/100)*100;

        $l2_rata_sum = DB::table('tbl_jawaban_lp')->sum('l2');
        $l2_rata_count = DB::table('tbl_jawaban_lp')->count('l2');
        $l2_rata_rata =  $l2_rata_sum / $l2_rata_count;
        $cli_l2 = $l2_rata_rata/5*(100/100)*100;

        $l3_rata_sum = DB::table('tbl_jawaban_lp')->sum('l3');
        $l3_rata_count = DB::table('tbl_jawaban_lp')->count('l3');
        $l3_rata_rata =  $l3_rata_sum / $l3_rata_count;
        $cli_l3 = $l3_rata_rata/5*(100/100)*100;

        $total_l = $cli_l1+$cli_l2+$cli_l3;
        $total_l_rata = $total_l / 3;

        //L1------------------==================----------------
       
        $l1_rata_count = DB::table('tbl_jawaban_lp')->count('l1');
        //skala
        $l1_rata_count_1 = DB::table('tbl_jawaban_lp')->where('l1','=','1')->count('l1');
        $l1_rata_count_2 = DB::table('tbl_jawaban_lp')->where('l1','=','2')->count('l1');
        $l1_rata_count_3 = DB::table('tbl_jawaban_lp')->where('l1','=','3')->count('l1');
        $l1_rata_count_4 = DB::table('tbl_jawaban_lp')->where('l1','=','4')->count('l1');
        $l1_rata_count_5 = DB::table('tbl_jawaban_lp')->where('l1','=','5')->count('l1');

        //L2------------------==================----------------
        
        $l2_rata_count = DB::table('tbl_jawaban_lp')->count('l2');
        //skala
        $l2_rata_count_1 = DB::table('tbl_jawaban_lp')->where('l2','=','1')->count('l2');
        $l2_rata_count_2 = DB::table('tbl_jawaban_lp')->where('l2','=','2')->count('l2');
        $l2_rata_count_3 = DB::table('tbl_jawaban_lp')->where('l2','=','3')->count('l2');
        $l2_rata_count_4 = DB::table('tbl_jawaban_lp')->where('l2','=','4')->count('l2');
        $l2_rata_count_5 = DB::table('tbl_jawaban_lp')->where('l2','=','5')->count('l2');

        //L3------------------==================----------------
        
        $l3_rata_count = DB::table('tbl_jawaban_lp')->count('l3');
        //skala
        $l3_rata_count_1 = DB::table('tbl_jawaban_lp')->where('l3','=','1')->count('l3');
        $l3_rata_count_2 = DB::table('tbl_jawaban_lp')->where('l3','=','2')->count('l3');
        $l3_rata_count_3 = DB::table('tbl_jawaban_lp')->where('l3','=','3')->count('l3');
        $l3_rata_count_4 = DB::table('tbl_jawaban_lp')->where('l3','=','4')->count('l3');
        $l3_rata_count_5 = DB::table('tbl_jawaban_lp')->where('l3','=','5')->count('l3');
        
        //------------------==================----------------



        return view('grafik.index6',[   'l1_rata_count' => $l1_rata_count,
                                        'l1_rata_count_1' => $l1_rata_count_1,
                                        'l1_rata_count_2' => $l1_rata_count_2,
                                        'l1_rata_count_3' => $l1_rata_count_3,
                                        'l1_rata_count_4' => $l1_rata_count_4,
                                        'l1_rata_count_5' => $l1_rata_count_5,

                                        'l2_rata_count' => $l2_rata_count,
                                        'l2_rata_count_1' => $l2_rata_count_1,
                                        'l2_rata_count_2' => $l2_rata_count_2,
                                        'l2_rata_count_3' => $l2_rata_count_3,
                                        'l2_rata_count_4' => $l2_rata_count_4,
                                        'l2_rata_count_5' => $l2_rata_count_5,

                                        'l3_rata_count' => $l3_rata_count,
                                        'l3_rata_count_1' => $l3_rata_count_1,
                                        'l3_rata_count_2' => $l3_rata_count_2,
                                        'l3_rata_count_3' => $l3_rata_count_3,
                                        'l3_rata_count_4' => $l3_rata_count_4,
                                        'l3_rata_count_5' => $l3_rata_count_5,

                                        'total_l_rata' => $total_l_rata,
                                    ]);
    }

    public function grafik5()
    {
        //----------------------------------------------------------------------------
        //hitung jumlah responden
        $totalresponden = Responden::count('id_responden');
        //----------------------------------------------------------------------------
        //hitung jumlah responden laki-laki (frekuensi)
        $total_lk = Responden::where('jk','=','laki-laki')->count('id_responden');

        //hitung jumlah responden perempuan (frekuensi)
        $total_pr = Responden::where('jk','=','perempuan')->count('id_responden');

        // hitung persentase laki-laki
        
        if($total_lk !== 0){
            $persentase_lk = $total_lk/$totalresponden*100;
        }else{
            $persentase_lk = 0;
        }
        // hitung persentase perempuan
        
        if($total_pr !== 0){
            $persentase_pr = $total_pr/$totalresponden*100;
        }else{
            $persentase_pr = 0;
        }
        
        //----------------------------------------------------------------------------
        
        //hitung jumlah responden usia < 25 tahun
        $total_usia25 = Responden::where('usia','=','<25')->count('id_responden');
        //hitung jumlah responden usia 25-34 tahun
        $total_usia25_34 = Responden::where('usia','=','25-34')->count('id_responden');
        //hitung jumlah responden usia 35-44 tahun
        $total_usia35_44 = Responden::where('usia','=','35-44')->count('id_responden');
        //hitung jumlah responden usia 45-54 tahun
        $total_usia45_54 = Responden::where('usia','=','45-54')->count('id_responden');
        //hitung jumlah responden usia 55-64 tahun
        $total_usia55_64 = Responden::where('usia','=','55-64')->count('id_responden');
        //hitung jumlah responden usia >64 tahun
        $total_usia64 = Responden::where('usia','=','>64')->count('id_responden');

        //hitung persentase usia < 25 tahun
        
        if($total_usia25 !== 0){
            $persentase_usia25 = ($total_usia25/$totalresponden)*100;
        }else{
            $persentase_usia25 = 0;
        }
        //hitung persentase usia 25-34 tahun
        
        if($total_usia25_34 !== 0){
            $persentase_usia25_34 = ($total_usia25_34/$totalresponden)*100;
        }else{
            $persentase_usia25_34 = 0;
        }
        //hitung persentase usia 35-44 tahun
        
        if($total_usia35_44 !== 0){
            $persentase_usia35_44 = ($total_usia35_44/$totalresponden)*100;
        }else{
            $persentase_usia35_44 = 0;
        }
        //hitung persentase usia 45-54 tahun
        
        if($total_usia45_54 !== 0){
            $persentase_usia45_54 = ($total_usia45_54/$totalresponden)*100;
        }else{
            $persentase_usia45_54 = 0;
        }
        //hitung persentase usia 55-64 tahun
        
        if($total_usia55_64 !== 0){
            $persentase_usia55_64 = ($total_usia55_64/$totalresponden)*100;
        }else{
            $persentase_usia55_64 = 0;
        }
        //hitung persentase usia >64 tahun
        
        if($total_usia64 !== 0){
            $persentase_usia64 = ($total_usia64/$totalresponden)*100;
        }else{
            $persentase_usia64 = 0;
        }


        
        //----------------------------------------------------------------------------

        //hitung jumlah responden sesuai pekerjaan
        // swasta
        $total_swasta = Responden::where('pekerjaan','=','karyawan_swasta')->count('id_responden');
        // wiraswasta
        $total_wiraswasta = Responden::where('pekerjaan','=','wiraswasta')->count('id_responden');
        // pns
        $total_pns = Responden::where('pekerjaan','=','PNS')->count('id_responden');
        // pelajar
        $total_pelajar = Responden::where('pekerjaan','=','pelajar')->count('id_responden');
        // lain
        $total_lain = Responden::where('pekerjaan','=','lain')->count('id_responden');

        //hitung presentase swasta
        
        if($total_swasta !== 0){
            $persentase_swasta = ($total_swasta/$totalresponden)*100;
        }else{
            $persentase_swasta = 0;
        }
        //hitung presentase wiraswasta
        
        if($total_wiraswasta !== 0){
            $persentase_wiraswasta = ($total_wiraswasta/$totalresponden)*100;
        }else{
            $persentase_wiraswasta = 0;
        }
        //hitung presentase pns
        
        if($total_pns !== 0){
            $persentase_pns = ($total_pns/$totalresponden)*100;
        }else{
            $persentase_pns = 0;
        }
        //hitung presentase pelajar
        
        if($total_pelajar !== 0){
            $persentase_pelajar = ($total_pelajar/$totalresponden)*100;
        }else{
            $persentase_pelajar = 0;
        }
        //hitung presentase lain
        
        if($total_lain !== 0){
            $persentase_lain = ($total_lain/$totalresponden)*100;
        }else{
            $persentase_lain = 0;
        }

        //----------------------------------------------------------------------------
        //hitung jumlah responden sesuai domisili
        // jawa
        $total_jawa = Responden::where('domisili','=','1')->count('id_responden');
        // sulawesi
        $total_sulawesi = Responden::where('domisili','=','2')->count('id_responden');
        // Sumatera
        $total_sumatera = Responden::where('domisili','=','3')->count('id_responden');
        // kalimantan
        $total_kalimantan = Responden::where('domisili','=','4')->count('id_responden');
        // papua
        $total_papua = Responden::where('domisili','=','5')->count('id_responden');
        // bali
        $total_bali = Responden::where('domisili','=','6')->count('id_responden');
        // ntb/ntt
        $total_ntb = Responden::where('domisili','=','7')->count('id_responden');
        // maluku
        $total_maluku = Responden::where('domisili','=','8')->count('id_responden');

        //hitung presentase jawa
        if($total_jawa !== 0){
            $persentase_jawa = ($total_jawa/$totalresponden)*100;
        }else{
            $persentase_jawa = 0;
        }
        
        //hitung presentase sulawesi
        if($total_sulawesi !== 0){
            $persentase_sulawesi = ($total_sulawesi/$totalresponden)*100;
        }else{
            $persentase_sulawesi = 0;
        }
        
        //hitung presentase sumatera
        if($total_sumatera !== 0){
            $persentase_sumatera = ($total_sumatera/$totalresponden)*100;
        }else{
            $persentase_sumatera = 0;
        }
        
        //hitung presentase kalimantan
        if($total_kalimantan !== 0){
            $persentase_kalimantan = ($total_kalimantan/$totalresponden)*100;
        }else{
            $persentase_kalimantan = 0;
        }
        
        //hitung presentase papua
        if($total_papua !== 0){
            $persentase_papua = ($total_papua/$totalresponden)*100;
        }else{
            $persentase_papua = 0;
        }
        
        //hitung presentase bali
        if($total_bali !== 0){
            $persentase_bali = ($total_bali/$totalresponden)*100;
        }else{
            $persentase_bali = 0;
        }
        
        //hitung presentase ntb/ntt
        if($total_ntb !== 0){
            $persentase_ntb = ($total_ntb/$totalresponden)*100;
        }else{
            $persentase_ntb = 0;
        }
        
        //hitung presentase maluku
        if($total_maluku !== 0){
            $persentase_maluku = ($total_maluku/$totalresponden)*100;
        }else{
            $persentase_maluku = 0;
        }
        

        //--------------------------------------------------------------------------------------------
         //hitung jumlah responden usia < 25 tahun laki-laki
         $total_usia25_lk = Responden::where('usia','=','<25')->where('jk','=','laki-laki')->count('id_responden');
         //hitung jumlah responden usia 25-34 tahun laki-laki
         $total_usia25_34_lk = Responden::where('usia','=','25-34')->where('jk','=','laki-laki')->count('id_responden');
         //hitung jumlah responden usia 35-44 tahun laki-laki
         $total_usia35_44_lk = Responden::where('usia','=','35-44')->where('jk','=','laki-laki')->count('id_responden');
         //hitung jumlah responden usia 45-54 tahun laki-laki
         $total_usia45_54_lk = Responden::where('usia','=','45-54')->where('jk','=','laki-laki')->count('id_responden');
         //hitung jumlah responden usia 55-64 tahun laki-laki
         $total_usia55_64_lk = Responden::where('usia','=','55-64')->where('jk','=','laki-laki')->count('id_responden');
         //hitung jumlah responden usia >64 tahun laki-laki
         $total_usia64_lk = Responden::where('usia','=','>64')->where('jk','=','laki-laki')->count('id_responden');

         //hitung jumlah responden usia < 25 tahun perempuan
         $total_usia25_pr = Responden::where('usia','=','<25')->where('jk','=','perempuan')->count('id_responden');
         //hitung jumlah responden usia 25-34 tahun perempuan
         $total_usia25_34_pr = Responden::where('usia','=','25-34')->where('jk','=','perempuan')->count('id_responden');
         //hitung jumlah responden usia 35-44 tahun perempuan
         $total_usia35_44_pr = Responden::where('usia','=','35-44')->where('jk','=','perempuan')->count('id_responden');
         //hitung jumlah responden usia 45-54 tahun perempuan
         $total_usia45_54_pr = Responden::where('usia','=','45-54')->where('jk','=','perempuan')->count('id_responden');
         //hitung jumlah responden usia 55-64 tahun perempuan
         $total_usia55_64_pr = Responden::where('usia','=','55-64')->where('jk','=','perempuan')->count('id_responden');
         //hitung jumlah responden usia >64 tahun perempuan
         $total_usia64_pr = Responden::where('usia','=','>64')->where('jk','=','perempuan')->count('id_responden');

         



         //hitung persentase usia < 25 tahun laki-laki
        if($total_usia25_lk !== 0){
            $persentase_usia25_lk = ($total_usia25_lk/$total_usia25)*100;
        }else{
            $persentase_usia25_lk = 0;
        }
         
         //hitung persentase usia 25-34 tahun laki-laki
         if($total_usia25_34_lk !== 0){
            $persentase_usia25_34_lk = ($total_usia25_34_lk/$total_usia25_34)*100;
        }else{
            $persentase_usia25_34_lk = 0;
        }
         
         //hitung persentase usia 35-44 tahun laki-laki
         
        if($total_usia35_44_lk !== 0){
            $persentase_usia35_44_lk = ($total_usia35_44_lk/$total_usia35_44)*100;
        }else{
            $persentase_usia35_44_lk = 0;
        }
         //hitung persentase usia 45-54 tahun laki-laki
        if($total_usia45_54_lk !== 0){
           $persentase_usia45_54_lk = ($total_usia45_54_lk/$total_usia45_54)*100;
        }else{
            $persentase_usia45_54_lk = 0;
        }
         //hitung persentase usia 55-64 tahun laki-laki
         
         if($total_usia55_64_lk !== 0){
            $persentase_usia55_64_lk = ($total_usia55_64_lk/$total_usia55_64)*100;
         }else{
             $persentase_usia55_64_lk = 0;
         }
         //hitung persentase usia >64 tahun laki-laki
        
        if($total_usia64_lk !== 0){
            $persentase_usia64_lk = ($total_usia64_lk/$total_usia64)*100;
        }else{
            $persentase_usia64_lk = 0;
        }

         //hitung persentase usia < 25 tahun perempuan
         
         if($total_usia25_pr !== 0){
            $persentase_usia25_pr = ($total_usia25_pr/$total_usia25)*100;
        }else{
            $persentase_usia25_pr = 0;
        }
         //hitung persentase usia 25-34 tahun perempuan
         
         if($total_usia25_34_pr !== 0){
            $persentase_usia25_34_pr = ($total_usia25_34_pr/$total_usia25_34)*100;
        }else{
            $persentase_usia25_34_pr = 0;
        }
         //hitung persentase usia 35-44 tahun perempuan
         
         if($total_usia35_44_pr !== 0){
            $persentase_usia35_44_pr = ($total_usia35_44_pr/$total_usia35_44)*100;
        }else{
            $persentase_usia35_44_pr = 0;
        }
         //hitung persentase usia 45-54 tahun perempuan
         
         if($total_usia45_54_pr !== 0){
            $persentase_usia45_54_pr = ($total_usia45_54_pr/$total_usia45_54)*100;
        }else{
            $persentase_usia45_54_pr = 0;
        }
         //hitung persentase usia 55-64 tahun perempuan
         
         if($total_usia55_64_pr !== 0){
            $persentase_usia55_64_pr = ($total_usia55_64_pr/$total_usia55_64)*100;
        }else{
            $persentase_usia55_64_pr = 0;
        }
         //hitung persentase usia >64 tahun perempuan
        if($total_usia64_pr !== 0){
            $persentase_usia64_pr = $total_usia64_pr/$total_usia64*100;
        }else{
            $persentase_usia64_pr = 0;
        }





        return view('grafik.index5',[   
       
                                        //persentase laki-laki usia
                                        'persentase_usia25_lk' => $persentase_usia25_lk,
                                        'persentase_usia25_34_lk' => $persentase_usia25_34_lk,
                                        'persentase_usia35_44_lk' => $persentase_usia35_44_lk,
                                        'persentase_usia45_54_lk' => $persentase_usia45_54_lk,
                                        'persentase_usia55_64_lk' => $persentase_usia55_64_lk,
                                        'persentase_usia64_lk' => $persentase_usia64_lk,
                                        //persentase perempuan usia
                                        'persentase_usia25_pr' => $persentase_usia25_pr,
                                        'persentase_usia25_34_pr' => $persentase_usia25_34_pr,
                                        'persentase_usia35_44_pr' => $persentase_usia35_44_pr,
                                        'persentase_usia45_54_pr' => $persentase_usia45_54_pr,
                                        'persentase_usia55_64_pr' => $persentase_usia55_64_pr,
                                        'persentase_usia64_pr' => $persentase_usia64_pr,

                                        //total usia
                                        'total_usia25' => $persentase_usia25,
                                        'total_usia25_34' => $persentase_usia25_34,
                                        'total_usia35_44' => $persentase_usia35_44,
                                        'total_usia45_54' => $persentase_usia45_54,
                                        'total_usia55_64' => $persentase_usia55_64,
                                        'total_usia64' => $persentase_usia64,

                                        //total pekerjaan
                                        'total_swasta' => $persentase_swasta,
                                        'total_wiraswasta' => $persentase_wiraswasta,
                                        'total_pns' => $persentase_pns,
                                        'total_pelajar' => $persentase_pelajar,
                                        'total_lain' => $persentase_lain,

                                         //total domisili
                                         'total_jawa' => $persentase_jawa,
                                         'total_sulawesi' => $persentase_sulawesi,
                                         'total_sumatera' => $persentase_sumatera,
                                         'total_kalimantan' => $persentase_kalimantan,
                                         'total_bali' => $persentase_bali,
                                         'total_ntb' => $persentase_ntb,
                                         'total_papua' => $persentase_papua,
                                         'total_maluku' => $persentase_maluku,
                                        
                                    ]);
                                    


                                    
    }
    public function grafik2()
    {
        //---------------------------------------------- ILP
        $l1_rata_sum = DB::table('tbl_jawaban_lp')->sum('l1');
        $l1_rata_count = DB::table('tbl_jawaban_lp')->count('l1');
        $l1_rata_rata =  $l1_rata_sum / $l1_rata_count;
        $cli_l1 = $l1_rata_rata/5*(100/100)*100;

        $l2_rata_sum = DB::table('tbl_jawaban_lp')->sum('l2');
        $l2_rata_count = DB::table('tbl_jawaban_lp')->count('l2');
        $l2_rata_rata =  $l2_rata_sum / $l2_rata_count;
        $cli_l2 = $l2_rata_rata/5*(100/100)*100;

        $l3_rata_sum = DB::table('tbl_jawaban_lp')->sum('l3');
        $l3_rata_count = DB::table('tbl_jawaban_lp')->count('l3');
        $l3_rata_rata =  $l3_rata_sum / $l3_rata_count;
        $cli_l3 = $l3_rata_rata/5*(100/100)*100;

        $total_l = $cli_l1+$cli_l2+$cli_l3;
        $total_l_rata = $total_l / 3;



        //---------------------------------------------- IKP


        //realibility =================
        //persepsi
        $r1_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r1');
        $r1_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r1');
        $r1_ratapersepsi_rata =  $r1_ratapersepsi_sum / $r1_ratapersepsi_count;

        $r2_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r2');
        $r2_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r2');
        $r2_ratapersepsi_rata =  $r2_ratapersepsi_sum / $r2_ratapersepsi_count;

        $r3_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r3');
        $r3_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r3');
        $r3_ratapersepsi_rata =  $r3_ratapersepsi_sum / $r3_ratapersepsi_count;

        $r4_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r4');
        $r4_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r4');
        $r4_ratapersepsi_rata =  $r4_ratapersepsi_sum / $r4_ratapersepsi_count;

        $r5_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r5');
        $r5_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r5');
        $r5_ratapersepsi_rata =  $r5_ratapersepsi_sum / $r5_ratapersepsi_count;

        $r6_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r6');
        $r6_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r6');
        $r6_ratapersepsi_rata =  $r6_ratapersepsi_sum / $r6_ratapersepsi_count;

        $r7_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r7');
        $r7_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r7');
        $r7_ratapersepsi_rata =  $r7_ratapersepsi_sum / $r7_ratapersepsi_count;

        $total_rpersepsi = ($r1_ratapersepsi_rata+$r2_ratapersepsi_rata+$r3_ratapersepsi_rata+$r4_ratapersepsi_rata+$r5_ratapersepsi_rata+$r6_ratapersepsi_rata+$r7_ratapersepsi_rata);

        //assurance ================
        //persepsi
        $a1_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a1');
        $a1_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a1');
        $a1_ratapersepsi_rata =  $a1_ratapersepsi_sum / $a1_ratapersepsi_count;

        $a2_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a2');
        $a2_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a2');
        $a2_ratapersepsi_rata =  $a2_ratapersepsi_sum / $a2_ratapersepsi_count;

        $a3_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a3');
        $a3_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a3');
        $a3_ratapersepsi_rata =  $a3_ratapersepsi_sum / $a3_ratapersepsi_count;

        $a4_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a4');
        $a4_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a4');
        $a4_ratapersepsi_rata =  $a4_ratapersepsi_sum / $a4_ratapersepsi_count;

        $total_apersepsi = ($a1_ratapersepsi_rata+$a2_ratapersepsi_rata+$a3_ratapersepsi_rata+$a4_ratapersepsi_rata);


        //Tangible ================
        //persepsi
        $t1_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t1');
        $t1_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t1');
        $t1_ratapersepsi_rata =  $t1_ratapersepsi_sum / $t1_ratapersepsi_count;

        $t2_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t2');
        $t2_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t2');
        $t2_ratapersepsi_rata =  $t2_ratapersepsi_sum / $t2_ratapersepsi_count;

        $t3_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t3');
        $t3_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t3');
        $t3_ratapersepsi_rata =  $t3_ratapersepsi_sum / $t3_ratapersepsi_count;

        $t4_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t4');
        $t4_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t4');
        $t4_ratapersepsi_rata =  $t4_ratapersepsi_sum / $t4_ratapersepsi_count;

        $t5_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t5');
        $t5_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t5');
        $t5_ratapersepsi_rata =  $t5_ratapersepsi_sum / $t5_ratapersepsi_count;

        $t6_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t6');
        $t6_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t6');
        $t6_ratapersepsi_rata =  $t6_ratapersepsi_sum / $t6_ratapersepsi_count;

        $total_tpersepsi = ($t1_ratapersepsi_rata+$t2_ratapersepsi_rata+$t3_ratapersepsi_rata+$t4_ratapersepsi_rata+$t5_ratapersepsi_rata+$t6_ratapersepsi_rata);



        //Empathy ================
        //persepsi
        $e1_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e1');
        $e1_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e1');
        $e1_ratapersepsi_rata =  $e1_ratapersepsi_sum / $e1_ratapersepsi_count;

        $e2_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e2');
        $e2_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e2');
        $e2_ratapersepsi_rata =  $e2_ratapersepsi_sum / $e2_ratapersepsi_count;

        $e3_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e3');
        $e3_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e3');
        $e3_ratapersepsi_rata =  $e3_ratapersepsi_sum / $e3_ratapersepsi_count;

        $e4_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e4');
        $e4_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e4');
        $e4_ratapersepsi_rata =  $e4_ratapersepsi_sum / $e4_ratapersepsi_count;

        $e5_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e5');
        $e5_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e5');
        $e5_ratapersepsi_rata =  $e5_ratapersepsi_sum / $e5_ratapersepsi_count;

     
        $total_epersepsi = ($e1_ratapersepsi_rata+$e2_ratapersepsi_rata+$e3_ratapersepsi_rata+$e4_ratapersepsi_rata+$e5_ratapersepsi_rata);

        //Responsivness ================
        //persepsi
        $rs1_ratapersepsi_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->sum('rs1');
        $rs1_ratapersepsi_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->count('rs1');
        $rs1_ratapersepsi_rata =  $rs1_ratapersepsi_sum / $rs1_ratapersepsi_count;

        $rs2_ratapersepsi_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->sum('rs2');
        $rs2_ratapersepsi_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->count('rs2');
        $rs2_ratapersepsi_rata =  $rs2_ratapersepsi_sum / $rs2_ratapersepsi_count;

       
        $total_rspersepsi = ($rs1_ratapersepsi_rata+$rs2_ratapersepsi_rata);
        
        

        //Applicability ================
        //persepsi
        $rl1_ratapersepsi_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->sum('ap1');
        $rl1_ratapersepsi_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->count('ap1');
        $rl1_ratapersepsi_rata =  $rl1_ratapersepsi_sum / $rl1_ratapersepsi_count;

        $rl2_ratapersepsi_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->sum('ap2');
        $rl2_ratapersepsi_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->count('ap2');
        $rl2_ratapersepsi_rata =  $rl2_ratapersepsi_sum / $rl2_ratapersepsi_count;

        

        $total_rlpersepsi = ($rl1_ratapersepsi_rata+$rl2_ratapersepsi_rata);
        

        


        //-------------------------------------------------------
        //-------------------------------------------------------


        //realibility =================
        //kepentingan/harapan
        $r1_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r1');
        $r1_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r1');
        $r1_ratakepentingan_rata =  $r1_ratakepentingan_sum / $r1_ratakepentingan_count;

        $r2_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r2');
        $r2_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r2');
        $r2_ratakepentingan_rata =  $r2_ratakepentingan_sum / $r2_ratakepentingan_count;

        $r3_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r3');
        $r3_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r3');
        $r3_ratakepentingan_rata =  $r3_ratakepentingan_sum / $r3_ratakepentingan_count;

        $r4_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r4');
        $r4_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r4');
        $r4_ratakepentingan_rata =  $r4_ratakepentingan_sum / $r4_ratakepentingan_count;

        $r5_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r5');
        $r5_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r5');
        $r5_ratakepentingan_rata =  $r5_ratakepentingan_sum / $r5_ratakepentingan_count;

        $r6_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r6');
        $r6_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r6');
        $r6_ratakepentingan_rata =  $r6_ratakepentingan_sum / $r6_ratakepentingan_count;

        $r7_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r7');
        $r7_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r7');
        $r7_ratakepentingan_rata =  $r7_ratakepentingan_sum / $r7_ratakepentingan_count;


        $total_rkepentingan = ($r1_ratakepentingan_rata+$r2_ratakepentingan_rata+$r3_ratakepentingan_rata+$r4_ratakepentingan_rata+$r5_ratakepentingan_rata+$r6_ratakepentingan_rata+$r7_ratakepentingan_rata);
        //$total_rgap = $total_rpersepsi-$total_rkepentingan;


        //assurance ================
        //kepentingan/harapan
        $a1_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a1');
        $a1_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a1');
        $a1_ratakepentingan_rata =  $a1_ratakepentingan_sum / $a1_ratakepentingan_count;

        $a2_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a2');
        $a2_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a2');
        $a2_ratakepentingan_rata =  $a2_ratakepentingan_sum / $a2_ratakepentingan_count;

        $a3_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a3');
        $a3_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a3');
        $a3_ratakepentingan_rata =  $a3_ratakepentingan_sum / $a3_ratakepentingan_count;

        $a4_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a4');
        $a4_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a4');
        $a4_ratakepentingan_rata =  $a4_ratakepentingan_sum / $a4_ratakepentingan_count;

       

        $total_akepentingan = ($a1_ratakepentingan_rata+$a2_ratakepentingan_rata+$a3_ratakepentingan_rata+$a4_ratakepentingan_rata);
        //$total_agap = $total_apersepsi-$total_akepentingan;

        //Tangible ================
        //kepentingan/harapan
        $t1_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t1');
        $t1_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t1');
        $t1_ratakepentingan_rata =  $t1_ratakepentingan_sum / $t1_ratakepentingan_count;

        $t2_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t2');
        $t2_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t2');
        $t2_ratakepentingan_rata =  $t2_ratakepentingan_sum / $t2_ratakepentingan_count;

        $t3_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t3');
        $t3_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t3');
        $t3_ratakepentingan_rata =  $t3_ratakepentingan_sum / $t3_ratakepentingan_count;

        $t4_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t4');
        $t4_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t4');
        $t4_ratakepentingan_rata =  $t4_ratakepentingan_sum / $t4_ratakepentingan_count;

        $t5_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t5');
        $t5_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t5');
        $t5_ratakepentingan_rata =  $t5_ratakepentingan_sum / $t5_ratakepentingan_count;

        $t6_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t6');
        $t6_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t6');
        $t6_ratakepentingan_rata =  $t6_ratakepentingan_sum / $t6_ratakepentingan_count;

        $total_tkepentingan = ($t1_ratakepentingan_rata+$t2_ratakepentingan_rata+$t3_ratakepentingan_rata+$t4_ratakepentingan_rata+$t5_ratakepentingan_rata+$t6_ratakepentingan_rata);
        //$total_tgap = $total_tpersepsi-$total_tkepentingan;


        //Empathy ================
        //kepentingan/harapan
        $e1_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e1');
        $e1_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e1');
        $e1_ratakepentingan_rata =  $e1_ratakepentingan_sum / $e1_ratakepentingan_count;

        $e2_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e2');
        $e2_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e2');
        $e2_ratakepentingan_rata =  $e2_ratakepentingan_sum / $e2_ratakepentingan_count;

        $e3_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e3');
        $e3_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e3');
        $e3_ratakepentingan_rata =  $e3_ratakepentingan_sum / $e3_ratakepentingan_count;

        $e4_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e4');
        $e4_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e4');
        $e4_ratakepentingan_rata =  $e4_ratakepentingan_sum / $e4_ratakepentingan_count;

        $e5_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e5');
        $e5_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e5');
        $e5_ratakepentingan_rata =  $e5_ratakepentingan_sum / $e5_ratakepentingan_count;

        
        $total_ekepentingan = ($e1_ratakepentingan_rata+$e2_ratakepentingan_rata+$e3_ratakepentingan_rata+$e4_ratakepentingan_rata+$e5_ratakepentingan_rata);
        
        //$total_tgap = $total_epersepsi-$total_ekepentingan;


        //Responsivness ================
        //kepentingan/harapan
        $rs1_ratakepentingan_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->sum('rs1');
        $rs1_ratakepentingan_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->count('rs1');
        $rs1_ratakepentingan_rata =  $rs1_ratakepentingan_sum / $rs1_ratakepentingan_count;

        $rs2_ratakepentingan_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->sum('rs2');
        $rs2_ratakepentingan_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->count('rs2');
        $rs2_ratakepentingan_rata =  $rs2_ratakepentingan_sum / $rs2_ratakepentingan_count;


        $total_rskepentingan = ($rs1_ratakepentingan_rata+$rs2_ratakepentingan_rata);
        //$total_rsgap = $total_rspersepsi-$total_rskepentingan;

        //Relevansi ================
        //kepentingan/harapan
        $rl1_ratakepentingan_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->sum('ap1');
        $rl1_ratakepentingan_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->count('ap1');
        $rl1_ratakepentingan_rata =  $rl1_ratakepentingan_sum / $rl1_ratakepentingan_count;

        $rl2_ratakepentingan_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->sum('ap2');
        $rl2_ratakepentingan_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->count('ap2');
        $rl2_ratakepentingan_rata =  $rl2_ratakepentingan_sum / $rl2_ratakepentingan_count;


        $total_rlkepentingan = ($rl1_ratakepentingan_rata+$rl2_ratakepentingan_rata);
        //$total_rlgap = $total_rlpersepsi-$total_rlkepentingan;

        // total rata-rata harapan untuk semua item --------------------------

        $totalharapan = $total_rkepentingan+$total_akepentingan+$total_tkepentingan+$total_ekepentingan+$total_rskepentingan+$total_rlkepentingan;

        //r
        $wf_r1 = $r1_ratakepentingan_rata/$totalharapan;
        $ws_r1 = $r1_ratapersepsi_rata*$wf_r1;
        $gap_r1 = $r1_ratapersepsi_rata-$r1_ratakepentingan_rata;

        $wf_r2 = $r2_ratakepentingan_rata/$totalharapan;
        $ws_r2 = $r2_ratapersepsi_rata*$wf_r2;
        $gap_r2 = $r2_ratapersepsi_rata-$r2_ratakepentingan_rata;

        $wf_r3 = $r3_ratakepentingan_rata/$totalharapan;
        $ws_r3 = $r3_ratapersepsi_rata*$wf_r3;
        $gap_r3 = $r3_ratapersepsi_rata-$r3_ratakepentingan_rata;

        $wf_r4 = $r4_ratakepentingan_rata/$totalharapan;
        $ws_r4 = $r4_ratapersepsi_rata*$wf_r4;
        $gap_r4 = $r4_ratapersepsi_rata-$r4_ratakepentingan_rata;

        $wf_r5 = $r5_ratakepentingan_rata/$totalharapan;
        $ws_r5 = $r5_ratapersepsi_rata*$wf_r5;
        $gap_r5 = $r5_ratapersepsi_rata-$r5_ratakepentingan_rata;

        $wf_r6 = $r6_ratakepentingan_rata/$totalharapan;
        $ws_r6 = $r6_ratapersepsi_rata*$wf_r6;
        $gap_r6 = $r6_ratapersepsi_rata-$r6_ratakepentingan_rata;

        $wf_r7 = $r7_ratakepentingan_rata/$totalharapan;
        $ws_r7 = $r7_ratapersepsi_rata*$wf_r7;
        $gap_r7 = $r7_ratapersepsi_rata-$r7_ratakepentingan_rata;

        $rata_gap_r = ($gap_r1+$gap_r2+$gap_r3+$gap_r4+$gap_r5+$gap_r6+$gap_r7)/7;
        $deviasi_r = sqrt(( (pow($gap_r1-$rata_gap_r,2))+(pow($gap_r2-$rata_gap_r,2))+(pow($gap_r3-$rata_gap_r,2))+(pow($gap_r4-$rata_gap_r,2))+(pow($gap_r5-$rata_gap_r,2))+(pow($gap_r6-$rata_gap_r,2))  )/6);
        

        $wf_a1 = $a1_ratakepentingan_rata/$totalharapan;
        $ws_a1 = $a1_ratapersepsi_rata*$wf_a1;
        $gap_a1 = $a1_ratapersepsi_rata-$a1_ratakepentingan_rata;

        $wf_a2 = $a2_ratakepentingan_rata/$totalharapan;
        $ws_a2 = $a2_ratapersepsi_rata*$wf_a2;
        $gap_a2 = $a2_ratapersepsi_rata-$a2_ratakepentingan_rata;

        $wf_a3 = $a3_ratakepentingan_rata/$totalharapan;
        $ws_a3 = $a3_ratapersepsi_rata*$wf_a3;
        $gap_a3 = $a3_ratapersepsi_rata-$a3_ratakepentingan_rata;

        $wf_a4 = $a4_ratakepentingan_rata/$totalharapan;
        $ws_a4 = $a4_ratapersepsi_rata*$wf_a4;
        $gap_a4 = $a4_ratapersepsi_rata-$a4_ratakepentingan_rata;
        
        $rata_gap_a = ($gap_a1+$gap_a2+$gap_a3+$gap_a4)/4;
        $deviasi_a = sqrt(( (pow($gap_a1-$rata_gap_a,2))+(pow($gap_a2-$rata_gap_a,2))+(pow($gap_a3-$rata_gap_a,2))+(pow($gap_a4-$rata_gap_a,2))  )/3);
        
        

        $wf_t1 = $t1_ratakepentingan_rata/$totalharapan;
        $ws_t1 = $t1_ratapersepsi_rata*$wf_t1;
        $gap_t1 = $t1_ratapersepsi_rata-$t1_ratakepentingan_rata;

        $wf_t2 = $t2_ratakepentingan_rata/$totalharapan;
        $ws_t2 = $t2_ratapersepsi_rata*$wf_t2;
        $gap_t2 = $t2_ratapersepsi_rata-$t2_ratakepentingan_rata;

        $wf_t3 = $t3_ratakepentingan_rata/$totalharapan;
        $ws_t3 = $t3_ratapersepsi_rata*$wf_t3;
        $gap_t3 = $t3_ratapersepsi_rata-$t3_ratakepentingan_rata;

        $wf_t4 = $t4_ratakepentingan_rata/$totalharapan;
        $ws_t4 = $t4_ratapersepsi_rata*$wf_t4;
        $gap_t4 = $t4_ratapersepsi_rata-$t4_ratakepentingan_rata;

        $wf_t5 = $t5_ratakepentingan_rata/$totalharapan;
        $ws_t5 = $t5_ratapersepsi_rata*$wf_t5;
        $gap_t5 = $t5_ratapersepsi_rata-$t5_ratakepentingan_rata;

        $wf_t6 = $t6_ratakepentingan_rata/$totalharapan;
        $ws_t6 = $t6_ratapersepsi_rata*$wf_t6;
        $gap_t6 = $t6_ratapersepsi_rata-$t6_ratakepentingan_rata;

        $rata_gap_t = ($gap_t1+$gap_t2+$gap_t3+$gap_t4+$gap_t5+$gap_t6)/6;
        $deviasi_t = sqrt(( (pow($gap_t1-$rata_gap_t,2))+(pow($gap_t2-$rata_gap_t,2))+(pow($gap_t3-$rata_gap_t,2))+(pow($gap_t4-$rata_gap_t,2))+(pow($gap_t5-$rata_gap_t,2))+(pow($gap_t6-$rata_gap_t,2))  )/5);
        

        $wf_e1 = $e1_ratakepentingan_rata/$totalharapan;
        $ws_e1 = $e1_ratapersepsi_rata*$wf_e1;
        $gap_e1 = $e1_ratapersepsi_rata-$e1_ratakepentingan_rata;

        $wf_e2 = $e2_ratakepentingan_rata/$totalharapan;
        $ws_e2 = $e2_ratapersepsi_rata*$wf_e2;
        $gap_e2 = $e2_ratapersepsi_rata-$e2_ratakepentingan_rata;

        $wf_e3 = $e3_ratakepentingan_rata/$totalharapan;
        $ws_e3 = $e3_ratapersepsi_rata*$wf_e3;
        $gap_e3 = $e3_ratapersepsi_rata-$e3_ratakepentingan_rata;

        $wf_e4 = $e4_ratakepentingan_rata/$totalharapan;
        $ws_e4 = $e4_ratapersepsi_rata*$wf_e4;
        $gap_e4 = $e4_ratapersepsi_rata-$e4_ratakepentingan_rata;

        $wf_e5 = $e5_ratakepentingan_rata/$totalharapan;
        $ws_e5 = $e5_ratapersepsi_rata*$wf_e5;
        $gap_e5 = $e5_ratapersepsi_rata-$e5_ratakepentingan_rata;

        $rata_gap_e = ($gap_e1+$gap_e2+$gap_e3+$gap_e4+$gap_e5)/5;
        $deviasi_e = sqrt(( (pow($gap_e1-$rata_gap_e,2))+(pow($gap_e2-$rata_gap_e,2))+(pow($gap_e3-$rata_gap_e,2))+(pow($gap_e4-$rata_gap_e,2))+(pow($gap_e5-$rata_gap_e,2))  )/4);
        
        
        $wf_rs1 = $rs1_ratakepentingan_rata/$totalharapan;
        $ws_rs1 = $rs1_ratapersepsi_rata*$wf_rs1;
        $gap_rs1 = $rs1_ratapersepsi_rata-$rs1_ratakepentingan_rata;

        $wf_rs2 = $rs2_ratakepentingan_rata/$totalharapan;
        $ws_rs2 = $rs2_ratapersepsi_rata*$wf_rs2;
        $gap_rs2 = $rs2_ratapersepsi_rata-$rs2_ratakepentingan_rata;

        $rata_gap_rs = ($gap_rs1+$gap_rs2)/2;
        $deviasi_rs = sqrt(( (pow($gap_rs1-$rata_gap_rs,2))+(pow($gap_rs2-$rata_gap_rs,2)) )/1);
        
        

        $wf_rl1 = $rl1_ratakepentingan_rata/$totalharapan;
        $ws_rl1 = $rl1_ratapersepsi_rata*$wf_rl1;
        $gap_rl1 = $rl1_ratapersepsi_rata-$rl1_ratakepentingan_rata;

        $wf_rl2 = $rl2_ratakepentingan_rata/$totalharapan;
        $ws_rl2 = $rl2_ratapersepsi_rata*$wf_rl2;
        $gap_rl2 = $rl2_ratapersepsi_rata-$rl2_ratakepentingan_rata;

        $rata_gap_rl = ($gap_rl1+$gap_rl2)/2;
        $deviasi_rl = sqrt(( (pow($gap_rl1-$rata_gap_rl,2))+(pow($gap_rl2-$rata_gap_rl,2)) )/1);
       

        $totalws = $ws_r1+$ws_r2+$ws_r3+$ws_r4+$ws_r5+$ws_r6+$ws_r7+$ws_a1+$ws_a2+$ws_a3+$ws_a4+$ws_t1+$ws_t2+$ws_t3+$ws_t4+$ws_t5+$ws_t6+$ws_e1+$ws_e2+$ws_e3+$ws_e4+$ws_e5+$ws_rs1+$ws_rs2+$ws_rl1+$ws_rl2;
        $totalikp = ($totalws/5) * (100/100)*100;
        
        return view('grafik.index2',[   'total_l_rata' => $total_l_rata,

                            'totalikp' => $totalikp,

                            'rata_gap_r' => $rata_gap_r,
                            'deviasi_r' => $deviasi_r,

                            'rata_gap_a' => $rata_gap_a,
                            'deviasi_a' => $deviasi_a,

                            'rata_gap_t' => $rata_gap_t,
                            'deviasi_t' => $deviasi_t,

                            'rata_gap_e' => $rata_gap_e,
                            'deviasi_e' => $deviasi_e,

                            'rata_gap_rs' => $rata_gap_rs,
                            'deviasi_rs' => $deviasi_rs,

                            'rata_gap_rl' => $rata_gap_rl,
                            'deviasi_rl' => $deviasi_rl,


                                    ]);
    }

    public function grafik3()
    {
        //realibility =================
        //persepsi
        $r1_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r1');
        $r1_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r1');
        $r1_ratapersepsi_rata =  $r1_ratapersepsi_sum / $r1_ratapersepsi_count;

        $r2_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r2');
        $r2_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r2');
        $r2_ratapersepsi_rata =  $r2_ratapersepsi_sum / $r2_ratapersepsi_count;

        $r3_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r3');
        $r3_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r3');
        $r3_ratapersepsi_rata =  $r3_ratapersepsi_sum / $r3_ratapersepsi_count;

        $r4_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r4');
        $r4_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r4');
        $r4_ratapersepsi_rata =  $r4_ratapersepsi_sum / $r4_ratapersepsi_count;

        $r5_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r5');
        $r5_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r5');
        $r5_ratapersepsi_rata =  $r5_ratapersepsi_sum / $r5_ratapersepsi_count;

        $r6_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r6');
        $r6_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r6');
        $r6_ratapersepsi_rata =  $r6_ratapersepsi_sum / $r6_ratapersepsi_count;

        $r7_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r7');
        $r7_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r7');
        $r7_ratapersepsi_rata =  $r7_ratapersepsi_sum / $r7_ratapersepsi_count;
        //kepentingan/harapan
        $r1_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r1');
        $r1_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r1');
        $r1_ratakepentingan_rata =  $r1_ratakepentingan_sum / $r1_ratakepentingan_count;

        $r2_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r2');
        $r2_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r2');
        $r2_ratakepentingan_rata =  $r2_ratakepentingan_sum / $r2_ratakepentingan_count;

        $r3_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r3');
        $r3_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r3');
        $r3_ratakepentingan_rata =  $r3_ratakepentingan_sum / $r3_ratakepentingan_count;

        $r4_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r4');
        $r4_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r4');
        $r4_ratakepentingan_rata =  $r4_ratakepentingan_sum / $r4_ratakepentingan_count;

        $r5_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r5');
        $r5_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r5');
        $r5_ratakepentingan_rata =  $r5_ratakepentingan_sum / $r5_ratakepentingan_count;

        $r6_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r6');
        $r6_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r6');
        $r6_ratakepentingan_rata =  $r6_ratakepentingan_sum / $r6_ratakepentingan_count;

        $r7_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r7');
        $r7_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r7');
        $r7_ratakepentingan_rata =  $r7_ratakepentingan_sum / $r7_ratakepentingan_count;

        //assurance ================
        //persepsi
        $a1_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a1');
        $a1_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a1');
        $a1_ratapersepsi_rata =  $a1_ratapersepsi_sum / $a1_ratapersepsi_count;

        $a2_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a2');
        $a2_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a2');
        $a2_ratapersepsi_rata =  $a2_ratapersepsi_sum / $a2_ratapersepsi_count;

        $a3_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a3');
        $a3_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a3');
        $a3_ratapersepsi_rata =  $a3_ratapersepsi_sum / $a3_ratapersepsi_count;

        $a4_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a4');
        $a4_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a4');
        $a4_ratapersepsi_rata =  $a4_ratapersepsi_sum / $a4_ratapersepsi_count;

        //$a5_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a5');
        //$a5_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a5');
        //$a5_ratapersepsi_rata =  $a5_ratapersepsi_sum / $a5_ratapersepsi_count;

        //kepentingan/harapan
        $a1_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a1');
        $a1_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a1');
        $a1_ratakepentingan_rata =  $a1_ratakepentingan_sum / $a1_ratakepentingan_count;

        $a2_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a2');
        $a2_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a2');
        $a2_ratakepentingan_rata =  $a2_ratakepentingan_sum / $a2_ratakepentingan_count;

        $a3_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a3');
        $a3_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a3');
        $a3_ratakepentingan_rata =  $a3_ratakepentingan_sum / $a3_ratakepentingan_count;

        $a4_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a4');
        $a4_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a4');
        $a4_ratakepentingan_rata =  $a4_ratakepentingan_sum / $a4_ratakepentingan_count;

        //$a5_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a5');
        //$a5_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a5');
        //$a5_ratakepentingan_rata =  $a5_ratakepentingan_sum / $a5_ratakepentingan_count;

        //Tangible ================
        //persepsi
        $t1_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t1');
        $t1_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t1');
        $t1_ratapersepsi_rata =  $t1_ratapersepsi_sum / $t1_ratapersepsi_count;

        $t2_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t2');
        $t2_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t2');
        $t2_ratapersepsi_rata =  $t2_ratapersepsi_sum / $t2_ratapersepsi_count;

        $t3_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t3');
        $t3_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t3');
        $t3_ratapersepsi_rata =  $t3_ratapersepsi_sum / $t3_ratapersepsi_count;

        $t4_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t4');
        $t4_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t4');
        $t4_ratapersepsi_rata =  $t4_ratapersepsi_sum / $t4_ratapersepsi_count;

        $t5_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t5');
        $t5_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t5');
        $t5_ratapersepsi_rata =  $t5_ratapersepsi_sum / $t5_ratapersepsi_count;

        $t6_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t6');
        $t6_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t6');
        $t6_ratapersepsi_rata =  $t6_ratapersepsi_sum / $t6_ratapersepsi_count;

        //kepentingan/harapan
        $t1_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t1');
        $t1_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t1');
        $t1_ratakepentingan_rata =  $t1_ratakepentingan_sum / $t1_ratakepentingan_count;

        $t2_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t2');
        $t2_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t2');
        $t2_ratakepentingan_rata =  $t2_ratakepentingan_sum / $t2_ratakepentingan_count;

        $t3_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t3');
        $t3_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t3');
        $t3_ratakepentingan_rata =  $t3_ratakepentingan_sum / $t3_ratakepentingan_count;

        $t4_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t4');
        $t4_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t4');
        $t4_ratakepentingan_rata =  $t4_ratakepentingan_sum / $t4_ratakepentingan_count;

        $t5_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t5');
        $t5_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t5');
        $t5_ratakepentingan_rata =  $t5_ratakepentingan_sum / $t5_ratakepentingan_count;

        $t6_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t6');
        $t6_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t6');
        $t6_ratakepentingan_rata =  $t6_ratakepentingan_sum / $t6_ratakepentingan_count;

        //Empathy ================
        //persepsi
        $e1_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e1');
        $e1_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e1');
        $e1_ratapersepsi_rata =  $e1_ratapersepsi_sum / $e1_ratapersepsi_count;

        $e2_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e2');
        $e2_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e2');
        $e2_ratapersepsi_rata =  $e2_ratapersepsi_sum / $e2_ratapersepsi_count;

        $e3_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e3');
        $e3_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e3');
        $e3_ratapersepsi_rata =  $e3_ratapersepsi_sum / $e3_ratapersepsi_count;

        $e4_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e4');
        $e4_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e4');
        $e4_ratapersepsi_rata =  $e4_ratapersepsi_sum / $e4_ratapersepsi_count;

        $e5_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e5');
        $e5_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e5');
        $e5_ratapersepsi_rata =  $e5_ratapersepsi_sum / $e5_ratapersepsi_count;

        //$e6_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e6');
        //$e6_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e6');
        //$e6_ratapersepsi_rata =  $e6_ratapersepsi_sum / $e6_ratapersepsi_count;

        //kepentingan/harapan
        $e1_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e1');
        $e1_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e1');
        $e1_ratakepentingan_rata =  $e1_ratakepentingan_sum / $e1_ratakepentingan_count;

        $e2_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e2');
        $e2_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e2');
        $e2_ratakepentingan_rata =  $e2_ratakepentingan_sum / $e2_ratakepentingan_count;

        $e3_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e3');
        $e3_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e3');
        $e3_ratakepentingan_rata =  $e3_ratakepentingan_sum / $e3_ratakepentingan_count;

        $e4_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e4');
        $e4_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e4');
        $e4_ratakepentingan_rata =  $e4_ratakepentingan_sum / $e4_ratakepentingan_count;

        $e5_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e5');
        $e5_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e5');
        $e5_ratakepentingan_rata =  $e5_ratakepentingan_sum / $e5_ratakepentingan_count;

        //$e6_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e6');
        //$e6_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e6');
        //$e6_ratakepentingan_rata =  $e6_ratakepentingan_sum / $e6_ratakepentingan_count;

        //Responsivness ================
        //persepsi
        $rs1_ratapersepsi_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->sum('rs1');
        $rs1_ratapersepsi_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->count('rs1');
        $rs1_ratapersepsi_rata =  $rs1_ratapersepsi_sum / $rs1_ratapersepsi_count;

        $rs2_ratapersepsi_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->sum('rs2');
        $rs2_ratapersepsi_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->count('rs2');
        $rs2_ratapersepsi_rata =  $rs2_ratapersepsi_sum / $rs2_ratapersepsi_count;

        //$rs3_ratapersepsi_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->sum('rs3');
        //$rs3_ratapersepsi_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->count('rs3');
        //$rs3_ratapersepsi_rata =  $rs3_ratapersepsi_sum / $rs3_ratapersepsi_count;

        //$rs4_ratapersepsi_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->sum('rs4');
        //$rs4_ratapersepsi_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->count('rs4');
        //$rs4_ratapersepsi_rata =  $rs4_ratapersepsi_sum / $rs4_ratapersepsi_count;

        //$rs5_ratapersepsi_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->sum('rs5');
        //$rs5_ratapersepsi_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->count('rs5');
        //$rs5_ratapersepsi_rata =  $rs5_ratapersepsi_sum / $rs5_ratapersepsi_count;

        
        //kepentingan/harapan
        $rs1_ratakepentingan_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->sum('rs1');
        $rs1_ratakepentingan_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->count('rs1');
        $rs1_ratakepentingan_rata =  $rs1_ratakepentingan_sum / $rs1_ratakepentingan_count;

        $rs2_ratakepentingan_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->sum('rs2');
        $rs2_ratakepentingan_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->count('rs2');
        $rs2_ratakepentingan_rata =  $rs2_ratakepentingan_sum / $rs2_ratakepentingan_count;

        //$rs3_ratakepentingan_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->sum('rs3');
        //$rs3_ratakepentingan_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->count('rs3');
        //$rs3_ratakepentingan_rata =  $rs3_ratakepentingan_sum / $rs3_ratakepentingan_count;

        //$rs4_ratakepentingan_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->sum('rs4');
        //$rs4_ratakepentingan_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->count('rs4');
        //$rs4_ratakepentingan_rata =  $rs4_ratakepentingan_sum / $rs4_ratakepentingan_count;

        //$rs5_ratakepentingan_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->sum('rs5');
        //$rs5_ratakepentingan_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->count('rs5');
        //$rs5_ratakepentingan_rata =  $rs5_ratakepentingan_sum / $rs5_ratakepentingan_count;

        //Relevansi ================
        //persepsi
        /*$rl1_ratapersepsi_sum = DB::table('tbl_jawaban_relevance')->where('kategori','=','persepsi')->sum('rl1');
        $rl1_ratapersepsi_count = DB::table('tbl_jawaban_relevance')->where('kategori','=','persepsi')->count('rl1');
        $rl1_ratapersepsi_rata =  $rl1_ratapersepsi_sum / $rl1_ratapersepsi_count;

        $rl2_ratapersepsi_sum = DB::table('tbl_jawaban_relevance')->where('kategori','=','persepsi')->sum('rl2');
        $rl2_ratapersepsi_count = DB::table('tbl_jawaban_relevance')->where('kategori','=','persepsi')->count('rl2');
        $rl2_ratapersepsi_rata =  $rl2_ratapersepsi_sum / $rl2_ratapersepsi_count;

        $rl3_ratapersepsi_sum = DB::table('tbl_jawaban_relevance')->where('kategori','=','persepsi')->sum('rl3');
        $rl3_ratapersepsi_count = DB::table('tbl_jawaban_relevance')->where('kategori','=','persepsi')->count('rl3');
        $rl3_ratapersepsi_rata =  $rl3_ratapersepsi_sum / $rl3_ratapersepsi_count;
        */


        
        //kepentingan/harapan
        /*$rl1_ratakepentingan_sum = DB::table('tbl_jawaban_relevance')->where('kategori','=','kepentingan')->sum('rl1');
        $rl1_ratakepentingan_count = DB::table('tbl_jawaban_relevance')->where('kategori','=','kepentingan')->count('rl1');
        $rl1_ratakepentingan_rata =  $rl1_ratakepentingan_sum / $rl1_ratakepentingan_count;

        $rl2_ratakepentingan_sum = DB::table('tbl_jawaban_relevance')->where('kategori','=','kepentingan')->sum('rl2');
        $rl2_ratakepentingan_count = DB::table('tbl_jawaban_relevance')->where('kategori','=','kepentingan')->count('rl2');
        $rl2_ratakepentingan_rata =  $rl2_ratakepentingan_sum / $rl2_ratakepentingan_count;

        $rl3_ratakepentingan_sum = DB::table('tbl_jawaban_relevance')->where('kategori','=','kepentingan')->sum('rl3');
        $rl3_ratakepentingan_count = DB::table('tbl_jawaban_relevance')->where('kategori','=','kepentingan')->count('rl3');
        $rl3_ratakepentingan_rata =  $rl3_ratakepentingan_sum / $rl3_ratakepentingan_count;
*/
        //Applicability ================
        //persepsi
        $rl1_ratapersepsi_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->sum('ap1');
        $rl1_ratapersepsi_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->count('ap1');
        $rl1_ratapersepsi_rata =  $rl1_ratapersepsi_sum / $rl1_ratapersepsi_count;

        $rl2_ratapersepsi_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->sum('ap2');
        $rl2_ratapersepsi_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->count('ap2');
        $rl2_ratapersepsi_rata =  $rl2_ratapersepsi_sum / $rl2_ratapersepsi_count;


        
        //kepentingan/harapan
        $rl1_ratakepentingan_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->sum('ap1');
        $rl1_ratakepentingan_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->count('ap1');
        $rl1_ratakepentingan_rata =  $rl1_ratakepentingan_sum / $rl1_ratakepentingan_count;

        $rl2_ratakepentingan_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->sum('ap2');
        $rl2_ratakepentingan_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->count('ap2');
        $rl2_ratakepentingan_rata =  $rl2_ratakepentingan_sum / $rl2_ratakepentingan_count;



        return view('grafik.index3',[   'r1_ratapersepsi_rata' => $r1_ratapersepsi_rata,
                                        'r2_ratapersepsi_rata' => $r2_ratapersepsi_rata,
                                        'r3_ratapersepsi_rata' => $r3_ratapersepsi_rata,
                                        'r4_ratapersepsi_rata' => $r4_ratapersepsi_rata,
                                        'r5_ratapersepsi_rata' => $r5_ratapersepsi_rata,
                                        'r6_ratapersepsi_rata' => $r6_ratapersepsi_rata,
                                        'r7_ratapersepsi_rata' => $r7_ratapersepsi_rata,

                                        'r1_ratakepentingan_rata' => $r1_ratakepentingan_rata,
                                        'r2_ratakepentingan_rata' => $r2_ratakepentingan_rata,
                                        'r3_ratakepentingan_rata' => $r3_ratakepentingan_rata,
                                        'r4_ratakepentingan_rata' => $r4_ratakepentingan_rata,
                                        'r5_ratakepentingan_rata' => $r5_ratakepentingan_rata,
                                        'r6_ratakepentingan_rata' => $r6_ratakepentingan_rata,
                                        'r7_ratakepentingan_rata' => $r7_ratakepentingan_rata,

                                        'a1_ratapersepsi_rata' => $a1_ratapersepsi_rata,
                                        'a2_ratapersepsi_rata' => $a2_ratapersepsi_rata,
                                        'a3_ratapersepsi_rata' => $a3_ratapersepsi_rata,
                                        'a4_ratapersepsi_rata' => $a4_ratapersepsi_rata,
                                        //'a5_ratapersepsi_rata' => $a5_ratapersepsi_rata,
                                        
                                        'a1_ratakepentingan_rata' => $a1_ratakepentingan_rata,
                                        'a2_ratakepentingan_rata' => $a2_ratakepentingan_rata,
                                        'a3_ratakepentingan_rata' => $a3_ratakepentingan_rata,
                                        'a4_ratakepentingan_rata' => $a4_ratakepentingan_rata,
                                        //'a5_ratakepentingan_rata' => $a5_ratakepentingan_rata,

                                        't1_ratapersepsi_rata' => $t1_ratapersepsi_rata,
                                        't2_ratapersepsi_rata' => $t2_ratapersepsi_rata,
                                        't3_ratapersepsi_rata' => $t3_ratapersepsi_rata,
                                        't4_ratapersepsi_rata' => $t4_ratapersepsi_rata,
                                        't5_ratapersepsi_rata' => $t5_ratapersepsi_rata,
                                        't6_ratapersepsi_rata' => $t6_ratapersepsi_rata,

                                        't1_ratakepentingan_rata' => $t1_ratakepentingan_rata,
                                        't2_ratakepentingan_rata' => $t2_ratakepentingan_rata,
                                        't3_ratakepentingan_rata' => $t3_ratakepentingan_rata,
                                        't4_ratakepentingan_rata' => $t4_ratakepentingan_rata,
                                        't5_ratakepentingan_rata' => $t5_ratakepentingan_rata,
                                        't6_ratakepentingan_rata' => $t6_ratakepentingan_rata,

                                        'e1_ratapersepsi_rata' => $e1_ratapersepsi_rata,
                                        'e2_ratapersepsi_rata' => $e2_ratapersepsi_rata,
                                        'e3_ratapersepsi_rata' => $e3_ratapersepsi_rata,
                                        'e4_ratapersepsi_rata' => $e4_ratapersepsi_rata,
                                        'e5_ratapersepsi_rata' => $e5_ratapersepsi_rata,
                                        //'e6_ratapersepsi_rata' => $e6_ratapersepsi_rata,

                                        'e1_ratakepentingan_rata' => $e1_ratakepentingan_rata,
                                        'e2_ratakepentingan_rata' => $e2_ratakepentingan_rata,
                                        'e3_ratakepentingan_rata' => $e3_ratakepentingan_rata,
                                        'e4_ratakepentingan_rata' => $e4_ratakepentingan_rata,
                                        'e5_ratakepentingan_rata' => $e5_ratakepentingan_rata,
                                        //'e6_ratakepentingan_rata' => $e6_ratakepentingan_rata,

                                        'rs1_ratapersepsi_rata' => $rs1_ratapersepsi_rata,
                                        'rs2_ratapersepsi_rata' => $rs2_ratapersepsi_rata,
                                        //'rs3_ratapersepsi_rata' => $rs3_ratapersepsi_rata,
                                        //'rs4_ratapersepsi_rata' => $rs4_ratapersepsi_rata,
                                        //'rs5_ratapersepsi_rata' => $rs5_ratapersepsi_rata,

                                        'rs1_ratakepentingan_rata' => $rs1_ratakepentingan_rata,
                                        'rs2_ratakepentingan_rata' => $rs2_ratakepentingan_rata,
                                        //'rs3_ratakepentingan_rata' => $rs3_ratakepentingan_rata,
                                        //'rs4_ratakepentingan_rata' => $rs4_ratakepentingan_rata,
                                        //'rs5_ratakepentingan_rata' => $rs5_ratakepentingan_rata,

                                        'rl1_ratapersepsi_rata' => $rl1_ratapersepsi_rata,
                                        'rl2_ratapersepsi_rata' => $rl2_ratapersepsi_rata,
                                        //'rl3_ratapersepsi_rata' => $rl3_ratapersepsi_rata,

                                        'rl1_ratakepentingan_rata' => $rl1_ratakepentingan_rata,
                                        'rl2_ratakepentingan_rata' => $rl2_ratakepentingan_rata,
                                        //'rl3_ratakepentingan_rata' => $rl3_ratakepentingan_rata,
                                    ]);
    }

    public function grafik4()
    {
        //---------------------------------------------- IKP
        //realibility =================
        //persepsi
        $r1_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r1');
        $r1_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r1');
        $r1_ratapersepsi_rata =  $r1_ratapersepsi_sum / $r1_ratapersepsi_count;

        $r2_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r2');
        $r2_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r2');
        $r2_ratapersepsi_rata =  $r2_ratapersepsi_sum / $r2_ratapersepsi_count;

        $r3_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r3');
        $r3_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r3');
        $r3_ratapersepsi_rata =  $r3_ratapersepsi_sum / $r3_ratapersepsi_count;

        $r4_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r4');
        $r4_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r4');
        $r4_ratapersepsi_rata =  $r4_ratapersepsi_sum / $r4_ratapersepsi_count;

        $r5_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r5');
        $r5_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r5');
        $r5_ratapersepsi_rata =  $r5_ratapersepsi_sum / $r5_ratapersepsi_count;

        $r6_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r6');
        $r6_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r6');
        $r6_ratapersepsi_rata =  $r6_ratapersepsi_sum / $r6_ratapersepsi_count;

        $r7_ratapersepsi_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->sum('r7');
        $r7_ratapersepsi_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','persepsi')->count('r7');
        $r7_ratapersepsi_rata =  $r7_ratapersepsi_sum / $r7_ratapersepsi_count;

        $total_rpersepsi = ($r1_ratapersepsi_rata+$r2_ratapersepsi_rata+$r3_ratapersepsi_rata+$r4_ratapersepsi_rata+$r5_ratapersepsi_rata+$r6_ratapersepsi_rata+$r7_ratapersepsi_rata)/7;

        //kepentingan/harapan
        $r1_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r1');
        $r1_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r1');
        $r1_ratakepentingan_rata =  $r1_ratakepentingan_sum / $r1_ratakepentingan_count;

        $r2_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r2');
        $r2_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r2');
        $r2_ratakepentingan_rata =  $r2_ratakepentingan_sum / $r2_ratakepentingan_count;

        $r3_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r3');
        $r3_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r3');
        $r3_ratakepentingan_rata =  $r3_ratakepentingan_sum / $r3_ratakepentingan_count;

        $r4_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r4');
        $r4_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r4');
        $r4_ratakepentingan_rata =  $r4_ratakepentingan_sum / $r4_ratakepentingan_count;

        $r5_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r5');
        $r5_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r5');
        $r5_ratakepentingan_rata =  $r5_ratakepentingan_sum / $r5_ratakepentingan_count;

        $r6_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r6');
        $r6_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r6');
        $r6_ratakepentingan_rata =  $r6_ratakepentingan_sum / $r6_ratakepentingan_count;

        $r7_ratakepentingan_sum = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->sum('r7');
        $r7_ratakepentingan_count = DB::table('tbl_jawaban_realibility')->where('kategori','=','kepentingan')->count('r7');
        $r7_ratakepentingan_rata =  $r7_ratakepentingan_sum / $r7_ratakepentingan_count;

        $total_rkepentingan = ($r1_ratakepentingan_rata+$r2_ratakepentingan_rata+$r3_ratakepentingan_rata+$r4_ratakepentingan_rata+$r5_ratakepentingan_rata+$r6_ratakepentingan_rata+$r7_ratakepentingan_rata)/7;
        $total_rgap = $total_rpersepsi-$total_rkepentingan;

        //assurance ================
        //persepsi
        $a1_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a1');
        $a1_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a1');
        $a1_ratapersepsi_rata =  $a1_ratapersepsi_sum / $a1_ratapersepsi_count;

        $a2_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a2');
        $a2_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a2');
        $a2_ratapersepsi_rata =  $a2_ratapersepsi_sum / $a2_ratapersepsi_count;

        $a3_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a3');
        $a3_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a3');
        $a3_ratapersepsi_rata =  $a3_ratapersepsi_sum / $a3_ratapersepsi_count;

        $a4_ratapersepsi_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->sum('a4');
        $a4_ratapersepsi_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','persepsi')->count('a4');
        $a4_ratapersepsi_rata =  $a4_ratapersepsi_sum / $a4_ratapersepsi_count;

        
        $total_apersepsi = ($a1_ratapersepsi_rata+$a2_ratapersepsi_rata+$a3_ratapersepsi_rata+$a4_ratapersepsi_rata)/4;


        //kepentingan/harapan
        $a1_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a1');
        $a1_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a1');
        $a1_ratakepentingan_rata =  $a1_ratakepentingan_sum / $a1_ratakepentingan_count;

        $a2_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a2');
        $a2_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a2');
        $a2_ratakepentingan_rata =  $a2_ratakepentingan_sum / $a2_ratakepentingan_count;

        $a3_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a3');
        $a3_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a3');
        $a3_ratakepentingan_rata =  $a3_ratakepentingan_sum / $a3_ratakepentingan_count;

        $a4_ratakepentingan_sum = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->sum('a4');
        $a4_ratakepentingan_count = DB::table('tbl_jawaban_assurance')->where('kategori','=','kepentingan')->count('a4');
        $a4_ratakepentingan_rata =  $a4_ratakepentingan_sum / $a4_ratakepentingan_count;

        

        $total_akepentingan = ($a1_ratakepentingan_rata+$a2_ratakepentingan_rata+$a3_ratakepentingan_rata+$a4_ratakepentingan_rata)/4;
        $total_agap = $total_apersepsi-$total_akepentingan;

        //Tangible ================
        //persepsi
        $t1_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t1');
        $t1_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t1');
        $t1_ratapersepsi_rata =  $t1_ratapersepsi_sum / $t1_ratapersepsi_count;

        $t2_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t2');
        $t2_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t2');
        $t2_ratapersepsi_rata =  $t2_ratapersepsi_sum / $t2_ratapersepsi_count;

        $t3_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t3');
        $t3_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t3');
        $t3_ratapersepsi_rata =  $t3_ratapersepsi_sum / $t3_ratapersepsi_count;

        $t4_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t4');
        $t4_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t4');
        $t4_ratapersepsi_rata =  $t4_ratapersepsi_sum / $t4_ratapersepsi_count;

        $t5_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t5');
        $t5_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t5');
        $t5_ratapersepsi_rata =  $t5_ratapersepsi_sum / $t5_ratapersepsi_count;

        $t6_ratapersepsi_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->sum('t6');
        $t6_ratapersepsi_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','persepsi')->count('t6');
        $t6_ratapersepsi_rata =  $t6_ratapersepsi_sum / $t6_ratapersepsi_count;

        $total_tpersepsi = ($t1_ratapersepsi_rata+$t2_ratapersepsi_rata+$t3_ratapersepsi_rata+$t4_ratapersepsi_rata+$t5_ratapersepsi_rata+$t6_ratapersepsi_rata)/6;


        //kepentingan/harapan
        $t1_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t1');
        $t1_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t1');
        $t1_ratakepentingan_rata =  $t1_ratakepentingan_sum / $t1_ratakepentingan_count;

        $t2_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t2');
        $t2_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t2');
        $t2_ratakepentingan_rata =  $t2_ratakepentingan_sum / $t2_ratakepentingan_count;

        $t3_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t3');
        $t3_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t3');
        $t3_ratakepentingan_rata =  $t3_ratakepentingan_sum / $t3_ratakepentingan_count;

        $t4_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t4');
        $t4_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t4');
        $t4_ratakepentingan_rata =  $t4_ratakepentingan_sum / $t4_ratakepentingan_count;

        $t5_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t5');
        $t5_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t5');
        $t5_ratakepentingan_rata =  $t5_ratakepentingan_sum / $t5_ratakepentingan_count;

        $t6_ratakepentingan_sum = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->sum('t6');
        $t6_ratakepentingan_count = DB::table('tbl_jawaban_tangible')->where('kategori','=','kepentingan')->count('t6');
        $t6_ratakepentingan_rata =  $t6_ratakepentingan_sum / $t6_ratakepentingan_count;

        $total_tkepentingan = ($t1_ratakepentingan_rata+$t2_ratakepentingan_rata+$t3_ratakepentingan_rata+$t4_ratakepentingan_rata+$t5_ratakepentingan_rata+$t6_ratakepentingan_rata)/6;
        $total_tgap = $total_tpersepsi-$total_tkepentingan;

        //Empathy ================
        //persepsi
        $e1_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e1');
        $e1_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e1');
        $e1_ratapersepsi_rata =  $e1_ratapersepsi_sum / $e1_ratapersepsi_count;

        $e2_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e2');
        $e2_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e2');
        $e2_ratapersepsi_rata =  $e2_ratapersepsi_sum / $e2_ratapersepsi_count;

        $e3_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e3');
        $e3_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e3');
        $e3_ratapersepsi_rata =  $e3_ratapersepsi_sum / $e3_ratapersepsi_count;

        $e4_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e4');
        $e4_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e4');
        $e4_ratapersepsi_rata =  $e4_ratapersepsi_sum / $e4_ratapersepsi_count;

        $e5_ratapersepsi_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->sum('e5');
        $e5_ratapersepsi_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','persepsi')->count('e5');
        $e5_ratapersepsi_rata =  $e5_ratapersepsi_sum / $e5_ratapersepsi_count;

        
        $total_epersepsi = ($e1_ratapersepsi_rata+$e2_ratapersepsi_rata+$e3_ratapersepsi_rata+$e4_ratapersepsi_rata+$e5_ratapersepsi_rata)/5;
        

        //kepentingan/harapan
        $e1_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e1');
        $e1_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e1');
        $e1_ratakepentingan_rata =  $e1_ratakepentingan_sum / $e1_ratakepentingan_count;

        $e2_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e2');
        $e2_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e2');
        $e2_ratakepentingan_rata =  $e2_ratakepentingan_sum / $e2_ratakepentingan_count;

        $e3_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e3');
        $e3_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e3');
        $e3_ratakepentingan_rata =  $e3_ratakepentingan_sum / $e3_ratakepentingan_count;

        $e4_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e4');
        $e4_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e4');
        $e4_ratakepentingan_rata =  $e4_ratakepentingan_sum / $e4_ratakepentingan_count;

        $e5_ratakepentingan_sum = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->sum('e5');
        $e5_ratakepentingan_count = DB::table('tbl_jawaban_empathy')->where('kategori','=','kepentingan')->count('e5');
        $e5_ratakepentingan_rata =  $e5_ratakepentingan_sum / $e5_ratakepentingan_count;

        $total_ekepentingan = ($e1_ratakepentingan_rata+$e2_ratakepentingan_rata+$e3_ratakepentingan_rata+$e4_ratakepentingan_rata+$e5_ratakepentingan_rata)/5;
        
        $total_egap = $total_epersepsi-$total_ekepentingan;


        //Responsivness ================
        //persepsi
        $rs1_ratapersepsi_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->sum('rs1');
        $rs1_ratapersepsi_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->count('rs1');
        $rs1_ratapersepsi_rata =  $rs1_ratapersepsi_sum / $rs1_ratapersepsi_count;

        $rs2_ratapersepsi_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->sum('rs2');
        $rs2_ratapersepsi_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','persepsi')->count('rs2');
        $rs2_ratapersepsi_rata =  $rs2_ratapersepsi_sum / $rs2_ratapersepsi_count;

        

        $total_rspersepsi = ($rs1_ratapersepsi_rata+$rs2_ratapersepsi_rata)/2;
        
        //kepentingan/harapan
        $rs1_ratakepentingan_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->sum('rs1');
        $rs1_ratakepentingan_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->count('rs1');
        $rs1_ratakepentingan_rata =  $rs1_ratakepentingan_sum / $rs1_ratakepentingan_count;

        $rs2_ratakepentingan_sum = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->sum('rs2');
        $rs2_ratakepentingan_count = DB::table('tbl_jawaban_responsiveness')->where('kategori','=','kepentingan')->count('rs2');
        $rs2_ratakepentingan_rata =  $rs2_ratakepentingan_sum / $rs2_ratakepentingan_count;

        

        $total_rskepentingan = ($rs1_ratakepentingan_rata+$rs2_ratakepentingan_rata)/2;
        $total_rsgap = $total_rspersepsi-$total_rskepentingan;

        //applicability ================
        //persepsi
        $rl1_ratapersepsi_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->sum('ap1');
        $rl1_ratapersepsi_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->count('ap1');
        $rl1_ratapersepsi_rata =  $rl1_ratapersepsi_sum / $rl1_ratapersepsi_count;

        $rl2_ratapersepsi_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->sum('ap2');
        $rl2_ratapersepsi_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','persepsi')->count('ap2');
        $rl2_ratapersepsi_rata =  $rl2_ratapersepsi_sum / $rl2_ratapersepsi_count;


        $total_rlpersepsi = ($rl1_ratapersepsi_rata+$rl2_ratapersepsi_rata)/2;
        

        
        //kepentingan/harapan
        $rl1_ratakepentingan_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->sum('ap1');
        $rl1_ratakepentingan_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->count('ap1');
        $rl1_ratakepentingan_rata =  $rl1_ratakepentingan_sum / $rl1_ratakepentingan_count;

        $rl2_ratakepentingan_sum = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->sum('ap2');
        $rl2_ratakepentingan_count = DB::table('tbl_jawaban_applicability')->where('kategori','=','kepentingan')->count('ap2');
        $rl2_ratakepentingan_rata =  $rl2_ratakepentingan_sum / $rl2_ratakepentingan_count;


        $total_rlkepentingan = ($rl1_ratakepentingan_rata+$rl2_ratakepentingan_rata)/2;
        $total_rlgap = $total_rlpersepsi-$total_rlkepentingan;


        return view('grafik.index4',[   'total_rpersepsi' => $total_rpersepsi,
                                        'total_rkepentingan' => $total_rkepentingan,
                                        'total_rgap' => $total_rgap,

                                        'total_apersepsi' => $total_apersepsi,
                                        'total_akepentingan' => $total_akepentingan,
                                        'total_agap' => $total_agap,

                                        
                                        'total_tpersepsi' => $total_tpersepsi,
                                        'total_tkepentingan' => $total_tkepentingan,
                                        'total_tgap' => $total_tgap,

                                        
                                        'total_epersepsi' => $total_epersepsi,
                                        'total_ekepentingan' => $total_ekepentingan,
                                        'total_egap' => $total_egap,

                                        
                                        'total_rspersepsi' => $total_rspersepsi,
                                        'total_rskepentingan' => $total_rskepentingan,
                                        'total_rsgap' => $total_rsgap,

                                        
                                        'total_rlpersepsi' => $total_rlpersepsi,
                                        'total_rlkepentingan' => $total_rlkepentingan,
                                        'total_rlgap' => $total_rlgap
                                    ]);
    }





}
