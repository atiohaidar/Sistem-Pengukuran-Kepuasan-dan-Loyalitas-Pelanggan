<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jawaban;
use App\Models\Responden;
use Illuminate\Support\Facades\DB;

class JawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all respondents
        $respondents = Responden::all();

        if ($respondents->isEmpty()) {
            $this->command->info('No respondents found. Skipping jawaban creation.');
            return;
        }

        $created = 0;

        foreach ($respondents as $respondent) {
            // Create answers for each dimension type
            $dimensions = [
                'realibility' => [
                    'questions' => ['r1', 'r2', 'r3', 'r4', 'r5', 'r6', 'r7'],
                    'categories' => ['persepsi', 'harapan']
                ],
                'assurance' => [
                    'questions' => ['a1', 'a2', 'a3', 'a4'],
                    'categories' => ['persepsi', 'harapan']
                ],
                'tangible' => [
                    'questions' => ['t1', 't2', 't3', 't4', 't5', 't6'],
                    'categories' => ['persepsi', 'harapan']
                ],
                'responsiveness' => [
                    'questions' => ['rs1', 'rs2'],
                    'categories' => ['persepsi', 'harapan']
                ],
                'empathy' => [
                    'questions' => ['e1', 'e2', 'e3', 'e4', 'e5'],
                    'categories' => ['persepsi', 'harapan']
                ],
                'applicability' => [
                    'questions' => ['ap1', 'ap2', 'ap3'],
                    'categories' => ['persepsi', 'harapan']
                ],
                'kp' => [
                    'questions' => ['k1', 'k2', 'k3'],
                    'categories' => ['persepsi', 'harapan']
                ],
                'lp' => [
                    'questions' => ['l1', 'l2', 'l3'],
                    'categories' => ['persepsi', 'harapan']
                ],
                'relevance' => [
                    'questions' => ['rel1', 'rel2'],
                    'categories' => ['persepsi', 'harapan']
                ],
                'kritik_saran' => [
                    'questions' => ['no1', 'no2', 'no3_online', 'no3_offline', 'no3_streaming', 'no3_elearning'],
                    'categories' => ['persepsi'] // Only persepsi for kritik dan saran
                ]
            ];

            foreach ($dimensions as $dimensionType => $config) {
                foreach ($config['categories'] as $category) {
                    // Generate realistic survey answers (1-5 scale, or 0-1 for checkboxes)
                    $answers = [];
                    foreach ($config['questions'] as $question) {
                        // Handle checkbox questions (no3_*)
                        if (str_starts_with($question, 'no3_')) {
                            $answers[$question] = rand(0, 1); // Checkbox: 0 or 1
                        } elseif ($dimensionType === 'kritik_saran' && in_array($question, ['no1', 'no2'])) {
                            // Text areas for kritik_saran - generate sample text
                            $sampleTexts = [
                                'no1' => [
                                    'Pelatihan sangat membantu, namun perlu lebih banyak contoh praktis.',
                                    'Materi bagus, tapi durasi terlalu singkat.',
                                    'Trainer sangat kompeten dan materi relevan dengan pekerjaan.',
                                    'Perlu lebih banyak sesi praktikum.',
                                    'Sarana dan prasarana pelatihan sudah baik.'
                                ],
                                'no2' => [
                                    'Digital Marketing untuk UMKM',
                                    'Manajemen Proyek dengan Agile',
                                    'Pengembangan Soft Skills',
                                    'Teknologi Cloud Computing',
                                    'Data Analytics untuk Bisnis'
                                ]
                            ];
                            $answers[$question] = $sampleTexts[$question][array_rand($sampleTexts[$question])];
                        } else {
                            // Regular 1-5 scale questions
                            if ($category === 'persepsi') {
                                $answers[$question] = rand(2, 4); // More conservative scores
                            } else {
                                $answers[$question] = rand(3, 5); // Higher expectations
                            }
                        }
                    }

                    // Check if answer already exists
                    $existing = DB::table('tbl_jawaban')
                        ->where('id_responden', $respondent->id_responden)
                        ->where('dimensi_type', $dimensionType)
                        ->where('kategori', $category)
                        ->first();

                    if ($existing) {
                        // Update existing record to add missing questions
                        $currentNilai = json_decode($existing->nilai, true) ?? [];
                        $updatedNilai = array_merge($currentNilai, array_diff_key($answers, $currentNilai));
                        
                        DB::table('tbl_jawaban')
                            ->where('id_jawaban', $existing->id_jawaban)
                            ->update(['nilai' => json_encode($updatedNilai)]);
                    } else {
                        // Create new record
                        Jawaban::create([
                            'id_responden' => $respondent->id_responden,
                            'dimensi_type' => $dimensionType,
                            'kategori' => $category,
                            'nilai' => $answers
                        ]);
                        $created++;
                    }
                }
            }
        }

        $this->command->info("Sample jawaban data created: {$created} records");
    }
}