<?php
namespace App\Http\Controllers\admin;

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
use Charts;
use App\Models\Exports\RespondenExport;

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

    private function getJawabanData($id_responden, $dimensi_type, $kategori = null)
    {
        $query = Jawaban::where('id_responden', $id_responden)
                       ->where('dimensi_type', $dimensi_type);
        
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        
        return $query;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Responden::with('bisnis:id_bisnis,nama_bisnis')->orderBy('id_responden','desc')->get();
        return view('admin.responden.index',['database' => $data]);
    }

    public function showdetailresponden($id_responden)
    {
        $data = Responden::with('bisnis')->find($id_responden);
        
        if (!$data) {
            return redirect('/dataresponden')->with('error', 'Data responden tidak ditemukan');
        }
        
        //kepentingan
        $jawaban_realibility1 = $this->getJawabanData($id_responden, 'realibility', 'kepentingan')->get();
        $jawaban_empathy1 = $this->getJawabanData($id_responden, 'empathy', 'kepentingan')->get();
        $jawaban_responsiveness1 = $this->getJawabanData($id_responden, 'responsiveness', 'kepentingan')->get();
        $jawaban_relevance1 = $this->getJawabanData($id_responden, 'applicability', 'kepentingan')->get();
        $jawaban_assurance1 = $this->getJawabanData($id_responden, 'assurance', 'kepentingan')->get();
        $jawaban_tangible1 = $this->getJawabanData($id_responden, 'tangible', 'kepentingan')->get();
        //persepsi
        $jawaban_realibility2 = $this->getJawabanData($id_responden, 'realibility', 'persepsi')->get();
        $jawaban_empathy2 = $this->getJawabanData($id_responden, 'empathy', 'persepsi')->get();
        $jawaban_responsiveness2 = $this->getJawabanData($id_responden, 'responsiveness', 'persepsi')->get();
        $jawaban_relevance2 = $this->getJawabanData($id_responden, 'applicability', 'persepsi')->get();
        $jawaban_assurance2 = $this->getJawabanData($id_responden, 'assurance', 'persepsi')->get();
        $jawaban_tangible2 = $this->getJawabanData($id_responden, 'tangible', 'persepsi')->get();
        
        
        $jawaban_lp = $this->getJawabanData($id_responden, 'lp')->get();
        $jawaban_kp = $this->getJawabanData($id_responden, 'kp')->get();
        $jawaban_kritik_saran = $this->getJawabanData($id_responden, 'kritik_saran')->get();
        
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
        // Delete all jawaban data for this responden first (child records)
        Jawaban::where('id_responden', $id)->delete();

        // Then delete the responden data (parent record)
        $tabel1 = Responden::find($id);
        $tabel1->delete();

        return redirect('/dataresponden')->with('success','Data berhasil dihapus');
    }

    

}
