<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_campaigns', function (Blueprint $table) {
            if (Schema::hasColumn('survey_campaigns', 'umkm_id')) {
                $table->dropIndex(['umkm_id', 'type']);
                $table->dropForeign(['umkm_id']);
                $table->dropColumn('umkm_id');
            }
        });

        Schema::table('survey_campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('survey_campaigns', 'umkm_profile_id')) {
                $table->foreignId('umkm_profile_id')
                    ->after('id')
                    ->constrained('umkm_profiles')
                    ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('survey_campaigns', function (Blueprint $table) {
            if (Schema::hasColumn('survey_campaigns', 'umkm_profile_id')) {
                $table->dropForeign(['umkm_profile_id']);
                $table->dropColumn('umkm_profile_id');
            }
        });

        Schema::table('survey_campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('survey_campaigns', 'umkm_id')) {
                $table->foreignId('umkm_id')
                    ->after('id')
                    ->constrained('users')
                    ->cascadeOnDelete();
                $table->index(['umkm_id', 'type']);
            }
        });
    }
};
