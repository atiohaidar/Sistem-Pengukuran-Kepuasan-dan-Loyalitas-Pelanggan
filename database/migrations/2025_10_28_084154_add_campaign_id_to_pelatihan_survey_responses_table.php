<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pelatihan_survey_responses', function (Blueprint $table) {
            $table->foreignId('survey_campaign_id')->nullable()->after('id')->constrained('survey_campaigns')->onDelete('cascade');
            $table->index('survey_campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatihan_survey_responses', function (Blueprint $table) {
            $table->dropForeign(['survey_campaign_id']);
            $table->dropIndex(['survey_campaign_id']);
            $table->dropColumn('survey_campaign_id');
        });
    }
};
