<?php

namespace App\Services;

use App\Models\SurveyCampaign;
use Illuminate\Support\Str;

class SurveyCampaignService
{
    /**
     * Generate unique slug from name
     */
    public function generateSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (SurveyCampaign::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Check and close expired campaigns
     */
    public function checkAndCloseExpired(): int
    {
        return SurveyCampaign::active()
            ->where('end_date', '<', now())
            ->update(['status' => 'closed']);
    }

    /**
     * Get campaign statistics for UMKM profile
     * If null is passed, aggregate across all campaigns (for superadmin)
     */
    public function getCampaignStats(?int $umkmProfileId): array
    {
        if ($umkmProfileId === null) {
            $campaignsQuery = SurveyCampaign::query();
        } else {
            $campaignsQuery = SurveyCampaign::byUmkm($umkmProfileId);
        }

        $campaigns = $campaignsQuery->get();

        return [
            'total' => $campaigns->count(),
            'active' => $campaigns->where('status', 'active')->count(),
            'closed' => $campaigns->where('status', 'closed')->count(),
            'draft' => $campaigns->where('status', 'draft')->count(),
            'total_responses' => $campaigns->sum(function($campaign) {
                return $campaign->responses_count;
            }),
        ];
    }

    /**
     * Duplicate campaign
     */
    public function duplicateCampaign(SurveyCampaign $campaign): SurveyCampaign
    {
        $newCampaign = $campaign->replicate();
        $newCampaign->name = $campaign->name . ' (Copy)';
        $newCampaign->slug = $this->generateSlug($newCampaign->name);
        $newCampaign->status = 'draft';
        $newCampaign->save();
        
        return $newCampaign;
    }

    /**
     * Activate campaign
     */
    public function activateCampaign(SurveyCampaign $campaign): bool
    {
        // Validasi: campaign harus draft atau closed
        if (!in_array($campaign->status, ['draft', 'closed'])) {
            return false;
        }
        
        // Validasi: start_date harus sudah lewat atau hari ini
        if ($campaign->start_date->isFuture()) {
            return false;
        }
        
        return $campaign->update(['status' => 'active']);
    }

    /**
     * Close campaign
     */
    public function closeCampaign(SurveyCampaign $campaign): bool
    {
        return $campaign->update(['status' => 'closed']);
    }

    /**
     * Archive campaign
     */
    public function archiveCampaign(SurveyCampaign $campaign): bool
    {
        // Validasi: campaign harus closed
        if ($campaign->status !== 'closed') {
            return false;
        }
        
        return $campaign->update(['status' => 'archived']);
    }

    /**
     * Get closure reason for campaign
     */
    public function getClosureReason(SurveyCampaign $campaign): ?string
    {
        if ($campaign->status !== 'active') {
            if ($campaign->status === 'draft') {
                return 'Survei ini masih dalam status draft dan belum dipublikasikan.';
            }
            if ($campaign->status === 'closed') {
                return 'Survei ini telah ditutup.';
            }
            if ($campaign->status === 'archived') {
                return 'Survei ini telah diarsipkan.';
            }
        }
        
        if (!$campaign->has_started) {
            return 'Survei ini akan dibuka pada: ' . $campaign->start_date->format('d M Y H:i');
        }
        
        if ($campaign->has_ended) {
            return 'Survei ini telah berakhir pada: ' . $campaign->end_date->format('d M Y H:i');
        }
        
        if ($campaign->is_full) {
            return 'Survei ini sudah mencapai batas maksimal responden.';
        }
        
        return null;
    }
}
