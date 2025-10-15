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
        Schema::create('pelatihan_survey_responses', function (Blueprint $table) {
            $table->id();
            $table->string('session_token')->unique(); // untuk tracking tanpa login
            $table->string('survey_type')->default('pelatihan');
            
            // Data Profil (JSON)
            $table->json('profile_data')->nullable();
            
            // Jawaban Pertanyaan 1 (Harapan/Importance) - JSON
            $table->json('importance_answers')->nullable();
            
            // Jawaban Pertanyaan 2 (Persepsi/Performance) - JSON  
            $table->json('performance_answers')->nullable();
            
            // Jawaban Pertanyaan 3 (Kepuasan) - JSON
            $table->json('satisfaction_answers')->nullable();
            
            // Jawaban Pertanyaan 4 (Loyalitas) - JSON
            $table->json('loyalty_answers')->nullable();
            
            // Jawaban Pertanyaan 5 (Kritik & Saran) - JSON
            $table->json('feedback_answers')->nullable();
            
            // Metadata
            $table->enum('status', ['draft', 'completed'])->default('draft');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_survey_responses');
    }
};
