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
        Schema::create('tbl_jawaban', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_responden');
            $table->enum('dimensi_type', [
                'realibility',
                'assurance', 
                'tangible',
                'empathy',
                'responsiveness',
                'applicability',
                'lp',
                'kp',
                'relevance',
                'kritik_saran'
            ]);
            $table->string('kategori')->nullable(); // persepsi/harapan
            $table->json('nilai'); // menyimpan semua nilai pertanyaan dalam format JSON
            $table->timestamps();

            $table->foreign('id_responden')->references('id_responden')->on('tbl_responden');
            $table->index(['dimensi_type', 'id_responden']); // untuk performa query
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_jawaban');
    }
};
