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
        Schema::table('customer_management_evaluations', function (Blueprint $table) {
            $table->foreignId('umkm_id')->nullable()->after('id')->constrained('umkm_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_management_evaluations', function (Blueprint $table) {
            $table->dropForeignKey(['umkm_id']);
            $table->dropColumn('umkm_id');
        });
    }
};
