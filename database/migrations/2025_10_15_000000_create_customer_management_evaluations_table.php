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
        Schema::create('customer_management_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->json('maturity_data')->nullable(); // JSON untuk menyimpan skor maturity assessment (8 pertanyaan)
            $table->json('priority_data')->nullable(); // JSON untuk menyimpan nilai prioritas (11 item)
            $table->json('readiness_data')->nullable(); // JSON untuk menyimpan skor readiness audit (11 pertanyaan)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_management_evaluations');
    }
};