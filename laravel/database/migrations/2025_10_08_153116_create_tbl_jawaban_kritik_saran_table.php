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
        Schema::create('tbl_jawaban_kritik_saran', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_responden');
            $table->text('no1')->nullable();
            $table->text('no2')->nullable();
            $table->text('no3_online')->nullable();
            $table->text('no3_offlone')->nullable();
            $table->text('no3_streaming')->nullable();
            $table->text('no3_elearning')->nullable();
            $table->timestamps();

            $table->foreign('id_responden')->references('id_responden')->on('tbl_responden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_jawaban_kritik_saran');
    }
};
