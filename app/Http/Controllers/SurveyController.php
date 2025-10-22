<?php

namespace App\Http\Controllers;

use App\Models\PelatihanSurveyResponse;
use App\Models\ProdukSurveyResponse;
use App\Services\SurveyQuestionService;
use App\Services\ProdukSurveyQuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SurveyController extends Controller
{
    private const STEPS = [
        'profile' => 1,
        'harapan' => 2,
        'persepsi' => 3,
        'kepuasan' => 4,
        'loyalitas' => 5,
        'feedback' => 6,
    ];

    /**
     * Get the last completed step number for a survey
     */
    private function getLastCompletedStep($survey): int
    {
        $stepFields = [
            1 => 'profile_data',
            2 => 'harapan_answers',
            3 => 'persepsi_answers',
            4 => 'kepuasan_answers',
            5 => 'loyalitas_answers',
            6 => 'feedback_answers',
        ];

        $lastCompletedStep = 0;

        foreach ($stepFields as $stepNumber => $field) {
            if (!empty($survey->$field)) {
                $lastCompletedStep = $stepNumber;
            } else {
                break; // Stop at the first incomplete step
            }
        }

        return $lastCompletedStep;
    }

    /**
     * Landing page survei
     */
    public function index($type = 'pelatihan')
    {
        // Validate type
        if (!in_array($type, ['pelatihan', 'produk'])) {
            abort(404);
        }

        return view('survey.index', compact('type'));
    }

    /**
     * Mulai survei baru
     */
    public function start($type, Request $request = null)
    {
        // Validate type
        if (!in_array($type, ['pelatihan', 'produk'])) {
            abort(404);
        }

        $model = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;

        $sessionToken = $model::generateSessionToken();

        // Buat record baru
        $survey = $model::create([
            'session_token' => $sessionToken,
            'started_at' => now(),
        ]);

        // Simpan session token
        Session::put('survey_token', $sessionToken);

        return redirect()->route('survey.step', ['type' => $type, 'step' => 'profile']);
    }

    /**
     * Tampilkan step tertentu
     */
    public function step($type, $step)
    {
        // Validate type and step
        if (!in_array($type, ['pelatihan', 'produk'])) {
            abort(404);
        }

        if (!array_key_exists($step, self::STEPS)) {
            abort(404);
        }

        $model = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;

        // Get survey from session
        $sessionToken = Session::get('survey_token');
        if (!$sessionToken) {
            return redirect()->route('survey.index', $type)->with('error', 'Sesi survei tidak valid');
        }

        $survey = $model::where('session_token', $sessionToken)->first();
        if (!$survey) {
            return redirect()->route('survey.index', $type)->with('error', 'Data survei tidak ditemukan');
        }

        // Check if step is accessible
        $currentStepNumber = self::STEPS[$step];
        $lastCompletedStep = $this->getLastCompletedStep($survey);

        if ($currentStepNumber > $lastCompletedStep + 1) {
            $lastAccessibleStep = array_search($lastCompletedStep + 1, self::STEPS);
            return redirect()->route('survey.step', ['type' => $type, 'step' => $lastAccessibleStep]);
        }

        // Calculate progress variables for progress bar
        $stepNumber = $currentStepNumber;
        $totalSteps = count(self::STEPS);
        $progress = round(($currentStepNumber / $totalSteps) * 100);

        // Get questions based on survey type
        $questions = $type === 'produk'
            ? (new ProdukSurveyQuestionService())->getProdukQuestions()
            : (new SurveyQuestionService())->getPelatihanQuestions();

        // Navigation variables
        $canGoBack = $currentStepNumber > 1;
        $routePrefix = 'survey.';
        $controllerClass = self::class;

        return view('survey.' . $step, compact('survey', 'step', 'type', 'stepNumber', 'totalSteps', 'progress', 'questions', 'canGoBack', 'routePrefix', 'controllerClass'));
    }

    /**
     * Simpan data step
     */
    public function store(Request $request, $type, $step)
    {
        // Validate type
        if (!in_array($type, ['pelatihan', 'produk'])) {
            abort(404);
        }

        $model = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;

        $sessionToken = Session::get('survey_token');

        if (!$sessionToken) {
            return redirect()->route('survey.index', $type)->with('error', 'Sesi survei tidak valid');
        }

        $survey = $model::where('session_token', $sessionToken)->first();

        if (!$survey) {
            return redirect()->route('survey.index', $type)->with('error', 'Data survei tidak ditemukan');
        }

        // Validasi dan simpan berdasarkan step
        $validatedData = $this->validateStepData($request, $step);

        switch ($step) {
            case 'profile':
                $survey->setProfileData($validatedData);
                break;
            case 'harapan':
                $survey->setAnswers('harapan', $validatedData);
                break;
            case 'persepsi':
                $survey->setAnswers('persepsi', $validatedData);
                break;
            case 'kepuasan':
                $survey->setAnswers('kepuasan', $validatedData);
                break;
            case 'loyalitas':
                $survey->setAnswers('loyalitas', $validatedData);
                break;
            case 'feedback':
                $survey->setAnswers('feedback', $validatedData);
                $survey->markAsCompleted();
                break;
        }

        // Redirect berdasarkan action
        $action = $request->get('action', 'next');

        if ($action === 'back') {
            $prevStep = $this->getPreviousStep($step);
            return redirect()->route('survey.step', ['type' => $type, 'step' => $prevStep]);
        } elseif ($action === 'save') {
            return back()->with('success', 'Data berhasil disimpan');
        } else {
            // Next or complete
            if ($step === 'feedback') {
                return redirect()->route('survey.complete', ['type' => $type]);
            } else {
                $nextStep = $this->getNextStep($step);
                return redirect()->route('survey.step', ['type' => $type, 'step' => $nextStep])->with('success', 'Data berhasil disimpan');
            }
        }
    }

    /**
     * Halaman selesai
     */
    public function complete($type = 'pelatihan')
    {
        // Validate type
        if (!in_array($type, ['pelatihan', 'produk'])) {
            abort(404);
        }

        $model = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;

        $sessionToken = Session::get('survey_token');

        if (!$sessionToken) {
            return redirect()->route('survey.index', $type);
        }

        $survey = $model::where('session_token', $sessionToken)->first();

        if (!$survey || !$survey->isCompleted()) {
            return redirect()->route('survey.step', ['type' => $type, 'step' => 'profile']);
        }

        // Clear session
        Session::forget('survey_token');

        return view('survey.complete', compact('survey', 'type'));
    }

    /**
     * Validasi data per step
     */
    private function validateStepData(Request $request, string $step): array
    {
        return match ($step) {
            'profile' => $request->validate([
                'email' => 'required|email',
                'whatsapp' => 'nullable|string|max:20',
                'jenis_kelamin' => 'required|in:L,P',
                'usia' => 'required|integer|min:1|max:120',
                'pekerjaan' => 'required|string',
                'pekerjaan_lain' => 'nullable|string|max:255',
                'domisili' => 'required|string',
            ]),
            'harapan', 'persepsi' => $request->validate([
                'reliability' => 'required|array',
                'reliability.*' => 'required|integer|min:0|max:5',
                'assurance' => 'required|array',
                'assurance.*' => 'required|integer|min:0|max:5',
                'tangible' => 'required|array',
                'tangible.*' => 'required|integer|min:0|max:5',
                'empathy' => 'required|array',
                'empathy.*' => 'required|integer|min:0|max:5',
                'responsiveness' => 'required|array',
                'responsiveness.*' => 'required|integer|min:0|max:5',
                'applicability' => 'required|array',
                'applicability.*' => 'required|integer|min:0|max:5',
            ]),
            'kepuasan' => $request->validate([
                'k1' => 'required|integer|min:1|max:5',
                'k2' => 'required|integer|min:1|max:5',
                'k3' => 'required|integer|min:1|max:5',
            ]),
            'loyalitas' => $request->validate([
                'l1' => 'required|integer|min:1|max:5',
                'l2' => 'required|integer|min:1|max:5',
                'l3' => 'required|integer|min:1|max:5',
            ]),
            'feedback' => $request->validate([
                'kritik_saran' => 'nullable|string|max:1000',
                'tema_judul' => 'nullable|string|max:500',
                'bentuk_pelatihan' => 'nullable|array',
                'bentuk_pelatihan.online' => 'boolean',
                'bentuk_pelatihan.offline' => 'boolean',
                'bentuk_pelatihan.streaming' => 'boolean',
                'bentuk_pelatihan.elearning' => 'boolean',
            ]),
            default => [],
        };
    }

    /**
     * Hitung step yang sudah completed
     */
    private function getCompletedSteps(PelatihanSurveyResponse $survey): int
    {
        $completed = 0;
        $sections = ['profile_data', 'harapan_answers', 'persepsi_answers', 'kepuasan_answers', 'loyalitas_answers', 'feedback_answers'];

        foreach ($sections as $section) {
            if (!empty($survey->{$section})) {
                $completed++;
            }
        }

        return $completed;
    }

    /**
     * Get last accessible step
     */
    private function getLastAccessibleStep(int $completedSteps): string
    {
        $stepKeys = array_keys(self::STEPS);
        return $stepKeys[min($completedSteps, count($stepKeys) - 1)];
    }

    /**
     * Get next step
     */
    public static function getNextStep(string $currentStep): string
    {
        $stepKeys = array_keys(self::STEPS);
        $currentIndex = array_search($currentStep, $stepKeys);

        if ($currentIndex === false || $currentIndex >= count($stepKeys) - 1) {
            return $currentStep;
        }

        return $stepKeys[$currentIndex + 1];
    }

    /**
     * Get previous step
     */
    public static function getPreviousStep(string $currentStep): string
    {
        $stepKeys = array_keys(self::STEPS);
        $currentIndex = array_search($currentStep, $stepKeys);

        if ($currentIndex === false || $currentIndex <= 0) {
            return $currentStep;
        }

        return $stepKeys[$currentIndex - 1];
    }
}
