<?php

namespace App\Http\Controllers;

use App\Models\PelatihanSurveyResponse;
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
     * Landing page survei
     */
    public function index()
    {
        return view('survey.index');
    }

    /**
     * Mulai survei baru
     */
    public function start(Request $request)
    {
        $sessionToken = PelatihanSurveyResponse::generateSessionToken();

        // Buat record baru
        $survey = PelatihanSurveyResponse::create([
            'session_token' => $sessionToken,
            'started_at' => now(),
        ]);

        // Simpan session token
        Session::put('survey_token', $sessionToken);

        return redirect()->route('survey.step', ['step' => 'profile']);
    }

    /**
     * Tampilkan step tertentu
     */
    public function step($step)
    {
        $sessionToken = Session::get('survey_token');

        if (!$sessionToken) {
            return redirect()->route('survey.index')->with('error', 'Sesi survei tidak valid');
        }

        $survey = PelatihanSurveyResponse::where('session_token', $sessionToken)->first();

        if (!$survey) {
            return redirect()->route('survey.index')->with('error', 'Data survei tidak ditemukan');
        }

        // Cek apakah step valid
        if (!array_key_exists($step, self::STEPS)) {
            return redirect()->route('survey.step', ['step' => 'profile']);
        }

        // Cek progress - user hanya bisa akses step yang sudah diisi atau step berikutnya
        $currentStepNumber = self::STEPS[$step];
        $completedSteps = $this->getCompletedSteps($survey);

        if ($currentStepNumber > $completedSteps + 1) {
            // Redirect ke step terakhir yang bisa diakses
            $lastAccessibleStep = $this->getLastAccessibleStep($completedSteps);
            return redirect()->route('survey.step', ['step' => $lastAccessibleStep]);
        }

        $viewData = [
            'survey' => $survey,
            'step' => $step,
            'stepNumber' => $currentStepNumber,
            'totalSteps' => count(self::STEPS),
            'canGoBack' => $currentStepNumber > 1,
            'canGoForward' => $currentStepNumber < count(self::STEPS),
            'progress' => $survey->getCompletionPercentage(),
        ];

        return view("survey.{$step}", $viewData);
    }

    /**
     * Simpan data step
     */
    public function store(Request $request, $step)
    {
        $sessionToken = Session::get('survey_token');

        if (!$sessionToken) {
            return redirect()->route('survey.index')->with('error', 'Sesi survei tidak valid');
        }

        $survey = PelatihanSurveyResponse::where('session_token', $sessionToken)->first();

        if (!$survey) {
            return redirect()->route('survey.index')->with('error', 'Data survei tidak ditemukan');
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
            return redirect()->route('survey.step', ['step' => $prevStep]);
        } elseif ($action === 'save') {
            return back()->with('success', 'Data berhasil disimpan');
        } else {
            // Next or complete
            if ($step === 'feedback') {
                return redirect()->route('survey.complete');
            } else {
                $nextStep = $this->getNextStep($step);
                return redirect()->route('survey.step', ['step' => $nextStep])->with('success', 'Data berhasil disimpan');
            }
        }
    }

    /**
     * Halaman selesai
     */
    public function complete()
    {
        $sessionToken = Session::get('survey_token');

        if (!$sessionToken) {
            return redirect()->route('survey.index');
        }

        $survey = PelatihanSurveyResponse::where('session_token', $sessionToken)->first();

        if (!$survey || !$survey->isCompleted()) {
            return redirect()->route('survey.step', ['step' => 'profile']);
        }

        // Clear session
        Session::forget('survey_token');

        return view('survey.complete', compact('survey'));
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
