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
        Schema::table('actions', function (Blueprint $table) {
            $table->longText('verifikasi_awal')->nullable();
            $table->longText('verifikasi_akhir')->nullable()->after('verifikasi_awal');
            $table->longText('informasi_obat')->nullable()->after('verifikasi_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn(['verifikasi_awal', 'verifikasi_akhir', 'informasi_obat']);
        });
    }
};
