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
        Schema::table('rfm_customers', function (Blueprint $table) {
            $table->string('custom_id', 100)->nullable()->after('id');
            $table->unique(['custom_id', 'umkm_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rfm_customers', function (Blueprint $table) {
            $table->dropUnique(['custom_id', 'umkm_id']);
            $table->dropColumn('custom_id');
        });
    }
};
