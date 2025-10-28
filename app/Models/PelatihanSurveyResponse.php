<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PelatihanSurveyResponse extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_survey_responses';

    protected $fillable = [
        'survey_campaign_id',
        'session_token',
        'survey_type',
        'profile_data',
        'harapan_answers',
        'persepsi_answers',
        'kepuasan_answers',
        'loyalitas_answers',
        'feedback_answers',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'profile_data' => 'array',
        'harapan_answers' => 'array',
        'persepsi_answers' => 'array',
        'kepuasan_answers' => 'array',
        'loyalitas_answers' => 'array',
        'feedback_answers' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relationship ke SurveyCampaign
     */
    public function campaign()
    {
        return $this->belongsTo(SurveyCampaign::class, 'survey_campaign_id');
    }

    /**
     * Generate unique session token
     */
    public static function generateSessionToken(): string
    {
        do {
            $token = bin2hex(random_bytes(16));
        } while (self::where('session_token', $token)->exists());

        return $token;
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Check if survey is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Mark survey as completed
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Get profile data helper
     */
    public function getProfileData(string $key = null)
    {
        if ($key) {
            return data_get($this->profile_data, $key);
        }
        return $this->profile_data;
    }

    /**
     * Set profile data helper
     */
    public function setProfileData(array $data): void
    {
        $this->update(['profile_data' => $data]);
    }

    /**
     * Get answers by section
     */
    public function getAnswers(string $section, string $key = null)
    {
        $answers = $this->{$section . '_answers'} ?? [];

        if ($key) {
            return data_get($answers, $key);
        }

        return $answers;
    }

    /**
     * Set answers by section
     */
    public function setAnswers(string $section, array $answers): void
    {
        $this->update([$section . '_answers' => $answers]);
    }

    /**
     * Calculate completion percentage
     */
    public function getCompletionPercentage(): float
    {
        $sections = ['profile_data', 'harapan_answers', 'persepsi_answers', 'kepuasan_answers', 'loyalitas_answers', 'feedback_answers'];
        $completed = 0;

        foreach ($sections as $section) {
            if (!empty($this->{$section})) {
                $completed++;
            }
        }

        return round(($completed / count($sections)) * 100, 1);
    }
}
