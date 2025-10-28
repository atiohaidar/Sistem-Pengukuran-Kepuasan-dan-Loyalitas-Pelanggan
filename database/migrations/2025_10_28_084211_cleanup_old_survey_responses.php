<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus semua response lama yang tidak ada campaign_id
        DB::table('produk_survey_responses')
            ->whereNull('survey_campaign_id')
            ->delete();
            
        DB::table('pelatihan_survey_responses')
            ->whereNull('survey_campaign_id')
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak ada rollback untuk data yang sudah dihapus
    }
};
