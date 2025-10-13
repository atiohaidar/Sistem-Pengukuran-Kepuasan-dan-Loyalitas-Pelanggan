<?php

namespace App\Http\Controllers\responden;

use App\Http\Controllers\Controller;
use App\SppEvaluation;
use App\Services\SppEvaluationResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SppSurveyController extends Controller
{
    private SppEvaluationResultService $resultService;

    public function __construct(SppEvaluationResultService $resultService)
    {
        $this->resultService = $resultService;
    }

    /**
     * Show the welcome page for SPP evaluation.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('responden.spp.index');
    }
    
    /**
     * Store the evaluation data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            // Maturity Assessment (8 questions)
            'maturity.visi' => 'required|integer|between:1,5',
            'maturity.strategi' => 'required|integer|between:1,5',
            'maturity.pengalamanKonsumen' => 'required|integer|between:1,5',
            'maturity.kolaborasiOrganisasi' => 'required|integer|between:1,5',
            'maturity.proses' => 'required|integer|between:1,5',
            'maturity.informasi' => 'required|integer|between:1,5',
            'maturity.teknologi' => 'required|integer|between:1,5',
            'maturity.matriks' => 'required|integer|between:1,5',
            // Priority Assessment (11 items, must total 100)
            'priority.kepemimpinanStrategis' => 'required|integer|min:0|max:100',
            'priority.posisiKompetitif' => 'required|integer|min:0|max:100',
            'priority.kepuasanPelanggan' => 'required|integer|min:0|max:100',
            'priority.nilaiUmurPelanggan' => 'required|integer|min:0|max:100',
            'priority.efisiensiBiaya' => 'required|integer|min:0|max:100',
            'priority.aksesPelanggan' => 'required|integer|min:0|max:100',
            'priority.solusiAplikasiPelanggan' => 'required|integer|min:0|max:100',
            'priority.informasiPelanggan' => 'required|integer|min:0|max:100',
            'priority.prosesPelanggan' => 'required|integer|min:0|max:100',
            'priority.standarSDM' => 'required|integer|min:0|max:100',
            'priority.pelaporanKinerja' => 'required|integer|min:0|max:100',
            // Readiness Audit (11 questions)
            'readiness.q1' => 'required|integer|between:1,5',
            'readiness.q2' => 'required|integer|between:1,5',
            'readiness.q3' => 'required|integer|between:1,5',
            'readiness.q4' => 'required|integer|between:1,5',
            'readiness.q5' => 'required|integer|between:1,5',
            'readiness.q6' => 'required|integer|between:1,5',
            'readiness.q7' => 'required|integer|between:1,5',
            'readiness.q8' => 'required|integer|between:1,5',
            'readiness.q9' => 'required|integer|between:1,5',
            'readiness.q10' => 'required|integer|between:1,5',
            'readiness.q11' => 'required|integer|between:1,5',
        ]);
        
        // Check priority total = 100
        $priorityTotal = 0;
        foreach ($validated['priority'] as $value) {
            $priorityTotal += $value;
        }
        
        if ($priorityTotal != 100) {
            return back()->withErrors(['priority' => 'Total prioritas harus 100'])->withInput();
        }
        
        // Create evaluation
        $evaluation = new SppEvaluation();
        $evaluation->company_name = $validated['company_name'];
        $evaluation->session_token = Str::uuid();
        
        // Maturity data
        $evaluation->maturity_visi = $validated['maturity']['visi'];
        $evaluation->maturity_strategi = $validated['maturity']['strategi'];
        $evaluation->maturity_pengalaman_konsumen = $validated['maturity']['pengalamanKonsumen'];
        $evaluation->maturity_kolaborasi_organisasi = $validated['maturity']['kolaborasiOrganisasi'];
        $evaluation->maturity_proses = $validated['maturity']['proses'];
        $evaluation->maturity_informasi = $validated['maturity']['informasi'];
        $evaluation->maturity_teknologi = $validated['maturity']['teknologi'];
        $evaluation->maturity_matriks = $validated['maturity']['matriks'];
        
        // Priority data
        $evaluation->priority_kepemimpinan_strategis = $validated['priority']['kepemimpinanStrategis'];
        $evaluation->priority_posisi_kompetitif = $validated['priority']['posisiKompetitif'];
        $evaluation->priority_kepuasan_pelanggan = $validated['priority']['kepuasanPelanggan'];
        $evaluation->priority_nilai_umur_pelanggan = $validated['priority']['nilaiUmurPelanggan'];
        $evaluation->priority_efisiensi_biaya = $validated['priority']['efisiensiBiaya'];
        $evaluation->priority_akses_pelanggan = $validated['priority']['aksesPelanggan'];
        $evaluation->priority_solusi_aplikasi_pelanggan = $validated['priority']['solusiAplikasiPelanggan'];
        $evaluation->priority_informasi_pelanggan = $validated['priority']['informasiPelanggan'];
        $evaluation->priority_proses_pelanggan = $validated['priority']['prosesPelanggan'];
        $evaluation->priority_standar_sdm = $validated['priority']['standarSDM'];
        $evaluation->priority_pelaporan_kinerja = $validated['priority']['pelaporanKinerja'];
        
        // Readiness data
        $evaluation->readiness_q1 = $validated['readiness']['q1'];
        $evaluation->readiness_q2 = $validated['readiness']['q2'];
        $evaluation->readiness_q3 = $validated['readiness']['q3'];
        $evaluation->readiness_q4 = $validated['readiness']['q4'];
        $evaluation->readiness_q5 = $validated['readiness']['q5'];
        $evaluation->readiness_q6 = $validated['readiness']['q6'];
        $evaluation->readiness_q7 = $validated['readiness']['q7'];
        $evaluation->readiness_q8 = $validated['readiness']['q8'];
        $evaluation->readiness_q9 = $validated['readiness']['q9'];
        $evaluation->readiness_q10 = $validated['readiness']['q10'];
        $evaluation->readiness_q11 = $validated['readiness']['q11'];
        
        // Calculate scores
        $evaluation->calculateMaturityScore();
        $evaluation->calculateProcessGroupScores();
        
        $evaluation->status = 'completed';
        $evaluation->completed_at = now();
        $evaluation->save();
        
        // Redirect to results page
        return redirect()->route('spp.survey.result', ['token' => $evaluation->session_token]);
    }
    
    /**
     * Show the result page.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function result($token)
    {
        $evaluation = SppEvaluation::where('session_token', $token)->firstOrFail();

        $resultData = $this->resultService->buildResultData($evaluation);

        return view('responden.spp.result', $resultData);
    }
}
