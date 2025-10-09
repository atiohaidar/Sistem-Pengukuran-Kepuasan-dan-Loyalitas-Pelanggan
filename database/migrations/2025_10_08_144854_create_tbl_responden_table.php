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
        Schema::create('tbl_responden', function (Blueprint $table) {
            $table->id('id_responden');
            $table->unsignedBigInteger('id_bisnis');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('jk');
            $table->string('usia');
            $table->string('pekerjaan');
            $table->string('pekerjaan_lain')->nullable();
            $table->string('domisili');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_responden');
    }
};
