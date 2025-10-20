<?php

namespace App\Http\Controllers;

use App\Models\CustomerManagementEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerEvaluationsExport;

class CustomerManagementEvaluationDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomerManagementEvaluation::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('company_name', 'like', "%{$search}%")
                  ->orWhere('token', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'completed') {
                $query->where('completed', true);
            } elseif ($request->status === 'incomplete') {
                $query->where('completed', false);
            }
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $query->orderBy($sortBy, $sortDirection);

        $evaluations = $query->paginate(15);

        // Calculate statistics
        $stats = [
            'total' => CustomerManagementEvaluation::count(),
            'completed' => CustomerManagementEvaluation::where('completed', true)->count(),
            'incomplete' => CustomerManagementEvaluation::where('completed', false)->count(),
            'this_month' => CustomerManagementEvaluation::whereMonth('created_at', now()->month)
                                                        ->whereYear('created_at', now()->year)
                                                        ->count(),
        ];

        return view('dashboard.customer-evaluation-management.index', compact('evaluations', 'stats'));
    }

    public function show($id)
    {
        $evaluation = CustomerManagementEvaluation::findOrFail($id);

        // Prepare question labels for display
        $questionLabels = app(\App\Services\SurveyQuestionService::class)->getCustomerEvaluationQuestions();

        return view('dashboard.customer-evaluation-management.show', compact('evaluation', 'questionLabels'));
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

        return Excel::download(new CustomerEvaluationsExport($request->all()), $filename);
    }
}