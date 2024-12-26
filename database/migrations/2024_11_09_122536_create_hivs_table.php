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
        Schema::create('hiv', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('alamat');
            $table->boolean('tes_hiv')->default(false);
            $table->date('tanggal_tes_terakhir')->nullable();
            $table->boolean('penurunan_berat')->default(false);
            $table->boolean('jumlah_berat_badan_turun')->default(false);
            $table->boolean('penyakit_kulit')->default(false);
            $table->boolean('gejala_ispa')->default(false);
            $table->boolean('gejala_sariawan')->default(false);
            $table->boolean('riwayat_sesak')->default(false);
            $table->boolean('riwayat_hepatitis')->default(false);
            $table->boolean('riwayat_seks_bebas')->default(false);
            $table->boolean('riwayat_narkoba')->default(false);
            $table->boolean('riwayat_penyakit_menular')->default(false);
            $table->integer('klaster');
            $table->string('poli');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiv');
    }
};
