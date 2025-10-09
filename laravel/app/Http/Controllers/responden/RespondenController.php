<?php

namespace App\Http\Controllers\responden;

use App\Http\Controllers\Controller;
use App\Models\Responden;
use App\Models\Provinsi;
use App\Models\Bisnis;
use App\Models\Jawaban;
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

    private function getJawabanData($id_responden, $dimensi_type, $kategori = null)
    {
        $query = Jawaban::where('id_responden', $id_responden)
                       ->where('dimensi_type', $dimensi_type);
        
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        
        return $query;
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

        // Save realibility data
        $realibility = new Jawaban;
        $realibility->id_responden = $request->id_responden;
        $realibility->dimensi_type = 'realibility';
        $realibility->kategori = 'kepentingan';
        $realibility->nilai = [
            'r1' => $request->r1,
            'r2' => $request->r2,
            'r3' => $request->r3,
            'r4' => $request->r4,
            'r5' => $request->r5,
            'r6' => $request->r6,
            'r7' => $request->r7
        ];
        $realibility->save();

        // Save assurance data
        $assurance = new Jawaban;
        $assurance->id_responden = $request->id_responden;
        $assurance->dimensi_type = 'assurance';
        $assurance->kategori = 'kepentingan';
        $assurance->nilai = [
            'a1' => $request->a1,
            'a2' => $request->a2,
            'a3' => $request->a3,
            'a4' => $request->a4
        ];
        $assurance->save();

        // Save empathy data
        $empathy = new Jawaban;
        $empathy->id_responden = $request->id_responden;
        $empathy->dimensi_type = 'empathy';
        $empathy->kategori = 'kepentingan';
        $empathy->nilai = [
            'e1' => $request->e1,
            'e2' => $request->e2,
            'e3' => $request->e3,
            'e4' => $request->e4,
            'e5' => $request->e5
        ];
        $empathy->save();

        // Save relevance data
        $relevance = new Jawaban;
        $relevance->id_responden = $request->id_responden;
        $relevance->dimensi_type = 'applicability';
        $relevance->kategori = 'kepentingan';
        $relevance->nilai = [
            'ap1' => $request->ap1,
            'ap2' => $request->ap2
        ];
        $relevance->save();

        // Save responsiveness data
        $responsiveness = new Jawaban;
        $responsiveness->id_responden = $request->id_responden;
        $responsiveness->dimensi_type = 'responsiveness';
        $responsiveness->kategori = 'kepentingan';
        $responsiveness->nilai = [
            'rs1' => $request->rs1,
            'rs2' => $request->rs2
        ];
        $responsiveness->save();

        // Save tangible data
        $tangible = new Jawaban;
        $tangible->id_responden = $request->id_responden;
        $tangible->dimensi_type = 'tangible';
        $tangible->kategori = 'kepentingan';
        $tangible->nilai = [
            't1' => $request->t1,
            't2' => $request->t2,
            't3' => $request->t3,
            't4' => $request->t4,
            't5' => $request->t5,
            't6' => $request->t6
        ];
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

        // Save realibility data
        $realibility = new Jawaban;
        $realibility->id_responden = $request->id_responden;
        $realibility->dimensi_type = 'realibility';
        $realibility->kategori = 'persepsi';
        $realibility->nilai = [
            'r1' => $request->r1,
            'r2' => $request->r2,
            'r3' => $request->r3,
            'r4' => $request->r4,
            'r5' => $request->r5,
            'r6' => $request->r6,
            'r7' => $request->r7
        ];
        $realibility->save();

        // Save assurance data
        $assurance = new Jawaban;
        $assurance->id_responden = $request->id_responden;
        $assurance->dimensi_type = 'assurance';
        $assurance->kategori = 'persepsi';
        $assurance->nilai = [
            'a1' => $request->a1,
            'a2' => $request->a2,
            'a3' => $request->a3,
            'a4' => $request->a4
        ];
        $assurance->save();

        // Save empathy data
        $empathy = new Jawaban;
        $empathy->id_responden = $request->id_responden;
        $empathy->dimensi_type = 'empathy';
        $empathy->kategori = 'persepsi';
        $empathy->nilai = [
            'e1' => $request->e1,
            'e2' => $request->e2,
            'e3' => $request->e3,
            'e4' => $request->e4,
            'e5' => $request->e5
        ];
        $empathy->save();

        // Save relevance data
        $relevance = new Jawaban;
        $relevance->id_responden = $request->id_responden;
        $relevance->dimensi_type = 'applicability';
        $relevance->kategori = 'persepsi';
        $relevance->nilai = [
            'ap1' => $request->ap1,
            'ap2' => $request->ap2
        ];
        $relevance->save();

        // Save responsiveness data
        $responsiveness = new Jawaban;
        $responsiveness->id_responden = $request->id_responden;
        $responsiveness->dimensi_type = 'responsiveness';
        $responsiveness->kategori = 'persepsi';
        $responsiveness->nilai = [
            'rs1' => $request->rs1,
            'rs2' => $request->rs2
        ];
        $responsiveness->save();

        // Save tangible data
        $tangible = new Jawaban;
        $tangible->id_responden = $request->id_responden;
        $tangible->dimensi_type = 'tangible';
        $tangible->kategori = 'persepsi';
        $tangible->nilai = [
            't1' => $request->t1,
            't2' => $request->t2,
            't3' => $request->t3,
            't4' => $request->t4,
            't5' => $request->t5,
            't6' => $request->t6
        ];
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

        $kp = new Jawaban;
        $kp->id_responden = $request->id_responden;
        $kp->dimensi_type = 'kp';
        $kp->nilai = [
            'k1' => $request->k1,
            'k2' => $request->k2,
            'k3' => $request->k3
        ];
        $kp->save();

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

        $lp = new Jawaban;
        $lp->id_responden = $request->id_responden;
        $lp->dimensi_type = 'lp';
        $lp->nilai = [
            'l1' => $request->l1,
            'l2' => $request->l2,
            'l3' => $request->l3
        ];
        $lp->save();

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

        $kritikSaran = new Jawaban;
        $kritikSaran->id_responden = $request->id_responden;
        $kritikSaran->dimensi_type = 'kritik_saran';
        $kritikSaran->nilai = [
            'no1' => $request->kritik_saran,
            'no2' => $request->tema_judul,
            'no3_online' => $request->online,
            'no3_offline' => $request->offline,
            'no3_streaming' => $request->streaming,
            'no3_elearning' => $request->elearning
        ];
        $kritikSaran->save();

        return redirect('selesai');
    }

    public function selesai()
    {
        
        return view('responden.selesai');
    }








}
