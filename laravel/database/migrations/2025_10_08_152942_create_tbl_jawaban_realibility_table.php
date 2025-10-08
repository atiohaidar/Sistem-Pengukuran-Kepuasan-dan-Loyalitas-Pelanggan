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
        Schema::create('tbl_jawaban_realibility', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_responden');
            $table->integer('r1')->nullable();
            $table->integer('r2')->nullable();
            $table->integer('r3')->nullable();
            $table->integer('r4')->nullable();
            $table->integer('r5')->nullable();
            $table->integer('r6')->nullable();
            $table->integer('r7')->nullable();
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
        Schema::dropIfExists('tbl_jawaban_realibility');
    }
};
