<?php

namespace App\Http\Controllers\responden;

use App\Http\Controllers\Controller;
use App\Models\Responden;
use App\Models\Provinsi;
use App\Models\Bisnis;
use App\Models\Jawaban_realibility;
use App\Models\Jawaban_empathy;
use App\Models\Jawaban_responsiveness;
use App\Models\Jawaban_relevance;
use App\Models\Jawaban_assurance;
use App\Models\Jawaban_tangible;
use App\Models\Jawaban_lp;
use App\Models\Jawaban_kp;
use App\Models\Jawaban_kritik_saran;
use App\Models\Jawaban_applicability;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class RespondenController extends Controller
{
   
    public function ip_details()
    {
        //$ip = '103.239.147.187'; //For static IP address get
        $ip = request()->ip(); //Dynamic IP address get
        $data = \Location::get($ip);                
        return dd($data);
    }
    
    public function index()
    {
        //$data = Bisnis::all();
        $data = Provinsi::all();
//        return view('responden.bisnis',['data' => $data]);
        return view('responden.responden',['data' => $data]);
        
    }

    public function index_1()
    {
        $data = Provinsi::all();
        return view('responden.responden',['data' => $data]);
    }

    public function simpanresponden(Request $request)
    {
        

        $tabel = new Responden;
        $tabel->id_bisnis = $request->id_bisnis;
        $tabel->email = $request->email;
        $tabel->whatsapp = $request->whatsapp;
        $tabel->usia = $request->usia;
        $tabel->pekerjaan = $request->pekerjaan;
        $tabel->pekerjaan_lain = $request->lain;
        $tabel->jk = $request->jk;
        $tabel->domisili = $request->domisili;
        
          
        $tabel->save();
        

       
        return redirect('/pertanyaan1/'.$request->email);
    }

    public function pertanyaan1($email)
    {
        $data = Responden::where('email', $email)->first();
        
        return view('responden.pertanyaan1',['data' => $data]);
    }


    public function simpanpertanyaan1(Request $request)
    {
        $data = Responden::where('id_responden', $request->id_responden)->first();

        $realibility = new Jawaban_realibility;
        $realibility->id_responden = $request->id_responden;
        $realibility->r1 = $request->r1;
        $realibility->r2 = $request->r2;
        $realibility->r3 = $request->r3;
        $realibility->r4 = $request->r4;
        $realibility->r5 = $request->r5;
        $realibility->r6 = $request->r6;
        $realibility->r7 = $request->r7;
        $realibility->kategori = 'kepentingan';
        $realibility->save();

        $assurance = new Jawaban_assurance;
        $assurance->id_responden = $request->id_responden;
        $assurance->a1 = $request->a1;
        $assurance->a2 = $request->a2;
        $assurance->a3 = $request->a3;
        $assurance->a4 = $request->a4;
        $assurance->kategori = 'kepentingan';
        $assurance->save();

        $empathy = new Jawaban_empathy;
        $empathy->id_responden = $request->id_responden;
        $empathy->e1 = $request->e1;
        $empathy->e2 = $request->e2;
        $empathy->e3 = $request->e3;
        $empathy->e4 = $request->e4;
        $empathy->e5 = $request->e5;
        $empathy->kategori = 'kepentingan';
        $empathy->save();

        $relevance = new Jawaban_applicability;
        $relevance->id_responden = $request->id_responden;
        $relevance->ap1 = $request->ap1;
        $relevance->ap2 = $request->ap2;
        $relevance->kategori = 'kepentingan';
        $relevance->save();

        
        $responsiveness = new Jawaban_responsiveness;
        $responsiveness->id_responden = $request->id_responden;
        $responsiveness->rs1 = $request->rs1;
        $responsiveness->rs2 = $request->rs2;
        $responsiveness->kategori = 'kepentingan';
        $responsiveness->save();

        $tangible = new Jawaban_tangible;
        $tangible->id_responden = $request->id_responden;
        $tangible->t1 = $request->t1;
        $tangible->t2 = $request->t2;
        $tangible->t3 = $request->t3;
        $tangible->t4 = $request->t4;
        $tangible->t5 = $request->t5;
        $tangible->t6 = $request->t6;
        $tangible->kategori = 'kepentingan';
        $tangible->save();

        
      

      return redirect('pertanyaan2/'.$data->email);
    }

    public function pertanyaan2($email)
    {
        $data = Responden::where('email', $email)->first();
        
        return view('responden.pertanyaan2',['data' => $data]);
    }

    public function simpanpertanyaan2(Request $request)
    {
        $data = Responden::where('id_responden', $request->id_responden)->first();

        $realibility = new Jawaban_realibility;
        $realibility->id_responden = $request->id_responden;
        $realibility->r1 = $request->r1;
        $realibility->r2 = $request->r2;
        $realibility->r3 = $request->r3;
        $realibility->r4 = $request->r4;
        $realibility->r5 = $request->r5;
        $realibility->r6 = $request->r6;
        $realibility->r7 = $request->r7;
        $realibility->kategori = 'persepsi';
        $realibility->save();

        $assurance = new Jawaban_assurance;
        $assurance->id_responden = $request->id_responden;
        $assurance->a1 = $request->a1;
        $assurance->a2 = $request->a2;
        $assurance->a3 = $request->a3;
        $assurance->a4 = $request->a4;
        $assurance->kategori = 'persepsi';
        $assurance->save();

        $empathy = new Jawaban_empathy;
        $empathy->id_responden = $request->id_responden;
        $empathy->e1 = $request->e1;
        $empathy->e2 = $request->e2;
        $empathy->e3 = $request->e3;
        $empathy->e4 = $request->e4;
        $empathy->e5 = $request->e5;
        $empathy->kategori = 'persepsi';
        $empathy->save();

        $relevance = new Jawaban_applicability;
        $relevance->id_responden = $request->id_responden;
        $relevance->ap1 = $request->ap1;
        $relevance->ap2 = $request->ap2;
        $relevance->kategori = 'persepsi';
        $relevance->save();

        
        $responsiveness = new Jawaban_responsiveness;
        $responsiveness->id_responden = $request->id_responden;
        $responsiveness->rs1 = $request->rs1;
        $responsiveness->rs2 = $request->rs2;
        $responsiveness->kategori = 'persepsi';
        $responsiveness->save();

        $tangible = new Jawaban_tangible;
        $tangible->id_responden = $request->id_responden;
        $tangible->t1 = $request->t1;
        $tangible->t2 = $request->t2;
        $tangible->t3 = $request->t3;
        $tangible->t4 = $request->t4;
        $tangible->t5 = $request->t5;
        $tangible->t6 = $request->t6;
        $tangible->kategori = 'persepsi';
        $tangible->save();

        
      

      return redirect('pertanyaan3/'.$data->email);
    }

    

    public function pertanyaan3($email)
    {
        $data = Responden::where('email', $email)->first();
        
        return view('responden.pertanyaan3',['data' => $data]);
    }
    

    public function simpanpertanyaan3(Request $request)
    {
        $data = Responden::where('id_responden', $request->id_responden)->first();

        $realibility = new Jawaban_kp;
        $realibility->id_responden = $request->id_responden;
        $realibility->k1 = $request->k1;
        $realibility->k2 = $request->k2;
        $realibility->k3 = $request->k3;
        $realibility->save();

        return redirect('pertanyaan4/'.$data->email);
    }

    public function pertanyaan4($email)
    {
        $data = Responden::where('email', $email)->first();
        
        return view('responden.pertanyaan4',['data' => $data]);
    }
    

    public function simpanpertanyaan4(Request $request)
    {
        $data = Responden::where('id_responden', $request->id_responden)->first();

        $realibility = new Jawaban_lp;
        $realibility->id_responden = $request->id_responden;
        $realibility->l1 = $request->l1;
        $realibility->l2 = $request->l2;
        $realibility->l3 = $request->l3;
        $realibility->save();

        return redirect('pertanyaan5/'.$data->email);
    }
    

    public function pertanyaan5($email)
    {
        $data = Responden::where('email', $email)->first();
        
        return view('responden.pertanyaan5',['data' => $data]);
    }
    
    public function simpanpertanyaan5(Request $request)
    {
        $data = Responden::where('id_responden', $request->id_responden)->first();

        $realibility = new Jawaban_kritik_saran;
        $realibility->id_responden = $request->id_responden;
        $realibility->no1 = $request->kritik_saran;
        $realibility->no2 = $request->tema_judul;
        $realibility->no3_online = $request->online;
        $realibility->no3_offlone = $request->offline;
        $realibility->no3_streaming = $request->streaming;
        $realibility->no3_elearning = $request->elearning;

        $realibility->save();

        return redirect('selesai');
    }

    public function selesai()
    {
        
        return view('responden.selesai');
    }








}
