<?php

namespace App\Http\Controllers;

use App\Models\CustomerManagementEvaluation;
use App\Models\UmkmProfile;
use App\Services\CustomerManagementEvaluationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerEvaluationsExport;

class CustomerManagementEvaluationDashboardController extends Controller
{
    protected $customerManagementEvaluationService;

    public function __construct(CustomerManagementEvaluationService $customerManagementEvaluationService)
    {
        $this->customerManagementEvaluationService = $customerManagementEvaluationService;
    }
    public function index(Request $request)
    {
        $query = UmkmProfile::with('customerManagementEvaluations');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_usaha', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $query->orderBy($sortBy, $sortDirection);

        $umkms = $query->paginate(15)->through(function ($umkm) {
            $evaluations = $umkm->customerManagementEvaluations;
            $completedCount = $evaluations->where('completed', true)->count();
            $totalCount = $evaluations->count();

            // Calculate average maturity for this UMKM
            $averageMaturity = 0;
            if ($totalCount > 0) {
                $maturityScores = [];
                foreach ($evaluations->where('completed', true) as $evaluation) {
                    $maturityData = $evaluation->maturity_data ?? [];
                    if (!empty($maturityData)) {
                        $scores = array_values($maturityData);
                        if (!empty($scores)) {
                            $maturityScores[] = array_sum($scores) / count($scores);
                        }
                    }
                }
                $averageMaturity = !empty($maturityScores) ? array_sum($maturityScores) / count($maturityScores) : 0;
            }

            return [
                'id' => $umkm->id,
                'nama_usaha' => $umkm->nama_usaha,
                'deskripsi' => $umkm->deskripsi,
                'kategori_usaha' => $umkm->kategori_usaha,
                'crm_token' => $umkm->crm_token,
                'customer_management_evaluations_count' => $totalCount,
                'total_evaluations' => $totalCount,
                'completed_evaluations' => $completedCount,
                'completion_rate' => $totalCount > 0 ? round(($completedCount / $totalCount) * 100, 1) : 0,
                'average_maturity' => round($averageMaturity, 2),
                'created_at' => $umkm->created_at,
                'updated_at' => $umkm->updated_at,
            ];
        });

        // Calculate statistics
        $allUmkms = UmkmProfile::with('customerManagementEvaluations')->get();
        $stats = [
            'total_umkm' => $allUmkms->count(),
            'umkm_with_evaluations' => $allUmkms->filter(function ($umkm) {
                return $umkm->customerManagementEvaluations->count() > 0;
            })->count(),
            'total_respondents' => $allUmkms->sum(function ($umkm) {
                return $umkm->customerManagementEvaluations->count();
            }),
            'completed_evaluations' => $allUmkms->sum(function ($umkm) {
                return $umkm->customerManagementEvaluations->where('completed', true)->count();
            }),
            'average_maturity' => $this->calculateAverageMaturity($allUmkms),
            'this_month' => $allUmkms->filter(function ($umkm) {
                return $umkm->created_at->isCurrentMonth();
            })->count(),
        ];


        return view('dashboard.customer-evaluation-management.index', compact('stats', 'umkms'));
    }

    private function calculateAverageMaturity($allUmkms)
    {
        $totalMaturity = 0;
        $umkmCount = 0;

        foreach ($allUmkms as $umkm) {
            $aggregatedData = $this->customerManagementEvaluationService->getAggregatedDataForUmkm($umkm);
            if ($aggregatedData['total_respondents'] > 0) {
                $maturityScores = array_values($aggregatedData['maturity']);
                $maturityAverage = count($maturityScores) > 0 ? array_sum($maturityScores) / count($maturityScores) : 0;
                $totalMaturity += $maturityAverage;
                $umkmCount++;
            }
        }

        return $umkmCount > 0 ? round($totalMaturity / $umkmCount, 2) : 0;
    }

    public function show($id)
    {
        $umkm = UmkmProfile::with('customerManagementEvaluations')->findOrFail($id);

        // Get aggregated data for this UMKM
        $aggregatedData = app(\App\Services\CustomerManagementEvaluationService::class)->getAggregatedDataForUmkm($umkm);

        // Calculate results using service
        $results = app(\App\Services\CustomerManagementEvaluationService::class)->calculateResults($aggregatedData);

        // Provide convenience variables expected by the view
        $totalRespondents = $aggregatedData['total_respondents'] ?? $umkm->customerManagementEvaluations->count();
        $completedEvaluations = $aggregatedData['completed_evaluations'] ?? $umkm->customerManagementEvaluations->where('completed', true)->count();

        return view('dashboard.customer-evaluation-management.show', compact('umkm', 'aggregatedData', 'results', 'totalRespondents', 'completedEvaluations'));
    }

    public function destroy($id)
    {
        $evaluation = CustomerManagementEvaluation::findOrFail($id);
        $evaluation->delete();

        return redirect()->route('dashboard.customer-evaluation-management.index')
            ->with('success', 'Evaluasi berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $filename = 'customer_evaluations_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        // return Excel::download(new CustomerEvaluationsExport($request->all()), $filename);
        // TODO: Update export to handle aggregated UMKM data
        return back()->with('info', 'Export functionality will be updated for UMKM-based data');
    }
}