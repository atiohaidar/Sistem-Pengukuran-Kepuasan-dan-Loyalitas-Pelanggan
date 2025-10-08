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
        Schema::create('tbl_jawaban_tangible', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_responden');
            $table->integer('t1')->nullable();
            $table->integer('t2')->nullable();
            $table->integer('t3')->nullable();
            $table->integer('t4')->nullable();
            $table->integer('t5')->nullable();
            $table->integer('t6')->nullable();
            $table->string('kategori')->nullable();
            $table->timestamps();

            $table->foreign('id_responden')->references('id_responden')->on('tbl_responden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_jawaban_tangible');
    }
};
