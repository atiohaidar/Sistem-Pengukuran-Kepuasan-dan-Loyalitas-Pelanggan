<?php

namespace App\Http\Controllers;

use App\Models\SurveyCampaign;
use App\Services\SurveyCampaignService;
use App\Services\SurveyCalculationService;
use App\Services\ProdukSurveyQuestionService;
use App\Services\SurveyQuestionService;
use App\Exports\CustomerEvaluationsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SurveyCampaignController extends Controller
{
    protected $campaignService;
    protected $calculationService;
    protected $produkQuestionService;
    protected $pelatihanQuestionService;

    public function __construct(
        SurveyCampaignService $campaignService,
        SurveyCalculationService $calculationService,
        ProdukSurveyQuestionService $produkQuestionService,
        SurveyQuestionService $pelatihanQuestionService
    ) {
        $this->campaignService = $campaignService;
        $this->calculationService = $calculationService;
        $this->produkQuestionService = $produkQuestionService;
        $this->pelatihanQuestionService = $pelatihanQuestionService;
    }

    protected function currentUmkmProfileId(): ?int
    {
        return Auth::user()->umkm_id ?? null;
    }

    protected function assertOwnership(SurveyCampaign $campaign): void
    {
        $umkmProfileId = $this->currentUmkmProfileId();

        if ($umkmProfileId === null || $campaign->umkm_profile_id !== $umkmProfileId) {
            abort(403);
        }
    }

    /**
     * Display a listing of campaigns
     */
    public function index(Request $request)
    {
        $umkmProfileId = $this->currentUmkmProfileId();

        abort_if(!$umkmProfileId, 403);

        $query = SurveyCampaign::byUmkm($umkmProfileId)
            ->with('umkm')
            ->latest();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $campaigns = $query->paginate(10)->appends($request->query());
        
        // Get stats
    $stats = $this->campaignService->getCampaignStats($umkmProfileId);

        return view('survey-campaigns.index', compact('campaigns', 'stats'));
    }

    /**
     * Show the form for creating a new campaign
     */
    public function create()
    {
        return view('survey-campaigns.create');
    }

    /**
     * Store a newly created campaign
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:produk,pelatihan',
            'name' => 'required|max:255',
            'slug' => 'required|alpha_dash|max:255|unique:survey_campaigns,slug',
            'description' => 'nullable|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_respondents' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,active',
        ]);

        $umkmProfileId = $this->currentUmkmProfileId();

        abort_if(!$umkmProfileId, 403);

        $validated['umkm_profile_id'] = $umkmProfileId;

        $campaign = SurveyCampaign::create($validated);

        return redirect()->route('survey-campaigns.dashboard', $campaign)
            ->with('success', 'Kampanye survei berhasil dibuat!');
    }

    /**
     * Display campaign dashboard with analytics
     */
    public function dashboard(SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        // Calculate results
        $results = $this->calculationService->calculateCampaignResults($campaign);
        
        // Get recent responses
        $recentResponses = $campaign->responses()
            ->latest()
            ->limit(10)
            ->get();

        // Stats
        $totalResponses = $campaign->responses_count;
        
        $todayCount = $campaign->responses()
            ->whereDate('created_at', today())
            ->count();
        
        $weekCount = $campaign->responses()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        return view('survey-campaigns.dashboard', compact(
            'campaign', 
            'results', 
            'recentResponses',
            'totalResponses',
            'todayCount',
            'weekCount'
        ));
    }

    /**
     * Show the form for editing campaign
     */
    public function edit(SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        return view('survey-campaigns.edit', compact('campaign'));
    }

    /**
     * Update campaign
     */
    public function update(Request $request, SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        $validated = $request->validate([
            'type' => 'required|in:produk,pelatihan',
            'name' => 'required|max:255',
            'slug' => 'required|alpha_dash|max:255|unique:survey_campaigns,slug,' . $campaign->id,
            'description' => 'nullable|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_respondents' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,active,closed,archived',
        ]);

        $campaign->update($validated);

        return redirect()->route('survey-campaigns.dashboard', $campaign)
            ->with('success', 'Kampanye survei berhasil diperbarui!');
    }

    /**
     * Delete campaign
     */
    public function destroy(SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        $campaign->delete();

        return redirect()->route('survey-campaigns.index')
            ->with('success', 'Kampanye survei berhasil dihapus!');
    }

    /**
     * Display campaign responses
     */
    public function responses(Request $request, SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        $query = $campaign->responses()->latest();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nomor_hp', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $responses = $query->paginate(20)->appends($request->query());

        // Stats
        $todayCount = $campaign->responses()
            ->whereDate('created_at', today())
            ->count();
        
        $weekCount = $campaign->responses()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        
        $monthCount = $campaign->responses()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        return view('survey-campaigns.responses', compact(
            'campaign', 
            'responses', 
            'todayCount', 
            'weekCount', 
            'monthCount'
        ));
    }

    /**
     * Display single response detail
     */
    public function responseDetail(SurveyCampaign $campaign, $responseId)
    {
        $this->assertOwnership($campaign);

        $response = $campaign->responses()->findOrFail($responseId);

        // Get questions based on campaign type
        if ($campaign->type === 'produk') {
            $allQuestions = $this->produkQuestionService->getQuestions();
            $loyaltyQuestions = $this->produkQuestionService->getLoyaltyQuestions();
        } else {
            $allQuestions = $this->pelatihanQuestionService->getQuestions();
            $loyaltyQuestions = $this->pelatihanQuestionService->getLoyaltyQuestions();
        }

        // Prepare structured questions with answers
        $harapanQuestions = $allQuestions['harapan_answers'] ?? [];
        $persepsiQuestions = $allQuestions['persepsi_answers'] ?? [];
        $kepuasanQuestions = $allQuestions['kepuasan_answers'] ?? [];

        return view('survey-campaigns.response-detail', compact(
            'campaign', 
            'response', 
            'harapanQuestions',
            'persepsiQuestions',
            'kepuasanQuestions',
            'loyaltyQuestions'
        ));
    }

    /**
     * Export campaign responses to Excel
     */
    public function export(SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        $filename = 'survey-' . $campaign->slug . '-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(
            new CustomerEvaluationsExport($campaign->responses),
            $filename
        );
    }

    /**
     * Activate campaign
     */
    public function activate(SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        if ($this->campaignService->activateCampaign($campaign)) {
            return back()->with('success', 'Kampanye survei berhasil diaktifkan!');
        }

        return back()->with('error', 'Gagal mengaktifkan kampanye. Pastikan tanggal mulai sudah lewat.');
    }

    /**
     * Close campaign
     */
    public function close(SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        $this->campaignService->closeCampaign($campaign);

        return back()->with('success', 'Kampanye survei berhasil ditutup!');
    }

    /**
     * Archive campaign
     */
    public function archive(SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        if ($this->campaignService->archiveCampaign($campaign)) {
            return back()->with('success', 'Kampanye survei berhasil diarsipkan!');
        }

        return back()->with('error', 'Hanya kampanye yang sudah ditutup yang bisa diarsipkan.');
    }

    /**
     * Duplicate campaign
     */
    public function duplicate(SurveyCampaign $campaign)
    {
        $this->assertOwnership($campaign);

        $newCampaign = $this->campaignService->duplicateCampaign($campaign);

        return redirect()->route('survey-campaigns.edit', $newCampaign)
            ->with('success', 'Kampanye berhasil diduplikasi! Silakan edit sesuai kebutuhan.');
    }
}
