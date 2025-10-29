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
        Schema::create('survey_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_profile_id')->constrained('umkm_profiles')->onDelete('cascade');
            $table->enum('type', ['produk', 'pelatihan']);
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('max_respondents')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status', ['draft', 'active', 'closed', 'archived'])->default('draft');
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index(['umkm_profile_id', 'type']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_campaigns');
    }
};
