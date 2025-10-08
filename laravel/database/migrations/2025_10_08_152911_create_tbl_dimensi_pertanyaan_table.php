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
        Schema::create('tbl_dimensi_pertanyaan', function (Blueprint $table) {
            $table->id('id_pertanyaan');
            $table->unsignedBigInteger('id_dimensi');
            $table->text('pertanyaan');
            $table->string('kode');
            $table->timestamps();

            $table->foreign('id_dimensi')->references('id_dimensi')->on('tbl_dimensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_dimensi_pertanyaan');
    }
};
