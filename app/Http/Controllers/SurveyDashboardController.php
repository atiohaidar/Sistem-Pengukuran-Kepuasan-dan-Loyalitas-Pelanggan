<?php

namespace App\Http\Controllers;

use App\Models\PelatihanSurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyDashboardController extends Controller
{
    /**
     * Display survey responses management dashboard
     */
    public function index(Request $request)
    {
        // Get survey responses with pagination
        $surveyResponses = PelatihanSurveyResponse::with([])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get survey statistics
        $stats = [
            'total_responses' => PelatihanSurveyResponse::count(),
            'completed_responses' => PelatihanSurveyResponse::where('status', 'completed')->count(),
            'draft_responses' => PelatihanSurveyResponse::where('status', 'draft')->count(),
            'unique_sessions' => PelatihanSurveyResponse::distinct('session_token')->count(),
        ];

        return view('dashboard.survey-management', compact('surveyResponses', 'stats'));
    }

    /**
     * Show detailed view of a specific survey response
     */
    public function show($id)
    {
        $surveyResponse = PelatihanSurveyResponse::findOrFail($id);

        // Define question labels for better display
        $questionLabels = app(\App\Services\SurveyQuestionService::class)->getPelatihanQuestions();

        return view('dashboard.survey-detail', compact('surveyResponse', 'questionLabels'));
    }

    /**
     * Delete a survey response
     */
    public function destroy($id)
    {
        $surveyResponse = PelatihanSurveyResponse::findOrFail($id);
        $surveyResponse->delete();

        return redirect()->route('dashboard.survey-management.index')
            ->with('success', 'Data survei berhasil dihapus');
    }

    /**
     * Export survey data to CSV
     */
    public function export(Request $request)
    {
        $filename = 'survey_responses_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID', 'Session Token', 'Email', 'WhatsApp', 'Jenis Kelamin', 'Usia',
                'Pekerjaan', 'Domisili', 'Status', 'Started At', 'Completed At'
            ]);

            // Get all responses
            PelatihanSurveyResponse::chunk(100, function($responses) use ($file) {
                foreach ($responses as $response) {
                    fputcsv($file, [
                        $response->id,
                        $response->session_token,
                        $response->profile_data['email'] ?? '',
                        $response->profile_data['whatsapp'] ?? '',
                        $response->profile_data['jenis_kelamin'] ?? '',
                        $response->profile_data['usia'] ?? '',
                        $response->profile_data['pekerjaan'] ?? '',
                        $response->profile_data['domisili'] ?? '',
                        $response->status,
                        $response->started_at,
                        $response->completed_at,
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}