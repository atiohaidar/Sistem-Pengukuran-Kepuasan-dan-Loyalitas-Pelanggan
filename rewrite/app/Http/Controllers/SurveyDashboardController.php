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
        $questionLabels = $this->getQuestionLabels();

        return view('dashboard.survey-detail', compact('surveyResponse', 'questionLabels'));
    }

    /**
     * Get question labels for display
     */
    private function getQuestionLabels()
    {
        return [
            // Importance questions
            'importance_answers' => [
                'reliability' => [
                    'r1' => 'Materi pelatihan disampaikan dengan jelas dan mudah dipahami',
                    'r2' => 'Materi pelatihan sesuai dengan kebutuhan peserta',
                    'r3' => 'Penyampaian materi pelatihan terstruktur dan sistematis',
                    'r4' => 'Durasi pelatihan sesuai dengan kebutuhan',
                    'r5' => 'Waktu pelatihan tidak terlalu pagi atau terlalu malam',
                    'r6' => 'Fasilitas pendukung pelatihan (proyektor, sound system, dll) berfungsi dengan baik',
                    'r7' => 'Pengajar/instruktur memiliki kompetensi yang memadai',
                ],
                'assurance' => [
                    'a1' => 'Pengajar/instruktur memberikan jaminan bahwa materi yang disampaikan benar dan akurat',
                    'a2' => 'Pengajar/instruktur memberikan kesempatan bertanya dan menjawab',
                    'a3' => 'Pengajar/instruktur memberikan motivasi kepada peserta',
                    'a4' => 'Pengajar/instruktur bersikap ramah dan sopan',
                ],
                'tangible' => [
                    't1' => 'Ruangan pelatihan bersih dan nyaman',
                    't2' => 'Ruangan pelatihan memiliki ventilasi yang baik',
                    't3' => 'Ruangan pelatihan memiliki pencahayaan yang cukup',
                    't4' => 'Kursi dan meja pelatihan dalam kondisi baik',
                    't5' => 'Sarana pendukung pelatihan (flipchart, spidol, dll) tersedia',
                    't6' => 'Makanan dan minuman selama pelatihan sesuai dengan kebutuhan',
                ],
                'empathy' => [
                    'e1' => 'Panitia pelatihan memberikan perhatian khusus kepada peserta yang membutuhkan',
                    'e2' => 'Panitia pelatihan memahami kebutuhan peserta',
                    'e3' => 'Panitia pelatihan memberikan pelayanan yang personal',
                    'e4' => 'Panitia pelatihan memberikan informasi yang jelas tentang pelatihan',
                    'e5' => 'Panitia pelatihan mudah dihubungi untuk konsultasi',
                ],
                'responsiveness' => [
                    'rs1' => 'Panitia pelatihan merespons dengan cepat terhadap pertanyaan peserta',
                    'rs2' => 'Panitia pelatihan memberikan solusi yang tepat terhadap masalah yang dihadapi peserta',
                ],
                'applicability' => [
                    'ap1' => 'Materi pelatihan dapat diterapkan dalam pekerjaan sehari-hari',
                    'ap2' => 'Materi pelatihan memberikan manfaat praktis bagi peserta',
                ],
            ],
            // Performance questions (same as importance for now)
            'performance_answers' => [
                'reliability' => [
                    'r1' => 'Materi pelatihan disampaikan dengan jelas dan mudah dipahami',
                    'r2' => 'Materi pelatihan sesuai dengan kebutuhan peserta',
                    'r3' => 'Penyampaian materi pelatihan terstruktur dan sistematis',
                    'r4' => 'Durasi pelatihan sesuai dengan kebutuhan',
                    'r5' => 'Waktu pelatihan tidak terlalu pagi atau terlalu malam',
                    'r6' => 'Fasilitas pendukung pelatihan (proyektor, sound system, dll) berfungsi dengan baik',
                    'r7' => 'Pengajar/instruktur memiliki kompetensi yang memadai',
                ],
                'assurance' => [
                    'a1' => 'Pengajar/instruktur memberikan jaminan bahwa materi yang disampaikan benar dan akurat',
                    'a2' => 'Pengajar/instruktur memberikan kesempatan bertanya dan menjawab',
                    'a3' => 'Pengajar/instruktur memberikan motivasi kepada peserta',
                    'a4' => 'Pengajar/instruktur bersikap ramah dan sopan',
                ],
                'tangible' => [
                    't1' => 'Ruangan pelatihan bersih dan nyaman',
                    't2' => 'Ruangan pelatihan memiliki ventilasi yang baik',
                    't3' => 'Ruangan pelatihan memiliki pencahayaan yang cukup',
                    't4' => 'Kursi dan meja pelatihan dalam kondisi baik',
                    't5' => 'Sarana pendukung pelatihan (flipchart, spidol, dll) tersedia',
                    't6' => 'Makanan dan minuman selama pelatihan sesuai dengan kebutuhan',
                ],
                'empathy' => [
                    'e1' => 'Panitia pelatihan memberikan perhatian khusus kepada peserta yang membutuhkan',
                    'e2' => 'Panitia pelatihan memahami kebutuhan peserta',
                    'e3' => 'Panitia pelatihan memberikan pelayanan yang personal',
                    'e4' => 'Panitia pelatihan memberikan informasi yang jelas tentang pelatihan',
                    'e5' => 'Panitia pelatihan mudah dihubungi untuk konsultasi',
                ],
                'responsiveness' => [
                    'rs1' => 'Panitia pelatihan merespons dengan cepat terhadap pertanyaan peserta',
                    'rs2' => 'Panitia pelatihan memberikan solusi yang tepat terhadap masalah yang dihadapi peserta',
                ],
                'applicability' => [
                    'ap1' => 'Materi pelatihan dapat diterapkan dalam pekerjaan sehari-hari',
                    'ap2' => 'Materi pelatihan memberikan manfaat praktis bagi peserta',
                ],
            ],
            // Satisfaction questions
            'satisfaction_answers' => [
                'k1' => 'Secara keseluruhan, bagaimana tingkat kepuasan Anda terhadap pelatihan ini?',
                'k2' => 'Seberapa besar manfaat yang Anda peroleh dari pelatihan ini?',
                'k3' => 'Apakah Anda akan merekomendasikan pelatihan ini kepada orang lain?',
            ],
            // Loyalty questions
            'loyalty_answers' => [
                'l1' => 'Apakah Anda akan mengikuti pelatihan serupa di masa depan?',
                'l2' => 'Apakah Anda akan menggunakan jasa pelatihan dari institusi ini lagi?',
                'l3' => 'Apakah Anda akan merekomendasikan institusi ini kepada orang lain?',
            ],
        ];
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