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
        Schema::table('actions', function (Blueprint $table) {
            $table->longText('riwayat_penyakit_sekarang')->after('keluhan')->nullable();
            $table->string('riwayat_penyakit_dulu')->after('riwayat_penyakit_sekarang')->nullable();
            $table->longText('riwayat_penyakit_lainnya')->after('riwayat_penyakit_dulu')->nullable();
            $table->string('riwayat_penyakit_keluarga')->after('riwayat_penyakit_lainnya')->nullable();
            $table->string('riwayat_penyakit_lainnya_keluarga')->after('riwayat_penyakit_keluarga')->nullable();
            $table->longText('riwayat_pengobatan')->after('riwayat_penyakit_lainnya_keluarga')->nullable();
            $table->longText('riwayat_alergi')->after('riwayat_pengobatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            //
        });
    }
};
