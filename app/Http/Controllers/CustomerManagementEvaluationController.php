<?php

namespace App\Http\Controllers;

use App\Models\CustomerManagementEvaluation;
use App\Services\CustomerManagementEvaluationService;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class CustomerManagementEvaluationController extends Controller
{
    protected $evaluationService;

    public function __construct(CustomerManagementEvaluationService $evaluationService)
    {
        $this->evaluationService = $evaluationService;
    }
    public function welcome()
    {
        return view('customer-management-evaluation.welcome');
    }

    public function maturity(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
            ]);

            $token = Str::uuid()->toString();
            $this->evaluationService->createEvaluation($validated['company_name'], $token);

            $request->session()->put('evaluation_token', $token);

            return redirect()->route('customer-management-evaluation.maturity');
        }

        $token = $request->session()->get('evaluation_token');
        if (!$token) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($token);
        if (!$evaluation) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $data = [
            'company_name' => $evaluation->company_name,
            'maturity' => $evaluation->maturity_data ?? [],
            'priority' => $evaluation->priority_data ?? [],
            'readiness' => $evaluation->readiness_data ?? [],
        ];

        return view('customer-management-evaluation.maturity', compact('data'));
    }

    public function storeMaturity(Request $request)
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

        $token = $request->session()->get('evaluation_token');
        if (!$token) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($token);
        if (!$evaluation) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $maturityData = array_intersect_key($validated, array_flip([
            'visi', 'strategi', 'pengalamanKonsumen', 'kolaborasiOrganisasi', 'proses', 'informasi', 'teknologi', 'matriks'
        ]));

        $this->evaluationService->updateMaturityData($evaluation, $maturityData);

        return redirect()->route('customer-management-evaluation.priority');
    }

    public function priority(Request $request)
    {
        $token = $request->session()->get('evaluation_token');
        if (!$token) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($token);
        if (!$evaluation) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $data = [
            'company_name' => $evaluation->company_name,
            'maturity' => $evaluation->maturity_data ?? [],
            'priority' => $evaluation->priority_data ?? [],
            'readiness' => $evaluation->readiness_data ?? [],
        ];

        return view('customer-management-evaluation.priority', compact('data'));
    }

    public function storePriority(Request $request)
    {
        $rules = [];
        $priorityItems = [
            'kepemimpinanStrategis', 'posisiKompetitif', 'kepuasanPelanggan', 'nilaiUmurPelanggan',
            'efisiensiBiaya', 'aksesPelanggan', 'solusiAplikasiPelanggan', 'informasiPelanggan',
            'prosesPelanggan', 'standarSDM', 'pelaporanKinerja'
        ];

        foreach ($priorityItems as $item) {
            $rules[$item] = 'nullable|integer|min:0|max:100|multiple_of:5';
        }

        $validated = $request->validate($rules);

        // Filter out empty values
        $filledValues = array_filter($validated, function($value) {
            return $value !== null && $value !== '';
        });

        $total = array_sum($filledValues);
        if ($total !== 100) {
            return back()->withErrors(['total' => 'Total bobot dari item yang diisi harus sama dengan 100.']);
        }

        $token = $request->session()->get('evaluation_token');
        if (!$token) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $this->evaluationService->updatePriorityData($token, $validated);

        return redirect()->route('customer-management-evaluation.readiness');
    }

    public function readiness(Request $request)
    {
        $token = $request->session()->get('evaluation_token');
        if (!$token) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $evaluation = $this->evaluationService->getEvaluationByToken($token);
        if (!$evaluation) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $data = [
            'company_name' => $evaluation->company_name,
            'maturity' => $evaluation->maturity_data ?? [],
            'priority' => $evaluation->priority_data ?? [],
            'readiness' => $evaluation->readiness_data ?? [],
        ];

        return view('customer-management-evaluation.readiness', compact('data'));
    }

    public function storeReadiness(Request $request)
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

        $token = $request->session()->get('evaluation_token');
        if (!$token) {
            return redirect()->route('customer-management-evaluation.welcome');
        }

        $this->evaluationService->updateReadinessData($token, $validated);

        return redirect()->route('customer-management-evaluation.dashboard');
    }

    public function dashboard(Request $request, $token = null)
    {
        if ($token) {
            // Access via token
            $evaluation = $this->evaluationService->getCompletedEvaluationByToken($token);
            if (!$evaluation) {
                abort(404);
            }
            $data = [
                'company_name' => $evaluation->company_name,
                'maturity' => $evaluation->maturity_data ?? [],
                'priority' => $evaluation->priority_data ?? [],
                'readiness' => $evaluation->readiness_data ?? [],
            ];
            $isShared = true;
        } else {
            // From session
            $sessionToken = $request->session()->get('evaluation_token');
            if (!$sessionToken) {
                return redirect()->route('customer-management-evaluation.welcome');
            }

            $evaluation = $this->evaluationService->getCompletedEvaluationByToken($sessionToken);
            if (!$evaluation) {
                return redirect()->route('customer-management-evaluation.welcome');
            }

            $data = [
                'company_name' => $evaluation->company_name,
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