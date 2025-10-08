<?php
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
use App\Jawaban_applicability;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Charts;
use App\Exports\RespondenExport;

class RespondenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function export(){
        $today = date('Y-m-d');
        return Excel::download(new RespondenExport, $today.'_export.xlsx');
        
        
     } 

    public function chart()
    {
        $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))->get();
        $chart = Charts::database($users, 'bar', 'highcharts')
         ->title("Monthly new Register Users")
         ->elementLabel("Total Users")
         ->dimensions(1000, 500)
         ->responsive(false)
         ->groupByMonth(date('Y'), true);
        
        return view('admin.chart',compact('chart'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Responden::orderBy('id_responden','desc')->get();
        return view('admin.responden.index',['database' => $data]);
    }

    public function showdetailresponden($id_responden)
    {
        $data = Responden::find($id_responden);
        //kepentingan
        $jawaban_realibility1 = Jawaban_realibility::where('id_responden','=',$id_responden)->where('kategori','=','kepentingan')->get();
        $jawaban_empathy1 = Jawaban_empathy::where('id_responden','=',$id_responden)->where('kategori','=','kepentingan')->get();
        $jawaban_responsiveness1 = Jawaban_responsiveness::where('id_responden','=',$id_responden)->where('kategori','=','kepentingan')->get();
        $jawaban_relevance1 = Jawaban_applicability::where('id_responden','=',$id_responden)->where('kategori','=','kepentingan')->get();
        $jawaban_assurance1 = Jawaban_assurance::where('id_responden','=',$id_responden)->where('kategori','=','kepentingan')->get();
        $jawaban_tangible1 = Jawaban_tangible::where('id_responden','=',$id_responden)->where('kategori','=','kepentingan')->get();
        //persepsi
        $jawaban_realibility2 = Jawaban_realibility::where('id_responden','=',$id_responden)->where('kategori','=','persepsi')->get();
        $jawaban_empathy2 = Jawaban_empathy::where('id_responden','=',$id_responden)->where('kategori','=','persepsi')->get();
        $jawaban_responsiveness2 = Jawaban_responsiveness::where('id_responden','=',$id_responden)->where('kategori','=','persepsi')->get();
        $jawaban_relevance2 = Jawaban_applicability::where('id_responden','=',$id_responden)->where('kategori','=','persepsi')->get();
        $jawaban_assurance2 = Jawaban_assurance::where('id_responden','=',$id_responden)->where('kategori','=','persepsi')->get();
        $jawaban_tangible2 = Jawaban_tangible::where('id_responden','=',$id_responden)->where('kategori','=','persepsi')->get();
        
        
        $jawaban_lp = Jawaban_lp::where('id_responden','=',$id_responden)->get();
        $jawaban_kp = Jawaban_kp::where('id_responden','=',$id_responden)->get();
        $jawaban_kritik_saran = Jawaban_kritik_saran::where('id_responden','=',$id_responden)->get();
        
        return view('admin.responden.detail',
            [
                'data' => $data,
                'jawaban_realibility1' => $jawaban_realibility1,
                'jawaban_empathy1' => $jawaban_empathy1,
                'jawaban_responsiveness1' => $jawaban_responsiveness1,
                'jawaban_relevance1' => $jawaban_relevance1,
                'jawaban_assurance1' => $jawaban_assurance1,
                'jawaban_tangible1' => $jawaban_tangible1,

                'jawaban_realibility2' => $jawaban_realibility2,
                'jawaban_empathy2' => $jawaban_empathy2,
                'jawaban_responsiveness2' => $jawaban_responsiveness2,
                'jawaban_relevance2' => $jawaban_relevance2,
                'jawaban_assurance2' => $jawaban_assurance2,
                'jawaban_tangible2' => $jawaban_tangible2,


                'jawaban_lp' => $jawaban_lp,
                'jawaban_kp' => $jawaban_kp,
                'jawaban_kritik_saran' => $jawaban_kritik_saran
            
            ]);
    }

    public function destroy($id)
    {
        $tabel1 = Responden::find($id);
        $tabel1->delete();

        $tabel2count = Jawaban_realibility::where('id_responden','=',$id)->count();
        if($tabel2count == null){}else{
            $tabel2 = Jawaban_realibility::where('id_responden','=',$id);
            $tabel2->delete();
        }
        
        $tabel3count = Jawaban_empathy::where('id_responden','=',$id)->count();
        if($tabel3count == null){}else{
        $tabel3 = Jawaban_empathy::where('id_responden','=',$id);
        $tabel3->delete();
        }

        $tabel4count = Jawaban_responsiveness::where('id_responden','=',$id)->count();
        if($tabel4count == null){}else{
        $tabel4 = Jawaban_responsiveness::where('id_responden','=',$id);
        $tabel4->delete();
        }

        $tabel5count = Jawaban_applicability::where('id_responden','=',$id)->count();
        if($tabel5count == null){}else{
        $tabel5 = Jawaban_applicability::where('id_responden','=',$id);
        $tabel5->delete();
        }

        $tabel6count = Jawaban_assurance::where('id_responden','=',$id)->count();
        if($tabel6count == null){}else{
        $tabel6 = Jawaban_assurance::where('id_responden','=',$id);
        $tabel6->delete();
        }

        $tabel7count = Jawaban_tangible::where('id_responden','=',$id)->count();
        if($tabel7count == null){}else{
        $tabel7 = Jawaban_tangible::where('id_responden','=',$id);
        $tabel7->delete();
        }

        $tabel8count = Jawaban_lp::where('id_responden','=',$id)->count();
        if($tabel8count == null){}else{
        $tabel8 = Jawaban_lp::where('id_responden','=',$id);
        $tabel8->delete();
        }

        $tabel9count = Jawaban_kp::where('id_responden','=',$id)->count();
        if($tabel9count == null){}else{
        $tabel9 = Jawaban_kp::where('id_responden','=',$id);
        $tabel9->delete();
        }

        $tabel10count = Jawaban_kritik_saran::where('id_responden','=',$id)->count();
        if($tabel10count == null){}else{
        $tabel10 = Jawaban_kritik_saran::where('id_responden','=',$id);
        $tabel10->delete();
        }


        return redirect('/dataresponden')->with('success','Data berhasil dihapus');
    }

    

}
