<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_spp_evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('session_token')->unique();
            
            // Maturity Assessment Data (8 questions)
            $table->tinyInteger('maturity_visi')->default(1);
            $table->tinyInteger('maturity_strategi')->default(1);
            $table->tinyInteger('maturity_pengalaman_konsumen')->default(1);
            $table->tinyInteger('maturity_kolaborasi_organisasi')->default(1);
            $table->tinyInteger('maturity_proses')->default(1);
            $table->tinyInteger('maturity_informasi')->default(1);
            $table->tinyInteger('maturity_teknologi')->default(1);
            $table->tinyInteger('maturity_matriks')->default(1);
            $table->decimal('maturity_score', 5, 2)->nullable(); // Calculated score
            $table->tinyInteger('maturity_level')->nullable(); // 1-5
            
            // Priority Assessment Data (11 items, total must be 100)
            $table->tinyInteger('priority_kepemimpinan_strategis')->default(0);
            $table->tinyInteger('priority_posisi_kompetitif')->default(0);
            $table->tinyInteger('priority_kepuasan_pelanggan')->default(0);
            $table->tinyInteger('priority_nilai_umur_pelanggan')->default(0);
            $table->tinyInteger('priority_efisiensi_biaya')->default(0);
            $table->tinyInteger('priority_akses_pelanggan')->default(0);
            $table->tinyInteger('priority_solusi_aplikasi_pelanggan')->default(0);
            $table->tinyInteger('priority_informasi_pelanggan')->default(0);
            $table->tinyInteger('priority_proses_pelanggan')->default(0);
            $table->tinyInteger('priority_standar_sdm')->default(0);
            $table->tinyInteger('priority_pelaporan_kinerja')->default(0);
            
            // Readiness Audit Data (11 questions)
            $table->tinyInteger('readiness_q1')->default(3); // Kepemimpinan Strategis
            $table->tinyInteger('readiness_q2')->default(3); // Posisi Kompetitif
            $table->tinyInteger('readiness_q3')->default(3); // Kepuasan Pelanggan
            $table->tinyInteger('readiness_q4')->default(3); // Nilai Umur Pelanggan
            $table->tinyInteger('readiness_q5')->default(3); // Efisiensi Biaya
            $table->tinyInteger('readiness_q6')->default(3); // Akses Pelanggan
            $table->tinyInteger('readiness_q7')->default(3); // Solusi Aplikasi Pelanggan
            $table->tinyInteger('readiness_q8')->default(3); // Informasi Pelanggan
            $table->tinyInteger('readiness_q9')->default(3); // Proses Pelanggan
            $table->tinyInteger('readiness_q10')->default(3); // Standar SDM
            $table->tinyInteger('readiness_q11')->default(3); // Pelaporan Kinerja
            
            // Process Group Scores (calculated from readiness & priority)
            $table->decimal('score_strategy_development', 5, 2)->nullable();
            $table->decimal('score_value_creation', 5, 2)->nullable();
            $table->decimal('score_multi_channel_integration', 5, 2)->nullable();
            $table->decimal('score_information_management', 5, 2)->nullable();
            $table->decimal('score_performance_assessment', 5, 2)->nullable();
            
            // Overall Readiness Score
            $table->decimal('readiness_score', 5, 2)->nullable();
            
            // Status
            $table->enum('status', ['draft', 'completed'])->default('completed');
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('company_name');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_spp_evaluations');
    }
}
