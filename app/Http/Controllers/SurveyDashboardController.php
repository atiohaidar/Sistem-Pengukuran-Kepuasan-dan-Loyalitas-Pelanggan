<?php

namespace App\Http\Controllers;

use App\Models\PelatihanSurveyResponse;
use App\Models\ProdukSurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyDashboardController extends Controller
{
    /**
     * Display survey responses management dashboard
     */
    public function index($type, Request $request = null)
    {
        // Validate type
        if (!in_array($type, ['pelatihan', 'produk'])) {
            abort(404);
        }

        $model = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;

        // Get survey responses with pagination
        $surveyResponses = $model::with([])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get survey statistics
        $stats = [
            'total_responses' => $model::count(),
            'completed_responses' => $model::where('status', 'completed')->count(),
            'draft_responses' => $model::where('status', 'draft')->count(),
            'unique_sessions' => $model::distinct('session_token')->count(),
        ];

        return view('dashboard.survey-management', compact('surveyResponses', 'stats', 'type'));
    }

    /**
     * Show detailed view of a specific survey response
     */
    public function show($type, $id)
    {
        // Validate type
        if (!in_array($type, ['pelatihan', 'produk'])) {
            abort(404);
        }

        $model = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;
        $service = $type === 'produk' ? \App\Services\ProdukSurveyQuestionService::class : \App\Services\SurveyQuestionService::class;

        $surveyResponse = $model::findOrFail($id);

        // Define question labels for better display
        $method = $type === 'produk' ? 'getProdukQuestions' : 'getPelatihanQuestions';
        $questionLabels = app($service)->$method();

        return view('dashboard.survey-detail', compact('surveyResponse', 'questionLabels', 'type'));
    }

    /**
     * Delete a survey response
     */
    public function destroy($type, $id)
    {
        // Validate type
        if (!in_array($type, ['pelatihan', 'produk'])) {
            abort(404);
        }

        $model = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;

        $surveyResponse = $model::findOrFail($id);
        $surveyResponse->delete();

        return redirect()->route('dashboard.survey-management.index', $type)
            ->with('success', 'Data survei berhasil dihapus');
    }

    /**
     * Export survey data to CSV
     */
    public function export(Request $request, $type)
    {
        // Validate type
        if (!in_array($type, ['pelatihan', 'produk'])) {
            abort(404);
        }

        $model = $type === 'produk' ? ProdukSurveyResponse::class : PelatihanSurveyResponse::class;

        $filename = 'survey_responses_' . $type . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($model) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID',
                'Session Token',
                'Email',
                'WhatsApp',
                'Jenis Kelamin',
                'Usia',
                'Pekerjaan',
                'Domisili',
                'Status',
                'Started At',
                'Completed At'
            ]);

            // Get all responses
            $model::chunk(100, function ($responses) use ($file) {
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