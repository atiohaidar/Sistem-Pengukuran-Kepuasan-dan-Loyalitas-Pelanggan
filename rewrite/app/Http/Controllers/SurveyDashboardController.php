<?php

namespace App\Http\Controllers;

use App\Models\PelatihanSurveyResponse;
use App\Services\SurveyCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyDashboardController extends Controller
{
    protected $surveyService;

    public function __construct(SurveyCalculationService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    /**
     * Display survey dashboard with statistics and data management
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $status = $request->get('status', 'all');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $surveyType = $request->get('survey_type', 'all');

        // Build query with filters
        $query = PelatihanSurveyResponse::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($surveyType !== 'all') {
            $query->where('survey_type', $surveyType);
        }

        // Get paginated results
        $surveys = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get basic statistics
        $stats = $this->getBasicStatistics($request);

        return view('dashboard.surveys.index', compact('surveys', 'stats', 'status', 'dateFrom', 'dateTo', 'surveyType'));
    }

    /**
     * Show the form for creating a new survey response
     */
    public function create()
    {
        return view('dashboard.surveys.create');
    }

    /**
     * Store a newly created survey response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'survey_type' => 'required|string',
            'profile_data.email' => 'required|email',
            'profile_data.whatsapp' => 'required|string',
            'profile_data.jenis_kelamin' => 'required|in:L,P',
            'profile_data.usia' => 'required|integer|min:18|max:100',
            'profile_data.pekerjaan' => 'required|string',
            'profile_data.pekerjaan_lain' => 'nullable|string',
            'profile_data.domisili' => 'required|string',
            'importance_answers' => 'required|array',
            'performance_answers' => 'required|array',
            'satisfaction_answers' => 'required|array',
            'loyalty_answers' => 'required|array',
            'feedback_answers' => 'required|array',
            'status' => 'required|in:draft,completed'
        ]);

        // Generate session token
        $validated['session_token'] = PelatihanSurveyResponse::generateSessionToken();

        // Set timestamps
        if ($validated['status'] === 'completed') {
            $validated['completed_at'] = now();
        }
        $validated['started_at'] = now();

        PelatihanSurveyResponse::create($validated);

        return redirect()->route('dashboard.surveys.index')
            ->with('success', 'Data survei berhasil ditambahkan.');
    }

    /**
     * Display the specified survey response
     */
    public function show(PelatihanSurveyResponse $survey)
    {
        // Calculate individual survey results
        $responses = [$survey->toArray()];
        $analysis = $this->surveyService->calculateCompleteSurveyResults($responses);

        return view('dashboard.surveys.show', compact('survey', 'analysis'));
    }

    /**
     * Show the form for editing the specified survey response
     */
    public function edit(PelatihanSurveyResponse $survey)
    {
        return view('dashboard.surveys.edit', compact('survey'));
    }

    /**
     * Update the specified survey response
     */
    public function update(Request $request, PelatihanSurveyResponse $survey)
    {
        $validated = $request->validate([
            'survey_type' => 'required|string',
            'profile_data.email' => 'required|email',
            'profile_data.whatsapp' => 'required|string',
            'profile_data.jenis_kelamin' => 'required|in:L,P',
            'profile_data.usia' => 'required|integer|min:18|max:100',
            'profile_data.pekerjaan' => 'required|string',
            'profile_data.pekerjaan_lain' => 'nullable|string',
            'profile_data.domisili' => 'required|string',
            'importance_answers' => 'required|array',
            'performance_answers' => 'required|array',
            'satisfaction_answers' => 'required|array',
            'loyalty_answers' => 'required|array',
            'feedback_answers' => 'required|array',
            'status' => 'required|in:draft,completed'
        ]);

        // Update completed_at if status changed to completed
        if ($validated['status'] === 'completed' && $survey->status !== 'completed') {
            $validated['completed_at'] = now();
        }

        $survey->update($validated);

        return redirect()->route('dashboard.surveys.index')
            ->with('success', 'Data survei berhasil diperbarui.');
    }

    /**
     * Remove the specified survey response
     */
    public function destroy(PelatihanSurveyResponse $survey)
    {
        $survey->delete();

        return redirect()->route('dashboard.surveys.index')
            ->with('success', 'Data survei berhasil dihapus.');
    }

    /**
     * Get basic statistics for dashboard
     */
    private function getBasicStatistics(Request $request)
    {
        $query = PelatihanSurveyResponse::query();

        // Apply same filters as main query
        $status = $request->get('status', 'all');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $surveyType = $request->get('survey_type', 'all');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($surveyType !== 'all') {
            $query->where('survey_type', $surveyType);
        }

        $totalSurveys = $query->count();
        $completedSurveys = (clone $query)->where('status', 'completed')->count();
        $draftSurveys = (clone $query)->where('status', 'draft')->count();

        // Get completion rate
        $completionRate = $totalSurveys > 0 ? round(($completedSurveys / $totalSurveys) * 100, 1) : 0;

        // Get recent surveys (last 7 days)
        $recentSurveys = (clone $query)->where('created_at', '>=', now()->subDays(7))->count();

        // Get average completion time for completed surveys
        $avgCompletionTime = (clone $query)->where('status', 'completed')
            ->whereNotNull('started_at')
            ->whereNotNull('completed_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, started_at, completed_at)) as avg_time')
            ->first()
            ->avg_time ?? 0;

        return [
            'total_surveys' => $totalSurveys,
            'completed_surveys' => $completedSurveys,
            'draft_surveys' => $draftSurveys,
            'completion_rate' => $completionRate,
            'recent_surveys' => $recentSurveys,
            'avg_completion_time' => round($avgCompletionTime, 1)
        ];
    }

    /**
     * Export survey data
     */
    public function export(Request $request)
    {
        // This could be expanded to export to CSV/Excel
        $query = PelatihanSurveyResponse::query();

        // Apply filters
        $status = $request->get('status', 'all');
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $surveys = $query->get();

        // For now, return JSON export
        return response()->json($surveys);
    }
}