<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\UmkmProfile;
use App\Models\User;
use App\Models\ProdukSurveyResponse;
use App\Models\PelatihanSurveyResponse;

class SurveyCampaign extends Model
{
    protected $fillable = [
        'umkm_profile_id',
        'type',
        'name',
        'slug',
        'description',
        'max_respondents',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'max_respondents' => 'integer',
    ];

    /**
     * Relationship ke profil UMKM.
     */
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_profile_id');
    }

    /**
     * Relationship ke user owner (opsional, berdasarkan profil UMKM).
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'umkm_profile_id', 'umkm_id');
    }

    /**
     * Relationship ke responses (dynamic based on type)
     */
    public function responses(): HasMany
    {
        if ($this->type === 'produk') {
            return $this->hasMany(ProdukSurveyResponse::class, 'survey_campaign_id');
        }
        return $this->hasMany(PelatihanSurveyResponse::class, 'survey_campaign_id');
    }

    /**
     * Scope untuk filter campaign aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk filter by UMKM
     */
    public function scopeByUmkm($query, $umkmProfileId)
    {
        return $query->where('umkm_profile_id', $umkmProfileId);
    }

    /**
     * Scope untuk filter by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope untuk search by name
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        }
        return $query;
    }

    /**
     * Accessor: Get public URL
     */
    public function getPublicUrlAttribute(): string
    {
        return route('public-survey.show', $this->slug);
    }

    /**
     * Accessor: Check if campaign is currently active
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active' 
            && now()->between($this->start_date, $this->end_date);
    }

    /**
     * Accessor: Get total responses count
     */
    public function getResponsesCountAttribute(): int
    {
        return $this->responses()->count();
    }

    /**
     * Accessor: Get progress percentage
     */
    public function getProgressPercentageAttribute(): ?float
    {
        if (!$this->max_respondents) {
            return null;
        }
        return min(100, round(($this->responses_count / $this->max_respondents) * 100, 1));
    }

    /**
     * Accessor: Check if campaign is full
     */
    public function getIsFullAttribute(): bool
    {
        if (!$this->max_respondents) {
            return false;
        }
        return $this->responses_count >= $this->max_respondents;
    }

    /**
     * Accessor: Get days remaining
     */
    public function getDaysRemainingAttribute(): int
    {
        if (now()->gt($this->end_date)) {
            return 0;
        }
        return now()->diffInDays($this->end_date);
    }

    /**
     * Accessor: Check if campaign has started
     */
    public function getHasStartedAttribute(): bool
    {
        return now()->gte($this->start_date);
    }

    /**
     * Accessor: Check if campaign has ended
     */
    public function getHasEndedAttribute(): bool
    {
        return now()->gt($this->end_date);
    }

    /**
     * Method: Check if campaign can accept responses
     */
    public function canAcceptResponses(): bool
    {
        return $this->is_active 
            && !$this->is_full 
            && now()->lte($this->end_date);
    }

    /**
     * Method: Auto close if full
     */
    public function autoCloseIfFull(): void
    {
        if ($this->is_full && $this->status === 'active') {
            $this->update(['status' => 'closed']);
        }
    }

    /**
     * Method: Get status badge color
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            'draft' => 'gray',
            'active' => 'green',
            'closed' => 'red',
            'archived' => 'blue',
            default => 'gray',
        };
    }

    /**
     * Method: Get type badge color
     */
    public function getTypeBadgeColor(): string
    {
        return match($this->type) {
            'produk' => 'purple',
            'pelatihan' => 'indigo',
            default => 'gray',
        };
    }

    /**
     * Method: Get type icon
     */
    public function getTypeIcon(): string
    {
        return match($this->type) {
            'produk' => 'fa-box',
            'pelatihan' => 'fa-graduation-cap',
            default => 'fa-question',
        };
    }
}
