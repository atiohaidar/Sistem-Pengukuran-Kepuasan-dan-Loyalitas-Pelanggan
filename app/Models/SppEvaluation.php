<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SppEvaluation extends Model
{
    protected $table = 'tbl_spp_evaluations';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'company_name',
        'session_token',
        // Maturity
        'maturity_visi',
        'maturity_strategi',
        'maturity_pengalaman_konsumen',
        'maturity_kolaborasi_organisasi',
        'maturity_proses',
        'maturity_informasi',
        'maturity_teknologi',
        'maturity_matriks',
        'maturity_score',
        'maturity_level',
        // Priority
        'priority_kepemimpinan_strategis',
        'priority_posisi_kompetitif',
        'priority_kepuasan_pelanggan',
        'priority_nilai_umur_pelanggan',
        'priority_efisiensi_biaya',
        'priority_akses_pelanggan',
        'priority_solusi_aplikasi_pelanggan',
        'priority_informasi_pelanggan',
        'priority_proses_pelanggan',
        'priority_standar_sdm',
        'priority_pelaporan_kinerja',
        // Readiness
        'readiness_q1',
        'readiness_q2',
        'readiness_q3',
        'readiness_q4',
        'readiness_q5',
        'readiness_q6',
        'readiness_q7',
        'readiness_q8',
        'readiness_q9',
        'readiness_q10',
        'readiness_q11',
        // Calculated scores
        'score_strategy_development',
        'score_value_creation',
        'score_multi_channel_integration',
        'score_information_management',
        'score_performance_assessment',
        'readiness_score',
        // Status
        'status',
        'completed_at',
    ];
    
    protected $dates = [
        'completed_at',
        'created_at',
        'updated_at',
    ];
    
    /**
     * Calculate maturity score (average of 8 questions)
     */
    public function calculateMaturityScore()
    {
        $questions = [
            $this->maturity_visi,
            $this->maturity_strategi,
            $this->maturity_pengalaman_konsumen,
            $this->maturity_kolaborasi_organisasi,
            $this->maturity_proses,
            $this->maturity_informasi,
            $this->maturity_teknologi,
            $this->maturity_matriks,
        ];
        
        $average = array_sum($questions) / count($questions);
        $this->maturity_score = round($average, 2);
        $this->maturity_level = (int) round($average);
        
        return $this->maturity_score;
    }
    
    /**
     * Calculate process group scores based on readiness and priority
     */
    public function calculateProcessGroupScores()
    {
        // Strategy Development: q1, q2
        $this->score_strategy_development = $this->calculateGroupScore(
            [$this->readiness_q1, $this->readiness_q2],
            [$this->priority_kepemimpinan_strategis, $this->priority_posisi_kompetitif]
        );
        
        // Value Creation: q3, q4
        $this->score_value_creation = $this->calculateGroupScore(
            [$this->readiness_q3, $this->readiness_q4],
            [$this->priority_kepuasan_pelanggan, $this->priority_nilai_umur_pelanggan]
        );
        
        // Multi-channel Integration: q6
        $this->score_multi_channel_integration = $this->calculateGroupScore(
            [$this->readiness_q6],
            [$this->priority_akses_pelanggan]
        );
        
        // Information Management: q7, q8
        $this->score_information_management = $this->calculateGroupScore(
            [$this->readiness_q7, $this->readiness_q8],
            [$this->priority_solusi_aplikasi_pelanggan, $this->priority_informasi_pelanggan]
        );
        
        // Performance Assessment: q5, q9, q10, q11
        $this->score_performance_assessment = $this->calculateGroupScore(
            [$this->readiness_q5, $this->readiness_q9, $this->readiness_q10, $this->readiness_q11],
            [$this->priority_efisiensi_biaya, $this->priority_proses_pelanggan, $this->priority_standar_sdm, $this->priority_pelaporan_kinerja]
        );
        
        // Overall readiness score (weighted average)
        $this->readiness_score = (
            $this->score_strategy_development +
            $this->score_value_creation +
            $this->score_multi_channel_integration +
            $this->score_information_management +
            $this->score_performance_assessment
        ) / 5;
        
        return $this->readiness_score;
    }
    
    /**
     * Calculate group score: (readiness * priority) / total_priority
     */
    private function calculateGroupScore($readiness_values, $priority_values)
    {
        $total_priority = array_sum($priority_values);
        if ($total_priority == 0) {
            return 0;
        }
        
        $weighted_sum = 0;
        for ($i = 0; $i < count($readiness_values); $i++) {
            $weighted_sum += ($readiness_values[$i] * $priority_values[$i]);
        }
        
        return round(($weighted_sum / $total_priority), 2);
    }
    
    /**
     * Get maturity level description
     */
    public function getMaturityLevelDescription()
    {
        $descriptions = [
            1 => 'Pre-Perancanan Sistem pengelolaan pelanggan',
            2 => 'Membangun repositori data',
            3 => 'Sistem pengelolaan pelanggan berkembang secara moderat',
            4 => 'Sistem pengelolaan pelanggan berkembang dengan baik',
            5 => 'Sistem pengelolaan pelanggan sangat maju',
        ];
        
        return $descriptions[$this->maturity_level] ?? 'Unknown';
    }
    
    /**
     * Get priority recommendation for lowest scoring process group
     */
    public function getLowestProcessGroup()
    {
        $groups = [
            'Strategy development' => $this->score_strategy_development,
            'Value creation' => $this->score_value_creation,
            'Multi-channel integration' => $this->score_multi_channel_integration,
            'Information management' => $this->score_information_management,
            'Performance assessment' => $this->score_performance_assessment,
        ];
        
        asort($groups);
        return array_key_first($groups);
    }
}
