<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role: superadmin, admin_umkm, user, etc.
            $table->string('role')->default('user')->after('password');
            // link ke umkm_profiles jika user adalah admin umkm
            $table->unsignedBigInteger('umkm_id')->nullable()->after('role');
            // approval status untuk akun/umkm (pending/approved/rejected)
            $table->string('status')->default('pending')->after('umkm_id');

            $table->foreign('umkm_id')->references('id')->on('umkm_profiles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['umkm_id']);
            $table->dropColumn(['role', 'umkm_id', 'status']);
        });
    }
};
