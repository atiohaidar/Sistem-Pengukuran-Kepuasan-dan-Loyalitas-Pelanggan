<?php

namespace App\Http\Controllers;

use App\Models\PelatihanSurveyResponse;
use App\Models\ProdukSurveyResponse;
use App\Models\SurveyCampaign;
use App\Services\SurveyCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrafikController extends Controller
{
    protected $surveyService;

    public function __construct(SurveyCalculationService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    protected function currentUmkmProfileId(): ?int
    {
        return Auth::user()->umkm_id ?? null;
    }

    protected function assertOwnership(?SurveyCampaign $campaign): void
    {
        if (!$campaign) {
            return;
        }

        // Allow superadmin users to access any campaign
        $user = Auth::user();
        if (isset($user->role) && $user->role === 'superadmin') {
            return;
        }

        if ($campaign->umkm_profile_id !== $this->currentUmkmProfileId()) {
            abort(403, 'Unauthorized access to this campaign');
        }
    }

    protected function isSuperAdmin(): bool
    {
        $user = Auth::user();
        return isset($user->role) && $user->role === 'superadmin';
    }

    /**
     * Halaman pemilihan campaign untuk analytics
     */
    public function selectCampaign()
    {
        $umkmProfileId = $this->currentUmkmProfileId();

        // Superadmin can see all campaigns; UMKM owners only their own
        if ($this->isSuperAdmin()) {
            $campaigns = SurveyCampaign::orderBy('created_at', 'desc')->get();
        } else {
            abort_if(!$umkmProfileId, 403);

            $campaigns = SurveyCampaign::where('umkm_profile_id', $umkmProfileId)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('grafik.select-campaign', compact('campaigns'));
    }

    /**
     * Dashboard analytics untuk campaign tertentu
     */
    public function dashboardCampaign($campaignId)
    {
        $campaign = SurveyCampaign::findOrFail($campaignId);

        $this->assertOwnership($campaign);

        return view('grafik.dashboard-campaign', compact('campaign'));
    }

    public function mean_gap_per_dimensi(Request $request, $type = 'pelatihan', $campaignId = null)
    {
        // Check query string first, then route parameter
        $type = $request->query('type') ?? $type;
        $campaignId = $request->query('campaignId') ?? $campaignId;
        $campaign = $campaignId ? SurveyCampaign::findOrFail($campaignId) : null;
        $this->assertOwnership($campaign);

        $modelClass = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;
        $responsesQuery = $modelClass::where('status', 'completed');

        if ($campaign) {

            $responsesQuery->where('survey_campaign_id', $campaign->id);
        } else {
            // If not superadmin, restrict to campaigns owned by current UMKM
            if (!$this->isSuperAdmin()) {
                $umkmProfileId = $this->currentUmkmProfileId();
                abort_if(!$umkmProfileId, 403);

                $responsesQuery->whereHas('campaign', function ($q) use ($umkmProfileId) {
                    $q->where('umkm_profile_id', $umkmProfileId);
                });
            }
        }

        $responses = $responsesQuery->get();


        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
        $gapResults = $this->surveyService->calculateGapAnalysis($responses->toArray());

        $itemAverages = $ikpResults['item_averages'] ?? [];
        $harapanAverages = $itemAverages['harapan'] ?? [];
        $persepsiAverages = $itemAverages['persepsi'] ?? [];
        $dimensionsConfig = $this->surveyService->getDimensionsConfig();

        $dimensions = [];
        foreach ($dimensionsConfig as $config) {
            $data = [];
            for ($i = 1; $i <= $config['count']; $i++) {
                $key = $config['prefix'] . $i;
                $data[$key . '_ratapersepsi_rata'] = $persepsiAverages[$key] ?? 0;
                $data[$key . '_ratakepentingan_rata'] = $harapanAverages[$key] ?? 0;
            }
            $dimensions[] = array_merge($config, ['data' => $data]);
        }

        return view('grafik.mean-gap-per-dimensi', compact('dimensions', 'type', 'campaign'));
    }

    public function profilResponden(Request $request, $type = 'pelatihan', $campaignId = null)
    {
        // Check query string first, then route parameter
        $type = $request->query('type') ?? $type;
        $campaignId = $request->query('campaignId') ?? $campaignId;
        $campaign = $campaignId ? SurveyCampaign::findOrFail($campaignId) : null;
        $this->assertOwnership($campaign);
        $modelClass = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;
        $query = $modelClass::completed();

        if ($campaign) {
            $query->where('survey_campaign_id', $campaign->id);
        } else {
            if (!$this->isSuperAdmin()) {
                $umkmProfileId = $this->currentUmkmProfileId();
                abort_if(!$umkmProfileId, 403);

                $query->whereHas('campaign', function ($q) use ($umkmProfileId) {
                    $q->where('umkm_profile_id', $umkmProfileId);
                });
            }
        }

        $responses = $query->get();

        $ageGroups = ['18-25', '26-35', '36-45', '46-55', '56+'];
        $ageData = [];
        foreach ($ageGroups as $group) {
            $ageData[] = [
                'age_group' => $group,
                'male' => $responses->filter(function ($response) use ($group) {
                    $jenisKelamin = $response->profile_data['jenis_kelamin'] ?? '';
                    $usia = $response->profile_data['usia'] ?? 0;

                    return $jenisKelamin === 'L' && $this->getAgeGroup($usia) === $group;
                })->count(),
                'female' => $responses->filter(function ($response) use ($group) {
                    $jenisKelamin = $response->profile_data['jenis_kelamin'] ?? '';
                    $usia = $response->profile_data['usia'] ?? 0;

                    return $jenisKelamin === 'P' && $this->getAgeGroup($usia) === $group;
                })->count(),
            ];
        }

        $genderData = [
            [
                'label' => 'Laki-laki',
                'value' => $responses->filter(function ($response) {
                    return ($response->profile_data['jenis_kelamin'] ?? '') === 'L';
                })->count()
            ],
            [
                'label' => 'Perempuan',
                'value' => $responses->filter(function ($response) {
                    return ($response->profile_data['jenis_kelamin'] ?? '') === 'P';
                })->count()
            ],
        ];

        $occupationData = $responses->groupBy(function ($response) {
            return $response->profile_data['pekerjaan'] ?? 'Tidak Diketahui';
        })->map(function ($group) {
            return ['label' => $group->first()->profile_data['pekerjaan'] ?? 'Tidak Diketahui', 'value' => $group->count()];
        })->values()->toArray();

        $domicileData = $responses->groupBy(function ($response) {
            return $response->profile_data['domisili'] ?? 'Tidak Diketahui';
        })->map(function ($group) {
            return ['label' => $group->first()->profile_data['domisili'] ?? 'Tidak Diketahui', 'value' => $group->count()];
        })->values()->toArray();

        return view('grafik.profil-responden', compact('ageData', 'genderData', 'occupationData', 'domicileData', 'type', 'campaign'));
    }

    private function getAgeGroup($usia)
    {
        if ($usia >= 18 && $usia <= 25) {
            return '18-25';
        }
        if ($usia >= 26 && $usia <= 35) {
            return '26-35';
        }
        if ($usia >= 36 && $usia <= 45) {
            return '36-45';
        }
        if ($usia >= 46 && $usia <= 55) {
            return '46-55';
        }

        return '56+';
    }

    public function mean_persepsi_harapan_gap_per_dimensi(Request $request, $type = 'pelatihan', $campaignId = null)
    {
        // Check query string first, then route parameter
        $type = $request->query('type') ?? $type;
        $campaignId = $request->query('campaignId') ?? $campaignId;
        $campaign = $campaignId ? SurveyCampaign::findOrFail($campaignId) : null;
        $this->assertOwnership($campaign);

        $modelClass = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;
        $query = $modelClass::where('status', 'completed');

        if ($campaign) {
            $query->where('survey_campaign_id', $campaign->id);
        } else {
            if (!$this->isSuperAdmin()) {
                $umkmProfileId = $this->currentUmkmProfileId();
                abort_if(!$umkmProfileId, 403);

                $query->whereHas('campaign', function ($q) use ($umkmProfileId) {
                    $q->where('umkm_profile_id', $umkmProfileId);
                });
            }
        }

        $responses = $query->get();

        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
        $gapResults = $this->surveyService->calculateGapAnalysis($responses->toArray());

        $itemAverages = $ikpResults['item_averages'] ?? [];
        $harapanAverages = $itemAverages['harapan'] ?? [];
        $persepsiAverages = $itemAverages['persepsi'] ?? [];
        $dimensionsConfig = $this->surveyService->getDimensionsConfig();

        $dimensions = [];
        foreach ($dimensionsConfig as $config) {
            $persepsiSum = 0;
            $harapanSum = 0;
            $gapSum = 0;
            $count = $config['count'];

            for ($i = 1; $i <= $count; $i++) {
                $key = $config['prefix'] . $i;
                $persepsiSum += $persepsiAverages[$key] ?? 0;
                $harapanSum += $harapanAverages[$key] ?? 0;
                $gapSum += ($persepsiAverages[$key] ?? 0) - ($harapanAverages[$key] ?? 0);
            }

            $avgPersepsi = $count > 0 ? $persepsiSum / $count : 0;
            $avgHarapan = $count > 0 ? $harapanSum / $count : 0;
            $avgGap = $count > 0 ? $gapSum / $count : 0;

            $dimensions[] = array_merge($config, [
                'avg_persepsi' => $avgPersepsi,
                'avg_harapan' => $avgHarapan,
                'avg_gap' => $avgGap,
            ]);
        }

        return view('grafik.mean-persepsi-harapan-gap-per-dimensi', compact('dimensions', 'type', 'campaign'));
    }

    public function rekomendasi(Request $request, $type = 'pelatihan', $campaignId = null)
    {
        // Check query string first, then route parameter
        $type = $request->query('type') ?? $type;
        $campaignId = $request->query('campaignId') ?? $campaignId;
        $campaign = $campaignId ? SurveyCampaign::findOrFail($campaignId) : null;
        $this->assertOwnership($campaign);

        $modelClass = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;
        $query = $modelClass::where('status', 'completed');

        if ($campaign) {
            $query->where('survey_campaign_id', $campaign->id);
        } else {
            if (!$this->isSuperAdmin()) {
                $umkmProfileId = $this->currentUmkmProfileId();
                abort_if(!$umkmProfileId, 403);

                $query->whereHas('campaign', function ($q) use ($umkmProfileId) {
                    $q->where('umkm_profile_id', $umkmProfileId);
                });
            }
        }

        $responses = $query->get();

        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
        $gapResults = $this->surveyService->calculateGapAnalysis($responses->toArray());

        $dimensionGaps = $gapResults['dimension_gaps'] ?? [];
        $gapStatistics = $gapResults['gap_statistics'] ?? [];
        $ikpPercentage = $ikpResults['ikp_percentage'] ?? 0;
        $ikpInterpretation = $ikpResults['ikp_interpretation'] ?? '';
        $dimensionsConfig = $this->surveyService->getDimensionsConfigForGap();

        $gapData = [];
        foreach ($dimensionsConfig as $config) {
            $gapData[$config['prefix']] = $dimensionGaps[$config['prefix']] ?? 0;
        }

        $stdDevData = [];
        $baseStdDev = $gapStatistics['standard_deviation'] ?? 0.5;
        foreach ($dimensionsConfig as $config) {
            $variation = (ord(substr($config['prefix'], 0, 1)) - ord('a')) * 0.1;
            $stdDevData[$config['prefix']] = max(0.1, $baseStdDev + $variation);
        }

        return view('grafik.rekomendasi', compact('dimensionsConfig', 'gapData', 'stdDevData', 'ikpPercentage', 'ikpInterpretation', 'type', 'campaign'));
    }

    public function kepuasan(Request $request, $type = 'pelatihan', $campaignId = null)
    {
        // Check query string first, then route parameter
        $type = $request->query('type') ?? $type;
        $campaignId = $request->query('campaignId') ?? $campaignId;
        $campaign = $campaignId ? SurveyCampaign::findOrFail($campaignId) : null;
        $this->assertOwnership($campaign);

        $modelClass = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;
        $query = $modelClass::where('status', 'completed');

        if ($campaign) {
            $query->where('survey_campaign_id', $campaign->id);
        } else {
            if (!$this->isSuperAdmin()) {
                $umkmProfileId = $this->currentUmkmProfileId();
                abort_if(!$umkmProfileId, 403);

                $query->whereHas('campaign', function ($q) use ($umkmProfileId) {
                    $q->where('umkm_profile_id', $umkmProfileId);
                });
            }
        }

        $responses = $query->get();

        $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
        $gapResults = $this->surveyService->calculateGapAnalysis($responses->toArray());
        $ilpResults = $this->surveyService->calculateILP($responses->toArray());
        $kepuasanDetails = $this->surveyService->calculateKepuasanDetails($responses->toArray());

        $ikpPercentage = $ikpResults['ikp_percentage'] ?? 0;
        $ilpPercentage = $ilpResults['ilp_percentage'] ?? 0;

        if ($type === 'produk') {
            $questions = app(\App\Services\ProdukSurveyQuestionService::class)->getProdukQuestions();
        } else {
            $questions = app(\App\Services\SurveyQuestionService::class)->getPelatihanQuestions();
        }

        return view('grafik.kepuasan', compact(
            'ikpPercentage',
            'ilpPercentage',
            'responses',
            'questions',
            'type',
            'campaign'
        ) + $kepuasanDetails);
    }

    public function loyalitas(Request $request, $type = 'pelatihan', $campaignId = null)
    {
        // Check query string first, then route parameter
        $type = $request->query('type') ?? $type;
        $campaignId = $request->query('campaignId') ?? $campaignId;
        $campaign = $campaignId ? SurveyCampaign::findOrFail($campaignId) : null;
        $this->assertOwnership($campaign);

        $modelClass = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;
        $query = $modelClass::where('status', 'completed');

        if ($campaign) {
            $query->where('survey_campaign_id', $campaign->id);
        } else {
            if (!$this->isSuperAdmin()) {
                $umkmProfileId = $this->currentUmkmProfileId();
                abort_if(!$umkmProfileId, 403);

                $query->whereHas('campaign', function ($q) use ($umkmProfileId) {
                    $q->where('umkm_profile_id', $umkmProfileId);
                });
            }
        }

        $responses = $query->get();

        $ilpResults = $this->surveyService->calculateILP($responses->toArray());
        $loyalitasDetails = $this->surveyService->calculateLoyalitasDetails($responses->toArray());

        $ilpPercentage = $ilpResults['ilp_percentage'] ?? 0;
        $ilpInterpretation = $ilpResults['ilp_interpretation'] ?? '';

        if ($type === 'produk') {
            $questions = app(\App\Services\ProdukSurveyQuestionService::class)->getProdukQuestions();
        } else {
            $questions = app(\App\Services\SurveyQuestionService::class)->getPelatihanQuestions();
        }

        return view('grafik.loyalitas', compact(
            'ilpPercentage',
            'ilpInterpretation',
            'responses',
            'questions',
            'type',
            'campaign'
        ) + $loyalitasDetails);
    }
    public function dashboardPelatihan()
    {
        // Ambil data statistik dasar untuk dashboard
        $query = PelatihanSurveyResponse::where('status', 'completed');

        if (!$this->isSuperAdmin()) {
            $umkmProfileId = $this->currentUmkmProfileId();
            abort_if(!$umkmProfileId, 403);

            $query->whereHas('campaign', function ($q) use ($umkmProfileId) {
                $q->where('umkm_profile_id', $umkmProfileId);
            });
        }

        $totalResponses = $query->count();

        // Hitung statistik dasar menggunakan service
        $responses = $query->get();
        if ($responses->count() > 0) {
            $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
            $ilpResults = $this->surveyService->calculateILP($responses->toArray());
            $ikpPercentage = $ikpResults['ikp_percentage'] ?? 0;
            $ilpPercentage = $ilpResults['ilp_percentage'] ?? 0;
        } else {
            $ikpPercentage = 0;
            $ilpPercentage = 0;
        }

        return view('dashboard.pelatihan', compact('totalResponses', 'ikpPercentage', 'ilpPercentage'));
    }

    public function dashboardProduk()
    {
        // Ambil data statistik dasar untuk dashboard
        $query = ProdukSurveyResponse::where('status', 'completed');

        if (!$this->isSuperAdmin()) {
            $umkmProfileId = $this->currentUmkmProfileId();
            abort_if(!$umkmProfileId, 403);

            $query->whereHas('campaign', function ($q) use ($umkmProfileId) {
                $q->where('umkm_profile_id', $umkmProfileId);
            });
        }

        $totalResponses = $query->count();

        // Hitung statistik dasar menggunakan service
        $responses = $query->get();
        if ($responses->count() > 0) {
            $ikpResults = $this->surveyService->calculateIKP($responses->toArray());
            $ilpResults = $this->surveyService->calculateILP($responses->toArray());
            $ikpPercentage = $ikpResults['ikp_percentage'] ?? 0;
            $ilpPercentage = $ilpResults['ilp_percentage'] ?? 0;
        } else {
            $ikpPercentage = 0;
            $ilpPercentage = 0;
        }

        return view('dashboard.produk', compact('totalResponses', 'ikpPercentage', 'ilpPercentage'));
    }
}
