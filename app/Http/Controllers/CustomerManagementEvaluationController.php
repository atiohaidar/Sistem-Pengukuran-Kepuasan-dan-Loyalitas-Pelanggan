<?php

namespace App\Http\Controllers;

use App\Models\CustomerManagementEvaluation;
use App\Services\CustomerManagementEvaluationService;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Models\UmkmProfile;

class CustomerManagementEvaluationController extends Controller
{
    protected $evaluationService;

    public function __construct(CustomerManagementEvaluationService $evaluationService)
    {
        $this->evaluationService = $evaluationService;
    }
    public function welcome(Request $request, $token)
    {
        // Get UMKM by token
        $umkm = UmkmProfile::where('crm_token', $token)->first();

        if (!$umkm) {
            abort(404, 'Token tidak valid');
        }

        return view('customer-management-evaluation.welcome', [
            'umkm' => $umkm,
            'token' => $token
        ]);
    }

    public function maturity(Request $request)
    {
        // Get UMKM by token
        $token = $request->route('token');
        $umkm = UmkmProfile::where('crm_token', $token)->first();

        if (!$umkm) {
            abort(404, 'Token tidak valid');
        }

        if ($request->isMethod('post')) {
            // Create new evaluation for this respondent
            $evaluation = $this->evaluationService->createEvaluationForUmkm($umkm);

            $request->session()->put('evaluation_token', $evaluation->token);

            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $sessionToken = $request->session()->get('evaluation_token');
        if (!$sessionToken) {
            // Show welcome page for new respondents
            return view('customer-management-evaluation.welcome', [
                'umkm' => $umkm,
                'token' => $token
            ]);
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($sessionToken);
        if (!$evaluation || $evaluation->umkm_id !== $umkm->id) {
            // Clear invalid session and show welcome again
            $request->session()->forget('evaluation_token');
            return view('customer-management-evaluation.welcome', [
                'umkm' => $umkm,
                'token' => $token
            ]);
        }

        $data = [
            'company_name' => $umkm->nama_usaha,
            'maturity' => $evaluation->maturity_data ?? [],
            'priority' => $evaluation->priority_data ?? [],
            'readiness' => $evaluation->readiness_data ?? [],
        ];

        return view('customer-management-evaluation.maturity', compact('data'));
    }

    public function storeMaturity(Request $request, $token)
    {
        $validated = $request->validate([
            'visi' => 'required|integer|min:1|max:5',
            'strategi' => 'required|integer|min:1|max:5',
            'pengalamanKonsumen' => 'required|integer|min:1|max:5',
            'kolaborasiOrganisasi' => 'required|integer|min:1|max:5',
            'proses' => 'required|integer|min:1|max:5',
            'informasi' => 'required|integer|min:1|max:5',
            'teknologi' => 'required|integer|min:1|max:5',
            'matriks' => 'required|integer|min:1|max:5',
        ]);

        // Validate UMKM token
        $umkm = UmkmProfile::where('crm_token', $token)->first();
        if (!$umkm) {
            abort(404, 'Token tidak valid');
        }

        $sessionToken = $request->session()->get('evaluation_token');
        if (!$sessionToken) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($sessionToken);
        if (!$evaluation || $evaluation->umkm_id !== $umkm->id) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $maturityData = array_intersect_key($validated, array_flip([
            'visi',
            'strategi',
            'pengalamanKonsumen',
            'kolaborasiOrganisasi',
            'proses',
            'informasi',
            'teknologi',
            'matriks'
        ]));

        $this->evaluationService->updateMaturityData($evaluation, $maturityData);

        return redirect()->route('customer-management-evaluation.priority', ['token' => $token]);
    }

    public function priority(Request $request, $token)
    {
        // Validate UMKM token
        $umkm = UmkmProfile::where('crm_token', $token)->first();
        if (!$umkm) {
            abort(404, 'Token tidak valid');
        }

        $sessionToken = $request->session()->get('evaluation_token');
        if (!$sessionToken) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($sessionToken);
        if (!$evaluation || $evaluation->umkm_id !== $umkm->id) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $data = [
            'company_name' => $umkm->nama_usaha,
            'maturity' => $evaluation->maturity_data ?? [],
            'priority' => $evaluation->priority_data ?? [],
            'readiness' => $evaluation->readiness_data ?? [],
        ];

        return view('customer-management-evaluation.priority', compact('data'));
    }

    public function storePriority(Request $request, $token)
    {
        $rules = [];
        $priorityItems = [
            'kepemimpinanStrategis',
            'posisiKompetitif',
            'kepuasanPelanggan',
            'nilaiUmurPelanggan',
            'efisiensiBiaya',
            'aksesPelanggan',
            'solusiAplikasiPelanggan',
            'informasiPelanggan',
            'prosesPelanggan',
            'standarSDM',
            'pelaporanKinerja'
        ];

        foreach ($priorityItems as $item) {
            $rules[$item] = 'nullable|integer|min:0|max:100|multiple_of:5';
        }

        $validated = $request->validate($rules);

        // Filter out empty values
        $filledValues = array_filter($validated, function ($value) {
            return $value !== null && $value !== '';
        });

        $total = array_sum($filledValues);
        if ($total !== 100) {
            return back()->withErrors(['total' => 'Total bobot dari item yang diisi harus sama dengan 100.']);
        }

        // Validate UMKM token
        $umkm = UmkmProfile::where('crm_token', $token)->first();
        if (!$umkm) {
            abort(404, 'Token tidak valid');
        }

        $sessionToken = $request->session()->get('evaluation_token');
        if (!$sessionToken) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($sessionToken);
        if (!$evaluation || $evaluation->umkm_id !== $umkm->id) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $this->evaluationService->updatePriorityData($sessionToken, $validated);

        return redirect()->route('customer-management-evaluation.readiness', ['token' => $token]);
    }

    public function readiness(Request $request, $token)
    {
        // Validate UMKM token
        $umkm = UmkmProfile::where('crm_token', $token)->first();
        if (!$umkm) {
            abort(404, 'Token tidak valid');
        }

        $sessionToken = $request->session()->get('evaluation_token');
        if (!$sessionToken) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($sessionToken);
        if (!$evaluation || $evaluation->umkm_id !== $umkm->id) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $data = [
            'company_name' => $umkm->nama_usaha,
            'maturity' => $evaluation->maturity_data ?? [],
            'priority' => $evaluation->priority_data ?? [],
            'readiness' => $evaluation->readiness_data ?? [],
        ];

        return view('customer-management-evaluation.readiness', compact('data'));
    }

    public function storeReadiness(Request $request, $token)
    {
        $validated = $request->validate([
            'q1' => 'required|integer|min:1|max:5',
            'q2' => 'required|integer|min:1|max:5',
            'q3' => 'required|integer|min:1|max:5',
            'q4' => 'required|integer|min:1|max:5',
            'q5' => 'required|integer|min:1|max:5',
            'q6' => 'required|integer|min:1|max:5',
            'q7' => 'required|integer|min:1|max:5',
            'q8' => 'required|integer|min:1|max:5',
            'q9' => 'required|integer|min:1|max:5',
            'q10' => 'required|integer|min:1|max:5',
            'q11' => 'required|integer|min:1|max:5',
        ]);

        // Validate UMKM token
        $umkm = UmkmProfile::where('crm_token', $token)->first();
        if (!$umkm) {
            abort(404, 'Token tidak valid');
        }

        $sessionToken = $request->session()->get('evaluation_token');
        if (!$sessionToken) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($sessionToken);
        if (!$evaluation || $evaluation->umkm_id !== $umkm->id) {
            return redirect()->route('customer-management-evaluation.maturity', ['token' => $token]);
        }

        $this->evaluationService->updateReadinessData($sessionToken, $validated);

        return redirect()->route('customer-management-evaluation.thank-you', ['token' => $token]);
    }

    public function thankYou($token)
    {
        // Validate UMKM token
        $umkm = UmkmProfile::where('crm_token', $token)->first();
        if (!$umkm) {
            abort(404, 'Token tidak valid');
        }

        return view('customer-management-evaluation.thank-you', compact('umkm'));
    }

    public function dashboard(Request $request, $token = null)
    {
        // For new system: dashboard is auth-only and shows aggregated data
        if (auth()->check() && auth()->user()->role === 'umkm') {
            $umkm = auth()->user()->umkm;
            if (!$umkm) {
                abort(403, 'UMKM profile not found');
            }

            $data = $this->evaluationService->getAggregatedDataForUmkm($umkm);
            $results = $this->evaluationService->calculateResults($data);
            $isShared = false;

            return view('customer-management-evaluation.dashboard', compact('data', 'results', 'isShared'));
        }

        // Legacy: token-based access (for backward compatibility)
        if ($token) {
            $evaluation = $this->evaluationService->getCompletedEvaluationByToken($token);
            if (!$evaluation) {
                abort(404);
            }
            $data = [
                'company_name' => $evaluation->company_name,
                'total_respondents' => 1,
                'maturity' => $evaluation->maturity_data ?? [],
                'priority' => $evaluation->priority_data ?? [],
                'readiness' => $evaluation->readiness_data ?? [],
            ];
            $isShared = true;
        } else {
            // From session
            $sessionToken = $request->session()->get('evaluation_token');
            if (!$sessionToken) {
                abort(403, 'Akses tidak diizinkan. Silakan mulai evaluasi terlebih dahulu.');
            }

            $evaluation = $this->evaluationService->getCompletedEvaluationByToken($sessionToken);
            if (!$evaluation) {
                abort(404, 'Evaluasi tidak ditemukan atau belum selesai.');
            }

            $data = [
                'company_name' => $evaluation->company_name,
                'total_respondents' => 1,
                'maturity' => $evaluation->maturity_data ?? [],
                'priority' => $evaluation->priority_data ?? [],
                'readiness' => $evaluation->readiness_data ?? [],
            ];
            $isShared = false;
            $token = $sessionToken;
        }

        // Calculate results using service
        $results = $this->evaluationService->calculateResults($data);

        return view('customer-management-evaluation.dashboard', compact('data', 'results', 'token', 'isShared'));
    }

}